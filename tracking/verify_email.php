<?php
include 'config.php';

if (isset($_GET['token'])) {
    $token = htmlspecialchars($_GET['token']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE verification_token = :token");
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $stmt = $pdo->prepare("UPDATE users SET email_verified = TRUE, verification_token = NULL WHERE id = :id");
        $stmt->execute(['id' => $user['id']]);
        echo "Email verification successful!";
    } else {
        echo "Invalid verification token.";
    }
} else {
    echo "No verification token provided.";
}
?>
