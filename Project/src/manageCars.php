<?php
session_start();

$cookieUser=isset($_COOKIE["user"]);
$cookieRole=isset($_COOKIE["role"]);

$sessionUser=isset($_SESSION["user"]);
$sessionRole = isset($_SESSION["role"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle List</title>
    <link rel="stylesheet" href="manageCarsStyle.css"/>
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
    <h2>Vehicle List</h2>
    <table id="shopping-list">
        <tr>
            <th>id</th>
            <th>brand</th>
            <th>model</th>
            <th>year</th>
            <th>color</th>
            <th>mileage</th>
            <th>fuel_type</th>
            <th>transmission_type</th>
            <th>engine_capacity</th>
            <th>price</th>
            <th>sale_status</th>
            <th>extra_features</th>
            <th>image_path</th>
            <th>buttons</th>
        </tr>
        <?php
        require_once 'connection.php';
        $conn = getConnection();
        $sql = "SELECT * FROM vehicles";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['ID'] . "</td>";
                echo "<td>" . $row['Brand'] . "</td>";
                echo "<td>" . $row['Model'] . "</td>";
                echo "<td>" . $row['Year'] . "</td>";
                echo "<td>" . $row['Color'] . "</td>";
                echo "<td>" . $row['Mileage'] . "</td>";
                echo "<td>" . $row['FuelType'] . "</td>";
                echo "<td>" . $row['TransmissionType'] . "</td>";
                echo "<td>" . $row['EngineCapacity'] . "</td>";
                echo "<td>" . $row['Price'] . "</td>";
                echo "<td>" . $row['SaleStatus'] . "</td>";
                echo "<td>" . $row['ExtraFeatures'] . "</td>";
                echo "<td><img src='" . $row['ImagePath'] . "' alt='Vehicle Image' width='100' height='100'></td>";
                echo "<td><button class='delete_button' onclick='deleteRow(this)'>Delete</button><button class='update_button' onclick='showUpdateCarDialog(this)'>Update</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='12'>No vehicles found</td></tr>";
        }
        mysqli_close($conn);
        ?>
    </table>
    <button onclick="showAddCarDialog()">Add Car</button>
</div>

<div id="addCarDialog" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddCarDialog()">&times;</span>
        <h2>Add Car</h2>
        <form id="addCarForm">
            <label for="brand">Brand:</label>
            <input type="text" id="brand" name="brand" required><br>
            <label for="model">Model:</label>
            <input type="text" id="model" name="model" required><br>
            <label for="year">Year:</label>
            <input type="number" id="year" name="year" required><br>
            <label for="color">Color:</label>
            <input type="text" id="color" name="color" required><br>
            <label for="mileage">Mileage:</label>
            <input type="number" id="mileage" name="mileage" required><br>
            <label for="fuel_type">Fuel Type:</label>
            <input type="text" id="fuel_type" name="fuel_type" required><br>
            <label for="transmission_type">Transmission Type:</label>
            <input type="text" id="transmission_type" name="transmission_type" required><br>
            <label for="engine_capacity">Engine Capacity:</label>
            <input type="number" id="engine_capacity" name="engine_capacity" required><br>
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required><br>
            <label for="sale_status">Sale Status:</label>
            <input type="text" id="sale_status" name="sale_status" required><br>
            <label for="extra_features">Extra Features:</label>
            <input type="text" id="extra_features" name="extra_features" required><br>
            <label for="image">Upload Image:</label>
            <input type="file" id="image" name="image" required><br><br>
            <button type="button" onclick="submitAddCarForm()">Save</button>
        </form>
    </div>
</div>


<div id="updateCarDialog" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeUpdateCarDialog()">&times;</span>
        <h2>Update Car</h2>
        <form id="updateCarForm">
            <input type="hidden" id="update_id" name="id" required>
            <label for="update_brand">Brand:</label>
            <input type="text" id="update_brand" name="brand" required><br>
            <label for="update_model">Model:</label>
            <input type="text" id="update_model" name="model" required><br>
            <label for="update_year">Year:</label>
            <input type="number" id="update_year" name="year" required><br>
            <label for="update_color">Color:</label>
            <input type="text" id="update_color" name="color" required><br>
            <label for="update_mileage">Mileage:</label>
            <input type="number" id="update_mileage" name="mileage" required><br>
            <label for="update_fuel_type">Fuel Type:</label>
            <input type="text" id="update_fuel_type" name="fuel_type" required><br>
            <label for="update_transmission_type">Transmission Type:</label>
            <input type="text" id="update_transmission_type" name="transmission_type" required><br>
            <label for="update_engine_capacity">Engine Capacity:</label>
            <input type="number" id="update_engine_capacity" name="engine_capacity" required><br>
            <label for="update_price">Price:</label>
            <input type="number" id="update_price" name="price" required><br>
            <label for="update_sale_status">Sale Status:</label>
            <input type="text" id="update_sale_status" name="sale_status" required><br>
            <label for="update_extra_features">Extra Features:</label>
            <input type="text" id="update_extra_features" name="extra_features" required><br>

            <button type="button" onclick="submitUpdateCarForm();">Save</button>
        </form>
    </div>
</div>

<footer>
    <p>Haliç University - HBC</p>
</footer>
<script src="script.js"></script>
</body>
</html>
