<?php
session_start();
if (!isset($_SESSION['email'])){
    header('Location: index.php');
}
require_once ('Core/MainCore.php');

$Core = MainCore::Main_ConnectDB();

$headerAccount = 'pages/header-account.php';
$sideBarAccount = 'pages/sidebar-account.php';
$bodyDefaultAccount = 'pages/body-account.php';
$footerAccount = 'pages/footer-account.php';

$InfoUsers = $Core->GetInfoAccount($_SESSION['email']);
$NumbersWorkSpace = $Core->GetNumbersWorkSpaceForMembers($_SESSION['email']);
$InfoWorkSpaceUsers = $Core->GetInfoWorkSpaceForMembers($_SESSION['email']);
include($headerAccount);
include($sideBarAccount);
if (isset($_REQUEST['page'])){
    $page = $_REQUEST['page'];
    include ('pages/'.$page.'.php');
}
else {
    include($bodyDefaultAccount);
}
include ($footerAccount);
?>