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
    <link rel="stylesheet" href="/BackendWebDev/userstyle/about.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>About Us</title>
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
        <a class="blink" href="#">About</a> |
        <a class="blink" href="ContactPage.php">Contact</a>
    </nav>

    <section class="about-us">
        <h2>About Us</h2>
        <div class="about-content">
            <p>
                <strong>Eternal Elegant Bridal</strong> was founded with a singular mission — to celebrate love with
                timeless elegance.
                We believe every bride deserves a gown that not only fits beautifully but also tells her unique story.
                Whether you dream of
                a classic silhouette or a modern design, we’re here to turn your vision into reality.
            </p>
            <p>
                Our curated collection features exquisitely crafted wedding dresses, bridal accessories, and
                personalized fittings
                that ensure each bride walks down the aisle with confidence and grace. At Eternal Elegant Bridal, we
                combine
                tradition with trend, offering pieces that are both stylish and meaningful.
            </p>
            <p>
                But we offer more than just gowns — we offer an experience. From your first fitting to your final walk
                down the aisle,
                our dedicated team is here to guide you with warmth, care, and attention to every detail.
            </p>
            <p class="quote">💍 <em>Elegance is eternal — and so is your story. Let us be part of it.</em></p>
        </div>
    </section>




    <footer>
        <p>&copy; 2021 Eternal Elegant Bridal. All rights reserved.</p>
    </footer>
</body>