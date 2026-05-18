<?php
session_start();
include("../../backend/config/db.php");
?>
<link rel="stylesheet" href="../assets/css/style.css">

<form method="POST">
    <h2>Login</h2>

    <input type="email" name="email" placeholder="Email" required><br><br>

    <input type="password" id="password" name="password" placeholder="Password" required>

    <span onclick="togglePassword()" style="cursor:pointer;">👁️</span>

    <br><br>

    <button type="submit" name="login">Login</button>

    <p>
        Don't have an account?
        <a href="register.php">Register here</a>
    </p>
</form>

<script>
    function togglePassword() {
        let pass = document.getElementById("password");
        pass.type = (pass.type === "password") ? "text" : "password";
    }
</script>

<?php

if (isset($_POST['login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // check user
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {

        $user = $result->fetch_assoc();

        // VERIFY PASSWORD (IMPORTANT)
        if (password_verify($password, $user['password'])) {

            // STORE SESSION
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];

            // ROLE BASED REDIRECT
            if ($user['role'] == "job_seeker") {
                header("Location: ../jobseeker/dashboard.php");
                exit();
            } elseif ($user['role'] == "recruiter") {
                header("Location: ../recruiter/dashboard.php");
                exit();
            } else {
                header("Location: ../admin/dashboard.php");
                exit();
            }

        } else {
            echo "❌ Wrong password!";
        }

    } else {
        echo "❌ User not found!";
    }
}
?>