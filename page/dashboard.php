<?php
session_start();

// If user is NOT logged in, show an alert and redirect to login page
if (!isset($_SESSION["user_id"])) {
    echo "<script>
        alert('Your session has expired or you are not logged in. Please log in again.');
        window.location.href = 'login.php';
    </script>";
    var_dump($_SESSION);

    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/transitions.css">
    <title>Dashboard</title>
    <script src="/script/transition.js"></script>
</head>

<body>
    <h1>Welcome to Your Dashboard</h1>
    <p>You are logged in as <?php echo htmlspecialchars($_SESSION["email"] ?? "Unknown User"); ?></p>
    <a href="login.php">login test</a>
    <a href="/backend/logout.php">Logout</a>
</body>

</html>