<?php
require_once("model/pizzadefaut.php");
require_once("controllerObjet.php");

class controllerPizzaDefaut extends controllerObjet {

    protected static string $classe = "PizzaDefaut";
    protected static string $identifiant = "IDPizzaDefaut";

    public static function listAllergenes(){
        $classeRecup = static::$classe;
        $title = "Les allergènes";
        $identifiant = static::$identifiant;
        
        $valeurIdentifiant = $_GET[$identifiant];

        include("view/debut.php");
        $tableau = static::$classe::listAllergenes($valeurIdentifiant);
        $lapizza = static::$classe::getOne($valeurIdentifiant);
        $pizzanom = $lapizza->get("NomPizzaDefaut"); 
        include("view/allergene/listAllergene.php");
        include("view/fin.php");
    }

    public static function listRecettes(){
        $classeRecup = static::$classe;
        $title = "Les Recettes";
        $identifiant = static::$identifiant;
        
        $valeurIdentifiant = $_GET[$identifiant];

        include("view/debut.php");
        $tableau = static::$classe::listRecettes($valeurIdentifiant);
        $lapizza = static::$classe::getOne($valeurIdentifiant);
        $pizzanom = $lapizza->get("NomPizzaDefaut"); 
        include("view/recette/listRecette.php");
        include("view/fin.php");
    }

    public static function setPizzaDuMoment() {
        $classeRecup = static::$classe;
        $identifiant = static::$identifiant;

        // Récupérer les paramètres de la requête GET
        $idPizza = $_GET[$identifiant];
        $pizzaDuMoment = $_GET['PizzaDuMoment'];

        static::$classe::setPizzaDuMoment($idPizza, $pizzaDuMoment);

        self::displayAll();
    }

    public static function displayCreationForm(){
        $classe = static::$classe;
        $identifiant = static::$identifiant;
        $title = "Création d'une pizza";
        include("view/debut.php");
        $idpizzadefaut = PizzaDefaut::nextID();
        include("view/pizzadefaut/formulaireCreationPizzaDefaut.php");
        include("view/fin.php");
    }

    public static function create(){
        $classe = static::$classe;
        $donnees = array();
        foreach($_POST as $cle => $valeur){
            if($cle != "objet" && $cle != "action" && $cle!= "ImagePizza"){
                $donnees[$cle] = $valeur;
            }
        }
        PizzaDefaut::uploadImage($donnees["IDPizzaDefaut"]);
        static::$classe::create($donnees);
        header("Location: index.php");

        echo "<script>alert('Pizza créée avec succès !');</script>";
    }





}



?>