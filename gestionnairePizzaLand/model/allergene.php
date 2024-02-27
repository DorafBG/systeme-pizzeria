<?php
require_once("objet.php");
class Allergene extends objet {

protected static string $classe = "Allergene";
protected static string $identifiant = "IDAllergene";

protected int $IDAllergene;
protected ?string $nomAllergene;

// constructeur 
public function __construct(int $IDAllergene = NULL, string $nomAllergene = NULL) {
    if(!is_null($IDAllergene)){
        $this->IDAllergene = $IDAllergene;
        $this->nomAllergene = $nomAllergene;
    }



}

// méthode _tostring

public function __toString() {
    return "Allergene : <b>$this->IDAllergene</b> (Catégorie $this->nomAllergene)";

}

}

?>