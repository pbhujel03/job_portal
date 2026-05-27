<?php
session_start();
include("../../backend/config/db.php");

$error_message = '';

if (isset($_POST['login'])) {
    $email = $conn->real_escape_string($_POST['email']);
    $password = $_POST['password'];

    // 1. Hardcoded Admin Check
    if ($email === 'admin@jobportal.com' && $password === 'Admin123') {
        // Get admin name from system_settings, fallback to default
        $admin_name = 'System Administrator';
        $settings_result = $conn->query("SELECT setting_value FROM system_settings WHERE setting_key = 'admin_name' LIMIT 1");
        if ($settings_result && $settings_result->num_rows > 0) {
            $setting_row = $settings_result->fetch_assoc();
            $admin_name = $setting_row['setting_value'] ?? 'System Administrator';
        }
        $_SESSION['user_id'] = 0; // Standard placeholder ID for system admin
        $_SESSION['name'] = $admin_name;
        $_SESSION['role'] = 'admin';

        header("Location: ../admin/dashboard.php");
        exit();
    }

    // 2. Database check for Job Seekers and Recruiters
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Store session
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            // Role based redirect
            if ($user['role'] == "job_seeker") {
                header("Location: ../jobseeker/dashboard.php");
                exit();
            } elseif ($user['role'] == "recruiter") {
                header("Location: ../recruiter/dashboard.php");
                exit();
            } else if ($user['role'] == "admin") { 
                // Fallback rewrite in case admin exists in your database instead
                header("Location: ../admin/dashboard.php");
                exit();
            }
        } else {
            $error_message = "Invalid email or password.";
        }
    } else {
        $error_message = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html class="scroll-smooth" lang="en">
<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Sign In - JobPortal</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&amp;family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet" />
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
                        "display-lg": ["48px", {"lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700"}],
                        "body-lg": ["18px", {"lineHeight": "28px", "fontWeight": "400"}],
                        "label-sm": ["12px", {"lineHeight": "16px", "fontWeight": "500"}],
                        "body-md": ["16px", {"lineHeight": "24px", "fontWeight": "400"}],
                        "headline-md": ["24px", {"lineHeight": "32px", "fontWeight": "600"}],
                        "headline-lg": ["30px", {"lineHeight": "38px", "letterSpacing": "-0.01em", "fontWeight": "600"}],
                        "label-md": ["14px", {"lineHeight": "20px", "letterSpacing": "0.05em", "fontWeight": "600"}],
                        "body-sm": ["14px", {"lineHeight": "20px", "fontWeight": "400"}]
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
    </style>
</head>
<body class="bg-background text-on-background font-body-md antialiased">
    <!-- TopNavBar -->
    <header class="w-full top-0 bg-surface border-b border-outline-variant shadow-sm sticky z-50">
        <div class="flex justify-between items-center max-w-container-max mx-auto px-margin-desktop py-unit-md">
                <a href="index.php" class="flex items-center gap-3 shrink-0">
                    <img src="../assets/images/Job1.png" alt="" class="w-11 h-11 shrink-0 rounded-[10px] object-cover">
                    <div class="flex flex-col justify-center leading-none gap-0.5">
                        <span class="text-[10px] font-bold text-on-surface-variant tracking-[0.18em] uppercase">Job</span>
                        <span class="text-[22px] font-black text-primary uppercase tracking-tight leading-none">Portal</span>
                    </div>
                </a>

            <div class="flex items-center gap-unit-md">
                <a href="register.php" class="font-body-md text-body-md text-on-surface-variant hover:text-primary transition-colors px-unit-md py-unit-sm">Sign Up</a>
            </div>
        </div>
    </header>

    <main>
        <!-- Login Section -->
        <section class="relative kinetic-bg py-unit-xl md:py-12 overflow-hidden flex items-center justify-center min-h-[calc(100vh-80px)]">
            <div class="max-w-md w-full mx-auto px-margin-mobile md:px-0">
                <div class="bg-surface p-unit-xl rounded-xl shadow-lg border border-outline-variant">
                    <h1 class="font-headline-lg text-headline-lg text-on-background mb-2">Welcome Back</h1>
                    <p class="font-body-md text-body-md text-on-surface-variant mb-unit-lg">Sign in to your account to continue</p>

                    <?php if ($error_message): ?>
                        <div class="bg-error-container text-on-background px-unit-md py-unit-sm rounded-lg mb-unit-lg border border-error font-body-sm">
                            <?php echo $error_message; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" class="space-y-unit-md">
                        <div>
                            <label class="block font-label-md text-on-background mb-2">Email</label>
                            <input type="email" name="email" required
                                class="w-full px-unit-md py-2 border border-outline-variant rounded-lg font-body-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                        </div>

                        <div>
                            <label class="block font-label-md text-on-background mb-2">Password</label>
                            <div class="relative">
                                <input type="password" id="password" name="password" required
                                    class="w-full px-unit-md py-2 border border-outline-variant rounded-lg font-body-sm focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" />
                                <button type="button" onclick="togglePasswordVisibility()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-on-surface-variant hover:text-primary transition-colors">
                                    <span class="material-symbols-outlined text-xl" id="passwordIcon" data-icon="visibility">visibility</span>
                                </button>
                            </div>
                        </div>

                        <button type="submit" name="login"
                            class="w-full bg-primary text-white px-unit-lg py-2 rounded-lg font-label-md hover:brightness-110 transition-all shadow-sm active:scale-95">
                            Sign In
                        </button>
                    </form>

                    <p class="text-center text-on-surface-variant font-body-sm mt-unit-lg">
                        Don't have an account?
                        <a href="register.php" class="text-primary font-label-md hover:underline">Sign Up</a>
                    </p>
                </div>
            </div>

            <!-- Background elements -->
            <div class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/4 w-96 h-96 bg-primary opacity-10 blur-[120px] rounded-full"></div>
            <div class="absolute bottom-0 left-0 translate-y-1/2 -translate-x-1/4 w-96 h-96 bg-inverse-surface opacity-5 blur-[120px] rounded-full"></div>
        </section>
    </main>

    <!-- Footer -->
    <footer class="w-full bottom-0 bg-inverse-surface py-unit-xl text-white">
        <div class="flex flex-col md:flex-row justify-between items-center max-w-container-max mx-auto px-margin-desktop gap-unit-lg">
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
                <a class="font-body-sm text-white/80 hover:text-primary transition-colors" href="#">Support</a>
            </nav>
        </div>
    </footer>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.textContent = 'visibility_off';
            } else {
                passwordInput.type = 'password';
                passwordIcon.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>