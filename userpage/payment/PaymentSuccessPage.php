<?php
session_start();

include "../../backend/user/payment/paymentSuccess.php"; // Include database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
</head>

<body>
    <h2>Payment Successful</h2>
    <p>Thank you, <strong><?php echo htmlspecialchars($first_name . " " . $last_name); ?></strong>!</p>
    <p>Your payment has been received.</p>
    <p><strong>Order ID:</strong> #<?php echo $order_id; ?></p>
    <p><strong>Amount Paid:</strong> RM <?php echo number_format($amount, 2); ?></p>
    <p><strong>Status:</strong> <?php echo $status; ?></p>
    <p><strong>Payment Date:</strong> <?php echo $created_at; ?></p>
    <p><strong>Delivery Method:</strong> <?php echo htmlspecialchars($delivery_method); ?></p>

    <a href="ViewOrderRecordPage.php">View Order Record</a>
</body>

</html>