<?php
session_start();
include __DIR__ . "/../../../backend/db_connect.php";

// Allow password reset for both logged-in users & forgot password users
if (!isset($_SESSION["reset_email"]) && !isset($_SESSION["user_id"])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized request."]);
    exit();
}

// Get new password from request
$new_password = trim($_POST["new_password"]);

// Basic password validation
if (strlen($new_password) < 8) {
    echo json_encode(["status" => "error", "message" => "Password must be at least 8 characters long."]);
    exit();
}

// Hash the new password
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

// Determine which email to use
if (isset($_SESSION["reset_email"])) {
    $email = $_SESSION["reset_email"]; // Forgot password flow
} else {
    // Fetch email from database using logged-in user ID
    $stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION["user_id"]);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $email = $row["email"];
    } else {
        echo json_encode(["status" => "error", "message" => "User not found."]);
        exit();
    }
    $stmt->close();
}

// Update password in database
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->bind_param("ss", $hashed_password, $email);

if ($stmt->execute()) {
    // Destroy session to force logout
    session_unset();
    session_destroy();
    session_start(); // Start a new session to avoid errors

    echo json_encode(["status" => "success", "message" => "Password reset successful! Please log in again."]);
} else {
    echo json_encode(["status" => "error", "message" => "Something went wrong. Please try again."]);
}

$stmt->close();
$conn->close();
?>