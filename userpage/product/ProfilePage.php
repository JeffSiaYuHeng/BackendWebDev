<?php
session_start();
// If user is NOT logged in, show an alert and redirect to login page
if (!isset($_SESSION["user_id"])) {
    echo "<script>
        alert('Your session has expired or you are not logged in. Please log in again.');
        window.location.href = '../authenticate/LoginPage.php';
    </script>";
    exit();
}

if (isset($_GET["update"]) && $_GET["update"] === "success") {
    echo "<script>alert('Address updated successfully!');</script>";
}




include "../../backend/user/cart/showCartNumber.php"; // Include database connection
include "../../backend/user/payment/viewOrderRecord.php";
include "../../backend/user/product/profile.php"; // Include database connection
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="/BackendWebDev/userstyle/transition.css">
    <link rel="stylesheet" href="/BackendWebDev/userstyle/profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="/BackendWebDev/userscript/transition.js"></script>
    <script src="/BackendWebDev/userscript/profile.js"></script>

</head>

<body>
    <header>
        <h1>Eternal Elegant Bridal</h1>
        <!-- Right container for Cart & Dropdown -->
        <div class="right-section">
            <button class="cart-btn" id="open-btn" onclick="window.location.href='../cart/CartPage.php'">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <?php if ($cart_count > 0): ?>
                <span class="icon-button__badge"><?= $cart_count ?></span>
                <?php endif; ?>
            </button>
            <div class="dropdown">
                <button class="dropbtn" id="account-btn">
                    <span>Me <i class="fa fa-angle-down" aria-hidden="true"></i></span>
                </button>
                <div class="dropdown-content">
                    <p>Hello <?php echo htmlspecialchars($first_name); ?>!</p>
                    <div class="line"></div>
                    <a href="ProfilePage.php">Profile</a>
                    <a href="../../backend/user/authenticate/logout.php">Logout</a>
                </div>
            </div>
    </header>
    <nav>
        <a class="blink" href="MainPage.php">Home</a> |
        <a class="blink" href="WeddingDressPage.php">Wedding Dress</a> |
        <a class="blink" href="">About</a> |
        <a class="blink" href="">Contact</a>
    </nav>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <h2>My Account</h2>
            <ul>
                <li class="active" onclick="showSection('personal')">Personal Details</li>
                <li onclick="showSection('security')">Security</li>
                <li onclick="showSection('orders')">Orders</li>
                <li onclick="showSection('settings')">Settings</li>
            </ul>
        </div>

        <!-- Content Area -->
        <div class="content">
            <div id="personal" class="section">
                <h2>Personal Details</h2>
                <p><strong>First Name:</strong> <?php echo htmlspecialchars($first_name); ?></p>
                <p><strong>Last Name:</strong> <?php echo htmlspecialchars($last_name); ?></p>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($email); ?></p>
                <p><strong>Phone:</strong> <?php echo htmlspecialchars($phone); ?></p>
                <!-- Address Section -->
                <p>
                    <strong>Address:</strong>
                    <span id="address-text"><?php echo htmlspecialchars($address); ?></span>
                    <button id="edit-address-btn" class="edit-btn" onclick="editAddress()">Change</button>
                </p>

                <!-- Address Edit Form (Hidden by Default) -->
                <form id="address-form" action="../../backend/user/product/update_address.php" method="POST"
                    style="display: none;">
                    <input type="text" id="new-address" name="new_address" class="address-input"
                        value="<?php echo htmlspecialchars($address); ?>" required>
                    <button type="submit" class="save-btn">Save</button>
                    <button type="button" id="cancel-btn" class="cancel-btn" onclick="cancelEdit()">Cancel</button>
                </form>

            </div>

            <div id="security" class="section" style="display: none;">
                <h2>Security</h2>
                <p>Change your password and manage security settings.</p>
                <p><strong>Password:</strong> ******** <a href="../authenticate/ResetpasswordPage.php
" class="reset-password-btn">Change</a></p>
                </p>
            </div>

            <div id="orders" class="section" style="display: none;">
                <h2>Your Order History</h2>

                <?php if ($orders_result->num_rows > 0): ?>
                <div class="table-container">
                    <table>
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
                            <td><?= isset($order['price']) ? number_format($order['price'], 2) : 'N/A'; ?></td>
                            </td>
                            <td><?= $order['accessories'] ? $order['accessories'] : 'No Accessories'; ?></td>
                            <td><?= $order['created_at']; ?></td>
                            <td><?= $order['payment_status'] ? $order['payment_status'] : 'Not Paid'; ?></td>
                            <td>
                                <?php if ($order['payment_status'] === 'Paid' && $order['status'] === 'Delivered'): ?>
                                <a class="review-btn"
                                    href="ReviewPage.php?order_id=<?= $order['order_id']; ?>&product_id=<?= $order['product_id']; ?>">
                                    Review
                                </a>

                                <?php elseif ($order['status'] === 'Pending'): ?>
                                Waiting to Delivered
                                <?php else: ?>
                                Waiting to done
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </table>

                </div>

                <?php else: ?>
                <p>No orders found.</p>
                <?php endif; ?>
            </div>

        </div>
    </div>
    <footer>
        <p>&copy; 2021 Eternal Elegant Bridal. All rights reserved.</p>
    </footer>


    <script src="/BackendWebDev/userscript/profile.js"></script>
</body>

</html>