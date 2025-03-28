<?php
session_start();
include __DIR__ . "/../../../backend/db_connect.php";

// Check if required data exists
if (!isset($_POST['payment_method']) || empty($_POST['payment_method'])) {
    die("Error: Please select a payment method.");
}

if (!isset($_POST['delivery_method']) || empty($_POST['delivery_method'])) {
    die("Error: Please select a delivery method.");
}

if (!isset($_SESSION['order_id']) || !isset($_SESSION['total_price'])) {
    die("Invalid Payment Request!");
}

$order_id = $_SESSION['order_id'];
$total_price = $_SESSION['total_price'];
$payment_method = $_POST['payment_method'];
$delivery_method = $_POST['delivery_method'];
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

// Update the order to include the selected delivery method
$sql = "UPDATE orders SET delivery_method = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $delivery_method, $order_id);
$stmt->execute();
$stmt->close();

// Insert into payments table
$sql = "INSERT INTO payments (order_id, user_id, amount, status, created_at) VALUES (?, ?, ?, 'Pending', NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iid", $order_id, $user_id, $total_price);
$stmt->execute();
$payment_id = $stmt->insert_id; // Get the inserted payment ID
$stmt->close();

// Redirect to success page
header("Location: /BackendWebDev/userpage/payment/PaymentSuccessPage.php?payment_id=" . $payment_id);
exit();
?>