<?php
session_start();
if (!isset($_SESSION['email'])){
    header('Location: index.php');
    exit();
}

// Patch Erreur Missing Header info Account
include ('Core/MainCore.php');
$Core = MainCore::Main_ConnectDB();

$headerAccount = 'pages/header-account.php';
$sideBarAccount = 'pages/sidebar-account.php';
$footerAccount = 'pages/footer-account.php';

$InfoUsers = $Core->GetInfoAccount($_SESSION['email']);
$InfoWorkSpaceUsers = $Core->GetInfoWorkSpaceForMembers($_SESSION['email']);
$JoinRequest = $Core->GetInvitationPendingAndRefused($_SESSION['email']);
include($headerAccount);
include($sideBarAccount);
if (isset($_REQUEST['param'])){
    $param = $_REQUEST['param'];
    include ('Control/account_control.php');
}
include ($footerAccount);
?>