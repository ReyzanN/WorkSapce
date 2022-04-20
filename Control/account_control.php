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

        default:{
            $NumbersWorkSpace = $Core->GetNumbersWorkSpaceForMembers($_SESSION['email']);
            $InfoNumbersUsers = $Core->GetNumbersMembersAll();
            include ("pages/body-account.php");
            break;
        }
    }
}