<?php
session_start();
include "db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $safe_key_answer = trim($_POST["safe_key_answer"]);
    $email = $_SESSION["reset_email"] ?? '';

    if (empty($email)) {
        echo json_encode(["status" => "error", "message" => "Session expired. Please restart."]);
        exit();
    }

    // Get the stored safe key answer
    $stmt = $conn->prepare("SELECT safe_key_answer FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_safe_key_answer);
        $stmt->fetch();

        // Verify the safe key answer
        if (password_verify($safe_key_answer, $hashed_safe_key_answer)) {
            echo json_encode(["status" => "success", "message" => "Correct answer. Redirecting..."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Incorrect answer. Try again."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Something went wrong. Try again."]);
    }

    $stmt->close();
    $conn->close();
}
?>