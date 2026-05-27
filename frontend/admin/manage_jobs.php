<?php
// Include database connection
require_once '../../backend/config/db.php';

// Start session
session_start();

// Check if user is admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../public/login.php");
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

// Get search query from URL parameter
$search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
$selected_location = isset($_GET['location']) ? $_GET['location'] : '';
$selected_status = isset($_GET['status']) ? $_GET['status'] : '';

// Fetch job statistics
$total_jobs = $conn->query("SELECT COUNT(*) as count FROM jobs")->fetch_assoc()['count'];
$new_today = $conn->query("SELECT COUNT(*) as count FROM jobs WHERE DATE(created_at) = CURDATE()")->fetch_assoc()['count'];

// Build query based on filters
$where_conditions = [];

if (!empty($search_query)) {
    $search_escaped = $conn->real_escape_string($search_query);
    $where_conditions[] = "(j.title LIKE '%$search_escaped%' OR j.description LIKE '%$search_escaped%' OR j.location LIKE '%$search_escaped%')";
}

if (!empty($selected_location)) {
    $location_escaped = $conn->real_escape_string($selected_location);
    $where_conditions[] = "j.location = '$location_escaped'";
}

$where_clause = !empty($where_conditions) ? "WHERE " . implode(" AND ", $where_conditions) : "";

// Get unique locations for filter
$locations_result = $conn->query("SELECT DISTINCT location FROM jobs WHERE location IS NOT NULL AND location != '' ORDER BY location ASC");
$locations = [];
if ($locations_result) {
    while ($row = $locations_result->fetch_assoc()) {
        $locations[] = $row['location'];
    }
}

// Pagination for jobs
$per_page = 10;
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$offset = ($page - 1) * $per_page;

$total_matching_result = $conn->query("SELECT COUNT(*) as count FROM jobs j $where_clause");
$total_matching_jobs = $total_matching_result ? (int)$total_matching_result->fetch_assoc()['count'] : 0;

