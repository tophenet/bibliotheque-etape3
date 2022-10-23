<?php
require_once "Connexion.class.php";
require_once "Livre.class.php";

class LivreManager extends Connexion {
    private $livres;//tableau de Livre
    public function getLivres(){
        return $this->livres;
    }
    function lireLivres(){
        $stmt = $this->getBdd()->prepare("SELECT * FROM livres");
        $stmt->execute();
        $bddLivres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        foreach($bddLivres as $livre){
            $l=new Livre($livre['id'], $livre['titre'], $livre['nb'], $livre['nbPages'], $livre['image'], $livre['description']);
            $this->livres[]=$l;
        }
        return $this->livres;
    }

    function lireLivreById($id){
        $stmt = $this->getBdd()->prepare("SELECT * FROM livres WHERE id=:id");
        $stmt->bindValue(":id",$id,PDO::PARAM_STR);
        $cpt = $stmt->execute();
        $livre = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();  
        //echo "id=".$id."<br>";
        $l=new Livre($livre['id'], $livre['titre'], $livre['nb'], $livre['nbPages'], $livre['image'], $livre['description']);
        return $l;
    }

    function ajouterLivreBd($titre,$prix,$nbPages,$image,$description){
        $pdo = $this->getBdd();
        $req = "
        INSERT INTO livres (titre, nb, nbPages, image, description)
        values (:titre, :nb, :nbPages, :image, :description)";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":titre",$titre,PDO::PARAM_STR);
        $stmt->bindValue(":nb",$nb,PDO::PARAM_STR);
        $stmt->bindValue(":nbPages",$nbPages,PDO::PARAM_INT);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
        if($resultat > 0){
            echo "livre insérer id=".$pdo->lastInsertId()."<br>";
        }        
    }

    function supprimerLivreBD($id){
        $pdo = $this->getBdd();
        $req = "Delete from livres where id = :idLivre";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":idLivre",$id,PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();
        if($resultat > 0){
            echo "livre supprimer id=".$id."<br>";
        }
    }
    
    function supprimerTousLivresBD(){
        $pdo = $this->getBdd();
        $req = "Delete from livres";
        $stmt = $pdo->prepare($req);
        $nbr = $stmt->execute();
        return $nbr;
    }

    function modificationLivreBD($id,$titre,$nb,$nbPages,$image,$description){
        $pdo = $this->getBdd();
        $req = "
        update livres 
        set titre = :titre, nb = :nb, nbPages = :nbPages, image = :image, description = :description
        where id = :id";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":id",$id,PDO::PARAM_INT);
        $stmt->bindValue(":titre",$titre,PDO::PARAM_STR);
        $stmt->bindValue(":nb",$nb,PDO::PARAM_STR);
        $stmt->bindValue(":nbPages",$nbPages,PDO::PARAM_INT);
        $stmt->bindValue(":image",$image,PDO::PARAM_STR);
        $stmt->bindValue(":description",$description,PDO::PARAM_STR);
        $resultat = $stmt->execute();
        $stmt->closeCursor();

        if($resultat > 0){
            echo "livre modifier id=".$id."<br>";
        }
    }
    function decrementerNbLivre($idLivre){
        //Update Matable Set MonChamp=Monchamp-1 where Macle=ValeurQuiVaBien
        $pdo = $this->getBdd();
        $req = "
        update livres 
        set nb = nb - 1
        where id = :id";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":id",$idLivre,PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();       
        if($resultat > 0){
            echo "livre modifier id=".$idLivre."<br>";
        }
    }
    function incrementerNbLivre($idLivre){
        //Update Matable Set MonChamp=Monchamp-1 where Macle=ValeurQuiVaBien
        $pdo = $this->getBdd();
        $req = "
        update livres 
        set nb = nb + 1
        where id = :id";
        $stmt = $pdo->prepare($req);
        $stmt->bindValue(":id",$idLivre,PDO::PARAM_INT);
        $resultat = $stmt->execute();
        $stmt->closeCursor();       
        if($resultat > 0){
            echo "livre modifier id=".$idLivre."<br>";
        }
    }
    function findTitreLivreByIdLivre($idLivre){ 
        $stmt = $this->getBdd()->prepare(
            "SELECT titre FROM livres WHERE id= :idLivre");
        $stmt->bindValue(":idLivre",$idLivre,PDO::PARAM_INT);
        $nb = $stmt->execute();
        //echo "nb=".$nb."<br>";
        $imageBd = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt->closeCursor();  
        return $imageBd['titre'];
    }
}