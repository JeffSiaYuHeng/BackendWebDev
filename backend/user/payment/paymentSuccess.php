<?php
include __DIR__ . "/../../../backend/db_connect.php";
// Check if payment_id is set
if (!isset($_GET['payment_id'])) {
    die("Invalid Payment!");
}

$payment_id = $_GET['payment_id'];

// Fetch payment and order details, including delivery method
$sql = "SELECT p.order_id, p.amount, p.status, p.created_at, o.user_id, o.delivery_method 
        FROM payments p 
        JOIN orders o ON p.order_id = o.id 
        WHERE p.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $payment_id);
$stmt->execute();
$stmt->bind_result($order_id, $amount, $status, $created_at, $user_id, $delivery_method);
$stmt->fetch();
$stmt->close();

if (!$order_id) {
    die("Payment not found!");
}

// Fetch user details
$sql_user = "SELECT first_name, last_name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql_user);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $email);
$stmt->fetch();
$stmt->close();
?>