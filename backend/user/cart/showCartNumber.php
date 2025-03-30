<?php
// Include database connection
include __DIR__ . "/../../../backend/db_connect.php";

$user_id = $_SESSION['user_id'];

// Fetch the count of items in the cart
$sql = "SELECT SUM(quantity) AS cart_count FROM cart_items WHERE cart_id = (SELECT id FROM cart WHERE user_id = ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$cart_count = $row['cart_count'] ?? 0; // If NULL, default to 0
$stmt->close();

?>