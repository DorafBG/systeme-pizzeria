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
            $idProduit = $produit["IDProduit"];
            $nomProduit = $produit["NomProduit"];
            $prixProduit = $produit["PrixProduit"];
            $quantiteProduit = $produit["quantite"];
            $prixProduit = $prixProduit * $quantiteProduit;
            $imgPathProduit = "img/produit/$idProduit.jfif";

            echo "<li class='produit-panier'>
                    <img src='$imgPathProduit' alt='$nomProduit'>
                    <div>
                        <p>$nomProduit &nbsp;<b>(x$quantiteProduit)</b></p>
                        <p>$prixProduit €</p>
                    </div>";
                    if($quantiteProduit > 1){
                        echo "<a href='?objet=panier&action=removeProduitPanier&IDProduit=$idProduit'><button class='boutonX'>-</button></a>";
                    } else {
                        echo "<a href='?objet=panier&action=removeProduitPanier&IDProduit=$idProduit'><button class='boutonX'>X</button></a>";
                    }
                    
            echo "</li>";
        }

        foreach ($lesPizzas as $pizza) {
            $idPizza = $pizza['IDPizza'];
            $idPizzaDefaut = $pizza["IDPizzaDefaut"];
            $nomPizza = $pizza["NomPizzaDefaut"];
            $prixPizza = $pizza["PrixPizzaDefaut"];
            $idChoixIngredient = PizzaDefaut::getChoixIngredient($idPizza, $element->get("IDPanier"));
            $ingredientChoix = choixIngredient::listIngredient($idChoixIngredient);
            $imgPath = "img/pizza/{$idPizzaDefaut}.jfif";

            
            // Vérifie si le fichier image existe
                if (file_exists($imgPath)) {
                   $imgSrc = $imgPath;
                 } else {
               // Si l'image n'existe pas, utilise l'image de base "pizza0.jfif"
                   $imgSrc = "img/pizza/0.png";
                 }



            $idPanier = $element->get("IDPanier");
            echo "<li class='pizza-panier'>
                    <img src='$imgSrc' alt='$nomPizza'>
                    <div>
                        <p>$nomPizza";
            if(!empty($ingredientChoix)) { echo "&nbsp;<I class='perso-pizza'>(Personnalisée)</I></p>"; } else { echo "</p>";}
            echo "      <p>$prixPizza €</p>
                    </div>
                    <a class='boutonModifier' href='?objet=PizzaDefaut&action=listRecettes&IDPizza=$idPizza&IDPanier=$idPanier'><button>Modifier</button></a>
                    <a href='?objet=panier&action=removePizzaPanier&IDPizza=$idPizza'><button class='boutonX'>X</button></a>
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
