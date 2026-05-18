<?php include("../../backend/middleware/auth_check.php"); ?>

<h1>Welcome Job Seeker</h1>
<p>Hello <?php echo $_SESSION['name']; ?></p>

<a href="../logout.php">Logout</a>