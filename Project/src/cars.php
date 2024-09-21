<?php
session_start();

$cookieUser=isset($_COOKIE["user"]);
$cookieRole=isset($_COOKIE["role"]);

$sessionUser=isset($_SESSION["user"]);
$sessionRole = isset($_SESSION["role"]);

if($cookieUser && !$sessionUser){
    $currentUser = $cookieUser ;
} else if(!$cookieUser && $sessionUser){
    $currentUser = $sessionUser ;
} else {
    $currentUser = null;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rented Vehicles</title>
    <link rel="stylesheet" href="cars.css">
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
<div class="container">
    <?php
    require_once 'connection.php';
    $conn = getConnection();

    $sql = "SELECT * FROM vehicles";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo '<div class="car-container">';
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<div class="car" data-price="' . $row["Price"] . '">';
            echo '<img src="' . $row["ImagePath"] . '" alt="' . $row["Brand"] . ' ' . $row["Model"] . '"/>';
            echo '<h3>' . $row["Brand"] . ' ' . $row["Model"] . '</h3>';
            echo '<p>Price: ' . $row["Price"] . ' TL/Day</p>';
            echo '<ul>';
            $features = explode(',', $row["ExtraFeatures"]);
            foreach ($features as $feature) {
                echo '<li>' . trim($feature) . '</li>';
            }
            echo '</ul>';
            echo '<button class="btn" onclick="showRentCarDialog(\'' . $row["ID"] . '\', \'' . $row["Brand"] . ' ' . $row["Model"] . '\', ' . $row["Price"] . ', \'' . $currentUser . '\');">Rent</button>';

            echo '</div>';
        }
        echo '</div>';
    } else {
        echo "0 results";
    }


    $promotions = [];
    $sqlPromotions = "SELECT * FROM promotions";
    $resultPromotions = mysqli_query($conn, $sqlPromotions);

    if (mysqli_num_rows($resultPromotions) > 0) {
        while ($row = mysqli_fetch_assoc($resultPromotions)) {
            $promotions[] = $row;
        }
    }

    mysqli_close($conn);
    ?>
</div>
<div class="modal" id="rentCarDialog">
    <div class="modal-content">
        <span class="close" onclick="closeRentCarDialog()">&times;</span>
        <h2 id="rentalHeading">Rent Vehicle</h2>
        <form id="rentalForm" action="" method="post" onsubmit="event.preventDefault(); submitAddRentForm();">

            <label for="vehicleName">Vehicle:</label>
            <input type="text" id="vehicleName" name="vehicleName" readonly><br><br>

            <input type="hidden" id="vehicleID" name="vehicleID">

            <input type="hidden" id="vehiclePrice" name="vehiclePrice">

            <label for="rentalDateTime">Rental Date:</label>
            <input type="date" id="rentalDateTime" name="rentalDateTime" required><br><br>

            <label for="returnDateTime">Return Date:</label>
            <input type="date" id="returnDateTime" name="returnDateTime" required><br><br>

            <label for="paymentAmount">Payment Amount:</label>
            <input type="text" id="paymentAmount" name="paymentAmount" readonly><br><br>

            <label for="promotions">Promotions:</label>
            <select id="promotions" name="promotionID">
                <option value="0" data-discount="0" title="No Discount">No Discount</option>
                <?php foreach ($promotions as $promotion): ?>
                    <option value="<?= $promotion['ID'] ?>" data-discount="<?= $promotion['DiscountRate'] ?>" title="<?= $promotion['Description'] ?>">
                        <?= $promotion['PromotionName'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span style="cursor: pointer" class="info-icon" id="infoIcon" title="Click for Promotion Info">&#9432;</span>
            <input type="hidden" id="selectedPromotionID" name="selectedPromotionID">
            <br><br>

            <input class="btn" type="submit" value="Rent">
        </form>
    </div>
</div>
<footer>
    <p>Haliç University - HBC</p>
</footer>

<script src="script.js"></script>
<script>
    document.getElementById("rentalDateTime").addEventListener("change", updatePaymentAmount);
    document.getElementById("returnDateTime").addEventListener("change", updatePaymentAmount);
    document.getElementById("promotions").addEventListener("change", function() {
        updatePromotionTooltip();
        updatePaymentAmount();
    });
    updatePromotionTooltip();
</script>
</body>
</html>
