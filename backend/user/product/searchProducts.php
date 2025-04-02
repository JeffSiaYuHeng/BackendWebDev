<?php
include __DIR__ . "/../../../backend/db_connect.php";

// Default sorting order
$sortQuery = "ORDER BY name ASC";

if (isset($_GET['filter'])) {
    switch ($_GET['filter']) {
        case 'A_Z':
            $sortQuery = "ORDER BY name ASC";
            break;
        case 'Z_A':
            $sortQuery = "ORDER BY name DESC";
            break;
        case 'price_high_low':
            $sortQuery = "ORDER BY price DESC";
            break;
        case 'price_low_high':
            $sortQuery = "ORDER BY price ASC";
            break;
    }
}

// Handle search query
$searchQuery = "";
if (isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
    $search = $conn->real_escape_string($_GET['searchQuery']);
    $searchQuery = " AND name LIKE '%$search%'";
}

// Fetch products with sorting and search filter
$sql_products = "SELECT id, name, price, image FROM products WHERE 1=1 $searchQuery $sortQuery";
$result_products = $conn->query($sql_products);

if ($result_products->num_rows > 0) {
    while ($product = $result_products->fetch_assoc()) {
        echo '<div class="product-card">
                <a target="_blank" href="/BackendWebDev/userpage/product/ProductDetailPage.php?id=' . urlencode($product["id"]) . '">
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
?>