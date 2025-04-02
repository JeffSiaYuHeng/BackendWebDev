<?php
include __DIR__ . "/../../../backend/db_connect.php";



// Ensure first_name is set; fallback to "Guest"
$first_name = $_SESSION["first_name"] ?? "Guest";

// Get total products count
$sql = "SELECT COUNT(*) AS total FROM products";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$item = $row["total"];
function fetchProducts($conn) {
    $sortQuery = "ORDER BY name ASC"; 

    if (isset($_GET['filter'])) {
        switch ($_GET['filter']) {
            case 'A_Z': $sortQuery = "ORDER BY name ASC"; break;
            case 'Z_A': $sortQuery = "ORDER BY name DESC"; break;
            case 'price_high_low': $sortQuery = "ORDER BY price DESC"; break;
            case 'price_low_high': $sortQuery = "ORDER BY price ASC"; break;
        }
    }

    $searchQuery = "";
    $params = [];

    if (!empty($_GET['searchQuery'])) {
        $searchQuery = "AND name LIKE ?";
        $params[] = "%" . $_GET['searchQuery'] . "%";
    }

    $sql_products = "SELECT id, name, price, image FROM products WHERE 1=1 $searchQuery $sortQuery";
    
    $stmt = $conn->prepare($sql_products);
    if (!empty($params)) {
        $stmt->bind_param("s", ...$params);
    }
    $stmt->execute();
    $result_products = $stmt->get_result();

    if ($result_products->num_rows > 0) {
        while ($product = $result_products->fetch_assoc()) {
            echo '<div class="product-card">
                    <a target="_blank" href="ProductDetailPage.php?id=' . urlencode($product["id"]) . '">
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