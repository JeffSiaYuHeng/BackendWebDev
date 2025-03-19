<?php

include "../backend/productDetail.php"; 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['name']); ?></title>
    <script src="/BackendWebDev/userscript/transition.js"></script>

    <link rel="stylesheet" href="/BackendWebDev/userstyle/transition.css">
    <link rel="stylesheet" href="/BackendWebDev/userstyle/productDetailPage.css">

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

            <!-- Color & Fabric Preview -->
            <div class="preview-container">
                <div class="preview-box" id="previewBox">
                    <div class="fabric-overlay" id="fabricPreview"></div>
                </div>
            </div>

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

    <script src="/BackendWebDev/userscript/productDetailPage.js"></script>

</body>

</html>