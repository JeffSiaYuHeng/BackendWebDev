<?php
include __DIR__ . "/../../../backend/db_connect.php";
// Fetch all orders, grouping accessories and payments, including delivery method
$sql = "SELECT o.id AS order_id, 
               o.total_price, 
               o.status, 
               o.delivery_method, -- Added delivery_method
               o.created_at, 
               MAX(p.amount) AS payment_amount, 
               MAX(p.status) AS payment_status, 
               MAX(p.created_at) AS payment_date,
               GROUP_CONCAT(DISTINCT a.name SEPARATOR ', ') AS accessories
        FROM orders o
        LEFT JOIN payments p ON o.id = p.order_id
        LEFT JOIN order_accessories oa ON o.id = oa.order_id
        LEFT JOIN accessories a ON oa.accessory_id = a.id
        WHERE o.user_id = ?
        GROUP BY o.id
        ORDER BY o.created_at DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders_result = $stmt->get_result();
?>