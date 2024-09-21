<?php
function logout() {
    session_start();
    session_unset();
    session_destroy();
    setcookie("user", "", time() - 3600, "/");
    setcookie("role", "", time() - 3600, "/");
    setcookie("id", "", time() - 3600, "/");
    header("Location: home.php");
    exit();
}

if (isset($_POST['action']) && $_POST['action'] == 'logout') {
    logout();
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] == 'logout') {
            logout();
        }  elseif ($_POST['action'] == 'updateVehicle') {
            updateVehicle($_POST);
        } elseif ($_POST['action'] == 'addPromotion') {
            addPromotion($_POST);
        } elseif ($_POST['action'] == 'updatePromotion') {
            updatePromotion($_POST);
        } elseif ($_POST['action'] == 'addVehicle') {
            addVehicle($_POST, $_FILES);
        } elseif ($_POST['action'] == 'rentCar') {
            rentCar($_POST);
        }
    }
}


/*MANAGE CARS*/
function addVehicle($data, $file) {

    require_once 'connection.php';
    $conn = getConnection();

    $brand = $data['brand'];
    $model = $data['model'];
    $year = $data['year'];
    $color = $data['color'];
    $mileage = $data['mileage'];
    $fuel_type = $data['fuel_type'];
    $transmission_type = $data['transmission_type'];
    $engine_capacity = $data['engine_capacity'];
    $price = $data['price'];
    $sale_status = $data['sale_status'];
    $extra_features = $data['extra_features'];

    $target_dir = "uploads/";
    $target_file = $target_dir . basename($file["image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));


    $check = getimagesize($file["image"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }


    if ($file["image"]["size"] > 500000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }


    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }


    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";

    } else {
        if (move_uploaded_file($file["image"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($file["image"]["name"])) . " has been uploaded.";

            $sql = "INSERT INTO vehicles (Brand, Model, Year, Color, Mileage, FuelType, TransmissionType, EngineCapacity, Price, SaleStatus, ExtraFeatures, ImagePath )
            VALUES ('$brand', '$model', '$year', '$color', '$mileage', '$fuel_type', '$transmission_type', '$engine_capacity', '$price', '$sale_status', '$extra_features', '$target_file')";

            if (mysqli_query($conn, $sql)) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }


        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    mysqli_close($conn);
}
function deleteVehicle($id)
{
    require_once 'connection.php';
    $conn = getConnection();
    $sql = "DELETE FROM vehicles WHERE id=" . $id;

    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    return "success";
}

if (isset($_POST['action']) && $_POST['action'] == 'deleteVehicle' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    deleteVehicle($id);
}

function updateVehicle($data)
{
    require_once 'connection.php';
    $conn = getConnection();


    $id = $data['id'];
    $brand = $data['brand'];
    $model = $data['model'];
    $year = $data['year'];
    $color = $data['color'];
    $mileage = $data['mileage'];
    $fuel_type = $data['fuel_type'];
    $transmission_type = $data['transmission_type'];
    $engine_capacity = $data['engine_capacity'];
    $price = $data['price'];
    $sale_status = $data['sale_status'];
    $extra_features = $data['extra_features'];

    $sql = "UPDATE vehicles SET 
            Brand='$brand', Model='$model', Year='$year', Color='$color', Mileage='$mileage',
            FuelType='$fuel_type', TransmissionType='$transmission_type', EngineCapacity='$engine_capacity',
            Price='$price', SaleStatus='$sale_status', ExtraFeatures='$extra_features'
            WHERE ID='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "Record updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}



/*MANAGE PROMOTIONS*/

function addPromotion($data) {
    require_once 'connection.php';
    $conn = getConnection();


    $promotion_name = $data['promotion_name'];
    $description = $data['description'];
    $start_date = $data['start_date'];
    $end_date = $data['end_date'];
    $discount_rate = $data['discount_rate'];
    $usage_terms = $data['usage_terms'];
    $is_active =  isset($data['is_active']) ? 1 : 0;


    $sql = "INSERT INTO promotions (PromotionName, Description, StartDate, EndDate, DiscountRate, UsageTerms, IsActive)
            VALUES ('$promotion_name', '$description', '$start_date', '$end_date', '$discount_rate', '$usage_terms', '$is_active')";

    if (mysqli_query($conn, $sql)) {
        echo "New promotion created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}


function updatePromotion($data)
{
    require_once 'connection.php';
    $conn = getConnection();

    $id = $data['id'];
    $promotion_name = $data['promotion_name'];
    $description = $data['description'];
    $start_date = $data['start_date'];
    $end_date = $data['end_date'];
    $discount_rate = $data['discount_rate'];
    $usage_terms = $data['usage_terms'];
    $is_active = isset($data['is_active']) && $data['is_active'] ? 1 : 0;


    $sql = "UPDATE promotions SET 
            PromotionName='$promotion_name', Description='$description', StartDate='$start_date', EndDate='$end_date', 
            DiscountRate='$discount_rate', UsageTerms='$usage_terms', IsActive='$is_active'
            WHERE ID='$id'";

    if (mysqli_query($conn, $sql)) {
        echo "Promotion updated successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}

function deletePromotion($id)
{
    require_once 'connection.php';
    $conn = getConnection();
    $sql = "DELETE FROM promotions WHERE id=" . $id;

    if (mysqli_query($conn, $sql)) {
        echo "Record deleted successfully";
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    return "success";
}

if (isset($_POST['action']) && $_POST['action'] == 'deletePromotion' && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    deletePromotion($id);
}

/*CARS*/
function rentCar($data) {
    require_once 'connection.php';
    $conn = getConnection();
    session_start();
    $cookieID = isset($_COOKIE["id"]) ? $_COOKIE["id"] : null;
    $sessionID = isset($_SESSION["id"]) ? $_SESSION["id"] : null;

    if($cookieID && !$sessionID){
        $userId = $cookieID ;
    } else {
        $userId = $sessionID ;
    }

    $vehicleId = $data["vehicleID"];
    $rentalDateTime = $data['rentalDateTime'];
    $returnDateTime = $data['returnDateTime'];
    $paymentAmount = $data['paymentAmount'];


    $promotionId = isset($data['promotionID']) && !empty($data['promotionID']) ? $data['promotionID'] : NULL;


    $sql = "INSERT INTO rentals (UserID, VehicleID, RentalDateTime, ReturnDateTime, PaymentAmount, UsedPromotionID)
            VALUES ('$userId', '$vehicleId', '$rentalDateTime', '$returnDateTime', '$paymentAmount', ";


    if ($promotionId) {
        $sql .= "'$promotionId')";
    } else {
        $sql .= "NULL)";
    }

    if (mysqli_query($conn, $sql)) {
        echo "Success";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    mysqli_close($conn);
}

?>
