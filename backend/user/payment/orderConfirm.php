<?php

include __DIR__ . "/../../../backend/db_connect.php";
// Check if order_id is set
if (!isset($_GET['order_id'])) {
    echo "Invalid Order!";
    exit();
}

$order_id = $_GET['order_id'];

// Fetch Order Details
$sql = "SELECT total_price FROM orders WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$stmt->bind_result($total_price);
$stmt->fetch();
$stmt->close();

// Check if order exists
if ($total_price === null) {
    echo "Order not found!";
    exit();
}

// Store order details in session for payment
$_SESSION['order_id'] = $order_id;
$_SESSION['total_price'] = $total_price;
?>