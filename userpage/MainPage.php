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

// Ensure first_name is set; fallback to "Guest"
$first_name = $_SESSION["first_name"] ?? "Guest";

include "../backend/db_connect.php"; // Include database connection


// Fetch all products
$sql = "SELECT id, name, price, image FROM products LIMIT 3";
$result = $conn->query($sql);



?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/BackendWebDev/userstyle/transitions.css">
    <link rel="stylesheet" href="/userstyle/transitions.css">
    <link rel="stylesheet" href="/BackendWebDev/userstyle/main.css">
    <link rel="stylesheet" href="/userstyle/main.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>main</title>
    <script src="/BackendWebDev/userscript/transition.js"></script>

    <script src="/userscript/slider.js"></script>
    <script src="/BackendWebDev/userscript/slider.js"></script>
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
                <a href="/BackendWebDev/backend/logout.php">Logout</a>
            </div>
        </div>
    </header>
    <nav>
        <a class="blink" href="#">Home</a> |
        <a class="blink" href="WeddingDressPage.php">Wedding Dress</a> |
        <a class="blink" href="">About</a> |
        <a class="blink" href="">Contact</a>
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
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '
                    <div class="product-card">
                        <a href="ProductDetailPage.php?id=' . $row['id'] . '">
                            <img src="' . htmlspecialchars($row['image']) . '"
                            alt="' . htmlspecialchars($row['name']) . '">
                        
                            <div class="overlay"></div>
                            <div class="product-content">
                                <h3>' . htmlspecialchars($row['name']) . '</h3>
                                <p>Starting from RM' . number_format($row['price'], 2) . '</p>
                            </div>
                        </a>
                    </div>';
                }
            } else {
                echo "<p>No products found.</p>";
            }
            
            $conn->close();
            ?>

        </div>
    </section>

    <a href="login.php">login test</a>
    <a href="ProductDetailPage.php">product page</a>
    <a href="/backend/logout.php">Logout</a>
</body>

</html>