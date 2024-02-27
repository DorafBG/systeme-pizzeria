<?php
require_once("model/PizzaDefaut.php");
require_once("controllerObjet.php");

class controllerPizzaDefaut extends controllerObjet {

    protected static string $classe = "PizzaDefaut";
    protected static string $identifiant = "IDPizzaDefaut";

    public static function displayAll(){
        $classeRecup = static::$classe;
        $title = "PizzaLand - Accueil";
        include("view/debut.php");
        include("view/menu.php");
        $tableau = static::$classe::getAll();
        include("view/pizzadefaut/listPizzaDefaut.php");
        include("view/fin.php");
        

    }

    public static function getPizzaDetails($idPizza) {
        $pizzaDetails = PizzaDefaut::getPizzaDetails($idPizza);
        // Vous pouvez manipuler les données ici si nécessaire avant de les retourner
        return $pizzaDetails;
    }

    public static function listRecettes(){
        $classeRecup = static::$classe;
        $title = "Les Recettes";
        $valeurIdentifiant = $_GET['IDPizza'];
        include("view/debut.php");
        include("view/menu.php");
        $tableau = PizzaDefaut::listRecettes($valeurIdentifiant);
        $lapizza = PizzaDefaut::getOne($valeurIdentifiant);
        include("view/modif/listModif.php");
        include("view/fin.php");
    }
    public static function incremente(){
        $idChoixIngredients = $_GET['IDChoixIngredient'];
        $idIngredient = $_GET['IDIngredient'];
        PizzaDefaut::incremente($idIngredient, $idChoixIngredients);
        self::listRecettes(); 
    }

    public static function decremente(){
        $idChoixIngredients = $_GET['IDChoixIngredient'];
        $idIngredient = $_GET['IDIngredient'];
        PizzaDefaut::decremente($idIngredient, $idChoixIngredients);
        self::listRecettes();
    }

    public static function ajout()
    {
        $nbIngredients = 1;
        $idIngredient = $_GET['IDIngredient'];
        $idChoixIngredients = $_GET['IDChoixIngredient'];
        if(PizzaDefaut::checkIdChoixIngredient($idChoixIngredients, $idIngredient) === false)PizzaDefaut::insert($idIngredient, $idChoixIngredients,$nbIngredients);
        else PizzaDefaut::incremente($idIngredient, $idChoixIngredients);

        self::listRecettes();
    }

    public static function getChoixIngredient()
    {
        $idPizza = $_GET['IDPizza'];
        $idPanier = $_GET['IDPanier'];
        $choixIngredient = PizzaDefaut::getChoixIngredient($idPizza, $idPanier);
        return $choixIngredient;
    }
    public static function retrait()
    {
        $idIngredient = $_GET['IDIngredient'];
        $nbIngredients = -1;
        $idChoixIngredients = $_GET['IDChoixIngredient'];
        if(PizzaDefaut::checkIdChoixIngredient($idChoixIngredients, $idIngredient) === false)PizzaDefaut::insert($idIngredient, $idChoixIngredients, $nbIngredients);
        else PizzaDefaut::decremente($idIngredient,$idChoixIngredients);
        self::listRecettes();
    }
}



?>