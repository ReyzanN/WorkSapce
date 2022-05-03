<?php
session_start();
if (!isset($_SESSION['email'])){
    header('Location: index.php');
    exit();
}

if (isset($_REQUEST['param'])){
    $param = $_REQUEST['param'];
    include ('Control/account_control.php');
}
?>