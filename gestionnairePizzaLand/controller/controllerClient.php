<?php
require_once("model/client.php");
require_once("controllerObjet.php");
require_once("controllerPizzaDefaut.php");

class controllerClient extends controllerObjet {

    protected static string $classe = "Client";
    protected static string $identifiant = "IDClient";

    public static function displayConnectionForm(){
        $classe = static::$classe;
        $identifiant = static::$identifiant;
        $title = "PizzaLandGestion - Connexion";
        include("view/debut.php");
        include("view/formulaireConnexion.html");
        include("view/fin.php");
    }

    
    public static function connect(){
        $classeRecup = static::$classe;
        $login = $_GET["loginClient"];
        $mdp = $_GET["mdpClient"];
    
        if(static::$classe::checkMDP($login, $mdp)){
            if($login == 'admin'){
                $_SESSION["login"] = $login;
                // Redirection vers index.php
                header("Location: index.php");
                exit(); 
            } else {
                self::displayConnectionForm();
            }
        } else {
            self::displayConnectionForm();
        }
    }

    public static function disconnect(){
        session_unset();
        session_destroy();
        setcookie(session_name(), '', time()-1);
        self::displayConnectionForm();
    }
    



}



?>