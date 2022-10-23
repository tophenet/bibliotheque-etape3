<?php
require_once "model/LivreManager.class.php"; 
require_once "./outil/outils.php";
require_once "model/EmpruntDao.class.php"; 
require_once "model/Emprunt.class.php"; 

class LivresController{
    private $livreManager;
    private $empruntDao;

    public function __construct(){
        $this->livreManager = new LivreManager();
        $this->empruntDao = EmpruntDao::getInstance();
        //$this->livreManager->chargementLivres();
    }
    function afficherAccueil(){
        require "vue/accueil.view.php";
    }
    function afficherLivres(){
        $tabLivres=$this->livreManager->lireLivres();
        require "vue/afficherlivres.view.php";
    }
    function afficherLivre($id){
        $livre=$this->livreManager->lireLivreById($id);
        require "vue/afficherlivre.view.php";
    }
    function supprimerLivre($id){ // Tester les droits
        if(Securite::verifAccessAdmin()){
            $nomImage = $this->livreManager->lireLivreById($id)->getImage();
            unlink("public/images/".$nomImage);
            $this->livreManager->supprimerLivreBD($id);
            header("Location: index.php?action=tab");
        }
        else throw new Exception("Vous n'avez pas les droit nécessaires");
    }
    function creerLivre(){ // Tester les droits
        if(Securite::verifAccessAdmin()){
            require "vue/formulairelivre.view.php";
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    function creerValidationLivre(){ // Tester les droits
        if(Securite::verifAccessAdmin()){
            $file = $_FILES['image'];
            $repertoire = "public/images/";
            $nomImageAjoute = ajouterImage($file,$repertoire);
            $this->livreManager->ajouterLivreBd($_POST['titre'],$_POST['nb'],$_POST['nbPages'],$nomImageAjoute,$_POST['descr']);
            header("Location: index.php?action=tab");
        }
        else throw new Exception("Vous n'avez pas les droit nécessaires");
    }
    function afficherCardLivres(){
        $livres=$this->livreManager->lireLivres();
        require "vue/cardLivres.view.php";
    }
    function modifierLivre($id){ // Tester les droits
        if(Securite::verifAccessAdmin()){
            //echo "Modifier LIVRE id=".$id."<br>";
            $livre=$this->livreManager->lireLivreById($id);
            require "vue/modifierLivre.view.php";
        }
        else throw new Exception("Vous n'avez pas le droit d'accéder à cette page");
    }
    function modifiervalidationLivre(){ // Tester les droits
        if(Securite::verifAccessAdmin()){
            afficherTableau($_POST,"POST");
            // echo "Modifier VALIDATION LIVRE id<br>";
            $repertoire = "public/images/";
            $nomImageAjoute = $_POST['image'];
            $file = $_FILES['image'];
            afficherTableau($file,"file");
            $repertoire = "public/images/";
            if($_FILES['image']['size'] > 0){
                unlink($repertoire.$nomImageAjoute);
                $nomImageAjoute = ajouterImage($file,$repertoire);
            }
            $livres=$this->livreManager->modificationLivreBD($_POST['id'],$_POST['titre'], $_POST['nb'],$_POST['nbPages'],$nomImageAjoute,$_POST['descr']);
            header("Location: index.php?action=tab");
        }
        else throw new Exception("Vous n'avez pas les droit nécessaires");
    }
    function ajouerterLivrePanier($id){ // ajout exception 
        //echo "controleur ajouerterLivrePanier id=".$id;
        if(!isset($_SESSION['livres'])){
            $_SESSION['livres'] = array();
        }
        if(in_array($id, $_SESSION['livres'])){
            echo $id." est déjà commander<br>";
            throw new Exception("Vous avez déjà commander ce livre");
        }
        else {
            $_SESSION['livres'][]=$id;
        }
        afficherTableau($_SESSION['livres'],"SESSION['livres']");
        header("Location: index.php?action=card");
    }
    function supprimerLivrePanier($id){
        for ($i = 0; $i < count($_SESSION['livres']); $i++){
            if($_SESSION['livres'][$i] == $id){
                unset($_SESSION['livres'][$i]);
            } 
        }
        header("Location: index.php?action=panier");
    }
    function afficherCommande(){
        foreach($_SESSION['livres'] as $id){
            $livres[]=$this->livreManager->lireLivreById($id);
        }
        if(isset($livres)){
            if(count($livres) > 0)
                require "vue/panierLire.view.php";
        }
        else //echo "La commande est vide<br>";
            header("Location: index.php?action=card");
    }
    /*function validerPanier(){
        $_SESSION['livres'] = array();
        afficherTableau($_SESSION,"controleur - supprimerCommand _SESSION");
        header("Location: index.php?action=card");
    }*/
    public function validerPanier(){
        echo date('Y-m-d H:i:s');
        //$dateNow = date('Y-m-d H:i:s');
        if(isset($_SESSION['livres'])){
            $login = $_SESSION['login'];
            foreach ($_SESSION['livres'] as $idLivre) {
                $livre = $this->livreManager->lireLivreById($idLivre);
                $emprunt = new Emprunt($idLivre, $login);
                //$emprunt->setTitreLivre($livre->getTitre());
                $emprunt = $this->empruntDao->creerEmprunt($emprunt);
                $this->livreManager->decrementerNbLivre($idLivre);
            }
            unset($_SESSION['livres']);
            //Toolbox::ajouterMessageAlerte("Vos emprunts ont bien été enregistré", Toolbox::COULEUR_VERTE);
            header("Location: index.php?action=lister-emprunt-livre");
        }
        else {
            //Toolbox::ajouterMessageAlerte("Votre panier est vide", Toolbox::COULEUR_VERTE);
            header("Location: index?action=card");
        }
        //$_SESSION['livres'] = array();
        //afficherTableau($_SESSION,"controleur - supprimerCommand _SESSION");
        //header("Location: index.php?action=card");
    }
    public function listerEmpruntLivre(){
        $alert="";
        $empruntList = $this->empruntDao->findEmpruntByLogin($_SESSION['login']);
        if(!isset($empruntList)){
            //Toolbox::ajouterMessageAlerte("Vous n'avez emprunté de livre", Toolbox::COULEUR_VERTE);
            //header("Location: ".URL."abonne/catalogue");
            $alert="Vous n'avez pas emprunté de livre";
            //header("Location: index?action=card");
        }
        //Outils::afficherListObjet($empruntList, "empruntList");
        if(isset($empruntList) && !empty($empruntList)){
            /*foreach ($empruntList as $emprunt) {
                //echo "emprunt=".$emprunt."<br>";
                $titreLivre = $this->livreManager->findTitreLivreByIdLivre($emprunt->getIdLivre()); 
                //echo "titreLivre=".$titreLivre."<br>";
                $emprunt->setTitreLivre($titreLivre);
                //echo "emprunt=".$emprunt."<br>";
                //Outils::afficherTableau($emprunt, "emprunt");
            }*/
            //Outils::afficherListObjet($empruntList, "empruntList");
            //Outils::afficherTableau($livreList, "livreList");
            //Toolbox::ajouterMessageAlerte("Les emprunts ont été validés", Toolbox::COULEUR_VERTE);
            require "vue/empruntListLivre.view.php";
        }
        else {
            //Toolbox::ajouterMessageAlerte("Vous n'avez emprunté de livre", Toolbox::COULEUR_VERTE);
            $alert="Vous liste de livre emprunté est vide";
            require "vue/empruntListLivre.view.php";
            //header("Location: index?action=card");
        }
    }
    public function retourLivreEmprunt($idEmprunt, $idLivre){
        //echo "retourLivreEmprunt idEmprunt = ".$idEmprunt."<br>";
        $this->empruntDao->setDateRetour($idEmprunt);
        $this->livreManager->incrementerNbLivre($idLivre);
        header("Location: index.php?action=lister-emprunt-livre");
    }
    public function historiqueEmprunt(){
        //echo "retourLivreEmprunt idEmprunt = ".$idEmprunt."<br>";
        $alert="";
        $empruntHistoriqueList = $this->empruntDao->findEmpruntHistoriqueByLogin($_SESSION['login']);
        if(isset($empruntHistoriqueList) && !empty($empruntHistoriqueList)){
        afficherTableau($empruntHistoriqueList, "empruntHistoriqueList");
        }
        else {
            $alert="Votre historique de livre emprunté est vide";
        }
       require "vue/historique.view.php";
    }
    public function recherche() {
        require "vue/recherche.view.php";
    }
    public function rechercheRequete(){
        echo "rechercheRequete";
        $description = $_POST['description'];
        $titre = $_POST['titre'];
        //if(isset($description))
    }
}
?>