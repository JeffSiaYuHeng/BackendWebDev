<?php
session_start();
include __DIR__ . "/../../../backend/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to leave a review.');window.history.back();</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = $_POST['order_id'];
$rating = $_POST['rating'];
$review_text = $_POST['review_text'];
$created_at = date("Y-m-d H:i:s");

// Find the product ID related to this order (assuming one product per order for now)
$query = "SELECT product_id FROM orders WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$stmt->bind_result($product_id);
$stmt->fetch();
$stmt->close();

if ($product_id) {
    $insert = "INSERT INTO review (user_id, product_id, rating, review_text, created_at)
               VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($insert);
    $stmt->bind_param("iiiss", $user_id, $product_id, $rating, $review_text, $created_at);
    if ($stmt->execute()) {
        echo "<script>alert('Review submitted successfully!'); window.location.href='../../frontend/user/ProfilePage.php';</script>";
    } else {
        echo "<script>alert('Failed to submit review.'); window.history.back();</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('Product not found for this order.'); window.history.back();</script>";
}
$conn->close();
?>