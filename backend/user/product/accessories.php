<?php

include __DIR__ . "/../../../backend/db_connect.php";

// Retrieve bridal details from POST request
$product_name = $_POST['product_name'] ?? 'Unknown Bridal Gown';
$product_type = $_POST['product_type'] ?? 'Unknown Type';
$product_price = $_POST['product_price'] ?? '0.00';
$size = $_POST['size'] ?? 'Not Selected';
$color = $_POST['color'] ?? 'Default Color';
$fabric = $_POST['fabric'] ?? 'Default Fabric';

// Fabric mapping
$fabric_options = ["fabric1" => "Lace", "fabric2" => "Satin", "fabric3" => "Tulle"];
$fabric_display = $fabric_options[$fabric] ?? $fabric;

// Convert product price to float
$product_price = (float) str_replace(',', '', $product_price);



// Initialize the accessories array
$accessories = [];

// Query to retrieve accessories from the database
$sql = "SELECT * FROM accessories";
$result = $conn->query($sql);

// Check if there are results and store them in an array
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $accessories[] = $row;
    }
} else {
    echo "No accessories found.";
}

// Close the database connection
$conn->close();

// Convert the accessories array to JSON for use in JavaScript
$accessories_json = json_encode($accessories);
?>