<?php
session_start();

// If user is already logged in, redirect to main
if (isset($_SESSION["user_id"])) {
    echo "<script>
        alert('Logout first to access this page.');
        window.location.href = 'MainPage.php';
    </script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/style/register.css">
 
    <link rel="stylesheet" href="/BackendWebDev/style/register.css">
    <link rel="stylesheet" href="/BackendWebDev/style/transition.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <script src="/BackendWebDev/script/transition.js"></script>
     
    <title>Eternal Elegant Bridal - Register</title>
</head>

<body>
    <header>
        <h1>Eternal Elegant Bridal</h1>
    </header>
    <section>
        <h1>Register</h1>
        <p style="color:#808080">Create your account to get started</p>

        <form action="/backend/register.php" method="POST">
            <div class="form-group">
                <div class="input-box">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" placeholder="Enter your First Name" required>
                </div>
                <div class="input-box">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" placeholder="Enter your Last Name" required>
                </div>
            </div>

            <div class="form-group">
                <div class="input-box">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Enter your Email" required>
                </div>
                <div class="input-box">
                    <label for="phone">Phone Number</label>
                    <div style="display: flex;">
                        <select id="country_code" name="country_code" required>
                            <option value="+60" selected>🇲🇾 +60</option>
                            <option value="+1">🇺🇸 +1</option>
                            <option value="+44">🇬🇧 +44</option>
                            <option value="+91">🇮🇳 +91</option>
                            <option value="+81">🇯🇵 +81</option>
                            <option value="+86">🇨🇳 +86</option>
                            <option value="+65">🇸🇬 +65</option>
                            <option value="+62">🇮🇩 +62</option>
                        </select>
                        <input type="tel" id="phone" name="phone_number" placeholder="Enter Phone Number" required
                            pattern="[0-9]{6,15}">
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="input-box">
                    <label for="address">Address</label>
                    <input type="text" id="address" name="address" placeholder="Enter your Address" required>
                </div>
                <div class="input-box">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your Password" required>
                </div>
            </div>

            <div class="form-group">
                <div class="input-box">
                    <label for="safe_key_question">Safe Key Question</label>
                    <select id="safe_key_question" name="safe_key_question" required>
                        <option value="pet_name">What is your first pet's name?</option>
                        <option value="mother_birth">What is your mother's birthdate?</option>
                        <option value="favorite_teacher">Who was your favorite teacher?</option>
                    </select>
                </div>
                <div class="input-box">
                    <label for="safe_key_answer">Safe Key Answer</label>
                    <input type="text" id="safe_key_answer" name="safe_key_answer" placeholder="Enter your answer"
                        required>
                </div>
            </div>

            <button type="submit">Register</button>
            <button type="button" onclick="window.location.href='login.php'">Sign In</button>
        </form>
    </section>
</body>


</html>