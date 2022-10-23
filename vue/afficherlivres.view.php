<?php ob_start()?>
<?php //require_once "model/LivreManager.php"; ?>
<?php //afficherTableau($tabLivres,"tabLivres"); ?>

<div class="container">
    <table class="table table-striped">
      <thead>
        <tr>
        <th scope="col">Id</th>
          <th scope="col">Image</th>
          <th scope="col">Titre</th>
          <th scope="col">Disponible</th>
          <th scope="col">Nombre de pages</th>
          <th scope="col" colspan="3">Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($tabLivres as $livre) { ?>
          <tr class="align-middle">
            <td scope="row"><?php echo $livre->getId(); ?></td>
            <td><img width="80" src="public/images/<?php echo $livre->getImage(); ?>"></td>
            <td><?php echo $livre->getTitre(); ?></td>
            <td><?php echo $livre->getNb(); ?></td>
            <td><?php echo $livre->getNbPages(); ?></td>
            <td><a href="index.php?action=lire&id=<?= $livre->getId(); ?>" class="btn btn-info">Lire</a></td>
            <td><a href="index.php?action=modifier&id=<?= $livre->getId(); ?>" class="btn btn-warning">Modifier</a></td>
            <td><a href="index.php?action=suppr&id=<?= $livre->getId(); ?>" class="btn btn-danger">Supprimer</a></td>
          </tr>
        <?php } ?>
      </tbody>
    </table> 
</div> 
<?php
    $content=ob_get_clean();
    $titre = "Liste des livres de la bibliothéque";
    require "template.view.php";
?>