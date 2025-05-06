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

// Ensure first_name is set; fallback to "Guest"
$first_name = $_SESSION["first_name"] ?? "Guest";

include "../../backend/user/cart/showCartNumber.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BackendWebDev/userstyle/transitions.css">
    <link rel="stylesheet" href="/BackendWebDev/userstyle/contact.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Contact Us</title>
    <script src="/BackendWebDev/userscript/transition.js"></script>
    <script src="/BackendWebDev/userscript/slider.js"></script>
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
        <a class="blink" href="AboutPage.php">About</a> |
        <a class="blink" href="#">Contact</a>
    </nav>

    <section class="contact-us">
        <h2>Contact Us</h2>
        <div class="contact-container">
            <div class="contact-info">
                <h3>Get in Touch</h3>
                <p><i class="fa fa-map-marker" aria-hidden="true"></i> 123 Bridal Avenue, Kuala Lumpur, Malaysia</p>
                <p><i class="fa fa-envelope" aria-hidden="true"></i> support@eternalelegant.com</p>
                <p><i class="fa fa-phone" aria-hidden="true"></i> +60 123 456 789</p>
                <p><i class="fa fa-clock-o" aria-hidden="true"></i> Mon - Sat: 10:00 AM – 6:00 PM</p>
            </div>
        </div>
    </section>





    <footer>
        <p>&copy; 2021 Eternal Elegant Bridal. All rights reserved.</p>
    </footer>
</body>