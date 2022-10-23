<?php
require_once "Connexion.class.php";
require_once "Livre.class.php";
class EmpruntDao extends Connexion {
        // Design pattern singleton
    private static $_instance = null;
    //private $themeDao;
    
    private function __construct() {  
        //echo "LivreDao - __construct()<br>";
        //$this->themeDao = ThemeDao::getInstance();
    }
    public static function getInstance() {
        if(is_null(self::$_instance)) {
            self::$_instance = new EmpruntDao();  
        }
        return self::$_instance;
    }
    public function findAllEmprunt(){
        $stmt = $this->getBdd()->prepare(
            "SELECT * FROM utilisateur_livre_emprunter");
        $nb = $stmt->execute();
        //echo "nb=".$nb."<br>";
        $empruntListBd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        if(isset($empruntListBd)){
            foreach($empruntListBd as $empruntBd){
                $emprunt = new Emprunt($empruntListBd['idLivre'], $empruntListBd['login'], $empruntListBd['date_pret'], $empruntListBd['date_retour'], $empruntListBd['description']);
                //echo "LivreDao - findAllLivre - l=".$l." livre[idLivre]=".$livre['idLivre']."<br>";
                //$emprunt->setIdLivre($livreBd['$idLivre']);
                $emprunts[]=$emprunt;
            }
            return $livres;
        }
    }
    public function findEmpruntByLogin($login){
        /*$stmt = $this->getBdd()->prepare(
            "SELECT * FROM utilisateur_livre_emprunter WHERE login= :login AND date_retour IS NULL");*/
        $stmt = $this->getBdd()->prepare(
            "SELECT idLivre, login, idEmprunt, date_pret, date_retour, titre "
                . " FROM utilisateur_livre_emprunter "
                . " JOIN livres ON utilisateur_livre_emprunter.idLivre = livres.id "
                . "WHERE login= :login AND date_retour IS NULL ORDER BY date_retour ASC");
        $stmt->bindValue(":login",$login,PDO::PARAM_INT);
        $nb = $stmt->execute();
        //echo "nb=".$nb."<br>";
        $empruntListBd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //outils::afficherTableau($empruntListBd, "empruntListBd");
        $stmt->closeCursor();
        $empruntList = array();
        foreach($empruntListBd as $empruntBd){
            $emprunt = new Emprunt($empruntBd['idLivre'], $empruntBd['login']);
            $emprunt->setIdEmprunt($empruntBd['idEmprunt']);
            $emprunt->setDatePret($empruntBd['date_pret']);
            $emprunt->setDateRetour($empruntBd['date_retour']);
            $emprunt->setTitreLivre($empruntBd['titre']);
            //echo "LivreDao - findAllLivre - l=".$l." livre[idLivre]=".$livre['idLivre']."<br>";
            $empruntList[]=$emprunt;
        }
        //Outils::afficherListObjet($empruntList, "empruntList");
        return $empruntList;
    }
    public function findEmpruntHistoriqueByLogin($login){
        $stmt = $this->getBdd()->prepare(
            "SELECT idLivre, login, idEmprunt, date_pret, date_retour, titre "
                . " FROM utilisateur_livre_emprunter "
                . " JOIN livres ON utilisateur_livre_emprunter.idLivre = livres.id "
                . "WHERE login= :login AND date_retour IS NOT NULL ORDER BY date_retour DESC");
        $stmt->bindValue(":login",$login,PDO::PARAM_INT);
        $nb = $stmt->execute();
        //echo "nb=".$nb."<br>";
        $empruntListBd = $stmt->fetchAll(PDO::FETCH_ASSOC);
        //outils::afficherTableau($empruntListBd, "empruntListBd");
        $stmt->closeCursor();
        $empruntList = array();
        foreach($empruntListBd as $empruntBd){
            $emprunt = new Emprunt($empruntBd['idLivre'], $empruntBd['login']);
            $emprunt->setIdEmprunt($empruntBd['idEmprunt']);
            $emprunt->setDatePret($empruntBd['date_pret']);
            $emprunt->setDateRetour($empruntBd['date_retour']);
            $emprunt->setTitreLivre($empruntBd['titre']);
            //echo "LivreDao - findAllLivre - l=".$l." livre[idLivre]=".$livre['idLivre']."<br>";
            $empruntList[]=$emprunt;
        }
        //Outils::afficherListObjet($empruntList, "empruntList");
        return $empruntList;
    }
    
    public function findEmpruntByIdEmprunt($idEmprunt){ 
        $stmt = $this->getBdd()->prepare(
            "SELECT * FROM utilisateur_livre_emprunter WHERE idEmprunt= :idEmprunt");
        $stmt->bindValue(":idEmprunt",$idEmprunt,PDO::PARAM_INT);
        $nb = $stmt->execute();
        //echo "nb=".$nb."<br>";
        $emprunBd = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();  
        //afficherTableau($livreBd, "findLivreByIdLivre livreBd");
        $emprunt = new Emprunt($emprunBd['idLivre'], $_SESSION['login']);
        $emprunt->setIdEmprunt($emprunBd['idEmprunt']);
        $emprunt->setDatePret($emprunBd['date_pret']);
        $emprunt->setDateRetour($emprunBd['date_retour']);
        
        //$livre->setIdLivre($livreBd['idLivre']);
        return $emprunt;
    }
    public function creerEmprunt($emprunt){
        echo "creerEmprunt emprunt=".$emprunt."<br>";
        $pdo = $this->getBdd();
        $req = "
            INSERT INTO utilisateur_livre_emprunter (idLivre, login, date_pret, date_retour)
            VALUES (:idLivre, :login, :date_pret, null)";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":idLivre",$emprunt->getIdLivre(),PDO::PARAM_INT);
        $stmt->bindValue(":login",$emprunt->getLogin(),PDO::PARAM_STR);
        $stmt->bindValue(":date_pret",$emprunt->getDatePret(),PDO::PARAM_STR);
        $nb = $stmt->execute();
        //echo "nb=".$nb."<br>";
        $stmt->closeCursor();      
        if($nb > 0){
            return $pdo->lastInsertId();
        }
        return false;
    }
    public function setDateRetour($idEmprunt) {
        $dateRetour = date('Y-m-d H:i:s');
        $pdo = $this->getBdd();
        $req = "
            UPDATE utilisateur_livre_emprunter 
            SET date_retour = :dateRetour 
            WHERE idEmprunt = :idEmprunt";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":idEmprunt",$idEmprunt,PDO::PARAM_INT);
        $stmt->bindValue(":dateRetour",$dateRetour,PDO::PARAM_STR);
        $nb = $stmt->execute();
        echo "dateRetour=".$dateRetour." nb=".$nb."<br>";
        $stmt->closeCursor();
        return ($nb > 0);
    }
    
}

