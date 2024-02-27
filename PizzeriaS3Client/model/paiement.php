<?php
require_once("objet.php");
class Paiement extends objet {

protected static string $classe = "Paiement";
protected static string $identifiant = "IDPaiement";

protected int $IDPaiement ;
protected ?string $NomPorteurCB;
protected ?string $codeCartePaiement;
protected ?string $datePeremptionPaiement;
protected ?int $cryptogrammePaiement;
protected ?int $IDCommande;

// constructeur 
public function __construct(int $IDPaiement = NULL, string $NomPorteurCB= NULL, string $codeCartePaiement = NULL, string $datePeremptionPaiement = NULL, int $cryptogrammePaiement = NULL, int $IDCommande = NULL) {
    if(!is_null($IDPaiement)){
        $this->IDPaiement = $IDPaiement;
        $this->NomPorteurCB = $NomPorteurCB;
        $this->codeCartePaiement = $codeCartePaiement;
        $this->datePeremptionPaiement = $datePeremptionPaiement;
        $this->cryptogrammePaiement = $cryptogrammePaiement;
        $this->IDCommande = $IDCommande;

    }



}

public static function create($donnees) {
    $classeRecuperee = static::$classe;


    $recetteQuery = "INSERT INTO Paiement(`NomPorteurCB`, `codeCartePaiement`, `datePeremptionPaiement`, `cryptogrammePaiement`, `IDCommande`) VALUES (:NomPorteurCB, :codeCartePaiement, :datePeremptionPaiement, :cryptogrammePaiement, :IDCommande);";
    $recetteResult = connexion::pdo()->prepare($recetteQuery);

    // Utiliser la date formatée dans les valeurs liées
    $tags = array(
        "NomPorteurCB" => $donnees['NomPorteurCB'],
        "codeCartePaiement" => $donnees['codeCartePaiement'],
        "datePeremptionPaiement" => $donnees['datePeremptionPaiement'],
        "cryptogrammePaiement" => $donnees['cryptogrammePaiement'],
        "IDCommande" => $donnees['IDCommande']
    );

    try {
        $recetteResult->execute($tags);
    } catch (PDOException $e) {
        echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        return false; // Gérer l'erreur comme nécessaire
    }

    return true;
}


public static function creerCommande($idPanier) //cree une commande, passe le panier en estCommande = false et refais un nv panier
{
    $requetePreparee = "call updatePanierAndCreateCommande(:idPanier);";
    $resultat = connexion::pdo()->prepare($requetePreparee);
    $tags = array("idPanier" => $idPanier);

    try {
        $resultat->execute($tags);

        $requetePreparee2 = "SELECT IDCommande FROM Commande WHERE IDPanier = :idPanier;"; //on recupere l'id de la nv commande créée
        $resultat2 = connexion::pdo()->prepare($requetePreparee2);
        $resultat2->execute($tags);
        $idCommande = $resultat2->fetchColumn();
        return $idCommande;

    } catch (PDOException $e) {
        echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
    }
}



// méthode _tostring

public function __toString() {
    return "Paiement n°$this->IDPaiement (Pour la commande n°$this->IDCommande)";

}

}

?>