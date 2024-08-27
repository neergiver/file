<?php
// functions.php

function log_activity($admin_id, $action) {
    include 'config.php';
    $stmt = $pdo->prepare("INSERT INTO activity_logs (admin_id, action) VALUES (:admin_id, :action)");
    $stmt->execute(['admin_id' => $admin_id, 'action' => $action]);
}
?>
