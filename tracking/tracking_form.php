<?php
include 'header.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login_form.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Track Your Package</title>
    <link rel="stylesheet" type="text/css" href="assets/style.css">
</head>
<body>
    <h2>Track Your Package</h2>
    <form action="track.php" method="post">
        <label for="tracking_number">Enter Tracking Number:</label>
        <input type="text" id="tracking_number" name="tracking_number" required>
        <button type="submit">Track</button>
    </form>
</body>
</html>
