<?php
session_start();
session_unset();
session_destroy();
setcookie("user", "", time() - 3600, "/");
setcookie("role", "", time() - 3600, "/");
setcookie("id", "", time() - 3600, "/");
header("Location: home.php");
exit();
?>
