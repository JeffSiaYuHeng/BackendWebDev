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

include "../../backend/user/product/main.php"; // Include database connection
include "../../backend/user/cart/showCartNumber.php"; // Include database connection



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BackendWebDev/userstyle/transition.css">
    <link rel="stylesheet" href="/BackendWebDev/userstyle/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Main Page</title>
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
        <a class="blink" href="#">Home</a> |
        <a class="blink" href="WeddingDressPage.php">Wedding Dress</a> |
        <a class="blink" href="AboutPage.php">About</a> |
        <a class="blink" href="ContactPage.php">Contact</a>
    </nav>
    <section class="banner">
        <div class="slider">
            <div class="slides">
                <img src="/BackendWebDev/image/banner/banner1_s.png" alt="Banner 1">

                <img src="/BackendWebDev/image/banner/banner2_s.png" alt="Banner 2">

                <img src="/BackendWebDev/image/banner/banner3_s.png" alt="Banner 3">
            </div>
            <button onclick="window.location.href='WeddingDressPage.php'">Start Customizing Your Gown</button>
        </div>
    </section>

    <section class="product">
        <h2>Our Products</h2>
        <div class="product-container">
            <?php
            fetch3product($conn);
            ?>

        </div>
    </section>

    <footer>
        <p>&copy; 2021 Eternal Elegant Bridal. All rights reserved.</p>
    </footer>



    <script>
    function trackVisit(productId) {
        // Open a new tab first
        let newTab = window.open("about:blank", "_blank");

        fetch('/BackendWebDev/backend/user/product/updateAnalytics.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    product_id: productId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the new tab's location
                    newTab.location.href = "ProductDetailPage.php?id=" + productId;
                } else {
                    alert("Failed to update analytics.");
                    newTab.close(); // Close the new tab if request fails
                }
            })
            .catch(error => {
                console.error('Error:', error);
                newTab.close(); // Close the new tab if there's an error
            });
    }
    </script>

</body>

</html>