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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?></title>

    <script src="/BackendWebDev/script/transition.js"></script>
    
    <link rel="stylesheet" href="/BackendWebDev/style/transition.css">
    <link rel="stylesheet" href="/BackendWebDev/style/productDetailPage.css">

</head>

<body>

    <div class="product-container">
        <!-- Left Side: Bridal Image -->
        <div class="image-container">
            <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                alt="<?php echo htmlspecialchars($product['name']); ?>" id="gownImage">
        </div>

        <!-- Right Side: Bridal Details -->
        <div class="details-container">
            <h1 id="bridalTitle"><?php echo htmlspecialchars($product['name']); ?></h1>
            <h3 id="bridalType">Type: <?php echo htmlspecialchars($product['type']); ?></h3>
            <p id="bridalDescription"><?php echo htmlspecialchars($product['description']); ?></p>
            <p id="bridalPrice">Price: RM<?php echo number_format($product['price'], 2); ?></p>

            <!-- Size Selection -->
            <label for="size">Size:</label>
            <select id="size">
                <option value="S">Small</option>
                <option value="M">Medium</option>
                <option value="L">Large</option>
                <option value="XL">X-Large</option>
            </select>

            <!-- Color Selection -->
            <label for="colorPicker">Select Color:</label>
            <select id="colorPicker">
                <option value="#FFFFFF">White</option>
                <option value="#F5F5DC">Ivory</option>
                <option value="#EAE0C8">Champagne</option>
                <option value="#FAEBD7">Antique White</option>
            </select>

            <!-- Fabric Selection -->
            <label for="fabricPicker">Select Fabric:</label>
            <select id="fabricPicker">
                <option value="none">None</option>
                <option value="fabric1">Lace</option>
                <option value="fabric2">Satin</option>
                <option value="fabric3">Tulle</option>
            </select>
        </div>
    </div>

    <!-- Review Section -->
    <div class="review-section">
        <h2>Customer Reviews</h2>
        
        <?php if (count($reviews) > 0): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <p class="username"><?php echo htmlspecialchars($review["username"]); ?></p>
                    <p class="stars"><?php echo str_repeat("★", $review["rating"]) . str_repeat("☆", 5 - $review["rating"]); ?></p>
                    <p class="review-content"><?php echo htmlspecialchars($review["content"]); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet. Be the first to review!</p>
        <?php endif; ?>
    </div>

    <script src="/BackendWebDev/script/productDetailPage.js"></script>

</body>

</html>
