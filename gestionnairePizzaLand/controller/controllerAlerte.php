<?php
require_once("model/alerte.php");
require_once("controllerObjet.php");

class controllerAlerte extends controllerObjet {

    protected static string $classe = "Alerte";
    protected static string $identifiant = "IDAlerte";
    protected static $champs = array(
        "IDAlerte " => ["text", "ID de l'alerte"],
        "QtIngredientAlerte" => ["text", "Quantité d'ingrédients de l'alerte"],
        "IDIngredient " => ["text", "ID de l'ingrédient"]
    );

    public static function displayCreationForm(){
        $champs = static::$champs;
        $classe = static::$classe;
        $identifiant = static::$identifiant;
        $title = "création ".$classe;
        include("view/debut.php");
        include("view/menu.html");
        include("view/alerte/formulaireCreationAlerte.php");
        include("view/fin.php");
    }
}



?>