<?php
require_once("model/panier.php");
require_once("controllerObjet.php");

class controllerPanier extends controllerObjet {

    protected static string $classe = "Panier";
    protected static string $identifiant = "IDPanier";


    public static function displayOne(){
        $title = "PizzaLand - Panier";
        
        if(isset($_SESSION["loginClient"])){
            $clientConnecte = $_SESSION["IDClient"];

            include("view/debut.php");
            include("view/menu.php");
            $element = Panier::getPanierDeClient($clientConnecte);
            include("view/panier/unPanier.php");
            include("view/fin.php");
        } else {
            echo "Veuillez vous connecter d'abord !";
        }
    }

    public static function addPizzaPanier(){
        $idpizzadefaut = $_GET["IDPizzaDefaut"];
        $clientConnecte = $_SESSION["IDClient"];
        $panierActuel = Panier::getPanierDeClient($clientConnecte);
        $idpanieractuel = $panierActuel->get("IDPanier");
        
        include("view/debut.php");
        include("view/menu.php");
        Panier::addPizzaPanier($idpizzadefaut, $idpanieractuel);
        header("Location: ./index.php");
    }

    public static function removePizzaPanier(){
        $idpizza = $_GET["IDPizza"];
        
        include("view/debut.php");
        include("view/menu.php");
        Panier::removePizzaPanier($idpizza);
        header("Location: ./index.php?objet=panier");
    }

    public static function addProduitPanier(){
        $idproduit = $_GET["IDProduit"];
        $clientConnecte = $_SESSION["IDClient"];
        $panierActuel = Panier::getPanierDeClient($clientConnecte);
        $idpanieractuel = $panierActuel->get("IDPanier");
        
        include("view/debut.php");
        include("view/menu.php");
        Panier::addProduitPanier($idproduit, $idpanieractuel);
        header("Location: ./index.php?objet=Produit");
    }

    public static function removeProduitPanier(){
        $idproduit = $_GET["IDProduit"];
        $clientConnecte = $_SESSION["IDClient"];
        $panierActuel = Panier::getPanierDeClient($clientConnecte);
        $idpanieractuel = $panierActuel->get("IDPanier");
        
        include("view/debut.php");
        include("view/menu.php");
        Panier::removeProduitPanier($idproduit, $idpanieractuel);
        header("Location: ./index.php?objet=panier");
    }

}



?>