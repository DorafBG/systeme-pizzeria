<?php
require_once("objet.php");
class nationalite extends objet {

protected static string $classe = "nationalite";
protected static string $identifiant = "numNationalite";

protected int $numNationalite;
protected string $nomNationalite;
protected ?string $nomAbrege;

// constructeur 
public function __construct(int $numNationalite = NULL, string $nomNationalite = NULL, string $nomAbrege = NULL) {
    if(!is_null($numNationalite)){
        $this->numNationalite = $numNationalite;
        $this->nomNationalite = $nomNationalite;
        $this->nomAbrege = $nomAbrege;
    }


}

// méthode _tostring

public function __toString() {
    return "Nationalité : $this->nomNationalite ($this->nomAbrege)";

}

}

?>