<?php
session_start();
include "../../backend/db_connect.php"; // Database connection



// Fetch all accessories from the database
$sql = "SELECT * FROM accessories ORDER BY id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View Accessories</title>
    <link rel="stylesheet" href="../adminstyle/accessories.css"> 
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
                <li><a href="../../backend/admin/authenticate/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Accessories Management Section -->
    <section class="accessories-management">
        <h2>All Accessories</h2>

        <?php if ($result->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price (RM)</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($accessory = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td>#<?php echo $accessory['id']; ?></td>
                    <td>
                        <?php if ($accessory['image']): ?>
                            <img src="<?php echo $accessory['image']; ?>" alt="Accessory Image" class="accessory-img">
                        <?php else: ?>
                            <span>No Image</span>
                        <?php endif; ?>
                    </td>
                    <td><?php echo htmlspecialchars($accessory['name']); ?></td>
                    <td><?php echo htmlspecialchars($accessory['category'] ?: 'N/A'); ?></td>
                    <td><?php echo number_format($accessory['price'], 2); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <p>No accessories found.</p>
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
