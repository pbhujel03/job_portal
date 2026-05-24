<?php
// Include database connection
require_once '..//../backend/config/db.php';

// Start session
session_start();

// Check if user is logged in and is admin
$admin_user = null;
if (isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    // Handle hardcoded admin (user_id = 0)
    if ($_SESSION['user_id'] == 0) {
        $admin_user = array(
            'user_id' => 0,
            'full_name' => $_SESSION['name'] ?? 'System Administrator',
            'email' => 'admin@jobportal.com',
            'role' => 'admin'
        );
    } else {
        // Check database for admin user
        $admin_result = $conn->query("SELECT * FROM users WHERE user_id = " . intval($_SESSION['user_id']) . " AND role = 'admin'");
        $admin_user = $admin_result->fetch_assoc();
    }
    
    if (!$admin_user) {
        // Not an admin, redirect to login
        header("Location: ../public/login.php");
        exit;
    }
} else {
    // Not logged in or not admin, redirect to login
    header("Location: ../public/login.php");
    exit;
}

// Fetch statistics from database
$total_users = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];
$total_jobs = $conn->query("SELECT COUNT(*) as count FROM jobs")->fetch_assoc()['count'];
$total_applications = $conn->query("SELECT COUNT(*) as count FROM applications")->fetch_assoc()['count'];
$shortlisted = $conn->query("SELECT COUNT(*) as count FROM applications WHERE status = 'shortlisted'")->fetch_assoc()['count'];

// Get active users (users with activity in last 24 hours)
$active_users = $conn->query("SELECT COUNT(DISTINCT user_id) as count FROM activity_logs WHERE created_at > DATE_SUB(NOW(), INTERVAL 24 HOUR)")->fetch_assoc()['count'];

// Handle search functionality
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$search_results = null;

