<?php
require_once "Connexion.class.php";
require_once "User.class.php";

class UsersDao extends Connexion {
     private $users;

    function getPasswdHashUser($login){
        $pdo = $this->getBdd();
        $req = "SELECT password FROM utilisateur WHERE login=:login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $passwd = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();  
        return $passwd['password'];
    }
    
    function lireUsers(){
        $stmt = $this->getBdd()->prepare("SELECT * FROM utilisateur");
        $stmt->execute();
        $bddUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach($bddUsers as $user){
            // version 3-01
            //$u=new User($user['username'], $user['passwd_hash']);
            $u=new User($user['login'], $user['password'],$user['mail'], $user['role'],$user['image'], $user['est_valide']);
            $this->users[]=$u;
        }
        return $this->users;
    }
    
    function supprimerUserBD($username){
        $pdo = $this->getBdd();
        $req = "Delete from utilisateur where login = :username";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":username",$username,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
        if($resultat > 0){
            echo "user supprimer username=".$username."<br>";
        }
    }
    // version 3-01
    function creerUserBd($user) {  
        echo "user=".$user->getLogin()."<br>";
        $pdo = $this->getBdd();
        $req = "
        INSERT INTO utilisateur (login, password, mail, role, image, est_valide)
        values (:login, :password, :mail, :role, :image, :est_valide)";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$user->getLogin(),PDO::PARAM_STR);
        $stmt->bindValue(":password",$user->getPassword(),PDO::PARAM_STR);
        $stmt->bindValue(":mail",$user->getMail(),PDO::PARAM_STR);
        $stmt->bindValue(":role",$user->getRole(),PDO::PARAM_STR);
        $stmt->bindValue(":image",$user->getImage(),PDO::PARAM_STR);
        $stmt->bindValue(":est_valide",$user->getEstValide(),PDO::PARAM_INT);
        
        $resultat = $stmt->execute();
        $stmt->closeCursor();
        if($resultat > 0){
            echo "utilisateur insérer id=".$pdo->lastInsertId()."<br>";
        }        
    }
    function setUserValidBd($login){
        echo "login=".$login."<br>";
        $pdo = $this->getBdd();
        $req = "UPDATE utilisateur SET est_valide = 1 WHERE login = :login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
        if($resultat > 0){
            echo "user supprier login=".$login."<br>";
        }
    }
    function isExistLoginUser($login){
        $pdo = $this->getBdd();
        $req = "SELECT count(login) AS nb FROM utilisateur WHERE login=:login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $nbUserTab = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor(); 
        return ($nbUserTab['nb'] > 0);
    }
    function isUserValid($login){
        $pdo = $this->getBdd();
        $req = "SELECT est_valide AS isvalid FROM utilisateur WHERE login=:login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $estValid = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor(); 
        return $estValid['isvalid'];
    }
    function getRoleByLogin($login){
        $pdo = $this->getBdd();
        $req = "SELECT role FROM utilisateur WHERE login=:login";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $role = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();  
        return $role['role'];
    }
    function getUserByLogin($login){
        $stmt = $this->getBdd()->prepare("SELECT * FROM utilisateur WHERE login=:login");
        $stmt->bindValue(":login",$login,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        $u=new User($user['login'], $user['password'],$user['mail'], $user['role'],$user['image'], $user['est_valide']);
        return $u;
    }
}