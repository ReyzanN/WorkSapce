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

    public static function QuoteThings($things){
        return $QUOTE = MainCore::$BaseConnect->quote($things);
    }

    public static function GetIdAccount($email){
        $EMAIL_QUOTE = self::QuoteThings($email);
        $SQL_SELECT_ID = "SELECT Id_users FROM users WHERE email = $EMAIL_QUOTE";
        $REQ_SELECT_ID = MainCore::$BaseConnect->query($SQL_SELECT_ID);
        $RES_SELECT_ID = $REQ_SELECT_ID->fetch();
        return $RES_SELECT_ID[0];
    }

    public static function GetInfoAccount($email){
        $ID_ACCOUNT = self::GetIdAccount($email);
        $SQL_GET_INFO = "SELECT users.name, USERS.surname, USERS.birthdate, USERS.email FROM users WHERE Id_users = $ID_ACCOUNT";
        $REQ_GET_INFO = MainCore::$BaseConnect->query($SQL_GET_INFO);
        return $RES_GET_INFO = $REQ_GET_INFO->fetch();
    }

    public static function GetWorkSpaceForMembers($email){
        $ID_ACCOUNT = self::GetIdAccount($email);
        $SQL_SELECT_MEMBERS = "SELECT workspace.Name, owner.Id_users, ValidUsers.logs_date, users.surname FROM owner
        INNER JOIN workspace W ON W.Id_WorkSpace = owner.Id_users
        INNER JOIN users ON users.Id_users = owner.Id_users
        INNER JOIN ValidUsers ON ValidUsers.Id_UsersAddAsk = $ID_ACCOUNT;
        ";
    }

}
?>