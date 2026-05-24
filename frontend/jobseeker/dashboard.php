<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>RecruitFlow - Job Seeker Dashboard</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&amp;display=swap"
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
                        "on-primary-fixed": "#0f0069",
                        "on-secondary-fixed-variant": "#3f465c",
                        "surface-container": "#e5eeff",
                        "primary-container": "#4f46e5",
                        "primary-fixed": "#e2dfff",
                        "outline-variant": "#c7c4d8",
                        "on-tertiary": "#ffffff",
                        "surface-container-high": "#dce9ff",
                        "on-tertiary-container": "#ffd2be",
                        "on-primary-fixed-variant": "#3323cc",
                        "tertiary": "#7e3000",
                        "secondary-fixed": "#dae2fd",
                        "surface-container-lowest": "#ffffff",
                        "on-secondary-container": "#5c647a",
                        "surface-container-low": "#eff4ff",
                        "secondary": "#565e74",
                        "surface-variant": "#d3e4fe",
                        "inverse-on-surface": "#eaf1ff",
                        "surface-dim": "#cbdbf5",
                        "secondary-fixed-dim": "#bec6e0",
                        "on-primary-container": "#dad7ff",
                        "error": "#ba1a1a",
                        "secondary-container": "#dae2fd",
                        "surface": "#f8f9ff",
                        "inverse-primary": "#c3c0ff",
                        "surface-container-highest": "#d3e4fe",
                        "on-error": "#ffffff",
                        "surface-tint": "#4d44e3",
                        "on-error-container": "#93000a",
                        "tertiary-fixed-dim": "#ffb695",
                        "on-surface-variant": "#464555",
                        "on-surface": "#0b1c30",
                        "tertiary-fixed": "#ffdbcc",
                        "inverse-surface": "#213145",
                        "on-tertiary-fixed": "#351000",
                        "primary-fixed-dim": "#c3c0ff",
                        "surface-bright": "#f8f9ff",
                        "outline": "#777587",
                        "on-primary": "#ffffff",
                        "tertiary-container": "#a44100",
                        "on-secondary-fixed": "#131b2e",
                        "on-tertiary-fixed-variant": "#7b2f00",
                        "on-secondary": "#ffffff",
                        "background": "#f8f9ff",
                        "on-background": "#0b1c30",
                        "error-container": "#ffdad6",
                        "primary": "#3525cd"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "gutter": "24px",
                        "lg": "24px",
                        "xs": "4px",
                        "margin-desktop": "40px",
                        "sm": "8px",
                        "base": "8px",
                        "xl": "32px",
                        "margin-mobile": "16px",
                        "md": "16px"
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

