<?php
session_start();
include "db_connect.php"; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    // Prepare SQL statement to fetch user data
    $stmt = $conn->prepare("SELECT id, first_name, last_name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $first_name, $last_name, $hashed_password);
        $stmt->fetch();

        // Verify password with hashed version in DB
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $user_id;
            $_SESSION["email"] = $email;
            $_SESSION["first_name"] = $first_name;  // ✅ Store first_name in session
            $_SESSION["last_name"] = $last_name;    // ✅ Store last_name in session
            $_SESSION["user_name"] = $first_name . " " . $last_name;

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