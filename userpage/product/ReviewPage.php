<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    echo "<script>
        alert('Your session has expired or you are not logged in. Please log in again.');
        window.location.href = '../authenticate/LoginPage.php';
    </script>";
    exit();
}

include __DIR__ . "/../../backend/db_connect.php";

$user_id = $_SESSION["user_id"];
$product_id = $_GET["product_id"] ?? '';
$order_id = $_GET["order_id"] ?? '';

$existing_rating = 0;
$existing_review = "";

// Check if the user has already reviewed this product
if ($product_id) {
    $query = "SELECT rating, review_text FROM reviews WHERE user_id = ? AND product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $product_id);
    $stmt->execute();
    $stmt->bind_result($existing_rating, $existing_review);
    $stmt->fetch();
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Write a Review</title>
    <link rel="stylesheet" href="/BackendWebDev/userstyle/review.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body>
    <div class="review-container">
        <h1>Product Review</h1>

        <form action="../../backend/user/product/submitReview.php" method="POST" class="review-form">
            <input type="hidden" name="order_id" value="<?php echo htmlspecialchars($order_id); ?>">
            <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product_id); ?>">

            <label for="rating">Rating:</label>
            <div class="stars" id="stars">
                <?php for ($i = 1; $i <= 5; $i++): ?>
                <i class="<?php echo ($i <= $existing_rating) ? 'fa-solid' : 'fa-regular'; ?> fa-star"
                    data-value="<?php echo $i; ?>"></i>
                <?php endfor; ?>
                <input type="hidden" name="rating" id="rating" value="<?php echo $existing_rating; ?>" required>
            </div>

            <label for="review">Review:</label>
            <textarea name="review_text" id="review" placeholder="Tell us what you think..." rows="5"
                required><?php echo htmlspecialchars($existing_review); ?></textarea>

            <button type="submit"
                class="submit-btn"><?php echo $existing_rating ? "Update Review" : "Submit Review"; ?></button>
        </form>
    </div>

    <script>
    const stars = document.querySelectorAll('.stars i');
    const ratingInput = document.getElementById('rating');

    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            ratingInput.value = star.dataset.value;
            stars.forEach((s, i) => {
                s.classList.toggle('fa-solid', i <= index);
                s.classList.toggle('fa-regular', i > index);
            });
        });
    });
    </script>
</body>

</html>