<?php
require_once("model/ingredient.php");
require_once("controllerObjet.php");

class controllerIngredient extends controllerObjet {

    protected static string $classe = "Ingredient";
    protected static string $identifiant = "IDIngredient";

    public static function incremente(){
        $classeRecup = static::$classe;
        $identifiant = static::$identifiant;
        $valeurIdentifiant = $_GET[$identifiant];

        static::$classe::incremente($valeurIdentifiant);
        self::displayAll();
    }

    public static function decremente(){
        $classeRecup = static::$classe;
        $identifiant = static::$identifiant;
        $valeurIdentifiant = $_GET[$identifiant];

        static::$classe::decremente($valeurIdentifiant);
        self::displayAll();
    }

}



?>