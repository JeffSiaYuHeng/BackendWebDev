<?php
session_start();
include __DIR__ . "/../../../backend/db_connect.php";

// Check if required data exists
if (!isset($_POST['payment_method']) || empty($_POST['payment_method'])) {
    die("Error: Please select a payment method.");
}

if (!isset($_SESSION['order_id']) || !isset($_SESSION['total_price'])) {
    die("Invalid Payment Request!");
}

$order_id = $_SESSION['order_id'];
$total_price = $_SESSION['total_price'];
$payment_method = $_POST['payment_method'];
$user_id = $_SESSION['user_id']; // Assuming user_id is stored in session

// Insert into payments table
$sql = "INSERT INTO payments (order_id, user_id, amount, status, created_at) VALUES (?, ?, ?, 'Pending', NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iid", $order_id, $user_id, $total_price);
$stmt->execute();
$payment_id = $stmt->insert_id; // Get the inserted payment ID
$stmt->close();

// Redirect to success page
header("Location:  /BackendWebDev/userpage/PaymentSuccessPage.php?payment_id=" . $payment_id);
exit();
?>
