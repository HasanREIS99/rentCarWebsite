<?php
if (isset($_COOKIE["role"]) && $_COOKIE["role"] == "user") {
    header("Location: home.php");
    exit();
}

echo "admin page";

?>



