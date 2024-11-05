<?php
// Include the database connection
include('db_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Products - Crafted Goods</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/products.css"> <!-- Link to products.css -->
</head>
<body>
    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>

    <!-- Banner -->
    <header class="banner">
        <h1>Our Products</h1>
        <p>Explore a curated selection of handcrafted goods</p>
    </header>

    <!-- Products Grid -->
    <section class="products-grid">
        <?php
        // Fetch products from the database
        $products = $conn->query("SELECT * FROM products");

        // Display each product in a card
        while ($product = $products->fetch_assoc()): ?>
            <div class="product-card">
                <img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                <h3><?= $product['name'] ?></h3>
                <p><?= $product['description'] ?></p>
                <p><strong>Price: R<?= number_format($product['price'], 2) ?></strong></p>
                <a href="product.php?id=<?= $product['id'] ?>" class="view-button">View Product</a>
            </div>
        <?php endwhile; ?>
    </section>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
</body>
</html>
