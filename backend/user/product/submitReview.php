<?php
session_start();
include __DIR__ . "/../../../backend/db_connect.php";

if (!isset($_SESSION['user_id'])) {
    echo "<script>alert('You must be logged in to leave a review.');window.history.back();</script>";
    exit();
}

$user_id = $_SESSION['user_id'];
$order_id = $_POST['order_id'];
$product_id = $_POST['product_id'];
$rating = $_POST['rating'];
$review_text = $_POST['review_text'];
$created_at = date("Y-m-d H:i:s");

// Optional: Validate required inputs
if (!$product_id || !$rating || !$review_text) {
    echo "<script>alert('Missing review information.'); window.history.back();</script>";
    exit();
}

// Insert review
$insert = "INSERT INTO reviews (user_id, product_id, rating, review_text, created_at)
           VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insert);
$stmt->bind_param("iiiss", $user_id, $product_id, $rating, $review_text, $created_at);

if ($stmt->execute()) {
    echo "<script>alert('Review submitted successfully!'); window.location.href='../../../userpage/product/ProfilePage.php';</script>";
} else {
    echo "<script>alert('Failed to submit review.'); window.history.back();</script>";
}
$stmt->close();
$conn->close();