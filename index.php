<?php
session_start();

// If user is already logged in, redirect to main
if (isset($_SESSION["user_id"])) {
    header("Location: /BackendWebDev/userpage/product/MainPage.php");
    exit();
}

include "backend/index.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style/index.css">
    <script src="userscript/transition.js"></script>
    <link rel="stylesheet" href="userstyle/transition.css">
    <title>Welcome to Eternal Elegant Bridal</title>
</head>

<body>
    <header>
        <h1>Eternal Elegant Bridal</h1>
    </header>
    <section>
        <div class="slider">
            <div class="slides">
                <img src="/BackendWebDev/image/banner/banner1_s.png" alt="Banner 1">
                <img src="/BackendWebDev/image/banner/banner2_s.png" alt="Banner 2">
                <img src="/BackendWebDev/image/banner/banner3_s.png" alt="Banner 3">
            </div>
            <button onclick="window.location.href = 'userpage/authenticate/LoginPage.php';">Let's Start</button>
        </div>
    </section>
    <section class="product">
        <h2>Our Best Products</h2>
        <div class="product-container">
            <?php
            fetch3product($conn);
            ?>
        </div>
    </section>
    <footer>
        <p>&copy; 2021 Eternal Elegant Bridal. All rights reserved.</p>
    </footer>
</body>

</html>