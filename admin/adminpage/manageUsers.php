<?php
session_start();
include __DIR__ . "../../../backend/db_connect.php";

// Check if the user is logged in and has an admin role
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: /BackendWebDev/userpage/authenticate/LoginPage.php");
    exit();
}

// Fetch all users
$userQuery = "SELECT id, username, first_name, last_name, email, phone_number, address, created_at, role FROM users";
$userResult = mysqli_query($conn, $userQuery);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../adminstyle/manageUsers.css"> <!-- Ensure you have a CSS file for styling -->
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

    
    <section class="user-management">
        <h2>Manage Users</h2>
        <table>
            <thead>
                <tr>
                    <th>Username</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Created At</th>
                    <th>Role</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Check if there are users and display them
                if (mysqli_num_rows($userResult) > 0) {
                    while ($user = mysqli_fetch_assoc($userResult)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($user['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['first_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['last_name']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['email']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['phone_number']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['address']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['created_at']) . "</td>";
                        echo "<td>" . htmlspecialchars($user['role']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No users found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; 2025 Admin Dashboard. All Rights Reserved.</p>
    </footer>
</body>
</html>
