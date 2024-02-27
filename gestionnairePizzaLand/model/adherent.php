<?php

require_once("objet.php");
class adherent extends objet{

protected static string $classe = "adherent";
protected static string $identifiant = "login";

// attributs d'une instance de La classe Livre
protected string $login;
protected string $mdp;
protected ?string $nomAdherent;
protected ?string $prenomAdherent;
protected ?string $email;
protected ?string $telephone;

// constructeur 
public function __construct(string $login = NULL, string $mdp = NULL, string $nomAdherent = NULL, string $prenomAdherent = NULL, string $email = NULL, string $telephone = NULL) {
    if(!is_null($login)){
        $this->login = $login;
        $this->mdp = $mdp;
        $this->nomAdherent = $nomAdherent;
        $this->prenomAdherent = $prenomAdherent;
        $this->email = $email;
        $this->telephone = $telephone;
    }


}


// méthode _tostring

public function __toString() {
return "adhérent $this->login ( $this->prenomAdherent $this->nomAdherent )";
}



}

?>