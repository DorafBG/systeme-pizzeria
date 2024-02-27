<?php
require_once("objet.php");
class serie extends objet {

protected static string $classe = "serie";
protected static string $identifiant = "numSerie";

protected int $numSerie;
protected string $nomSerie;
protected ?int $categorie;

// constructeur 
public function __construct(int $numSerie = NULL, string $nomSerie = NULL, int $categorie = NULL) {
    if(!is_null($numSerie)){
        $this->numSerie = $numSerie;
        $this->nomSerie = $nomSerie;
        $this->categorie = $categorie;
    }



}

// méthode _tostring

public function __toString() {
    return "Série : <b>$this->nomSerie</b> (Catégorie $this->categorie)";

}

}

?>