<!DOCTYPE html>

<html class="scroll-smooth" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Job Portal - Find Your Dream Job Today</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "on-surface": "#0b1c30",
                        "on-primary-fixed-variant": "#3323cc",
                        "surface": "#f8f9ff",
                        "on-secondary-fixed-variant": "#3f465c",
                        "on-error": "#ffffff",
                        "on-tertiary": "#ffffff",
                        "on-tertiary-container": "#ffd2be",
                        "outline": "#777587",
                        "primary-container": "#4f46e5",
                        "on-secondary-fixed": "#131b2e",
                        "on-tertiary-fixed-variant": "#7b2f00",
                        "error": "#ba1a1a",
                        "secondary-container": "#dae2fd",
                        "surface-container": "#e5eeff",
                        "on-primary-container": "#dad7ff",
                        "surface-container-low": "#eff4ff",
                        "on-background": "#0f172a",
                        "on-tertiary-fixed": "#351000",
                        "secondary": "#475569",
                        "secondary-fixed": "#dae2fd",
                        "surface-tint": "#4f46e5",
                        "on-secondary": "#ffffff",
                        "primary-fixed-dim": "#c3c0ff",
                        "surface-bright": "#f8f9ff",
                        "inverse-on-surface": "#eaf1ff",
                        "on-surface-variant": "#475569",
                        "inverse-surface": "#0f172a",
                        "error-container": "#ffdad6",
                        "primary-fixed": "#e2dfff",
                        "on-primary-fixed": "#0f0069",
                        "surface-container-highest": "#d3e4fe",
                        "tertiary-fixed": "#ffdbcc",
                        "surface-container-high": "#dce9ff",
                        "on-secondary-container": "#5c647a",
                        "tertiary-fixed-dim": "#ffb695",
                        "surface-dim": "#cbdbf5",
                        "outline-variant": "#cbd5e1",
                        "on-primary": "#ffffff",
                        "background": "#f8f9ff",
                        "surface-variant": "#d3e4fe",
                        "inverse-primary": "#c3c0ff",
                        "on-error-container": "#93000a",
                        "tertiary": "#7e3000",
                        "secondary-fixed-dim": "#bec6e0",
                        "primary": "#4f46e5",
                        "surface-container-lowest": "#ffffff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "container-max": "1280px",
                        "unit-xs": "0.25rem",
                        "unit-sm": "0.5rem",
                        "margin-desktop": "2rem",
                        "unit-lg": "1.5rem",
                        "unit-md": "1rem",
                        "gutter": "1.5rem",
                        "unit-xl": "2rem",
                        "margin-mobile": "1rem"
                    },
                    "fontFamily": {
                        "display-lg": ["Inter"],
                        "body-lg": ["Inter"],
                        "label-sm": ["Inter"],
                        "body-md": ["Inter"],
                        "headline-md": ["Inter"],
                        "headline-lg": ["Inter"],
                        "label-md": ["Inter"],
                        "body-sm": ["Inter"]
                    },
                    "fontSize": {
                        "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "label-sm": ["12px", { "lineHeight": "16px", "fontWeight": "500" }],
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "fontWeight": "600" }],
                        "headline-lg": ["30px", { "lineHeight": "38px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "label-md": ["14px", { "lineHeight": "20px", "letterSpacing": "0.05em", "fontWeight": "600" }],
                        "body-sm": ["14px", { "lineHeight": "20px", "fontWeight": "400" }]
                    }
                }
            }
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .kinetic-bg {
            background: radial-gradient(circle at 10% 20%, rgba(79, 70, 229, 0.08) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(15, 23, 42, 0.03) 0%, transparent 40%);
        }

        .hero-reveal {
            animation: reveal 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        @keyframes reveal {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body class="bg-background text-on-background font-body-md antialiased">
    <!-- TopNavBar -->
    <header class="w-full top-0 bg-surface border-b border-outline-variant shadow-sm sticky z-50">
        <div class="flex justify-between items-center max-w-container-max mx-auto px-margin-desktop py-unit-md">
            <div class="flex items-center gap-unit-xl">
                <a href="index.php" class="flex items-center gap-3 shrink-0">
                    <img src="../assets/images/Job1.png" alt="" class="w-11 h-11 shrink-0 rounded-[10px] object-cover">
                    <div class="flex flex-col justify-center leading-none gap-0.5">
                        <span class="text-[10px] font-bold text-on-surface-variant tracking-[0.18em] uppercase">Job</span>
                        <span class="text-[22px] font-black text-primary uppercase tracking-tight leading-none">Portal</span>
                    </div>
                </a>

                <nav class="hidden md:flex items-center gap-unit-lg">
                    <a class="font-body-md text-body-md text-primary font-bold border-b-2 border-primary pb-1"
                        href="#">Jobs</a>
                    <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors"
                        href="#">Companies</a>
                    <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors"
                        href="#">Salaries</a>
                    <a class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors"
                        href="#">Resources</a>
                </nav>
            </div>
            <div class="flex items-center gap-unit-md">
                <a href="login.php"
                    class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors active:scale-95 transition-transform px-unit-md py-unit-sm">Sign
                    In</a>
                <a href="register.php"
                    class="bg-primary text-white px-unit-lg py-unit-sm rounded-lg font-label-md hover:shadow-md transition-all active:scale-95 inline-block">Sign
                    Up</a>
            </div>
        </div>
    </header>
    <main>
        <!-- Hero Section -->
        <section class="relative kinetic-bg py-unit-xl md:py-32 overflow-hidden">
            <div class="max-w-container-max mx-auto px-margin-desktop relative z-10">
                <div class="flex flex-col items-center text-center max-w-3xl mx-auto hero-reveal"
                    style="animation-delay: 0.1s;">
                    <span
                        class="inline-block py-1 px-3 mb-unit-md bg-primary/10 text-primary rounded-full font-label-sm uppercase tracking-wider">The
                        Future of Talent</span>
                    <h1 class="font-display-lg text-display-lg text-on-background mb-unit-lg leading-tight">Find Your
                        Dream Job Today</h1>
                    <p class="font-body-lg text-body-lg text-on-surface-variant mb-unit-xl">Discover thousands of job
                        opportunities from top companies around the world</p>
                    <!-- Search Bar Interface -->
                    <div
                        class="w-full bg-surface p-unit-sm rounded-xl shadow-lg border border-outline-variant flex flex-col md:flex-row gap-unit-sm">
                        <div
                            class="flex-1 flex items-center px-unit-md border-b md:border-b-0 md:border-r border-outline-variant">
                            <span class="material-symbols-outlined text-primary mr-unit-sm"
                                data-icon="search">search</span>
                            <input
                                class="w-full border-none focus:ring-0 bg-transparent text-body-md py-3 text-on-background"
                                placeholder="Job title, keywords, or company" type="text" />
                        </div>
                        <div class="flex-1 flex items-center px-unit-md">
                            <span class="material-symbols-outlined text-primary mr-unit-sm"
                                data-icon="location_on">location_on</span>
                            <input
                                class="w-full border-none focus:ring-0 bg-transparent text-body-md py-3 text-on-background"
                                placeholder="City, state, or remote" type="text" />
                        </div>
                        <button
                            class="bg-primary text-white px-unit-xl py-3 rounded-lg font-label-md hover:brightness-110 transition-all shadow-sm">Browse
                            Jobs</button>
                    </div>
                </div>
            </div>
            <!-- Atmospheric background elements -->
            <div
                class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-96 h-96 bg-primary opacity-10 blur-[120px] rounded-full">
            </div>
            <div
                class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/4 w-96 h-96 bg-inverse-surface opacity-5 blur-[120px] rounded-full">
            </div>
        </section>

        <!-- Featured Opportunities -->
        <section class="py-unit-xl bg-background">
            <div class="max-w-container-max mx-auto px-margin-desktop">
                <div class="flex justify-between items-end mb-unit-xl">
                    <div>
                        <h2 class="font-headline-lg text-headline-lg text-on-background mb-unit-xs">Available Jobs</h2>
                        <p class="font-body-md text-on-surface-variant">Latest job opportunities from top companies</p>
                    </div>
                    <a class="text-primary font-label-md hover:underline flex items-center gap-1 group" href="#">
                        View all jobs <span
                            class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform"
                            data-icon="arrow_forward">arrow_forward</span>
                    </a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-unit-lg">
                    <?php
                    // Include database connection
                    include '../../backend/config/db.php';

                    // Query to fetch jobs with recruiter details
                    $query = "SELECT j.job_id, j.title, j.experience_required, j.salary, j.location, u.full_name 
              FROM jobs j 
              JOIN users u ON j.recruiter_id = u.user_id 
              LIMIT 6";

                    $result = $conn->query($query);
                    $cardCount = 0;

                    if ($result && $result->num_rows > 0) {
                        while ($job = $result->fetch_assoc()) {
                            $cardCount++;
                            $isNew = $cardCount == 1 ? 'New' : '';
                            $isUrgent = $cardCount == 5 ? 'Urgent' : '';
                            $badgeClass = !empty($isNew) ? 'New' : (!empty($isUrgent) ? 'Urgent' : '');
                            $badgeHTML = '';

                            if (!empty($isNew)) {
                                $badgeHTML = '<span class="bg-primary text-white px-2 py-1 rounded text-xs font-bold">New</span>';
                            } elseif (!empty($isUrgent)) {
                                $badgeHTML = '<span class="bg-inverse-surface text-white px-2 py-1 rounded text-xs font-bold">Urgent</span>';
                            }

                            $icons = ['rocket_launch', 'cloud', 'data_object', 'security', 'psychology', 'store'];
                            $icon = $icons[$cardCount - 1] ?? 'work';

                            echo '<div class="bg-surface p-unit-lg rounded-xl shadow-sm border border-outline-variant hover:-translate-y-1 hover:shadow-md transition-all group">
                <div class="flex justify-between items-start mb-unit-md">
                    <div class="w-12 h-12 rounded-lg bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-3xl" data-icon="' . $icon . '">' . $icon . '</span>
                    </div>
                    ' . $badgeHTML . '
                </div>
                <h3 class="font-headline-md text-headline-md text-on-background mb-1 group-hover:text-primary transition-colors">' . htmlspecialchars($job['title']) . '</h3>
                <p class="text-primary font-label-md mb-unit-md">' . htmlspecialchars($job['full_name']) . '</p>
                <div class="flex flex-wrap gap-unit-sm mb-unit-lg">
                    <div class="flex items-center gap-1 text-on-surface-variant font-body-sm">
                        <span class="material-symbols-outlined text-sm text-primary" data-icon="location_on">location_on</span> ' . htmlspecialchars($job['location']) . '
                    </div>
                    <div class="flex items-center gap-1 text-on-surface-variant font-body-sm">
                        <span class="material-symbols-outlined text-sm text-primary" data-icon="payments">payments</span> ' . htmlspecialchars($job['salary']) . '
                    </div>
                </div>
                <a href="register.php" class="w-full py-unit-sm border border-primary text-primary rounded-lg font-label-md hover:bg-primary hover:text-white transition-colors inline-block text-center">Apply Now</a>
            </div>';
                        }
                    } else {
                        echo '<p class="col-span-full text-center text-on-surface-variant">No jobs available at the moment.</p>';
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
        </section>

    <!-- Footer -->
    <footer class="w-full bottom-0 bg-inverse-surface py-unit-xl text-white">
        <div
            class="flex flex-col md:flex-row justify-between items-center max-w-container-max mx-auto px-margin-desktop gap-unit-lg">
            <div class="flex flex-col items-center md:items-start">
                <a href="index.php" class="flex items-center gap-3 mb-2">
                    <img src="../assets/images/Job1.png" alt="" class="w-10 h-10 shrink-0 rounded-[10px] object-cover">
                    <div class="flex flex-col justify-center leading-none gap-0.5">
                        <span class="text-[9px] font-bold text-white/80 tracking-[0.18em] uppercase">Job</span>
                        <span class="text-lg font-black text-white uppercase tracking-tight leading-none">Portal</span>
                    </div>
                </a>

                <p class="font-body-sm text-white/60 max-w-xs text-center md:text-left">© 2026. All rights reserved.</p>
            </div>
            <nav class="flex flex-wrap justify-center gap-unit-lg">
                <a class="font-body-sm text-white/80 hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="font-body-sm text-white/80 hover:text-primary transition-colors" href="#">Terms of Service</a>
                <a class="font-body-sm text-white/80 hover:text-primary transition-colors" href="#">Cookie Policy</a>
                <a class="font-body-sm text-white/80 hover:text-primary transition-colors" href="#">Support</a>
                <a class="font-body-sm text-white/80 hover:text-primary transition-colors" href="#">Accessibility</a>
            </nav>
            <div class="flex gap-unit-md">
                <a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-primary transition-all"
                    href="#">
                    <span class="material-symbols-outlined" data-icon="public">public</span>
                </a>
                <a class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center text-white hover:bg-primary transition-all"
                    href="#">
                    <span class="material-symbols-outlined" data-icon="share">share</span>
                </a>
            </div>
        </div>
    </footer>
    <script>
        // Intersection Observer for scroll animations
        const observerOptions = {
            threshold: 0.1
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('hero-reveal');
                    entry.target.style.opacity = '1';
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        document.querySelectorAll('section > div').forEach(div => {
            div.style.opacity = '0';
            observer.observe(div);
        });
    </script>
</body>

</html>