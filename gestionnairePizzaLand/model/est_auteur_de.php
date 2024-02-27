<?php
class est_auteur_de {

protected int $auteur;
protected ?int $bd;

// getter et setter (adaptés à tous Les attributs)
public function get($attribut) {return $this->$attribut;}
public function set($attribut, $valeur) {$this->$attribut = $valeur;}

// constructeur 
public function __construct(int $auteur = NULL, int $bd = NULL) {
if(!is_null($auteur)){
    $this->auteur = $auteur;
    $this->bd = $bd;
}

}

// méthode _tostring

public function __toString() {
    return "auteur n°$this->auteur auteur de bd n°$this->bd";

}

}

?>