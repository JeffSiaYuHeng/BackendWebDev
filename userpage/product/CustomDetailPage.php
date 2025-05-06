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
  <meta charset="UTF-8" />
  <title>Dress Designer Viewer</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      height: 100vh;
      background: #f5f5f5;
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
      gap: 1.5rem;
    }

    .controls label {
      font-weight: bold;
    }

    .controls select {
      padding: 0.5rem;
      font-size: 1rem;
      margin-top: 0.25rem;
    }
  </style>
</head>
<body>

  <div class="viewer">
    <img id="dressImage" src="" alt="Dress Design" />
  </div>

  <div class="controls">
    <div>
      <label for="color">颜色：</label>
      <select id="color">
        <option value="black">黑色</option>
        <option value="white">白色</option>
      </select>
    </div>

    <div>
      <label for="design">设计：</label>
      <select id="design">
        <option value="design1">Design 1</option>
        <option value="design2">Design 2</option>
        <option value="design3">Design 3</option>
      </select>
    </div>

    <div>
      <label for="length">裙摆长度：</label>
      <select id="length">
        <option value="long">长</option>
        <option value="midi">中长</option>
      </select>
    </div>

    <div>
      <label for="sleeve">袖子：</label>
      <select id="sleeve">
        <option value="sleeves">有袖子</option>
        <option value="sleeveless">无袖子</option>
      </select>
    </div>
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
      const imagePath = `images/${filename}`;

      // Fade-out
      image.classList.remove("visible");
      
      setTimeout(() => {
        image.src = imagePath;

        // After image loads, fade-in
        image.onload = () => {
          image.classList.add("visible");
        };
      }, 200);
    }

    selects.forEach(select => {
      select.addEventListener("change", updateImage);
    });

    // Initialize default image
    window.onload = updateImage;
  </script>

</body>
</html>
