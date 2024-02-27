<?php
require_once("model/client.php");
require_once("model/produit.php");
require_once("model/PizzaDefaut.php");
require_once("model/panier.php");
require_once("controller/controllerProduit.php");
require_once("controller/controllerPizzaDefaut.php");
require_once("model/client.php");

$idClient = $_SESSION["IDClient"];
$historique = client::historique($idClient);
?>
<title>PizzaLand - Historique des commandes</title>
<body>
<h1 class="titre-historique">Mon historique des commandes (<?php echo $_SESSION['loginClient']?>)</h1> 
<div id="container-historique">

<?php
function formatteDate($dateStr)
{
    $dateTime = new DateTime($dateStr);
    return $dateTime->format('d/m/Y \à H:i:s');
}

$nbCommandes = count($historique);

// Afficher l'historique des commandes
foreach ($historique as $commande) {
    echo '<div class="commande-historique">';
    echo '<div class="numNombreCommande"> N° DE COMMANDE ' . $commande['IDCommande'] . ' </div>';
    echo '<div class="numero-commande">Commande n°' . $nbCommandes . ' passée le ' . formatteDate($commande['DateCommande']) . '</div>';

    // Afficher les produits de la commande
    $produits = produit::getProduitsDePanier($commande['IDPanier']);
    foreach ($produits as $produit) {
      if(($produit['quantite']) > 1)
      {
        $prixProduit = $produit['PrixProduit'] * $produit['quantite']; 
      }
      else{
        $prixProduit = $produit['PrixProduit'];
      }
        echo '<span class="produit-historique">- Produit : ' . $produit['NomProduit'] . ' (x' . $produit['quantite'] . ')' . ' : ' . $prixProduit . '€</span><br>';
    }

    // Afficher les pizzas de la commande
    $pizzas = PizzaDefaut::getPizzasDePanier($commande['IDPanier']);
    foreach ($pizzas as $pizza) {
        echo '<span class="pizza-historique">- Pizza : ' . $pizza['NomPizzaDefaut'] . ' : ' . $pizza['PrixPizzaDefaut'] . '€</span><br>';
    }

    $prixtotal = Panier::getPrixTotalPanier($commande["IDPanier"]);
    if($prixtotal > 0) echo '<p class="prix-total">Total : ' . $prixtotal . ' €</p>';

    echo '<p class="codeCB">Payée avec CB : ***-' . substr($commande["codeCartePaiement"], -4) . '</p>';
    echo "</div>";
    $nbCommandes--;
}
?>

</div>