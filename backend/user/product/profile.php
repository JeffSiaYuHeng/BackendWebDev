<?php
include __DIR__ . "/../../../backend/db_connect.php";

// Ensure session variables are set
$first_name = $_SESSION["first_name"] ?? "Guest";
$last_name = $_SESSION["last_name"] ?? "";
$email = $_SESSION["email"] ?? "";
$phone = $_SESSION["phone_number"] ?? "";
$address = $_SESSION["address"] ?? "";

// Get user ID from session
$user_id = $_SESSION["user_id"];

// Fetch user details from database
$stmt = $conn->prepare("SELECT first_name, last_name, email, phone_number,address FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $email, $phone, $address);
$stmt->fetch();
$stmt->close();
$conn->close();
?>