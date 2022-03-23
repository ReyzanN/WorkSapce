<?php
/*
 * @author Reyzan - G.SC
 * @version    1.0
 */

class MainCore{
    private static $server='mysql:host=localhost';
    private static $bdd='dbname=workspace_new';
    private static $user='root' ;
    private static $pass='' ;
    private static $BaseConnect;
    private static $BasConnection =null;

    private function __construct(){
        MainCore::$BaseConnect = new PDO(MainCore::$server.';'.MainCore::$bdd, MainCore::$user, MainCore::$pass);
        MainCore::$BaseConnect->query("SET CHARACTER SET utf8");
    }
    public function __destruct(){
        MainCore::$BaseConnect = null;
    }

    public static function Main_ConnectDB(){
        if(MainCore::$BasConnection==null){
            MainCore::$BasConnection = new MainCore();
        }
        return MainCore::$BasConnection;
    }

    public static function Main_ConnectUsers($email,$pass){
        $email = MainCore::$BaseConnect->quote($email);
        $pass = MainCore::$BaseConnect->quote($pass);
        $SQL_SELECT = "SELECT * FROM users WHERE email = $email AND password = $pass";
        $REQ_SELECT = MainCore::$BaseConnect->query($SQL_SELECT);
        $REQ_SELECT = $REQ_SELECT->rowCount();

        if ($REQ_SELECT == 1){
            return true;
        }
        return $MessageValid = "Combinaison Mot De Passe / Identifiants inccorect";
    }

    public static function Main_DisconnectUsers(){
        return session_destroy();
    }

}
?>