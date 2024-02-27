<title>PizzaLand - Accueil</title>
<div id="main-content">

    <?php
    require_once("model/PizzaDefaut.php");
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
        $ingredients = PizzaDefaut::getIngredientsForPizza($idPizza);

            // Vérifie si le fichier image existe
    if (file_exists($imgPath)) {
        $imgSrc = $imgPath;
    } else {
        // Si l'image n'existe pas, utilise l'image de base "pizza0.jfif"
        $imgSrc = "img/pizza/0.png";
    }

        if ($pizzaDuMoment) {
            echo "<div id='pizza-du-moment-container'>";
            echo "<div id='pizza-du-moment-image'>";
            echo "<img src='$imgSrc' alt='$nomPizza'>";
            echo "</div>";
            echo "<div class='pizza-du-moment-details'>";
            echo "<h2>🔥Pizza du Moment: la $nomPizza !!🔥</h2>";
            echo "<p>$descriptionPizza</p>";
            
            $ingredientsList = "";
            foreach ($ingredients as $index => $ingredient) {
                $nomIngredient = $ingredient['NomIngredient'];
                if ($index > 0) {
                    $ingredientsList .= ", ";
                }
                $ingredientsList .= $nomIngredient;
            }
            echo "<p id='listeIngredientsPizzaDuMoment'>" . $ingredientsList . "</p>";

            echo "<h2 style = 'font-size: 2.4em;'>$prixPizza € SEULEMENT</h2>";
            if (!isset($_SESSION["loginClient"])) {
                echo "<a href='?objet=client&action=displayConnectionForm'><button class='ajouterAuPanier'>Ajouter au panier</button></a>";
            } else {
                echo "<a><button onClick='addPizzaToPanier(event, $idPizza)' class='ajouterAuPanier'>Ajouter au panier</button></a>";
            }
            
            echo "</div>";
            echo "</div>";
        } else {
            echo "<div class='pizza'>";
            echo "<div id='pizza-non-du-moment-image'><img class='non-du-moment-img' src='$imgSrc' alt='$nomPizza'></div>";
            echo "<h3>$nomPizza</h3>";
            echo "<p>$descriptionPizza</p>";

            $ingredientsList = "";
            foreach ($ingredients as $index => $ingredient) {
                $nomIngredient = $ingredient['NomIngredient'];
                if ($index > 0) {
                    $ingredientsList .= ", ";
                }
                $ingredientsList .= $nomIngredient;
            }
            echo "<p id='listeIngredients'>" . $ingredientsList . "</p>";


            echo "<p>$prixPizza €</p>";
            if (!isset($_SESSION["loginClient"])) {
                echo "<a href='?objet=client&action=displayConnectionForm'><button class='ajouterAuPanier'>Ajouter au panier</button></a>";
            } else {
                echo "<a><button onClick='addPizzaToPanier(event, $idPizza)' class='ajouterAuPanier'>Ajouter au panier</button></a>";
            }
            echo "</div>";
        }
    }
    ?>

</div>

<!-- Script pour l'animation de l'emoji pizza -->
<script>
function addPizzaToPanier(event, idPizza) {
    var boutonRect = event.target.getBoundingClientRect();

    var pizzaEmoji = document.createElement('div');
    pizzaEmoji.innerHTML = '🍕';
    pizzaEmoji.style.position = 'fixed';
    pizzaEmoji.style.left = boutonRect.left + 'px';
    pizzaEmoji.style.top = boutonRect.top + 'px';
    pizzaEmoji.style.fontSize = '4em';
    pizzaEmoji.style.transition = 'transform 1s ease-out';

    document.body.appendChild(pizzaEmoji);

    void pizzaEmoji.offsetWidth;

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
    pizzaEmoji.style.transform = 'translate(' + pourcentageY +'%, ' + pourcentageX +'%)';

     setTimeout(function() {
         document.body.removeChild(pizzaEmoji);
         window.location.href = '?objet=panier&action=addPizzaPanier&IDPizzaDefaut=' + idPizza;
     }, 500);
}
</script>



