<?php
require_once("objet.php");
require_once("PizzaDefaut.php");
class Recette extends objet {

protected static string $classe = "Recette";
protected static string $identifiant = "IDRecette";

protected int $IDRecette ;
protected ?int $IDPizzaDefaut;

// constructeur 
public function __construct(int $IDRecette = NULL, int $IDPizzaDefaut = NULL) {
    if(!is_null($IDRecette)){
        $this->IDRecette = $IDRecette;
        $this->IDPizzaDefaut = $IDPizzaDefaut;
    }



}

public static function create($donnees) {
    $classeRecuperee = static::$classe;

    $recetteQuery = "INSERT INTO Recette(`IDPizzaDefaut`, `IDRecette`) VALUES (:IDPizzaDefaut, :IDRecette);";
    $recetteResult = connexion::pdo()->prepare($recetteQuery);
    $tags = array("IDPizzaDefaut" => $donnees['IDPizzaDefaut'], "IDRecette" => $donnees['IDRecette']);

    try {
        $recetteResult->execute($tags);
    } catch (PDOException $e) {
        echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        return false; // Handle the error as needed
    }


    $idRecette = $donnees['IDRecette'];
    if (isset($donnees['IDIngredient']) && isset($donnees['qtIngredientRecette'])) {
        $ingredients = $donnees['IDIngredient'];
        $quantites = $donnees['qtIngredientRecette'];

        foreach ($ingredients as $key => $ingredientID) {
            $ingredientQuery = "INSERT INTO est_composee(`IDIngredient`, `IDRecette`, `qtIngredientRecette`) VALUES (:IDIngredient, :IDRecette, :qtIngredientRecette);";
            $ingredientResult = connexion::pdo()->prepare($ingredientQuery);

            try {
                $ingredientResult->execute([
                    'IDIngredient' => $ingredientID,
                    'IDRecette' => $idRecette,
                    'qtIngredientRecette' => $quantites[$key]
                ]);
            } catch (PDOException $e) {
                echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
                return false; 
            }
        }
    }

    return true;
}



public static function nextID() {
    $requetePreparee = "SELECT MAX(IDRecette) AS maxID FROM Recette;";
    
    $resultat = connexion::pdo()->query($requetePreparee);

    try {
        $maxID = $resultat->fetchColumn();
        // If no records exist yet, set the initial ID to 1
        return $maxID === false ? 1 : $maxID + 1;
    } catch (PDOException $e) {
        echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
    }
}



public static function listIngredient($id){
    $requetePreparee = "SELECT IDIngredient, NomIngredient, QtIngredientStock FROM PizzaDefaut NATURAL JOIN Recette NATURAL JOIN est_composee NATURAL JOIN Ingredient WHERE IDRecette = :id_tag;";
    $resultat = connexion::pdo()->prepare($requetePreparee);

    $tags = array("id_tag" => $id);
    try{
        $resultat->execute($tags);
        $resultat->setFetchmode(PDO::FETCH_CLASS, "Ingredient");
        $tableau = $resultat->fetchAll();
        return $tableau;
    } catch (PDOException $e){
        echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
    }
}

public static function quantiteDeLingredientDansLaRecette($idrecette, $idingredient) {
    $requetePreparee = "SELECT qtIngredientRecette FROM PizzaDefaut 
                        NATURAL JOIN Recette 
                        NATURAL JOIN est_composee 
                        NATURAL JOIN Ingredient 
                        WHERE IDRecette = :idrecette AND IDIngredient = :idingredient;";
    
    $resultat = connexion::pdo()->prepare($requetePreparee);

    $tags = array("idrecette" => $idrecette, "idingredient" => $idingredient);

    try {
        $resultat->execute($tags);
        $quantite = $resultat->fetchColumn();
        return $quantite;
    } catch (PDOException $e) {
        echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
    }
}

public static function quantiteDeLingredientDansLeContient($idPizza, $idIngredient)
{
    $requetePreparee = "SELECT nbIngredients FROM contient_ingredients NATURAL JOIN Ingredient NATURAL JOIN ChoixIngredient NATURAL JOIN Pizza WHERE IDPizza = :idPizza AND IDIngredient = :idIngredient;";
    $resultat = connexion::pdo()->prepare($requetePreparee);
    $tags = array(":idPizza"=> $idPizza,
                    ":idIngredient"=> $idIngredient);
    try{
        $resultat->execute($tags);
        $element = $resultat->fetchColumn();
        return $element;
    } catch (PDOException $e){
        echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
    }
}

// méthode _tostring

public function __toString() {
    return "Recette n°$this->IDRecette (Pour la pizza n°$this->IDPizzaDefaut)";

}

}

?>