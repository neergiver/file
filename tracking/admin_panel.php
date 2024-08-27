<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login_form.php");
    exit();
}
include 'config.php';
include 'functions.php';

// Fetch summary data
$userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$trackingCount = $pdo->query("SELECT COUNT(*) FROM tracking_info")->fetchColumn();
$verifiedUserCount = $pdo->query("SELECT COUNT(*) FROM users WHERE email_verified = TRUE")->fetchColumn();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>
    <h2>Admin Panel</h2>
    <div class="dashboard-summary">
        <div>
            <h3>Total Users</h3>
            <p><?php echo $userCount; ?></p>
        </div>
        <div>
            <h3>Verified Users</h3>
            <p><?php echo $verifiedUserCount; ?></p>
        </div>
        <div>
            <h3>Total Tracking Records</h3>
            <p><?php echo $trackingCount; ?></p>
        </div>
    </div>
    <nav>
        <ul>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="view_tracking.php">View Tracking Info</a></li>
            <li><a href="admin_logout.php">Logout</a></li>
        </ul>
    </nav>
</body>
</html>
