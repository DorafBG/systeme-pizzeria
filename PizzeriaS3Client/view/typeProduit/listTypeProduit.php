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
        if (!isset($_SESSION["loginClient"])) {
            echo "<a href='?objet=client&action=displayConnectionForm'><button class='btn-ajouter-panier'>Ajouter au panier</button></a>";
        } else {
            echo "<a><button onClick='addProduitToPanier(event, $idProduit)' class='btn-ajouter-panier'>Ajouter au panier</button></a>";
        }
        echo "</div>";
    }
?>
</div>

</main>
<!-- Script pour l'animation de l'emoji produit -->
<script>
function addProduitToPanier(event, idProduit) {
    var boutonRect = event.target.getBoundingClientRect();

    var productEmoji = document.createElement('div');
    productEmoji.innerHTML = '🛒'; 
    productEmoji.style.position = 'fixed';
    productEmoji.style.left = boutonRect.left + 'px';
    productEmoji.style.top = boutonRect.top + 'px';
    productEmoji.style.fontSize = '4em';
    productEmoji.style.transition = 'transform 1s ease-out';

    document.body.appendChild(productEmoji);

    void productEmoji.offsetWidth;

    // Calcul de la position du bouton par rapport à la largeur totale de la fenêtre
    var positionX = ((boutonRect.left / window.innerWidth) * 800);
    var pourcentageX = positionX - (positionX * 4) + 300; 
    var pourcentageY = 1200;

    if (pourcentageX > -300) {
        pourcentageX = -500 - 300;
        pourcentageY = pourcentageY + 300;
    } else if (pourcentageX > -600) {
        pourcentageX = -800;
    } else if (pourcentageX > -1700 && pourcentageX < -1500) {
        pourcentageX = -2200;
    }

    productEmoji.style.transform = 'translate(' + pourcentageY + '%, ' + pourcentageX + '%)';

    setTimeout(function() {
        document.body.removeChild(productEmoji);
        window.location.href = '?objet=panier&action=addProduitPanier&IDProduit=' + idProduit;
    }, 500);
}

</script>
