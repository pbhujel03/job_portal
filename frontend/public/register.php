<?php include("../../backend/config/db.php"); ?>
<link rel="stylesheet" href="../assets/css/style.css">

<form method="POST" enctype="multipart/form-data">
    <h2>Register</h2>

    <input type="text" name="full_name" placeholder="Full Name" required><br><br>

    <input type="email" name="email" placeholder="Email" required><br><br>

    <input type="text" name="phone" placeholder="Phone"><br><br>

    <input type="password" name="password" placeholder="Password" required><br><br>

    <input type="file" name="profile_image"><br><br>

    <select name="role" required>
        <option value="job_seeker">Job Seeker</option>
        <option value="recruiter">Recruiter</option>
    </select><br><br>

    <button type="submit" name="register">Register</button>

    <br><br>
    <p>
        Already have an account?
        <a href="login.php">Login here</a>
    </p>
</form>

<?php

if (isset($_POST['register'])) {

    $name = $_POST['full_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    $password = $_POST['password'];

    if (!preg_match('/^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{8,}$/', $password)) {
        echo "Password must be at least 8 characters and include uppercase, lowercase, and number.";
        exit;
    }

    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // check duplicate email
    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo "Email already exists!";
        exit;
    }

    // PROFILE IMAGE UPLOAD
    $image_name = NULL;

    if (!empty($_FILES['profile_image']['name'])) {
        $image_name = time() . "_" . $_FILES['profile_image']['name'];
        $target = "../../frontend/assets/uploads/profile_photos/" . $image_name;

        move_uploaded_file($_FILES['profile_image']['tmp_name'], $target);
    }

    $sql = "INSERT INTO users (full_name, email, password, role, phone, profile_image)
            VALUES ('$name', '$email', '$pass', '$role', '$phone', '$image_name')";

    if ($conn->query($sql)) {
        echo "Registration Successful! <a href='login.php'>Login</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>