<?php
include __DIR__ . "/../../../backend/db_connect.php";

header("Content-Type: application/json");

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data["product_id"])) {
    echo json_encode(["success" => false, "error" => "Invalid request"]);
    exit();
}

$product_id = intval($data["product_id"]);

// Check if the product exists in analytics
$check_sql = "SELECT id FROM analytics WHERE product_id = ?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Product exists, update visit_count
    $update_sql = "UPDATE analytics SET visit_count = visit_count + 1 WHERE product_id = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
} else {
    // Product does not exist, insert a new row
    $insert_sql = "INSERT INTO analytics (product_id, visit_count) VALUES (?, 1)";
    $stmt = $conn->prepare($insert_sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
}

echo json_encode(["success" => true]);
?>