<?php
session_start();
// If user is NOT logged in, show an alert and redirect to login page
if (!isset($_SESSION["user_id"])) {
    echo "<script>
        alert('Your session has expired or you are not logged in. Please log in again.');
        window.location.href = 'login.php';
    </script>";
    exit();
}

// Ensure first_name is set; fallback to "Guest"
$first_name = $_SESSION["first_name"] ?? "Guest";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BackendWebDev/style/transitions.css">
    <link rel="stylesheet" href="/style/transitions.css">
    <link rel="stylesheet" href="/BackendWebDev/style/dashboard.css">
    <link rel="stylesheet" href="/style/dashboard.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Dashboard</title>
    <script src="/BackendWebDev/script/transition.js"></script>
    <script src="/script/transition.js"></script>
    <script src="/script/slider.js"></script>
    <script src="/BackendWebDev/script/slider.js"></script>
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
        <a class="blink" href="">Home</a> |
        <a class="blink" href="">Wedding Dress</a> |
        <a class="blink" href="">About</a> |
        <a class="blink" href="">Contact</a>
    </nav>
    <div class="slider">
        <div class="slides">
            <img src="/image/banner1.webp" alt="Banner 1">
            <img src="/image/banner2.webp" alt="Banner 2">
            <img src="/image/banner3.webp" alt="Banner 3">
        </div>
    </div>

    <a href="login.php">login test</a>
    <a href="ProductDetailPage.php">product page</a>
    <a href="/backend/logout.php">Logout</a>
</body>

</html>