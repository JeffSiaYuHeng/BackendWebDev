<?php
session_start();
include "../../backend/db_connect.php"; // Database connection

// Check if the user is logged in and has an admin role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: /BackendWebDev/userpage/authenticate/LoginPage.php");
    exit();
}

// Fetch all products from the database
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Products</title>
    <link rel="stylesheet" href="../adminstyle/products.css"> 
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
                <li><a href="orders.php">Orders</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="accessories.php" class="active">Accessories</a></li>
                <li><a href="payments.php">Payments</a></li>
                <li><a href="analytics.php">Analytics</a></li>
                <li><a href="settings.php">Settings</a></li>
                <li><a href="../../backend/admin/authenticate/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Product Management Section -->
    <section class="product-management">
        <h2>All Products</h2>

        <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Price (RM)</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($product = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>#<?php echo $product['id']; ?></td>
                    <td>
                        <?php if ($product['image']): ?>
                            <img src="<?php echo $product['image']; ?>" alt="Product Image" class="product-img">
                        <?php else: ?>
                            <span>No Image</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['type'] ?: 'N/A'); ?></td>
                    <td><?php echo number_format($product['price'], 2); ?></td>
                    <td><?php echo htmlspecialchars($product['description'] ?: 'No description'); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No products found.</p>
        <?php endif; ?>

        <a href="MainPage.php">Back to Home</a>
    </section>

    <footer>
        <p>&copy; 2025 Admin Dashboard. All Rights Reserved.</p>
    </footer>

</body>
</html>

<?php
mysqli_close($conn);
?>
