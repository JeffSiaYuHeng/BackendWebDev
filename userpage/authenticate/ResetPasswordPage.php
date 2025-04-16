<?php
session_start();

// Check if user is logged in OR resetting via forgot password
if (!isset($_SESSION["user_id"]) && !isset($_SESSION["reset_email"])) {
    echo "<script>
        alert('Unauthorized access! Please log in or use the forgot password process.');
        window.location.href = 'LoginPage.php';
    </script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/BackendWebDev/userscript/resetPassword.js"></script>
    <link rel="stylesheet" href="/BackendWebDev/userstyle/resetpassword.css">
    <link rel="stylesheet" href="/BackendWebDev/userstyle/transition.css">
    <script src="/BackendWebDev/userscript/transition.js"></script>

</head>

<body>
    <h1>Reset Password</h1>
    <p style="color:#808080">Enter your new password</p>

    <form id="reset-password-form">
        <label>New Password</label>
        <input type="password" id="new_password" name="new_password" placeholder="Enter new password" required>

        <label>Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password"
            required>

        <button type="submit">Reset Password</button>
    </form>
</body>

</html>