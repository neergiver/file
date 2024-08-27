<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login_form.php");
    exit();
}
include 'config.php';
include 'functions.php';

if (isset($_GET['id'])) {
    $id = htmlspecialchars($_GET['id']);
    $stmt = $pdo->prepare("SELECT * FROM tracking_info WHERE id = :id");
    $stmt->execute(['id' => $id]);
    $info = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$info) {
        echo "Tracking info not found.";
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = htmlspecialchars($_POST['id']);
    $trackingNumber = htmlspecialchars($_POST['tracking_number']);
    $status = htmlspecialchars($_POST['status']);
    $location = htmlspecialchars($_POST['location']);

    $stmt = $pdo->prepare("UPDATE tracking_info SET tracking_number = :tracking_number, status = :status, location = :location WHERE id = :id");
    $stmt->execute(['tracking_number' => $trackingNumber, 'status' => $status, 'location' => $location, 'id' => $id]);

    header("Location: view_tracking.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Tracking Info</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>
    <h2>Edit Tracking Info</h2>
    <form action="edit_tracking.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($info['id']); ?>">
        <label for="tracking_number">Tracking Number:</label>
        <input type="text" id="tracking_number" name="tracking_number" value="<?php echo htmlspecialchars($info['tracking_number']); ?>" required>
        <label for="status">Status:</label>
        <input type="text" id="status" name="status" value="<?php echo htmlspecialchars($info['status']); ?>" required>
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo htmlspecialchars($info['location']); ?>" required>
        <button type="submit">Update</button>
    </form>
</body>
</html>
