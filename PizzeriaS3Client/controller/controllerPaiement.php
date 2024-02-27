<?php
require_once("model/paiement.php");
require_once("controllerObjet.php");
class controllerPaiement extends ControllerObjet {

    public static function displayPaiement() { // Affiche le formulaire pr payer un panier
        include("view/debut.php");
        include("view/menu.php");

        if(isset($_GET["IDPanier"])){
            $idpanier = $_GET["IDPanier"];
            include("view/paiement/formulairePaiement.php");
        } else {
            echo "<div> Veuillez créer un panier ! </div>";
        }

        include("view/fin.php");
    }

    public static function displayValiderCommande(int $idC){
        include("view/debut.php");
        include("view/menu.php");
        $idcommande = $idC;
        include("view/paiement/confirmationPaiement.php");
        include("view/fin.php");
    }

    public static function create(){
        $donnees = array();
        foreach($_GET as $cle => $valeur){
            if($cle == "IDPanier"){
                $idpanier = $valeur;
            }
            if($cle != "objet" && $cle != "action" && $cle != "IDPanier"){
                $donnees[$cle] = $valeur;
            }
        }

        $idcommande = Paiement::creerCommande($idpanier);
        $donnees["IDCommande"] = $idcommande;
        Paiement::create($donnees);

        self::displayValiderCommande($idcommande);

        
    }

}
?>
