<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);

    // sprawdzanie czy użytkownik istnieje
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        die("Nie znaleziono użytkownika z tym adresem email.");
    }

    // generowanie tokena resetu
    $token = bin2hex(random_bytes(32));
    $expires = date("Y-m-d H:i:s", time() + 3600); // ważny 1h

    // zapis tokena w bazie
    $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE email = ?");
    $stmt->execute([$token, $expires, $email]);

    $resetLink = "localhost/strona%20sklep/main/php/updatehaslo.php?token=" . $token;

    // konfiguracja PHPMailer
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'dominikkasprowicz253@gmail.com';
        $mail->Password = 'hddr zmnd rbex dnyl';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('twoj_email@gmail.com', 'Sklep');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Reset hasła';
        $mail->Body = 'Kliknij w link, aby ustawić nowe hasło: <br>
                       <a href="' . $resetLink . '">Resetuj hasło</a>';

        $mail->send();
        echo "Wysłano link resetujący na Twój email. Sprawdź skrzynkę.";
    } catch (Exception $e) {
        echo "Mail nie został wysłany. Błąd: {$mail->ErrorInfo}";
    }
}
?>