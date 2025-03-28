<?php
include __DIR__ . "/../../../backend/db_connect.php";
$user_id = $_SESSION['user_id'];

// Retrieve the user's cart
$sql = "SELECT * FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$cart_result = $stmt->get_result();
$cart = $cart_result->fetch_assoc();
$stmt->close();

if (!$cart) {
    echo "<h2>Your cart is empty.</h2>";
    exit();
}

$cart_id = $cart['id'];
// Retrieve cart items
$sql = "SELECT ci.*, p.name AS product_name 
        FROM cart_items ci
        INNER JOIN products p ON ci.product_id = p.id
        WHERE ci.cart_id = ?";

if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $cart_id);
    $stmt->execute();
    $items_result = $stmt->get_result();
    
    $cart_items = $items_result->fetch_all(MYSQLI_ASSOC);

    $stmt->close();
} else {
    $cart_items = [];
}

// Retrieve accessories for each cart item
$cart_accessories = [];
$sql = "SELECT ca.cart_item_id, a.name AS accessory_name, a.price AS accessory_price
        FROM cart_accessories ca
        JOIN accessories a ON ca.accessory_id = a.id
        WHERE ca.cart_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$accessories_result = $stmt->get_result();
$stmt->close();

while ($row = $accessories_result->fetch_assoc()) {
    $cart_accessories[$row['cart_item_id']][] = $row;
}

$conn->close();
?>