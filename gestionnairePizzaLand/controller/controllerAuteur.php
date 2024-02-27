<?php
require_once("model/auteur.php");
require_once("controllerObjet.php");

class controllerAuteur extends controllerObjet {

    protected static string $classe = "auteur";
    protected static string $identifiant = "numAuteur";
}

?>