<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $confirmPassword = htmlspecialchars($_POST['confirm_password']);

    if ($password !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $verificationToken = bin2hex(random_bytes(50));

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, password, verification_token) VALUES (:username, :password, :verification_token)");
        $stmt->execute(['username' => $username, 'password' => $hashedPassword, 'verification_token' => $verificationToken]);

        $verificationLink = "http://yourwebsite.com/verify_email.php?token=$verificationToken";
        $to = $username;
        $subject = "Email Verification";
        $message = "Click the following link to verify your email: $verificationLink";
        $headers = "From: no-reply@yourwebsite.com";

        if (mail($to, $subject, $message, $headers)) {
            echo "Registration successful! A verification email has been sent to your email address.";
        } else {
            echo "Failed to send the verification email.";
        }
    } catch (PDOException $e) {
        if ($e->errorInfo[1] == 1062) {
            echo "Username already taken.";
        } else {
            echo "Error: " . $e->getMessage();
        }
    }
}
?>
