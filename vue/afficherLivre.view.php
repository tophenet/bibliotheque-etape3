<?php 
ob_start(); 
?>
<br>
<div class="row">
    <div class="col-4">
        <img  style="width:80%; height:auto" src="public/images/<?= $livre->getImage(); ?>">
    </div>
    <div class="col-8">
        <br>
        <h3>Nombre de pages : <?= $livre->getNbPages(); ?></h3>
        <br>
        <h3>Nombre d'exemplaire disponible : <?= $livre->getNb(); ?></h3>
        <br>
        <h3>Description :</h3> 
        <p><?= $livre->getDescription(); ?></p>
    </div>
</div>

<?php
$content = ob_get_clean();
$titre = $livre->getTitre();
require "template.view.php";
?>