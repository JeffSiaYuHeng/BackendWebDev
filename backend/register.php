<?php
session_start();
include "db_connect.php"; // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $first_name = trim(htmlspecialchars($_POST["first_name"]));
    $last_name = trim(htmlspecialchars($_POST["last_name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $country_code = trim($_POST["country_code"]);
    $phone_number = trim($_POST["phone_number"]);
    $address = trim(htmlspecialchars($_POST["address"]));
    $password = trim($_POST["password"]);
    $safe_key_question = trim($_POST["safe_key_question"]);
    $safe_key_answer = trim($_POST["safe_key_answer"]);

    // Ensure the phone number includes the country code correctly
    $full_phone_number = (strpos($country_code, "+") === false) ? "+" . $country_code . $phone_number : $country_code . $phone_number;

    // Check if the email already exists
    $check_email = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check_email->bind_param("s", $email);
    $check_email->execute();
    $check_email->store_result();

    if ($check_email->num_rows > 0) {
        echo "<script>alert('Email already exists! Please use another email.'); window.location.href='/page/register.php';</script>";
        exit();
    }
    $check_email->close();

    // Hash the password & safe key answer for security
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $hashed_safe_key_answer = password_hash($safe_key_answer, PASSWORD_BCRYPT);

    // Insert user data into the database
    $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, phone_number, address, password, safe_key_question, safe_key_answer) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $first_name, $last_name, $email, $full_phone_number, $address, $hashed_password, $safe_key_question, $hashed_safe_key_answer);

    if ($stmt->execute()) {
        // Store session variables
        $_SESSION["user_id"] = $stmt->insert_id; // Store user ID in session
        $_SESSION["email"] = $email;
        $_SESSION["first_name"] = $first_name; // ✅ Add this line
        $_SESSION["last_name"] = $last_name;  // Optional, in case you need it
        $_SESSION["user_name"] = $first_name . " " . $last_name; // Store user's full name in session

        // Redirect to main
        header("Location: /page/main.php");
        exit();
    } else {
        echo "<script>alert('Error: Could not register user. Please try again later.'); window.location.href='/page/register.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>