<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/navbar.css"> <!-- Link to navbar.css -->
</head>
<body>

<nav class="navbar">
    <div class="logo"><a href="index.php"><img src="images/logo.png" alt="Crafted Goods" class="logo-img"></a></div>
    <ul>
        <li><a href="index.php">Home</a></li>
        <li><a href="stores.php">Stores</a></li>
        <li><a href="products.php">Products</a></li>
    </ul>
    <div class="nav-icons">
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Regular user is logged in -->
            <a href="cart.php"><img src="images/cart.png" alt="Cart" class="cart-icon"></a>
            <a href="logout.php" class="button">Logout</a>
        <?php elseif (isset($_SESSION['store_id'])): ?>
            <!-- Seller is logged in -->
            <a href="seller-dashboard.php" class="button">Dashboard</a>
            <a href="logout.php" class="button">Logout</a>
        <?php else: ?>
            <!-- No user is logged in -->
            <a href="login.php" class="button">Login</a>
            <a href="seller-login.php" class="button">Seller Login</a>
        <?php endif; ?>
    </div>
</nav>

</body>
</html>
