<?php
// Start session
session_start();

// Handle quantity updates and removal
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];

    // Update quantity
    if (isset($_POST['update_quantity'])) {
        $new_quantity = intval($_POST['quantity']);
        if ($new_quantity > 0) {
            $_SESSION['cart'][$product_id]['quantity'] = $new_quantity;
        } else {
            unset($_SESSION['cart'][$product_id]); // Remove item if quantity is zero or less
        }
    }

    // Remove item
    if (isset($_POST['remove_item'])) {
        unset($_SESSION['cart'][$product_id]);
    }
}

// Calculate total
$total = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart - Crafted Goods</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/cart.css">
</head>

<body>
    <!-- Navbar -->
    <?php include('includes/navbar.php'); ?>

    <section class="cart">
        <h2>Your Shopping Cart</h2>

        <?php if (empty($_SESSION['cart'])): ?>
            <p class="empty-cart">Your cart is empty. <a href="products.php">Continue shopping</a>.</p>
        <?php else: ?>
            <div class="cart-table-container">
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Subtotal</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $id => $item): ?>
                            <tr>
                                <td class="product-info">
                                    <img src="images/<?= $item['image'] ?>" alt="<?= $item['name'] ?>" class="product-image">
                                    <span><?= $item['name'] ?></span>
                                </td>
                                <td>R<?= number_format($item['price'], 2) ?></td>
                                <td>
                                    <form action="cart.php" method="POST">
                                        <input type="hidden" name="product_id" value="<?= $id ?>">
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1"
                                            class="quantity-input">
                                        <button type="submit" name="update_quantity" class="update-btn">Update</button>
                                    </form>
                                </td>
                                <td>R<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                                <td>
                                    <form action="cart.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="product_id" value="<?= $id ?>">
                                        <button type="submit" name="remove_item" class="remove-btn">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            <?php $total += $item['price'] * $item['quantity']; ?>
                        <?php endforeach; ?>
                        <tr class="total-row">
                            <td colspan="3"><strong>Total:</strong></td>
                            <td><strong>R<?= number_format($total, 2) ?></strong></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="checkout-container">
                <button onclick="window.location.href='checkout.php'" class="checkout-btn">Proceed to Checkout</button>
            </div>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <?php include('includes/footer.php'); ?>
</body>

</html>