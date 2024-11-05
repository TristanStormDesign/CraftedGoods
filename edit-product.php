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

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$store_id = $_SESSION['store_id'];

// Fetch the product details for the given product ID and store ID
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND store_id = ?");
$stmt->bind_param("ii", $product_id, $store_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

// If no product is found or product ID is invalid, redirect back to dashboard
if (!$product) {
    header("Location: seller-dashboard.php");
    exit();
}

// Handle form submission for updating product
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image_name = $product['image']; // Keep the old image by default

    // Handle image upload if a new image is provided
    if ($_FILES['image']['name']) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_folder = 'images/' . $image_name;

        if (!move_uploaded_file($image_tmp, $image_folder)) {
            echo "Failed to upload image.";
            exit();
        }
    }

    // Update product in the database
    $stmt = $conn->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ? AND store_id = ?");
    $stmt->bind_param("ssdssi", $name, $description, $price, $image_name, $product_id, $store_id);
    
    if ($stmt->execute()) {
        header("Location: seller-dashboard.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Crafted Goods</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/navbar.css"> <!-- Navbar styling -->
    <link rel="stylesheet" href="css/footer.css"> <!-- Footer styling -->
    <link rel="stylesheet" href="css/edit-product.css"> <!-- Page-specific styling -->
</head>
<body>
    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>

    <div class="dashboard-wrapper">
        <h2>Edit Product</h2>
        
        <section class="edit-product">
            <form action="edit-product.php?id=<?= $product_id ?>" method="POST" enctype="multipart/form-data">
                <label for="name">Product Name:</label>
                <input type="text" id="name" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

                <label for="description">Description:</label>
                <textarea id="description" name="description" required><?= htmlspecialchars($product['description']) ?></textarea>

                <label for="price">Price:</label>
                <input type="number" id="price" name="price" step="0.01" value="<?= htmlspecialchars($product['price']) ?>" required>

                <label for="image">Image:</label>
                <input type="file" id="image" name="image">
                <p>Current Image:</p>
                <img src="images/<?= htmlspecialchars($product['image']) ?>" alt="Product Image" width="150">

                <button type="submit" class="update-btn">Update Product</button>
            </form>
        </section>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
</body>
</html>

