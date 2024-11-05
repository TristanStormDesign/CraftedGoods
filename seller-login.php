<?php
// Start the session
session_start();

// Include the database connection
include('db_connect.php');

// Initialize message variable
$message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $store_name = $_POST['store_name'];
    $password = $_POST['password'];

    // For this setup, we're assuming all sellers have the password "1234"
    if ($password === '1234') {
        // Retrieve store data from the database
        $stmt = $conn->prepare("SELECT id FROM stores WHERE name = ?");
        $stmt->bind_param("s", $store_name);
        $stmt->execute();
        $stmt->store_result();

        // Check if a store with that name exists
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($store_id);
            $stmt->fetch();

            // Store ID is correct; set session variables
            $_SESSION['store_id'] = $store_id;
            $_SESSION['store_name'] = $store_name;

            // Redirect to the seller dashboard
            header("Location: seller-dashboard.php");
            exit();
        } else {
            $message = "No account found with that store name.";
        }

        $stmt->close();
    } else {
        $message = "Incorrect password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Login - Crafted Goods</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/seller-login.css">
</head>
<body>
    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>

    <div class="seller-login-wrapper">
        <!-- Display message if any -->
        <?php if ($message): ?>
            <div class="message <?= strpos($message, 'successful') !== false ? 'success' : 'error' ?>">
                <?= $message ?>
            </div>
        <?php endif; ?>

        <section class="seller-login-form">
            <h2>Seller Login</h2>
            <form action="seller-login.php" method="POST">
                <label for="store_name">Store Name:</label>
                <input type="text" id="store_name" name="store_name" required>

                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>

                <button type="submit" class="login-btn">Login</button>
            </form>
            <p>Not a seller? <a href="index.php">Go back to the main site</a></p>
        </section>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
</body>
</html>
