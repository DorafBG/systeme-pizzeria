<?php
require_once("objet.php");
class categorie extends objet {

protected static string $classe = "categorie";
protected static string $identifiant = "numCategorie";

protected int $numCategorie;
protected string $nomCategorie;
protected ?string $descriptif;

// constructeur 
public function __construct(int $numCategorie = NULL, string $nomCategorie= NULL, string $descriptif= NULL) {
if(!is_null($numCategorie)){
    $this->numCategorie = $numCategorie;
    $this->nomCategorie = $nomCategorie;
    $this->descriptif = $descriptif;
}



}

// méthode _tostring

public function __toString() {
    return "catégorie <b>$this->nomCategorie</b> ( $this->descriptif )";

}

}

?>