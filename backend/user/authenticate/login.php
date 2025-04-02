<?php
session_start();
include __DIR__ . "/../../../backend/db_connect.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Prepare SQL statement to fetch user data including the role
    if ($stmt = $conn->prepare("SELECT id, first_name, last_name, password, role FROM users WHERE username = ?")) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($user_id, $first_name, $last_name, $hashed_password, $role);
            $stmt->fetch();

            // Verify password with the hashed version in DB
            if (password_verify($password, $hashed_password)) {
                // Store session variables
                $_SESSION["user_id"] = $user_id;
                $_SESSION["username"] = $username;
                $_SESSION["first_name"] = $first_name;
                $_SESSION["last_name"] = $last_name;
                $_SESSION["user_name"] = $first_name . " " . $last_name;
                $_SESSION["role"] = $role;  // Store role in session

                // Redirect based on role
                if ($role === "admin") {
                    // Redirect to the admin page if the user is an Admin
                    echo "<script>alert('Welcome back Admin'); window.location.href='/BackendWebDev/admin/adminpage/MainPage.php';</script>";
                    exit();
                } else {
                    // Redirect to the user main page if the user is not an Admin
                    echo "<script>alert('Welcome back Admin'); window.location.href='/BackendWebDev/userpage/MainPage.php';</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Invalid username or password'); window.location.href='/BackendWebDev/userpage/authenticate/LoginPage.php';</script>";
            }
        } else {
            echo "<script>alert('Invalid username or password'); window.location.href='/BackendWebDev/userpage/authenticate/LoginPage.php';</script>";
        }

        $stmt->close();
    } else {
        // Handle error if query preparation fails
        echo "<script>alert('Database error. Please try again later.'); window.location.href='/BackendWebDev/userpage/authenticate/LoginPage.php';</script>";
    }

    // Close connection
    $conn->close();
}
?>
