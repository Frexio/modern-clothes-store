<?php
session_start();
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];


    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        die("Nie znaleziono użytkownika o tym emailu.");
    }


    if (password_verify($password, $user['passwd'])) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['username'] = $user['username'];
        echo "Zalogowano pomyślnie. <a href='../glowna.html'>Przejdź do sklepu</a>";
    } else {
        die("Nieprawidłowe hasło.");
    }
}
?>
