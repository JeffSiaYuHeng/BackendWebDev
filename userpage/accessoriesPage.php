<?php
// Retrieve bridal details from POST request
$product_name = $_POST['product_name'] ?? 'Unknown Bridal Gown';
$product_type = $_POST['product_type'] ?? 'Unknown Type';
$product_price = $_POST['product_price'] ?? '0.00';
$size = $_POST['size'] ?? 'Not Selected';
$color = $_POST['color'] ?? 'Default Color';
$fabric = $_POST['fabric'] ?? 'Default Fabric';

// Fabric mapping
$fabric_options = ["fabric1" => "Lace", "fabric2" => "Satin", "fabric3" => "Tulle"];
$fabric_display = $fabric_options[$fabric] ?? $fabric;

// Convert product price to float
$product_price = (float) str_replace(',', '', $product_price);

// Define accessory prices
$accessory_prices = [
    "Classic Lace Veil" => 100.00,
    "Cathedral Veil" => 150.00,
    "Birdcage Veil" => 80.00,
    "Royal Crystal Tiara" => 120.00,
    "Pearl Crown Tiara" => 140.00,
    "Floral Gold Tiara" => 110.00,
    "Ivory Satin Heels" => 200.00,
    "Embroidered Flats" => 180.00,
    "Crystal Stiletto" => 250.00
];

// Convert prices to JSON for JavaScript use
$accessory_prices_json = json_encode($accessory_prices);
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
        <p><strong>Color:</strong> <?= htmlspecialchars($color) ?></p>
        <p><strong>Fabric:</strong> <?= htmlspecialchars($fabric_display) ?></p>
        <p><strong>Base Price:</strong> RM<span id="basePrice"><?= number_format($product_price, 2) ?></span></p>
        <p><strong>Total Price:</strong> RM<span id="totalPrice"><?= number_format($product_price, 2) ?></span></p>
    </section>
    
    <section>
        <h2>Selected Accessories</h2>
        <div id="selected-accessories"></div>
    </section>
    
    <section class="accessories-container">
        <?php 
        $categories = [
            "Veils" => ["Classic Lace Veil" => "veil1.jpg", "Cathedral Veil" => "veil2.jpg", "Birdcage Veil" => "veil3.jpg"],
            "Tiaras" => ["Royal Crystal Tiara" => "tiara1.jpg", "Pearl Crown Tiara" => "tiara2.jpg", "Floral Gold Tiara" => "tiara3.jpg"],
            "Shoes" => ["Ivory Satin Heels" => "shoe1.jpg", "Embroidered Flats" => "shoe2.jpg", "Crystal Stiletto" => "shoe3.jpg"]
        ];
        
        foreach ($categories as $category => $items) {
            echo "<h2>$category</h2><div class='accessory-grid'>";
            foreach ($items as $name => $image) {
                $price = $accessory_prices[$name] ?? 0;
                echo "<div class='accessory'>
                        <img src='$image' alt='$name'>
                        <p>$name - RM $price</p>
                        <button onclick=\"selectAccessory('$name', $price, '$image')\">Select</button>
                      </div>";
            }
            echo "</div>";
        }
        ?>
    </section>
    
    <form action="order.php" method="POST">
        <input type="hidden" name="product_name" value="<?= htmlspecialchars($product_name) ?>">
        <input type="hidden" name="product_type" value="<?= htmlspecialchars($product_type) ?>">
        <input type="hidden" name="product_price" id="finalPrice" value="<?= number_format($product_price, 2) ?>">
        <input type="hidden" name="size" value="<?= htmlspecialchars($size) ?>">
        <input type="hidden" name="color" value="<?= htmlspecialchars($color) ?>">
        <input type="hidden" name="fabric" value="<?= htmlspecialchars($fabric_display) ?>">
        <input type="hidden" name="accessories" id="selectedAccessories" value="">
        <button type="submit">Add to Cart</button>
        </form>

    <script>
        const basePrice = parseFloat(<?= $product_price ?>);
        let totalPrice = basePrice;
        let selectedAccessories = [];

        // Accessory Prices from PHP
        const accessoryPrices = <?= $accessory_prices_json ?>;

        function selectAccessory(name, price, image) {
            if (selectedAccessories.includes(name)) return;

            selectedAccessories.push(name);
            totalPrice += price;

            const selectedContainer = document.getElementById("selected-accessories");
            const item = document.createElement("div");
            item.classList.add("selected-item");
            item.id = name;
            
            item.innerHTML = `
                <img src="${image}" alt="${name}">
                <p>${name} - RM ${price.toFixed(2)}</p>
                <button onclick="removeAccessory('${name}', ${price})">Remove</button>
            `;

            selectedContainer.appendChild(item);
            updateTotalPrice();
        }

        function removeAccessory(name, price) {
            selectedAccessories = selectedAccessories.filter(item => item !== name);
            totalPrice -= price;
            document.getElementById(name).remove();
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
