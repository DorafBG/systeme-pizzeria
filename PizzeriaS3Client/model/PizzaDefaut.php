<?php

require_once("objet.php");
require_once("recette.php");
include_once("choixIngredient.php");
class PizzaDefaut extends objet {
    protected static string $classe = "PizzaDefaut";
    protected static string $identifiant = "IDPizzaDefaut";

    // attributs d'une instance de La classe Livre
    protected int $IDPizzaDefaut;
    protected ?string $NomPizzaDefaut;
    protected ?string $DescriptionPizzaDefaut;
    protected ?float $PrixPizzaDefaut;
    protected ?bool $PizzaDuMoment;

    // constructeur 
    public function __construct(int $IDPizzaDefaut = NULL, string $NomPizzaDefaut = NULL, string $DescriptionPizzaDefaut = NULL, float $PrixPizzaDefaut = NULL, bool $PizzaDuMoment = NULL) {
        if(!is_null($IDPizzaDefaut)){
            $this->IDPizzaDefaut = $IDPizzaDefaut;
            $this->NomPizzaDefaut = $NomPizzaDefaut;
            $this->DescriptionPizzaDefaut = $DescriptionPizzaDefaut;
            $this->PrixPizzaDefaut = $PrixPizzaDefaut;
            $this->PizzaDuMoment = $PizzaDuMoment;
        }
    }
    // public static function getIDPizzaDefaut() {
    //     $a = $this->IDPizzaDefaut;
    //     return $a;
    // }


