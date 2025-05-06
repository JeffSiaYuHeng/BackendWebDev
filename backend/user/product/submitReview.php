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

// Validate inputs
if (!$product_id || !$rating || !$review_text) {
    echo "<script>alert('Missing review information.'); window.history.back();</script>";
    exit();
}

// Step 1: Check if review exists
$check_sql = "SELECT id FROM reviews WHERE user_id = ? AND product_id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("ii", $user_id, $product_id);
$check_stmt->execute();
$check_stmt->store_result();

if ($check_stmt->num_rows > 0) {
    // Review exists -> UPDATE
    $update_sql = "UPDATE reviews SET rating = ?, review_text = ?, created_at = ? WHERE user_id = ? AND product_id = ?";
    $update_stmt = $conn->prepare($update_sql);
    $update_stmt->bind_param("issii", $rating, $review_text, $created_at, $user_id, $product_id);
    
    if ($update_stmt->execute()) {
        echo "<script>alert('Review updated successfully!'); window.location.href='../../../userpage/product/ProfilePage.php';</script>";
    } else {
        echo "<script>alert('Failed to update review.'); window.history.back();</script>";
    }

    $update_stmt->close();
} else {
    // No review exists -> INSERT
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
}

$check_stmt->close();
$conn->close();