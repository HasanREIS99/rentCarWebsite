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
    <title>Promotion List</title>
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
    <h2>Promotion List</h2>
    <table id="shopping-list">
        <tr>
            <th>id</th>
            <th>promotion_name</th>
            <th>description</th>
            <th>start_date</th>
            <th>end_date</th>
            <th>discount_rate</th>
            <th>usage_terms</th>
            <th>is_active</th>
            <th>creation_date</th>
            <th>buttons</th>
        </tr>
        <?php
        require_once 'connection.php';
        $conn = getConnection();
        $sql = "SELECT * FROM promotions";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['ID'] . "</td>";
                echo "<td>" . $row['PromotionName'] . "</td>";
                echo "<td>" . $row['Description'] . "</td>";
                echo "<td>" . $row['StartDate'] . "</td>";
                echo "<td>" . $row['EndDate'] . "</td>";
                echo "<td>" . $row['DiscountRate'] . "</td>";
                echo "<td>" . $row['UsageTerms'] . "</td>";
                echo "<td>" . $row['IsActive'] . "</td>";
                echo "<td>" . $row['CreationDate'] . "</td>";
                echo "<td><button class='delete_button' onclick='deletePromotion(this)'>Delete</button><button class='update_button' onclick='showUpdatePromotionDialog(this)'>Update</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='12'>No promotion found</td></tr>";
        }
        mysqli_close($conn);
        ?>
    </table>
    <button onclick="showAddPromotionDialog()">Add Promotion</button>
</div>

<div id="addPromotionDialog" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddPromotionDialog()">&times;</span>
        <h2>Add Promotion</h2>
        <form id="addPromotionForm">
            <label for="promotion_name">Promotion Name:</label>
            <input type="text" id="promotion_name" name="promotion_name" required><br>

            <label for="description">Description:</label>
            <input type="text" id="description" name="description" required><br>

            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required><br>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required><br>

            <label for="discount_rate">Discount Rate:</label>
            <input type="number" id="discount_rate" name="discount_rate" step="0.01" required><br>

            <label for="usage_terms">Usage Terms:</label>
            <input type="text" id="usage_terms" name="usage_terms" required><br>

            <label for="is_active">Is Active:</label>
            <input type="checkbox" id="is_active" name="is_active"><br>


            <button type="button" onclick="submitAddPromotionForm()">Save</button>
        </form>

    </div>
</div>

<div id="updatePromotionDialog" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeUpdatePromotionDialog()">&times;</span>
        <h2>Update Promotion</h2>
        <form id="updatePromotionForm">
            <input type="hidden" id="update_id" name="id" required>

            <label for="update_promotion_name">Promotion Name:</label>
            <input type="text" id="update_promotion_name" name="promotion_name" required><br>

            <label for="update_description">Description:</label>
            <input type="text" id="update_description" name="description" required><br>

            <label for="update_start_date">Start Date:</label>
            <input type="date" id="update_start_date" name="start_date" required><br>

            <label for="update_end_date">End Date:</label>
            <input type="date" id="update_end_date" name="end_date" required><br>

            <label for="update_discount_rate">Discount Rate:</label>
            <input type="number" id="update_discount_rate" name="discount_rate" step="0.01" required><br>

            <label for="update_usage_terms">Usage Terms:</label>
            <input type="text" id="update_usage_terms" name="usage_terms" required><br>

            <label for="update_is_active">Is Active:</label>
            <input type="checkbox" id="update_is_active" name="is_active"><br>

            <button type="button" onclick="submitUpdatePromotionForm()">Save</button>
        </form>
    </div>
</div>
<footer>
    <p>Haliç University - HBC</p>
</footer>

<script src="script.js"></script>

</body>
</html>
