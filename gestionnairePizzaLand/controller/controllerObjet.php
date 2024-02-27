<?php

class controllerObjet {

    public static function displayAll(){
        $classeRecup = static::$classe;
        $title = "PizzaLandGestion - Les " . static::$classe . "s"; //les adherent s ou serie s
        include("view/debut.php");
        include("view/menu.html");
        $tableau = static::$classe::getAll();
        if($classeRecup == "Ingredient"){
            include("view/ingredient/listIngredient.php");
        } else  if($classeRecup == "PizzaDefaut"){
            include("view/pizzadefaut/listPizzaDefaut.php");
        } else if($classeRecup == "Alerte"){
            include("view/alerte/listAlerte.php");
        } else {
            include("view/list.php");
        }
        
        include("view/fin.php");
    }

    
    public static function displayOne(){
        $classeRecup = static::$classe;
        $title = "un(e) " . static::$classe; //les adherent s ou serie s
        $identifiant = static::$identifiant;
        
        $valeurIdentifiant = $_GET[$identifiant];

        include("view/debut.php");
        include("view/menu.html");
        $element = static::$classe::getOne($valeurIdentifiant);
        include("view/details.php");
        include("view/fin.php");
    }

    public static function delete(){
        $classeRecup = static::$classe;
        $identifiant = static::$identifiant;
        $valeurIdentifiant = $_GET[$identifiant];

        static::$classe::delete($valeurIdentifiant);
        self::displayAll();
    }

    public static function displayCreationForm(){
        $champs = static::$champs;
        $classe = static::$classe;
        $identifiant = static::$identifiant;
        $title = "création ".$classe;
        include("view/debut.php");
        include("view/menu.html");
        include("view/formulaireCreation.php");
        include("view/fin.php");
    }

    public static function update(){
        $classeRecup = static::$classe;
        $identifiant = static::$identifiant;
        $valeurIdentifiant = $_GET[$identifiant];
        $valeurAttribut = $_GET["attribut"];
        $valeurnouvelleValeur = $_GET["nouvelleValeur"];

        static::$classe::update($valeurIdentifiant, $valeurAttribut, $valeurnouvelleValeur);
        self::displayAll();
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
        self::displayAll();
    }



}


?>