<?php
require_once "controleur/LivreControleur.class.php";
require_once "outil/outils.php";
require_once "outil/Securite.class.php";
require_once "controleur/UserControleur.class.php";
session_start();
$livreController = new LivresController;
$userControleur = new UserControleur();
//afficherTableau($_SESSION,"SESSION");
try{
    if(empty($_GET['action'])){
        $livreController->afficherAccueil();
    }
    elseif(isset($_GET['action'])) {
        if($_GET['action']=="tab"){
            $livreController->afficherLivres();
        }
        elseif($_GET['action'] == 'suppr'){ //OK
            $livreController->supprimerLivre($_GET['id']);
        }
        else if($_GET['action'] == 'lire'){ //OK
            $livreController->afficherLivre($_GET['id']);
        }
        elseif($_GET['action'] == 'creer'){ //OK
            $livreController->creerLivre();
        }
        elseif($_GET['action'] == 'valid-creer'){ //OK
            $livreController->creerValidationLivre();
        }
        elseif($_GET['action']=="card"){  //OK
            $livreController->afficherCardLivres();
        }
        elseif($_GET['action'] == 'modifier'){ //OK
            $livreController->modifierLivre($_GET['id']);
        }
        elseif($_GET['action'] == 'valid-modifier'){//OK
            echo "Modifier validation";
            $livreController->modifierValidationLivre();
        }
        elseif($_GET['action'] == 'addpanier'){ //OK
            echo "Ajouter panier id=".$_GET['id'];
            $livreController->ajouerterLivrePanier($_GET['id']);
        }
        elseif($_GET['action'] == 'panier'){ //OK
            //echo "Voir commande";
            if(isset($_SESSION['livres']))
                $livreController->afficherCommande();
            else throw new Exception("Votre commande est vide");
        }
        elseif($_GET['action'] == 'panier-supprimer-livre'){ //OK
            $livreController->supprimerLivrePanier($_GET['id']);
        }
        elseif($_GET['action']=="valider-panier"){ 
            echo "valider panier";
            $livreController->validerPanier();
        }
        elseif($_GET['action'] == 'addpanier'){ //OK
            echo "Ajouter panier id=".$_GET['id'];
            $livreController->ajouerterLivrePanier($_GET['id']);
        }
        elseif($_GET['action'] == 'lister-emprunt-livre'){ //OK
         
            $livreController->listerEmpruntLivre();
        }
        // emprunt-retour-livre
        elseif($_GET['action'] == 'retourner-emprunt-livre'){ //OK
         
            $livreController->retourLivreEmprunt($_GET['idEmprunt'], $_GET['idLivre']);
        }
        elseif($_GET['action'] == 'error404'){ 
            throw new Exception("La page n'existe pas - erreur 404");
        }
        // Ajouter les action : se logger/délogger et gestion administrateur
        elseif($_GET['action']=="login"){
            $userControleur->login();
        }
        elseif($_GET['action']=="login-validation"){
            //echo "login-validation";
            $userControleur->loginValidation();
        }
        elseif($_GET['action']=="logout"){
            $userControleur->logout();
        }
        elseif($_GET['action']=="admin"){
            //echo "login";
            $userControleur->adminUser();
        }
        elseif($_GET['action']=="creer-user"){
            $userControleur->creerUser();
        }
        elseif($_GET['action']=="creer-user-validation"){
            $userControleur->creerUserValidation();
        }
        elseif($_GET['action']=="sendmailuser"){
            $userControleur->receiveMailValidation();
        }
        elseif($_GET['action']=="profil"){
            $userControleur->afficherProfil();
        }
        elseif($_GET['action']=="supprimer-abonne"){ 
            $userControleur->supprimersonCompteAbonne();
        }
        elseif($_GET['action']=="supprimer-user"){
            $userControleur->supprimerUser();
        }
        elseif($_GET['action']=="historique"){
            $livreController->historiqueEmprunt();
        }
        elseif($_GET['action']=="recherche"){
            $livreController->recherche();
        }
        elseif($_GET['action']=="rechercher-requete"){
            $livreController->rechercheRequete();
        }
        else {
            throw new Exception("La page n'existe pas");
        } 
    }
    else {
        //echo "La page n'existe pas";
        throw new Exception("La page n'existe pas");
    } 
}catch(Exception $e){
    $erreurMsg = $e->getMessage();
    require "vue/erreurs.view.php";
}
?>