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

// Get the product ID from the URL and the store ID from the session
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$store_id = $_SESSION['store_id'];

// Check if both $product_id and $store_id are set correctly
if ($product_id === 0 || $store_id === 0) {
    $_SESSION['message'] = "Invalid product or store ID.";
    header("Location: seller-dashboard.php");
    exit();
}

// Prepare and execute the delete statement
$stmt = $conn->prepare("DELETE FROM products WHERE id = ? AND store_id = ?");
if ($stmt === false) {
    $_SESSION['message'] = "Failed to prepare the statement: " . $conn->error;
    header("Location: seller-dashboard.php");
    exit();
}

$stmt->bind_param("ii", $product_id, $store_id);

if ($stmt->execute()) {
    $_SESSION['message'] = "Product deleted successfully!";
} else {
    $_SESSION['message'] = "Failed to delete the product: " . $stmt->error;
}

$stmt->close();
header("Location: seller-dashboard.php");
exit();
?>
