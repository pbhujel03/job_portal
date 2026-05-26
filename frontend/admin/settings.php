<?php
require_once '../../backend/config/db.php';
require_once '../../backend/helpers/settings.php';
session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../public/login.php');
    exit;
}

$admin_user = null;
$is_system_admin = ($_SESSION['user_id'] == 0);

if ($is_system_admin) {
    $admin_user = [
        'user_id' => 0,
        'full_name' => $_SESSION['name'] ?? 'System Administrator',
        'email' => 'admin@jobportal.com',
        'phone' => '',
        'profile_image' => null,
        'role' => 'admin',
    ];
} else {
    $stmt = $conn->prepare('SELECT * FROM users WHERE user_id = ? AND role = ?');
    $role = 'admin';
    $uid = (int) $_SESSION['user_id'];
    $stmt->bind_param('is', $uid, $role);
    $stmt->execute();
    $admin_user = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

$success_message = '';
$error_message = '';
$active_tab = $_GET['tab'] ?? 'general';
$uid = (int) $_SESSION['user_id'];
$settings = get_settings($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'save_settings') {
    $active_tab = $_POST['active_tab'] ?? 'general';

    if ($active_tab === 'general') {
        save_settings_bulk($conn, [
            'system_name' => trim($_POST['system_name'] ?? 'Job Portal'),
            'language' => $_POST['language'] ?? 'en-US',
            'timezone' => $_POST['timezone'] ?? 'Asia/Kathmandu',
        ]);

        if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $mime = mime_content_type($_FILES['logo']['tmp_name']);
            if (in_array($mime, $allowed, true) && $_FILES['logo']['size'] <= 2 * 1024 * 1024) {
                $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION) ?: 'png';
                $ext = preg_replace('/[^a-zA-Z0-9]/', '', $ext);
                $upload_dir = dirname(__DIR__) . '/assets/uploads/branding/';
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0755, true);
                }
                $filename = 'logo.' . strtolower($ext);
                $target = $upload_dir . $filename;
                if (move_uploaded_file($_FILES['logo']['tmp_name'], $target)) {
                    save_setting($conn, 'logo_path', 'assets/uploads/branding/' . $filename);
                }
            } else {
                $error_message = 'Logo must be JPG, PNG, GIF, or WebP and under 2MB.';
            }
        }

        if ($error_message === '') {
            $success_message = 'General settings saved successfully.';
        }
    } elseif ($active_tab === 'account') {
        $full_name = trim($_POST['full_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        if ($full_name === '') {
            $error_message = 'Full name is required.';
        } elseif (!$is_system_admin && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error_message = 'Please enter a valid email address.';
        } elseif ($new_password !== '' && strlen($new_password) < 6) {
            $error_message = 'Password must be at least 6 characters.';
        } elseif ($new_password !== '' && $new_password !== $confirm_password) {
            $error_message = 'Passwords do not match.';
        } else {
            if ($is_system_admin) {
                $_SESSION['name'] = $full_name;
                $admin_user['full_name'] = $full_name;
                $success_message = 'Display name updated for this session.';
            } else {
                $check = $conn->prepare('SELECT user_id FROM users WHERE email = ? AND user_id != ?');
                $check->bind_param('si', $email, $uid);
                $check->execute();
                if ($check->get_result()->num_rows > 0) {
                    $error_message = 'That email is already in use.';
                } else {
                    if ($new_password !== '') {
                        $hash = password_hash($new_password, PASSWORD_DEFAULT);
                        $stmt = $conn->prepare('UPDATE users SET full_name = ?, email = ?, phone = ?, password = ? WHERE user_id = ?');
                        $stmt->bind_param('ssssi', $full_name, $email, $phone, $hash, $uid);
                    } else {
                        $stmt = $conn->prepare('UPDATE users SET full_name = ?, email = ?, phone = ? WHERE user_id = ?');
                        $stmt->bind_param('sssi', $full_name, $email, $phone, $uid);
                    }
                    $stmt->execute();
                    $stmt->close();
                    $_SESSION['name'] = $full_name;
                    $success_message = 'Account profile updated successfully.';
                }
                $check->close();
            }

            if ($error_message === '' && !$is_system_admin && isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $mime = mime_content_type($_FILES['profile_image']['tmp_name']);
                if (in_array($mime, $allowed, true) && $_FILES['profile_image']['size'] <= 2 * 1024 * 1024) {
                    $ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION) ?: 'jpg';
                    $ext = preg_replace('/[^a-zA-Z0-9]/', '', $ext);
                    $upload_dir = dirname(__DIR__) . '/assets/uploads/profile_photos/';
                    if (!is_dir($upload_dir)) {
                        mkdir($upload_dir, 0755, true);
                    }
                    $filename = $uid . '_' . time() . '.' . strtolower($ext);
                    if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $upload_dir . $filename)) {
                        $path = 'assets/uploads/profile_photos/' . $filename;
                        $stmt = $conn->prepare('UPDATE users SET profile_image = ? WHERE user_id = ?');
                        $stmt->bind_param('si', $path, $uid);
                        $stmt->execute();
                        $stmt->close();
                        $admin_user['profile_image'] = $path;
                    }
                }
            }
        }
    } elseif ($active_tab === 'security') {
        save_setting($conn, 'two_factor_enabled', isset($_POST['two_factor_enabled']) ? '1' : '0');
        $success_message = 'Security settings saved successfully.';
    } elseif ($active_tab === 'notifications') {
        save_setting($conn, 'email_notifications', isset($_POST['email_notifications']) ? '1' : '0');
        $success_message = 'Notification preferences saved successfully.';
    }

    $settings = get_settings($conn);

    if (!$is_system_admin && $success_message !== '' && $error_message === '') {
        $stmt = $conn->prepare('SELECT * FROM users WHERE user_id = ? AND role = ?');
        $stmt->bind_param('is', $uid, $role);
        $stmt->execute();
        $admin_user = $stmt->get_result()->fetch_assoc();
        $stmt->close();
    }
}

