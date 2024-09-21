<?php
session_start();
require_once 'connection.php';
$conn = getConnection();


$email = $_POST['email'];
$password = $_POST['password'];



if( isset($email) AND isset($password)) {
$sql = "SELECT * FROM users WHERE `email`= '".$_POST["email"]."'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {

    while($row = mysqli_fetch_assoc($result)) {

        if (password_verify($password, $row["password"])) {
            $role = $row["role"];
            $id = $row["id"];

           if($row["role"] == "admin")
            {
                getCookie("home",$role,  $id);
                exit;
            } else {
                getCookie("home",$role, $id);
            }
        } else {
            header("Location: home.php?errorPassword=wrong_password");
            exit();
        }
    }

    } else {
    header("Location: home.php?errorEmail=email_taken");
    exit();
}

}
mysqli_close($conn);

function getCookie($location, $role, $id) {
    global $email;


    if (isset($_POST["remember"])) {

        $cookie_email_value = $email;
        $cookie_role_value = $role;

        setcookie("user",$cookie_email_value, time() + (3600), "/");
        setcookie("id",$id, time() + (3600), "/");

        setcookie("role", $cookie_role_value, time() + (3600), "/");
        echo "Cookie/Session will be activate";
        header("Location: ".$location.".php");
        die();
    } else {

        $_SESSION["user"] = $email;
        $_SESSION["role"] = $role;
        $_SESSION["id"] = $id;


        header("Location: " . $location . ".php");
        exit();
    }
}

?>
