<?php
// Start session
session_start();

// Include database connection
include('db_connect.php');

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch product details from the database
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$product = $stmt->get_result()->fetch_assoc();
$stmt->close();

// Handle "Add to Cart" action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$product_id] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => 1,
            'image' => $product['image']
        ];
    }
    header("Location: cart.php");
    exit();
}

// Handle Comment Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_comment']) && isset($_SESSION['user_id'])) {
    $comment = $_POST['comment'];
    $rating = intval($_POST['rating']);
    $user_id = $_SESSION['user_id'];
    
    $stmt = $conn->prepare("INSERT INTO comments (product_id, user_id, comment, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("iisi", $product_id, $user_id, $comment, $rating);
    $stmt->execute();
    $stmt->close();

    // Refresh the page to show the new comment
    header("Location: product.php?id=" . $product_id);
    exit();
}

// Fetch Comments for this Product
$comments = $conn->query("SELECT c.comment, c.rating, c.created_at, u.username 
                          FROM comments c 
                          JOIN users u ON c.user_id = u.id 
                          WHERE c.product_id = $product_id 
                          ORDER BY c.created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product['name'] ?> - Crafted Goods</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/product.css">
</head>
<body>
    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>

    <!-- Product Content Wrapper -->
    <div class="product-wrapper">
        <!-- Left Block: Product Image -->
        <div class="product-image-block">
            <img src="images/<?= $product['image'] ?>" alt="<?= $product['name'] ?>" class="product-image">
        </div>

        <!-- Middle Block: Product Info and Add to Cart -->
        <div class="product-info">
            <h2><?= $product['name'] ?></h2>
            <p><?= $product['description'] ?></p>
            <p><strong>Price: R<?= number_format($product['price'], 2) ?></strong></p>
            <form action="product.php?id=<?= $product['id'] ?>" method="POST">
                <button type="submit" name="add_to_cart" class="add-to-cart-button">Add to Cart</button>
            </form>

            <!-- Comment Form -->
            <div class="comment-form">
                <h3>Leave a Comment</h3>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form action="product.php?id=<?= $product['id'] ?>" method="POST">
                        <textarea name="comment" placeholder="Write your comment here..." required></textarea>
                        <label for="rating">Rate this product:</label>
                        <select name="rating" id="rating" required>
                            <option value="5">★★★★★ (5)</option>
                            <option value="4">★★★★☆ (4)</option>
                            <option value="3">★★★☆☆ (3)</option>
                            <option value="2">★★☆☆☆ (2)</option>
                            <option value="1">★☆☆☆☆ (1)</option>
                        </select>
                        <button type="submit" name="submit_comment" class="submit-comment-button">Submit Comment</button>
                    </form>
                <?php else: ?>
                    <p>Please <a href="login.php">login</a> to leave a comment.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Right Block: Customer Reviews -->
        <div class="comments-section">
            <h3>Customer Reviews</h3>
            <div class="comments-grid">
                <?php while ($comment = $comments->fetch_assoc()): ?>
                    <div class="comment">
                        <p><strong><?= htmlspecialchars($comment['username']) ?></strong> - <?= htmlspecialchars($comment['rating']) ?>★</p>
                        <p><?= htmlspecialchars($comment['comment']) ?></p>
                        <small><?= htmlspecialchars($comment['created_at']) ?></small>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
</body>
</html>