    public static function listRecettes($id){
        $identifiant = "IDPizza";
        $requetePreparee = "SELECT DISTINCT IDRecette, IDPizzaDefaut FROM Pizza NATURAL JOIN PizzaDefaut NATURAL JOIN Recette NATURAL JOIN est_composee NATURAL JOIN Ingredient WHERE $identifiant = :id_tag;";
        $resultat = connexion::pdo()->prepare($requetePreparee);

        $tags = array("id_tag" => $id);
        try{
            $resultat->execute($tags);
            $resultat->setFetchMode(PDO::FETCH_ASSOC);
            $tableau = $resultat->fetchAll();
            return $tableau;
        } catch (PDOException $e){
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }

    public static function getPizzasDePanier($idPanier){
        $requetePreparee = "SELECT * FROM Panier NATURAL JOIN Pizza NATURAL JOIN PizzaDefaut WHERE IDPanier = :id_tag;";
        $resultat = connexion::pdo()->prepare($requetePreparee);

        $tags = array("id_tag" => $idPanier);
        try{
            $resultat->execute($tags);
            $resultat->setFetchMode(PDO::FETCH_ASSOC);
            $tableau = $resultat->fetchAll();
            return $tableau;
        } catch (PDOException $e){
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }

    // méthode _tostring
    public function __toString() {
        return "pizza $this->IDPizzaDefaut ( $this->NomPizzaDefaut )";
    }

    public static function getPizzaDetails($idPizza) {
        $requetePreparee = "SELECT * FROM PizzaDefaut WHERE IDPizzaDefaut = :id_tag";
        $resultat = connexion::pdo()->prepare($requetePreparee);
        $tags = array("id_tag" => $idPizza);
        try {
            $resultat->execute($tags);
            $resultat->setFetchMode(PDO::FETCH_ASSOC);
            return $resultat->fetch();
        } catch (PDOException $e) {
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }

    public static function getOne($id){
        $classeRecuperee = static::$classe;
        $identifiant = "IDPizza";
        $requetePreparee = "SELECT * FROM PizzaDefaut NATURAL JOIN Pizza WHERE $identifiant = :id_tag;";
        $resultat = connexion::pdo()->prepare($requetePreparee);

        $tags = array("id_tag" => $id);
        try{
            $resultat->execute($tags);
            $resultat->setFetchmode(PDO::FETCH_CLASS, "PizzaDefaut");
            $element = $resultat->fetch();
            return $element;
        } catch (PDOException $e){
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }

    public static function getIngredientsForPizza($idPizza) {
        $requetePreparee = "SELECT i.* FROM Ingredient i
                            JOIN est_composee ec ON i.IDIngredient = ec.IDIngredient
                            JOIN Recette r ON ec.IDRecette = r.IDRecette
                            JOIN PizzaDefaut pd ON r.IDPizzaDefaut = pd.IDPizzaDefaut
                            WHERE pd.IDPizzaDefaut = :id_tag";
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

    public static function incremente($idIngredient, $idChoixIngredient){
        $requetePreparee = "UPDATE contient_ingredients SET nbIngredients = nbIngredients + 1 WHERE idIngredient = :idIngredient AND idChoixIngredient = :idChoixIngredient;";
        $resultat = connexion::pdo()->prepare($requetePreparee);
    
        $tags = array('idIngredient' => $idIngredient, 'idChoixIngredient' => $idChoixIngredient);
        try{
            $resultat->execute($tags);
        } catch (PDOException $e){
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }

    public static function decremente($idIngredient, $idChoixIngredient)
    {
        $requetePreparee = "UPDATE contient_ingredients NATURAL JOIN ChoixIngredient SET nbIngredients = nbIngredients - 1 WHERE idIngredient = :idIngredient AND idChoixIngredient = :idChoixIngredient;";
        $resultat = connexion::pdo()->prepare($requetePreparee);
    
        $tags = array('idIngredient' => $idIngredient, 'idChoixIngredient' => $idChoixIngredient);
        try {
            $resultat->execute($tags);
        } catch (PDOException $e) {
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }
    public static function insert($idIngredient, $idChoixIngredient, $nbIngredients)
    {
        $classeRecuperee = static::$classe;
        $requetePreparee = "INSERT INTO contient_ingredients VALUES (:idIngredient, :idChoixIngredient, :nbIngredients);";
        $resultat = connexion::pdo()->prepare($requetePreparee);

        $tags = array('idIngredient' => $idIngredient, 'idChoixIngredient' => $idChoixIngredient, 'nbIngredients' => $nbIngredients);
        try {
            $resultat->execute($tags);
        } catch (PDOException $e) {
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }


    public static function getChoixIngredient($idPizza, $idPanier)
    {
        $requetePreparee = "SELECT IDChoixIngredient FROM ChoixIngredient NATURAL JOIN Panier WHERE IDPanier = :idPanier AND IDPizza = :idPizza;";
        $resultat = connexion::pdo()->prepare($requetePreparee);
    
        $tags = array('idPanier' => $idPanier, 'idPizza' => $idPizza);
        try {
            $resultat->execute($tags);
            $element = $resultat->fetchColumn();

            if ($element === null || $element === false || $element === "") {
                $idChoixIngredient = ChoixIngredient::getMaxID();
                $requetePreparee = "INSERT INTO ChoixIngredient VALUES (:idChoixIngredient, :idPanier, :idPizza);";
                $resultat = connexion::pdo()->prepare($requetePreparee);
    
                $tags2 = array('idChoixIngredient' => $idChoixIngredient, 'idPanier' => $idPanier, 'idPizza' => $idPizza);
                $resultat->execute($tags2);
                return $idChoixIngredient;
            } else {
                return $element;
            }
        } catch (PDOException $e) {
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }

    public static function checkIdChoixIngredient($idChoix, $idIngredient)
    {
        $requetePreparee = "SELECT * FROM ChoixIngredient NATURAL JOIN contient_ingredients WHERE IDChoixIngredient = :id_tag AND IDIngredient = :idIngredient;";
        $resultat = connexion::pdo()->prepare($requetePreparee);
        $tags = array("id_tag" => $idChoix, "idIngredient" => $idIngredient);
        try {
            $resultat->execute($tags);
            $resultat->setFetchMode(PDO::FETCH_ASSOC);
            $row = $resultat->fetch();
            return $row !== false;
        } catch (PDOException $e) {
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }
    
        
}
    
?>