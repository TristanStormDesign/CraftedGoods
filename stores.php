<?php
// Include the database connection
include('db_connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Stores - Crafted Goods</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/stores.css"> <!-- Link to stores.css -->
</head>
<body>
    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>

    <!-- Banner -->
    <header class="banner">
        <h1>Our Stores</h1>
        <p>Discover our local artisans and furniture makers</p>
    </header>

    <!-- Stores Grid -->
    <section class="stores-grid">
        <?php
        // Fetch stores from the database
        $stores = $conn->query("SELECT * FROM stores");

        // Display each store in a card
        while ($store = $stores->fetch_assoc()): ?>
            <div class="store-card">
                <img src="images/<?= $store['logo'] ?>" alt="<?= $store['name'] ?>">
                <h3><?= $store['name'] ?></h3>
                <p>Location: <?= $store['location'] ?></p>
                <a href="store.php?id=<?= $store['id'] ?>" class="view-button">View Store</a>
            </div>
        <?php endwhile; ?>
    </section>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
</body>
</html>
