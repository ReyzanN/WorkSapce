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
                $OperatorList = $Core->WorkSpaceCountOperator($_REQUEST['WorkSpaceAccess'], $_SESSION['email']);
                $RessourcesList = $Core->GetAllRessourceForWorkSpace($_REQUEST['WorkSpaceAccess']);
                if ($PermissionUsers[1]){
                    $MembersToInvite = $Core->GetNoMembersForInvitation($_REQUEST['WorkSpaceAccess']);
                }
                if ($PermissionUsers[3]){
                    $MembersToKick = $Core->GetAllMembersForWorkSpace($_REQUEST['WorkSpaceAccess']);
                }
                if ($PermissionUsers[6]){
                    $TeatcherList = $Core->GetAllTeatcherFroWorkSpace($_REQUEST['WorkSpaceAccess']);
                }
                if ($PermissionUsers[9]){
                    $DisciplineList = $Core->GetAllDiscipline($_REQUEST['WorkSpaceAccess']);
                }
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
            if ($MemberTest){
                $PermissionUsers = $Core->GetPermissionForUsers($_REQUEST['WorkSpaceAccess'], $_SESSION['email']);
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

        case 'WorkSpaceInvitationSend':{
            $MemberTest = $Core->IsMemberOfWorkSpace($_REQUEST['WorkSpaceAccess'],$_SESSION['email']);
            if ($MemberTest){
                $PermissionUsers = $Core->GetPermissionForUsers($_REQUEST['WorkSpaceAccess'], $_SESSION['email']);
                if ($PermissionUsers[1]){
                    $IdWorkSpace = $_REQUEST['WorkSpaceAccess'];
                    $IdUserToInvite = $_POST['MembersToInviteId'];
                    $Core->SendInvitationToUser($IdWorkSpace,$_SESSION['email'],$IdUserToInvite);

                }
                header('Location: account.php?param=WorkSpace&WorkSpaceAccess=' . $IdWorkSpace);
            }
            break;
        }

        case 'WorkSpaceKickUser':{
            $MemberTest = $Core->IsMemberOfWorkSpace($_REQUEST['WorkSpaceAccess'],$_SESSION['email']);
            if ($MemberTest){
                $PermissionUsers = $Core->GetPermissionForUsers($_REQUEST['WorkSpaceAccess'], $_SESSION['email']);
                if ($PermissionUsers[3]){
                    $IdToKick = $_REQUEST['KickPerson'];
                    $WorkSpace = $_REQUEST['WorkSpaceAccess'];
                    $Core->KickUserFromWorkSpace($_REQUEST['WorkSpaceAccess'],$IdToKick);
                    header('Location: account.php?param=WorkSpace&WorkSpaceAccess=' . $IdWorkSpace);
                }
            }
            break;
        }

        case 'AcceptWorkSpaceInvitation':{
            $IdWorkSpace = $_REQUEST['WorkSpaceId'];
            $IdInvitation = $_REQUEST['IdInvitation'];
            $Core->AcceptInvitationForWorkSpace($_SESSION['email'],$IdWorkSpace,$IdInvitation);
            header('Location: account.php?param=default');
            break;
        }

        case 'DeniedWorkSpaceInvitation': {
            $IdWorkSpace = $_REQUEST['WorkSpaceId'];
            $IdInvitation = $_REQUEST['IdInvitation'];
            $Core->DeniedInvitationForWorkSpace($_SESSION['email'],$IdWorkSpace,$IdInvitation);
            header('Location: account.php?param=default');
            break;
        }

        case 'AddTeatcherToWorkSpace':{
            $MemberTest = $Core->IsMemberOfWorkSpace($_REQUEST['WorkSpaceAccess'],$_SESSION['email']);
            if ($MemberTest){
                $PermissionUsers = $Core->GetPermissionForUsers($_REQUEST['WorkSpaceAccess'], $_SESSION['email']);
                if ($PermissionUsers[5]) {
                    $Core->AddTeatcherToWorkSpace($_REQUEST['WorkSpaceAccess'], $_POST['TeatcherAdd']);
                    header('Location: account.php?param=WorkSpace&WorkSpaceAccess=' . $_REQUEST['WorkSpaceAccess']);
                }
            }
            break;
        }

        case 'RemoveTeatcherFromWorkSpce':{
            $MemberTest = $Core->IsMemberOfWorkSpace($_REQUEST['WorkSpaceAccess'],$_SESSION['email']);
            if ($MemberTest){
                $PermissionUsers = $Core->GetPermissionForUsers($_REQUEST['WorkSpaceAccess'], $_SESSION['email']);
                if ($PermissionUsers[6]){
                    $Core->RemoveTeatcherFromWorkSapce($_POST['TeatcherToRemove'],$_REQUEST['WorkSpaceAccess']);
                    header('Location: account.php?param=WorkSpace&WorkSpaceAccess=' . $_REQUEST['WorkSpaceAccess']);
                }
            }
            break;
        }

        case 'WorkSpaceAddDiscipline':{
            $MemberTest = $Core->IsMemberOfWorkSpace($_REQUEST['WorkSpaceAccess'],$_SESSION['email']);
            if ($MemberTest){
                $PermissionUsers = $Core->GetPermissionForUsers($_REQUEST['WorkSpaceAccess'], $_SESSION['email']);
                if ($PermissionUsers[10]){
                    $Core->AddDiscipline($_REQUEST['WorkSpaceAccess'],$_POST['DisciplineName']);
                    header('Location: account.php?param=WorkSpace&WorkSpaceAccess=' . $_REQUEST['WorkSpaceAccess']);
                }
            }
            break;
        }

        case 'WorkSpaceRemoveDiscipline':{
            $MemberTest = $Core->IsMemberOfWorkSpace($_REQUEST['WorkSpaceAccess'],$_SESSION['email']);
            if ($MemberTest){
                $PermissionUsers = $Core->GetPermissionForUsers($_REQUEST['WorkSpaceAccess'], $_SESSION['email']);
                if ($PermissionUsers[9]){
                    $Core->RemoveDiscipline($_REQUEST['WorkSpaceAccess'],$_POST['RemoveDiscipline']);
                    header('Location: account.php?param=WorkSpace&WorkSpaceAccess=' . $_REQUEST['WorkSpaceAccess']);
                }
            }
            break;
        }

        case 'AddRessourcesToWorkSpace' : {
            $MemberTest = $Core->IsMemberOfWorkSpace($_REQUEST['WorkSpaceAccess'],$_SESSION['email']);
            if ($MemberTest){
                $CountContent = Count($_FILES['uploads']['name']);
                if ($CountContent >= 1){
                    $Folder = "files/";
                    $FolderName = $_POST['titleRessource'].'-'.$_POST['DisciplineId'];
                    mkdir($Folder.$FolderName);
                    for ($NumberFiles = 0 ; $NumberFiles < $CountContent ; $NumberFiles++){
                        $FileInfo = pathinfo($_FILES['uploads']['name'][$NumberFiles]);
                        $ExtentioFiles = ".pdf";
                        $NewFileName = $NumberFiles.'-'.$_POST['titleRessource'].$ExtentioFiles;
                        if ($_FILES['uploads']['type'][$NumberFiles] == "application/pdf") {
                            move_uploaded_file($_FILES['uploads']['tmp_name'][$NumberFiles], $Folder . '/' . $FolderName . '/' . $NewFileName);
                        }
                    }
                }
                $Core->AddRessourcesToWorkSpace($_REQUEST['WorkSpaceAccess'], $_POST['DisciplineId'], $_POST['TeatcherId'], $CountContent, $_POST['Content'], $_POST['titleRessource']);
                header('Location: account.php?param=WorkSpace&WorkSpaceAccess=' . $_REQUEST['WorkSpaceAccess']);
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