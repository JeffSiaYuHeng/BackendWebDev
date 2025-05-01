<?php
include __DIR__ . "../../../backend/db_connect.php";

// Fetch payment method distribution
$paymentMethodQuery = "SELECT payment_method, COUNT(*) as count FROM payments GROUP BY payment_method";
$paymentMethodResult = $conn->query($paymentMethodQuery);
$methodLabels = $methodCounts = [];
while ($row = $paymentMethodResult->fetch_assoc()) {
    $methodLabels[] = $row['payment_method'];
    $methodCounts[] = $row['count'];
}

// Fetch payment status distribution
$paymentStatusQuery = "SELECT status, COUNT(*) as count FROM payments GROUP BY status";
$paymentStatusResult = $conn->query($paymentStatusQuery);
$statusLabels = $statusCounts = [];
while ($row = $paymentStatusResult->fetch_assoc()) {
    $statusLabels[] = $row['status'];
    $statusCounts[] = $row['count'];
}

// Top 5 most searched products
$searchQuery = "SELECT p.name, a.search_count FROM analytics a JOIN products p ON a.product_id = p.id ORDER BY a.search_count DESC LIMIT 5";
$searchResult = $conn->query($searchQuery);
$searchLabels = $searchCounts = [];
while ($row = $searchResult->fetch_assoc()) {
    $searchLabels[] = $row['name'];
    $searchCounts[] = $row['search_count'];
}

// Top 5 most visited products
$visitQuery = "SELECT p.name, a.visit_count FROM analytics a JOIN products p ON a.product_id = p.id ORDER BY a.visit_count DESC LIMIT 5";
$visitResult = $conn->query($visitQuery);
$visitLabels = $visitCounts = [];
while ($row = $visitResult->fetch_assoc()) {
    $visitLabels[] = $row['name'];
    $visitCounts[] = $row['visit_count'];
}

// Top 5 most ordered products
$orderQuery = "SELECT p.name, a.order_count FROM analytics a JOIN products p ON a.product_id = p.id ORDER BY a.order_count DESC LIMIT 5";
$orderResult = $conn->query($orderQuery);
$orderLabels = $orderCounts = [];
while ($row = $orderResult->fetch_assoc()) {
    $orderLabels[] = $row['name'];
    $orderCounts[] = $row['order_count'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics - Admin</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="../adminstyle/analytics.css">
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
                <li><a href="payments.php">Payments</a></li>
                <li><a class="active" href="analytics.php">Analytics</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="../../backend/admin/authenticate/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <h2>Payment & Product Analytics</h2>

        <div class="chart-container">
            <h3>Payment Method Distribution</h3>
            <canvas id="methodChart"></canvas>

            <h3>Payment Status Distribution</h3>
            <canvas id="statusChart"></canvas>

            <h3>Top 5 Most Searched Products</h3>
            <canvas id="searchChart"></canvas>

            <h3>Top 5 Most Visited Products</h3>
            <canvas id="visitChart"></canvas>

            <h3>Top 5 Most Ordered Products</h3>
            <canvas id="orderChart"></canvas>
        </div>
    </main>

    <script>
    const methodCtx = document.getElementById('methodChart');
    new Chart(methodCtx, {
        type: 'pie',
        data: {
            labels: <?= json_encode($methodLabels) ?>,
            datasets: [{
                label: 'Payment Methods',
                data: <?= json_encode($methodCounts) ?>,
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6c757d']
            }]
        }
    });

    const statusCtx = document.getElementById('statusChart');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($statusLabels) ?>,
            datasets: [{
                label: 'Payment Status',
                data: <?= json_encode($statusCounts) ?>,
                backgroundColor: ['#17a2b8', '#28a745', '#dc3545', '#ffc107']
            }]
        }
    });

    const searchCtx = document.getElementById('searchChart');
    new Chart(searchCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($searchLabels) ?>,
            datasets: [{
                label: 'Search Count',
                data: <?= json_encode($searchCounts) ?>,
                backgroundColor: '#007bff'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const visitCtx = document.getElementById('visitChart');
    new Chart(visitCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($visitLabels) ?>,
            datasets: [{
                label: 'Visit Count',
                data: <?= json_encode($visitCounts) ?>,
                backgroundColor: '#28a745'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    const orderCtx = document.getElementById('orderChart');
    new Chart(orderCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($orderLabels) ?>,
            datasets: [{
                label: 'Order Count',
                data: <?= json_encode($orderCounts) ?>,
                backgroundColor: '#dc3545'
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>

    <footer>
        <p>&copy; 2025 Admin Dashboard. All Rights Reserved.</p>
    </footer>
</body>

</html>

<?php
$conn->close();
?>