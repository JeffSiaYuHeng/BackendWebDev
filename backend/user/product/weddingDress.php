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
    $types = "";

    if (!empty($_GET['searchQuery'])) {
        $search_term = trim($_GET['searchQuery']);
        $searchQuery = "AND name LIKE ?";
        $params[] = "%" . $search_term . "%";
        $types .= "s";

        // Get matching products
        $sql_search = "SELECT id FROM products WHERE name LIKE ?";
        $stmt_search = $conn->prepare($sql_search);
        $stmt_search->bind_param("s", $params[0]);
        $stmt_search->execute();
        $result_search = $stmt_search->get_result();

        while ($product = $result_search->fetch_assoc()) {
            $product_id = $product["id"];

            // Update search count in analytics table
            $update_sql = "INSERT INTO analytics (product_id, search_count) 
                           VALUES (?, 1) 
                           ON DUPLICATE KEY UPDATE search_count = search_count + 1";
            $stmt_update = $conn->prepare($update_sql);
            $stmt_update->bind_param("i", $product_id);
            $stmt_update->execute();
        }
    }

    $sql_products = "SELECT id, name, price, image, type FROM products WHERE 1=1 $searchQuery $sortQuery";

    $stmt = $conn->prepare($sql_products);
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result_products = $stmt->get_result();

    if ($result_products->num_rows > 0) {
        while ($product = $result_products->fetch_assoc()) {
            echo '<div class="product-card">
                    <a href="javascript:void(0);" onclick="trackVisit(' . $product["id"] . ', \'' . $product["type"] . '\')" target="_blank">

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