<?php
include __DIR__ . "../../../backend/db_connect.php";

// Fetch all orders for all users, grouping accessories and payments, including delivery method
$sql = "SELECT o.id AS order_id, 
               o.user_id, 
               o.total_price, 
               o.status, 
               o.delivery_method, -- Added delivery_method
               o.created_at, 
               MAX(p.amount) AS payment_amount, 
               MAX(p.status) AS payment_status, 
               MAX(p.created_at) AS payment_date,
               GROUP_CONCAT(DISTINCT a.name SEPARATOR ', ') AS accessories,
               u.first_name, 
               u.last_name, 
               u.email 
        FROM orders o
        LEFT JOIN payments p ON o.id = p.order_id
        LEFT JOIN order_accessories oa ON o.id = oa.order_id
        LEFT JOIN accessories a ON oa.accessory_id = a.id
        LEFT JOIN users u ON o.user_id = u.id
        GROUP BY o.id
        ORDER BY o.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->execute();
$orders_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders - Admin</title>
    <link rel="stylesheet" href="../adminstyle/orders.css"> <!-- Ensure you have a CSS file for styling -->
</head>

<body>

    <!-- Header -->
    <header>
        <div class="logo">
            <h1>Admin Dashboard</h1>
        </div>
        <nav>
            <ul>
                <li><a href="/BackendWebDev/admin/adminpage/MainPage.php">Home</a></li>
                <li><a href="manageUsers.php">Manage Users</a></li>
                <li><a href="orders.php" class="active">Orders</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="accessories.php">Accessories</a></li>
                <li><a href="payments.php">Payments</a></li>
                <li><a href="analytics.php">Analytics</a></li>
                <li><a href="../../backend/admin/authenticate/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>
    <section class="order-management">
        <h2>All Orders</h2>

        <?php if ($orders_result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Total Price (RM)</th>
                    <th>Order Status</th>
                    <th>Delivery Method</th>
                    <th>Order Date</th>
                    <th>Payment Amount (RM)</th>
                    <th>Payment Status</th>
                    <th>Payment Date</th>
                    <th>Accessories</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders_result->fetch_assoc()): ?>
                <tr>
                    <td>#<?php echo $order['order_id']; ?></td>
                    <td><?php echo $order['first_name'] . " " . $order['last_name']; ?><br>
                        <?php echo $order['email']; ?></td>
                    <td><?php echo number_format($order['total_price'], 2); ?></td>
                    <td><?php echo $order['status']; ?></td>
                    <td><?php echo $order['delivery_method']; ?></td>
                    <td><?php echo $order['created_at']; ?></td>
                    <td><?php echo $order['payment_amount'] ? number_format($order['payment_amount'], 2) : 'N/A'; ?>
                    </td>
                    <td><?php echo $order['payment_status'] ? $order['payment_status'] : 'Not Paid'; ?></td>
                    <td><?php echo $order['payment_date'] ? $order['payment_date'] : 'N/A'; ?></td>
                    <td><?php echo $order['accessories'] ? $order['accessories'] : 'No Accessories'; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No orders found.</p>
        <?php endif; ?>

        <a href="MainPage.php">Back to Home</a>
    </section>

    <footer>
        <p>&copy; 2025 Admin Dashboard. All Rights Reserved.</p>
    </footer>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>