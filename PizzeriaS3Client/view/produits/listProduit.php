<title>PizzaLand - Les Types De Produit</title>
<main>
    <ul class="product-list">
        <?php
        $displayedTypes = []; // Array to store displayed types

        foreach ($tableau as $unElement) {
            $TypeProduit = $unElement->get('TypeProduit');

            // Check if the type has already been displayed
            if (!in_array($TypeProduit, $displayedTypes)) {
                echo "<div class='afficheTypeProduit'>";
                echo "<div class='type-produit-item'>";
                echo "<img class='type-produit-image' src='img/afficheProduit/$TypeProduit.jfif' alt='Image'>";
                echo "<div class='type-produit-details'>";
                if($TypeProduit == "Gateau") { echo "<h3 class='type-product-title'>🍰 $TypeProduit 🍰</h3>"; } else
                if($TypeProduit == "Fruits") { echo "<h3 class='type-product-title'>🍌 $TypeProduit 🍌</h3>"; } else
                if($TypeProduit == "Boisson") { echo "<h3 class='type-product-title'>🥤 $TypeProduit 🥤</h3>"; } else
                if($TypeProduit == "Glace") { echo "<h3 class='type-product-title'>🍦 $TypeProduit 🍦</h3>"; }
                
                echo "<a class='couleurProd' href='?objet=Produit&action=listTypeProduit&TypeProduit=$TypeProduit'>";
                echo "<button class='btn-voir'> <span>Voir</span> <svg viewBox='-5 -5 110 110' preserveAspectRatio='none' aria-hidden='true'> <path d='M0,0 C0,0 100,0 100,0 C100,0 100,100 100,100 C100,100 0,100 0,100 C0,100 0,0 0,0'/> </svg> </button>";
                echo "</a>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

                // Add the type to the displayed array
                $displayedTypes[] = $TypeProduit;
            }
        }
        ?>
    </ul>
</main>
