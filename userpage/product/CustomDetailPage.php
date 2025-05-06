<?php
session_start();

include "../../backend/user/cart/showCartNumber.php"; // Include database connection
// Ensure first_name is set; fallback to "Guest"
$first_name = $_SESSION["first_name"] ?? "Guest";

// 登录验证
if (!isset($_SESSION["user_id"])) {
    echo "<script>
        alert('Your session has expired or you are not logged in. Please log in again.');
        window.location.href = '../authenticate/LoginPage.php';
    </script>";
    exit();
}

include "../../backend/db_connect.php";

// 获取产品 ID
$productId = $_GET['id'] ?? null;
if (!$productId) {
    echo "<script>alert('Product not found.'); window.location.href='WeddingDressPage.php';</script>";
    exit();
}

// 获取产品信息
$stmt = $conn->prepare("SELECT name, price, image, description FROM products WHERE id = ? AND type = 'custom'");
$stmt->bind_param("i", $productId);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "<script>alert('Custom product not found.'); window.location.href='WeddingDressPage.php';</script>";
    exit();
}

// 获取评论
$reviews = [];
$review_query = "SELECT r.rating, r.review_text, u.username
                 FROM reviews r
                 LEFT JOIN users u ON r.user_id = u.id
                 WHERE r.product_id = ?
                 ORDER BY r.created_at DESC";

if ($stmt = $conn->prepare($review_query)) {
    $stmt->bind_param("i", $productId);
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
$image_path = $product['image'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($product['name']) ?> - Designer</title>
    <link rel="stylesheet" href="/BackendWebDev/userstyle/customdetail.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <header>
        <h1>Eternal Elegant Bridal - Customize Your Dress</h1><!-- Right container for Cart & Dropdown -->
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
            <img id="dressImage" src="" alt="Dress Design" />
        </div>
        <div class="details-container">
        <h2 id="bridalTitle"> <?= htmlspecialchars($product['name']) ?> </h2>

            <form class="controls" action="accessoriesPage.php" method="POST">
                <!-- Hidden fields for product info -->
                <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']) ?>">
                <input type="hidden" name="product_type" value="custom">
                <input type="hidden" name="product_price" value="<?= htmlspecialchars(number_format((float) $base_price, 2, '.', '')) ?>">

                <!-- User-selected fields -->
                <label for="color">Color: </label>
                <select id="color" name="color" required>
                    <option value="black">Black</option>
                    <option value="white">White</option>
                </select>

                <label for="design">Design: </label>
                <select id="design" name="design" required>
                    <option value="design1">Design 1</option>
                    <option value="design2">Design 2</option>
                    <option value="design3">Design 3</option>
                </select>

                <label for="length">Skirt Length: </label>
                <select id="length" name="length" required>
                    <option value="long">Long</option>
                    <option value="midi">Midi</option>
                </select>

                <label for="sleeve">Sleeve: </label>
                <select id="sleeve" name="sleeve" required>
                    <option value="sleeves">With Sleeves</option>
                    <option value="sleeveless">Sleeveless</option>
                </select>

                <label for="size">Size: </label>
                <select id="size" name="size" required>
                    <option value="S">Small (S)</option>
                    <option value="M">Medium (M)</option>
                    <option value="L">Large (L)</option>
                    <option value="XL">Extra Large (XL)</option>
                </select>

                <button type="submit">Continue</button>
            </form>
        </div>

    </div>


    <div class="review-section">
        <h2>Customer Reviews</h2>
        <?php if (!empty($reviews)): ?>
            <?php foreach ($reviews as $review): ?>
                <div class="review">
                    <p class="username"><strong><?= htmlspecialchars($review["username"]) ?></strong></p>
                    <p class="stars"><?= str_repeat("★", $review["rating"]) . str_repeat("☆", 5 - $review["rating"]) ?></p>
                    <p class="review-content"><?= htmlspecialchars($review["content"]) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No reviews yet. Be the first to review!</p>
        <?php endif; ?>
    </div>
    <div class="box"></div>

    <script>
        const image = document.getElementById("dressImage");
        const selects = document.querySelectorAll("select");

        function updateImage() {
            const color = document.getElementById("color").value;
            const design = document.getElementById("design").value;
            const length = document.getElementById("length").value;
            const sleeve = document.getElementById("sleeve").value;

            const filename = `${color}_${design}_${length}_${sleeve}.png`;
            const imagePath = `/BackendWebDev/image/WeddingDressImage/${filename}`;

            image.classList.remove("visible");

            setTimeout(() => {
                image.src = imagePath;
                image.onload = () => {
                    image.classList.add("visible");
                };
            }, 200);
        }

        selects.forEach(select => {
            select.addEventListener("change", updateImage);
        });

        window.onload = updateImage;
    </script>

</body>

</html>