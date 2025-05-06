<?php
session_start();

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
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      flex-direction: column;
      background: #f5f5f5;
    }

    header {
      background-color: #222;
      color: white;
      padding: 1rem;
      text-align: center;
    }

    .main-content {
      display: flex;
      height: 80vh;
    }

    .viewer {
      flex: 2;
      display: flex;
      justify-content: center;
      align-items: center;
      background: #ffffff;
      position: relative;
    }

    .viewer img {
      max-height: 80%;
      max-width: 100%;
      opacity: 0;
      transition: opacity 0.5s ease-in-out;
      position: absolute;
    }

    .viewer img.visible {
      opacity: 1;
      position: relative;
    }

    .controls {
      flex: 1;
      padding: 2rem;
      background: #222;
      color: white;
      display: flex;
      flex-direction: column;
      gap: 1.2rem;
    }

    .controls label {
      font-weight: bold;
    }

    .controls select {
      padding: 0.5rem;
      font-size: 1rem;
    }

    form button {
      margin-top: 2rem;
      padding: 0.75rem;
      font-size: 1rem;
      background-color: #00c2cb;
      border: none;
      color: white;
      cursor: pointer;
    }

    .review-section {
      padding: 2rem;
      background-color: #fff;
    }

    .review {
      border-bottom: 1px solid #ccc;
      margin-bottom: 1rem;
      padding-bottom: 1rem;
    }
  </style>
</head>
<body>

<header>
  <h1>Eternal Elegant Bridal - Customize Your Dress</h1>
</header>

<div class="main-content">
  <div class="viewer">
    <img id="dressImage" src="" alt="Dress Design" />
  </div>

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
