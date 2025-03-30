<?php
session_start();
include __DIR__ . "/../../../backend/db_connect.php";

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["status" => "error", "message" => "User not logged in."]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $new_address = trim($_POST["new_address"]);
    $user_id = $_SESSION["user_id"];

    $sql = "UPDATE users SET address = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $new_address, $user_id);

    if ($stmt->execute()) {
        // Redirect back to ProfilePage.php
        header("Location: /BackendWebDev/userpage/product/ProfilePage.php");
        exit();
    } else {
        echo json_encode(["status" => "error", "message" => "Error updating address."]);
    }

    $stmt->close();
    $conn->close();
}
?>