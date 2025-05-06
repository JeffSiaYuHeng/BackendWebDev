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
$color = $_POST['color'] ?? null;
$design = $_POST['design'] ?? null;
$length = $_POST['length'] ?? null;
$sleeve = $_POST['sleeve'] ?? null;
$size = $_POST['size'] ?? '';
$total_price = isset($_POST['product_price']) ? (float) $_POST['product_price'] : 0.00;
$accessories = isset($_POST['accessories']) ? json_decode($_POST['accessories'], true) : [];

// Fetch product ID
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

// Check or create cart
$cart_query = "SELECT id FROM cart WHERE user_id = ? LIMIT 1";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();

if ($cart_result->num_rows > 0) {
    $cart_id = $cart_result->fetch_assoc()['id'];
} else {
    $cart_insert = "INSERT INTO cart (user_id, total_price) VALUES (?, 0.00)";
    $stmt = $conn->prepare($cart_insert);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $cart_id = $stmt->insert_id;
    $stmt->close();
}

// Optional: insert custom dress configuration
$custom_config_id = null;
if (strtolower($product_type) === 'custom') {
    $insert_config = "INSERT INTO custom_dress_configurations (color, design, length, sleeve) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insert_config);
    $stmt->bind_param("ssss", $color, $design, $length, $sleeve);
    $stmt->execute();
    $custom_config_id = $stmt->insert_id;
    $stmt->close();
}

// Insert cart item
$item_insert = "INSERT INTO cart_items (cart_id, product_id, size, price, custom_config_id) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($item_insert);
$stmt->bind_param("iisdi", $cart_id, $product_id, $size, $total_price, $custom_config_id);
$stmt->execute();
$cart_item_id = $stmt->insert_id;
$stmt->close();

// Insert accessories
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

// Update total price
$update_cart = "UPDATE cart SET total_price = (SELECT SUM(price) FROM cart_items WHERE cart_id = ?) WHERE id = ?";
$stmt = $conn->prepare($update_cart);
$stmt->bind_param("ii", $cart_id, $cart_id);
$stmt->execute();
$stmt->close();

$conn->close();

// Redirect
header("Location: /BackendWebDev/userpage/cart/CartPage.php");
exit();
