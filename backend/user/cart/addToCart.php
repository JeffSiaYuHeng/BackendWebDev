<?php
session_start();
include __DIR__ . "/../../../backend/db_connect.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];
$product_name = $_POST['product_name'] ?? '';
$product_type = $_POST['product_type'] ?? '';
$size = $_POST['size'] ?? '';
$color = $_POST['color'] ?? '';
$fabric = $_POST['fabric'] ?? '';
$total_price = (float) $_POST['product_price'] ?? 0.00;
$accessories = json_decode($_POST['accessories'], true) ?? [];

// Fetch product ID from database
$product_query = "SELECT id FROM products WHERE name = ? AND type = ? LIMIT 1";
$stmt = $conn->prepare($product_query);
$stmt->bind_param("ss", $product_name, $product_type);
$stmt->execute();
$product_result = $stmt->get_result();
$product_id = ($product_result->num_rows > 0) ? $product_result->fetch_assoc()['id'] : null;
$stmt->close();

if (!$product_id) {
    die("Product not found.");
}

// Check if user has an active cart
$cart_query = "SELECT id FROM cart WHERE user_id = ? LIMIT 1";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();

if ($cart_result->num_rows > 0) {
    $cart_id = $cart_result->fetch_assoc()['id'];
} else {
    // Create a new cart if not exists
    $cart_insert = "INSERT INTO cart (user_id, total_price) VALUES (?, 0.00)";
    $stmt = $conn->prepare($cart_insert);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_id = $stmt->insert_id;
    $stmt->close();
}

// Insert the main product into cart_items
$item_insert = "INSERT INTO cart_items (cart_id, product_id, size, color, fabric, price) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($item_insert);
$stmt->bind_param("iisssd", $cart_id, $product_id, $size, $color, $fabric, $total_price);
$stmt->execute();
$cart_item_id = $stmt->insert_id;
$stmt->close();

// Insert selected accessories into cart_accessories
if (!empty($accessories)) {
    foreach ($accessories as $accessory_name) {
        $accessory_query = "SELECT id FROM accessories WHERE name = ? LIMIT 1";
        $stmt = $conn->prepare($accessory_query);
        $stmt->bind_param("s", $accessory_name);
        $stmt->execute();
        $accessory_result = $stmt->get_result();
        if ($accessory_result->num_rows > 0) {
            $accessory_id = $accessory_result->fetch_assoc()['id'];
            $stmt->close();

            $accessory_insert = "INSERT INTO cart_accessories (cart_id, cart_item_id, accessory_id) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($accessory_insert);
            $stmt->bind_param("iii", $cart_id, $cart_item_id, $accessory_id);
            $stmt->execute();
            $stmt->close();
        }
    }
}

// Update the cart total price
$update_cart_query = "UPDATE cart SET total_price = (SELECT SUM(price) FROM cart_items WHERE cart_id = ?) WHERE id = ?";
$stmt = $conn->prepare($update_cart_query);
$stmt->bind_param("ii", $cart_id, $cart_id);
$stmt->execute();
$stmt->close();

$conn->close();

// Redirect to cart page
header("Location: /BackendWebDev/userpage/cart/CartPage.php");
exit();