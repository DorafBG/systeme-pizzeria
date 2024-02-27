<title>PizzaLand - Panier</title>
<main class="main-panier">
    <h1 class="titre-panier">Mon Panier</h1>
    <ul class="produits-panier">
        <?php

include("model/produit.php");
include("model/PizzaDefaut.php");
$lesProduits = Produit::getProduitsDePanier($element->get("IDPanier"));
$lesPizzas = PizzaDefaut::getPizzasDePanier($element->get("IDPanier"));

        foreach ($lesProduits as $produit){
            $idProduit = $produit->get("IDProduit");
            $nomProduit = $produit->get("NomProduit");
            $prixProduit = $produit->get("PrixProduit");
            $imgPathProduit = "img/produit/$idProduit.jfif";

            echo "<li class='produit-panier'>
                    <img src='$imgPathProduit' alt='$nomProduit'>
                    <div>
                        <p>$nomProduit</p>
                        <p>$prixProduit €</p>
                    </div>
                    <a href='?objet=panier&action=removeProduitPanier&IDProduit=$idProduit'><button>X</button></a>
                  </li>";
        }

        foreach ($lesPizzas as $pizza) {
            $idPizza = $pizza['IDPizza'];
            $idPizzaDefaut = $pizza["IDPizzaDefaut"];
            $nomPizza = $pizza["NomPizzaDefaut"];
            $prixPizza = $pizza["PrixPizzaDefaut"];
            $imgPath = "img/pizza/{$idPizzaDefaut}.jfif";
            $idPanier = $element->get("IDPanier");
            echo "<li class='pizza-panier'>
                    <img src='$imgPath' alt='$nomPizza'>
                    <div>
                        <p>$nomPizza</p>
                        <p>$prixPizza €</p>
                    </div>
                    <a href='?objet=PizzaDefaut&action=listRecettes&IDPizza=$idPizza&IDPanier=$idPanier'><button>Modifier</button></a>
                    <a href='?objet=panier&action=removePizzaPanier&IDPizza=$idPizza'><button>X</button></a>
                  </li>";
        }
        ?>
    </ul>

    <?php
        echo "<div class='total'>";

        $prixtotal = Panier::getPrixTotalPanier($element->get("IDPanier"));
        if($prixtotal > 0) echo "<p>Total: $prixtotal €</p>";

        echo "</div>";

    
    $idpanier = $element->get("IDPanier");
    if($prixtotal > 0){
        echo "<a href='?objet=paiement&IDPanier=$idpanier'><button class='payment-btn'>Accéder au paiement</button></a>";
    } else {
        echo "<div><p>Votre panier est vide ! Qu'attendez-vous ? 🕺</p></div>";
    }
    

    ?>
</main>

</body>
</html>
