<?php
session_start();

include "../../backend/user/product/productDetail.php";
include "../../backend/user/cart/showCartNumber.php"; // Include database connection
// Ensure first_name is set; fallback to "Guest"
$first_name = $_SESSION["first_name"] ?? "Guest";

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

$base_price = $product['price'];

// Extract image directory
$product_image = $product['image'];
$image_dir = dirname($product_image);

$image_extensions = ['jpg', 'jpeg', 'png', 'webp'];
$additional_images = [];

$absolute_path = $_SERVER['DOCUMENT_ROOT'] . $image_dir;

if (is_dir($absolute_path)) {
    $files = scandir($absolute_path);
    foreach ($files as $file) {
        $file_extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        if (in_array($file_extension, $image_extensions)) {
            $additional_images[] = $image_dir . '/' . $file;
        }
    }
}

if (!empty($additional_images)) {
    $main_image = $product_image;
    $additional_images = array_diff($additional_images, [$main_image]);
} else {
    $main_image = $product_image;
}

// Get average rating for the product
$avg_rating = 0;
$count_rating = 0;

$avg_query = "SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews FROM reviews WHERE product_id = ?";
if ($stmt = $conn->prepare($avg_query)) {
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $stmt->bind_result($avg_rating_result, $count_rating_result);
    if ($stmt->fetch()) {
        $avg_rating = $avg_rating_result;
        $count_rating = $count_rating_result;
    }
    $stmt->close();
}

$recommended_products = [];

$recommend_stmt = $conn->prepare("SELECT id, name, price, image, type FROM products WHERE id != ? ORDER BY RAND() LIMIT 4");

if ($recommend_stmt) {
    $recommend_stmt->bind_param("i", $product_id);
    $recommend_stmt->execute();
    $result = $recommend_stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $recommended_products[] = $row;
    }
    $recommend_stmt->close();
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="/BackendWebDev/userstyle/productDetailPage.css">
</head>

<body>
    <header>
        <h1>Eternal Elegant Bridal</h1>
        <!-- Right container for Cart & Dropdown -->
        <div class="right-section">
            <button class="cart-btn" id="open-btn" onclick="window.location.href='../cart/CartPage.php'">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                <?php if ($cart_count > 0): ?>
                <span class="icon-button__badge"><?= $cart_count ?></span>
                <?php endif; ?>
            </button>
            <div class="dropdown">
                <button class="dropbtn" id="account-btn">
                    <span>Me <i class="fa fa-angle-down" aria-hidden="true"></i></span>
                </button>
                <div class="dropdown-content">
                    <p>Hello <?php echo htmlspecialchars($first_name); ?>!</p>
                    <div class="line"></div>
                    <a href="ProfilePage.php">Profile</a>
                    <a href="../../backend/user/authenticate/logout.php">Logout</a>
                </div>
            </div>
    </header>
    <nav>
        <a class="blink" href="MainPage.php">Home</a> |
        <a class="blink" href="WeddingDressPage.php">Wedding Dress</a> |
        <a class="blink" href="AboutPage.php">About</a> |
        <a class="blink" href="ContactPage.php">Contact</a>
    </nav>
    <div class="product-container">
        <div class="image-container">
            <img src="<?= htmlspecialchars($main_image) ?>" alt="<?= htmlspecialchars($product['name']) ?>"
                id="gownImage">
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
            <div class="average-rating">
                <h2>Average Rating</h2>
                <?php if ($count_rating > 0): ?>
                <p>
                    <?= number_format($avg_rating, 1) ?> / 5.0
                    (<?= $count_rating ?> review<?= $count_rating > 1 ? 's' : '' ?>)
                </p>
                <p class="stars">
                    <?= str_repeat("★", floor($avg_rating)) ?>
                    <?= ($avg_rating - floor($avg_rating) >= 0.5) ? "⯨" : "" ?>
                    <?= str_repeat("☆", 5 - ceil($avg_rating)) ?>
                </p>
                <?php else: ?>
                <p>No ratings yet</p>
                <?php endif; ?>
            </div>

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
    <div class="box"></div>

    <?php if (!empty($recommended_products)): ?>
    <div class="recommendation-section">
        <h2>You May Also Like</h2>
        <div class="recommended-grid">
            <?php foreach ($recommended_products as $rec): ?>
            <div class="recommended-product">
                <a
                    href="<?= $rec['type'] === 'custom' ? 'CustomDetailPage.php' : 'ProductDetailPage.php' ?>?id=<?= $rec['id'] ?>">
                    <img src="<?= htmlspecialchars($rec['image']) ?>" alt="<?= htmlspecialchars($rec['name']) ?>"
                        class="recommended-img">
                    <h3><?= htmlspecialchars($rec['name']) ?></h3>
                    <p>Price: RM <?= number_format($rec['price'], 2) ?></p>
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <?php endif; ?>

    <footer>
        <p>&copy; 2021 Eternal Elegant Bridal. All rights reserved.</p>
    </footer>
    <script>
    function changeImage(newSrc) {
        document.getElementById("gownImage").src = newSrc;
    }
    </script>
    <script src="/BackendWebDev/userscript/productDetailPage.js"></script>
</body>

</html>