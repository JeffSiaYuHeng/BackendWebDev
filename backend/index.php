<?php
include "db_connect.php"; // Include database connection

function fetch3product($conn) {
    // Fetch 3 products from the database
    $sql = "SELECT id, name, price, image FROM products LIMIT 3";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '
            <div class="product-card">
                <a href="/BackendWebDev/userpage/LoginPage.php">
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

    // Close connection only if this is the last operation in the script
    // Remove this line if you're using the connection elsewhere later
    $conn->close();
}
?>