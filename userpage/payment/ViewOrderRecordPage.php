<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Please log in to view your order history.");
}

$user_id = $_SESSION['user_id'];

include "../../backend/user/payment/viewOrderRecord.php";
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

    <div id="orders" class="section">
        <?php if ($orders_result->num_rows > 0): ?>
            <table border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <th>Order ID</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Size</th>
                    <th>Status</th>
                    <th>Delivery Method</th>
                    <th>Payment Amount</th>
                    <th>Accessories</th>
                    <th>Order Date</th>
                    <th>Payment Status</th>
                    <th>Review</th>
                </tr>

                <?php while ($order = $orders_result->fetch_assoc()): ?>
                    <tr>
                        <td>#<?= $order['order_id']; ?></td>
                        <td><?= htmlspecialchars($order['product_name']); ?></td>
                        <td><?= $order['quantity']; ?></td>
                        <td><?= htmlspecialchars($order['size']); ?></td>
                        <td><?= $order['status']; ?></td>
                        <td><?= $order['delivery_method']; ?></td>
                        <td><?= $order['payment_amount'] ? number_format($order['payment_amount'], 2) : 'N/A'; ?></td>
                        <td><?= $order['accessories'] ? $order['accessories'] : 'No Accessories'; ?></td>
                        <td><?= $order['created_at']; ?></td>
                        <td><?= $order['payment_status'] ? $order['payment_status'] : 'Not Paid'; ?></td>
                        <td>
                            <?php if ($order['payment_status'] === 'Paid' && $order['status'] === 'Delivered'): ?>
                                <a href="ReviewPage.php?order_id=<?= $order['order_id']; ?>&product_id=<?= $order['product_id']; ?>">
                                    Review
                                </a>
                            <?php elseif ($order['status'] === 'Pending'): ?>
                                Waiting to be Delivered
                            <?php else: ?>
                                Waiting to be completed
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php else: ?>
            <p>No orders found.</p>
        <?php endif; ?>
    </div>

    <a href="/BackendWebDev/userpage/product/MainPage.php">Back to Home</a>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>
