<?php
include __DIR__ . "../../../backend/db_connect.php";

$statusFilter = $_GET['status'] ?? '';
$sql = "SELECT p.*, u.first_name, u.last_name, o.id AS order_number
        FROM payments p
        LEFT JOIN users u ON p.user_id = u.id
        LEFT JOIN orders o ON p.order_id = o.id";

if ($statusFilter) {
    $sql .= " WHERE p.status = ?";
}
$sql .= " ORDER BY p.created_at DESC";

$stmt = $conn->prepare($sql);
if ($statusFilter) {
    $stmt->bind_param("s", $statusFilter);
}
$stmt->execute();
$payments_result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payments - Admin</title>
    <link rel="stylesheet" href="../adminstyle/payment.css">

</head>

<body>

    <header>
        <div class="logo">
            <h1>Admin Dashboard</h1>
        </div>
        <nav>
            <ul>
                <li><a href="MainPage.php">Home</a></li>
                <li><a href="manageUsers.php">Manage Users</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="accessories.php">Accessories</a></li>
                <li><a href="payments.php" class="active">Payments</a></li>
                <li><a href="analytics.php">Analytics</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="../../backend/admin/authenticate/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="user-management">
        <h2>All Payments</h2>

        <form class="filter-form" method="get">
            <label for="status">Filter by Status:</label>
            <select name="status" id="status">
                <option value="">All</option>
                <option value="Pending" <?= $statusFilter == "Pending" ? "selected" : "" ?>>Pending</option>
                <option value="Paid" <?= $statusFilter == "Paid" ? "selected" : "" ?>>Paid</option>
                <option value="Failed" <?= $statusFilter == "Failed" ? "selected" : "" ?>>Failed</option>
                <option value="Refunded" <?= $statusFilter == "Refunded" ? "selected" : "" ?>>Refunded</option>
            </select>
            <button type="submit">Search</button>
        </form>

        <?php if ($payments_result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>User</th>
                    <th>Order ID</th>
                    <th>Amount (RM)</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($payment = $payments_result->fetch_assoc()): ?>
                <tr>
                    <td>#<?= $payment['id'] ?></td>
                    <td><?= $payment['first_name'] . " " . $payment['last_name'] ?></td>
                    <td>#<?= $payment['order_number'] ?></td>
                    <td><?= number_format($payment['amount'], 2) ?></td>
                    <td><?= $payment['payment_method'] ?></td>
                    <td><?= $payment['status'] ?></td>
                    <td><?= $payment['created_at'] ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No payment records found.</p>
        <?php endif; ?>
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