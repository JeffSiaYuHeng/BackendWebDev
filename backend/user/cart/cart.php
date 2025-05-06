<?php
include __DIR__ . "/../../../backend/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    die("User not logged in.");
}

$user_id = $_SESSION['user_id'];

// Step 1: Get user's cart
$sql = "SELECT * FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();
$cart = $cart_result->fetch_assoc();
$stmt->close();

if (!$cart) {
    $cart_items = [];
    $cart_accessories = [];
    return;
}

$cart_id = $cart['id'];

// Step 2: Get cart items with product name, type, and custom config if any
$sql = "
    SELECT 
        ci.*, 
        p.name AS product_name, 
        p.type AS product_type,
        cdc.color, cdc.design, cdc.length, cdc.sleeve
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.id
    LEFT JOIN custom_dress_configurations cdc ON ci.custom_config_id = cdc.id
    WHERE ci.cart_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$items_result = $stmt->get_result();
$cart_items = $items_result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Step 3: Get accessories linked to cart items
$cart_accessories = [];
$sql = "
    SELECT ca.cart_item_id, a.name AS accessory_name, a.price AS accessory_price
    FROM cart_accessories ca
    JOIN accessories a ON ca.accessory_id = a.id
    WHERE ca.cart_id = ?
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$accessories_result = $stmt->get_result();
$stmt->close();

while ($row = $accessories_result->fetch_assoc()) {
    $cart_accessories[$row['cart_item_id']][] = $row;
}
?>
