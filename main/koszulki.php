<?php
require 'php/config.php';

$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

$where = [];
$params = [];

if (!empty($_GET['category'])) {
    $where[] = "p.product_category = ?";
    $params[] = $_GET['category'];
}

if (!empty($_GET['search'])) {
    $where[] = "p.product_name LIKE ?";
    $params[] = "%".$_GET['search']."%";
}

$order = "p.product_name ASC"; 
if (!empty($_GET['sort'])) {
    if ($_GET['sort'] == "price_asc") $order = "p.product_price ASC";
    if ($_GET['sort'] == "price_desc") $order = "p.product_price DESC";
}

$sql = "SELECT p.product_id, p.product_name, p.product_price, p.product_image, c.category_name 
        FROM products p 
        LEFT JOIN categories c ON p.product_category = c.category_id";

if ($where) $sql .= " WHERE ".implode(" AND ", $where);

$sql .= " ORDER BY $order";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Koszulki</title>
    <link rel="stylesheet" href="styl.css">
    <link rel="stylesheet" href="styl2.css">
</head>
<body>
<div class="dostawa">
        <p id="dostawa">DARMOWA DOSTAWA OD 300PLN</p>
    </div>   
    <div class="menu">
        <div class="lewomenu">
        <a href="glowna.html">Home</a>
        <a href="koszulki.html">Koszulki</a>

        <a href="rozmiary.html">Tabele rozmiarow</a>
        <a href="kontakt.html">Kontakt</a>
    </div>
        <img class="logo" src="../assets/zdjecia/logo.png" alt="Presige shop" height="50px" >
        <div class="prawomenu">
        <a href="#"><i id="wyszukaj" class="fa-solid fa-magnifying-glass" ></i></a>
        <a href="login.html"><i id="user" class="fa-regular fa-user"></i></a>
        <a href="#"><i id="koszyk" class="fa-solid fa-cart-shopping"></i></a>
    </div>
</div>



    </div>

    <div class="filter-container">
        <form method="GET">
            <input type="text" name="search" placeholder="Szukaj produktu" value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
            <select name="category">
                <option value="">Wszystkie kategorie</option>
                <?php foreach($categories as $cat): ?>
                    <option value="<?= $cat['category_id'] ?>" <?= (!empty($_GET['category']) && $_GET['category']==$cat['category_id'])?'selected':'' ?>><?= htmlspecialchars($cat['category_name']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="sort">
                <option value="">Sortuj</option>
                <option value="price_asc" <?= (!empty($_GET['sort']) && $_GET['sort']=='price_asc')?'selected':'' ?>>Cena rosnąco</option>
                <option value="price_desc" <?= (!empty($_GET['sort']) && $_GET['sort']=='price_desc')?'selected':'' ?>>Cena malejąco</option>
            </select>
            <button type="submit">Filtruj</button>
        </form>
    </div>

    <div class="products-grid">
        <?php foreach($products as $p): ?>
            <div class="product-card">
                <img src="<?= $p['product_image'] ?>" alt="<?= htmlspecialchars($p['product_name']) ?>">
                <h3><?= htmlspecialchars($p['product_name']) ?></h3>
                <p><?= $p['product_price'] ?> PLN</p>
                <p>Kategoria: <?= htmlspecialchars($p['category_name']) ?></p>
                <a href="product.php?id=<?= $p['product_id'] ?>">Szczegóły</a>
            </div>
        <?php endforeach; ?>
        <?php if(count($products)==0) echo "<p>Brak produktów do wyświetlenia.</p>"; ?>
    </div>
    <footer>
        <p>&copy;2025 Copyright prestige shop.</p>
    </footer>
</body>
</html>
