<?php
// Include database connection
require_once '../../backend/config/db.php';

// Start session
session_start();

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// Get admin user info
$admin_user = null;
if ($_SESSION['user_id'] == 0) {
    $admin_user = array(
        'user_id' => 0,
        'full_name' => $_SESSION['name'] ?? 'System Administrator',
        'email' => 'admin@jobportal.com',
        'role' => 'admin'
    );
} else {
    $admin_result = $conn->query("SELECT * FROM users WHERE user_id = " . intval($_SESSION['user_id']) . " AND role = 'admin'");
    $admin_user = $admin_result->fetch_assoc();
}

// Get role filter from URL parameter
$selected_role = isset($_GET['role']) ? $_GET['role'] : '';
$selected_status = isset($_GET['status']) ? $_GET['status'] : '';

// Build query based on filters
$where_conditions = [];

if ($selected_role && in_array($selected_role, ['job_seeker', 'recruiter'])) {
    $where_conditions[] = "role = '" . $conn->real_escape_string($selected_role) . "'";
}

if ($selected_status && in_array($selected_status, ['active', 'pending', 'suspended'])) {
    // You can add status column logic here if you have it in the database
}

$where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

// Fetch users
$users_query = "SELECT user_id, full_name, email, role, created_at FROM users $where_clause ORDER BY created_at DESC";
$users_result = $conn->query($users_query);
$total_users = $users_result->num_rows;

