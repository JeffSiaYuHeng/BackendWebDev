<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    echo "<script>
        alert('Session expired. Please log in again.');
        window.location.href = '../authenticate/LoginPage.php';
    </script>";
    exit();
}

include "../../backend/db_connect.php";

$productId = $_GET['id'] ?? null;
if (!$productId) {
    echo "<script>alert('Product not found.'); window.location.href='WeddingDressPage.php';</script>";
    exit();
}

// Fetch the base product details
$stmt = $conn->prepare("SELECT name, price, image, description FROM products WHERE id = ? AND type = 'custom'");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "<script>alert('Custom product not found.'); window.location.href='WeddingDressPage.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Customize Your Wedding Dress</title>
    <link rel="stylesheet" href="/BackendWebDev/userstyle/customizePage.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

    <header>
        <h1>Customize Your Wedding Dress</h1>
    </header>

    <section class="customize-section">
        <div class="product-preview">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <p><?= htmlspecialchars($product['description']) ?></p>
        </div>

        <div class="customize-options">
            <form action="../../backend/user/cart/addCustomToCart.php" method="post">
                <input type="hidden" name="product_id" value="<?= $productId ?>">

                <div class="option-group">
                    <label for="size">Select Size:</label>
                    <select name="size" id="size" required>
                        <option value="">Choose size</option>
                        <option value="S">Small (S)</option>
                        <option value="M">Medium (M)</option>
                        <option value="L">Large (L)</option>
                        <option value="XL">Extra Large (XL)</option>
                    </select>
                </div>

                <div class="option-group">
                    <label for="color">Select Color:</label>
                    <select name="color" id="color" required>
                        <option value="">Choose color</option>
                        <option value="White">White</option>
                        <option value="Ivory">Ivory</option>
                        <option value="Blush Pink">Blush Pink</option>
                        <option value="Champagne">Champagne</option>
                    </select>
                </div>

                <div class="option-group">
                    <label>Add Accessories:</label>
                    <div class="accessories-list">
                        <label><input type="checkbox" name="accessories[]" value="Veil" data-price="100"> Veil
                            (+RM100)</label>
                        <label><input type="checkbox" name="accessories[]" value="Gloves" data-price="50"> Gloves
                            (+RM50)</label>
                        <label><input type="checkbox" name="accessories[]" value="Necklace" data-price="150"> Necklace
                            (+RM150)</label>
                        <label><input type="checkbox" name="accessories[]" value="Tiara" data-price="200"> Tiara
                            (+RM200)</label>
                    </div>
                </div>

                <div class="price-summary">
                    <h3>Estimated Price: <span id="totalPrice">RM <?= number_format($product['price'], 2) ?></span></h3>
                </div>

                <button type="submit" class="add-to-cart-btn">Add Customized Dress to Cart</button>
            </form>
        </div>
    </section>



    <footer>
        <p>&copy; 2021 Eternal Elegant Bridal. All rights reserved.</p>
    </footer>
    <script>
    $(document).ready(function() {
        let basePrice = <?= $product['price'] ?>;

        function updatePrice() {
            let totalPrice = basePrice;
            $("input[name='accessories[]']:checked").each(function() {
                totalPrice += parseFloat($(this).attr("data-price"));
            });
            $("#totalPrice").text("RM " + totalPrice.toFixed(2));
        }

        $("input[name='accessories[]']").change(function() {
            updatePrice();
        });
    });
    </script>

</body>

</html>