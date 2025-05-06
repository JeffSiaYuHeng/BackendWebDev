<?php
include __DIR__ . "../../../backend/db_connect.php";

// Handle delivery update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['order_id'], $_POST['status'], $_POST['delivery_method'])) {
    $order_id = $_POST['order_id'];
    $delivery_method = $_POST['delivery_method'];
    $status = $_POST['status'];

    $update_sql = "UPDATE orders SET delivery_method = ?, status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("ssi", $delivery_method, $status, $order_id);
    $update_stmt->execute();
    $update_stmt->close();

    // Redirect to prevent resubmission
    header("Location: manageDelivery.php" . (!empty($_GET['status']) ? "?status=" . urlencode($_GET['status']) : ""));
    exit;
}

// Fetch orders
$deliveryStatusFilter = $_GET['status'] ?? '';
$sql = "SELECT o.id AS order_id, 
               o.user_id, 
               o.total_price, 
               o.status, 
               o.delivery_method, 
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
        LEFT JOIN users u ON o.user_id = u.id";

if (!empty($deliveryStatusFilter)) {
    $sql .= " WHERE o.status = ?";
}

$sql .= " GROUP BY o.id ORDER BY o.created_at DESC";

$stmt = $conn->prepare($sql);
if (!empty($deliveryStatusFilter)) {
    $stmt->bind_param("s", $deliveryStatusFilter);
}
$stmt->execute();
$orders_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Deliveries</title>
    <link rel="stylesheet" href="../adminstyle/delivery.css">
</head>

<body>
    <header>
        <div class="logo">
            <h1>Admin Dashboard</h1>
        </div>
        <nav>
            <ul>
                <li><a href="/BackendWebDev/admin/adminpage/MainPage.php">Home</a></li>
                <li><a href="manageUsers.php">Manage Users</a></li>
                <li><a href="manageDelivery.php" class="active">Manage Delivery</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="accessories.php">Accessories</a></li>
                <li><a href="payments.php">Payments</a></li>
                <li><a href="analytics.php">Analytics</a></li>
                <li><a href="../../backend/admin/authenticate/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="order-management">
        <h2>Manage Delivery</h2>

        <form method="get" class="filter-form">
            <label for="status">Filter by Delivery Status:</label>
            <select name="status" id="status">
                <option value="">All</option>
                <option value="Pending" <?= $deliveryStatusFilter == "Pending" ? "selected" : "" ?>>Pending</option>
                <option value="Processing" <?= $deliveryStatusFilter == "Processing" ? "selected" : "" ?>>Processing
                </option>
                <option value="Delivered" <?= $deliveryStatusFilter == "Delivered" ? "selected" : "" ?>>Delivered
                </option>
                <option value="Cancelled" <?= $deliveryStatusFilter == "Cancelled" ? "selected" : "" ?>>Cancelled
                </option>
            </select>
            <button type="submit">Search</button>
        </form>

        <?php if ($orders_result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>Total (RM)</th>
                    <th>Delivery Status</th>
                    <th>Delivery Method</th>
                    <th>Order Date</th>
                    <th>Payment</th>
                    <th>Payment Status</th>
                    <th>Accessories</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($order = $orders_result->fetch_assoc()): ?>
                <tr>
                    <form method="post">
                        <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                        <td>#<?= $order['order_id'] ?></td>
                        <td><?= htmlspecialchars($order['first_name'] . " " . $order['last_name']) ?><br><?= htmlspecialchars($order['email']) ?>
                        </td>
                        <td><?= number_format($order['total_price'], 2) ?></td>

                        <td>
                            <select name="status" onchange="this.form.submit()">
                                <option value="Pending" <?= $order['status'] === 'Pending' ? 'selected' : '' ?>>Pending
                                </option>
                                <option value="Processing" <?= $order['status'] === 'Processing' ? 'selected' : '' ?>>
                                    Processing</option>
                                <option value="Delivered" <?= $order['status'] === 'Delivered' ? 'selected' : '' ?>>
                                    Delivered</option>
                                <option value="Cancelled" <?= $order['status'] === 'Cancelled' ? 'selected' : '' ?>>
                                    Cancelled</option>
                            </select>
                        </td>

                        <td>
                            <select name="delivery_method" onchange="this.form.submit()">
                                <option value="Delivery"
                                    <?= $order['delivery_method'] === 'Delivery' ? 'selected' : '' ?>>Delivery</option>
                                <option value="Collection"
                                    <?= $order['delivery_method'] === 'Collection' ? 'selected' : '' ?>>Collection
                                </option>
                            </select>
                        </td>

                        <td><?= $order['created_at'] ?></td>
                        <td><?= $order['payment_amount'] ? number_format($order['payment_amount'], 2) : 'N/A' ?></td>
                        <td><?= $order['payment_status'] ?? 'Not Paid' ?></td>
                        <td><?= $order['accessories'] ?? 'No Accessories' ?></td>
                    </form>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No orders available.</p>
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