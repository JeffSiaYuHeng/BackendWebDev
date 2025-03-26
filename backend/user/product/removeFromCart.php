<?php
session_start();
include __DIR__ . "/../../../backend/db_connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cart_item_id'])) {
    $cart_item_id = intval($_POST['cart_item_id']);

    // Ensure the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(["status" => "error", "message" => "User not logged in"]);
        exit;
    }

    $user_id = $_SESSION['user_id'];

    // Start transaction to ensure data consistency
    $conn->begin_transaction();

    try {
        // Get cart_id from the cart_items table
        $sql = "SELECT cart_id, price, quantity FROM cart_items WHERE id = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cart_item_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        if ($result->num_rows === 0) {
            throw new Exception("Cart item not found.");
        }

        $cart_item = $result->fetch_assoc();
        $cart_id = $cart_item['cart_id'];
        $price_to_deduct = $cart_item['price'] * $cart_item['quantity'];

        // Delete any related accessories from cart_accessories
        $sql = "DELETE FROM cart_accessories WHERE cart_item_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $cart_item_id);
        $stmt->execute();
        $stmt->close();

        // Remove the item from cart_items
        $sql = "DELETE FROM cart_items WHERE id = ? AND cart_id IN (SELECT id FROM cart WHERE user_id = ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $cart_item_id, $user_id);
        $stmt->execute();
        $stmt->close();

        // Update the total price in the cart table
        $sql = "UPDATE cart SET total_price = total_price - ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("di", $price_to_deduct, $cart_id);
        $stmt->execute();
        $stmt->close();

        // Commit the transaction
        $conn->commit();

        echo json_encode(["status" => "success", "message" => "Item removed from cart"]);
    } catch (Exception $e) {
        $conn->rollback(); // Rollback in case of failure
        echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request"]);
}

$conn->close();

header("Location: /BackendWebDev/userpage/CartPage.php");

?>
