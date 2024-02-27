<?php
require_once("model/recette.php");
require_once("controllerObjet.php");

class controllerRecette extends controllerObjet {

    protected static string $classe = "Recette";
    protected static string $identifiant = "IDRecette";
    protected static $champs = array(
        "IDRecette " => ["text", "ID de la recette"],
        "QtIngredientAlerte" => ["text", "ID de la pizzadefaut"],
        "IDIngredient " => ["text", "ID de l'ingrédient"],
        "qtIngredientRecette " => ["text", "La quantité de l'ingrédient dans la recette"]
    );

    public static function __toString() {
        return "controllerRecette";
    }
}