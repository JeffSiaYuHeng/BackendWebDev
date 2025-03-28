<?php
include __DIR__ . "/../../../backend/db_connect.php";

session_start();

// If user is NOT logged in, show an alert and redirect to login page
if (!isset($_SESSION["user_id"])) {
    echo "<script>
        alert('Your session has expired or you are not logged in. Please log in again.');
        window.location.href = '../../../BackendWebDev/login.php';
    </script>";
    exit();
}

// Ensure first_name is set; fallback to "Guest"
$first_name = $_SESSION["first_name"] ?? "Guest";

// Get total products count
$sql = "SELECT COUNT(*) AS total FROM products";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$item = $row["total"];

function fetchProducts($conn) {
    // Fetch products sorted by price (high to low)
    $sql_products = "SELECT id, name, price, image FROM products ORDER BY price DESC";
    $result_products = $conn->query($sql_products);

    if ($result_products->num_rows > 0) {
        while ($product = $result_products->fetch_assoc()) {
            echo '<div class="product-card">
                    <a href="/BackendWebDev/userpage/product/ProductDetailPage.php?id=' . urlencode($product["id"]) . '">
                        <img src="' . htmlspecialchars($product["image"]) . '" alt="' . htmlspecialchars($product["name"]) . '">
                        <div class="product-content">
                            <p class="product-name">' . htmlspecialchars($product["name"]) . '</p>
                            <p class="product-price">RM ' . number_format($product["price"], 2) . '</p>
                        </div>
                    </a>
                </div>';
        }
    } else {
        echo "<p>No products found.</p>";
    }
}

?>