// Fetch paginated jobs
$jobs_query = $conn->query("
    SELECT j.job_id, j.title, j.description, j.required_skills, u.full_name as recruiter_name, j.location, j.salary, 
           j.created_at, COUNT(a.application_id) as applications_count
    FROM jobs j
    LEFT JOIN users u ON j.recruiter_id = u.user_id
    LEFT JOIN applications a ON j.job_id = a.job_id
    $where_clause
    GROUP BY j.job_id, j.title, j.description, j.required_skills, j.location, j.salary, j.created_at, u.full_name
    ORDER BY j.created_at DESC
    LIMIT $offset, $per_page
");
$jobs_result = $jobs_query;
?>
<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Job Management | Job Portal Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link rel="stylesheet" href="../assets/css/admin-sidebar-brand.css">
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-primary-container": "#dad7ff",
                        "outline-variant": "#c7c4d8",
                        "tertiary": "#7e3000",
                        "on-primary-fixed": "#0f0069",
                        "primary": "#3525cd",
                        "outline": "#777587",
                        "on-secondary-fixed-variant": "#3f465c",
                        "on-tertiary-container": "#ffd2be",
                        "background": "#f8f9ff",
                        "on-error": "#ffffff",
                        "error-container": "#ffdad6",
                        "on-background": "#0b1c30",
                        "surface-variant": "#d3e4fe",
                        "surface-bright": "#f8f9ff",
                        "on-error-container": "#93000a",
                        "surface-container": "#e5eeff",
                        "inverse-primary": "#c3c0ff",
                        "on-tertiary-fixed": "#351000",
                        "secondary-fixed": "#dae2fd",
                        "tertiary-container": "#a44100",
                        "surface-container-low": "#eff4ff",
                        "on-secondary-container": "#5c647a",
                        "on-secondary": "#ffffff",
                        "tertiary-fixed": "#ffdbcc",
                        "surface-container-high": "#dce9ff",
                        "on-tertiary-fixed-variant": "#7b2f00",
                        "surface-container-highest": "#d3e4fe",
                        "tertiary-fixed-dim": "#ffb695",
                        "surface-dim": "#cbdbf5",
                        "secondary-container": "#dae2fd",
                        "primary-fixed-dim": "#c3c0ff",
                        "on-primary": "#ffffff",
                        "surface": "#f8f9ff",
                        "primary-fixed": "#e2dfff",
                        "on-secondary-fixed": "#131b2e",
                        "inverse-surface": "#213145",
                        "surface-tint": "#4d44e3",
                        "on-primary-fixed-variant": "#3323cc",
                        "surface-container-lowest": "#ffffff",
                        "secondary-fixed-dim": "#bec6e0",
                        "on-tertiary": "#ffffff",
                        "secondary": "#565e74",
                        "inverse-on-surface": "#eaf1ff",
                        "on-surface": "#0b1c30",
                        "on-surface-variant": "#464555",
                        "error": "#ba1a1a",
                        "primary-container": "#4f46e5"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "margin-mobile": "16px",
                        "xs": "4px",
                        "md": "16px",
                        "margin-desktop": "40px",
                        "lg": "24px",
                        "base": "8px",
                        "sm": "8px",
                        "xl": "32px",
                        "gutter": "24px"
                    },
                    "fontFamily": {
                        "headline-lg": ["Inter"],
                        "body-md": ["Inter"],
                        "title-md": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "body-lg": ["Inter"],
                        "label-md": ["Inter"],
                        "display": ["Inter"]
                    },
                    "fontSize": {
                        "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "title-md": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "headline-lg-mobile": ["28px", { "lineHeight": "36px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500" }],
                        "display": ["56px", { "lineHeight": "64px", "letterSpacing": "-0.02em", "fontWeight": "700" }]
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

        .sidebar-active {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-surface text-on-surface min-h-screen flex selection:bg-primary-container selection:text-on-primary-container">
    <!-- SideNavBar Shell -->
    <aside
        class="fixed h-full left-0 top-0 w-64 bg-on-secondary-fixed dark:bg-inverse-surface flex flex-col py-lg px-md z-50">
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
            <a class="flex items-center gap-md bg-primary-container text-on-primary-container rounded-lg px-md py-base transition-transform active:scale-95"
                href="manage_jobs.php">
                <span class="material-symbols-outlined" data-icon="work">work</span>
                <span class="font-body-md text-body-md">Job Management</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="settings.php">
                <span class="material-symbols-outlined" data-icon="settings">settings</span>
                <span class="font-body-md text-body-md">Settings</span>
            </a>
        </nav>
    </aside>
    <!-- TopAppBar Shell -->
    <header
        class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-surface border-b border-outline-variant flex justify-between items-center px-margin-desktop z-40">
        <div></div>
        <div class="flex items-center gap-md">
            <div class="flex items-center gap-sm">
                <div
                    class="w-10 h-10 rounded-full border-2 border-primary-container bg-primary-fixed flex items-center justify-center text-on-primary-fixed font-bold">
                    <?php echo strtoupper(substr($admin_user['full_name'], 0, 1) . substr(explode(' ', $admin_user['full_name'])[1] ?? '', 0, 1)); ?>
                </div>
                <div class="hidden lg:block text-left">
                    <p class="font-body-md font-bold text-on-surface">
                        <?php echo htmlspecialchars($admin_user['full_name']); ?></p>
                    <p class="font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">System Admin</p>
                </div>
            </div>
            <div class="h-8 w-[1px] bg-outline-variant/30 mx-2"></div>
            <a href="../public/logout.php" class="p-2 text-on-surface-variant hover:bg-surface-container-low transition-colors rounded-full" title="Logout">
                <span class="material-symbols-outlined">logout</span>
            </a>
        </div>
    </header>
    <!-- Main Content Area -->
    <main class="ml-64 flex-1 min-h-screen bg-surface relative flex flex-col">
        <div class="flex-1 p-margin-desktop space-y-xl pt-16">
            <!-- Page Header Section -->
            <div class="flex justify-between items-end">
                <div>
                    <h2 class="font-headline-lg text-headline-lg text-on-surface mb-1">Job Management</h2>
                    <p class="text-on-surface-variant font-body-md text-body-md">Oversee, track, and manage all active job vacancies
                        across the platform.</p>
                </div>
            </div>
            <!-- Metrics Bento Grid -->
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-gutter">
                <!-- Total Active Jobs -->
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm flex flex-col justify-between hover:border-primary transition-colors">
                    <div class="flex justify-between items-start mb-sm">
                        <div class="p-3 bg-primary/10 rounded-lg text-primary">
                            <span class="material-symbols-outlined">work</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Total Active Jobs</p>
                        <h3 class="text-display font-display text-[32px] font-extrabold text-on-surface mt-1">
                            <?php echo number_format($total_jobs); ?></h3>
                    </div>
                </div>
                <!-- New Postings (Today) -->
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm flex flex-col justify-between hover:border-primary transition-colors">
                    <div class="flex justify-between items-start mb-sm">
                        <div class="p-3 bg-secondary-container rounded-lg text-secondary">
                            <span class="material-symbols-outlined">new_releases</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">New Postings (Today)</p>
                        <h3 class="text-display font-display text-[32px] font-extrabold text-on-surface mt-1">
                            <?php echo number_format($new_today); ?></h3>
                    </div>
                </div>
                <!-- Pending Approval -->
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm flex flex-col justify-between hover:border-primary transition-colors">
                    <div class="flex justify-between items-start mb-sm">
                        <div class="p-3 bg-tertiary-fixed rounded-lg text-tertiary">
                            <span class="material-symbols-outlined">pending_actions</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Pending Approval</p>
                        <h3 class="text-display font-display text-[32px] font-extrabold text-on-surface mt-1">0</h3>
                    </div>
                </div>
                <!-- Expiring Soon -->
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm flex flex-col justify-between hover:border-primary transition-colors">
                    <div class="flex justify-between items-start mb-sm">
                        <div class="p-3 bg-error-container rounded-lg text-error">
                            <span class="material-symbols-outlined">timer</span>
                        </div>
                    </div>
                    <div>
                        <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Expiring Soon</p>
                        <h3 class="text-display font-display text-[32px] font-extrabold text-on-surface mt-1">0</h3>
                    </div>
                </div>
            </section>
            <!-- Table Controls -->
            <div
                class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm flex flex-wrap items-center justify-between gap-4">
                <div class="flex gap-3 items-center">
                    <div class="relative">
                        <select onchange="window.location.href='?location=' + this.value"
                            class="appearance-none pl-4 pr-10 py-2 bg-white border border-outline-variant rounded-lg text-body-md font-body-md focus:ring-primary focus:border-primary cursor-pointer">
                            <option value="">All Locations</option>
                            <?php foreach ($locations as $location): ?>
                                <option value="<?php echo htmlspecialchars($location); ?>" <?php echo ($selected_location === $location) ? 'selected' : ''; ?>>
                                    <?php echo htmlspecialchars($location); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <span
                            class="material-symbols-outlined absolute right-3 top-2.5 text-on-surface-variant pointer-events-none text-sm">expand_more</span>
                    </div>
                    <a href="manage_jobs.php"
                        class="px-4 py-2 text-primary font-label-md text-label-md font-bold hover:bg-primary/5 rounded-lg transition-all">Clear
                        Filters</a>
                </div>
                <form method="get" class="relative w-72">
                    <input type="hidden" name="location" value="<?php echo htmlspecialchars($selected_location); ?>">
                    <span
                        class="material-symbols-outlined absolute left-3 top-2.5 text-on-surface-variant text-sm">search</span>
                    <input
                        name="search"
                        class="pl-10 pr-4 py-2 w-full border border-outline-variant rounded-lg text-body-md font-body-md focus:ring-primary focus:border-primary"
                        placeholder="Search Jobs..." type="text" value="<?php echo htmlspecialchars($search_query); ?>" onchange="this.form.submit()">
                </form>
            </div>
            <!-- Data Table Section -->
            <div class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden flex flex-col">
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse font-body-md">
                        <thead class="bg-surface-container-low/50 border-b border-outline-variant/20">
                            <tr>
                                <th class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Job Title</th>
                                <th class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Company</th>
                                <th class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Category</th>
                                <th class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Date Posted</th>
                                <th class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-center">Applications</th>
                                <th class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider">Status</th>
                                <th class="px-lg py-4 font-label-md text-label-md text-on-surface-variant uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-outline-variant/10">
                            <?php if ($jobs_result && $jobs_result->num_rows > 0):
                                while ($job = $jobs_result->fetch_assoc()):
                                    $category = !empty($job['required_skills']) ? explode(',', $job['required_skills'])[0] : 'General';
                                    $date_posted = date('M d, Y', strtotime($job['created_at']));
                                    $applications_count = $job['applications_count'] ?? 0;
                                    ?>
                                    <tr class="hover:bg-surface-container-low/30 transition-colors">
                                        <td class="px-lg py-4">
                                            <p class="font-bold text-on-surface"><?php echo htmlspecialchars($job['title']); ?></p>
                                            <p class="text-xs text-on-surface-variant"><?php echo htmlspecialchars($job['location']); ?></p>
                                        </td>
                                        <td class="px-lg py-4">
                                            <div class="flex items-center space-x-3">
                                                <div
                                                    class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-sm font-medium">
                                                    <?php echo strtoupper(substr($job['recruiter_name'] ?? 'N', 0, 1)); ?>
                                                </div>
                                                <span
                                                    class="text-sm font-medium"><?php echo htmlspecialchars($job['recruiter_name'] ?? 'Unknown'); ?></span>
                                            </div>
                                        </td>
                                        <td class="px-lg py-4">
                                            <span
                                                class="bg-surface-container text-on-secondary-container px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider"><?php echo htmlspecialchars($category); ?></span>
                                        </td>
                                        <td class="px-lg py-4 text-sm text-on-surface-variant"><?php echo $date_posted; ?></td>
                                        <td class="px-lg py-4 text-center">
                                            <span
                                                class="font-bold text-primary"><?php echo number_format($applications_count); ?></span>
                                        </td>
                                        <td class="px-lg py-4">
                                            <span
                                                class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                            </span>
                                        </td>
                                        <td class="px-lg py-4 text-right">
                                            <div class="flex items-center justify-end space-x-2">
                                                <a href="view_job.php?id=<?php echo $job['job_id']; ?>"
                                                    class="p-1.5 hover:text-primary transition-colors" title="View"><span
                                                        class="material-symbols-outlined text-[20px]">visibility</span></a>
                                                <a href="edit_job.php?id=<?php echo $job['job_id']; ?>"
                                                    class="p-1.5 hover:text-primary transition-colors" title="Edit"><span
                                                        class="material-symbols-outlined text-[20px]">edit</span></a>
                                                <a href="#"
                                                    onclick="if(confirm('Delete this job?')){ window.location='delete_job.php?id=<?php echo $job['job_id']; ?>'; } return false;"
                                                    class="p-1.5 hover:text-error transition-colors" title="Delete"><span
                                                        class="material-symbols-outlined text-[20px]">delete</span></a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                endwhile;
                            else:
                                echo '<tr><td colspan="7" class="px-lg py-8 text-center text-on-surface-variant">No jobs found.</td></tr>';
                            endif;
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- Pagination -->
                <div class="px-lg py-4 bg-surface-container-lowest border-t border-outline-variant/20 flex items-center justify-between">
                    <?php
                    $total = $total_matching_jobs;
                    $start = ($total > 0) ? $offset + 1 : 0;
                    $end = ($total > 0) ? min($offset + $per_page, $total) : 0;
                    $last_page = ($per_page > 0) ? (int) ceil($total / $per_page) : 1;
                    $base_params = [];
                    if (!empty($selected_location)) $base_params['location'] = $selected_location;
                    if (!empty($search_query)) $base_params['search'] = $search_query;
                    $build_url = function($page_num) use ($base_params) {
                        $params = $base_params;
                        $params['page'] = $page_num;
                        return 'manage_jobs.php?' . http_build_query($params);
                    };
                    ?>
                    <p class="font-label-md text-label-md text-on-surface-variant">Showing <?php echo $start; ?>–<?php echo $end; ?> of <?php echo number_format($total); ?> postings</p>
                    <div class="flex items-center gap-1">
                        <a href="<?php echo ($page > 1) ? $build_url($page - 1) : '#'; ?>" class="p-2 border border-outline-variant rounded-md hover:bg-surface-container-low disabled:opacity-50 transition-all <?php echo ($page <= 1) ? 'opacity-50 pointer-events-none' : ''; ?>">
                            <span class="material-symbols-outlined text-sm">chevron_left</span>
                        </a>
                        <a href="<?php echo $build_url(1); ?>" class="px-3 py-1 <?php echo ($page == 1) ? 'bg-primary text-white rounded-md' : 'hover:bg-surface-container-low rounded-md'; ?> font-label-md text-label-md">1</a>
                        <?php if ($page > 2): ?>
                            <span class="px-2 text-on-surface-variant">...</span>
                        <?php endif; ?>
                        <?php if ($page > 1): ?>
                            <a href="<?php echo $build_url($page); ?>" class="px-3 py-1 bg-primary text-white rounded-md font-label-md text-label-md"><?php echo $page; ?></a>
                        <?php endif; ?>
                        <?php if ($page < $last_page - 1): ?>
                            <span class="px-2 text-on-surface-variant">...</span>
                        <?php endif; ?>
                        <a href="<?php echo $build_url($last_page); ?>" class="px-3 py-1 hover:bg-surface-container-low rounded-md font-label-md text-label-md text-on-surface-variant"><?php echo $last_page; ?></a>
                        <a href="<?php echo ($page < $last_page) ? $build_url($page + 1) : '#'; ?>" class="p-2 border border-outline-variant rounded-md hover:bg-surface-container-low transition-all <?php echo ($page >= $last_page) ? 'opacity-50 pointer-events-none' : ''; ?>">
                            <span class="material-symbols-outlined text-sm">chevron_right</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Standard Footer -->
        <footer
            class="mt-auto px-margin-desktop py-lg border-t border-outline-variant bg-surface flex justify-between items-center text-[10px] text-on-surface-variant uppercase tracking-widest font-bold">
            <p class="">© 2024 Job Portal. All rights reserved.</p>
            <div class="flex gap-lg">
                <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="hover:text-primary transition-colors" href="#">Security Audit</a>
                <a class="hover:text-primary transition-colors" href="#">Support Desk</a>
            </div>
        </footer>
    </main>
    <script>
        // Simple micro-interaction for dropdowns and interactive elements
        document.querySelectorAll('select').forEach(select => {
            select.addEventListener('change', function () {
                this.parentElement.classList.add('ring-2', 'ring-primary/20');
                setTimeout(() => {
                    this.parentElement.classList.remove('ring-2', 'ring-primary/20');
                }, 1000);
            });
        });
    </script>
</body>

</html>