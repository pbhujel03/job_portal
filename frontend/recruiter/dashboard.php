<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>RecruitFlow - AI Recruiter Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface": "#f8f9ff",
                        "secondary-container": "#dae2fd",
                        "surface-tint": "#4d44e3",
                        "on-secondary-container": "#5c647a",
                        "surface-bright": "#f8f9ff",
                        "on-primary": "#ffffff",
                        "on-secondary-fixed": "#131b2e",
                        "inverse-primary": "#c3c0ff",
                        "outline-variant": "#c7c4d8",
                        "on-surface": "#0b1c30",
                        "surface-container-high": "#dce9ff",
                        "on-tertiary": "#ffffff",
                        "inverse-surface": "#213145",
                        "error-container": "#ffdad6",
                        "tertiary": "#7e3000",
                        "surface-container-low": "#eff4ff",
                        "on-surface-variant": "#464555",
                        "error": "#ba1a1a",
                        "surface-container": "#e5eeff",
                        "on-error-container": "#93000a",
                        "surface-container-highest": "#d3e4fe",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-fixed": "#351000",
                        "tertiary-container": "#a44100",
                        "primary-fixed-dim": "#c3c0ff",
                        "on-primary-fixed-variant": "#3323cc",
                        "surface-dim": "#cbdbf5",
                        "on-primary-container": "#dad7ff",
                        "surface-variant": "#d3e4fe",
                        "on-secondary-fixed-variant": "#3f465c",
                        "secondary-fixed-dim": "#bec6e0",
                        "primary-fixed": "#e2dfff",
                        "on-primary-fixed": "#0f0069",
                        "on-error": "#ffffff",
                        "inverse-on-surface": "#eaf1ff",
                        "outline": "#777587",
                        "primary-container": "#4f46e5",
                        "background": "#f8f9ff",
                        "secondary": "#565e74",
                        "tertiary-fixed-dim": "#ffb695",
                        "primary": "#3525cd",
                        "on-tertiary-container": "#ffd2be",
                        "on-tertiary-fixed-variant": "#7b2f00",
                        "secondary-fixed": "#dae2fd",
                        "tertiary-fixed": "#ffdbcc",
                        "on-secondary": "#ffffff",
                        "on-background": "#0b1c30"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "md": "16px",
                        "xl": "32px",
                        "margin-mobile": "16px",
                        "gutter": "24px",
                        "xs": "4px",
                        "base": "8px",
                        "margin-desktop": "40px",
                        "sm": "8px",
                        "lg": "24px"
                    },
                    "fontFamily": {
                        "body-md": ["Inter"],
                        "headline-lg-mobile": ["Inter"],
                        "display": ["Inter"],
                        "title-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "headline-lg": ["Inter"],
                        "label-md": ["Inter"]
                    },
                    "fontSize": {
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "headline-lg-mobile": ["28px", { "lineHeight": "36px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "display": ["56px", { "lineHeight": "64px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "title-md": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500" }]
                    }
                },
            },
        }
    </script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
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