<body class="text-on-surface">
    <!-- SideNavBar Component -->
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
            <a class="flex items-center gap-md bg-primary-container text-on-primary-container rounded-lg px-md py-base transition-transform active:scale-95"
                href="#">
                <span class="material-symbols-outlined" data-icon="dashboard">dashboard</span>
                <span class="font-body-md text-body-md">Dashboard</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="#">
                <span class="material-symbols-outlined" data-icon="work">work</span>
                <span class="font-body-md text-body-md">Available Jobs</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="#">
                <span class="material-symbols-outlined" data-icon="assignment_turned_in">assignment_turned_in</span>
                <span class="font-body-md text-body-md">Applied Jobs</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="#">
                <span class="material-symbols-outlined" data-icon="analytics">analytics</span>
                <span class="font-body-md text-body-md">Resume Analysis</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="#">
                <span class="material-symbols-outlined" data-icon="speed">speed</span>
                <span class="font-body-md text-body-md">ATS Score</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="#">
                <span class="material-symbols-outlined" data-icon="psychology">psychology</span>
                <span class="font-body-md text-body-md">Skill Gap Analysis</span>
            </a>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="#">
                <span class="material-symbols-outlined" data-icon="bookmark_heart">bookmark_heart</span>
                <span class="font-body-md text-body-md">Saved Jobs</span>
            </a>
            <div class="h-px bg-outline-variant/10 mx-md my-sm"></div>
            <a class="flex items-center gap-md text-secondary-fixed-dim hover:text-surface-bright hover:bg-primary/10 transition-colors duration-200 px-md py-base rounded-lg"
                href="#">
                <span class="material-symbols-outlined" data-icon="settings">settings</span>
                <span class="font-body-md text-body-md">Profile Settings</span>
            </a>
            <a class="flex items-center gap-md text-error/80 hover:bg-error/10 transition-all duration-200 px-md py-base rounded-lg"
                href="#">
                <span class="material-symbols-outlined" data-icon="logout">logout</span>
                <span class="font-body-md text-body-md">Logout</span>
            </a>
        </nav>

    </aside>
    <!-- Main Content Area -->
    <main class="ml-64 flex-1 min-h-screen bg-surface relative flex flex-col">
        <!-- TopAppBar Component -->
        <header
            class="fixed top-0 right-0 w-[calc(100%-16rem)] h-16 bg-surface border-b border-outline-variant flex justify-between items-center px-margin-desktop z-40">
            <div class="flex items-center gap-lg flex-1">
                <div
                    class="relative w-full max-w-xl focus-within:ring-2 focus-within:ring-primary/20 rounded-full bg-surface-container-low transition-all border border-outline-variant/30">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-outline"
                        data-icon="search">search</span>
                    <input class="w-full bg-transparent border-none focus:ring-0 py-2.5 pl-10 pr-4 text-body-md"
                        placeholder="Search for jobs, companies, or skills..." type="text">
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
                    <span class="material-symbols-outlined" data-icon="settings">settings</span>
                </button>
                <div class="h-8 w-[1px] bg-outline-variant mx-sm"></div>
                <div class="flex items-center gap-sm cursor-pointer group">
                    <div class="hidden lg:block text-right">
                        <p class="font-body-md font-bold text-on-surface">Alex Rivera</p>
                        <p class="text-[10px] text-on-surface-variant">Pro Seeker</p>
                    </div>
                    <img alt="Profile"
                        class="w-10 h-10 rounded-full border-2 border-primary-container/20 group-hover:border-primary-container transition-all object-cover"
                        src="https://lh3.googleusercontent.com/aida-public/AB6AXuDSvLlLEVxvK5JIoZcNAPZw6XyU4KMbBVNPp2LFyYGtNTHbfGjtbznyHjKd2AN14ELKNcI3yb3Od9eruhjTxkoPU2gWMDjR_yArISMBg-oZlxN4DpkVVaCjEmbKJCbJ2CBOqysj8QboBGLC6IZ4183lAbJYDPRmNFde8jl6mDe2FqaiHUT1OjMUne4kRVXgEpeGsfE3oo_Uc_k1Kxg97TPflky-8m_dT288GCaQp7EQd2p22vgb2scW905O2YoJ6s9HApTvnZq2EEQ">
                </div>
            </div>
        </header>
        <!-- Page Canvas -->
        <div class="mt-16 p-margin-desktop grid grid-cols-1 lg:grid-cols-12 gap-gutter flex-grow">
            <!-- Stats Bento Row -->
            <div class="lg:col-span-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-gutter mb-xl">
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm flex items-center justify-between hover:border-primary transition-colors group">
                    <div>
                        <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Total
                            Jobs Available</p>
                        <h3 class="text-display font-display text-[32px] font-extrabold text-on-surface mt-1">1,240</h3>
                        <p class="text-primary font-label-md text-label-md flex items-center mt-2">
                            <span class="material-symbols-outlined text-sm mr-1">trending_up</span> +8% new
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 bg-primary/10 rounded-full flex items-center justify-center text-primary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 1;">travel_explore</span>
                    </div>
                </div>
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm flex items-center justify-between hover:border-primary transition-colors group">
                    <div>
                        <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">Jobs
                            Applied</p>
                        <h3 class="text-display font-display text-[32px] font-extrabold text-on-surface mt-1">12</h3>
                        <p class="text-secondary font-label-md text-label-md flex items-center mt-2">
                            <span class="material-symbols-outlined text-sm mr-1">history</span> Last 30d
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center text-secondary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">send</span>
                    </div>
                </div>
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm flex items-center justify-between hover:border-primary transition-colors group border-l-4 border-l-primary">
                    <div>
                        <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">ATS
                            Score</p>
                        <h3 class="text-display font-display text-[32px] font-extrabold text-on-surface mt-1">85%</h3>
                        <p class="text-emerald-600 font-label-md text-label-md flex items-center mt-2">
                            <span class="material-symbols-outlined text-sm mr-1"
                                style="transform: scale(1) rotate(0deg); transition: transform 0.3s;">auto_awesome</span>
                            Strong Match
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 1;">analytics</span>
                    </div>
                </div>
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm flex items-center justify-between hover:border-primary transition-colors group">
                    <div>
                        <p class="text-on-surface-variant font-label-md text-label-md uppercase tracking-wider">
                            Shortlisted</p>
                        <h3 class="text-display font-display text-[32px] font-extrabold text-on-surface mt-1">03</h3>
                        <p class="text-tertiary font-label-md text-label-md flex items-center mt-2">
                            <span class="material-symbols-outlined text-sm mr-1">star</span> 3 active
                        </p>
                    </div>
                    <div
                        class="w-12 h-12 bg-tertiary-fixed rounded-full flex items-center justify-center text-tertiary group-hover:scale-110 transition-transform">
                        <span class="material-symbols-outlined"
                            style="font-variation-settings: 'FILL' 1;">bookmark_heart</span>
                    </div>
                </div>
            </div>
            <!-- Main Section: Available Jobs -->
            <div class="lg:col-span-8 space-y-lg">
                <div class="flex justify-between items-center">
                    <h2 class="font-headline-lg text-headline-lg text-on-surface">Available Jobs for You</h2>
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-on-surface-variant font-medium">Sort by:</span>
                        <div class="relative">
                            <select
                                class="appearance-none pl-3 pr-8 py-1.5 bg-white border border-outline-variant rounded-lg text-xs font-bold text-primary focus:ring-primary/20 cursor-pointer">
                                <option>Relevance</option>
                                <option>Newest</option>
                                <option>Salary</option>
                            </select>
                            <span
                                class="material-symbols-outlined absolute right-2 top-1.5 text-primary pointer-events-none text-sm">keyboard_arrow_down</span>
                        </div>
                    </div>
                </div>
                <!-- Job Card 1 -->
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm hover:shadow-md transition-all group">
                    <div class="flex items-start gap-lg">
                        <img alt="Nexus Tech"
                            class="w-16 h-16 rounded-xl object-contain border border-outline-variant/50 bg-surface-container-low p-2 group-hover:border-primary/50 transition-colors"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuClqcJCz3UWW8ooLw6_K4-ZE0Nxppk457USCkAuJ208EwyXdnD6i_HbPDxqodV06coQbq9TzIgbJ7fQCZG5oRgPP4SpHF1pL4AaazaE4_tAVMaFf05SP1AnSkh0U_zsbnfMWv-obvtmi0zs7h9B5X3nSpuA7q7Q5MF2ThXi1dDt9ddg2TXfzyxGCi2YCgvINt0u18TExmC0IZdl4X68imuW82MuFDVQkdo9ScEZjdhbn77IHI2jFIXM9NKnoR0T0EoG_TNpefYorXI">
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3
                                        class="text-lg font-bold text-on-surface group-hover:text-primary cursor-pointer transition-colors leading-tight">
                                        Senior Full Stack Developer</h3>
                                    <p class="text-sm font-medium text-on-surface-variant flex items-center mt-1">
                                        Nexus Tech Solutions <span class="mx-2 text-outline-variant">•</span> London, UK
                                        (Remote)
                                    </p>
                                </div>
                                <button class="text-outline hover:text-primary transition-colors p-1">
                                    <span class="material-symbols-outlined">bookmark</span>
                                </button>
                            </div>
                            <div
                                class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-lg py-3 border-y border-outline-variant/10">
                                <div class="flex items-center text-xs text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[18px] mr-1.5 text-outline"
                                        data-icon="payments">payments</span>
                                    <span class="font-bold">£85k - £110k</span>
                                </div>
                                <div class="flex items-center text-xs text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[18px] mr-1.5 text-outline"
                                        data-icon="work_outline">work_outline</span>
                                    <span class="">5+ Yrs Exp</span>
                                </div>
                                <div class="flex items-center text-xs text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[18px] mr-1.5 text-outline"
                                        data-icon="schedule">schedule</span>
                                    <span class="">2 days ago</span>
                                </div>
                                <div class="flex items-center text-xs text-primary">
                                    <span class="material-symbols-outlined text-[18px] mr-1.5 text-primary"
                                        data-icon="verified">verified</span>
                                    <span class="font-bold">92% Match</span>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 mt-lg">
                                <span
                                    class="px-3 py-1 bg-surface-container-low text-[11px] font-bold text-on-secondary-container rounded-lg border border-outline-variant/20">React</span>
                                <span
                                    class="px-3 py-1 bg-surface-container-low text-[11px] font-bold text-on-secondary-container rounded-lg border border-outline-variant/20">Node.js</span>
                                <span
                                    class="px-3 py-1 bg-surface-container-low text-[11px] font-bold text-on-secondary-container rounded-lg border border-outline-variant/20">PostgreSQL</span>
                                <span
                                    class="px-3 py-1 bg-surface-container-low text-[11px] font-bold text-on-secondary-container rounded-lg border border-outline-variant/20">TypeScript</span>
                            </div>
                            <div class="flex items-center justify-end gap-3 mt-lg">
                                <button
                                    class="px-5 py-2 border border-outline-variant rounded-lg text-sm font-bold text-on-surface hover:bg-surface-container-low transition-colors"
                                    onclick="toggleModal('ai-modal')">
                                    Analyze Match
                                </button>
                                <button
                                    class="px-8 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:shadow-lg active:scale-95 transition-all">
                                    Apply Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Job Card 2 -->
                <div
                    class="bg-surface-container-lowest p-lg rounded-xl border border-outline-variant/30 shadow-sm hover:shadow-md transition-all group">
                    <div class="flex items-start gap-lg">
                        <img alt="Cognitive Systems"
                            class="w-16 h-16 rounded-xl object-contain border border-outline-variant/50 bg-surface-container-low p-2 group-hover:border-primary/50 transition-colors"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDP8lNiFN47GLPaZN9D_yZORMgETmB3OkbwZ3SN_PPQ_ueuD7LuWBWFtJHY1-3rc_4ocJp4RqpA-ZWQYTwKrAozUDj3tS3JBs32NQhKXn6aByhN4oJT-enRq7YYs1h7lPvBxtBU1IPW0Xg7Yxl7Nr9_VhRNaUYiSERFe_CN2HJyJ2KPFtZy9Z0LgGscjmbqPEeWLy_pfUzzA7qWEaX7CZcZNAPaQFZpQDIEWYjjVnJVCMarR3Okk4TvAuUqRmZMEOrz0NSz3ewytgo">
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3
                                        class="text-lg font-bold text-on-surface group-hover:text-primary cursor-pointer transition-colors leading-tight">
                                        AI Engineer (LLM focus)</h3>
                                    <p class="text-sm font-medium text-on-surface-variant flex items-center mt-1">
                                        Cognitive Systems <span class="mx-2 text-outline-variant">•</span> San
                                        Francisco, CA (On-site)
                                    </p>
                                </div>
                                <button class="text-outline hover:text-primary transition-colors p-1">
                                    <span class="material-symbols-outlined">bookmark</span>
                                </button>
                            </div>
                            <div
                                class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-lg py-3 border-y border-outline-variant/10">
                                <div class="flex items-center text-xs text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[18px] mr-1.5 text-outline"
                                        data-icon="payments">payments</span>
                                    <span class="font-bold">$160k - $210k</span>
                                </div>
                                <div class="flex items-center text-xs text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[18px] mr-1.5 text-outline"
                                        data-icon="work_outline">work_outline</span>
                                    <span class="">3+ Yrs Exp</span>
                                </div>
                                <div class="flex items-center text-xs text-on-surface-variant">
                                    <span class="material-symbols-outlined text-[18px] mr-1.5 text-outline"
                                        data-icon="schedule">schedule</span>
                                    <span class="">4h ago</span>
                                </div>
                                <div class="flex items-center text-xs text-primary">
                                    <span class="material-symbols-outlined text-[18px] mr-1.5 text-primary"
                                        data-icon="verified">verified</span>
                                    <span class="font-bold">88% Match</span>
                                </div>
                            </div>
                            <div class="flex flex-wrap items-center gap-2 mt-lg">
                                <span
                                    class="px-3 py-1 bg-surface-container-low text-[11px] font-bold text-on-secondary-container rounded-lg border border-outline-variant/20">Python</span>
                                <span
                                    class="px-3 py-1 bg-surface-container-low text-[11px] font-bold text-on-secondary-container rounded-lg border border-outline-variant/20">PyTorch</span>
                                <span
                                    class="px-3 py-1 bg-surface-container-low text-[11px] font-bold text-on-secondary-container rounded-lg border border-outline-variant/20">Transformers</span>
                                <span
                                    class="px-3 py-1 bg-surface-container-low text-[11px] font-bold text-on-secondary-container rounded-lg border border-outline-variant/20">GenAI</span>
                            </div>
                            <div class="flex items-center justify-end gap-3 mt-lg">
                                <button
                                    class="px-5 py-2 border border-outline-variant rounded-lg text-sm font-bold text-on-surface hover:bg-surface-container-low transition-colors"
                                    onclick="toggleModal('ai-modal')">
                                    Analyze Match
                                </button>
                                <button
                                    class="px-8 py-2 bg-primary text-white rounded-lg text-sm font-bold hover:shadow-lg active:scale-95 transition-all">
                                    Apply Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Right Panel: Side Modules -->
            <div class="lg:col-span-4 space-y-xl">
                <!-- AI Smart Tips Section -->
                <div class="bg-primary text-white p-lg rounded-xl shadow-lg relative overflow-hidden group">
                    <div
                        class="absolute -right-10 -top-10 w-40 h-40 bg-white/10 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-700">
                    </div>
                    <div class="relative z-10">
                        <div class="flex items-center gap-2 mb-lg">
                            <span class="material-symbols-outlined" data-icon="tips_and_updates">tips_and_updates</span>
                            <h3 class="font-bold text-lg">AI Smart Tips</h3>
                        </div>
                        <div class="space-y-md">
                            <div class="bg-white/10 p-4 rounded-lg border border-white/20 backdrop-blur-sm">
                                <p class="text-[13px] leading-relaxed">Include more <span
                                        class="font-bold underline">quantifiable metrics</span> in your Experience
                                    section. It could boost your ATS score by up to 15%.</p>
                            </div>
                            <div class="bg-white/10 p-4 rounded-lg border border-white/20 backdrop-blur-sm">
                                <p class="text-[13px] leading-relaxed">Your profile lacks <span
                                        class="font-bold underline">"Cloud Architecture"</span>. Add it to your skills
                                    to match 24 more top-tier jobs.</p>
                            </div>
                        </div>
                        <button
                            class="w-full mt-lg bg-white text-primary py-3 rounded-lg text-xs font-bold hover:bg-surface transition-all shadow-sm">Full
                            Resume Report</button>
                    </div>
                </div>
                <!-- Recommended Jobs Section -->
                <div
                    class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden">
                    <div
                        class="px-lg py-md border-b border-outline-variant/10 flex justify-between items-center bg-surface-container-low/30">
                        <h3 class="font-bold text-on-surface text-sm">Recommended for You</h3>
                        <button class="text-xs text-primary font-bold hover:underline">Refresh</button>
                    </div>
                    <div class="divide-y divide-outline-variant/10">
                        <div class="p-lg hover:bg-surface-container-low/20 cursor-pointer transition-colors group">
                            <div class="flex gap-md">
                                <div
                                    class="w-10 h-10 bg-primary/5 rounded-lg border border-outline-variant/20 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-[20px]"
                                        data-icon="corporate_fare">corporate_fare</span>
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-bold text-on-surface group-hover:text-primary transition-colors leading-tight">
                                        Software Engineer III</p>
                                    <p class="text-[11px] text-on-surface-variant mt-0.5">Stripe • Remote</p>
                                    <div class="flex items-center mt-1.5">
                                        <span
                                            class="text-[10px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold">95%
                                            Match</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-lg hover:bg-surface-container-low/20 cursor-pointer transition-colors group">
                            <div class="flex gap-md">
                                <div
                                    class="w-10 h-10 bg-primary/5 rounded-lg border border-outline-variant/20 flex items-center justify-center text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                    <span class="material-symbols-outlined text-[20px]"
                                        data-icon="corporate_fare">corporate_fare</span>
                                </div>
                                <div>
                                    <p
                                        class="text-sm font-bold text-on-surface group-hover:text-primary transition-colors leading-tight">
                                        Staff Product Designer</p>
                                    <p class="text-[11px] text-on-surface-variant mt-0.5">Airbnb • San Francisco</p>
                                    <div class="flex items-center mt-1.5">
                                        <span
                                            class="text-[10px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-bold">89%
                                            Match</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button
                        class="w-full py-3 text-xs font-bold text-primary border-t border-outline-variant/10 hover:bg-surface-container-low transition-colors">Explore
                        All Recommendations</button>
                </div>
                <!-- Application Status Section -->
                <div
                    class="bg-surface-container-lowest rounded-xl border border-outline-variant/30 shadow-sm overflow-hidden">
                    <div class="px-lg py-md border-b border-outline-variant/10 bg-surface-container-low/30">
                        <h3 class="font-bold text-on-surface text-sm">Application Status</h3>
                    </div>
                    <div class="divide-y divide-outline-variant/10">
                        <div class="p-lg flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[18px]"
                                        data-icon="apartment">apartment</span>
                                </div>
                                <div>
                                    <p class="text-xs font-bold">Google</p>
                                    <p class="text-[10px] text-on-surface-variant">UX Researcher</p>
                                </div>
                            </div>
                            <span
                                class="px-2.5 py-1 rounded-full bg-secondary-container text-on-secondary-container text-[10px] font-bold">Shortlisted</span>
                        </div>
                        <div class="p-lg flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[18px]"
                                        data-icon="apartment">apartment</span>
                                </div>
                                <div>
                                    <p class="text-xs font-bold">Meta</p>
                                    <p class="text-[10px] text-on-surface-variant">Full Stack Eng</p>
                                </div>
                            </div>
                            <span
                                class="px-2.5 py-1 rounded-full bg-surface-container-high text-on-secondary-container text-[10px] font-bold">Reviewed</span>
                        </div>
                        <div class="p-lg flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[18px]"
                                        data-icon="apartment">apartment</span>
                                </div>
                                <div>
                                    <p class="text-xs font-bold">Stripe</p>
                                    <p class="text-[10px] text-on-surface-variant">Product Manager</p>
                                </div>
                            </div>
                            <span
                                class="px-2.5 py-1 rounded-full bg-error-container text-error text-[10px] font-bold">Rejected</span>
                        </div>
                        <div class="p-lg flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="w-9 h-9 rounded-lg bg-surface-container-low flex items-center justify-center text-primary">
                                    <span class="material-symbols-outlined text-[18px]"
                                        data-icon="apartment">apartment</span>
                                </div>
                                <div>
                                    <p class="text-xs font-bold">Atlassian</p>
                                    <p class="text-[10px] text-on-surface-variant">Backend Dev</p>
                                </div>
                            </div>
                            <span
                                class="px-2.5 py-1 rounded-full bg-primary-container/10 text-primary text-[10px] font-bold">Applied</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- System Footer -->
        <footer
            class="mt-auto px-margin-desktop py-lg border-t border-outline-variant bg-surface flex flex-col md:flex-row justify-between items-center text-[10px] text-on-surface-variant uppercase tracking-widest font-bold">
            <p class="">© 2024 RecruitFlow Intelligence. All rights reserved.</p>
            <div class="flex gap-lg mt-4 md:mt-0">
                <a class="hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="hover:text-primary transition-colors" href="#">Terms of Service</a>
                <a class="hover:text-primary transition-colors" href="#">Support Center</a>
            </div>
        </footer>
    </main>
    <!-- AI ANALYSIS MODAL -->
    <div class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-inverse-surface/60 backdrop-blur-sm opacity-0 pointer-events-none transition-all duration-300"
        id="ai-modal">
        <div
            class="bg-white w-full max-w-2xl rounded-2xl shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300">
            <!-- Header -->
            <div
                class="p-6 border-b border-outline-variant flex justify-between items-center bg-surface-container-low/50">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined" data-icon="auto_awesome">auto_awesome</span>
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-on-surface">AI Resume Analysis</h2>
                        <p class="text-xs text-on-surface-variant">Analyzing match for Senior Full Stack Developer</p>
                    </div>
                </div>
                <button class="p-2 hover:bg-surface-container-high rounded-full transition-colors"
                    onclick="toggleModal('ai-modal')">
                    <span class="material-symbols-outlined" data-icon="close">close</span>
                </button>
            </div>
            <div class="p-6 md:p-8 space-y-8">
                <!-- Stats Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center p-4 bg-primary/5 rounded-xl border border-primary/10">
                        <p class="text-[11px] font-bold text-on-surface-variant uppercase mb-2">Resume Match</p>
                        <p class="text-3xl font-bold text-primary">92%</p>
                        <div class="w-full bg-outline-variant/30 h-1.5 rounded-full mt-3 overflow-hidden">
                            <div class="bg-primary h-full w-[92%]"></div>
                        </div>
                    </div>
                    <div class="text-center p-4 bg-surface-container-low rounded-xl border border-outline-variant">
                        <p class="text-[11px] font-bold text-on-surface-variant uppercase mb-2">ATS Score</p>
                        <p class="text-3xl font-bold text-on-surface">85<span class="text-sm">/100</span></p>
                        <p class="text-[10px] text-emerald-600 font-bold mt-3">Exceeds Benchmark</p>
                    </div>
                    <div class="text-center p-4 bg-surface-container-low rounded-xl border border-outline-variant">
                        <p class="text-[11px] font-bold text-on-surface-variant uppercase mb-2">Strength Level</p>
                        <p class="text-3xl font-bold text-on-surface">High</p>
                        <p class="text-[10px] text-secondary font-bold mt-3">Top 5% Applicants</p>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Missing Skills -->
                    <div>
                        <h4 class="text-sm font-bold text-on-surface mb-4 flex items-center">
                            <span class="material-symbols-outlined text-error mr-2 text-[20px]"
                                data-icon="error_outline">error_outline</span>
                            Missing Skills to Add
                        </h4>
                        <div class="flex flex-wrap gap-2">
                            <span
                                class="px-3 py-1 bg-error/5 text-error text-[11px] font-bold rounded-full border border-error/10">Docker</span>
                            <span
                                class="px-3 py-1 bg-error/5 text-error text-[11px] font-bold rounded-full border border-error/10">AWS
                                Lambda</span>
                            <span
                                class="px-3 py-1 bg-error/5 text-error text-[11px] font-bold rounded-full border border-error/10">GraphQL</span>
                            <span
                                class="px-3 py-1 bg-error/5 text-error text-[11px] font-bold rounded-full border border-error/10">CI/CD</span>
                        </div>
                    </div>
                    <!-- Suggestions -->
                    <div>
                        <h4 class="text-sm font-bold text-on-surface mb-4 flex items-center">
                            <span class="material-symbols-outlined text-primary mr-2 text-[20px]"
                                data-icon="lightbulb">lightbulb</span>
                            AI Suggestions
                        </h4>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <span class="material-symbols-outlined text-primary text-[16px] mr-2 mt-0.5"
                                    data-icon="check_circle">check_circle</span>
                                <p class="text-xs text-on-surface-variant leading-relaxed">Quantify your achievements
                                    with Node.js.</p>
                            </li>
                            <li class="flex items-start">
                                <span class="material-symbols-outlined text-primary text-[16px] mr-2 mt-0.5"
                                    data-icon="check_circle">check_circle</span>
                                <p class="text-xs text-on-surface-variant leading-relaxed">Mention "Microservices
                                    Architecture" explicitly.</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="flex justify-end space-x-4 pt-4">
                    <button
                        class="px-6 py-2.5 text-sm font-bold text-on-surface-variant hover:bg-surface-container-low rounded-lg transition-colors"
                        onclick="toggleModal('ai-modal')">Close</button>
                    <button
                        class="px-6 py-2.5 bg-primary text-sm font-bold text-white rounded-lg shadow-lg hover:brightness-110 active:scale-95 transition-all">Optimize
                        &amp; Apply</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function toggleModal(id) {
            const modal = document.getElementById(id);
            const card = modal.querySelector('.transform');

            if (modal.classList.contains('opacity-0')) {
                modal.classList.remove('opacity-0', 'pointer-events-none');
                card.classList.remove('scale-95');
                card.classList.add('scale-100');
            } else {
                modal.classList.add('opacity-0', 'pointer-events-none');
                card.classList.add('scale-95');
                card.classList.remove('scale-100');
            }
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            const modal = document.getElementById('ai-modal');
            if (event.target == modal) {
                toggleModal('ai-modal');
            }
        }

        // Card hover effects logic
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