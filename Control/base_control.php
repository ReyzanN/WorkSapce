<?php
session_start();
require_once (dirname(__FILE__).'/../../WorkSpace_New/Core/MainCore.php');
$MainDB = MainCore::Main_ConnectDB();

if (isset($_REQUEST['param'])){
    $param = $_REQUEST['param'];

    switch ($param){

        case 'ConnectionRequest': {
            $login = $_REQUEST['emailConnect'];
            $pass = $_REQUEST['ConnectPass'];
            $ValidConnect = $MainDB->Main_ConnectUsers($login,$pass);
            if ($ValidConnect == 1){
                $_SESSION['email'] = $login;
                header('Location: ../account.php?param=default');
                exit();
            }
            else{
                header('Location: ../index.php');
                exit();
            }
            break;
        }

        default:{
            header('Location: ../index.php');
            exit();
            break;
        }
    }
}

?>