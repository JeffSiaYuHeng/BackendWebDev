<?php
session_start();
include "db_connect.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Prepare SQL statement to fetch user data
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Verify password with hashed version in DB
        if (password_verify($password, $row["password"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["email"] = $email;

            // ✅ Redirect to dashboard after successful login
            header("Location: /page/dashboard.php");
            exit();
        } else {
            echo "<script>alert('Invalid email or password'); window.location.href='/page/login.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid email or password'); window.location.href='/page/login.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>