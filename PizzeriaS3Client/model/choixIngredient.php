<?php
require_once("objet.php");
require_once("ingredient.php");
require_once("PizzaDefaut.php");

class ChoixIngredient extends objet {
    protected static string $classe = "ChoixIngredient";
    protected static string $identifiant = "IDChoixIngredient";

    protected int $IDChoixIngredient;
    protected int $IDPanier;
    protected int $IDPizza;

    // constructeur 
    public function __construct(int $IDChoixIngredient = NULL, int $IDPanier = NULL, int $IDPizza = NULL) {
        if(!is_null($IDChoixIngredient)){
            $this->IDChoixIngredient = $IDChoixIngredient;
            $this->IDPanier = $IDPanier;
            $this->IDPizza = $IDPizza;
        }
    }
    public static function getMaxID() {
        $classeRecuperee = "ChoixIngredient";
        $identifiant = "IDChoixIngredient";
        $requete = "SELECT MAX($identifiant) AS max_id FROM $classeRecuperee";
        $resultat = connexion::pdo()->query($requete);
        $maxId = $resultat->fetchColumn();
    
        // Si aucun enregistrement n'existe encore dans la table, initialise l'identifiant à 1
        if ($maxId === false || $maxId === null) {
            return 1;
        }
    
        // Sinon, retourne le prochain identifiant disponible en l'incrémentant de 1
        return $maxId + 1;
    }
    public static function listIngredient($idChoix){
        $requetePreparee = "SELECT * FROM Ingredient NATURAL JOIN contient_ingredients NATURAL JOIN ChoixIngredient WHERE IDChoixIngredient = :idChoix AND contient_ingredients.nbIngredients != 0;";
        $resultat = connexion::pdo()->prepare($requetePreparee);
    
        $tags = array("idChoix" => $idChoix);
        try{
            $resultat->execute($tags);
            $resultat->setFetchmode(PDO::FETCH_CLASS, "Ingredient");
            $tableau = $resultat->fetchAll();
            return $tableau;
        } catch (PDOException $e){
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }
    

}

?>
