<?php

class controllerObjet {

    public static function displayAll(){
        $classeRecup = static::$classe;
        $title = "les " . static::$classe . "s"; //les adherent s ou serie s
        include("view/debut.php");
        include("view/menu.php");
        $tableau = static::$classe::getAll();
        include("view/list.php");
        
        include("view/fin.php");
    }

    
    public static function displayOne(){
        $classeRecup = static::$classe;
        $title = "un(e) " . static::$classe; //les adherent s ou serie s
        $identifiant = static::$identifiant;
        
        $valeurIdentifiant = $_GET[$identifiant];

        include("view/debut.php");
        include("view/menu.php");
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

}


?>