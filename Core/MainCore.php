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

    public static function GetNumbersWorkSpaceForMembers($email){
        $ID_ACCOUNT = self::GetIdAccount($email);
        $SQL_SELECT_Numbers_WOKSPACE_FOR_USERS = "SELECT count(*) FROM joinrequest_users WHERE Id_usersRequested = $ID_ACCOUNT AND Id_JoinStatut = 2";
        $REQ_SELECT_Numbers_WOKSPACE_FOR_USERS = MainCore::$BaseConnect->query($SQL_SELECT_Numbers_WOKSPACE_FOR_USERS);
        if ($REQ_SELECT_Numbers_WOKSPACE_FOR_USERS){
            return $RES_SELECT_Numbers_WOKSPACE_FOR_USERS = $REQ_SELECT_Numbers_WOKSPACE_FOR_USERS->fetch();
        }
        else{
            return $RES_SELECT_Numbers_WOKSPACE_FOR_USERS = [0];
        }
    }

    public function GetNumbersMembersAll(){
        $SQL_COUNT_MEMBERS = "SELECT count(*) FROM users";
        $REQ_COUNT_MEMBERS = MainCore::$BaseConnect->query($SQL_COUNT_MEMBERS);
        return $RES_COUNT_MEMBERS = $REQ_COUNT_MEMBERS->fetch();
    }

    public static function GetInfoWorkSpaceForMembers($email){
        $ID_ACCOUNT = self::GetIdAccount($email);
        $SQL_SELECT_INFO = "SELECT joinrequest_users.Id_WorkSpace, workspace.Name, users.name, users.surname, joinrequest_users.DateJoin FROM joinrequest_users
        INNER JOIN workspace ON workspace.Id_WorkSpace = joinrequest_users.Id_WorkSpace
        INNER JOIN owner ON owner.Id_WorkSpace = joinrequest_users.Id_WorkSpace
        INNER JOIN users ON users.Id_users = owner.Id_WorkSpace
        WHERE joinrequest_users.Id_usersRequested = $ID_ACCOUNT[0] AND joinrequest_users.Id_JoinStatut = 2;";
        $REQ_SELECT_INFO = MainCore::$BaseConnect->query($SQL_SELECT_INFO);
        if ($REQ_SELECT_INFO){
            return $RES_SELECT_INFO = $REQ_SELECT_INFO->fetchAll();
        }
        else{
            return "";
        }
    }

    public static function GetInvitationAll($email){
        $ID_ACCOUNT = self::GetIdAccount($email);
        $SQL_SELECT = "SELECT joinrequest_users.Id_JoinAsk, users.name, users.surname, workspace.Name, joinstatut.Status, joinstatut.Id_JoinStatut FROM joinrequest_users
        INNER JOIN users ON users.Id_users = joinrequest_users.Id_users
        INNER JOIN workspace ON workspace.Id_Workspace = joinrequest_users.Id_WorkSpace
        INNER JOIN joinstatut ON joinstatut.Id_JoinStatut = joinrequest_users.Id_JoinStatut
        WHERE joinrequest_users.Id_usersRequested = $ID_ACCOUNT";
        $REQ_SELECT = MainCore::$BaseConnect->query($SQL_SELECT);
        if ($REQ_SELECT){
            return $RES_SELECT = $REQ_SELECT->fetchAll();
        }
        else{
            return "";
        }
    }

    public static function GetCountPendingJoinRequest($email){
        $ID_ACCOUNT = self::GetIdAccount($email);
        $STAT = 3;
        $SQL_SELECT = "SELECT Count(*) AS NumberPendingAsk FROM joinrequest_users WHERE Id_usersRequested = :user AND Id_JoinStatut = :stat";
        $REQ_PREP = MainCore::$BaseConnect->prepare($SQL_SELECT);
        $REQ_PREP->bindParam(':user', $ID_ACCOUNT, PDO::PARAM_INT);
        $REQ_PREP->bindParam(':stat', $STAT, PDO::PARAM_INT);
        $REQ_PREP->execute();
        return $REQ_PREP->fetch();
    }


}
?>