<?php
require_once("model/adherent.php");
require_once("controllerObjet.php");

class controllerAdherent extends controllerObjet {

    protected static string $classe = "adherent";
    protected static string $identifiant = "login";
    protected static $champs = array(
        "login" => ["text", "identifiant"],
        "mdp" => ["text", "mot de passe"],
        "nomAdherent" => ["text", "nom"],
        "prenomAdherent" => ["text", "prénom"],
        "email" => ["email", "email"],
        "telephone" => ["text", "téléphone"]
    );

}



?>