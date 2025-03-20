<?php
session_start();
include "../../db_connect.php"; // Goes back two folders

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Check if email exists
    $stmt = $conn->prepare("SELECT safe_key_question FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($safe_key_question);
        $stmt->fetch();
        $_SESSION["reset_email"] = $email; // Store email in session

        // Send safe key question back as JSON
        echo json_encode(["status" => "success", "question" => $safe_key_question]);
    } else {
        echo json_encode(["status" => "error", "message" => "Email not found. Try again."]);
    }

    $stmt->close();
    $conn->close();
}
?>