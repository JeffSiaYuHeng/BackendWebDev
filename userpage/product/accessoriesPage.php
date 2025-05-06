<?php
session_start();
// If user is NOT logged in, show an alert and redirect to login page
if (!isset($_SESSION["user_id"])) {
    echo "<script>
        alert('Your session has expired or you are not logged in. Please log in again.');
        window.location.href = '../authenticate/LoginPage.php';
    </script>";
    exit();
}

// Ensure first_name is set; fallback to "Guest"
$first_name = $_SESSION["first_name"] ?? "Guest";

include "../../backend/user/product/accessories.php"; // Include database connection
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bridal Accessories | Eternal Elegant Bridal</title>
    <link rel="stylesheet" href="/BackendWebDev/userstyle/accessories.css">
    <script defer src="/BackendWebDev/userscript/accessories.js"></script>
</head>

<body>
    <header>
        <h1>Bridal Accessories</h1>
    </header>

    <section class="bridal-details">
        <h2>Your Bridal Selection</h2>
        <p><strong>Gown:</strong> <?= htmlspecialchars($product_name) ?></p>
        <p><strong>Type:</strong> <?= htmlspecialchars($product_type) ?></p>
        <p><strong>Size:</strong> <?= htmlspecialchars($size) ?></p>
        <p><strong>Base Price:</strong> RM<span id="basePrice"><?= number_format($product_price, 2) ?></span></p>
        <p><strong>Total Price:</strong> RM<span id="totalPrice"><?= number_format($product_price, 2) ?></span></p>
    </section>

    <section>
        <h2>Selected Accessories</h2>
        <div id="selected-accessories">

            <section class="accessories-container">
                <?php 
        // Categories for displaying accessories
        $categories = [
            "Veils" => [],
            "Tiaras" => [],
            "Shoes" => []
        ];

        // Sort accessories by category
        foreach ($accessories as $accessory) {
            $name = $accessory['name'];
            $price = $accessory['price'];
            $image = $accessory['image'];
            $category = $accessory['category'];

            if (strpos(strtolower($name), 'veil') !== false) {
                $categories['Veils'][] = ['name' => $name, 'price' => $price, 'image' => $image];
            } elseif (strpos(strtolower($name), 'tiara') !== false) {
                $categories['Tiaras'][] = ['name' => $name, 'price' => $price, 'image' => $image];
            } elseif (strpos(strtolower($name), 'heel') !== false || strpos(strtolower($name), 'flat') !== false) {
                $categories['Shoes'][] = ['name' => $name, 'price' => $price, 'image' => $image];
            }
        }

       // Loop through each category and display accessories
        foreach ($categories as $category => $items) {
            echo "<h2>$category</h2><div class='accessory-grid'>";
            foreach ($items as $item) {
                $name = htmlspecialchars($item['name']);
                $price = $item['price'];
                $image = $item['image'] ?? 'default.jpg'; // Use a default image if none exists

                echo "<div class='accessory'>
                        <img src='$image' alt='$name'>
                        <p>$name - RM $price</p>
                        <button 
                            class='select-btn' 
                            data-accessory='$name' 
                            data-price='$price' 
                            onclick=\"selectAccessory('$name', $price, '$image', this)\">
                            Select
                        </button>
                    </div>";
            }
            echo "</div>";
        }

        ?>
        </div>
    </section>
    </section>

    <form action="/BackendWebDev/backend/user/cart/addToCart.php" method="POST">
        <input type="hidden" name="product_name" value="<?= htmlspecialchars($product_name) ?>">
        <input type="hidden" name="product_type" value="<?= htmlspecialchars($product_type) ?>">
        <input type="hidden" name="product_price" id="finalPrice" value="<?= number_format($product_price, 2) ?>">
        <input type="hidden" name="size" value="<?= htmlspecialchars($size) ?>">
        <input type="hidden" name="accessories" id="selectedAccessories" value="">
        <button type="submit">Add to Cart</button>
    </form>

    <script>
    const basePrice = parseFloat(<?= $product_price ?>);
    let totalPrice = basePrice;
    let selectedAccessories = [];
    const accessoryButtons = {}; // Store references to buttons

    function selectAccessory(name, price, image, button) {
        if (selectedAccessories.includes(name)) return;

        selectedAccessories.push(name);
        totalPrice += price;

        // Disable the clicked button and mark it visually
        button.disabled = true;
        button.textContent = "Selected";
        button.classList.add("disabled-btn");

        accessoryButtons[name] = button;

        const selectedContainer = document.getElementById("selected-accessories");
        const item = document.createElement("div");
        item.classList.add("selected-item");
        item.id = name;

        item.innerHTML = `
        <p>${name} - RM ${price.toFixed(2)}</p>
        <button onclick="removeAccessory('${name}', ${price}')">Remove</button>
    `;

        selectedContainer.appendChild(item);
        updateTotalPrice();
    }


    function removeAccessory(name, price) {
        selectedAccessories = selectedAccessories.filter(item => item !== name);
        totalPrice -= price;

        // Re-enable the button and reset its style
        const button = accessoryButtons[name];
        if (button) {
            button.disabled = false;
            button.textContent = "Select";
            button.classList.remove("disabled-btn");
            delete accessoryButtons[name];
        }

        document.getElementById(name)?.remove();
        updateTotalPrice();
    }


    function updateTotalPrice() {
        document.getElementById("totalPrice").textContent = totalPrice.toFixed(2);
        document.getElementById("finalPrice").value = totalPrice.toFixed(2);
        document.getElementById("selectedAccessories").value = JSON.stringify(selectedAccessories);
    }
    </script>
</body>

</html>