if (!empty($search_query)) {
    $search_term = '%' . $conn->real_escape_string($search_query) . '%';
    $search_results = $conn->query("
        SELECT u.user_id, u.full_name, u.email, u.role, COUNT(a.application_id) as app_count 
        FROM users u 
        LEFT JOIN applications a ON u.user_id = a.seeker_id AND u.role = 'job_seeker'
        WHERE u.full_name LIKE '$search_term' OR u.email LIKE '$search_term'
        GROUP BY u.user_id 
        ORDER BY u.created_at DESC 
        LIMIT 10
    ");
}

// Fetch recent job seekers
$job_seekers_query = $conn->query("
    SELECT u.user_id, u.full_name, u.email, COUNT(a.application_id) as app_count 
    FROM users u 
    LEFT JOIN applications a ON u.user_id = a.seeker_id 
    WHERE u.role = 'job_seeker' 
    GROUP BY u.user_id 
    ORDER BY u.created_at DESC 
    LIMIT 2
");

// Fetch recent recruiters
$recruiters_query = $conn->query("
    SELECT u.user_id, u.full_name, u.email, COUNT(j.job_id) as jobs_posted 
    FROM users u 
    LEFT JOIN jobs j ON u.user_id = j.recruiter_id 
    WHERE u.role = 'recruiter' 
    GROUP BY u.user_id 
    ORDER BY u.created_at DESC 
    LIMIT 2
");

// Fetch recruitment funnel data
$funnel_data = $conn->query("
    SELECT status, COUNT(*) as count 
    FROM applications 
    GROUP BY status
");

$funnel_counts = [];
while ($row = $funnel_data->fetch_assoc()) {
    $funnel_counts[$row['status']] = $row['count'];
}

// Calculate percentages for funnel
$total_applied = $funnel_counts['applied'] ?? 0;
$total_reviewed = $funnel_counts['reviewed'] ?? 0;
$total_shortlisted = $funnel_counts['shortlisted'] ?? 0;
$total_rejected = $funnel_counts['rejected'] ?? 0;
?>

<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>RecruitFlow Admin Console</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-primary-fixed": "#0f0069",
                        "inverse-on-surface": "#eaf1ff",
                        "secondary-container": "#dae2fd",
                        "secondary": "#565e74",
                        "on-tertiary-fixed-variant": "#7b2f00",
                        "on-error": "#ffffff",
                        "surface-variant": "#d3e4fe",
                        "on-secondary-fixed-variant": "#3f465c",
                        "primary-fixed": "#e2dfff",
                        "on-secondary": "#ffffff",
                        "surface": "#f8f9ff",
                        "surface-tint": "#4d44e3",
                        "error": "#ba1a1a",
                        "tertiary": "#7e3000",
                        "primary-container": "#4f46e5",
                        "on-surface-variant": "#464555",
                        "on-primary": "#ffffff",
                        "inverse-surface": "#213145",
                        "tertiary-fixed": "#ffdbcc",
                        "on-primary-fixed-variant": "#3323cc",
                        "on-primary-container": "#dad7ff",
                        "surface-container-high": "#dce9ff",
                        "on-background": "#0b1c30",
                        "primary": "#3525cd",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-container": "#ffd2be",
                        "tertiary-container": "#a44100",
                        "on-secondary-container": "#5c647a",
                        "surface-bright": "#f8f9ff",
                        "secondary-fixed-dim": "#bec6e0",
                        "on-error-container": "#93000a",
                        "surface-container-low": "#eff4ff",
                        "on-surface": "#0b1c30",
                        "on-tertiary": "#ffffff",
                        "secondary-fixed": "#dae2fd",
                        "on-tertiary-fixed": "#351000",
                        "inverse-primary": "#c3c0ff",
                        "surface-container-highest": "#d3e4fe",
                        "outline": "#777587",
                        "tertiary-fixed-dim": "#ffb695",
                        "surface-container": "#e5eeff",
                        "on-secondary-fixed": "#131b2e",
                        "surface-dim": "#cbdbf5",
                        "error-container": "#ffdad6",
                        "primary-fixed-dim": "#c3c0ff",
                        "outline-variant": "#c7c4d8",
                        "background": "#f8f9ff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "xl": "32px",
                        "margin-mobile": "16px",
                        "gutter": "24px",
                        "lg": "24px",
                        "base": "8px",
                        "xs": "4px",
                        "sm": "8px",
                        "margin-desktop": "40px",
                        "md": "16px"
                    },
                    "fontFamily": {
                        "body-md": ["Inter"],
                        "headline-lg": ["Inter"],
                        "display": ["Inter"],
                        "body-lg": ["Inter"],
                        "label-md": ["Inter"],
                        "title-md": ["Inter"],
                        "headline-lg-mobile": ["Inter"]
                    },
                    "fontSize": {
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "display": ["56px", { "lineHeight": "64px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500" }],
                        "title-md": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "headline-lg-mobile": ["28px", { "lineHeight": "36px", "letterSpacing": "-0.01em", "fontWeight": "600" }]
                    }
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
    </style>
</head>

<body class="bg-surface text-on-surface min-h-screen flex">
    <!-- SideNavBar Component -->
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
            <a class="flex items-center gap-md bg-primary-container text-on-primary-container rounded-lg px-md py-base transition-transform active:scale-95"
                href="#">
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
    <!-- Main Content Area -->
    <main class="ml-64 flex-1 min-h-screen bg-surface relative flex flex-col">
        <!-- TopNavBar Component -->
        <header
            class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-surface border-b border-outline-variant flex justify-between items-center px-margin-desktop z-40">
            <div class="flex items-center gap-lg flex-1">
                <form action="" method="GET" class="w-full max-w-md">
                    <div
                        class="relative focus-within:ring-2 focus-within:ring-primary rounded-full bg-surface-container-low transition-all">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline"
                            data-icon="search">search</span>
                        <input class="w-full bg-transparent border-none focus:ring-0 py-2 pl-10 pr-4 text-body-md"
                            placeholder="Search for jobs, recruiters, or candidates..." type="text" name="search" value="<?php echo htmlspecialchars($search_query); ?>">
                    </div>
                </form>
            </div>
            <div class="flex items-center gap-md">
                <div class="flex items-center gap-sm">
                    <div class="w-10 h-10 rounded-full border-2 border-primary-container bg-primary-fixed flex items-center justify-center text-on-primary-fixed font-bold">
                        <?php echo strtoupper(substr($admin_user['full_name'], 0, 1) . substr(explode(' ', $admin_user['full_name'])[1] ?? '', 0, 1)); ?>
                    </div>
                    <div class="hidden lg:block text-left">
                        <p class="font-body-md font-bold text-on-surface"><?php echo htmlspecialchars($admin_user['full_name']); ?></p>
                        <p class="text-[10px] text-on-surface-variant">System Admin</p>
                    </div>
                </div>
            </div>
        </header>
        <!-- Page Canvas -->
        <div class="mt-16 p-margin-desktop grid grid-cols-1 gap-gutter flex-grow">
            <!-- 1. System-Wide Overview -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-md">
                <!-- Total Users -->
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:border-primary transition-colors">
                    <div class="flex justify-between items-start mb-sm">
                        <span class="material-symbols-outlined text-primary p-2 bg-primary-fixed rounded-lg"
                            data-icon="group"
                            style="transform: scale(1) rotate(0deg); transition: transform 0.3s;">group</span>
                        <span class="text-[10px] font-bold text-tertiary-container flex items-center gap-xs">
                            <span class="material-symbols-outlined text-[14px]"
                                data-icon="trending_up">trending_up</span> +12%
                        </span>
                    </div>
                    <div>
                        <p class="text-on-surface-variant font-label-md">Total Users</p>
                        <h2 class="text-headline-lg font-headline-lg text-on-surface"><?php echo number_format($total_users); ?></h2>
                    </div>
                </div>
                <!-- Jobs Posted -->
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:border-primary transition-colors">
                    <div class="flex justify-between items-start mb-sm">
                        <span class="material-symbols-outlined text-primary p-2 bg-primary-fixed rounded-lg"
                            data-icon="work"
                            style="transform: scale(1) rotate(0deg); transition: transform 0.3s;">work</span>
                        <span class="text-[10px] font-bold text-tertiary-container flex items-center gap-xs">
                            <span class="material-symbols-outlined text-[14px]"
                                data-icon="trending_up">trending_up</span> +8%
                        </span>
                    </div>
                    <div>
                        <p class="text-on-surface-variant font-label-md">Jobs Posted</p>
                        <h2 class="text-headline-lg font-headline-lg text-on-surface"><?php echo number_format($total_jobs); ?></h2>
                    </div>
                </div>
                <!-- Applications -->
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:border-primary transition-colors">
                    <div class="flex justify-between items-start mb-sm">
                        <span class="material-symbols-outlined text-primary p-2 bg-primary-fixed rounded-lg"
                            data-icon="description"
                            style="transform: scale(1) rotate(0deg); transition: transform 0.3s;">description</span>
                        <span class="text-[10px] font-bold text-tertiary-container flex items-center gap-xs">
                            <span class="material-symbols-outlined text-[14px]"
                                data-icon="trending_up">trending_up</span> +24%
                        </span>
                    </div>
                    <div>
                        <p class="text-on-surface-variant font-label-md">Applications</p>
                        <h2 class="text-headline-lg font-headline-lg text-on-surface"><?php echo number_format($total_applications); ?></h2>
                    </div>
                </div>
                <!-- Shortlisted -->
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:border-primary transition-colors">
                    <div class="flex justify-between items-start mb-sm">
                        <span class="material-symbols-outlined text-primary p-2 bg-primary-fixed rounded-lg"
                            data-icon="person_check">person_check</span>
                        <span class="text-[10px] font-bold text-error flex items-center gap-xs">
                            <span class="material-symbols-outlined text-[14px]"
                                data-icon="trending_down">trending_down</span> -2%
                        </span>
                    </div>
                    <div>
                        <p class="text-on-surface-variant font-label-md">Shortlisted</p>
                        <h2 class="text-headline-lg font-headline-lg text-on-surface"><?php echo number_format($shortlisted); ?></h2>
                    </div>
                </div>
                <!-- Active Users -->
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm flex flex-col justify-between hover:border-primary transition-colors">
                    <div class="flex justify-between items-start mb-sm">
                        <span class="material-symbols-outlined text-primary p-2 bg-primary-fixed rounded-lg"
                            data-icon="bolt"
                            style="transform: scale(1) rotate(0deg); transition: transform 0.3s;">bolt</span>
                        <span class="text-[10px] font-bold text-tertiary-container flex items-center gap-xs">
                            <span class="material-symbols-outlined text-[14px]"
                                data-icon="trending_up">trending_up</span> +5%
                        </span>
                    </div>
                    <div>
                        <p class="text-on-surface-variant font-label-md">Active Now</p>
                        <h2 class="text-headline-lg font-headline-lg text-on-surface"><?php echo number_format($active_users); ?></h2>
                    </div>
                </div>
            </div>
            <!-- 2. Recent Job Seekers Table -->
            <section class="bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden">
                <div
                    class="px-lg py-md border-b border-outline-variant flex justify-between items-center bg-surface-container-low">
                    <h3 class="font-title-md text-on-surface">Recent Job Seekers</h3>
                    <a href="manage_users.php?role=job_seeker" class="text-primary font-body-md font-bold hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left font-body-md">
                        <thead>
                            <tr
                                class="bg-surface-container-low text-on-surface-variant border-b border-outline-variant">
                                <th class="px-lg py-md font-bold">Candidate</th>
                                <th class="px-lg py-md font-bold">Top Skills</th>
                                <th class="px-lg py-md font-bold text-center">Apps</th>
                                <th class="px-lg py-md font-bold text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            <?php while ($seeker = $job_seekers_query->fetch_assoc()): 
                                $initials = strtoupper(substr($seeker['full_name'], 0, 1) . substr(explode(' ', $seeker['full_name'])[1] ?? '', 0, 1));
                            ?>
                            <tr>
                                <td class="px-lg py-md">
                                    <div class="flex items-center gap-md">
                                        <div
                                            class="w-8 h-8 rounded-full bg-secondary-fixed text-on-secondary-fixed flex items-center justify-center font-bold text-xs">
                                            <?php echo $initials; ?></div>
                                        <div>
                                            <p class="font-bold"><?php echo htmlspecialchars($seeker['full_name']); ?></p>
                                            <p class="text-xs text-on-surface-variant"><?php echo htmlspecialchars($seeker['email']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-lg py-md">
                                    <div class="flex gap-xs">
                                        <span
                                            class="bg-secondary-container text-on-secondary-container px-2 py-0.5 rounded text-[10px] font-bold">Job Seeker</span>
                                    </div>
                                </td>
                                <td class="px-lg py-md text-center font-bold text-on-surface-variant"><?php echo $seeker['app_count']; ?></td>
                                <td class="px-lg py-md text-right">
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-wider text-on-tertiary-fixed bg-tertiary-fixed px-2 py-1 rounded-full">Active</span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                    </table>
                </div>
            </section>
            <!-- 3. Recent Recruiters Table -->
            <section class="bg-surface-container-lowest rounded-xl border border-outline-variant overflow-hidden">
                <div
                    class="px-lg py-md border-b border-outline-variant flex justify-between items-center bg-surface-container-low">
                    <h3 class="font-title-md text-on-surface">Recent Recruiters</h3>
                    <a href="manage_users.php?role=recruiter" class="text-primary font-body-md font-bold hover:underline">View All</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left font-body-md">
                        <thead>
                            <tr
                                class="bg-surface-container-low text-on-surface-variant border-b border-outline-variant">
                                <th class="px-lg py-md font-bold">Recruiter</th>
                                <th class="px-lg py-md font-bold">Industry</th>
                                <th class="px-lg py-md font-bold text-center">Jobs Posted</th>
                                <th class="px-lg py-md font-bold text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant">
                            <?php while ($recruiter = $recruiters_query->fetch_assoc()): 
                                $initials = strtoupper(substr($recruiter['full_name'], 0, 1) . substr(explode(' ', $recruiter['full_name'])[1] ?? '', 0, 1));
                            ?>
                            <tr>
                                <td class="px-lg py-md">
                                    <div class="flex items-center gap-md">
                                        <div
                                            class="w-8 h-8 rounded-full bg-primary-container text-on-primary flex items-center justify-center font-bold text-xs">
                                            <?php echo $initials; ?></div>
                                        <div>
                                            <p class="font-bold"><?php echo htmlspecialchars($recruiter['full_name']); ?></p>
                                            <p class="text-xs text-on-surface-variant"><?php echo htmlspecialchars($recruiter['email']); ?></p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-lg py-md">
                                    <span class="text-xs font-medium text-on-surface-variant">Recruitment</span>
                                </td>
                                <td class="px-lg py-md text-center font-bold text-on-surface-variant"><?php echo $recruiter['jobs_posted']; ?></td>
                                <td class="px-lg py-md text-right">
                                    <span
                                        class="text-[10px] font-bold uppercase tracking-wider text-on-primary-container bg-primary-container/20 px-2 py-1 rounded-full border border-primary-container/30">Verified</span>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                    </table>
                </div>
            </section>
            <!-- 4. Recruitment Funnel -->
            <section class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant">
                <h3 class="font-title-md text-on-surface mb-lg">Recruitment Funnel Overview</h3>
                <div class="space-y-md">
                    <div class="relative">
                        <div class="flex justify-between text-xs mb-1 font-bold"><span class="">Applied</span><span
                                class=""><?php echo number_format($total_applied); ?></span></div>
                        <div class="w-full bg-surface-container-high h-6 rounded-lg overflow-hidden">
                            <div class="bg-primary h-full w-full opacity-100 transition-all duration-1000"></div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="flex justify-between text-xs mb-1 font-bold"><span class="">Reviewed</span><span
                                class=""><?php echo number_format($total_reviewed); ?></span></div>
                        <div class="w-full bg-surface-container-high h-6 rounded-lg overflow-hidden">
                            <div class="bg-primary h-full <?php echo ($total_applied > 0) ? 'w-[' . ($total_reviewed / $total_applied * 100) . '%]' : 'w-0'; ?> opacity-80 transition-all duration-1000"></div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="flex justify-between text-xs mb-1 font-bold"><span class="">Shortlisted</span><span
                                class=""><?php echo number_format($total_shortlisted); ?></span></div>
                        <div class="w-full bg-surface-container-high h-6 rounded-lg overflow-hidden">
                            <div class="bg-primary h-full <?php echo ($total_applied > 0) ? 'w-[' . ($total_shortlisted / $total_applied * 100) . '%]' : 'w-0'; ?> opacity-60 transition-all duration-1000"></div>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="flex justify-between text-xs mb-1 font-bold"><span class="">Rejected</span><span
                                class=""><?php echo number_format($total_rejected); ?></span></div>
                        <div class="w-full bg-surface-container-high h-6 rounded-lg overflow-hidden">
                            <div class="bg-error h-full <?php echo ($total_applied > 0) ? 'w-[' . ($total_rejected / $total_applied * 100) . '%]' : 'w-0'; ?> opacity-40 transition-all duration-1000"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- System Footer -->
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
        document.addEventListener('DOMContentLoaded', () => {
            const statCards = document.querySelectorAll('.hover\\:border-primary');
            statCards.forEach(card => {
                card.addEventListener('mouseenter', () => {
                    const icon = card.querySelector('.material-symbols-outlined');
                    if (icon) {
                        icon.style.transform = 'scale(1.1) rotate(5deg)';
                        icon.style.transition = 'transform 0.3s ease';
                    }
                });
                card.addEventListener('mouseleave', () => {
                    const icon = card.querySelector('.material-symbols-outlined');
                    if (icon) {
                        icon.style.transform = 'scale(1) rotate(0deg)';
                    }
                });
            });
        });
    </script>
</body>

</html>