<?php
require_once '../../backend/config/db.php';
session_start();

// Only allow admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../public/login.php');
    exit;
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manage_jobs.php');
    exit;
}

$job_id = intval($_GET['id']);

// Delete related applications first (if any)
$stmtApps = $conn->prepare("DELETE FROM applications WHERE job_id = ?");
$stmtApps->bind_param('i', $job_id);
$stmtApps->execute();
$stmtApps->close();

// Delete the job
$stmt = $conn->prepare("DELETE FROM jobs WHERE job_id = ?");
$stmt->bind_param('i', $job_id);
$stmt->execute();
$stmt->close();

header('Location: manage_jobs.php');
exit;
