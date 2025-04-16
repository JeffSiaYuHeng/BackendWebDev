<?php
session_start();
include __DIR__ . "/../../../backend/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);

    // Define mapping of safe key values to full question text
    $safeKeyMap = [
        'pet_name' => "What is your first pet's name?",
        'mother_birth' => "What is your mother's birthdate?",
        'favorite_teacher' => "Who was your favorite teacher?"
    ];

    // Check if email exists
    $stmt = $conn->prepare("SELECT safe_key_question FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($safe_key_question);
        $stmt->fetch();
        $_SESSION["reset_email"] = $email; // Store email in session

        // Convert stored key into readable question
        $questionText = isset($safeKeyMap[$safe_key_question]) ? $safeKeyMap[$safe_key_question] : "Security question";

        // Send full question text back
        echo json_encode([
            "status" => "success",
            "question" => $questionText
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Email not found. Try again."
        ]);
    }

    $stmt->close();
    $conn->close();
}
?>