<?php
session_start();

$cookieUser=isset($_COOKIE["user"]);
$cookieRole=isset($_COOKIE["role"]);
$cookieUserID=isset($_COOKIE["id"]);

$sessionUser=isset($_SESSION["user"]);
$sessionRole = isset($_SESSION["role"]);
$sessionUserID= isset($_SESSION["id"]);


if ($cookieUserID && !$sessionUserID) {
    $currentUserID = $_COOKIE["id"];
} else if (!$cookieUserID && $sessionUserID) {
    $currentUserID = $_SESSION["id"];
} else {
    $currentUserID= null;
}


if(isset($_GET["error"])){
    echo "<script>window.alert('This email is already taken!');</script>";
}

if(isset($_GET["errorEmail"])){
    echo "<script>window.alert('Email address not found!');</script>";
}
if(isset($_GET["errorPassword"])){
    echo "<script>window.alert('Password is mistake!');</script>";
}


if(isset($_COOKIE["user"]) || isset($_SESSION["user"])){
    echo "<script>document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#formContainer').style.display = 'none';
    });</script>";
}



if ((isset($_COOKIE["role"]) && $_COOKIE["role"] == "admin") || (isset($_SESSION["role"]) && $_SESSION["role"] == "user")) {
    // header("Location: admin.php");
    //exit();
    echo "<script>document.addEventListener('DOMContentLoaded', function() {
        document.querySelector('#addCar').style.display = 'none';
    });</script>";
}




?>

<!DOCTYPE html>

<html lang="tr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>HBC RENT A CAR</title>
    <link rel="stylesheet" href="style.css" />

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
<section class="hero">
    <video autoplay muted loop id="background-video">
        <source src="../assets/background.mp4" type="video/mp4" />
        Your browser does not support the video tag.
    </video>
    <div class="overlay">
        <h1 class="fade-in find_car">Find Your Perfect Car</h1>
        <h3 class="fade-in rent_car_text">Rent a car for your next adventure.</h3>
        <h1 class="fade-in hbc_rent">HBC RENT A CAR</h1>
        <h3 class="fade-in">
            <p class="hbc_inc">HBC Inc. Established in 2024 - Available 24/7 with Our Entire Fleet</p>
        </h3>
    </div>


    <div class="form-container fade-in"  id="formContainer">
        <div class="form-content" id="loginForm">
            <h2 class="loginAndRegister_text">Login</h2>
            <form action="login.php" method="post">
                <div class="form-group">
                    <label for="loginEmail">Email:</label>
                   <input type="email" id="loginEmail" name="email" required>
                </div>
                <div class="form-group">
                    <label for="loginPassword">Password:</label>
                    <input type="password" id="loginPassword" name="password" required>
                </div>
                <div  style=" display: flex; justify-content: flex-start; align-items: center;gap:5px;">
                    <label for="remember">Remember Me</label>
                    <input type="checkbox" id="remember" name="remember" style="margin-bottom: 10px">

                </div>
                <div class="form-group">
                    <button type="submit">Login</button>
                </div>
            </form>
            <div class="form-toggle">
                <button id="showSignupForm">Don't have an account? Sign Up</button>
            </div>
        </div>

        <div class="form-content" id="signupForm" style="display:none;">
            <h2 class="loginAndRegister_text">Sign Up</h2>
            <form action="register.php" method="post">
                <div class="form-group">
                    <label for="signupFullName">Full Name:</label>
                    <input type="text" id="signupFullName" name="full_name" required>
                </div>
                <div class="form-group">
                    <label for="signupEmail">Email:</label>
                    <input type="email" id="signupEmail" name="email" required>
                </div>
                <div class="form-group">
                    <label for="signupPassword">Password:</label>
                    <input type="password" id="signupPassword" name="password" required>
                </div>
                <div class="form-group">
                    <label for="signupPhone">Phone:</label>
                    <input type="tel" id="signupPhone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="signupGender">Gender:</label>
                    <select id="signupGender" name="gender" required>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="signupDob">Date of Birth:</label>
                    <input type="date" id="signupDob" name="date_of_birth" required>
                </div>
                <div class="form-group">
                    <label for="signupAddress">Address:</label>
                    <input type="text" id="signupAddress" name="address" required>
                </div>
                <div class="form-group">
                    <button type="submit">Sign Up</button>
                </div>
            </form>
            <div class="form-toggle">
                <button id="showLoginForm">Already have an account? Login</button>
            </div>
        </div>
    </div>

    <?php if((isset($_COOKIE["role"]) && $_COOKIE["role"] == "user") || (isset($_SESSION["role"]) && $_SESSION["role"] == "user")):?>


    <div class="container fade-in" >

        <table id="shopping-list"  style="width: 100%;">
            <caption style="color: black; font-size: 1.4rem; font-weight: bold">Rented Vehicles</caption>
            <tr>
                <td style="font-weight: 800">Brand</td>
                <td style="font-weight: 800">Model</td>
                <td style="font-weight: 800">Rental Date</td>
                <td style="font-weight: 800">Return Date</td>
                <td style="font-weight: 800">Price</td>
                <td style="font-weight: 800">Image</td>
            </tr>
            <?php
            require_once 'connection.php';
            $conn = getConnection();
            $sql = "SELECT * FROM rentals";

            $sql = "SELECT Brand, Model, RentalDateTime, ReturnDateTime,PaymentAmount, ImagePath
            FROM vehicles as v INNER JOIN rentals as r ON v.ID = r.VehicleID 
            INNER JOIN users as u ON u.id = r.UserID where u.ID = '".$currentUserID."'";


            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";

                    echo "<td>" . $row['Brand'] . "</td>";
                    echo "<td>" . $row['Model'] . "</td>";
                    echo "<td>" . $row['RentalDateTime'] . "</td>";
                    echo "<td>" . $row['ReturnDateTime'] . "</td>";
                    echo "<td>" . $row['PaymentAmount'] . "</td>";
                    echo "<td><img src='" . $row['ImagePath'] . "' alt='Vehicle Image' width='100' height='100'></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='12'>No vehicles found</td></tr>";
            }
            mysqli_close($conn);
            ?>
        </table>

    </div>
    <?php endif?>

</section>

<footer>
    <p>Haliç University - HBC</p>
</footer>

<script src="script.js"></script>
</body>
</html>

