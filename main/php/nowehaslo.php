<?php
require 'config.php';

$token = $_GET['token'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM users WHERE reset_token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user || strtotime($user['reset_expires']) < time()) {
    die("Token nieprawidłowy lub wygasł.");
}
?>

<form action="update_password.php" method="POST">
  <input type="hidden" name="token" value="<?php echo $token; ?>">
  <input type="password" name="password" placeholder="Nowe hasło">
  <input type="password" name="password2" placeholder="Powtórz hasło">
  <button type="submit">Zmień hasło</button>
</form>
