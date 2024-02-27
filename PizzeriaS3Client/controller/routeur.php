<?php
require_once("model/session.php");
$objet = "PizzaDefaut"; //default value
$objets = ["PizzaDefaut", "Produit", "Client", "client", "panier", "Panier", "paiement", "Paiement"]; //objets possibles 

$actions = ["displayAll", "displayOne" ,"listTypeProduit","create", "update", "delete","displayHistorique", "connect", "deconnect", "inscription", "connexion", "deconnexion", "displayConnectionForm", "createAccount", "addPizzaPanier", "addProduitPanier", "removePizzaPanier", "removeProduitPanier", "listRecettes", "incremente", "decremente", "displayAllPizzaDefaut", "displayOnePizzaDefaut", "displayAllProduit", "displayOneProduit", "displayAllClient", "displayOneClient", "displayAllPanier", "displayOnePanier", "ajout", "retrait", "displayPaiement", "displayProfil","displayEditProfil","displayApropos"];
$action = "displayAll";
$formulaire;
if(isset($_GET["objet"]) && in_array($_GET["objet"], $objets)){
    $objet = $_GET["objet"]; 
}

//Si l'objet appelé est panier, l'action par défaut est displayOne (pas displayAll)
if($objet == "panier"){
    $action = "displayOne";
}

//Si l'objet appelé est paiement, l'action par défaut est displayPaiement (pas displayAll)
if($objet == "paiement"){
    $action = "displayPaiement";
}

if(isset($_GET["action"]) && in_array($_GET["action"], $actions)){
    $action = $_GET["action"]; 
}
if(isset($_GET["formulaire"])){
    $formulaire = $_GET["formulaire"]; 
}

if($objet == "panier"){

    if(!Session::clientConnected() && !Session::clientConnecting()){
        $objet = "client";
        $action = "displayConnectionForm";
    }

}

$controller = "controller".ucfirst($objet);
require_once("controller/controllerObjet.php");
require_once("controller/$controller.php");
require_once("config/connexion.php");
connexion::connect();
$controller::$action();
?>

