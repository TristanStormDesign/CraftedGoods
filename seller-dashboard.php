<?php
// Start the session
session_start();

// Redirect to seller login if the seller is not logged in
if (!isset($_SESSION['store_id'])) {
    header("Location: seller-login.php");
    exit();
}

// Include the database connection
include('db_connect.php');

// Fetch the store details
$store_id = $_SESSION['store_id'];
$stmt = $conn->prepare("SELECT * FROM stores WHERE id = ?");
$stmt->bind_param("i", $store_id);
$stmt->execute();
$store = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Fetch products for this store
$products = $conn->query("SELECT * FROM products WHERE store_id = $store_id");

// Initialize message variable for feedback
$message = '';

// Handle form submission for adding a product on the same page
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_name = '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_folder = 'images/' . $image_name;

        if (!move_uploaded_file($image_tmp, $image_folder)) {
            $message = "Failed to upload image.";
        }
    }

    // Insert the product into the database
    $stmt = $conn->prepare("INSERT INTO products (store_id, name, description, price, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issds", $store_id, $name, $description, $price, $image_name);

    if ($stmt->execute()) {
        $message = "Product added successfully!";
    } else {
        $message = "Error: " . $stmt->error;
    }

    $stmt->close();
    // Refresh products after adding a new one
    $products = $conn->query("SELECT * FROM products WHERE store_id = $store_id");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Dashboard - Crafted Goods</title>
    <link rel="stylesheet" href="css/seller-dashboard.css">
</head>
<body>
    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>

    <div class="dashboard-container">
        <!-- Banner Section -->
        <div class="dashboard-banner">
            <img src="images/<?= $store['logo'] ?>" alt="<?= $store['name'] ?>" class="store-logo">
            <h2>Welcome, <?= $store['name'] ?>!</h2>
            <p><?= $store['description'] ?: 'No description available.' ?></p>
        </div>

        <!-- Product Cards Section (Scrollable) -->
        <div class="product-list">
            <?php while ($product = $products->fetch_assoc()): ?>
                <div class="product-card">
                    <img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="product-image">
                    <h4><?= $product['name'] ?></h4>
                    <p><strong>Price: R<?= number_format($product['price'], 2) ?></strong></p>
                    <div class="product-actions">
                        <a href="edit-product.php?id=<?= $product['id'] ?>" class="button">Edit</a>
                        <a href="delete-product.php?id=<?= $product['id'] ?>" class="button delete-button">Delete</a>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>

        <!-- Add Product Section -->
        <div class="add-product-section">
            <h3>Add a New Product</h3>
            <?php if ($message): ?>
                <div class="message"><?= $message ?></div>
            <?php endif; ?>
            <form action="seller-dashboard.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="name" placeholder="Product Name" required>
                <textarea name="description" placeholder="Description" required></textarea>
                <input type="number" name="price" step="0.01" placeholder="Price" required>
                <input type="file" name="image" accept="image/*" required>
                <button type="submit">Add Product</button>
            </form>
        </div>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
</body>
</html>