<body class="bg-surface text-on-surface">
    <!-- SideNavBar Shell -->
    <aside
        class="fixed left-0 top-0 h-screen w-64 bg-surface-container-lowest border-r border-outline-variant flex flex-col py-lg px-md z-50">
        <div class="flex items-center gap-sm mb-xl">
            <div class="w-10 h-10 bg-primary-container rounded-lg flex items-center justify-center text-on-primary">
                <span class="material-symbols-outlined">psychology</span>
            </div>
            <div>
                <h1 class="font-title-md text-title-md font-bold text-primary">RecruitFlow</h1>
                <p class="text-[10px] text-on-surface-variant uppercase tracking-widest font-bold">AI Recruiter
                    Dashboard</p>
            </div>
        </div>
        <nav class="flex-1 space-y-1">
            <a class="flex items-center gap-md px-md py-sm rounded-lg text-primary font-bold border-r-4 border-primary bg-primary-container/10 transition-colors duration-200"
                href="#">
                <span class="material-symbols-outlined">dashboard</span>
                <span class="font-body-md text-body-md">Dashboard</span>
            </a>
            <a class="flex items-center gap-md px-md py-sm rounded-lg text-secondary hover:bg-surface-container-low transition-colors duration-200"
                href="#">
                <span class="material-symbols-outlined">add_box</span>
                <span class="font-body-md text-body-md">Post Job</span>
            </a>
            <a class="flex items-center gap-md px-md py-sm rounded-lg text-secondary hover:bg-surface-container-low transition-colors duration-200"
                href="#">
                <span class="material-symbols-outlined">work</span>
                <span class="font-body-md text-body-md">My Jobs</span>
            </a>
            <a class="flex items-center gap-md px-md py-sm rounded-lg text-secondary hover:bg-surface-container-low transition-colors duration-200"
                href="#">
                <span class="material-symbols-outlined">groups</span>
                <span class="font-body-md text-body-md">Applicants</span>
            </a>
            <a class="flex items-center gap-md px-md py-sm rounded-lg text-secondary hover:bg-surface-container-low transition-colors duration-200"
                href="#">
                <span class="material-symbols-outlined">psychology</span>
                <span class="font-body-md text-body-md">AI Analysis</span>
            </a>
            <a class="flex items-center gap-md px-md py-sm rounded-lg text-secondary hover:bg-surface-container-low transition-colors duration-200"
                href="#">
                <span class="material-symbols-outlined">analytics</span>
                <span class="font-body-md text-body-md">Analytics</span>
            </a>
            <a class="flex items-center gap-md px-md py-sm rounded-lg text-secondary hover:bg-surface-container-low transition-colors duration-200"
                href="#">
                <span class="material-symbols-outlined">settings</span>
                <span class="font-body-md text-body-md">Settings</span>
            </a>
        </nav>
        <div class="mt-auto p-md bg-secondary-container rounded-xl">
            <p class="font-label-md text-label-md text-on-secondary-container mb-sm">Ready for more?</p>
            <button
                class="w-full py-sm bg-primary text-on-primary font-bold rounded-lg hover:shadow-lg transition-all active:scale-95">Upgrade
                to Pro</button>
        </div>
    </aside>
    <!-- TopAppBar Shell -->
    <header
        class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-surface/80 backdrop-blur-md border-b border-outline-variant flex justify-between items-center px-lg z-40">
        <div
            class="flex items-center bg-surface-container-low rounded-full px-md py-xs border border-outline-variant w-96">
            <span class="material-symbols-outlined text-outline">search</span>
            <input class="bg-transparent border-none focus:ring-0 text-body-md w-full ml-sm"
                placeholder="Search for candidates, jobs, or tags..." type="text" />
        </div>
        <div class="flex items-center gap-md">
            <button
                class="w-10 h-10 flex items-center justify-center rounded-full hover:bg-surface-container transition-colors relative">
                <span class="material-symbols-outlined text-on-surface-variant">notifications</span>
                <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border border-surface"></span>
            </button>
            <button
                class="flex items-center gap-sm px-md py-sm border border-outline-variant rounded-lg font-label-md text-label-md text-on-surface hover:bg-surface-container transition-colors">
                <span class="material-symbols-outlined text-[18px]">help</span>
                Support
            </button>
            <button
                class="px-lg py-sm bg-primary-container text-on-primary-container font-bold rounded-lg text-body-md hover:shadow-md transition-all active:scale-95">
                Create Job
            </button>
            <div class="h-10 w-10 rounded-full overflow-hidden border-2 border-primary-container p-[2px]">
                <img alt="Recruiter Profile" class="w-full h-full object-cover rounded-full"
                    data-alt="A professional headshot of a recruitment specialist for a modern tech firm, showing a friendly and confident expression. The lighting is bright and clean, typical of high-end corporate photography, with a soft-focus office background that includes hints of architectural wood and glass. The visual style is premium and professional."
                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBt1_iMHQJAsifO1Y9yqk2PH_gk3O1d8Bhic2JaCjW3AvrnFdzmiz4l6TiicrdDwWHdVpMSVwjp8al-0PfK1QBGkWQ5_YrP0AITo2d4xcVMan4q_JIVt1wUo7vIugxwUptT8Y0ezEtPF9ZqcAz96AuH1a3lDtmWyMdKkx14QqoBb-Oe_8EXgYZsfcfkzqqm_sS_682BXG3sXP8paltJv27GCdbtuozJln09xmHZxq0cAC-PWgDg4cFHPQ22EX2fYiSxbYtk_-cvFfw" />
            </div>
        </div>
    </header>
    <!-- Main Content Canvas -->
    <main class="ml-64 pt-16 min-h-screen p-lg space-y-xl">
        <!-- Summary Cards Section -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-lg">
            <div
                class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-sm">
                    <span
                        class="p-sm bg-primary-container/10 text-primary rounded-lg material-symbols-outlined">work</span>
                    <span
                        class="text-green-600 bg-green-50 px-sm py-1 rounded text-[12px] font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">trending_up</span> +12%
                    </span>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Total Jobs</h3>
                <p class="font-display text-[32px] font-bold text-on-surface">24</p>
            </div>
            <div
                class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-sm">
                    <span
                        class="p-sm bg-secondary-container/20 text-secondary rounded-lg material-symbols-outlined">groups</span>
                    <span
                        class="text-green-600 bg-green-50 px-sm py-1 rounded text-[12px] font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">trending_up</span> +184
                    </span>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Total
                    Applicants</h3>
                <p class="font-display text-[32px] font-bold text-on-surface">1,482</p>
            </div>
            <div
                class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm hover:shadow-md transition-shadow">
                <div class="flex justify-between items-start mb-sm">
                    <span class="p-sm bg-tertiary-fixed text-tertiary rounded-lg material-symbols-outlined">star</span>
                    <span
                        class="text-on-surface-variant bg-surface-container px-sm py-1 rounded text-[12px] font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]">horizontal_rule</span> 0%
                    </span>
                </div>
                <h3 class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Shortlisted
                </h3>
                <p class="font-display text-[32px] font-bold text-on-surface">86</p>
            </div>
        </section>
        <!-- Active Job Postings & Analytics Grid -->
        <section class="grid grid-cols-1 xl:grid-cols-12 gap-lg">
            <!-- Left: Active Job Postings (8 Columns) -->
            <div class="xl:col-span-8 space-y-md">
                <div class="flex justify-between items-center mb-sm">
                    <h2 class="font-headline-lg text-headline-lg text-on-surface">Active Job Postings</h2>
                    <div class="flex gap-sm">
                        <button
                            class="p-xs hover:bg-surface-container-high rounded transition-colors text-on-surface-variant"><span
                                class="material-symbols-outlined">filter_list</span></button>
                        <button
                            class="p-xs hover:bg-surface-container-high rounded transition-colors text-on-surface-variant"><span
                                class="material-symbols-outlined">sort</span></button>
                    </div>
                </div>
                <!-- Job Card 1 -->
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant hover:border-primary-container/40 transition-all group">
                    <div class="flex flex-col md:flex-row gap-lg">
                        <div class="flex-1">
                            <div class="flex items-center gap-md mb-xs">
                                <h3
                                    class="font-title-md text-title-md text-on-surface group-hover:text-primary transition-colors cursor-pointer">
                                    Senior Full-Stack Engineer</h3>
                                <span
                                    class="bg-primary/10 text-primary px-sm py-xs rounded text-[10px] font-bold uppercase tracking-widest">Full-time</span>
                            </div>
                            <div class="flex gap-md text-on-surface-variant font-body-md text-body-md mb-md">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[18px]">location_on</span> San
                                    Francisco, CA
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[18px]">calendar_today</span> Posted 3
                                    days ago
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-md border-t border-outline-variant pt-md">
                                <div>
                                    <p class="text-[10px] text-on-surface-variant font-bold uppercase mb-1">Total Apps
                                    </p>
                                    <p class="font-title-md text-title-md font-bold">124</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-on-surface-variant font-bold uppercase mb-1">Shortlisted
                                    </p>
                                    <p class="font-title-md text-title-md font-bold text-green-600">18</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-on-surface-variant font-bold uppercase mb-1">Rejected</p>
                                    <p class="font-title-md text-title-md font-bold text-error">42</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-on-surface-variant font-bold uppercase mb-1">Pending</p>
                                    <p class="font-title-md text-title-md font-bold text-secondary">64</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex md:flex-col justify-end gap-sm min-w-[160px]">
                            <button
                                class="w-full py-sm bg-primary text-on-primary rounded-lg font-bold hover:bg-primary/90 transition-all active:scale-95"
                                onclick="toggleDrillDown()">View Applicants</button>
                            <div class="flex gap-sm">
                                <button
                                    class="flex-1 py-sm bg-surface-container text-on-surface-variant rounded-lg font-bold hover:bg-surface-container-high transition-all"><span
                                        class="material-symbols-outlined">edit</span></button>
                                <button
                                    class="flex-1 py-sm bg-error-container text-on-error-container rounded-lg font-bold hover:bg-error/10 transition-all"><span
                                        class="material-symbols-outlined">delete</span></button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Job Card 2 -->
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant hover:border-primary-container/40 transition-all group">
                    <div class="flex flex-col md:flex-row gap-lg">
                        <div class="flex-1">
                            <div class="flex items-center gap-md mb-xs">
                                <h3
                                    class="font-title-md text-title-md text-on-surface group-hover:text-primary transition-colors cursor-pointer">
                                    Lead Product Designer</h3>
                                <span
                                    class="bg-tertiary-fixed text-on-tertiary-fixed-variant px-sm py-xs rounded text-[10px] font-bold uppercase tracking-widest">Contract</span>
                            </div>
                            <div class="flex gap-md text-on-surface-variant font-body-md text-body-md mb-md">
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[18px]">location_on</span> Remote,
                                    Global
                                </div>
                                <div class="flex items-center gap-1">
                                    <span class="material-symbols-outlined text-[18px]">calendar_today</span> Posted 1
                                    week ago
                                </div>
                            </div>
                            <div class="grid grid-cols-4 gap-md border-t border-outline-variant pt-md">
                                <div>
                                    <p class="text-[10px] text-on-surface-variant font-bold uppercase mb-1">Total Apps
                                    </p>
                                    <p class="font-title-md text-title-md font-bold">56</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-on-surface-variant font-bold uppercase mb-1">Shortlisted
                                    </p>
                                    <p class="font-title-md text-title-md font-bold text-green-600">8</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-on-surface-variant font-bold uppercase mb-1">Rejected</p>
                                    <p class="font-title-md text-title-md font-bold text-error">12</p>
                                </div>
                                <div>
                                    <p class="text-[10px] text-on-surface-variant font-bold uppercase mb-1">Pending</p>
                                    <p class="font-title-md text-title-md font-bold text-secondary">36</p>
                                </div>
                            </div>
                        </div>
                        <div class="flex md:flex-col justify-end gap-sm min-w-[160px]">
                            <button
                                class="w-full py-sm bg-primary text-on-primary rounded-lg font-bold hover:bg-primary/90 transition-all active:scale-95">View
                                Applicants</button>
                            <div class="flex gap-sm">
                                <button
                                    class="flex-1 py-sm bg-surface-container text-on-surface-variant rounded-lg font-bold hover:bg-surface-container-high transition-all"><span
                                        class="material-symbols-outlined">edit</span></button>
                                <button
                                    class="flex-1 py-sm bg-error-container text-on-error-container rounded-lg font-bold hover:bg-error/10 transition-all"><span
                                        class="material-symbols-outlined">delete</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right: Analytics Pipeline (4 Columns) -->
            <div class="xl:col-span-4 space-y-md">
                <div class="flex justify-between items-center mb-sm">
                    <h2 class="font-headline-lg text-headline-lg text-on-surface">Pipeline</h2>
                    <select
                        class="bg-surface-container-low border-none rounded-lg text-label-md py-1 px-sm focus:ring-primary">
                        <option>Full-Stack Eng</option>
                        <option>Product Designer</option>
                    </select>
                </div>
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant shadow-sm h-full flex flex-col">
                    <p class="font-body-md text-body-md text-on-surface-variant mb-xl">Applications per Stage</p>
                    <div class="flex-1 flex flex-col gap-lg justify-between">
                        <!-- Custom Bar Chart (Horizontal) -->
                        <div class="space-y-sm">
                            <div class="flex justify-between font-label-md text-label-md mb-1">
                                <span>Applied</span>
                                <span class="font-bold">124</span>
                            </div>
                            <div class="w-full bg-surface-container rounded-full h-3">
                                <div class="bg-primary h-full rounded-full w-full"></div>
                            </div>
                        </div>
                        <div class="space-y-sm">
                            <div class="flex justify-between font-label-md text-label-md mb-1">
                                <span>Screening</span>
                                <span class="font-bold">64</span>
                            </div>
                            <div class="w-full bg-surface-container rounded-full h-3">
                                <div class="bg-primary/80 h-full rounded-full w-[52%]"></div>
                            </div>
                        </div>
                        <div class="space-y-sm">
                            <div class="flex justify-between font-label-md text-label-md mb-1">
                                <span>Interview</span>
                                <span class="font-bold">18</span>
                            </div>
                            <div class="w-full bg-surface-container rounded-full h-3">
                                <div class="bg-primary/60 h-full rounded-full w-[15%]"></div>
                            </div>
                        </div>
                        <div class="space-y-sm">
                            <div class="flex justify-between font-label-md text-label-md mb-1">
                                <span>Technical</span>
                                <span class="font-bold">8</span>
                            </div>
                            <div class="w-full bg-surface-container rounded-full h-3">
                                <div class="bg-primary/40 h-full rounded-full w-[6%]"></div>
                            </div>
                        </div>
                        <div class="space-y-sm">
                            <div class="flex justify-between font-label-md text-label-md mb-1">
                                <span>Offer</span>
                                <span class="font-bold">2</span>
                            </div>
                            <div class="w-full bg-surface-container rounded-full h-3">
                                <div class="bg-primary/20 h-full rounded-full w-[2%]"></div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-xl pt-lg border-t border-outline-variant">
                        <div class="flex justify-between items-center mb-md">
                            <span class="text-label-md font-bold text-on-surface-variant uppercase">Conversion
                                Rate</span>
                            <span class="text-title-md font-bold text-primary">14.5%</span>
                        </div>
                        <div class="p-md bg-primary/5 rounded-lg border border-primary/20 flex items-center gap-md">
                            <span class="material-symbols-outlined text-primary"
                                style="font-variation-settings: 'FILL' 1;">auto_awesome</span>
                            <p class="text-body-md text-primary-fixed-dim leading-snug">AI suggests increasing outreach
                                for "Lead Designer" as candidate pool is shrinking.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <!-- Applicant View Modal (Drill-down Overlay) -->
    <div class="hidden fixed inset-0 bg-on-surface/40 backdrop-blur-sm z-50 flex items-center justify-center p-md overflow-hidden"
        id="applicantModal">
        <div
            class="bg-surface-container-lowest w-full max-w-6xl h-[870px] rounded-2xl shadow-2xl flex flex-col border border-outline-variant">
            <header class="p-lg border-b border-outline-variant flex justify-between items-center">
                <div>
                    <h2 class="font-headline-lg text-headline-lg text-on-surface">Applicants: Senior Full-Stack Engineer
                    </h2>
                    <p class="text-on-surface-variant text-body-md">Displaying top AI-matched candidates</p>
                </div>
                <button class="p-sm hover:bg-surface-container rounded-full transition-colors"
                    onclick="toggleDrillDown()">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </header>
            <div class="flex-1 flex overflow-hidden">
                <!-- Candidate List -->
                <div class="w-1/2 border-r border-outline-variant p-lg overflow-y-auto custom-scrollbar space-y-md">
                    <!-- Candidate Card 1 -->
                    <div
                        class="p-md border-2 border-primary-container bg-primary-container/5 rounded-xl flex gap-md cursor-pointer">
                        <div class="h-16 w-16 rounded-lg overflow-hidden shrink-0">
                            <img alt="Sarah Henderson" class="w-full h-full object-cover bg-white"
                                data-alt="A professional portrait of a senior software engineer with a modern technology background. She has a knowledgeable and warm expression, wearing professional attire. The lighting is balanced and crisp, evoking a sense of expertise and reliability. Soft bokeh background with tech-inspired elements."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuArLeLuIOtjKziv5uu8yy2NHCnI50ZGOJswBBAvYLupEaOKFR4e52tEvJ6UqiPuH3MDp5XBsDLHQEMDuqE_wGueS8mgTaGsLRmhVYNnLmJSLBZPV5BIMemnFZuxRXHVas_aG2CCDNYdnUteea2Sy9DQ9DDC6f5sMwBCBtma3EYD2vQOCbvzZUTrzQ7FfS5bwjN6aN658By2tLI9cZ1jb629XPDVfSlC0Jb1aMuku_p_QuzzfU0kViCFGIJ6XYmncoTk2SaE_LpvdOM" />
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h3 class="font-title-md text-title-md text-on-surface">Sarah Henderson</h3>
                                <div class="bg-green-100 text-green-700 px-sm py-1 rounded-full text-[12px] font-bold">
                                    94% Match</div>
                            </div>
                            <p class="text-body-md text-on-surface-variant mb-md">8+ years experience · Next.js, Go,
                                Kubernetes</p>
                            <div class="flex gap-sm">
                                <button
                                    class="flex-1 py-xs bg-primary text-on-primary rounded font-bold text-label-md">Shortlist</button>
                                <button
                                    class="flex-1 py-xs border border-outline-variant text-on-surface rounded font-bold text-label-md">Reject</button>
                            </div>
                        </div>
                    </div>
                    <!-- Candidate Card 2 -->
                    <div
                        class="p-md border border-outline-variant hover:border-primary/40 rounded-xl flex gap-md cursor-pointer transition-all">
                        <div class="h-16 w-16 rounded-lg overflow-hidden shrink-0">
                            <img alt="Marcus Liang" class="w-full h-full object-cover bg-white"
                                data-alt="A high-quality professional photograph of a male software architect. He is dressed in business casual attire and is looking directly at the camera with a confident, approachable smile. The setting is a minimalist, modern office space with natural lighting and architectural clean lines."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuD9TPU52PwfKoEuimQFg3SQVzDXpqI4av5bZxN50oYhJR8Pf-6vyyBY7NmesPILt2MxUoun4fuWtZ650mx68a-A96rPoxLrz5gbnmaZYtvA_BXcecSrH46lCeB3Llog4ImgkFw49_qU26b9fLcmxrr4DeQ7ITMysla2JMirQ15pIdxOgf5jB2fpHqNrjlVX3HAgC8ANyJEICwH7qIvVBeGOuEoDZtc0csy5vwV1ny4ncGU3FCVXyA8wyyTg8H3DoEulXI269EyF-iU" />
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h3 class="font-title-md text-title-md text-on-surface">Marcus Liang</h3>
                                <div
                                    class="bg-secondary-container text-secondary px-sm py-1 rounded-full text-[12px] font-bold">
                                    88% Match</div>
                            </div>
                            <p class="text-body-md text-on-surface-variant mb-md">5 years experience · React, Node.js,
                                AWS</p>
                            <div class="flex gap-sm">
                                <button
                                    class="flex-1 py-xs bg-primary text-on-primary rounded font-bold text-label-md">Shortlist</button>
                                <button
                                    class="flex-1 py-xs border border-outline-variant text-on-surface rounded font-bold text-label-md">Reject</button>
                            </div>
                        </div>
                    </div>
                    <!-- Candidate Card 3 -->
                    <div
                        class="p-md border border-outline-variant hover:border-primary/40 rounded-xl flex gap-md cursor-pointer transition-all">
                        <div class="h-16 w-16 rounded-lg overflow-hidden shrink-0">
                            <img alt="Jessica Wu" class="w-full h-full object-cover bg-white"
                                data-alt="A polished headshot of a female technologist. The image captures a bright and vibrant personality with sharp focus on the facial features. The background is a contemporary tech campus with soft sunshine, creating a warm and professional atmosphere."
                                src="https://lh3.googleusercontent.com/aida-public/AB6AXuA_wQGzccXSumT8IUl16AkNmHJy5FzQq5EPh81Y2Qj8jn2qdXPNFiYOs4lRCaBuyG5SFVYRJVrQbLAf6o2R3mLmqpkRmwMSzW84g41ZBPM715WhXDALUfkhPq9tUM9hh4uMnbYy1iEwv_euqi7X-hIypnFLHAyrnvzudtU89rXLvjd5lwhMMS6oqUysBkJ9n-u_ADaeRP6NjghUpZQe-mkRdUrzToHfWSwE8y2FjlXw_pNZsU29SKIU1uJ4wbvJPx2sD5Lo2tW47o4" />
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <h3 class="font-title-md text-title-md text-on-surface">Jessica Wu</h3>
                                <div
                                    class="bg-secondary-container text-secondary px-sm py-1 rounded-full text-[12px] font-bold">
                                    82% Match</div>
                            </div>
                            <p class="text-body-md text-on-surface-variant mb-md">6 years experience · Vue, Python,
                                Docker</p>
                            <div class="flex gap-sm">
                                <button
                                    class="flex-1 py-xs bg-primary text-on-primary rounded font-bold text-label-md">Shortlist</button>
                                <button
                                    class="flex-1 py-xs border border-outline-variant text-on-surface rounded font-bold text-label-md">Reject</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- AI Analysis Panel (Detail View) -->
                <div class="w-1/2 p-lg overflow-y-auto custom-scrollbar bg-surface-container-low">
                    <div class="flex items-center gap-md mb-xl">
                        <div class="p-sm bg-primary-container text-on-primary-container rounded-lg">
                            <span class="material-symbols-outlined"
                                style="font-variation-settings: 'FILL' 1;">psychology</span>
                        </div>
                        <h4 class="font-title-md text-title-md font-bold text-primary">AI Match Analysis</h4>
                    </div>
                    <div class="space-y-xl">
                        <!-- ATS Breakdown -->
                        <div class="space-y-md">
                            <p
                                class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest font-bold">
                                ATS Score Breakdown</p>
                            <div class="grid grid-cols-2 gap-md">
                                <div class="p-md bg-surface-container-lowest rounded-xl border border-outline-variant">
                                    <p class="text-[10px] text-on-surface-variant font-bold uppercase mb-xs">Skills
                                        Relevance</p>
                                    <p class="text-title-md font-bold text-green-600">98/100</p>
                                </div>
                                <div class="p-md bg-surface-container-lowest rounded-xl border border-outline-variant">
                                    <p class="text-[10px] text-on-surface-variant font-bold uppercase mb-xs">Experience
                                        Level</p>
                                    <p class="text-title-md font-bold text-green-600">92/100</p>
                                </div>
                                <div class="p-md bg-surface-container-lowest rounded-xl border border-outline-variant">
                                    <p class="text-[10px] text-on-surface-variant font-bold uppercase mb-xs">Education
                                    </p>
                                    <p class="text-title-md font-bold text-primary">85/100</p>
                                </div>
                                <div class="p-md bg-surface-container-lowest rounded-xl border border-outline-variant">
                                    <p class="text-[10px] text-on-surface-variant font-bold uppercase mb-xs">Culture Fit
                                    </p>
                                    <p class="text-title-md font-bold text-primary">88/100</p>
                                </div>
                            </div>
                        </div>
                        <!-- Skill Gaps -->
                        <div class="space-y-md">
                            <p
                                class="font-label-md text-label-md text-on-surface-variant uppercase tracking-widest font-bold">
                                Identified Skill Gaps</p>
                            <div class="flex flex-wrap gap-sm">
                                <span
                                    class="bg-error-container text-on-error-container px-sm py-1 rounded text-label-md font-bold border border-error/20">No
                                    Rust Experience</span>
                                <span
                                    class="bg-secondary-container text-on-secondary-fixed-variant px-sm py-1 rounded text-label-md font-bold">Limited
                                    Redis Exposure</span>
                            </div>
                        </div>
                        <!-- Recommendations -->
                        <div class="p-lg bg-surface-container-highest rounded-xl border-l-4 border-primary">
                            <p class="font-body-md text-body-md font-bold text-on-surface mb-sm">AI Recommendation:</p>
                            <p class="text-body-md text-on-surface-variant leading-relaxed">
                                Sarah Henderson is an exceptional match for this role. Her extensive experience with
                                Kubernetes and Next.js perfectly aligns with our current tech stack. While she lacks
                                Rust experience mentioned as a "nice-to-have", her rapid learning track record in
                                previous roles suggests she could adapt quickly.
                                <br /><br />
                                <strong>Action:</strong> Move to Technical Interview immediately.
                            </p>
                            <button
                                class="mt-lg w-full py-sm bg-primary text-on-primary rounded-lg font-bold hover:shadow-lg transition-all">Generate
                                Interview Questions</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleDrillDown() {
            const modal = document.getElementById('applicantModal');
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            } else {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                document.body.style.overflow = 'auto';
            }
        }

        // Close modal on click outside
        window.onclick = function (event) {
            const modal = document.getElementById('applicantModal');
            if (event.target == modal) {
                toggleDrillDown();
            }
        }
    </script>
</body>

</html>