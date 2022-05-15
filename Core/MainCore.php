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
        $SQL_SELECT = "SELECT joinrequest_users.Id_JoinAsk, users.name, users.surname, workspace.Name, joinstatut.Status, joinstatut.Id_JoinStatut, joinrequest_users.Id_WorkSpace FROM joinrequest_users
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

    public static function IsMemberOfWorkSpace($IdWorkSpace,$email){
        $ID_ACCOUNT = self::GetIdAccount($email);
        $STAT = 2;
        $SQL_SELECT = "SELECT * FROM joinrequest_users WHERE Id_usersRequested = :user AND Id_JoinStatut = :stat AND Id_WorkSpace = :workspace";
        $REQ_SELECT = MainCore::$BaseConnect->prepare($SQL_SELECT);
        $REQ_SELECT->bindParam(':user', $ID_ACCOUNT, PDO::PARAM_INT);
        $REQ_SELECT->bindParam(':stat', $STAT, PDO::PARAM_INT);
        $REQ_SELECT->bindParam(':workspace', $IdWorkSpace, PDO::PARAM_INT);
        $REQ_SELECT->execute();
        $RES_SELECT = $REQ_SELECT->rowCount();

        if ($RES_SELECT >= 1){
            return $RES = 1;
        }
        else {
            return $RES = 0;
        }
    }

    public static function GetNameWorkSpace($IdWorkSpace){
        $SQL_SELECT = "SELECT workspace.Name FROM workspace WHERE Id_WorkSpace = :workspace";
        $REQ_SELECT = self::$BaseConnect->prepare($SQL_SELECT);
        $REQ_SELECT->bindParam(':workspace', $IdWorkSpace, PDO::PARAM_INT);
        $REQ_SELECT->execute();
        return $REQ_SELECT->fetch();
    }

    public static function GetHeaderMessageForWorkSpace($IdWorkSpace){
        $SQL_SELECT = "SELECT Message FROM headermessage_workspace WHERE Id_WorkSpace = :workspace";
        $REQ_SELECT = self::$BaseConnect->prepare($SQL_SELECT);
        $REQ_SELECT->bindParam(':workspace', $IdWorkSpace, PDO::PARAM_INT);
        $REQ_SELECT->execute();
        return $REQ_SELECT->fetch();
    }

    public static function GetPermissionForUsers($IdWorkSpace, $EmailUser){
        $ID_ACCOUNT = self::GetIdAccount($EmailUser);
        $SQL_SELECT = "SELECT * FROM operator WHERE Id_users = :id_users AND Id_WorkSpace = :workspace";
        $REQ_SELECT = self::$BaseConnect->prepare($SQL_SELECT);
        $REQ_SELECT->bindParam(':id_users', $ID_ACCOUNT, PDO::PARAM_INT);
        $REQ_SELECT->bindParam(':workspace', $IdWorkSpace, PDO::PARAM_INT);
        $REQ_SELECT->execute();
        return $REQ_SELECT->fetch();
    }

    public function EditHeaderMessageWorkSpace($IdWorkSpace,$Message){
        $SQL_EDIT = "UPDATE headermessage_workspace SET Message = :Message WHERE Id_WorkSpace = :WorkSpace";
        $REQ_EDIT = self::$BaseConnect->prepare($SQL_EDIT);
        $REQ_EDIT->bindParam(':Message', $Message, PDO::PARAM_STR);
        $REQ_EDIT->bindParam(':WorkSpace', $IdWorkSpace, PDO::PARAM_INT);
        $REQ_EDIT->execute();
    }

    public static function GetNoMembersForInvitation($IdWorkSpace){
        $SQL_SELECT = "SELECT Id_users, users.name, users.surname FROM users WHERE 
        users.Id_users NOT IN (SELECT joinrequest_users.Id_usersRequested FROM joinrequest_users WHERE Id_JoinStatut  IN (2,3) AND Id_WorkSpace = 1)";
        $REQ_SELECT = self::$BaseConnect->prepare($SQL_SELECT);
        $REQ_SELECT->bindParam(':WorkSpace',$IdWorkSpace,PDO::PARAM_INT);
        $REQ_SELECT->execute();
        return $REQ_SELECT->fetchAll();
    }

    public static function SendInvitationToUser($IdWorkSpace,$IdUser, $IdUsersRequested){
        $IdUser = self::GetIdAccount($IdUser);
        $SQL_INSERT = "INSERT INTO joinrequest_users VALUES (null, DATE(NOW()), :IdWorkSpace, :IdUsers, :IdRequestedUser, 3);";
        $REQ_INSERT = self::$BaseConnect->prepare($SQL_INSERT);
        $REQ_INSERT->bindParam(':IdWorkSpace',$IdWorkSpace,PDO::PARAM_INT);
        $REQ_INSERT->bindParam(':IdUsers',$IdUser,PDO::PARAM_INT);
        $REQ_INSERT->bindParam(':IdRequestedUser',$IdUsersRequested,PDO::PARAM_INT);
        $REQ_INSERT->execute();
    }

    public static function AcceptInvitationForWorkSpace($EmailUser,$IdWorkSpace, $IdInvitation){
        $IdUser = self::GetIdAccount($EmailUser);
        $SQL_EDIT = "UPDATE joinrequest_users SET Id_JoinStatut = 2 WHERE Id_usersRequested = :IdUser AND Id_WorkSpace = :WorkSpace AND Id_JoinAsk = :IdJoinAsk";
        $REQ_EDIT = self::$BaseConnect->prepare($SQL_EDIT);
        $REQ_EDIT->bindParam(':IdUser',$IdUser,PDO::PARAM_INT);
        $REQ_EDIT->bindParam(':WorkSpace',$IdWorkSpace,PDO::PARAM_INT);
        $REQ_EDIT->bindParam(':IdJoinAsk',$IdInvitation,PDO::PARAM_INT);
        $REQ_EDIT->execute();
    }

    public static function DeniedInvitationForWorkSpace($EmailUser,$IdWorkSpace, $IdInvitation){
        $IdUser = self::GetIdAccount($EmailUser);
        $SQL_EDIT = "UPDATE joinrequest_users SET Id_JoinStatut = 1 WHERE Id_usersRequested = :IdUser AND Id_WorkSpace = :WorkSpace AND Id_JoinAsk = :IdJoinAsk";
        $REQ_EDIT = self::$BaseConnect->prepare($SQL_EDIT);
        $REQ_EDIT->bindParam(':IdUser',$IdUser,PDO::PARAM_INT);
        $REQ_EDIT->bindParam(':WorkSpace',$IdWorkSpace,PDO::PARAM_INT);
        $REQ_EDIT->bindParam(':IdJoinAsk',$IdInvitation,PDO::PARAM_INT);
        $REQ_EDIT->execute();
    }

    public static function WorkSpaceCountOperator($IdWorkSpace,$Users){
        $ID_ACCOUNT = self::GetIdAccount($Users);
        $SQL_SELECT = "SELECT users.name, users.surname FROM operator
        INNER JOIN users ON users.Id_users = operator.Id_users
        WHERE operator.Id_WorkSpace = :WorkSpace AND operator.Id_users = :Users";
        $REQ_SELECT = self::$BaseConnect->prepare($SQL_SELECT);
        $REQ_SELECT->bindParam(':WorkSpace',$IdWorkSpace,PDO::PARAM_INT);
        $REQ_SELECT->bindParam(':Users',$ID_ACCOUNT,PDO::PARAM_INT);
        $REQ_SELECT->execute();
        return $REQ_SELECT->fetchAll();
    }

    public static function AddTeatcherToWorkSpace($IdWorkSpace,$TeatcherName){
        $SQL_INSERT = "INSERT INTO teatcher VALUES (null, :Teatcher, :WorkSpace)";
        $REQ_INSERT = self::$BaseConnect->prepare($SQL_INSERT);
        $REQ_INSERT->bindParam(':Teatcher',$TeatcherName,PDO::PARAM_STR);
        $REQ_INSERT->bindParam('WorkSpace',$IdWorkSpace,PDO::PARAM_INT);
        $REQ_INSERT->execute();
    }

    public static function GetAllMembersForWorkSpace($IdWorkSpace){
        $ID_JOINSTAT = 2;
        $SQL_SELECT = "SELECT joinrequest_users.Id_JoinAsk, users.name, users.surname FROM joinrequest_users 
        INNER JOIN users ON users.Id_users = joinrequest_users.Id_usersRequested                                                      
        WHERE joinrequest_users.Id_JoinStatut = :IdStatJoin AND Id_WorkSpace = :IdWorkSpace";
        $REQ_SELECT = self::$BaseConnect->prepare($SQL_SELECT);
        $REQ_SELECT->bindParam(':IdStatJoin',$ID_JOINSTAT,PDO::PARAM_INT);
        $REQ_SELECT->bindParam(':IdWorkSpace',$IdWorkSpace,PDO::PARAM_INT);
        $REQ_SELECT->execute();
        return $REQ_SELECT->fetchAll();
    }

    public static function KickUserFromWorkSpace($IdWorkSpace,$IdInvitation){
        $KickedUser = 4;
        $SQL_UPDATE = "UPDATE joinrequest_users SET Id_JoinStatut = :KickId WHERE Id_JoinAsk = :IdInvitation AND Id_WorkSpace = :WorkSpace";
        $REQ_UPDATE = self::$BaseConnect->prepare($SQL_UPDATE);
        $REQ_UPDATE->bindParam(':KickId',$KickedUser,PDO::PARAM_INT);
        $REQ_UPDATE->bindParam(':IdInvitation',$IdInvitation,PDO::PARAM_INT);
        $REQ_UPDATE->bindParam(':WorkSpace',$IdWorkSpace,PDO::PARAM_INT);
        $REQ_UPDATE->execute();
    }

    public static function GetAllTeatcherFroWorkSpace($IdWorkSpace){
        $SQL_SELECT = "SELECT IdTeatcher, TeacherName FROM teatcher WHERE Id_WorkSpace = :IdWorkSpace";
        $REQ_SELECT = self::$BaseConnect->prepare($SQL_SELECT);
        $REQ_SELECT->bindParam(':IdWorkSpace',$IdWorkSpace,PDO::PARAM_INT);
        $REQ_SELECT->execute();
        return $REQ_SELECT->fetchAll();
    }

    public static function RemoveTeatcherFromWorkSapce($IdTeatcher,$IdWorkSpace){
        $SQL_DELETE = "DELETE FROM teatcher WHERE IdTeatcher = :Teatcher AND Id_WorkSpace = :IdWorkSpace";
        echo $SQL_DELETE;
        $REQ_DELETE = self::$BaseConnect->prepare($SQL_DELETE);
        $REQ_DELETE->bindParam(':Teatcher',$IdTeatcher,PDO::PARAM_INT);
        $REQ_DELETE->bindParam(':IdWorkSpace',$IdWorkSpace,PDO::PARAM_INT);
        $REQ_DELETE->execute();
    }

    public static function AddDiscipline($IdWorkSpace,$Name){
        $SQL_INSERT = "INSERT INTO discipline VALUES (null, :name, :Id_WorkSpace)";
        $REQ_INSERT = self::$BaseConnect->prepare($SQL_INSERT);
        $REQ_INSERT->bindParam(':name',$Name,PDO::PARAM_STR);
        $REQ_INSERT->bindParam(':Id_WorkSpace',$IdWorkSpace,PDO::PARAM_INT);
        $REQ_INSERT->execute();
    }

    public static function GetAllDiscipline($IdWorkSpace){
        $SQL_SELECT = "SELECT Id_discipline, name FROM discipline WHERE Id_WorkSpace = :IdWorkSpace";
        $REQ_SELECT = self::$BaseConnect->prepare($SQL_SELECT);
        $REQ_SELECT->bindParam(':IdWorkSpace',$IdWorkSpace,PDO::PARAM_INT);
        $REQ_SELECT->execute();
        return $REQ_SELECT->fetchAll();
    }

    public static function RemoveDiscipline($IdWorkSpace,$IdDiscipline){
        $SQL_DELETE = "DELETE FROM discipline WHERE Id_discipline = :IdDiscipline AND Id_WorkSpace = :IdWorkSpace";
        $REQ_DELETE = self::$BaseConnect->prepare($SQL_DELETE);
        $REQ_DELETE->bindParam(':IdWorkSpace', $IdWorkSpace,PDO::PARAM_INT);
        $REQ_DELETE->bindParam(':IdDiscipline', $IdDiscipline,PDO::PARAM_INT);
        $REQ_DELETE->execute();
    }
}
?>