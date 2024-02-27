<?php
require_once("objet.php");
class alerte extends objet {

protected static string $classe = "Alerte";
protected static string $identifiant = "IDAlerte";

protected int $IDAlerte ;
protected ?int $QtIngredientAlerte;
protected ?int $IDIngredient ;

// constructeur 
public function __construct(int $IDAlerte = NULL, int $QtIngredientAlerte = NULL, int $IDIngredient = NULL) {
    if(!is_null($IDAlerte)){
        $this->IDAlerte = $IDAlerte;
        $this->QtIngredientAlerte = $QtIngredientAlerte;
        $this->IDIngredient = $IDIngredient;
    }



}

// méthode _tostring

public function __toString() {
    return "Alerte n°$this->IDAlerte <b>(Seuil [$this->QtIngredientAlerte] pour ingredient n°$this->IDIngredient)</b>";

}

}

?>