<?php
session_start();

// If user is already logged in, redirect to main
if (isset($_SESSION["user_id"])) {
    header("Location: page/main.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Start Button</title>
</head>

<body>
    <header>
        <h1>Eternal Elegant Bridal</h1>
    </header>
    <section class="banner">
        <div class="slider">
            <div class="slides">
                <img src="/image/banner/banner1_s.png" alt="Banner 1">
                <img src="/image/banner/banner2_s.png" alt="Banner 2">
                <img src="/image/banner/banner3_s.png" alt="Banner 3">
            </div>
            <button>Get Started</button>
        </div>
    </section>
    <a href="page/login.php">Login</a>
    <a href="page/register.php">Register</a>
</body>

</html>