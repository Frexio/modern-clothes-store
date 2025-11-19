<?php
require 'config.php'; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if (empty($username) || empty($email) || empty($password) || empty($password2)) {
        die("Wszystkie pola są wymagane.");
    }

    if ($password !== $password2) {
        die("Hasła nie są takie same.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Nieprawidłowy adres email.");
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        die("Użytkownik z tym emailem już istnieje.");
    }
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (username, email, passwd) VALUES (?, ?, ?)");
    $stmt->execute([$username, $email, $hash]);

    header("Location: ../login.html");
}
?>
