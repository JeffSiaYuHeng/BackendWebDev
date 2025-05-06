<?php
include "../../backend/user/product/productDetail.php";

// Fetch actual reviews from the database
$reviews = [];



$review_query = "SELECT r.rating, r.review_text, u.username
                 FROM reviews r
                 LEFT JOIN users u ON r.user_id = u.id
                 WHERE r.product_id = ?
                 ORDER BY r.created_at DESC";

if ($stmt = $conn->prepare($review_query)) {
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $reviews[] = [
            "username" => $row["username"] ?? "Anonymous",
            "rating" => (int) $row["rating"],
            "content" => $row["review_text"]
        ];
    }
    $stmt->close();
}

// Fabric prices
$fabric_prices = [
    "None" => 0,
    "fabric1" => 50,  // Lace adds RM50
    "fabric2" => 70,  // Satin adds RM70
    "fabric3" => 40,  // Tulle adds RM40
];

$base_price = $product['price'];



// to Jeff: this is get the image path and by using the pathinfo function, we can get the directory of the image
// and i adding php to remove the image name like dress.jpg and get the directory of the image
// and then i will use the directory to get all the images in the directory and display it in the product detail page
// Extract the directory from the product image path
$product_image = $product['image'];  // Example: /BackendWebDev/image/dress/dress1/dress1.jpg
$image_dir = dirname($product_image); // This extracts "/BackendWebDev/image/dress/dress1"

// Get all images in the directory
$image_extensions = ['jpg', 'jpeg', 'png', 'webp'];
$additional_images = [];

// Get absolute path
$absolute_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;

// Check if the directory exists and scan for images
if (is_dir($absolute_path)) {
    $files = scandir($absolute_path);
    foreach ($files as $file) {
        $file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($file_extension, $image_extensions)) {
            $additional_images[] = $image_dir . '/' . $file;  // Store the relative path
        }
    }
}

// Ensure the main image is at the start
if (!empty($additional_images)) {
    $main_image = $product_image;
    $additional_images = array_diff($additional_images, [$main_image]);
} else {
    $main_image = $product_image;
}
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
    <header>
        <h1>Eternal Elegant Bridal</h1>
    </header>
    <div class="product-container">
        <div class="image-container">
            <!-- Main Product Image -->
            <img src="<?= htmlspecialchars($main_image) ?>" alt="<?= htmlspecialchars($product['name']) ?>"
                id="gownImage">

            <!-- Additional Images for Product Views -->
            <div class="additional-images">
                <?php foreach ($additional_images as $img): ?>
                <img src="<?= htmlspecialchars($img) ?>"
                    alt="Additional view of <?= htmlspecialchars($product['name']) ?>" class="extra-image"
                    onclick="changeImage(this.src)">
                <?php endforeach; ?>
            </div>
        </div>

        <div class="details-container">
            <h2 id="bridalTitle"> <?= htmlspecialchars($product['name']) ?> </h2>
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

                <br>
                <label for="fabricPicker">Select Fabric:</label>
                <select name="fabric" id="fabricPicker" required>
                    <option value="" disabled selected>Select a fabric</option>
                    <option value="fabric1">Lace</option>
                    <option value="fabric2">Satin</option>
                    <option value="fabric3">Tulle</option>
                </select>


                <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']) ?>">
                <input type="hidden" name="product_type" value="<?= htmlspecialchars($product['type']) ?>">
                <input type="hidden" id="finalPrice" name="product_price"
                    value="<?= number_format((float) $base_price, 2, '.', '') ?>">

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

    <script>
    function changeImage(newSrc) {
        document.getElementById("gownImage").src = newSrc;
    }
    </script>
    <script src="/BackendWebDev/userscript/productDetailPage.js"></script>
</body>

</html>