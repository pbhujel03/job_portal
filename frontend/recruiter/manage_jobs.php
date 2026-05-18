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

$recruiter_id = $_SESSION['user_id'];
?>

<?php
if (isset($_GET['delete'])) {
    $job_id = $_GET['delete'];

    $conn->query("DELETE FROM jobs 
                  WHERE job_id='$job_id' 
                  AND recruiter_id='$recruiter_id'");

    header("Location: manage_jobs.php");
    exit();
}
?>

<?php
if (isset($_POST['update_job'])) {

    $job_id = $_POST['job_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $skills = $_POST['skills'];
    $experience = $_POST['experience_required'];
    $salary = $_POST['salary'];
    $location = $_POST['location'];

    $conn->query("UPDATE jobs SET 
        title='$title',
        description='$description',
        required_skills='$skills',
        experience_required='$experience',
        salary='$salary',
        location='$location'
        WHERE job_id='$job_id' AND recruiter_id='$recruiter_id'
    ");

    header("Location: manage_jobs.php");
    exit();
}
?>

<?php
$result = $conn->query("SELECT * FROM jobs WHERE recruiter_id='$recruiter_id' ORDER BY job_id DESC");
?>

<?php
$edit_job = null;

if (isset($_GET['edit'])) {
    $job_id = $_GET['edit'];
    $edit_job = $conn->query("SELECT * FROM jobs WHERE job_id='$job_id' AND recruiter_id='$recruiter_id'")
                    ->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Jobs</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<h2>My Jobs</h2>

<!-- EDIT FORM -->
<?php if ($edit_job) { ?>

    <h3>Edit Job</h3>

    <form method="POST">

        <input type="hidden" name="job_id" value="<?php echo $edit_job['job_id']; ?>">

        <input type="text" name="title" value="<?php echo $edit_job['title']; ?>" required><br><br>

        <textarea name="description" required><?php echo $edit_job['description']; ?></textarea><br><br>

        <input type="text" name="skills" value="<?php echo $edit_job['required_skills']; ?>" required><br><br>

        <input type="text" name="experience_required" value="<?php echo $edit_job['experience_required']; ?>" required><br><br>

        <input type="text" name="salary" value="<?php echo $edit_job['salary']; ?>"><br><br>

        <input type="text" name="location" value="<?php echo $edit_job['location']; ?>"><br><br>

        <button type="submit" name="update_job">Update Job</button>

    </form>

    <hr>

<?php } ?>

<!-- JOB LIST -->
<?php while ($row = $result->fetch_assoc()) { ?>

    <div style="border:1px solid #ccc; padding:15px; margin-bottom:10px; border-radius:8px;">

        <h3><?php echo $row['title']; ?></h3>

        <p><b>Description:</b> <?php echo $row['description']; ?></p>
        <p><b>Skills:</b> <?php echo $row['required_skills']; ?></p>
        <p><b>Experience:</b> <?php echo $row['experience_required']; ?></p>
        <p><b>Salary:</b> <?php echo $row['salary']; ?></p>
        <p><b>Location:</b> <?php echo $row['location']; ?></p>

        <a href="?edit=<?php echo $row['job_id']; ?>">✏ Edit</a> | 

        <a href="?delete=<?php echo $row['job_id']; ?>" 
           onclick="return confirm('Delete this job?')"
           style="color:red;">
           🗑 Delete
        </a>

    </div>

<?php } ?>

</body>
</html>