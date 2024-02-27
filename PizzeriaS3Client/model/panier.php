<?php

require_once("objet.php");
class Panier extends objet{

protected static string $classe = "Panier";
protected static string $identifiant = "IDPanier";

protected int $IDPanier;
protected ?bool $estCommande;
protected ?int $IDClient;

// constructeur 
public function __construct(int $IDPanier = NULL, bool $estCommande = NULL, int $IDClient = NULL) {
    if(!is_null($IDPanier)){
        $this->IDPanier = $IDPanier;
        $this->estCommande = $estCommande;
        $this->IDClient = $IDClient;
    }


}

public static function nbElementsDansPanier($idpanier){
    $panierProduitsQuery = "SELECT SUM(quantite) AS NombreProduits FROM Panier NATURAL JOIN possede WHERE IDPanier = :IDPanier;";
    $panierPizzasQuery = "SELECT COUNT(IDPizza) AS NombrePizzas FROM Panier NATURAL JOIN Pizza WHERE IDPanier = :IDPanier;";

    $panierProduitsResult = connexion::pdo()->prepare($panierProduitsQuery);
    $panierPizzasResult = connexion::pdo()->prepare($panierPizzasQuery);

    $tags = array("IDPanier" => $idpanier);

    try {
        $panierProduitsResult->execute($tags);
        $panierProduitsResult->setFetchMode(PDO::FETCH_ASSOC);
        $nbProduits = $panierProduitsResult->fetchColumn();

        $panierPizzasResult->execute($tags);
        $panierPizzasResult->setFetchMode(PDO::FETCH_ASSOC);
        $nbPizzas = $panierPizzasResult->fetchColumn();

        $nbElements = $nbProduits + $nbPizzas;

        return $nbElements;

    } catch (PDOException $e) {
        echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        return false; 
    }
}



public static function nextIdPizza() {
    $classeRecuperee = "Pizza";
    $identifiant = "IDPizza";
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

public static function addPizzaPanier($idpizzadefaut, $idpanier){
    $classeRecuperee = static::$classe;
    $idpizzasuivant = self::nextIdPizza();
    $estCuisine = 0;

    $pizzaQuery = "INSERT INTO Pizza(`IDPizza`, `IDPanier`, `IDPizzaDefaut`, `estCuisine`) VALUES (:IDPizza, :IDPanier, :IDPizzaDefaut, :estCuisine);";
    $pizzaResult = connexion::pdo()->prepare($pizzaQuery);
    $tags = array("IDPizza" => $idpizzasuivant, "IDPanier" => $idpanier ,"IDPizzaDefaut" => $idpizzadefaut, "estCuisine" => $estCuisine);

    try {
        $pizzaResult->execute($tags);
    } catch (PDOException $e) {
        echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        return false; 
    }
}

public static function removePizzaPanier($idpizza){
    $classeRecuperee = static::$classe;

    $pizzaQuery = "DELETE FROM Pizza WHERE IDPizza = :IDPizza;";
    $pizzaResult = connexion::pdo()->prepare($pizzaQuery);
    $tags = array("IDPizza" => $idpizza);

    try {
        $pizzaResult->execute($tags);
    } catch (PDOException $e) {
        echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        return false; 
    }
}

public static function addProduitPanier($idproduit, $idpanier){
    $classeRecuperee = static::$classe;

    $checkQuery = "SELECT * FROM possede WHERE IDProduit = :IDProduit AND IDPanier = :IDPanier";
    $checkResult = connexion::pdo()->prepare($checkQuery);
    $tags = array("IDProduit" => $idproduit, "IDPanier" => $idpanier);

    try {
        $checkResult->execute($tags);
        $existingRow = $checkResult->fetch(PDO::FETCH_ASSOC);

        if ($existingRow) {
            $updateQuery = "UPDATE possede SET quantite = quantite + 1 WHERE IDProduit = :IDProduit AND IDPanier = :IDPanier";
            $updateResult = connexion::pdo()->prepare($updateQuery);
            $updateResult->execute($tags);
        } else {
            $insertQuery = "INSERT INTO possede(`IDProduit`, `IDPanier`) VALUES (:IDProduit, :IDPanier);";
            $insertResult = connexion::pdo()->prepare($insertQuery);
            $insertResult->execute($tags);
        }

    } catch (PDOException $e) {
        echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        return false; 
    }
}


public static function removeProduitPanier($idproduit, $idpanier){
    $classeRecuperee = static::$classe;

    $checkQuery = "SELECT * FROM possede WHERE IDProduit = :IDProduit AND IDPanier = :IDPanier";
    $checkResult = connexion::pdo()->prepare($checkQuery);
    $tags = array("IDProduit" => $idproduit, "IDPanier" => $idpanier);

    try {
        $checkResult->execute($tags);
        $existingRow = $checkResult->fetch(PDO::FETCH_ASSOC);

        if ($existingRow) {
            if ($existingRow['quantite'] > 1) {
                $updateQuery = "UPDATE possede SET quantite = quantite - 1 WHERE IDProduit = :IDProduit AND IDPanier = :IDPanier";
                $updateResult = connexion::pdo()->prepare($updateQuery);
                $updateResult->execute($tags);
            } else {
                $deleteQuery = "DELETE FROM possede WHERE IDProduit = :IDProduit AND IDPanier = :IDPanier";
                $deleteResult = connexion::pdo()->prepare($deleteQuery);
                $deleteResult->execute($tags);
            }
        }

    } catch (PDOException $e) {
        echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        return false; 
    }
}



public static function getPanierDeClient($idClient){
    $requetePreparee = "SELECT * FROM Panier WHERE IDClient = :id_tag AND estCommande = 0 ORDER BY IDPanier DESC LIMIT 1;";
    $resultat = connexion::pdo()->prepare($requetePreparee);

    $tags = array("id_tag" => $idClient);
    try{
        $resultat->execute($tags);
        $resultat->setFetchmode(PDO::FETCH_CLASS, "Panier");
        $element = $resultat->fetch();
        return $element;
    } catch (PDOException $e){
        echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
    }
}



public static function getPrixTotalPanier($idPanier)
{
    $requetePreparee = "SELECT prixTotal(:idPanier) AS total;";
    $resultat = connexion::pdo()->prepare($requetePreparee);

    $tags = array("idPanier" => $idPanier);
    try {
        $resultat->execute($tags);
        $total = $resultat->fetch(PDO::FETCH_ASSOC)["total"];
        return $total;
    } catch (PDOException $e) {
        echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
    }
}

// méthode _tostring

public function __toString() {
return "Panier n°$this->IDPanier ( du client n°$this->IDClient ) -> commandé ? : $this->estCommande";
}



}

?>