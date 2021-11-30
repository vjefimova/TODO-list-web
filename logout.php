<?php
session_start();
if (!isset($_SESSION['log'])) {
    header('Location: login.php');
    exit();
}
if(isset($_POST['logout'])){
    session_destroy();
    unset($_SESSION["user"]);
    header('Location: login.php');
    exit();
}
?>