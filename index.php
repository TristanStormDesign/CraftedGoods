<?php
// Include the database connection
include('db_connect.php');

// Fetch 5 random products and 5 random stores
$products = $conn->query("SELECT * FROM products ORDER BY RAND() LIMIT 5");
$stores = $conn->query("SELECT * FROM stores ORDER BY RAND() LIMIT 5");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crafted Goods</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css"> <!-- Link to index.css -->
</head>
<body>
    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>
    
    <!-- Banner Section -->
    <header class="banner">
        <h1>Welcome to Crafted Goods</h1>
        <p>Your one-stop shop for South African handcrafted furniture</p>
    </header>

    <!-- Info Blocks Section -->
    <section class="info-blocks">
        <div class="block">Support Local Artisans</div>
        <div class="block">Unique, High-Quality Furniture</div>
        <div class="block">Easy, Secure Shopping</div>
    </section>

    <!-- Popular Products Section -->
    <section class="popular-products">
        <h2>Popular Products</h2>
        <div class="products-row">
            <?php while($product = $products->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                    <h3><?= $product['name'] ?></h3>
                    <p><?= $product['description'] ?></p>
                    <a href="product.php?id=<?= $product['id'] ?>" class="view-button">View Product</a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- Popular Stores Section -->
    <section class="popular-stores">
        <h2>Popular Stores</h2>
        <div class="stores-row">
            <?php while($store = $stores->fetch_assoc()): ?>
                <div class="store-card">
                    <img src="images/<?= $store['logo'] ?>" alt="<?= $store['name'] ?>">
                    <h3><?= $store['name'] ?></h3>
                    <p>Location: <?= $store['location'] ?></p>
                    <a href="store.php?id=<?= $store['id'] ?>" class="view-button">View Store</a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
</body>
</html>
