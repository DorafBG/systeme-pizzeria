<?php
require_once("model/choixIngredient.php");
require_once("controllerObjet.php");

class ControllerChoixIngredient extends controllerObjet
{
    protected static $champs = [
        'IDChoixIngredient' => ['text', 'Identifiant choix ingredient'],
        'IDPanier' => ['text', 'identifiant panier'],
        'IDPizza' => ['text', 'identifiant pizza']
    ];

    public static function ajout(){
        $champs = static::$champs;
        $classe = static::$classe;
        $donnees = array();
        foreach($_GET as $cle => $valeur){
            if($cle != "objet" && $cle != "action"){
                $donnees[$cle] = $valeur;
            }
        }
        static::$classe::ajout($donnees);
    }
}
?>