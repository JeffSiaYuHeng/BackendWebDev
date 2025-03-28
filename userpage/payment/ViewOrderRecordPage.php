<?php
session_start();


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please log in to view your order history.");
}

$user_id = $_SESSION['user_id'];

include "../../backend/user/payment/viewOrderRecord.php"
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
</head>

<body>
    <h2>Your Order History</h2>

    <?php if ($orders_result->num_rows > 0): ?>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Total Price (RM)</th>
            <th>Order Status</th>
            <th>Delivery Method</th> <!-- Added Delivery Method -->
            <th>Order Date</th>
            <th>Payment Amount (RM)</th>
            <th>Payment Status</th>
            <th>Payment Date</th>
            <th>Accessories</th>
        </tr>
        <?php while ($order = $orders_result->fetch_assoc()): ?>
        <tr>
            <td>#<?php echo $order['order_id']; ?></td>
            <td><?php echo number_format($order['total_price'], 2); ?></td>
            <td><?php echo $order['status']; ?></td>
            <td><?php echo $order['delivery_method']; ?></td> <!-- Display Delivery Method -->
            <td><?php echo $order['created_at']; ?></td>
            <td><?php echo $order['payment_amount'] ? number_format($order['payment_amount'], 2) : 'N/A'; ?></td>
            <td><?php echo $order['payment_status'] ? $order['payment_status'] : 'Not Paid'; ?></td>
            <td><?php echo $order['payment_date'] ? $order['payment_date'] : 'N/A'; ?></td>
            <td><?php echo $order['accessories'] ? $order['accessories'] : 'No Accessories'; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
    <p>No orders found.</p>
    <?php endif; ?>

    <a href="/BackendWebDev/userpage/product/MainPage.php">Back to Home</a>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>