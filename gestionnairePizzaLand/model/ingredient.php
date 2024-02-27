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

public static function incremente($id){
    $classeRecuperee = static::$classe;
    $identifiant = static::$identifiant;
    $requetePreparee = "UPDATE $classeRecuperee SET QtIngredientStock = QtIngredientStock + 1 WHERE $identifiant = :id_tag;";
    $resultat = connexion::pdo()->prepare($requetePreparee);

    $tags = array("id_tag" => $id);
    try{
        $resultat->execute($tags);
        $resultat->setFetchmode(PDO::FETCH_CLASS, $classeRecuperee);
        $element = $resultat->fetch();
        return $element;
    } catch (PDOException $e){
        echo $e->getMessage();
    }
}

public static function decremente($id){
    $classeRecuperee = static::$classe;
    $identifiant = static::$identifiant;
    $requetePreparee = "UPDATE $classeRecuperee SET QtIngredientStock = QtIngredientStock - 1 WHERE $identifiant = :id_tag;";
    $resultat = connexion::pdo()->prepare($requetePreparee);

    $tags = array("id_tag" => $id);
    try{
        $resultat->execute($tags);
        $resultat->setFetchmode(PDO::FETCH_CLASS, $classeRecuperee);
        $element = $resultat->fetch();
        return $element;
    } catch (PDOException $e){
        echo $e->getMessage();
    }
}

// méthode _tostring

public function __toString() {
    return "$this->NomIngredient $this->QtIngredientStock";

}

}

?>