<?php
require_once 'connection.php';
$conn = getConnection();


$message = "This email is already taken!";

if(isset($_POST["full_name"]) AND isset($_POST["email"]) AND isset($_POST["password"])
    AND isset($_POST["phone"]) AND isset($_POST["gender"])
    AND isset($_POST["date_of_birth"]) AND isset($_POST["address"])){


    $sql = "SELECT *  FROM users WHERE `email` LIKE '".$_POST["email"]."';";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result)  == 0) {
        $hashedPassword = password_hash($_POST["password"], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (`full_name`, `email`, `password`, `phone`, `gender`, `date_of_birth` 
,`address`,`created_time`)
VALUES ('".$_POST["full_name"]."', '".$_POST["email"]."','".$hashedPassword."',
'".$_POST["phone"]."','".$_POST["gender"]."','".$_POST["date_of_birth"]."',
'".$_POST["address"]."',current_timestamp())";
        echo "oldu";
        mysqli_query($conn, $sql);

        header("Location: home.php");
        exit();

    } else {
        header("Location: home.php?error=email_taken");
        exit();
    }

}

mysqli_close($conn);


?>

