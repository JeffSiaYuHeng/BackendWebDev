<?php
session_start();
include __DIR__ . "/../../../backend/db_connect.php";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Prepare SQL statement to fetch user data
    $stmt = $conn->prepare("SELECT id, first_name, last_name, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $first_name, $last_name, $hashed_password);
        $stmt->fetch();

        // Verify password with hashed version in DB
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $user_id;
            $_SESSION["username"] = $username;
            $_SESSION["first_name"] = $first_name;  // ✅ Store first_name in session
            $_SESSION["last_name"] = $last_name;    // ✅ Store last_name in session
            $_SESSION["user_name"] = $first_name . " " . $last_name;
            

            // ✅ Redirect to main after successful login
            header("Location: /BackendWebDev/userpage/MainPage.php");
            exit();
        } else {
            echo "<script>alert('Invalid username or password'); window.location.href='/BackendWebDev/userpage/LoginPage.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid username or password'); window.location.href='/BackendWebDev/userpage/LoginPage.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>