<?php
include "../../db_connect.php"; // Include database connection
// Check if 'id' is set in the URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Product not found.";
    exit();
}

$product_id = intval($_GET['id']); // Sanitize ID input

// Fetch product details from database
$sql = "SELECT name, type, price, image, description FROM products WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Product not found.";
    exit();
}

$product = $result->fetch_assoc();
$conn->close();
?>