<?php
require_once "model/UsersDao.class.php";
require_once "outil/Securite.class.php";

class UserControleur {
    private $userDao;

    public function __construct(){
        $this->userDao = new UsersDao();
    }
    function login(){
        $alert="";
        if(!Securite::isConnected()){
            require "vue/login.view.php";
        }
        else header("Location: index.php?action=profil");
    }
    function loginValidation(){
        $alert="";
        if(!$this->userDao->isExistLoginUser($_POST['login'])){
            throw new Exception("Le login n'existe pas");
        }
        else {          //if(!Securite::verifAccessAdmin()){
            if(isset($_POST['login']) && !empty($_POST['login'])
                     && isset($_POST['password']) && !empty($_POST['password']))        
            {
                if($this->userDao->isUserValid($_POST['login'])){
                    echo "user valide";
                    echo "_POST['password']=".$_POST['password']."<br>";
                    $passwdHashbd = $this->userDao->getPasswdHashUser($_POST['login']);
                    echo "passwdHash bd=".$passwdHashbd."<br>";
                    //echo "passwdHash bd=".$passwdHashbd."<br>";
                    if(password_verify($_POST['password'], $passwdHashbd)){
                        echo "password_verify OK";  
                        $_SESSION['login'] = $_POST['login']; 
                        $_SESSION['role'] = $this->userDao->getRoleByLogin($_POST['login']);
                        header("Location: index.php?action=profil");
                    }
                    else {
                       $alert = "Mot de passe invalide";
                       require "vue/login.view.php";
                    }
                }
                else {
                    $alert = "Vous devez valider votre compte via votre mail";
                    require "vue/login.view.php";
                }
            } else {
                $alert = "Saisir un nom d'utilisateur et un mot de passe";
                require "vue/login.view.php";
            }
        }
    }
    function logout(){
        if(Securite::isConnected()){
            unset($_SESSION['role']);
            unset($_SESSION['nom']);
            header("Location: index.php");
        }
        else throw new Exception("Vous n'êtes pas connecté, vous ne pouvez vous délogger");
    }
    function adminUser(){
        if(Securite::verifAccessAdmin()){
            $users = $this->userDao->lireUsers();
            require "vue/admin.view.php";
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    function supprimerUser(){
        if(Securite::verifAccessAdmin()){
            $this->userDao->supprimerUserBD($_GET['user']);
            header("Location: index.php?action=admin");
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    function creerUser(){
        require "vue/creerUser.view.php";
    }
    function creerUserValidation(){
        $this->sendMailValidation($_POST['login'], $_POST['mail']);
        $hash = password_hash($_POST['passwd'], PASSWORD_DEFAULT);
        echo "hash=".$hash."<br>";
        //$this->userDao->creerUserBd($_POST['username'],$hash);
        // Version 3-01
        $user=new User($_POST['login'], $hash, $_POST['mail'], "abonne","profils/profil.png", 0);
        $this->userDao->creerUserBd($user);
        header("Location: index.php?action=login");
    }
    private function sendMailValidation($login,$mail){
        $urlVerification = "http://localhost/bdd/biblio-etape3-01/index.php?action=sendmailuser&login=".$login;
        $sujet = "Création du compte sur le site Alcatar";
        $message = "Pour valider votre compte veuillez cliquer sur le lien suivant ".$urlVerification;
        sendMail($mail,$sujet,$message);
    }
    function receiveMailValidation(){
        echo "receiveMailValidation";
        $this->userDao->setUserValidBd($_GET['login']);
        $alert="";
        require "vue/login.view.php";
    }
    function afficherProfil(){
        $user = $this->userDao->getUserByLogin($_SESSION['login']);
        require "vue/profil.view.php";
    }
    function supprimersonCompteAbonne(){
        if($_SESSION['role'] == 'abonne'){
            $user = $this->userDao->supprimerUserBD($_SESSION['login']);
            unset($_SESSION);
            require "vue/accueil.view.php";
        }
        else {
            require "vue/profil.view.php";
        }
    }
    
}

