<?php
session_start();

$cookieUser=isset($_COOKIE["user"]);
$cookieRole=isset($_COOKIE["role"]);

$sessionUser=isset($_SESSION["user"]);
$sessionRole = isset($_SESSION["role"]);


?>


<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About</title>

    <link rel="stylesheet" href="about.css" />
</head>
<body>
<header style="background-color: rgba(204, 34, 34, 0.96)">
    <nav class="navbar" style="width: 100%;">
        <ul>
            <div>
                <li><a href="home.php">Home</a></li>
                <?php if((isset($_COOKIE["role"]) && $_COOKIE["role"] == "admin") || (isset($_SESSION["role"]) && $_SESSION["role"] == "admin")):?>
                    <li><a href="manageCars.php">Manage Cars</a></li>
                    <li><a href="managePromotions.php">Manage Promotions</a></li>
                <?php else:?>
                    <li><a href="cars.php">Cars</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                <?php endif;?>
            </div>

            <?php  if($sessionUser || $cookieUser): ?>
                <li >
                    <button onclick="logout()" class="logout_button" type="submit"
                            name="logout" value="logout" >Log out</button>
                </li>
            <?php endif;?>
        </ul>

    </nav>
</header>

<section class="about">
    <div class="about-section">
        <div class="image-container">
            <img src="../assets/img.png" alt="about_image" />
        </div>
        <div class="text-container">
            <h2>About Us</h2>
            <p style="width: 92%" >
                “May your path always be clear and safe...” As HBC Rent Company, we aim to be among the leading brands in the fleet leasing
                sector with our strong capital structure and experienced team in corporate fleet management, always prioritizing your
                satisfaction. By adopting the principles of boutique service, customer satisfaction and honest work, HBC Rent Company, with
                20 years of experience, provides guaranteed and 24/7 uninterrupted service to its customers nationwide.
            </p>
        </div>
    </div>
</section>

<footer>
    <p>Haliç University - HBC</p>
</footer>
<script src="script.js"></script>
</body>
</html>
