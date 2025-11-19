<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once "config.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Niepoprawne wywołanie.'); // <- to jest teraz poprawnie zabezpieczone
}

$token = $_POST['token'] ?? '';
$password = $_POST['password'] ?? '';
$password2 = $_POST['password2'] ?? '';

if (!$token || !$password || !$password2) {
    die('Wypełnij wszystkie pola.');
}

if ($password !== $password2) {
    die('Hasła nie są takie same.');
}

// Sprawdzenie tokena w bazie
$stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user || strtotime($user['reset_expires']) < time()) {
    die('Token jest nieprawidłowy lub wygasł.');
}

// Hashowanie i zapis nowego hasła
$hashed = password_hash($password, PASSWORD_DEFAULT);
$stmt = $pdo->prepare("
    UPDATE users 
    SET passwd = ?, reset_token = NULL, reset_expires = NULL 
    WHERE user_id = ?
");
$stmt->execute([$hashed, $user['user_id']]);

echo "Hasło zostało zmienione! Możesz się teraz zalogować.";
?>
