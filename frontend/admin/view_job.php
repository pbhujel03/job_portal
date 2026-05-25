<?php
require_once '../../backend/config/db.php';
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../public/login.php');
    exit;
}

$admin_user = null;
if ($_SESSION['user_id'] == 0) {
    $admin_user = array('user_id' => 0, 'full_name' => $_SESSION['name'] ?? 'System Administrator', 'email' => 'admin@jobportal.com', 'role' => 'admin');
} else {
    $admin_result = $conn->query("SELECT * FROM users WHERE user_id = " . intval($_SESSION['user_id']) . " AND role = 'admin'");
    $admin_user = $admin_result->fetch_assoc();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manage_jobs.php');
    exit;
}

$job_id = intval($_GET['id']);
$stmt = $conn->prepare("SELECT j.*, u.full_name as recruiter_name FROM jobs j LEFT JOIN users u ON j.recruiter_id = u.user_id WHERE j.job_id = ?");
$stmt->bind_param('i', $job_id);
$stmt->execute();
$res = $stmt->get_result();
$job = $res->fetch_assoc();
$stmt->close();

if (!$job) {
    header('Location: manage_jobs.php');
    exit;
}
?>
<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>View Job | RecruitFlow</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin-sidebar-brand.css">

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet">
    <script id="tailwind-config">tailwind.config={darkMode:"class",theme:{extend:{"colors":{"on-primary-fixed":"#0f0069","inverse-on-surface":"#eaf1ff","secondary-container":"#dae2fd","secondary":"#565e74","on-tertiary-fixed-variant":"#7b2f00","on-error":"#ffffff","surface-variant":"#d3e4fe","on-secondary-fixed-variant":"#3f465c","primary-fixed":"#e2dfff","on-secondary":"#ffffff","surface":"#f8f9ff","surface-tint":"#4d44e3","error":"#ba1a1a","tertiary":"#7e3000","primary-container":"#4f46e5","on-surface-variant":"#464555","on-primary":"#ffffff","inverse-surface":"#213145","tertiary-fixed":"#ffdbcc","on-primary-fixed-variant":"#3323cc","on-primary-container":"#dad7ff","surface-container-high":"#dce9ff","on-background":"#0b1c30","primary":"#3525cd","surface-container-lowest":"#ffffff","on-tertiary-container":"#ffd2be","tertiary-container":"#a44100","on-secondary-container":"#5c647a","surface-bright":"#f8f9ff","secondary-fixed-dim":"#bec6e0","on-error-container":"#93000a","surface-container-low":"#eff4ff","on-surface":"#0b1c30","on-tertiary":"#ffffff","secondary-fixed":"#dae2fd","on-tertiary-fixed":"#351000","inverse-primary":"#c3c0ff","surface-container-highest":"#d3e4fe","outline":"#777587","tertiary-fixed-dim":"#ffb695","surface-container":"#e5eeff","on-secondary-fixed":"#131b2e","surface-dim":"#cbdbf5","error-container":"#ffdad6","primary-fixed-dim":"#c3c0ff","outline-variant":"#c7c4d8","background":"#f8f9ff"},"borderRadius":{"DEFAULT":"0.25rem","lg":"0.5rem","xl":"0.75rem","full":"9999px"},"spacing":{"xl":"32px","margin-mobile":"16px","gutter":"24px","lg":"24px","base":"8px","xs":"4px","sm":"8px","margin-desktop":"40px","md":"16px"},"fontFamily":{"body-md":["Inter"],"headline-lg":["Inter"],"display":["Inter"],"body-lg":["Inter"],"label-md":["Inter"],"title-md":["Inter"]},"fontSize":{"body-md":["14px",{"lineHeight":"20px","fontWeight":"400"}],"headline-lg":["32px",{"lineHeight":"40px","letterSpacing":"-0.01em","fontWeight":"600"}],"display":["56px",{"lineHeight":"64px","letterSpacing":"-0.02em","fontWeight":"700"}],"body-lg":["16px",{"lineHeight":"24px","fontWeight":"400"}],"label-md":["12px",{"lineHeight":"16px","letterSpacing":"0.05em","fontWeight":"500"}],"title-md":["20px",{"lineHeight":"28px","fontWeight":"600"}]}}}}</script>
    <style>body{font-family:'Inter',sans-serif}.material-symbols-outlined{font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 24}.custom-scrollbar::-webkit-scrollbar{width:4px}.custom-scrollbar::-webkit-scrollbar-track{background:transparent}.custom-scrollbar::-webkit-scrollbar-thumb{background:#e2e8f0;border-radius:10px}</style>
</head>
<body class="bg-surface text-on-surface min-h-screen flex">
    <aside class="fixed h-full left-0 top-0 w-64 bg-on-secondary-fixed dark:bg-inverse-surface flex flex-col py-lg px-md z-50">
        <a href="dashboard.php" class="admin-sidebar-brand">
            <img src="../assets/images/Job1.png" alt="" class="admin-sidebar-brand__icon">
            <div class="admin-sidebar-brand__text">
                <span class="admin-sidebar-brand__job">Job</span>
                <span class="admin-sidebar-brand__portal">Portal</span>
            </div>
        </a>




        <nav class="flex-1 space-y-xs overflow-y-auto custom-scrollbar">
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg" href="dashboard.php">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-body-md text-body-md">Dashboard</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg" href="manage_users.php">
                <span class="material-symbols-outlined">group</span>
                <span class="font-body-md text-body-md">User Management</span>
            </a>
            <a class="flex items-center gap-md bg-primary-container text-on-primary-container rounded-lg px-md py-base transition-transform active:scale-95" href="manage_jobs.php">
                <span class="material-symbols-outlined">work</span>
                <span class="font-body-md text-body-md">Job Management</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg" href="settings.php">
                <span class="material-symbols-outlined">settings</span>
                <span class="font-body-md text-body-md">Settings</span>
            </a>
        </nav>
    </aside>
    <main class="ml-64 flex-1 min-h-screen bg-surface relative flex flex-col">
        <header class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-surface border-b border-outline-variant flex justify-between items-center px-margin-desktop z-40">
            <div class="flex items-center gap-lg flex-1">
                <div class="relative focus-within:ring-2 focus-within:ring-primary rounded-full bg-surface-container-low transition-all w-full max-w-md">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline">search</span>
                    <input class="w-full bg-transparent border-none focus:ring-0 py-2 pl-10 pr-4 text-body-md" placeholder="Search..." type="text">
                </div>
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
        <div class="flex-1 p-margin-desktop space-y-xl pt-16">
            <div class="space-y-lg">
                <div class="flex justify-between items-center">
                    <div>
                        <h2 class="font-headline-lg text-headline-lg text-on-surface"><?php echo htmlspecialchars($job['title']); ?></h2>
                        <p class="text-on-surface-variant font-body-md text-body-md">View job posting details and information.</p>
                    </div>
                    <div class="flex gap-2">
                        <a href="edit_job.php?id=<?php echo $job['job_id']; ?>" class="bg-primary hover:bg-primary-container text-white px-6 py-3 rounded-lg font-bold flex items-center transition-all shadow-sm">
                            <span class="material-symbols-outlined mr-2">edit</span>Edit Job
                        </a>
                        <a href="manage_jobs.php" class="bg-surface-container hover:bg-surface-container-high text-on-surface px-6 py-3 rounded-lg font-bold transition-all shadow-sm">
                            <span class="material-symbols-outlined">arrow_back</span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-3 gap-lg">
                <div class="col-span-2 bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm space-y-lg">
                    <div>
                        <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-2">Description</p>
                        <p class="font-body-md text-on-surface whitespace-pre-wrap"><?php echo htmlspecialchars($job['description']); ?></p>
                    </div>
                    <div>
                        <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-2">Required Skills</p>
                        <p class="font-body-md text-on-surface"><?php echo htmlspecialchars($job['required_skills']); ?></p>
                    </div>
                </div>
                <div class="space-y-lg">
                    <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm">
                        <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-2">Company</p>
                        <p class="font-body-lg text-on-surface"><?php echo htmlspecialchars($job['recruiter_name'] ?? 'Unknown'); ?></p>
                    </div>
                    <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm">
                        <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-2">Location</p>
                        <p class="font-body-lg text-on-surface"><?php echo htmlspecialchars($job['location']); ?></p>
                    </div>
                    <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm">
                        <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-2">Salary</p>
                        <p class="font-body-lg text-on-surface"><?php echo htmlspecialchars($job['salary'] ?? 'Not specified'); ?></p>
                    </div>
                    <div class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm">
                        <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider mb-2">Posted Date</p>
                        <p class="font-body-lg text-on-surface"><?php echo date('M d, Y', strtotime($job['created_at'])); ?></p>
                    </div>
                </div>
            </div>
        </div>
        <footer class="mt-auto px-margin-desktop py-lg border-t border-outline-variant bg-surface flex justify-between items-center text-[10px] text-on-surface-variant uppercase tracking-widest font-bold">
            <p>© 2024 RecruitFlow Intelligence. All rights reserved.</p>
            <div class="flex gap-lg"><a class="hover:text-primary transition-colors" href="#">Privacy Policy</a><a class="hover:text-primary transition-colors" href="#">Support</a></div>
        </footer>
    </main>
</body>
</html>
