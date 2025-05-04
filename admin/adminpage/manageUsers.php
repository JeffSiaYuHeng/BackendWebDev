<?php
session_start();
include __DIR__ . "../../../backend/db_connect.php";

if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: /BackendWebDev/userpage/authenticate/LoginPage.php");
    exit();
}

$userQuery = "SELECT id, username, first_name, last_name, email, phone_number, address, created_at, role FROM users";
$userResult = mysqli_query($conn, $userQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="stylesheet" href="../adminstyle/manageUsers.css">
</head>

<body>

    <header>
        <div class="logo">
            <h1>Admin Dashboard</h1>
        </div>
        <nav>
            <ul>
                <li><a href="/BackendWebDev/admin/adminpage/MainPage.php">Home</a></li>
                <li><a href="manageUsers.php" class="active">Manage Users</a></li>
                <li><a href="orders.php">Orders</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="payments.php">Payments</a></li>
                <li><a href="analytics.php">Analytics</a></li>
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
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Created At</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($user = mysqli_fetch_assoc($userResult)) : ?>
                <tr>
                    <td><?= htmlspecialchars($user['username']) ?></td>
                    <td><?= htmlspecialchars($user['first_name']) ?></td>
                    <td><?= htmlspecialchars($user['last_name']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= htmlspecialchars($user['phone_number']) ?></td>
                    <td><?= htmlspecialchars($user['address']) ?></td>
                    <td><?= htmlspecialchars($user['created_at']) ?></td>
                    <td><?= htmlspecialchars($user['role']) ?></td>
                    <td>
                        <a href="editUser.php?id=<?= $user['id'] ?>" class="btn edit-btn">Edit</a>
                        <a href="deleteUser.php?id=<?= $user['id'] ?>" class="btn delete-btn"
                            onclick="return confirm('Are you sure to delete this user?');">Delete</a>
                    </td>

                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>

    <footer>
        <p>&copy; 2025 Admin Dashboard. All Rights Reserved.</p>
    </footer>

</body>

</html>