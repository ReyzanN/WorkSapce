<?php
/*
 * Copyright (c) 2022. -- Reyzan [ Gaétan S.CH ]
 */
require_once ('Core/MainCore.php');
$Core = MainCore::Main_ConnectDB();
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
            header('Location: index.php');
            exit();
        }

        case 'WorkSpace':{
            $MemberTest = $Core->IsMemberOfWorkSpace($_REQUEST['WorkSpaceAccess'],$_SESSION['email']);
            if ($MemberTest){
                $InfoUsers = $Core->GetInfoAccount($_SESSION['email']);
                $InfoWorkSpace = $Core->GetNameWorkSpace($_REQUEST['WorkSpaceAccess']);
                $HeaderMessage = $Core->GetHeaderMessageForWorkSpace($_REQUEST['WorkSpaceAccess']);
                $PermissionUsers = $Core->GetPermissionForUsers($_REQUEST['WorkSpaceAccess'], $_SESSION['email']);
                include ("pages/workspace-header.php");
                include ("pages/workspace-sidebar.php");
                include ("pages/workspace-body.php");
                include ("pages/workspace-footer.php");
            }
            else{
                header('Location: account.php?param=default');
            }
            break;
        }

        case 'WorkSpaceEditHeaderMessage':{
            $MemberTest = $Core->IsMemberOfWorkSpace($_REQUEST['WorkSpaceAccess'],$_SESSION['email']);
            $PermissionUsers = $Core->GetPermissionForUsers($_REQUEST['WorkSpaceAccess'], $_SESSION['email']);
            if ($MemberTest){
                if ($PermissionUsers[3]) {
                    $Message = $_POST['messageHeader'];
                    $IdWorkSpace = $_REQUEST['WorkSpaceAccess'];
                    $Core->EditHeaderMessageWorkSpace($IdWorkSpace, $Message);
                    header('Location: account.php?param=WorkSpace&WorkSpaceAccess=' . $IdWorkSpace);
                }
            }
            else{
                header('Location: account.php?param=default');
            }
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