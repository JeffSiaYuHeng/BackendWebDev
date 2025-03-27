<?php
session_start();
include "../backend/db_connect.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: LoginPage.php");
    exit();
}

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
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart | Eternal Elegant Bridal</title>
    <link rel="stylesheet" href="/BackendWebDev/userstyle/cart.css">
</head>

<body>
    <header>
        <h1>Your Shopping Cart</h1>
    </header>

    <section class="cart-items">
        <?php if (empty($cart_items)): ?>
        <h2>Your cart is empty.</h2>
        <?php else: ?>
        <?php foreach ($cart_items as $item): ?>
        <div class="cart-item">
            <h2><?= htmlspecialchars($item['product_name']) ?></h2>
            <p><strong>Size:</strong> <?= htmlspecialchars($item['size']) ?></p>
            <p><strong>Color:</strong> <?= htmlspecialchars($item['color']) ?></p>
            <p><strong>Fabric:</strong> <?= htmlspecialchars($item['fabric']) ?></p>
            <p><strong>Price:</strong> RM <?= number_format($item['price'], 2) ?></p>
            <p><strong>Quantity:</strong> <?= $item['quantity'] ?></p>
            <h3>Accessories:</h3>
            <ul>
                <?php if (isset($cart_accessories[$item['id']])): ?>
                <?php foreach ($cart_accessories[$item['id']] as $accessory): ?>
                <li><?= htmlspecialchars($accessory['accessory_name']) ?> - RM
                    <?= number_format($accessory['accessory_price'], 2) ?></li>
                <?php endforeach; ?>
                <?php else: ?>
                <li>No accessories added</li>
                <?php endif; ?>
            </ul>
            <form action="../backend/user/product/removeFromCart.php" method="POST">
                <input type="hidden" name="cart_item_id" value="<?= $item['id'] ?>">
                <button type="submit">Remove</button>
            </form>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <footer>
        <h2>Total Price: RM <?= number_format($cart['total_price'], 2) ?></h2>
        <button onclick="location.href='/BackendWebDev/userpage/CheckoutPage.php'">Proceed to Checkout</button>
        <button onclick="location.href='/BackendWebDev/userpage/MainPage.php'">Home</button>
    </footer>
</body>

</html>