<?php
    require_once("model/session.php");

    $objet = "PizzaDefaut"; //default value
    $objets = ["PizzaDefaut", "Ingredient", "alerte", "Alerte", "recette", "Recette" , "stats", "Stats", "Client", "client"]; //objets possibles 
    $formulaires = ["alerte", "recette"];
    
    $actions = ["displayAll", "displayOne", "delete", "displayCreationForm", "incremente", "decremente", "update", "listAllergenes", "listRecettes", "create", "setPizzaDuMoment", "displayConnectionForm", "connect", "disconnect"]; //actions possibles
    $action = "displayAll";
    $formulaire;


    if(isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        // La requête est une méthode POST
        if(isset($_POST["objet"]) && in_array($_POST["objet"], $objets)){
            $objet = $_POST["objet"]; 
        }
        if(isset($_POST["action"]) && in_array($_POST["action"], $actions)){
            $action = $_POST["action"]; 
        }
    } else {
        if(isset($_GET["objet"]) && in_array($_GET["objet"], $objets)){
            $objet = $_GET["objet"]; 
        }
        if(isset($_GET["action"]) && in_array($_GET["action"], $actions)){
            $action = $_GET["action"]; 
        }

    }



    if(!session::adminConnected() && !session::adherentConnecting()){
        $action = "displayConnectionForm";
        $objet = "client";
    }
    
    $controller = "controller".ucfirst($objet);
    require_once("controller/controllerObjet.php");
    require_once("controller/$controller.php");
    require_once("config/connexion.php");
    
    connexion::connect();
    $controller::$action();
    ?>