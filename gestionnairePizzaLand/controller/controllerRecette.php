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

    public static function displayCreationForm(){
        $champs = static::$champs;
        $classe = static::$classe;
        $identifiant = static::$identifiant;
        $title = "Création d'une recette";
        include("view/debut.php");
        include("view/recette/formulaireCreationRecette.php");
        include("view/fin.php");
    }

    public static function create(){
        $champs = static::$champs;
        $classe = static::$classe;
        $donnees = array();
        foreach($_GET as $cle => $valeur){
            if($cle != "objet" && $cle != "action"){
                $donnees[$cle] = $valeur;
            }
        }

        static::$classe::create($donnees);

        echo "<script>alert('Recette créée avec succès !');</script>";
        echo "<script> window.close();  </script>";
    }

    public static function delete(){
        $classeRecup = static::$classe;
        $identifiant = static::$identifiant;
        $valeurIdentifiant = $_GET[$identifiant];

        static::$classe::delete($valeurIdentifiant);
        echo "<script>alert('Recette supprimée avec succès !');</script>";
        echo "<script> window.close();  </script>";
    }
    
    
}



?>