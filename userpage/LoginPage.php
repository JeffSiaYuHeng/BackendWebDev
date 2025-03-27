<?php
session_start();

// If user is already logged in, redirect to main
if (isset($_SESSION["user_id"])) {
    echo "<script>
        alert('You are already logged in.');
        window.location.href = 'MainPage.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/userstyle/login.css">
    <link rel="stylesheet" href="/BackendWebDev/userstyle/login.css">
    <link rel="stylesheet" href="/BackendWebDev/userstyle/transition.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <script src="/BackendWebDev/userscript/transition.js"></script>


    <title>Eternal Elegant Bridal - Login</title>
</head>

<body>
    <header>
        <h1>Eternal Elegant Bridal</h1>
    </header>
    <section>
        <h1>Welcome Back</h1>
        <p style="color:#808080">Enter your username and password to access your account</p>
        <form action="/BackendWebDev/backend/user/authenticate/login.php" method="POST" class="form">
            <label>username</label>
            <input type="text" name="username" placeholder="Enter your username" required>
            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your Password" required>
            <a href="ForgotPasswordPage.html">Forgot Password</a>
            <button type="submit">Sign In</button>
            <button type="button" onclick="window.location.href='RegisterPage.php'">Register</button>
        </form>
    </section>
</body>

</html>