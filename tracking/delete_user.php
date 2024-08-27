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
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $stmt->execute(['id' => $id]);

    log_activity($_SESSION['admin_id'], "Deleted user ID $id");

    header("Location: manage_users.php");
    exit();
}
?>
