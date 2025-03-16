<?php

//make into productPage.php
include "../backend/productPage.php"; 


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Product Page</title>
    <link rel="stylesheet" href="/style/productPage.css">
    <link rel="stylesheet" href="/style/transition.css">
    <script src="/BackendWebDev/script/transition.js"></script>
    <script src="/script/transition.js"></script>
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
                <a href="/backend/logout.php">Logout</a>
            </div>
        </div>
    </header>
    <nav>
        <a class="blink" href="#">Home</a> |
        <a class="blink" href="">Wedding Dress</a> |
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