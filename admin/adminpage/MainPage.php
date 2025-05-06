<?php
session_start();
include __DIR__ . "../../../backend/db_connect.php";

// Check if the user is logged in and has an admin role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: /BackendWebDev/userpage/authenticate/LoginPage.php");
    exit();
}

$first_name = $_SESSION["first_name"];
$last_name = $_SESSION["last_name"];
$user_name = $_SESSION["user_name"];

// Fetch total users
$userQuery = "SELECT COUNT(*) AS total_users FROM users";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);
$totalUsers = $userData['total_users'];

// Fetch total orders
$orderQuery = "SELECT COUNT(*) AS total_orders FROM orders";
$orderResult = mysqli_query($conn, $orderQuery);
$orderData = mysqli_fetch_assoc($orderResult);
$totalOrders = $orderData['total_orders'];

// Fetch total revenue
$revenueQuery = "SELECT SUM(amount) AS total_revenue FROM payments WHERE status = 'paid'";
$revenueResult = mysqli_query($conn, $revenueQuery);
$revenueData = mysqli_fetch_assoc($revenueResult);
$totalRevenue = $revenueData['total_revenue'] ?? 0;



// Fetch most popular product
// Fetch most popular product
$popularProductQuery = "
    SELECT p.name, COUNT(oi.product_id) AS order_count 
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    GROUP BY oi.product_id 
    ORDER BY order_count DESC 
    LIMIT 1";
    
$popularProductResult = mysqli_query($conn, $popularProductQuery);
$popularProductData = mysqli_fetch_assoc($popularProductResult);
$popularProduct = $popularProductData['name'] ?? 'N/A';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../adminstyle/MainPage.css"> <!-- Ensure you have a CSS file for styling -->
</head>
<body>
    <header>
        <div class="logo">
            <h1>Admin Dashboard</h1>
        </div>
        <nav>
            <ul>
                <li><a href="/BackendWebDev/admin/adminpage/MainPage.php" class="active">Home</a></li>
                <li><a href="manageUsers.php">Manage Users</a></li>
                <li><a href="manageDelivery.php" >Manage Delivery</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="payments.php">Payments</a></li>
                <li><a href="analytics.php">Analytics</a></li>
                <li><a href="../../backend/admin/authenticate/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section class="welcome-section">
        <h2>Welcome, <?php echo htmlspecialchars($user_name); ?>!</h2>
        <p>You're logged in as an Admin.</p>
    </section>

    <section class="stats">
        <div class="card">
            <h4>Total Users</h4>
            <p><?php echo $totalUsers; ?></p>
        </div>
        <div class="card">
            <h4>Total Orders</h4>
            <p><?php echo $totalOrders; ?></p>
        </div>
        <div class="card">
            <h4>Total Revenue</h4>
            <p>$<?php echo number_format($totalRevenue, 2); ?></p>
        </div>
        <div class="card">
            <h4>Most Popular Product</h4>
            <p><?php echo htmlspecialchars($popularProduct); ?></p>
        </div>
    </section>

    <footer>
        <p>&copy; 2025 Admin Dashboard. All Rights Reserved.</p>
    </footer>
</body>
</html>