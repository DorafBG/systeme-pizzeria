<?php
require_once("objet.php");
class client extends objet {

protected static string $classe = "Client";
protected static string $identifiant = "IDClient";

protected int $IDClient;
protected ?string $loginClient;
protected ?string $mdpClient;
protected ?string $NomClient;
protected ?string $PrenomClient;
protected ?string $RueClient;
protected ?string $VilleClient;
protected ?string $PaysClient;
protected ?string $TelClient;

// constructeur 
public function __construct(int $IDClient = NULL, string $loginClient= NULL, string $mdpClient= NULL, string $NomClient= NULL, string $PrenomClient= NULL, string $RueClient= NULL, string $VilleClient= NULL, string $PaysClient=NULL, string $TelClient=NULL) {
if(!is_null($IDClient)){
    $this->IDClient = $IDClient;
    $this->loginClient = $loginClient;
    $this->mdpClient = $mdpClient;
    $this->PrenomClient = $PrenomClient;
    $this->RueClient = $RueClient;
    $this->VilleClient = $VilleClient;
    $this->PaysClient = $PaysClient;
    $this->TelClient = $TelClient;
    
}
}

public static function checkMDP($l, $m){
    $requetePreparee = "SELECT * FROM Client WHERE loginClient = :loginClient AND mdpClient = :mdpClient;";
    $resultat = connexion::pdo()->prepare($requetePreparee);

    $tags = array("loginClient" => $l, "mdpClient" => $m);
    try{
        $resultat->execute($tags);
        $resultat->setFetchmode(PDO::FETCH_CLASS, "Client");
        $tableau = $resultat->fetchAll();
        if(count($tableau) == 1){
            return true;
        } else {
            return false;
        }
    } catch (PDOException $e){
        echo $e->getMessage();
    }
}

// méthode _tostring

public function __toString() {
    return "Client n°<b>$this->IDClient</b> ( login: $this->loginClient )";

}

}

?>