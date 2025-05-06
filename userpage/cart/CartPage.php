<?php
session_start();
include "../../backend/user/cart/cart.php";

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: LoginPage.php");
    exit();
}

$total_price = 0; // Initialize total price

// Calculate the total price for items in the cart
foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];

    // Add price for accessories if any
    if (isset($cart_accessories[$item['id']])) {
        foreach ($cart_accessories[$item['id']] as $accessory) {
            $total_price += $accessory['accessory_price'];
        }
    }
}
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
                    <p><strong>Price:</strong> RM <?= number_format($item['price'], 2) ?></p>
                    <p><strong>Quantity:</strong> <?= $item['quantity'] ?></p>
                    <h3>Accessories:</h3>
                    <ul>
                        <?php if (isset($cart_accessories[$item['id']])): ?>
                            <?php foreach ($cart_accessories[$item['id']] as $accessory): ?>
                                <li><?= htmlspecialchars($accessory['accessory_name']) ?> - RM <?= number_format($accessory['accessory_price'], 2) ?></li>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <li>No accessories added</li>
                        <?php endif; ?>
                    </ul>
                    <form action="../../backend/user/cart/removeFromCart.php" method="POST">
                        <input type="hidden" name="cart_item_id" value="<?= $item['id'] ?>">
                        <button type="submit">Remove</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

    <footer>
        <h2>Total Price: RM <?= number_format($total_price, 2) ?></h2>
        <form action="/BackendWebDev/userpage/payment/CheckoutPage.php" method="POST">
            <input type="hidden" name="total_price" value="<?= $total_price ?>">
            <button type="submit">Proceed to Checkout</button>
        </form>
        <button onclick="location.href='/BackendWebDev/userpage/product/MainPage.php'">Home</button>
    </footer>
</body>

</html>
