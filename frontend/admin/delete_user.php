<?php
require_once '../../backend/config/db.php';
session_start();

// Only allow admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../public/login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manage_users.php');
    exit;
}

$user_id = intval($_GET['id']);

// Protect system admin placeholder (user_id = 0)
if ($user_id === 0) {
    header('Location: manage_users.php');
    exit;
}

// Delete the user (FKs in DB will cascade where defined)
$stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->close();

header('Location: manage_users.php');
exit;
