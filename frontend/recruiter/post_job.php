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

include("../../backend/config/db.php");

/* POST JOB LOGIC*/
if (isset($_POST['post_job'])) {

    $recruiter_id = $_SESSION['user_id'];

    // =========================
    // GET & CLEAN INPUTS
    // =========================
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $skills = trim($_POST['skills']);
    $experience = trim($_POST['experience_required']);
    $salary = trim($_POST['salary']);
    $location = trim($_POST['location']);

    // =========================
    // VALIDATION
    // =========================

    // Job title only letters + spaces
    if (!preg_match("/^[a-zA-Z\s]+$/", $title)) {
        $_SESSION['message'] = "Job Title should contain only letters!";
        $_SESSION['msg_type'] = "error";
        header("Location: post_job.php");
        exit();
    }

    // Salary must be numeric
    if (!is_numeric($salary)) {
        $_SESSION['message'] = "Salary must be a number!";
        $_SESSION['msg_type'] = "error";
        header("Location: post_job.php");
        exit();
    }

    // Required fields check
    if (empty($title) || empty($description) || empty($skills) || empty($experience)) {
        $_SESSION['message'] = "Please fill all required fields!";
        $_SESSION['msg_type'] = "error";
        header("Location: post_job.php");
        exit();
    }

    // =========================
    // INSERT INTO DATABASE
    // =========================
    $currency = $_POST['currency'];
    $salary = $_POST['salary'];

    $sql = "INSERT INTO jobs 
    (recruiter_id, title, description, required_skills, experience_required, salary, location)
    VALUES 
    ('$recruiter_id', '$title', '$description', '$skills', '$experience', '$currency $salary', '$location')";

    if ($conn->query($sql)) {
        $_SESSION['message'] = "Job Posted Successfully!";
        $_SESSION['msg_type'] = "success";
    } else {
        $_SESSION['message'] = "Error: " . $conn->error;
        $_SESSION['msg_type'] = "error";
    }

    header("Location: post_job.php");
    exit();
}

/*
   SHOW MESSAGE (FLASH)
 */
$message = "";
$type = "";

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    $type = $_SESSION['msg_type'];

    unset($_SESSION['message']);
    unset($_SESSION['msg_type']);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Post Job</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>

    <!-- SUCCESS / ERROR MESSAGE -->
    <?php if ($message != "") { ?>
        <div style="
        width: 100%;
        max-width: 500px;
        margin: 20px auto;
        padding: 15px;
        text-align: center;
        border-radius: 8px;
        color: white;
        font-weight: bold;
        background: <?php echo ($type == 'success') ? '#28a745' : '#dc3545'; ?>;
    ">
            <?php echo $message; ?>
        </div>
    <?php } ?>

    <h2 style="text-align:center;">Post a New Job</h2>

    <form method="POST">

        <input type="text" name="title" placeholder="Job Title" required><br><br>

        <textarea name="description" placeholder="Job Description" required></textarea><br><br>

        <input type="text" name="skills" placeholder="Required Skills (comma separated)" required><br><br>

        <input type="text" name="experience_required" placeholder="Experience Required (e.g. 2 years)" required><br><br>

        <select name="currency" required>
            <option value="NPR">NPR (Nepal Rupees)</option>
            <option value="USD">USD (US Dollar)</option>
            <option value="INR">INR (Indian Rupee)</option>
        </select><br><br>

        <input type="number" name="salary" placeholder="Salary Amount" required><br><br>

        <input type="text" name="location" placeholder="Location"><br><br>

        <button type="submit" name="post_job">Post Job</button>

    </form>

</body>

</html>