$logo_src = '../' . ltrim($settings['logo_path'], '/');
$profile_src = !empty($admin_user['profile_image'])
    ? '../' . ltrim($admin_user['profile_image'], '/')
    : 'https://ui-avatars.com/api/?name=' . urlencode($admin_user['full_name']) . '&background=4f46e5&color=fff&size=128';

$timezones = [
    'Asia/Kathmandu' => '(GMT+05:45) Kathmandu',
    'UTC' => '(GMT+00:00) UTC',
    'America/Los_Angeles' => '(GMT-08:00) Pacific Time',
    'America/New_York' => '(GMT-05:00) Eastern Time',
    'Europe/London' => '(GMT+00:00) London',
    'Europe/Paris' => '(GMT+01:00) Paris',
];

?>

<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Settings | Job Portal Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin-sidebar-brand.css">

    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .active-tab {
            background-color: rgba(79, 70, 229, 0.1);
            color: #4f46e5;
            border-right: 4px solid #4f46e5;
        }

        /* Custom Scrollbar for modern look */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #cbd5e1;
        }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-fixed": "#e2dfff",
                        "on-secondary-fixed-variant": "#3f465c",
                        "secondary-fixed": "#dae2fd",
                        "inverse-primary": "#c3c0ff",
                        "primary-fixed-dim": "#c3c0ff",
                        "on-error": "#ffffff",
                        "on-secondary-container": "#5c647a",
                        "on-primary-fixed": "#0f0069",
                        "secondary-container": "#dae2fd",
                        "on-primary": "#ffffff",
                        "surface-bright": "#f8f9ff",
                        "on-tertiary-fixed": "#351000",
                        "on-surface-variant": "#464555",
                        "surface-container": "#e5eeff",
                        "surface": "#f8f9ff",
                        "on-error-container": "#93000a",
                        "tertiary": "#7e3000",
                        "secondary": "#565e74",
                        "on-tertiary-container": "#ffd2be",
                        "error": "#ba1a1a",
                        "primary-container": "#4f46e5",
                        "inverse-on-surface": "#eaf1ff",
                        "on-primary-container": "#dad7ff",
                        "surface-tint": "#4d44e3",
                        "surface-container-high": "#dce9ff",
                        "surface-variant": "#d3e4fe",
                        "on-tertiary-fixed-variant": "#7b2f00",
                        "on-primary-fixed-variant": "#3323cc",
                        "surface-dim": "#cbdbf5",
                        "secondary-fixed-dim": "#bec6e0",
                        "on-secondary": "#ffffff",
                        "background": "#f8f9ff",
                        "tertiary-fixed-dim": "#ffb695",
                        "on-background": "#0b1c30",
                        "on-secondary-fixed": "#131b2e",
                        "surface-container-lowest": "#ffffff",
                        "outline": "#777587",
                        "error-container": "#ffdad6",
                        "on-tertiary": "#ffffff",
                        "primary": "#4f46e5",
                        "tertiary-fixed": "#ffdbcc",
                        "inverse-surface": "#213145",
                        "surface-container-low": "#eff4ff",
                        "outline-variant": "#c7c4d8",
                        "surface-container-highest": "#d3e4fe",
                        "tertiary-container": "#a44100",
                        "on-surface": "#0b1c30"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "xs": "4px",
                        "margin-mobile": "16px",
                        "sm": "8px",
                        "margin-desktop": "40px",
                        "lg": "24px",
                        "xl": "32px",
                        "md": "16px",
                        "gutter": "24px",
                        "base": "8px"
                    },
                    "fontFamily": {
                        "headline-lg": ["Inter"],
                        "display": ["Inter"],
                        "label-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "title-md": ["Inter"],
                        "body-md": ["Inter"]
                    },
                    "fontSize": {
                        "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "display": ["56px", { "lineHeight": "64px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "title-md": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }]
                    }
                },
            },
        }
    </script>
