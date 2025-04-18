<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    echo "<script>
        alert('Your session has expired or you are not logged in. Please log in again.');
        window.location.href = '../authenticate/LoginPage.php';
    </script>";
    exit();
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
            <input type="hidden" name="order_id" value="<?php echo $_GET['order_id']; ?>">

            <label for="rating">Rating:</label>
            <div class="stars" id="stars">
                <i class="fa-regular fa-star" data-value="1"></i>
                <i class="fa-regular fa-star" data-value="2"></i>
                <i class="fa-regular fa-star" data-value="3"></i>
                <i class="fa-regular fa-star" data-value="4"></i>
                <i class="fa-regular fa-star" data-value="5"></i>
                <input type="hidden" name="rating" id="rating" required>
            </div>

            <label for="review">Review:</label>
            <textarea name="review" id="review" placeholder="Tell us what you think..." rows="5" required></textarea>

            <button type="submit" class="submit-btn">Submit Review</button>
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