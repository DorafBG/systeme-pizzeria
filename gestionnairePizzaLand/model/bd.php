<?php
require_once("objet.php");
class bd extends objet {

protected static string $classe = "bd";
protected static string $identifiant = "numBD";

protected int $numBD;
protected string $titre;
protected int $anneeParution;
protected ?int $serie;
protected ?int $rang;
protected ?int $etat;
protected ?string $emprunteur;

// constructeur 
public function __construct(int $numBD = NULL, string $titre = NULL, int $anneeParution = NULL, int $serie = NULL, int $rang = NULL, int $etat = NULL, string $emprunteur = NULL) {
    if(!is_null($numBD)){
        $this->numBD = $numBD;
        $this->titre = $titre;
        $this->anneeParution = $anneeParution;
        $this->serie = $serie;
        $this->rang = $rang;
        $this->etat = $etat;
        $this->emprunteur = $emprunteur;
    }


}

// méthode _tostring

public function __toString() {
    return "BD <b>$this->titre</b> parue en $this->anneeParution";
}


}

?>