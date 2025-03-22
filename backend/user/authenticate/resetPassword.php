<?php
session_start();
include "../../db_connect.php"; // Ensure the path is correct

// Check if the user is authorized (e.g., session variable set after security question verification)
if (!isset($_SESSION["reset_email"])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized request."]);
    exit();
}

// Get the new password from the request
$new_password = trim($_POST["new_password"]);

// Basic password validation
if (strlen($new_password) < 8) {
    echo json_encode(["status" => "error", "message" => "Password must be at least 8 characters long."]);
    exit();
}

// Hash the new password before storing it in the database
$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
$email = $_SESSION["reset_email"]; // Email stored in session during forgot password flow

// Update the password in the database
$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
$stmt->bind_param("ss", $hashed_password, $email);

if ($stmt->execute()) {
    // Password updated successfully
    unset($_SESSION["reset_email"]); // Remove reset session for security
    echo json_encode(["status" => "success", "message" => "Password reset successful! Redirecting to login..."]);
} else {
    echo json_encode(["status" => "error", "message" => "Something went wrong. Please try again."]);
}

$stmt->close();
$conn->close();
?>