<?php
require_once("objet.php");
class Produit extends objet{
    protected static string $classe = "Produit";
    protected static string $identifiant = "IDProduit";
    protected int $IDProduit;
    protected string $TypeProduit;
    protected string $NomProduit;
    protected float $PrixProduit;

    // getter et setter

    public function __construct(int $IDProduit= NULL, string $TypeProduit= NULL, string $NomProduit= NULL, float $PrixProduit = NULL)
    {
        if(!is_null($IDProduit))
        {
        $this->IDProduit =$IDProduit;
        $this->TypeProduit = $TypeProduit;
        $this->NomProduit = $NomProduit;
        $this->PrixProduit = $PrixProduit;
        }
    }

    public function get($attribut) {return $this->$attribut;}
    public function set($attribut, $valeur) {$this->$attribut = $valeur;}
    public function getIDProduit(): int {
        return $this->IDProduit;
    }


    public static function getTypeProduit($id){
        $requetePreparee = "SELECT * FROM Produit WHERE TypeProduit = :id_tag;";
        $resultat = connexion::pdo()->prepare($requetePreparee);
    
        $tags = array("id_tag" => $id);
        try{
            $resultat->execute($tags);
            $resultat->setFetchMode(PDO::FETCH_CLASS, "Produit");
            $tableau = $resultat->fetchAll();
            return $tableau;
        } catch (PDOException $e){
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }


    public static function getOneNomProduit($Type)
    {
        $requetePreparee = "SELECT * FROM Produit WHERE nomProduit = :id_tag;";
        $resultat = connexion::pdo()->prepare($requetePreparee);
        $tags = array("id_tag" => $Type);
        try{
            $resultat->execute($tags);
            $resultat->setFetchmode(PDO::FETCH_CLASS, "Produit");
            $element = $resultat->fetch();
            return $element;
        } catch(PDOException $e)
        {
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }

    }

    public static function getProduitsDePanier($idPanier){
        $requetePreparee = "SELECT * FROM Panier NATURAL JOIN possede NATURAL JOIN Produit WHERE IDPanier = :id_tag;";
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

    public function __toString()
    { 
        return "$this->NomProduit est à $this->PrixProduit";
    }
}

?>