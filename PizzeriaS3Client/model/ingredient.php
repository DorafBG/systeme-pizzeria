<?php
require_once("objet.php");
class ingredient extends objet {

protected static string $classe = "Ingredient";
protected static string $identifiant = "IDIngredient";

protected int $IDIngredient ;
protected string $NomIngredient;
protected ?int $QtIngredientStock;

// constructeur 
public function __construct(int $IDIngredient = NULL, string $NomIngredient = NULL, int $QtIngredientStock = NULL) {
    if(!is_null($IDIngredient)){
        $this->IDIngredient = $IDIngredient;
        $this->NomIngredient = $NomIngredient;
        $this->QtIngredientStock = $QtIngredientStock;
    }



}

public function getNomIngredient() {
    return $this->NomIngredient;
}

public function getIDIngredient() {
    return $this->IDIngredient;
}

public function __toString() {
    return "$this->NomIngredient $this->QtIngredientStock";

}

}

?>