</head>

<body class="bg-surface text-on-surface overflow-hidden h-screen flex flex-col">
    <!-- Sidebar Navigation Shell -->
    <aside class="fixed h-full left-0 top-0 w-64 bg-on-secondary-fixed dark:bg-inverse-surface flex flex-col py-lg px-md z-50">
        <a href="dashboard.php" class="admin-sidebar-brand">
            <img src="../assets/images/Job1.png" alt="" class="admin-sidebar-brand__icon">
            <div class="admin-sidebar-brand__text">
                <span class="admin-sidebar-brand__job">Job</span>
                <span class="admin-sidebar-brand__portal">Portal</span>
            </div>
        </a>



        <nav class="flex-1 space-y-xs overflow-y-auto custom-scrollbar">
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="dashboard.php">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span class="font-body-md text-body-md">Dashboard</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="manage_users.php">
                <span class="material-symbols-outlined" data-icon="group">group</span>
                <span class="font-body-md text-body-md">User Management</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="manage_jobs.php">
                <span class="material-symbols-outlined" data-icon="work">work</span>
                <span class="font-body-md text-body-md">Job Management</span>
            </a>
            <a class="flex items-center gap-md bg-primary-container text-on-primary-container rounded-lg px-md py-base transition-transform active:scale-95"
                href="settings.php">
                <span class="material-symbols-outlined" data-icon="settings">settings</span>
                <span class="font-body-md text-body-md">Settings</span>
            </a>
        </nav>
    </aside>
    <!-- Top App Bar -->
    <header
        class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-surface border-b border-outline-variant flex justify-between items-center px-margin-desktop z-40">
        <div></div>
        <div class="flex items-center space-x-6">
            <button
                class="p-2 text-on-surface-variant hover:bg-surface-container-low transition-colors rounded-full relative">
                <span class="material-symbols-outlined">help_outline</span>
            </button>
            <div class="h-8 w-[1px] bg-outline-variant/30 mx-2"></div>
            <div class="flex items-center gap-sm">
                <div class="w-10 h-10 rounded-full border-2 border-primary-container bg-primary-fixed flex items-center justify-center text-on-primary-fixed font-bold">
                    <?php echo strtoupper(substr($admin_user['full_name'], 0, 1)); ?>
                </div>
                <div class="hidden lg:block text-left">
                    <p class="font-body-md text-body-md font-bold text-on-surface"><?php echo htmlspecialchars($admin_user['full_name']); ?></p>
                    <p class="font-label-md text-label-md text-on-surface-variant">System Admin</p>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content Area -->
    <main class="ml-64 flex-1 pt-16 bg-surface relative overflow-hidden flex flex-col">
        <div class="flex-1 overflow-y-auto pb-32">
            <div class="max-w-[1600px] mx-auto p-margin-desktop">
            <header class="mb-xl">
                <h2 class="font-headline-lg text-headline-lg text-on-surface">System Settings</h2>
                <p class="text-on-surface-variant font-body-md text-body-md">Manage your organization's configurations,
                    AI models, and security protocols.</p>
            </header>

            <?php if ($success_message): ?>
                <div class="mb-lg px-4 py-3 rounded-lg bg-green-50 border border-green-200 text-green-800 font-body-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-green-600">check_circle</span>
                    <?php echo htmlspecialchars($success_message); ?>
                </div>
            <?php endif; ?>
            <?php if ($error_message): ?>
                <div class="mb-lg px-4 py-3 rounded-lg bg-error-container border border-error/30 text-on-background font-body-md flex items-center gap-2">
                    <span class="material-symbols-outlined text-error">error</span>
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data" id="settings-form" class="flex gap-gutter items-start w-full">
                <input type="hidden" name="action" value="save_settings">
                <input type="hidden" name="active_tab" id="active_tab" value="<?php echo htmlspecialchars($active_tab); ?>">
                <!-- Vertical Settings Navigation -->
                <nav class="flex-1 space-y-2">
                    <button type="button"
                        class="nav-btn w-full flex items-center px-4 py-3 rounded-lg text-on-surface-variant hover:bg-surface-container transition-all active-tab"
                        id="tab-general" onclick="switchTab('general')">
                        <span class="material-symbols-outlined mr-3">settings_applications</span>
                        <span class="font-body-md text-body-md font-medium">General Settings</span>
                    </button>
                    <button type="button"
                        class="nav-btn w-full flex items-center px-4 py-3 rounded-lg text-on-surface-variant hover:bg-surface-container transition-all"
                        id="tab-account" onclick="switchTab('account')">
                        <span class="material-symbols-outlined mr-3">account_circle</span>
                        <span class="font-body-md text-body-md font-medium">Account &amp; Profile</span>
                    </button>
                    <button type="button"
                        class="nav-btn w-full flex items-center px-4 py-3 rounded-lg text-on-surface-variant hover:bg-surface-container transition-all"
                        id="tab-security" onclick="switchTab('security')">
                        <span class="material-symbols-outlined mr-3">admin_panel_settings</span>
                        <span class="font-body-md text-body-md font-medium">Security &amp; Access</span>
                    </button>
                    <button type="button"
                        class="nav-btn w-full flex items-center px-4 py-3 rounded-lg text-on-surface-variant hover:bg-surface-container transition-all"
                        id="tab-notifications" onclick="switchTab('notifications')">
                        <span class="material-symbols-outlined mr-3">notifications_active</span>
                        <span class="font-body-md text-body-md font-medium">Notifications</span>
                    </button>
                </nav>
                <!-- Settings Content Canvas -->
                <div class="flex-1 pb-32">
                    <!-- Section: General Settings -->
                    <section class="settings-section space-y-6" id="content-general">
                        <div
                            class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-lg shadow-sm">
                            <h3
                                class="font-title-md text-title-md text-on-surface mb-lg border-b border-outline-variant/20 pb-md">
                                System Preferences</h3>
                            <div class="grid grid-cols-2 gap-lg">
                                <div class="space-y-sm">
                                    <label class="font-label-md text-label-md text-on-surface">System Name</label>
                                    <input name="system_name"
                                        class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                                        type="text" value="<?php echo htmlspecialchars($settings['system_name']); ?>" required>
                                </div>
                                <div class="space-y-sm">
                                    <label class="font-label-md text-label-md text-on-surface">Language</label>
                                    <select name="language"
                                        class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                                        <option value="en-US" <?php echo $settings['language'] === 'en-US' ? 'selected' : ''; ?>>English (US)</option>
                                        <option value="es" <?php echo $settings['language'] === 'es' ? 'selected' : ''; ?>>Spanish</option>
                                        <option value="fr" <?php echo $settings['language'] === 'fr' ? 'selected' : ''; ?>>French</option>
                                        <option value="de" <?php echo $settings['language'] === 'de' ? 'selected' : ''; ?>>German</option>
                                    </select>
                                </div>
                                <div class="space-y-sm col-span-2">
                                    <label class="font-label-md text-label-md text-on-surface">Time Zone</label>
                                    <select name="timezone"
                                        class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                                        <?php foreach ($timezones as $tz => $label): ?>
                                            <option value="<?php echo htmlspecialchars($tz); ?>" <?php echo $settings['timezone'] === $tz ? 'selected' : ''; ?>><?php echo htmlspecialchars($label); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div
                            class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-lg shadow-sm">
                            <h3
                                class="font-title-md text-title-md text-on-surface mb-lg border-b border-outline-variant/20 pb-md">
                                Branding &amp; Logo</h3>
                            <div class="flex items-center gap-lg">
                                <div
                                    class="w-32 h-32 bg-primary/5 border-2 border-dashed border-primary/30 rounded-xl flex items-center justify-center overflow-hidden">
                                    <img src="<?php echo htmlspecialchars($logo_src); ?>" alt="Company Logo" class="max-w-full max-h-full object-contain p-2">
                                </div>
                                <div class="flex-1">
                                    <p class="font-body-md text-body-md text-on-surface font-semibold">Company Logo</p>
                                    <p class="font-body-md text-body-md text-on-surface-variant mb-4">Upload JPG, PNG, GIF, or WebP (max 2MB). Recommended size: 512×512px.</p>
                                    <label class="inline-flex items-center gap-2 bg-primary text-white px-6 py-2 rounded-lg font-bold hover:opacity-90 transition-all shadow-sm cursor-pointer">
                                        <span class="material-symbols-outlined text-sm">upload</span>
                                        Replace Image
                                        <input type="file" name="logo" accept="image/jpeg,image/png,image/gif,image/webp" class="hidden">
                                    </label>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Section: Account & Profile -->
                    <section class="settings-section hidden space-y-6" id="content-account">
                        <div
                            class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-lg shadow-sm">
                            <h3
                                class="font-title-md text-title-md text-on-surface mb-lg border-b border-outline-variant/20 pb-md">
                                Profile Information</h3>
                            <div class="flex items-center mb-lg gap-lg">
                                <div class="relative">
                                    <img alt="Profile Avatar"
                                        class="w-24 h-24 rounded-full object-cover border-4 border-surface-container"
                                        src="<?php echo htmlspecialchars($profile_src); ?>">
                                    <?php if (!$is_system_admin): ?>
                                    <label class="absolute bottom-0 right-0 bg-primary text-white p-1.5 rounded-full shadow-lg border-2 border-white cursor-pointer">
                                        <span class="material-symbols-outlined text-sm">edit</span>
                                        <input type="file" name="profile_image" accept="image/jpeg,image/png,image/gif,image/webp" class="hidden">
                                    </label>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h4 class="font-title-md text-on-surface"><?php echo htmlspecialchars($admin_user['full_name']); ?></h4>
                                    <p class="font-body-md text-on-surface-variant"><?php echo htmlspecialchars($admin_user['email']); ?></p>
                                    <?php if ($is_system_admin): ?>
                                        <p class="text-xs text-on-surface-variant mt-1">Built-in admin — email is fixed; use login credentials from setup.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-lg">
                                <div class="space-y-sm">
                                    <label class="font-label-md text-label-md text-on-surface">Full Name</label>
                                    <input name="full_name"
                                        class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                                        type="text" value="<?php echo htmlspecialchars($admin_user['full_name']); ?>" required>
                                </div>
                                <div class="space-y-sm">
                                    <label class="font-label-md text-label-md text-on-surface">Email Address</label>
                                    <input name="email"
                                        class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none <?php echo $is_system_admin ? 'opacity-60' : ''; ?>"
                                        type="email" value="<?php echo htmlspecialchars($admin_user['email']); ?>" <?php echo $is_system_admin ? 'readonly' : 'required'; ?>>
                                </div>
                                <div class="space-y-sm">
                                    <label class="font-label-md text-label-md text-on-surface">Phone</label>
                                    <input name="phone"
                                        class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                                        type="text" value="<?php echo htmlspecialchars($admin_user['phone'] ?? ''); ?>" <?php echo $is_system_admin ? 'readonly' : ''; ?>>
                                </div>
                                <?php if (!$is_system_admin): ?>
                                <div class="space-y-sm">
                                    <label class="font-label-md text-label-md text-on-surface">New Password</label>
                                    <input name="new_password"
                                        class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                                        type="password" placeholder="Leave blank to keep current" autocomplete="new-password">
                                </div>
                                <div class="space-y-sm col-span-2">
                                    <label class="font-label-md text-label-md text-on-surface">Confirm New Password</label>
                                    <input name="confirm_password"
                                        class="w-full bg-surface-container-low border border-outline-variant rounded-lg px-4 py-2 focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none"
                                        type="password" placeholder="Confirm new password" autocomplete="new-password">
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </section>
                    <!-- Section: Security & Access -->
                    <section class="settings-section hidden space-y-6" id="content-security">
                        <div
                            class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-lg shadow-sm">
                            <h3
                                class="font-title-md text-title-md text-on-surface mb-lg border-b border-outline-variant/20 pb-md">
                                Access Control</h3>
                            <div class="space-y-lg">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-4">
                                        <div class="p-3 bg-error-container/20 text-error rounded-xl">
                                            <span class="material-symbols-outlined">security</span>
                                        </div>
                                        <div>
                                            <p class="font-body-md font-semibold text-on-surface">Two-Factor
                                                Authentication (2FA)</p>
                                            <p class="text-sm text-on-surface-variant">Add an extra layer of security to
                                                your account.</p>
                                        </div>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input type="checkbox" name="two_factor_enabled" value="1" class="sr-only peer" <?php echo $settings['two_factor_enabled'] === '1' ? 'checked' : ''; ?>>
                                        <div class="w-11 h-6 bg-outline-variant rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Section: Notifications -->
                    <section class="settings-section hidden space-y-6" id="content-notifications">
                        <div
                            class="bg-surface-container-lowest border border-outline-variant/30 rounded-xl p-lg shadow-sm">
                            <h3
                                class="font-title-md text-title-md text-on-surface mb-lg border-b border-outline-variant/20 pb-md">
                                Communication Preferences</h3>
                            <div class="space-y-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-body-md font-semibold text-on-surface">Email Notifications</p>
                                        <p class="text-sm text-on-surface-variant">Receive summary updates and urgent
                                            alerts via email.</p>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer">
                                        <input name="email_notifications" value="1" class="sr-only peer" type="checkbox" <?php echo $settings['email_notifications'] === '1' ? 'checked' : ''; ?>>
                                        <div
                                            class="w-11 h-6 bg-outline-variant rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </form>
            </div>
        </div>
    </main>
    <!-- Fixed Action Footer -->
    <div class="fixed bottom-0 left-64 right-0 z-50 bg-white/80 backdrop-blur-md border-t border-outline-variant/30">
        <div class="max-w-[1600px] mx-auto px-margin-desktop py-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3 ml-4 text-on-surface-variant">
                    <span class="material-symbols-outlined text-primary"
                        style="font-variation-settings: 'FILL' 1;">info</span>
                    <p class="text-sm">Unsaved changes will be lost if you leave this page.</p>
                </div>
                <div class="flex items-center gap-4">
                    <button type="button"
                        class="px-6 py-2.5 rounded-xl font-bold text-on-surface-variant hover:bg-surface-container transition-all"
                        onclick="window.location.href='settings.php?tab=' + document.getElementById('active_tab').value">Discard
                        Changes</button>
                    <button type="submit" form="settings-form"
                        class="bg-primary text-white px-10 py-2.5 rounded-xl font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-2">
                        <span class="material-symbols-outlined text-xl">save</span>
                        <span>Save Changes</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function switchTab(tabId) {
            document.querySelectorAll('.settings-section').forEach(section => {
                section.classList.add('hidden');
            });
            document.querySelectorAll('.nav-btn').forEach(btn => {
                btn.classList.remove('active-tab');
            });

            document.getElementById('content-' + tabId).classList.remove('hidden');
            document.getElementById('tab-' + tabId).classList.add('active-tab');
            document.getElementById('active_tab').value = tabId;

            document.querySelector('main').scrollTo({ top: 0, behavior: 'smooth' });
        }

        window.onload = () => switchTab(<?php echo json_encode($active_tab); ?>);
    </script>




</body>

</html>