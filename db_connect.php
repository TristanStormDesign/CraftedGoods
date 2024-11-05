<?php
// db_connect.php - Database connection file
$host = 'localhost';
$user = 'root'; // Default XAMPP user
$pass = ''; // Default XAMPP password is empty
$db = 'craftedgoods';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
