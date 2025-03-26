<?php
session_start();
include "../backend/db_connect.php";

// Check if payment_id is set
if (!isset($_GET['payment_id'])) {
    die("Invalid Payment!");
}

$payment_id = $_GET['payment_id'];

// Fetch payment details
$sql = "SELECT p.order_id, p.amount, p.status, p.created_at, o.user_id 
        FROM payments p 
        JOIN orders o ON p.order_id = o.id 
        WHERE p.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $payment_id);
$stmt->execute();
$stmt->bind_result($order_id, $amount, $status, $created_at, $user_id);
$stmt->fetch();
$stmt->close();

if (!$order_id) {
    die("Payment not found!");
}

// Fetch user details (Corrected column names)
$sql_user = "SELECT first_name, last_name, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql_user);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $email);
$stmt->fetch();
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
</head>
<body>
    <h2>Payment Successful</h2>
    <p>Thank you, <strong><?php echo htmlspecialchars($first_name . " " . $last_name); ?></strong>!</p>
    <p>Your payment has been received.</p>
    <p><strong>Order ID:</strong> #<?php echo $order_id; ?></p>
    <p><strong>Amount Paid:</strong> RM <?php echo number_format($amount, 2); ?></p>
    <p><strong>Status:</strong> <?php echo $status; ?></p>
    <p><strong>Payment Date:</strong> <?php echo $created_at; ?></p>
    
    <a href="ViewOrderRecord.php">View Order Record</a>
</body>
</html>
