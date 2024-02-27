<?php
require_once("objet.php");
class Ingredients extends objet{
    private $IDIngredient;
    private $NomIngredient;
    private $QtIngredientStock;

    public function __construct($IDIngredient, $NomIngredient, $QtIngredientStock) {
        $this->IDIngredient = $IDIngredient;
        $this->NomIngredient = $NomIngredient;
        $this->QtIngredientStock = $QtIngredientStock;
    }

    public function __toString() {
        return "IDIngredient: " . $this->IDIngredient . ", NomIngredient: " . $this->NomIngredient . ", QtIngredientStock: " . $this->QtIngredientStock;
    }

    public static function getAvailableIngredients() {
        $requetePreparee = "SELECT * FROM Ingredient";
        $resultat = connexion::pdo()->query($requetePreparee);
        $resultat->setFetchMode(PDO::FETCH_ASSOC);
        return $resultat->fetchAll();
    }

    public static function getIngredientsForPizza($idPizza) {
        $requetePreparee = "SELECT * FROM Pizza NATURAL JOIN PizzaDefaut NATURAL JOIN Contient NATURAL JOIN Ingredient WHERE IDPizza = :id_tag";
        $resultat = connexion::pdo()->prepare($requetePreparee);
        $tags = array("id_tag" => $idPizza);
        try {
            $resultat->execute($tags);
            $resultat->setFetchMode(PDO::FETCH_ASSOC);
            return $resultat->fetchAll();
        } catch (PDOException $e) {
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }
}
?>