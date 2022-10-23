<?php
require_once "../outil/outils.php";
require_once "LivreManager.class.php"; 
$livreManager = new LivreManager();
$livreManager->lireLivres();
$livres = $livreManager->getLivres();
afficherTableau($livres,"Tableau livres");
/*echo "id=".$livres[0]->getId()."<br>";

$livre = $livreManager->lireLivreById($livres[0]->getId());
afficherTableau($livre,"Tableau livre");
*/

//$livreManager->ajouterLivreBd("test titre",444,444,"miel.jpg","test description");

//echo "id=".$livres[0]->getId()."<br>";
//$livreManager->supprimerLivreBD($livres[0]->getId());

//echo "nbr=".$livreManager->supprimerTousLivresBD()."<br>";

//$livreManager->supprimerLivreBD($livres[0]->getId());

//$livreManager->modificationLivreBD($livres[0]->getId(),"test titre",444,444,"miel.jpg","test description");