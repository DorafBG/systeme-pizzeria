<?php
    require_once("model/produit.php");
    require_once("controllerObjet.php");
    class controllerProduit extends controllerObjet
    {
        protected static string $classe = "Produit";
        protected static string $identifiant = "IDProduit";

        public static function displayAll()
        {
            $classeRecup = static::$classe;
            $title = "PizzaLand - Produits";;
            include("view/debut.php");
            include("view/menu.php");
            $tableau = static::$classe::getAll();
            include("view/produits/listProduit.php");
            include("view/fin.php");
        }

        public static function listTypeProduit(){
            $classeRecup = static::$classe;
            $title = "Les Types de Produits";
            $valeurIdentifiant = $_GET["TypeProduit"]; 
            include("view/debut.php");
            include("view/menu.php");
            $tableau = static::$classe::getTypeProduit($valeurIdentifiant);
            include("view/typeProduit/listTypeProduit.php");
            include("view/fin.php");
        }

        
    }
    
?>