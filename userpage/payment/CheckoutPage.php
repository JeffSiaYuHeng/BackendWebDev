<?php
session_start();
include "../../backend/db_connect.php";

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$total_amount = 0;

// Step 1: Get cart ID
$sql = "SELECT id FROM cart WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($cart_id);
$stmt->fetch();
$stmt->close();

if (!$cart_id) {
    echo "<p>Error: Cart not found!</p>";
    exit();
}

// Step 2: Get cart items with custom_config_id if any
$sql = "
    SELECT ci.id AS cart_item_id, ci.product_id, ci.size, ci.quantity, ci.price, ci.custom_config_id, 
           p.name AS product_name 
    FROM cart_items ci
    JOIN products p ON ci.product_id = p.id
    WHERE ci.cart_id = ?
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$result = $stmt->get_result();
$cart_items = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

if (empty($cart_items)) {
    echo "<p>Your cart is empty. <a href='../product/MainPage.php'>Go back to shopping</a></p>";
    exit();
}

// Step 3: Calculate total amount
foreach ($cart_items as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

// Step 4: Create order
$sql = "INSERT INTO orders (user_id, total_price, status) VALUES (?, ?, 'Pending')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("id", $user_id, $total_amount);
$stmt->execute();
$order_id = $stmt->insert_id;
$stmt->close();

// Step 5: Move cart items to order items (including custom_config_id)
foreach ($cart_items as $item) {
    $sql = "
        INSERT INTO order_items (order_id, product_id, quantity, size, price, custom_config_id) 
        VALUES (?, ?, ?, ?, ?, ?)
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "iiisdi", 
        $order_id, 
        $item['product_id'], 
        $item['quantity'], 
        $item['size'], 
        $item['price'], 
        $item['custom_config_id']
    );
    $stmt->execute();
    $order_item_id = $stmt->insert_id;
    $stmt->close();

    // Step 6: Move accessories related to this cart item
    $sql = "
        INSERT INTO order_accessories (order_id, order_item_id, accessory_id)
        SELECT ?, ?, ca.accessory_id
        FROM cart_accessories ca
        WHERE ca.cart_item_id = ?
    ";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $order_id, $order_item_id, $item['cart_item_id']);
    $stmt->execute();
    $stmt->close();
}

// Step 7: Clear cart items and accessories
$sql = "DELETE FROM cart_items WHERE cart_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$stmt->close();

$sql = "DELETE FROM cart_accessories WHERE cart_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $cart_id);
$stmt->execute();
$stmt->close();

// Step 8: Redirect to confirmation
header("Location: /BackendWebDev/userpage/payment/OrderConfirmationPage.php?order_id=" . $order_id);
exit();
?>
