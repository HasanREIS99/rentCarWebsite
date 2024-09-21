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
    <title>Contact</title>
    <link rel="stylesheet" href="contact.css" />
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

<h2>Contact</h2>
<h3>Founder :Hasan Can Cörüt, Ali Batuhan Ak, Yaşar Cem Durak</h3>
<h3>Tel: 0212 257 01 01</h3>
<h3>Gmail: info@gmail.com</h3>

<footer>
    <p>Haliç University - HBC</p>
</footer>
<script src="script.js"></script>
</body>
</html>

