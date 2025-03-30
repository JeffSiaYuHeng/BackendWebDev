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


//make into productPage.php
include "../../backend/user/cart/showCartNumber.php";
include "../../backend/user/product/weddingDress.php"; 


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Product Page</title>
    <link rel="stylesheet" href="/BackendWebDev/userstyle/weddingDress.css">
    <link rel="stylesheet" href="/BackendWebDev/userstyle/transition.css">
    <script src="/BackendWebDev/userscript/transition.js"></script>

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
                    <a href="../backend/user/authenticate/logout.php">Logout</a>
                </div>
            </div>
    </header>
    <nav>
        <a class="blink" href="MainPage.php">Home</a> |
        <a class="blink" href="#">Wedding Dress</a> |
        <a class="blink" href="">About</a> |
        <a class="blink" href="">Contact</a>
    </nav>
    <section>
        <div class="same-row">
            <div class="title">
                <h3>Dress</h3>
                <p><?php echo $item; ?> Items</p>
            </div>
            <div class="filter">
                <label for="filter">Filter by:</label>
                <select id="filter" name="filter">
                    <option value="price_high_low" selected>Price: High to Low</option>
                </select>
            </div>
        </div>
    </section>

    <section class="product">
        <div class="product-container">
            <?php fetchProducts($conn); ?>
        </div>
    </section>

</body>

</html>