<?php
// Include the database connection
include('db_connect.php');

// Get the store ID from the URL
$store_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the store details from the database
$stmt = $conn->prepare("SELECT * FROM stores WHERE id = ?");
$stmt->bind_param("i", $store_id);
$stmt->execute();
$store = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch products for this store
$products = $conn->query("SELECT * FROM products WHERE store_id = $store_id");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $store['name'] ?> - Crafted Goods</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/store.css"> <!-- Link to store.css -->
</head>
<body>
    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>

    <!-- Store Banner and Details -->
    <section class="store-banner">
        <div class="store-logo">
            <img src="images/<?= $store['logo'] ?>" alt="<?= $store['name'] ?>">
        </div>
        <div class="store-info">
            <h2><?= $store['name'] ?></h2>
            <p>Location: <?= $store['location'] ?></p>
            <p><?= $store['description'] ?></p>
        </div>
    </section>

    <!-- Products by Store -->
    <section class="store-products">
        <h3>Products by <?= $store['name'] ?></h3>
        <div class="products-grid">
            <?php while ($product = $products->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>">
                    <h4><?= $product['name'] ?></h4>
                    <p><?= $product['description'] ?></p>
                    <p><strong>Price: R<?= number_format($product['price'], 2) ?></strong></p>
                    <a href="product.php?id=<?= $product['id'] ?>" class="view-button">View Product</a>
                </div>
            <?php endwhile; ?>
        </div>
    </section>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
</body>
</html>
