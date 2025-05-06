<?php
session_start();


// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include "../../backend/user/payment/orderConfirm.php"

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link rel="stylesheet" href="/BackendWebDev/userstyle/orderConfirmation.css">
</head>

<body>
    <h2>Order Confirmation</h2>
    <p>Thank you for your purchase! Your order ID is: <strong>#<?php echo htmlspecialchars($order_id); ?></strong></p>
    <p>Total Amount: <strong>RM <?php echo number_format($total_price, 2); ?></strong></p>

    <form action="/BackendWebDev/backend/user/payment/paymentMethod.php" method="post">
        <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
        <input type="hidden" name="total_price" value="<?php echo htmlspecialchars($total_price); ?>">

        <label>Select Payment Method:</label><br>
        <input type="radio" name="payment_method" value="Credit Card" required> Credit Card <br>
        <input type="radio" name="payment_method" value="Online Banking" required> Online Banking <br>
        <input type="radio" name="payment_method" value="e-Wallet" required> e-Wallet <br><br>

        <label>Select Delivery Method:</label><br>
        <input type="radio" name="delivery_method" value="Delivery" required> Delivery <br>
        <input type="radio" name="delivery_method" value="Collection" required> Collection <br><br>

        <button type="submit">Proceed to Payment</button>
    </form>
</body>

</html>