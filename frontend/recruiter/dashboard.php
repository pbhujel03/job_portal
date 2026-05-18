<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../public/login.php");
    exit();
}

if ($_SESSION['role'] != "recruiter") {
    echo "Access Denied!";
    exit();
}
?>

<?php include("../../backend/config/db.php"); ?>

<!DOCTYPE html>
<html>

<head>
    <title>Recruiter Dashboard</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <div class="container">

        <h1>Recruiter Dashboard</h1>

        <p>Welcome, <?php echo $_SESSION['name']; ?> 👋</p>

        <hr>

        <div class="menu">

            <a href="post_job.php">➕ Post Job</a><br><br>

            <a href="manage_jobs.php">📋 My Jobs</a><br><br>

            <a href="applications.php">📄 View Applications</a><br><br>

            <a href="../public/logout.php">🚪 Logout</a>

        </div>

    </div>

</body>

</html>

