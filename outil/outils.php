<?php

function sendMail($destinataire, $sujet, $message){
    //$headers = "From: xxxxx@gmail.com";
    //if(mail($destinataire,$sujet,$message,$headers)){
    if(mail($destinataire,$sujet,$message)){
        echo("Mail envoyé");
    } else {
        echo("Mail non envoyé");
    }
}
    
function afficherTableau($tab,$titre){
    echo "<hr>";
    echo "<p>Tableau ".$titre."</p>";
    echo "<pre>";
    print_r($tab);
    echo "</pre>";
    echo "<hr>";
}

function afficherChaine($chaine, $titre){
    echo "<p>".$titre."</p>";
    echo "Chaine = ". $chaine . "<br>";
    echo "<hr>";
}

function ajouterImage($file, $dir){
    $random = rand(0,99999);
    $target_file = $dir.$random."_".$file['name'];
    move_uploaded_file($file['tmp_name'], $target_file);
    return $random."_".$file['name'];
}

function sousChaineTaille($chaine,$taille){
    if(strlen($chaine) >= $taille)
        $sousChaine = substr($chaine, 0, $taille)."...";
    else {
        $bouchon = str_repeat(" ", $taille-strlen($chaine));
        $sousChaine = $chaine;
    }
    return $sousChaine;
}
?>