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

// Fetch job statistics
$total_jobs = $conn->query("SELECT COUNT(*) as count FROM jobs")->fetch_assoc()['count'];
$new_today = $conn->query("SELECT COUNT(*) as count FROM jobs WHERE DATE(created_at) = CURDATE()")->fetch_assoc()['count'];

// Fetch all jobs
$jobs_query = $conn->query("
    SELECT j.job_id, j.title, j.description, j.required_skills, u.full_name as recruiter_name, j.location, j.salary, 
           j.created_at, COUNT(a.application_id) as applications_count
    FROM jobs j
    LEFT JOIN users u ON j.recruiter_id = u.user_id
    LEFT JOIN applications a ON j.job_id = a.job_id
    GROUP BY j.job_id
    ORDER BY j.created_at DESC
");
$jobs_result = $jobs_query;
?>
<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>RecruitFlow Admin - Job Management</title>
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
            background-color: #f8f9ff;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .sidebar-active {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="text-on-surface">
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
        class="flex justify-between items-center h-16 w-full pl-72 pr-10 z-40 bg-white fixed top-0 border-b border-outline-variant dark:border-outline">
        <div class="flex items-center flex-1 max-w-xl">
            <div class="relative w-full">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                <input
                    class="w-full pl-10 pr-4 py-2 bg-surface-container-low border-none rounded-lg focus:ring-2 focus:ring-primary/20 text-body-md"
                    placeholder="Search job titles, companies, or categories..." type="text" />
            </div>
        </div>
        <div class="flex items-center space-x-6">
            <div class="flex items-center space-x-3 ml-4">
                <div
                    class="w-10 h-10 rounded-full border-2 border-primary-container bg-primary-fixed flex items-center justify-center text-on-primary-fixed font-bold">
                    <?php echo strtoupper(substr($admin_user['full_name'], 0, 1) . substr(explode(' ', $admin_user['full_name'])[1] ?? '', 0, 1)); ?>
                </div>
                <div class="text-left">
                    <p class="font-title-md text-sm font-bold text-on-surface leading-tight">
                        <?php echo htmlspecialchars($admin_user['full_name']); ?></p>
                    <p class="text-[10px] text-outline uppercase tracking-wider">System Admin</p>
                </div>
            </div>
        </div>
    </header>
    <!-- Main Content Area -->
    <main class="pl-64 pt-16 min-h-screen">
        <div class="p-10 max-w-[1600px] mx-auto space-y-8">
            <!-- Page Header Section -->
            <div class="flex justify-between items-end">
                <div>
                    <h2 class="font-headline-lg text-headline-lg text-on-surface mb-1">Job Management</h2>
                    <p class="text-on-surface-variant font-body-lg">Oversee, track, and manage all active job vacancies
                        across the platform.</p>
                </div>
            </div>
            <!-- Metrics Bento Grid -->
            <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Total Active Jobs -->
                <div
                    class="bg-white p-6 rounded-xl border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-primary/10 rounded-lg text-primary">
                            <span class="material-symbols-outlined">work</span>
                        </div>
                    </div>
                    <p class="text-outline text-label-md uppercase tracking-widest font-bold">Total Active Jobs</p>
                    <h3 class="text-display text-4xl font-black text-on-surface mt-1">
                        <?php echo number_format($total_jobs); ?></h3>
                </div>
                <!-- New Postings (Today) -->
                <div
                    class="bg-white p-6 rounded-xl border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-secondary-container rounded-lg text-secondary">
                            <span class="material-symbols-outlined">new_releases</span>
                        </div>
                    </div>
                    <p class="text-outline text-label-md uppercase tracking-widest font-bold">New Postings (Today)</p>
                    <h3 class="text-display text-4xl font-black text-on-surface mt-1">
                        <?php echo number_format($new_today); ?></h3>
                </div>
                <!-- Pending Approval -->
                <div
                    class="bg-white p-6 rounded-xl border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-tertiary-fixed rounded-lg text-tertiary">
                            <span class="material-symbols-outlined">pending_actions</span>
                        </div>
                    </div>
                    <p class="text-outline text-label-md uppercase tracking-widest font-bold">Pending Approval</p>
                    <h3 class="text-display text-4xl font-black text-on-surface mt-1">0</h3>
                </div>
                <!-- Expiring Soon -->
                <div
                    class="bg-white p-6 rounded-xl border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-3 bg-error-container rounded-lg text-error">
                            <span class="material-symbols-outlined">timer</span>
                        </div>
                    </div>
                    <p class="text-outline text-label-md uppercase tracking-widest font-bold">Expiring Soon</p>
                    <h3 class="text-display text-4xl font-black text-on-surface mt-1">0</h3>
                </div>
            </section>
            <!-- Table Controls -->
            <div
                class="bg-white p-6 rounded-xl border border-outline-variant shadow-sm flex flex-wrap items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                </div>
                <div class="flex items-center space-x-2">
                </div>
            </div>
            <!-- Data Table Section -->
            <div class="bg-white rounded-xl border border-outline-variant shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-outline-variant">
                            <th class="px-6 py-4 font-bold text-xs uppercase text-outline tracking-wider">Job Title</th>
                            <th class="px-6 py-4 font-bold text-xs uppercase text-outline tracking-wider">Company</th>
                            <th class="px-6 py-4 font-bold text-xs uppercase text-outline tracking-wider">Category</th>
                            <th class="px-6 py-4 font-bold text-xs uppercase text-outline tracking-wider">Date Posted
                            </th>
                            <th class="px-6 py-4 font-bold text-xs uppercase text-outline tracking-wider text-center">
                                Applications</th>
                            <th class="px-6 py-4 font-bold text-xs uppercase text-outline tracking-wider">Status</th>
                            <th class="px-6 py-4 font-bold text-xs uppercase text-outline tracking-wider text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        <?php if ($jobs_result && $jobs_result->num_rows > 0):
                            while ($job = $jobs_result->fetch_assoc()):
                                $category = !empty($job['required_skills']) ? explode(',', $job['required_skills'])[0] : 'General';
                                $date_posted = date('M d, Y', strtotime($job['created_at']));
                                $applications_count = $job['applications_count'] ?? 0;
                                ?>
                                <tr class="hover:bg-surface-container-lowest transition-colors group">
                                    <td class="px-6 py-5">
                                        <p class="font-bold text-on-surface"><?php echo htmlspecialchars($job['title']); ?></p>
                                        <p class="text-xs text-outline"><?php echo htmlspecialchars($job['location']); ?></p>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center space-x-3">
                                            <div
                                                class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-sm font-medium">
                                                <?php echo strtoupper(substr($job['recruiter_name'] ?? 'N', 0, 1)); ?>
                                            </div>
                                            <span
                                                class="text-sm font-medium"><?php echo htmlspecialchars($job['recruiter_name'] ?? 'Unknown'); ?></span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-5">
                                        <span
                                            class="bg-surface-container text-on-secondary-container px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider"><?php echo htmlspecialchars($category); ?></span>
                                    </td>
                                    <td class="px-6 py-5 text-sm text-on-surface-variant"><?php echo $date_posted; ?></td>
                                    <td class="px-6 py-5 text-center">
                                        <span
                                            class="font-bold text-primary"><?php echo number_format($applications_count); ?></span>
                                    </td>
                                    <td class="px-6 py-5">
                                        <div class="flex items-center text-green-600 font-bold text-xs">
                                            <span class="w-2 h-2 rounded-full bg-green-500 mr-2"></span>
                                            Active
                                        </div>
                                    </td>
                                    <td class="px-6 py-5 text-right">
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
                            echo '<tr><td colspan="7" class="px-6 py-8 text-center text-on-surface-variant">No jobs found.</td></tr>';
                        endif;
                        ?>
                    </tbody>
                </table>
                <!-- Pagination -->
                <div
                    class="px-6 py-4 bg-surface-container-low flex justify-between items-center border-t border-outline-variant">
                    <p class="text-xs font-medium text-on-surface-variant">Showing <span class="font-bold">1</span> to
                        <span class="font-bold">4</span> of <span class="font-bold">1,284</span> postings
                    </p>
                    <div class="flex space-x-1">
                        <button
                            class="px-3 py-1 border border-outline-variant rounded bg-white text-xs font-bold hover:bg-surface-container transition-all">Previous</button>
                        <button
                            class="px-3 py-1 border border-primary rounded bg-primary text-white text-xs font-bold">1</button>
                        <button
                            class="px-3 py-1 border border-outline-variant rounded bg-white text-xs font-bold hover:bg-surface-container transition-all">2</button>
                        <button
                            class="px-3 py-1 border border-outline-variant rounded bg-white text-xs font-bold hover:bg-surface-container transition-all">3</button>
                        <span class="px-2 py-1 text-xs">...</span>
                        <button
                            class="px-3 py-1 border border-outline-variant rounded bg-white text-xs font-bold hover:bg-surface-container transition-all">128</button>
                        <button
                            class="px-3 py-1 border border-outline-variant rounded bg-white text-xs font-bold hover:bg-surface-container transition-all">Next</button>
                    </div>
                </div>
            </div>
        </div>
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