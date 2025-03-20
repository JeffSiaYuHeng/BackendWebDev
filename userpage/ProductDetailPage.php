<?php
include "../backend/productDetail.php";

// Dummy reviews (replace with database values later)
$reviews = [
    ["username" => "Alice", "rating" => 5, "content" => "Absolutely loved this dress! The quality is amazing."],
    ["username" => "JohnDoe", "rating" => 4, "content" => "Beautiful fabric and design, but the size runs a bit small."],
    ["username" => "Sophia", "rating" => 3, "content" => "It's decent, but I expected better stitching."],
    ["username" => "EmilyR", "rating" => 5, "content" => "Perfect for my wedding! Highly recommend."],
    ["username" => "Michael", "rating" => 2, "content" => "Not what I expected. The fabric feels cheap."],
];

// Fabric prices
$fabric_prices = [
    "None" => 0,
    "fabric1" => 50,  // Lace adds RM50
    "fabric2" => 70,  // Satin adds RM70
    "fabric3" => 40,  // Tulle adds RM40
];

$base_price = $product['price'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($product['name']) ?></title>
    <script src="/BackendWebDev/userscript/transition.js"></script>
    <link rel="stylesheet" href="/BackendWebDev/userstyle/transition.css">
    <link rel="stylesheet" href="/BackendWebDev/userstyle/productDetailPage.css">
</head>
<body>
    <div class="product-container">
        <div class="image-container">
            <img src="<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" id="gownImage">
        </div>

        <div class="details-container">
            <h1 id="bridalTitle"> <?= htmlspecialchars($product['name']) ?> </h1>
            <h3 id="bridalType">Type: <?= htmlspecialchars($product['type']) ?> </h3>
            <p id="bridalDescription"> <?= htmlspecialchars($product['description']) ?> </p>
            <p id="bridalPrice">Price: RM<span id="dynamicPrice"> <?= number_format($base_price, 2) ?> </span></p>
            <input type="hidden" id="basePrice" value="<?= $base_price ?>">

            <form action="accessoriesPage.php" method="POST">
                <label for="size">Size:</label>
                <select name="size" id="size">
                    <option value="S">Small</option>
                    <option value="M">Medium</option>
                    <option value="L">Large</option>
                    <option value="XL">X-Large</option>
                </select>

                <div class="preview-container">
                    <div class="preview-box" id="previewBox">
                        <div class="fabric-overlay" id="fabricPreview"></div>
                    </div>
                </div>

                <label for="colorPicker">Select Color:</label>
                <select name="color" id="colorPicker">
                    <option value="White">White</option>
                    <option value="Ivory">Ivory</option>
                    <option value="Champagne">Champagne</option>
                    <option value="Antique White">Antique White</option>
                </select>

                <label for="fabricPicker">Select Fabric:</label>
                <select name="fabric" id="fabricPicker">
                    <option value="None">None</option>
                    <option value="fabric1">Lace</option>
                    <option value="fabric2">Satin</option>
                    <option value="fabric3">Tulle</option>
                </select>

                <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']) ?>">
                <input type="hidden" name="product_type" value="<?= htmlspecialchars($product['type']) ?>">
                <input type="hidden" id="finalPrice" name="product_price" value="<?= number_format((float) $base_price, 2, '.', '') ?>">

                <button type="submit">Continue</button>
            </form>
        </div>
    </div>

    <div class="review-section">
        <h2>Customer Reviews</h2>
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <p class="username"> <?= htmlspecialchars($review["username"]) ?> </p>
                    <p class="stars"> <?= str_repeat("★", $review["rating"]) . str_repeat("☆", 5 - $review["rating"]) ?> </p>
                    <p class="review-content"> <?= htmlspecialchars($review["content"]) ?> </p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet. Be the first to review!</p>
        <?php endif; ?>
    </div>

    <script src="/BackendWebDev/userscript/productDetailPage.js"></script>
</body>
</html>