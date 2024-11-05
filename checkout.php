<?php
// Start the session
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Clear the cart
unset($_SESSION['cart']); // Clear the cart after successful checkout

// Display success message
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Crafted Goods</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/checkout.css">
</head>
<body>
    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>

    <!-- Checkout Success Section -->
    <section class="checkout-success">
        <div class="checkout-content">
            <h2>Checkout Successful</h2>
            <p>Thank you for your purchase! Your order has been processed successfully.</p>
            <a href="products.php" class="continue-shopping-btn">Continue Shopping</a>
        </div>
    </section>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
</body>
</html>
