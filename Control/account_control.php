<?php
/*
 * Copyright (c) 2022. -- Reyzan [ Gaétan S.CH ]
 */
require_once ('Core/MainCore.php');
$Core = MainCore::Main_ConnectDB();
session_start();
if (!isset($_SESSION['email'])){
    header('Location: index.php');
    exit();
}
if (isset($_REQUEST['param'])){
    $param = $_REQUEST['param'];

    switch ($param){

        case 'UsersDisconnect':{
            $Core->Main_DisconnectUsers();
            echo '<meta http-equiv="refresh" content="0">';
            header('Location: ../index.php');
            exit();
        }

        case 'WorkSpace':{
            include ("pages/workspace-main.php");
            break;
        }

        default:{
            $headerAccount = 'pages/header-account.php';
            $sideBarAccount = 'pages/sidebar-account.php';
            $footerAccount = 'pages/footer-account.php';
            $InfoUsers = $Core->GetInfoAccount($_SESSION['email']);
            $InfoWorkSpaceUsers = $Core->GetInfoWorkSpaceForMembers($_SESSION['email']);
            $JoinRequest = $Core->GetInvitationAll($_SESSION['email']);
            $CountPending = $Core->GetCountPendingJoinRequest($_SESSION['email']);
            $NumbersWorkSpace = $Core->GetNumbersWorkSpaceForMembers($_SESSION['email']);
            $InfoNumbersUsers = $Core->GetNumbersMembersAll();
            include($headerAccount);
            include($sideBarAccount);
            include ("pages/body-account.php");
            include ($footerAccount);
            break;
        }
    }
}