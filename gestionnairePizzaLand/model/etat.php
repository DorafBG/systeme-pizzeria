<?php
require_once("objet.php");
class etat extends objet {

protected static string $classe = "etat";
protected static string $identifiant = "numEtat";

protected int $numEtat;
protected ?string $nomEtat;

// constructeur 
public function __construct(int $numEtat = NULL, string $nomEtat = NULL) {
if(!is_null($numEtat)){
    $this->numEtat = $numEtat;
    $this->nomEtat = $nomEtat;
}



}

// méthode _tostring

public function __toString() {
    return "État : $this->nomEtat";

}

}

?>