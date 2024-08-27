<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = htmlspecialchars($_POST['token']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE password_reset_token = :token");
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $stmt = $pdo->prepare("UPDATE users SET password = :password, password_reset_token = NULL WHERE id = :id");
        $stmt->execute(['password' => $password, 'id' => $user['id']]);
        echo "Password has been reset successfully.";
    } else {
        echo "Invalid token.";
    }
}
?>
