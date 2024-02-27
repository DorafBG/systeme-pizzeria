<?php
require_once("objet.php");
class auteur extends objet {

protected static string $classe = "auteur";
protected static string $identifiant = "numAuteur";

protected int $numAuteur;
protected ?string $nomAuteur;
protected ?string $prenomAuteur;
protected ?int $nationalite;

// constructeur 
public function __construct(int $numAuteur = NULL, string $nomAuteur = NULL, string $prenomAuteur = NULL, int $nationalite = NULL) {
    if(!is_null($numAuteur)){
        $this->numAuteur = $numAuteur;
        $this->nomAuteur = $nomAuteur;
        $this->prenomAuteur = $prenomAuteur;
        $this->nationalite = $nationalite;
    }



}

// méthode _tostring

public function __toString() {
    return "Auteur <b>$this->prenomAuteur $this->nomAuteur</b>";

}

}

?>