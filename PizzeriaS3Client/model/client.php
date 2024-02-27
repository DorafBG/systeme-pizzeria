<?php
require_once("objet.php");

class Client extends objet {
    protected static string $classe = "Client";
    protected static string $identifiant = "IDClient";
    protected int $IDClient;
    protected string $loginClient;
    protected string $mdpClient;
    protected string $NomClient;
    protected string $PrenomClient;
    protected string $RueClient;
    protected string $VilleClient;
    protected string $PaysClient;
    protected string $TelClient;

    public function get($attribut) {return $this->$attribut;}
    public function set($attribut, $valeur) {$this->$attribut = $valeur;}

    public function __construct(
        int $IDClient = NULL,
        string $loginClient = NULL,
        string $mdpClient = NULL,
        string $NomClient = NULL,
        string $PrenomClient = NULL,
        string $RueClient = NULL,
        string $VilleClient = NULL,
        string $PaysClient = NULL,
        string $TelClient = NULL
    ) {
        if (!is_null($IDClient)) {
            $this->IDClient = $IDClient;
            $this->loginClient = $loginClient;
            $this->mdpClient = $mdpClient;
            $this->NomClient = $NomClient;
            $this->PrenomClient = $PrenomClient;
            $this->RueClient = $RueClient;
            $this->VilleClient = $VilleClient;
            $this->PaysClient = $PaysClient;
            $this->TelClient = $TelClient;
        }
    }
    public function getIDClient() {return $this->IDClient;}
    public function getLoginClient() {return $this->loginClient;}

    public static function getOne($id){
        $requetePreparee = "SELECT * FROM Client WHERE loginClient = :id_tag;";
        $resultat = connexion::pdo()->prepare($requetePreparee);

        $tags = array("id_tag" => $id);
        try{
            $resultat->execute($tags);
            $resultat->setFetchmode(PDO::FETCH_CLASS, "Client");
            $element = $resultat->fetch();
            return $element;
        } catch (PDOException $e){
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }
    
    public static function checkMDP($l, $m) {
        $requetePreparee = "SELECT * FROM Client WHERE loginClient = :login_tag AND mdpClient = :mdp_tag;";
        $resultat = connexion::pdo()->prepare($requetePreparee);
        $tags = array("login_tag" => $l, "mdp_tag" => $m);
        try {
            $resultat->execute($tags);
            $resultat->setFetchMode(PDO::FETCH_ASSOC);
            $clients = $resultat->fetchAll();
            if (count($clients) == 1) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
        }
    }


    public function update() {
        
        $requetePreparee = "UPDATE Client SET loginClient = :login, mdpClient = :mdp, NomClient = :nom, PrenomClient = :prenom, RueClient = :rue, VilleClient = :ville, PaysClient = :pays, TelClient = :tel WHERE IDClient = :id";
        $resultat = connexion::pdo()->prepare($requetePreparee);
    
        $tags = array(
            "login" => $this->loginClient,
            "mdp" => $this->mdpClient,
            "nom" => $this->NomClient,
            "prenom" => $this->PrenomClient,
            "rue" => $this->RueClient,
            "ville" => $this->VilleClient,
            "pays" => $this->PaysClient,
            "tel" => $this->TelClient,
            "id" => $this->IDClient
        );
    
        try {
            $resultat->execute($tags);
            // Mise à jour réussie
            return true;
        } catch (PDOException $e) {
            // Erreur lors de la mise à jour
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
            return false;
        }
    }


    public static function countOrdersByClient($loginClient) {
        $requetePreparee = "SELECT COUNT(IDCommande) AS NombreDeCommandes FROM Commande NATURAL JOIN Client WHERE loginClient = :login_tag;";
        $resultat = connexion::pdo()->prepare($requetePreparee);
        $tags = array("login_tag" => $loginClient);
    
        try {
            $resultat->execute($tags);
            $row = $resultat->fetchColumn();
            return $row;
        } catch (PDOException $e) {
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
            return -1; // En cas d'erreur
        }
    }
    
    public static function historique($idClient)
    {
        $requetePreparee = "SELECT * FROM Panier NATURAL JOIN Client NATURAL JOIN Commande NATURAL JOIN Paiement WHERE IDClient = :id_tag AND estCommande = 1 ORDER BY IDPanier DESC;";
        $resultat = connexion::pdo()->prepare($requetePreparee);
        $tags = array("id_tag" => $idClient);
    
        try {
            $resultat->execute($tags);
            $resultat->setFetchMode(PDO::FETCH_ASSOC);
            $commandes = $resultat->fetchAll();
            return $commandes;
        } catch (PDOException $e) {
            echo '<script type="text/javascript">alert("Erreur PDO : ' . $e->getMessage() . '");</script>';
            return -1; // En cas d'erreur
        }
    }




}
?>