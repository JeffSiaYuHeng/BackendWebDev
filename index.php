<?php
session_start();

// If user is already logged in, redirect to dashboard
if (isset($_SESSION["user_id"])) {
    header("Location: page/dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Start Button</title>
</head>

<body>
    <h1>index page</h1>
    <a href="page/login.php">Login</a>
    <a href="page/register.php">Register</a>
</body>

</html>