<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login_form.php");
    exit();
}
include 'config.php';
include 'functions.php';

// Fetch tracking information
$searchTerm = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';
$stmt = $pdo->prepare("SELECT * FROM tracking_info WHERE tracking_number LIKE :search OR status LIKE :search");
$stmt->execute(['search' => "%$searchTerm%"]);
$trackingInfos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Log access to tracking info page
log_activity($_SESSION['admin_id'], "Viewed tracking information");

?>
<!DOCTYPE html>
<html>
<head>
    <title>View Tracking Info</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>
    <h2>View Tracking Info</h2>
    <form method="get" action="view_tracking.php">
        <input type="text" name="search" placeholder="Search tracking info..." value="<?php echo $searchTerm; ?>">
        <button type="submit">Search</button>
    </form>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Tracking Number</th>
                <th>Status</th>
                <th>Location</th>
                <th>Timestamp</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($trackingInfos as $info): ?>
                <tr>
                    <td><?php echo htmlspecialchars($info['id']); ?></td>
                    <td><?php echo htmlspecialchars($info['tracking_number']); ?></td>
                    <td><?php echo htmlspecialchars($info['status']); ?></td>
                    <td><?php echo htmlspecialchars($info['location']); ?></td>
                    <td><?php echo htmlspecialchars($info['timestamp']); ?></td>
                    <td>
                        <a href="edit_tracking.php?id=<?php echo $info['id']; ?>">Edit</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
