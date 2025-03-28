<?php
session_start();
// If user is NOT logged in, show an alert and redirect to login page
if (!isset($_SESSION["user_id"])) {
    echo "<script>
        alert('Your session has expired or you are not logged in. Please log in again.');
        window.location.href = 'LoginPage.php';
    </script>";
    exit();
}




include "../../backend/user/product/profile.php"; // Include database connection
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="/BackendWebDev/userstyle/transitions.css">
    <link rel="stylesheet" href="/userstyle/transitions.css">
    <link rel="stylesheet" href="/BackendWebDev/userstyle/profile.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="/BackendWebDev/userscript/transition.js"></script>
    <script src="/BackendWebDev/userscript/profile.js"></script>
</head>

<body>
    <header>
        <h1>Eternal Elegant Bridal</h1>
        <div class="dropdown">
            <button class="dropbtn">
                <span>Me <i class="fa fa-angle-down" aria-hidden="true"></i></span>
            </button>
            <div class="dropdown-content">
                <p>Hello <?php echo htmlspecialchars($first_name); ?>!</p>
                <div class="line"></div>
                <a href="#">Profile</a>
                <a href="/BackendWebDev/backend/user/authenticate/logout.php">Logout</a>
            </div>
        </div>
    </header>
    <nav>
        <a class="blink" href="#">Home</a> |
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
            </div>

            <div id="security" class="section" style="display: none;">
                <h2>Security</h2>
                <p>Change your password and manage security settings.</p>
                <p><strong>Password:</strong> ******** <a href="../authenticate/ResetpasswordPage.php
" class="reset-password-btn">Change</a></p>
                </p>
            </div>

            <div id="orders" class="section" style="display: none;">
                <h2>Orders</h2>
                <p>View your past orders and track current ones.</p>
            </div>

            <div id="settings" class="section" style="display: none;">
                <h2>Settings</h2>
                <p>Customize your profile settings and preferences.</p>
            </div>
        </div>
    </div>
</body>

</html>