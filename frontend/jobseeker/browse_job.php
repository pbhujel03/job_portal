<!DOCTYPE html>

<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Available Jobs | RecruitFlow</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9ff;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
            vertical-align: middle;
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

        .job-card-active {
            border-color: #4f46e5 !important;
            background-color: #f0f3ff !important;
        }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "inverse-surface": "#213145",
                        "error-container": "#ffdad6",
                        "on-error-container": "#93000a",
                        "on-background": "#0b1c30",
                        "surface-tint": "#4d44e3",
                        "surface": "#f8f9ff",
                        "on-primary": "#ffffff",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary-container": "#5c647a",
                        "inverse-primary": "#c3c0ff",
                        "surface-container-highest": "#d3e4fe",
                        "primary": "#3525cd",
                        "on-error": "#ffffff",
                        "on-secondary-fixed": "#131b2e",
                        "on-secondary": "#ffffff",
                        "surface-bright": "#f8f9ff",
                        "inverse-on-surface": "#eaf1ff",
                        "on-primary-fixed-variant": "#3323cc",
                        "on-tertiary-fixed": "#351000",
                        "on-surface-variant": "#464555",
                        "error": "#ba1a1a",
                        "on-primary-fixed": "#0f0069",
                        "tertiary": "#7e3000",
                        "tertiary-fixed": "#ffdbcc",
                        "primary-container": "#4f46e5",
                        "on-secondary-fixed-variant": "#3f465c",
                        "background": "#f8f9ff",
                        "secondary-container": "#dae2fd",
                        "secondary-fixed-dim": "#bec6e0",
                        "on-tertiary": "#ffffff",
                        "surface-dim": "#cbdbf5",
                        "on-primary-container": "#dad7ff",
                        "tertiary-fixed-dim": "#ffb695",
                        "on-tertiary-fixed-variant": "#7b2f00",
                        "tertiary-container": "#a44100",
                        "on-tertiary-container": "#ffd2be",
                        "outline": "#777587",
                        "secondary-fixed": "#dae2fd",
                        "primary-fixed": "#e2dfff",
                        "primary-fixed-dim": "#c3c0ff",
                        "surface-variant": "#d3e4fe",
                        "on-surface": "#0b1c30",
                        "outline-variant": "#c7c4d8",
                        "surface-container": "#e5eeff",
                        "secondary": "#565e74",
                        "surface-container-high": "#dce9ff",
                        "surface-container-low": "#eff4ff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "xs": "4px",
                        "lg": "24px",
                        "gutter": "24px",
                        "md": "16px",
                        "margin-mobile": "16px",
                        "base": "8px",
                        "sm": "8px",
                        "margin-desktop": "40px",
                        "xl": "32px"
                    },
                    "fontFamily": {
                        "headline-lg-mobile": ["Inter"],
                        "headline-lg": ["Inter"],
                        "label-md": ["Inter"],
                        "display": ["Inter"],
                        "body-md": ["Inter"],
                        "title-md": ["Inter"],
                        "body-lg": ["Inter"]
                    },
                    "fontSize": {
                        "headline-lg-mobile": ["28px", { "lineHeight": "36px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "headline-lg": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "label-md": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "500" }],
                        "display": ["56px", { "lineHeight": "64px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "body-md": ["14px", { "lineHeight": "20px", "fontWeight": "400" }],
                        "title-md": ["20px", { "lineHeight": "28px", "fontWeight": "600" }],
                        "body-lg": ["16px", { "lineHeight": "24px", "fontWeight": "400" }]
                    }
                },
            },
        }
    </script>
</head>

<body class="bg-surface text-on-surface flex min-h-screen">
    <!-- SideNavBar: Copied from SCREEN_30 -->
    <aside
        class="fixed h-full left-0 top-0 w-64 bg-on-secondary-fixed dark:bg-inverse-surface flex flex-col py-lg px-md z-50">
        <div class="flex items-center gap-md mb-xl px-md">
            <div class="w-10 h-10 rounded-lg bg-primary-container flex items-center justify-center">
                <span class="material-symbols-outlined text-on-primary" data-icon="rocket_launch">rocket_launch</span>
            </div>
            <div>
                <h1 class="font-title-md text-title-md font-bold text-surface-container-lowest leading-tight">
                    RecruitFlow</h1>
                <p class="text-[10px] text-secondary-fixed-dim tracking-widest uppercase">Job Seeker</p>
            </div>
        </div>
        <nav class="flex-1 space-y-xs overflow-y-auto custom-scrollbar">
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="dashboard.php">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span class="font-body-md text-body-md">Dashboard</span>
            </a>
            <!-- Active Tab: Available Jobs -->
            <a class="flex items-center gap-md bg-primary-container text-on-primary-container rounded-lg px-md py-base transition-transform active:scale-95"
                href="browse_job.php">
                <span class="material-symbols-outlined" data-icon="work">work</span>
                <span class="font-body-md text-body-md">Available Jobs</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="applied_jobs.php">
                <span class="material-symbols-outlined" data-icon="assignment_turned_in">assignment_turned_in</span>
                <span class="font-body-md text-body-md">Applied Jobs</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="resume_analysis.php">
                <span class="material-symbols-outlined" data-icon="analytics">analytics</span>
                <span class="font-body-md text-body-md">Resume Analysis</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="ats_score.php">
                <span class="material-symbols-outlined" data-icon="speed">speed</span>
                <span class="font-body-md text-body-md">ATS Score</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="skill_gap_analysis.php">
                <span class="material-symbols-outlined" data-icon="psychology">psychology</span>
                <span class="font-body-md text-body-md">Skill Gap Analysis</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="saved_jobs.php"></a>
                <span class="material-symbols-outlined" data-icon="bookmark_heart">bookmark_heart</span>
                <span class="font-body-md text-body-md">Saved Jobs</span>
            </a>
            <div class="h-px bg-outline-variant/10 mx-md my-sm"></div>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="profile_settings.php">
                <span class="material-symbols-outlined" data-icon="settings">settings</span>
                <span class="font-body-md text-body-md">Profile Settings</span>
            </a>
            <a class="flex items-center gap-md text-error/80 hover:bg-error/10 transition-all duration-200 px-md py-base rounded-lg"
                href="logout.php">
                <span class="material-symbols-outlined" data-icon="logout">logout</span>
                <span class="font-body-md text-body-md">Logout</span>
            </a>
        </nav>
    </aside>
    <!-- Main Content Area -->
    <div class="flex-1 ml-64 min-h-screen flex flex-col">
        <!-- TopAppBar: Matched with SCREEN_30 -->
        <header
            class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-surface border-b border-outline-variant flex justify-between items-center px-margin-desktop z-40">
            <div class="flex items-center gap-lg flex-1">
                <div
                    class="relative w-full max-w-xl focus-within:ring-2 focus-within:ring-primary/20 rounded-full bg-surface-container-low transition-all border border-outline-variant/30">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline"
                        data-icon="search">search</span>
                    <input class="w-full bg-transparent border-none focus:ring-0 py-2.5 pl-10 pr-4 text-body-md"
                        placeholder="Search for jobs, companies, or skills..." type="text" />
                </div>
            </div>
            <div class="flex items-center gap-md">
                <button
                    class="hover:bg-surface-container-low rounded-full p-2 text-on-surface-variant transition-colors relative">
                    <span class="material-symbols-outlined" data-icon="notifications">notifications</span>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-error rounded-full border-2 border-white"></span>
                </button>
                <button
                    class="hover:bg-surface-container-low rounded-full p-2 text-on-surface-variant transition-colors">
                    <span class="material-symbols-outlined" data-icon="help">help</span>
                </button>
                <div class="h-8 w-[1px] bg-outline-variant mx-sm"></div>
                <div class="flex items-center gap-sm cursor-pointer group">
                    <div class="hidden lg:block text-right">
                        <p class="font-body-md font-bold text-on-surface">Alex Rivera</p>
                        <p class="text-[10px] text-on-surface-variant">Pro Seeker</p>
                    </div>
                    <img alt="Alex Rivera"
                        class="w-10 h-10 rounded-full border-2 border-primary-container/20 group-hover:border-primary-container transition-all object-cover"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuDSvLlLEVxvK5JIoZcNAPZw6XyU4KMbBVNPp2LFyYGtNTHbfGjtbznyHjKd2AN14ELKNcI3yb3Od9eruhjTxkoPU2gWMDjR_yArISMBg-oZlxN4DpkVVaCjEmbKJCbJ2CBOqysj8QboBGLC6IZ4183lAbJYDPRmNFde8jl6mDe2FqaiHUT1OjMUne4kRVXgEpeGsfE3oo_Uc_k1Kxg97TPflky-8m_dT288GCaQp7EQd2p22vgb2scW905O2YoJ6s9HApTvnZq2EEQ" />
                </div>
            </div>
        </header>
        <!-- Main Page Content -->
        <main class="mt-16 p-margin-desktop flex flex-col h-[calc(100vh-4rem)]">
            <!-- Page Header & Filter Bar -->
            <div class="mb-lg flex flex-col gap-md">
                <div class="flex justify-between items-end">
                    <div>
                        <h2 class="font-headline-lg text-headline-lg text-on-surface">Available Jobs</h2>
                        <p class="text-on-surface-variant font-body-md text-body-md">Discover roles matched to your
                            professional profile by our AI.</p>
                    </div>
                    <div class="text-right">
                        <span class="text-label-md font-label-md text-primary font-bold">254 New Matches Found</span>
                    </div>
                </div>
                <div
                    class="p-md bg-surface-container-lowest border border-outline-variant/30 rounded-xl flex flex-wrap gap-md items-center shadow-sm">
                    <div class="flex flex-col gap-1 min-w-[200px]">
                        <span class="text-[10px] font-bold text-secondary uppercase tracking-tighter">Location</span>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-2 top-1/2 -translate-y-1/2 text-on-surface-variant text-[16px]"
                                data-icon="location_on">location_on</span>
                            <select
                                class="w-full pl-7 pr-8 py-1.5 bg-surface-container-low border border-outline-variant/50 rounded-lg text-body-md focus:ring-primary outline-none">
                                <option>Remote</option>
                                <option>San Francisco, CA</option>
                                <option>New York, NY</option>
                                <option>London, UK</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex flex-col gap-1 min-w-[150px]">
                        <span class="text-[10px] font-bold text-secondary uppercase tracking-tighter">Job Type</span>
                        <select
                            class="w-full px-3 py-1.5 bg-surface-container-low border border-outline-variant/50 rounded-lg text-body-md focus:ring-primary outline-none">
                            <option>Full-time</option>
                            <option>Contract</option>
                            <option>Freelance</option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1 min-w-[180px]">
                        <span class="text-[10px] font-bold text-secondary uppercase tracking-tighter">Salary
                            Range</span>
                        <select
                            class="w-full px-3 py-1.5 bg-surface-container-low border border-outline-variant/50 rounded-lg text-body-md focus:ring-primary outline-none">
                            <option>$100k - $150k</option>
                            <option>$150k - $200k</option>
                            <option>$200k+</option>
                        </select>
                    </div>
                    <div class="flex-1 flex justify-end">
                        <button
                            class="flex items-center gap-xs px-lg py-2 bg-on-secondary-fixed text-white rounded-lg font-bold text-label-md hover:bg-inverse-surface transition-colors">
                            <span class="material-symbols-outlined text-[18px]"
                                data-icon="filter_list">filter_list</span>
                            Advanced Filters
                        </button>
                    </div>
                </div>
            </div>
            <!-- Two-Column Layout -->
            <div class="flex gap-lg flex-1 overflow-hidden">
                <!-- Left Column: Scrollable Job List -->
                <div class="w-[400px] flex flex-col gap-md overflow-y-auto pr-2 custom-scrollbar">
                    <!-- Job Card 1 (Active) -->
                    <div
                        class="p-lg bg-surface-container-lowest border border-primary rounded-xl job-card-active cursor-pointer shadow-sm transition-all hover:border-primary group">
                        <div class="flex justify-between items-start mb-md">
                            <div
                                class="w-12 h-12 rounded-lg bg-white border border-outline-variant flex items-center justify-center p-2 group-hover:border-primary/50">
                                <img alt="NexGen Logo" class="w-full h-full object-contain"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBS3Uux7qSy9ilaElL-regOA-JPaCf_uQ5Ql7lP1HQE4okejm-XD97UyyGyVMzgdgOSsYurVdfHYudxTGM38zntO1v72-ANw7Gh2MMYiSxd3fYJprrBDYAlvBBtmxBXhWh7RHjrhWIQXFztUS0M-jNI8Ce5Rasx8tw027dbbqsD84BrRGFEhz8BGyvt2mu5ryqiMrhfLkyzpgJkF6Yq0otg-jKH5xmOP1gNrlBPa_-ZpP2em0PVe99SfT5hDnCk8YzeeSt6LV5rnEE" />
                            </div>
                            <span
                                class="px-2 py-0.5 bg-primary-container text-white text-[10px] font-bold rounded-full">HOT
                                MATCH</span>
                        </div>
                        <h3
                            class="font-title-md text-title-md text-on-surface font-bold mb-1 group-hover:text-primary transition-colors">
                            Senior Product Designer</h3>
                        <p class="text-on-surface-variant text-body-md font-medium mb-md">NexGen AI Solutions</p>
                        <div class="flex flex-wrap gap-xs mb-md">
                            <div
                                class="px-2 py-1 bg-surface-container-low text-secondary text-[11px] font-medium rounded-md flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]"
                                    data-icon="location_on">location_on</span> Remote
                            </div>
                            <div
                                class="px-2 py-1 bg-surface-container-low text-secondary text-[11px] font-medium rounded-md flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]" data-icon="payments">payments</span>
                                $140k - $180k
                            </div>
                        </div>
                        <div class="flex items-center justify-between border-t border-outline-variant/20 pt-md">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-primary text-[18px]" data-icon="bolt"
                                        style="font-variation-settings: 'FILL' 1;">bolt</span>
                                </div>
                                <span class="text-label-md font-bold text-primary">98% Match Score</span>
                            </div>
                            <span class="text-[11px] text-on-surface-variant">2h ago</span>
                        </div>
                    </div>
                    <!-- Job Card 2 -->
                    <div
                        class="p-lg bg-surface-container-lowest border border-outline-variant/30 rounded-xl cursor-pointer hover:border-primary/50 transition-all group">
                        <div class="flex justify-between items-start mb-md">
                            <div
                                class="w-12 h-12 rounded-lg bg-white border border-outline-variant flex items-center justify-center p-2 group-hover:border-primary/50">
                                <img alt="CloudScale Logo" class="w-full h-full object-contain"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDmj92EIGFUvRY9HeUmQwtSfXeJrTDQmugi0DqGDsJaJpS4paxvqUHQTtyYMM4KNyjkqTGtKFhi90ljIcffNQU8_DHtNyhGafJibrEVGVp1wja7DOqjuOQsIaEcNdSTWgXyjdRvTGse7D74ypEWqur1rPXGhpQ45U8xrT8LkX8_aMZ09NWky8qx4Fr7sgFVIqUmVua_VFVqEp2UavaPzu53xvsRdbMksusH4jl3cc5MSBebPjfiRThq01gPtY-oSphGUz_3_WEWQCg" />
                            </div>
                            <span class="px-2 py-0.5 bg-tertiary text-white text-[10px] font-bold rounded-full">NEW
                                ROLE</span>
                        </div>
                        <h3
                            class="font-title-md text-title-md text-on-surface font-bold mb-1 group-hover:text-primary transition-colors">
                            Lead Frontend Architect</h3>
                        <p class="text-on-surface-variant text-body-md font-medium mb-md">CloudScale Systems</p>
                        <div class="flex flex-wrap gap-xs mb-md">
                            <div
                                class="px-2 py-1 bg-surface-container-low text-secondary text-[11px] font-medium rounded-md flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]"
                                    data-icon="location_on">location_on</span> New York, NY
                            </div>
                            <div
                                class="px-2 py-1 bg-surface-container-low text-secondary text-[11px] font-medium rounded-md flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]" data-icon="payments">payments</span>
                                $160k - $210k
                            </div>
                        </div>
                        <div class="flex items-center justify-between border-t border-outline-variant/20 pt-md">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-secondary/10 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-secondary text-[18px]"
                                        data-icon="bolt">bolt</span>
                                </div>
                                <span class="text-label-md font-bold text-secondary">92% Match Score</span>
                            </div>
                            <span class="text-[11px] text-on-surface-variant">5h ago</span>
                        </div>
                    </div>
                    <!-- Job Card 3 -->
                    <div
                        class="p-lg bg-surface-container-lowest border border-outline-variant/30 rounded-xl cursor-pointer hover:border-primary/50 transition-all group">
                        <div class="flex justify-between items-start mb-md">
                            <div
                                class="w-12 h-12 rounded-lg bg-white border border-outline-variant flex items-center justify-center p-2">
                                <img alt="Velocity Fintech Logo" class="w-full h-full object-contain"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBlVJNBrv4PIOn0eyBInNn6W5kxUI5XCb76TLsPhBgcE3x3EVOa4Dy7nj6Rifr3uCXfjgtd5H9upJBso0_5lgCJG5xg6kqCWNOpw8u1x29UEby3NdzpeQEV8gujCLjPO3vCBKN3tkjG-OYBk1d49ws5htmcIWqEmbNkHbU_lXfMbWeUUHsgXaRJkyuTYptVT1Cm2_TkxXcWJfPVvdlJP2UN3mV6YVPA3zmQaCYNAP4A28hJoeAXWn2_XkhnOS8lDGlMT_D-BgYDY80" />
                            </div>
                        </div>
                        <h3
                            class="font-title-md text-title-md text-on-surface font-bold mb-1 group-hover:text-primary transition-colors">
                            Design System Lead</h3>
                        <p class="text-on-surface-variant text-body-md font-medium mb-md">Velocity Fintech</p>
                        <div class="flex flex-wrap gap-xs mb-md">
                            <div
                                class="px-2 py-1 bg-surface-container-low text-secondary text-[11px] font-medium rounded-md flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]"
                                    data-icon="location_on">location_on</span> Remote
                            </div>
                            <div
                                class="px-2 py-1 bg-surface-container-low text-secondary text-[11px] font-medium rounded-md flex items-center gap-1">
                                <span class="material-symbols-outlined text-[14px]" data-icon="payments">payments</span>
                                $130k - $170k
                            </div>
                        </div>
                        <div class="flex items-center justify-between border-t border-outline-variant/20 pt-md">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 rounded-full bg-secondary/10 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-secondary text-[18px]"
                                        data-icon="bolt">bolt</span>
                                </div>
                                <span class="text-label-md font-bold text-secondary">88% Match Score</span>
                            </div>
                            <span class="text-[11px] text-on-surface-variant">1d ago</span>
                        </div>
                    </div>
                </div>
                <!-- Right Column: Job Preview Pane -->
                <div
                    class="flex-1 bg-surface-container-lowest border border-outline-variant/30 rounded-xl flex flex-col overflow-hidden shadow-sm relative">
                    <!-- Hero Section -->
                    <div class="h-32 bg-primary-container relative overflow-hidden">
                        <div class="absolute inset-0 opacity-20"
                            style="background-image: radial-gradient(circle at 2px 2px, white 1px, transparent 0); background-size: 24px 24px;">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-r from-primary to-transparent"></div>
                        <div class="absolute bottom-4 left-lg flex items-center gap-md">
                            <div
                                class="w-16 h-16 bg-white rounded-xl shadow-lg border border-outline-variant flex items-center justify-center p-2">
                                <img alt="NexGen Logo Large" class="w-full h-full object-contain"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuADLaMqiK01Ev_UrFXVMVSA2_h1UMe3KyIqfvVwcQINnxOYKqRZCe52T-IcTBFRsg8AVCM3D9RhMWv7ti7IIut41R_qZVDXhTM3AjSG_392AYGTHrDEn9c53Lzhw8Giz5HrfIVU0iruYStlifALoaUWJu293cokPV5-md3ntYG87kMlnx-4tOvqq7ohBuzkVqR8Msz-Y26R6JO7qEBZQObZsdMNQZQKT0ch5CMG15EzVBLvq4phX1ClBOJEkbjDNnexn9Q1IXVnJtw" />
                            </div>
                            <div class="text-white">
                                <h2 class="font-title-md text-title-md font-bold">Senior Product Designer</h2>
                                <p class="text-[14px] opacity-80">NexGen AI Solutions • Posted 2 hours ago</p>
                            </div>
                        </div>
                    </div>
                    <!-- Details Content -->
                    <div class="flex-1 overflow-y-auto p-lg custom-scrollbar">
                        <div class="flex justify-between items-start mb-lg">
                            <div class="flex gap-lg">
                                <div>
                                    <span
                                        class="text-[10px] font-bold text-secondary uppercase tracking-widest block mb-1">SALARY</span>
                                    <p class="font-title-md text-title-md font-bold text-on-surface">$140k - $180k <span
                                            class="text-body-md font-normal text-on-surface-variant">/ yr</span></p>
                                </div>
                                <div class="h-10 w-px bg-outline-variant/30"></div>
                                <div>
                                    <span
                                        class="text-[10px] font-bold text-secondary uppercase tracking-widest block mb-1">TYPE</span>
                                    <p class="font-title-md text-title-md font-bold text-on-surface">Full-time</p>
                                </div>
                                <div class="h-10 w-px bg-outline-variant/30"></div>
                                <div>
                                    <span
                                        class="text-[10px] font-bold text-secondary uppercase tracking-widest block mb-1">LOCATION</span>
                                    <p class="font-title-md text-title-md font-bold text-on-surface">Remote (US)</p>
                                </div>
                            </div>
                            <div class="flex gap-md">
                                <button
                                    class="p-2 border border-outline-variant rounded-lg hover:bg-surface-container-low transition-colors">
                                    <span class="material-symbols-outlined text-secondary"
                                        data-icon="bookmark">bookmark</span>
                                </button>
                                <button
                                    class="p-2 border border-outline-variant rounded-lg hover:bg-surface-container-low transition-colors">
                                    <span class="material-symbols-outlined text-secondary"
                                        data-icon="share">share</span>
                                </button>
                            </div>
                        </div>
                        <section class="mb-lg">
                            <h4 class="font-title-md text-title-md font-bold text-on-surface mb-md">Role Overview</h4>
                            <p class="text-body-lg text-body-lg text-on-surface-variant leading-relaxed">
                                NexGen is seeking a visionary Senior Product Designer to join our Core AI team. You will
                                be responsible for defining the user experience of our next-generation generative AI
                                tools, ensuring that complex machine learning capabilities are accessible, intuitive,
                                and high-performing for enterprise users.
                            </p>
                        </section>
                        <section class="mb-lg">
                            <h4 class="font-title-md text-title-md font-bold text-on-surface mb-md">Key Responsibilities
                            </h4>
                            <ul class="space-y-sm">
                                <li class="flex items-start gap-md text-body-md text-on-surface-variant">
                                    <span class="material-symbols-outlined text-primary text-[18px] mt-0.5"
                                        data-icon="check_circle">check_circle</span>
                                    Lead design initiatives from concept to high-fidelity implementation.
                                </li>
                                <li class="flex items-start gap-md text-body-md text-on-surface-variant">
                                    <span class="material-symbols-outlined text-primary text-[18px] mt-0.5"
                                        data-icon="check_circle">check_circle</span>
                                    Collaborate with AI engineers to translate technical models into user-centric
                                    interfaces.
                                </li>
                                <li class="flex items-start gap-md text-body-md text-on-surface-variant">
                                    <span class="material-symbols-outlined text-primary text-[18px] mt-0.5"
                                        data-icon="check_circle">check_circle</span>
                                    Maintain and contribute to the RecruitFlow Design System.
                                </li>
                            </ul>
                        </section>
                        <section
                            class="mb-lg p-lg bg-surface-container-low rounded-xl border border-outline-variant/30">
                            <h4 class="font-label-md text-label-md font-bold text-primary uppercase mb-md">Perks &amp;
                                Benefits</h4>
                            <div class="grid grid-cols-2 gap-md">
                                <div class="flex items-center gap-sm">
                                    <span class="material-symbols-outlined text-on-surface-variant"
                                        data-icon="medical_services">medical_services</span>
                                    <span class="text-body-md text-on-surface-variant">Healthcare</span>
                                </div>
                                <div class="flex items-center gap-sm">
                                    <span class="material-symbols-outlined text-on-surface-variant"
                                        data-icon="home_work">home_work</span>
                                    <span class="text-body-md text-on-surface-variant">Remote-First</span>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- Sticky Bottom CTA -->
                    <div
                        class="p-lg bg-surface-container-lowest border-t border-outline-variant/30 flex items-center justify-between">
                        <div class="flex items-center gap-md">
                            <div class="p-2 bg-primary/10 rounded-lg">
                                <span class="material-symbols-outlined text-primary"
                                    data-icon="psychology">psychology</span>
                            </div>
                            <div>
                                <p class="text-label-md font-bold text-primary">AI Recommendation</p>
                                <p class="text-[12px] text-on-surface-variant">98% requirement match.</p>
                            </div>
                        </div>
                        <div class="flex gap-md">
                            <button
                                class="px-lg py-3 bg-primary-container text-white font-bold rounded-xl hover:shadow-lg transition-all active:scale-95 flex items-center gap-md">
                                Apply Now
                                <span class="material-symbols-outlined text-[20px]"
                                    data-icon="arrow_forward">arrow_forward</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <script>
        const cards = document.querySelectorAll('.job-card-active, div[class*="border-outline-variant"].cursor-pointer');
        cards.forEach(card => {
            card.addEventListener('click', () => {
                cards.forEach(c => {
                    c.classList.remove('job-card-active', 'border-primary', 'bg-primary-container/10', 'shadow-sm');
                    c.classList.add('border-outline-variant/30');
                    if (c.classList.contains('job-card-active')) {
                        c.style.backgroundColor = '';
                    }
                });
                card.classList.add('job-card-active');
                card.classList.remove('border-outline-variant/30');
                card.style.backgroundColor = '#f0f3ff';
            });
        });
    </script>
</body>

</html>