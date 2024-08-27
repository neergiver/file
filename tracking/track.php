<?php
include 'header.php';
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tracking_number = htmlspecialchars($_POST['tracking_number']);

    $stmt = $pdo->prepare("SELECT * FROM tracking_info WHERE tracking_number = :tracking_number");
    $stmt->execute(['tracking_number' => $tracking_number]);
    $tracking_info = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tracking_info) {
        echo "<h2>Tracking Information</h2>";
        echo "<p>Tracking Number: " . htmlspecialchars($tracking_info['tracking_number']) . "</p>";
        echo "<p>Status: " . htmlspecialchars($tracking_info['status']) . "</p>";
        echo "<p>Location: " . htmlspecialchars($tracking_info['location']) . "</p>";
        echo "<p>Timestamp: " . htmlspecialchars($tracking_info['timestamp']) . "</p>";
    } else {
        echo "<p>No tracking information found for this tracking number.</p>";
    }
}
?>
