<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute(['username' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $token = bin2hex(random_bytes(50));
        $stmt = $pdo->prepare("UPDATE users SET password_reset_token = :token WHERE username = :username");
        $stmt->execute(['token' => $token, 'username' => $username]);

        $resetLink = "http://yourwebsite.com/password_reset.php?token=$token";
        // Send email to the user with the reset link (using a mail function or service)
        // Example (using mail function):
        $to = $user['username']; // Assuming the username is the email
        $subject = "Password Reset Request";
        $message = "Click the following link to reset your password: $resetLink";
        $headers = "From: no-reply@yourwebsite.com";

        if (mail($to, $subject, $message, $headers)) {
            echo "Password reset link has been sent to your email.";
        } else {
            echo "Failed to send the password reset link.";
        }
    } else {
        echo "User not found.";
    }
}
?>
