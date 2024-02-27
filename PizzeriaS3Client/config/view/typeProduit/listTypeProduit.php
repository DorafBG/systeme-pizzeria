<title>PizzaLand - Les Produits</title>
<main>

<div class="produit-container">
<?php
    foreach ($tableau as $unElement) {
        $NomProduit = $unElement->get('NomProduit');
        $idProduit = $unElement->get('IDProduit');
        $prixProduit = $unElement->get('PrixProduit');
        $imgPathProduit = "img/produit/$idProduit.jfif";

        echo "<div class='produit-item'>";
        echo "<img class='produit-image' src='$imgPathProduit' alt='Image'>";
        echo "<div class='produit-details'>";
        echo "<h3 class='produit-title'>$NomProduit</h3>";
        echo "<p class='produit-price'>$prixProduit €</p>";
        echo "</div>";
        echo "<a href = '?objet=panier&action=addProduitPanier&IDProduit=$idProduit'><button class='btn-ajouter-panier'>Ajouter au panier</button></a>";
        echo "</div>";
    }
?>
</div>

</main>
