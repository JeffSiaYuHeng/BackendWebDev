<?php
include __DIR__ . "/../../../backend/db_connect.php";

// Fetch all orders, grouping accessories and payments, including delivery method
$sql = "SELECT o.id AS order_id,
               oi.product_id,
               pr.name AS product_name,  -- Use a different alias for the products table
               oi.quantity,
               oi.size,
               o.status,
               o.delivery_method,
               o.created_at,
               MAX(p.amount) AS payment_amount,
               MAX(p.status) AS payment_status,
               GROUP_CONCAT(DISTINCT a.name SEPARATOR ', ') AS accessories
        FROM orders o
        LEFT JOIN payments p ON o.id = p.order_id
        LEFT JOIN order_accessories oa ON o.id = oa.order_id
        LEFT JOIN accessories a ON oa.accessory_id = a.id
        LEFT JOIN order_items oi ON o.id = oi.order_id
        LEFT JOIN products pr ON oi.product_id = pr.id  -- Changed alias to 'pr' for the products table
        WHERE o.user_id = ?
        GROUP BY o.id, oi.id
        ORDER BY o.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders_result = $stmt->get_result();
?>
