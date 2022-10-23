<?php

	if(mail("votre mail","sujet test","message test")){
        echo("Mail envoyé");
    } else {
        echo("Mail non envoyé");
    }

?>