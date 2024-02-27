<title>PizzaLand - Accueil</title>
<div id="main-content">

    <?php
    //fonction de tri pour mettre les Pizza qui qui ont PizzaDuMoment TRUE en premier
    usort($tableau, function($a, $b) {
        return $b->get('PizzaDuMoment') - $a->get('PizzaDuMoment');
    });

    foreach ($tableau as $unElement) {
        $nomPizza = $unElement->get('NomPizzaDefaut');
        $idPizza = $unElement->get('IDPizzaDefaut');
        $descriptionPizza = $unElement->get('DescriptionPizzaDefaut');
        $pizzaDuMoment = $unElement->get('PizzaDuMoment');
        $prixPizza = $unElement->get('PrixPizzaDefaut');
        $imgPath = "img/pizza/{$idPizza}.jfif";

        if ($pizzaDuMoment) {
            echo "<div id='pizza-du-moment-container'>";
            echo "<div id='pizza-du-moment-image'>";
            echo "<img src='$imgPath' alt='$nomPizza'>";
            echo "</div>";
            echo "<div id='pizza-du-moment-details'>";
            echo "<h2>🔥Pizza du Moment: la $nomPizza !!🔥</h2>";
            echo "<p>$descriptionPizza</p>";
            echo "<h2 style = 'font-size: 2.4em;'>16 € SEULEMENT</h2>";
            echo "<a href = '?objet=panier&action=addPizzaPanier&IDPizzaDefaut=$idPizza'><button class='ajouterAuPanier'>Ajouter au panier</button></a>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<div class='pizza'>";
            echo "<div id='pizza-non-du-moment-image'><img class='non-du-moment-img' src='$imgPath' alt='$nomPizza'></div>";
            echo "<h3>$nomPizza</h3>";
            echo "<p>$descriptionPizza</p>";
            echo "<p>$prixPizza €</p>";
            echo "<a href = '?objet=panier&action=addPizzaPanier&IDPizzaDefaut=$idPizza'><button class='ajouterAuPanier'>Ajouter au panier</button></a>";
            echo "</div>";
        }
    }
    ?>

</div>
