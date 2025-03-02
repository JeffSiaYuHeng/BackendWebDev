<?php
$servername = "localhost";
$username = "root";  // Default XAMPP user
$password = "";      // Leave empty for XAMPP
$database = "backendweb";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>