<?php

require_once("objet.php");
require_once("allergene.php");
require_once("recette.php");
class pizzadefaut extends objet{

protected static string $classe = "PizzaDefaut";
protected static string $identifiant = "IDPizzaDefaut";

protected string $IDPizzaDefaut;
protected string $NomPizzaDefaut;
protected ?string $DescriptionPizzaDefaut;
protected ?float $PrixPizzaDefaut;
protected ?bool $PizzaDuMoment;

// constructeur 
public function __construct(string $IDPizzaDefaut = NULL, string $NomPizzaDefaut = NULL, string $DescriptionPizzaDefaut = NULL, float $PrixPizzaDefaut = NULL, string $email = NULL, bool $PizzaDuMoment = NULL) {
    if(!is_null($IDPizzaDefaut)){
        $this->IDPizzaDefaut = $IDPizzaDefaut;
        $this->NomPizzaDefaut = $NomPizzaDefaut;
        $this->DescriptionPizzaDefaut = $DescriptionPizzaDefaut;
        $this->PrixPizzaDefaut = $PrixPizzaDefaut;
        $this->PizzaDuMoment = $PizzaDuMoment;
    }


}

public static function nextID() {
    $requetePreparee = "SELECT MAX(IDPizzaDefaut) AS maxID FROM PizzaDefaut;";
    
    $resultat = connexion::pdo()->query($requetePreparee);

    try {
        $maxID = $resultat->fetchColumn();
        return $maxID === false ? 1 : $maxID + 1;
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

public static function listAllergenes($id){
    $classeRecuperee = static::$classe;
    $identifiant = static::$identifiant;
    $requetePreparee = "SELECT * FROM Allergene NATURAL JOIN recette_comprend NATURAL JOIN Recette NATURAL JOIN PizzaDefaut WHERE $identifiant = :id_tag;";
    $resultat = connexion::pdo()->prepare($requetePreparee);

    $tags = array("id_tag" => $id);
    try{
        $resultat->execute($tags);
        $resultat->setFetchMode(PDO::FETCH_CLASS, "Allergene");
        $tableau = $resultat->fetchAll();
        return $tableau;
    } catch (PDOException $e){
        echo $e->getMessage();
    }
}

public static function listRecettes($id){
    $classeRecuperee = static::$classe;
    $identifiant = static::$identifiant;
    $requetePreparee = "SELECT DISTINCT IDRecette, IDPizzaDefaut FROM PizzaDefaut NATURAL JOIN Recette NATURAL JOIN est_composee NATURAL JOIN Ingredient WHERE $identifiant = :id_tag;";
    $resultat = connexion::pdo()->prepare($requetePreparee);

    $tags = array("id_tag" => $id);
    try{
        $resultat->execute($tags);
        $resultat->setFetchMode(PDO::FETCH_CLASS, "Recette");
        $tableau = $resultat->fetchAll();
        return $tableau;
    } catch (PDOException $e){
        echo $e->getMessage();
    }
}

public static function setPizzaDuMoment($idPizza, $pizzaDuMoment) {
    $classeRecuperee = static::$classe;
    $identifiant = static::$identifiant;

    if ($pizzaDuMoment == 1) {
        $requeteVerification = "SELECT COUNT(*) AS nbPizzasDuMoment FROM $classeRecuperee WHERE PizzaDuMoment = 1;";
        $resultatVerification = connexion::pdo()->query($requeteVerification);
        $nbPizzasDuMoment = $resultatVerification->fetch(PDO::FETCH_ASSOC)['nbPizzasDuMoment'];

        if ($nbPizzasDuMoment > 0) {
            echo "<script>alert('Il existe déjà une pizza du moment ! Vous ne pouvez pas en définir une nouvelle.');</script>";
            return;
        }
    }

    $requetePreparee = "UPDATE $classeRecuperee SET PizzaDuMoment = :pizzaDuMoment WHERE $identifiant = :idPizza;";
    $resultat = connexion::pdo()->prepare($requetePreparee);

    $tags = array("idPizza" => $idPizza, "pizzaDuMoment" => $pizzaDuMoment);

    try {
        $resultat->execute($tags);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}

public static function uploadImage($idPizza) {
    $uploadDir = '../PizzeriaS3Client/img/pizza/';

    if (isset($_FILES['ImagePizza']) && $_FILES['ImagePizza']['error'] === UPLOAD_ERR_OK) {
        $uploadFile = $uploadDir . $idPizza . '.jfif';

        move_uploaded_file($_FILES['ImagePizza']['tmp_name'], $uploadFile);
        // Vous pouvez ajouter d'autres traitements ici si nécessaire.
    }
}






// méthode _tostring

public function __toString() {
return "Pizza n°$this->IDPizzaDefaut : $this->NomPizzaDefaut";
}

}


?>