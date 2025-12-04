<?php
session_start();
require 'php/config.php';

$isLoggedIn = isset($_SESSION['user_id']);
$role = ''; // domyślna rola
$username = '';

if ($isLoggedIn) {
    $user_id = $_SESSION['user_id'];
    $stmt = $pdo->prepare("SELECT username, role FROM users WHERE user_id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();

    if ($user) {
        $_SESSION['username'] = $user['username'];
        $username = $user['username'];
        $role = $user['role']; // 'admin' lub 'user'
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sklep internetowy</title>
    <link rel="icon" type="image/x-icon" href="favicon.avif">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/1ba5448ee9.js" crossorigin="anonymous"></script>

    <!-- Twoje style -->
    <link rel="stylesheet" href="styl.css">
    <link rel="stylesheet" href="styl2.css">
</head>

<body>

    <div class="dostawa">
        <p id="dostawa">DARMOWA DOSTAWA OD 300PLN</p>
    </div>

    <div class="menu">
    <div class="lewomenu">
        <a href="glowna.php">Home</a>
        <a href="admin/koszulki.php">Koszulki</a>
        <a href="rozmiary.html">Tabele rozmiarow</a>
        <a href="kontakt.html">Kontakt</a>
    </div>

    <img class="logo" src="../assets/zdjecia/logo.png" alt="Presige shop" height="50px">

    <div class="prawomenu">
        <?php if (!$isLoggedIn): ?>
            <a href="login.html" id="user"><i class="fa-regular fa-user"></i></a>
        <?php elseif ($role === 'admin'): ?>
            <a href="admin/admin.php" id="user"><i class="fa-regular fa-user"></i></a>
        <?php else: ?>
            <a href="panel.php" id="user"><i class="fa-regular fa-user"></i></a>
        <?php endif; ?>

        <a href="#"><i id="wyszukaj" class="fa-solid fa-magnifying-glass"></i></a>
        <a href="#"><i id="koszyk" class="fa-solid fa-cart-shopping"></i></a>
    </div>
</div>

    <div class="pasek">
        <div class="tekstpasek">
           <span>ZAPISZ SIE NA NEWSLETTER ZYSKAJ 10% ZNIZKI </span> 
           <span>ZAPISZ SIE NA NEWSLETTER ZYSKAJ 10% ZNIZKI </span> 
           <span>ZAPISZ SIE NA NEWSLETTER ZYSKAJ 10% ZNIZKI </span> 
           <span>ZAPISZ SIE NA NEWSLETTER ZYSKAJ 10% ZNIZKI </span> 
        </div>
    </div>

    <div class="duzezdjecia">
        <img src="../assets/zdjecia/glowna1.png" alt="zdjecie1">
        <div class="zdjprzycisk">
            <img src="../assets/zdjecia/glowna2.png" alt="zdjecie2">
            <a href="koszulki.php"><button class="przycisk">ZOBACZ WIECEJ</button></a>
        </div>
        <img src="../assets/zdjecia/glowna3.png" alt="zdjecie3">
    </div>

    <section class="bestsellery">
        <a href="koszulki.html"><button class="btn">ZOBACZ WIECEJ</button></a>

        <div class="slider-window">
            <h1>Bestsellery</h1>
            <div class="slider" id="slider">
                <div class="slide">
                    <div class="img-wrapper">
                        <img src="../assets/zdjecia/b1_1.png">
                        <img src="../assets/zdjecia/b1_2.png" class="hover">
                        <img src="../assets/zdjecia/b1_3.png">
                    </div>
                </div>

                <div class="slide">
                    <div class="img-wrapper">
                        <img src="../assets/zdjecia/b2_1.png">
                        <img src="../assets/zdjecia/b2_2.png" class="hover">
                        <img src="../assets/zdjecia/b2_3.png">
                    </div>
                </div>

                <div class="slide">
                    <div class="img-wrapper">
                        <img src="../assets/zdjecia/b3_1.png">
                        <img src="../assets/zdjecia/b3_2.png" class="hover">
                        <img src="../assets/zdjecia/b3_3.png">
                    </div>
                </div>

                <div class="slide">
                    <div class="img-wrapper">
                        <img src="../assets/zdjecia/b4_1.png">
                        <img src="../assets/zdjecia/b4_2.png" class="hover">
                        <img src="../assets/zdjecia/b4_3.png">
                    </div>
                </div>
            </div>

            <div class="znizka">
                <div class="znizkalewo">
                    <img src="../assets/zdjecia/znizka.png" height="1000px">
                </div>
                <div class="znizkaprawo">
                    <img src="../assets/zdjecia/logo.png" height="150px">
                    <p>UZYSKAJ 10% NA PIERWSZE ZAMOWIENIE</p>
                    <span>Zapisz sie na nasz newsletter, aby byc na biezaco</span>

                    <div class="inputzapisz">
                        <input type="email" id="email2" placeholder="Adres e-mail: ">
                        <button id="b2">Zapisz się</button>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <footer>
        &copy; 2025 Copyright harry potter
    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>
