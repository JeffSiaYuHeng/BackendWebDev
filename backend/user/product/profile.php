<?php
include "../../db_connect.php"; // Include database connection

// Get user ID from session
$user_id = $_SESSION["user_id"];

// Fetch user details from database
$stmt = $conn->prepare("SELECT first_name, last_name, email, phone_number FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($first_name, $last_name, $email, $phone);
$stmt->fetch();
$stmt->close();
$conn->close();
?>