// Count statistics
$total_users_count = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$active_users_count = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$job_seekers_count = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'job_seeker'")->fetch_assoc()['count'];
$recruiters_count = $conn->query("SELECT COUNT(*) as count FROM users WHERE role = 'recruiter'")->fetch_assoc()['count'];
?>
<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>User Management | RecruitAdmin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface-container": "#e5eeff",
                        "primary": "#3525cd",
                        "tertiary-fixed": "#ffdbcc",
                        "on-surface-variant": "#464555",
                        "secondary-fixed": "#dae2fd",
                        "outline-variant": "#c7c4d8",
                        "on-secondary-fixed-variant": "#3f465c",
                        "on-error": "#ffffff",
                        "on-primary-container": "#dad7ff",
                        "surface-variant": "#d3e4fe",
                        "surface-tint": "#4d44e3",
                        "error-container": "#ffdad6",
                        "surface-container-lowest": "#ffffff",
                        "primary-fixed": "#e2dfff",
                        "on-error-container": "#93000a",
                        "surface-container-highest": "#d3e4fe",
                        "primary-container": "#4f46e5",
                        "tertiary": "#7e3000",
                        "surface": "#f8f9ff",
                        "on-primary": "#ffffff",
                        "surface-container-low": "#eff4ff",
                        "on-tertiary-fixed-variant": "#7b2f00",
                        "on-tertiary-container": "#ffd2be",
                        "on-tertiary": "#ffffff",
                        "inverse-primary": "#c3c0ff",
                        "error": "#ba1a1a",
                        "on-secondary": "#ffffff",
                        "on-background": "#0b1c30",
                        "surface-bright": "#f8f9ff",
                        "primary-fixed-dim": "#c3c0ff",
                        "secondary-container": "#dae2fd",
                        "on-primary-fixed": "#0f0069",
                        "on-tertiary-fixed": "#351000",
                        "on-primary-fixed-variant": "#3323cc",
                        "secondary": "#565e74",
                        "tertiary-container": "#a44100",
                        "inverse-on-surface": "#eaf1ff",
                        "background": "#f8f9ff",
                        "on-secondary-container": "#5c647a",
                        "secondary-fixed-dim": "#bec6e0",
                        "on-surface": "#0b1c30",
                        "inverse-surface": "#213145",
                        "outline": "#777587",
                        "surface-dim": "#cbdbf5",
                        "surface-container-high": "#dce9ff",
                        "tertiary-fixed-dim": "#ffb695",
                        "on-secondary-fixed": "#131b2e"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "margin-mobile": "16px",
                        "md": "16px",
                        "lg": "24px",
                        "xs": "4px",
                        "gutter": "24px",
                        "sm": "8px",
                        "base": "8px",
                        "margin-desktop": "40px",
                        "xl": "32px"
                    },
                    "fontFamily": {
                        "label-md": ["Inter"],
                        "headline-lg": ["Inter"],
                        "body-lg": ["Inter"],
                        "body-md": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "display": ["Inter"],
                        "title-md": ["Inter"]
                    },
                    "fontSize": {
                        "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "headline-lg-mobile": ["28px", { "lineHeight": "36px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "display": ["56px", { "lineHeight": "64px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "title-md": ["20px", { "lineHeight": "28px", "fontWeight": "600" }]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-background text-on-surface selection:bg-primary-container selection:text-on-primary-container">
    <!-- SideNavBar Shell -->
    <aside
        class="fixed h-full left-0 top-0 w-64 bg-on-secondary-fixed dark:bg-inverse-surface flex flex-col py-lg px-md z-50">
        <div class="flex items-center gap-md mb-xl px-md">
            <div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center">
                <span class="material-symbols-outlined text-on-primary" data-icon="rocket_launch">rocket_launch</span>
            </div>
            <div>
                <h1 class="font-title-md text-title-md font-bold text-surface-container-lowest">RecruitFlow</h1>
                <p class="text-[10px] text-secondary-fixed-dim tracking-widest uppercase">Admin Console</p>
            </div>
        </div>
        <nav class="flex-1 space-y-xs overflow-y-auto custom-scrollbar">
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="dashboard.php">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span class="font-body-md text-body-md">Dashboard</span>
            </a>
            <a class="flex items-center gap-md bg-primary-container text-on-primary-container rounded-lg px-md py-base transition-transform active:scale-95"
                href="manage_users.php">
                <span class="material-symbols-outlined" data-icon="group">group</span>
                <span class="font-body-md text-body-md">User Management</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="manage_jobs.php">
                <span class="material-symbols-outlined" data-icon="work">work</span>
                <span class="font-body-md text-body-md">Job Management</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="#">
                <span class="material-symbols-outlined" data-icon="assessment">assessment</span>
                <span class="font-body-md text-body-md">Reports</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="#">
                <span class="material-symbols-outlined" data-icon="leaderboard">leaderboard</span>
                <span class="font-body-md text-body-md">Analytics</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="#">
                <span class="material-symbols-outlined" data-icon="settings">settings</span>
                <span class="font-body-md text-body-md">Settings</span>
            </a>
        </nav>
    </aside>
    <!-- Main Wrapper -->
    <main class="ml-64 flex-1 min-h-screen bg-surface relative flex flex-col">
        <!-- TopAppBar Shell -->
        <header
            class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-surface border-b border-outline-variant flex justify-between items-center px-margin-desktop z-40">
            <div
                class="flex items-center bg-surface-container-low rounded-full px-4 py-2 w-96 border border-outline-variant/30">
                <span class="material-symbols-outlined text-on-surface-variant mr-2">search</span>
                <input
                    class="bg-transparent border-none focus:ring-0 text-body-md font-body-md w-full placeholder-on-surface-variant/60"
                    placeholder="Search for anything..." type="text">
            </div>
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-3 cursor-pointer group">
                    <div class="w-10 h-10 rounded-full border-2 border-primary-container bg-primary-fixed flex items-center justify-center text-on-primary-fixed font-bold">
                        <?php echo strtoupper(substr($admin_user['full_name'], 0, 1) . substr(explode(' ', $admin_user['full_name'])[1] ?? '', 0, 1)); ?>
                    </div>
                    <div class="hidden lg:block text-left">
                        <p class="font-body-md font-bold text-on-surface"><?php echo htmlspecialchars($admin_user['full_name']); ?></p>
                        <p class="font-label-md text-label-md text-on-surface-variant">System Admin</p>
                    </div>
                </div>
            </div>
        </header>
        <!-- Content Canvas -->
        <div class="flex-1 p-margin-desktop space-y-xl pt-16">
            <!-- Page Header & Stats -->
            <div class="space-y-lg">
                <div class="flex justify-between items-end">
                    <div>
                        <h2 class="font-headline-lg text-headline-lg text-on-surface">User Management</h2>
                        <p class="text-on-surface-variant font-body-md text-body-md">Oversee and regulate all platform
                            participants across your ecosystem.</p>
                    </div>
                </div>
                <!-- Stats Bento Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-gutter">
                    <div
                        class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">
                                Total Users</p>
                            <h3 class="text-display font-display text-[32px] font-extrabold text-on-surface mt-1"><?php echo number_format($total_users_count); ?>
                            </h3>
                            <p class="text-primary font-label-md text-label-md flex items-center mt-2">
                                <span class="material-symbols-outlined text-sm mr-1">trending_up</span> <?php echo number_format($job_seekers_count); ?> Candidates
                            </p>
                        </div>
                        <div class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined"
                                style="font-variation-settings: 'FILL' 1;">groups</span>
                        </div>
                    </div>
                    <div
                        class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">
                                Recruiters</p>
                            <h3 class="text-display font-display text-[32px] font-extrabold text-on-surface mt-1"><?php echo number_format($recruiters_count); ?>
                            </h3>
                            <p class="text-emerald-600 font-label-md text-label-md flex items-center mt-2">
                                <span class="material-symbols-outlined text-sm mr-1">check_circle</span> Hiring Partners
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600">
                            <span class="material-symbols-outlined"
                                style="font-variation-settings: 'FILL' 1;">verified_user</span>
                        </div>
                    </div>
                    <div
                        class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm flex items-center justify-between">
                        <div>
                            <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">
                                Candidates</p>
                            <h3 class="text-display font-display text-[32px] font-extrabold text-on-surface mt-1"><?php echo number_format($job_seekers_count); ?>
                            </h3>
                            <p class="text-tertiary font-label-md text-label-md flex items-center mt-2">
                                <span class="material-symbols-outlined text-sm mr-1">history</span> Job Seekers
                            </p>
                        </div>
                        <div
                            class="w-12 h-12 bg-tertiary-fixed rounded-full flex items-center justify-center text-tertiary">
                            <span class="material-symbols-outlined"
                                style="font-variation-settings: 'FILL' 1;">pending</span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Main Table Section -->
            <section
                class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col">
                <!-- Table Filters -->
                <div
                    class="p-lg border-b border-outline-variant/20 flex flex-wrap gap-4 items-center justify-between bg-surface-bright/50">
                    <div class="flex gap-3 items-center">
                        <div class="relative">
                            <select onchange="window.location.href='?role=' + this.value"
                                class="appearance-none pl-4 pr-10 py-2 bg-white border border-outline-variant rounded-lg text-body-md font-body-md focus:ring-primary focus:border-primary cursor-pointer">
                                <option value="">All Roles</option>
                                <option value="job_seeker" <?php echo ($selected_role === 'job_seeker') ? 'selected' : ''; ?>>Candidates</option>
                                <option value="recruiter" <?php echo ($selected_role === 'recruiter') ? 'selected' : ''; ?>>Recruiters</option>
                            </select>
                            <span
                                class="material-symbols-outlined absolute right-3 top-2.5 text-on-surface-variant pointer-events-none text-sm">expand_more</span>
                        </div>
                        <div class="relative">
                            <select
                                class="appearance-none pl-4 pr-10 py-2 bg-white border border-outline-variant rounded-lg text-body-md font-body-md focus:ring-primary focus:border-primary cursor-pointer">
                                <option>Status: All</option>
                                <option>Active</option>
                                <option>Pending</option>
                                <option>Suspended</option>
                            </select>
                            <span
                                class="material-symbols-outlined absolute right-3 top-2.5 text-on-surface-variant pointer-events-none text-sm">expand_more</span>
                        </div>
                        <button
                            class="px-4 py-2 text-primary font-label-md text-label-md font-bold hover:bg-primary/5 rounded-lg transition-all">Clear
                            Filters</button>
                    </div>
                    <div class="relative w-72">
                        <span
                            class="material-symbols-outlined absolute left-3 top-2.5 text-on-surface-variant text-sm">search</span>
                        <input
                            class="pl-10 pr-4 py-2 w-full border border-outline-variant rounded-lg text-body-md font-body-md focus:ring-primary focus:border-primary"
                            placeholder="Search Users..." type="text">
                    </div>
                </div>
                <!-- Data Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-surface-container-low/50 border-b border-outline-variant/20">
                            <tr>
                                <th
                                    class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">
                                    User</th>
                                <th
                                    class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">
                                    Role</th>
                                <th
                                    class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">
                                    Date Joined</th>
                                <th
                                    class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">
                                    Status</th>
                                <th
                                    class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-right">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10">
                            <?php 
                            if ($users_result->num_rows > 0) {
                                while ($user = $users_result->fetch_assoc()) {
                                    $initials = strtoupper(substr($user['full_name'], 0, 1) . substr(explode(' ', $user['full_name'])[1] ?? '', 0, 1));
                                    $role_badge = $user['role'] === 'job_seeker' ? 'Candidate' : 'Recruiter';
                                    $role_color = $user['role'] === 'job_seeker' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800';
                                    $date_joined = date('M d, Y', strtotime($user['created_at']));
                            ?>
                            <tr class="hover:bg-surface-container-low/30 transition-colors">
                                <td class="px-lg py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-full bg-primary-container flex items-center justify-center text-on-primary-fixed font-bold text-sm border border-outline-variant/20">
                                            <?php echo $initials; ?>
                                        </div>
                                        <div>
                                            <p class="font-body-md text-body-md font-bold text-on-surface"><?php echo htmlspecialchars($user['full_name']); ?>
                                            </p>
                                            <p class="font-label-md text-label-md text-on-surface-variant">
                                                <?php echo htmlspecialchars($user['email']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-lg py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $role_color; ?>"><?php echo $role_badge; ?></span>
                                </td>
                                <td class="px-lg py-4 font-body-md text-body-md text-on-surface-variant"><?php echo $date_joined; ?>
                                </td>
                                <td class="px-lg py-4">
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                </td>
                                <td class="px-lg py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="view_user.php?id=<?php echo $user['user_id']; ?>" class="p-1.5 hover:text-primary transition-colors" title="View">
                                                <span class="material-symbols-outlined text-[20px]">visibility</span>
                                            </a>
                                            <a href="edit_user.php?id=<?php echo $user['user_id']; ?>" class="p-1.5 hover:text-primary transition-colors" title="Edit">
                                                <span class="material-symbols-outlined text-[20px]">edit</span>
                                            </a>
                                            <a href="#" onclick="if(confirm('Delete this user?')){ window.location='delete_user.php?id=<?php echo $user['user_id']; ?>'; } return false;" class="p-1.5 hover:text-error transition-colors" title="Delete">
                                                <span class="material-symbols-outlined text-[20px]">delete</span>
                                            </a>
                                        </div>
                                </td>
                            </tr>
                            <?php 
                                }
                            } else {
                                echo '<tr><td colspan="5" class="px-lg py-8 text-center text-on-surface-variant">No users found.</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div
                    class="px-lg py-4 bg-surface-container-lowest border-t border-outline-variant/20 flex items-center justify-between">
                    <p class="font-label-md text-label-md text-on-surface-variant">Showing 1-10 of 14,234 users</p>
                    <div class="flex items-center gap-1">
                        <button
                            class="p-2 border border-outline-variant rounded-md hover:bg-surface-container-low disabled:opacity-50 transition-all"
                            disabled="">
                            <span class="material-symbols-outlined text-sm">chevron_left</span>
                        </button>
                        <button
                            class="px-3 py-1 bg-primary text-white rounded-md font-label-md text-label-md">1</button>
                        <button
                            class="px-3 py-1 hover:bg-surface-container-low rounded-md font-label-md text-label-md text-on-surface-variant">2</button>
                        <button
                            class="px-3 py-1 hover:bg-surface-container-low rounded-md font-label-md text-label-md text-on-surface-variant">3</button>
                        <span class="px-2 text-on-surface-variant">...</span>
                        <button
                            class="px-3 py-1 hover:bg-surface-container-low rounded-md font-label-md text-label-md text-on-surface-variant">1,423</button>
                        <button
                            class="p-2 border border-outline-variant rounded-md hover:bg-surface-container-low transition-all">
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                        </button>
                    </div>
                </div>
            </section>
        </div>
        <!-- Standard Footer -->
        <footer
            class="mt-auto px-margin-desktop py-lg border-t border-outline-variant bg-surface flex justify-between items-center text-[10px] text-on-surface-variant uppercase tracking-widest font-bold">
            <p class="">© 2024 RecruitFlow Intelligence. All rights reserved.</p>
            <div class="flex gap-lg">
                <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="hover:text-primary transition-colors" href="#">Security Audit</a>
                <a class="hover:text-primary transition-colors" href="#">Support Desk</a>
            </div>
        </footer>
    </main>
    <script>
        // Micro-interactions
        document.querySelectorAll('button').forEach(btn => {
            btn.addEventListener('mousedown', () => btn.classList.add('scale-95'));
            btn.addEventListener('mouseup', () => btn.classList.remove('scale-95'));
            btn.addEventListener('mouseleave', () => btn.classList.remove('scale-95'));
        });
    </script>


</body>

</html>