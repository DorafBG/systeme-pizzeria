<main>
    <div class="recette-container">
        <?php
        echo "<h2 class='recette-title'>Liste Recette de $pizzanom</h2>";
        echo "<ul class='recette-list'>";
        foreach ($tableau as $unElement) {
            require_once("model/recette.php");

            $idrecette = $unElement->get("IDRecette");
            $identifiant = static::$identifiant;
            $classe = static::$classe;

            $ingredients = recette::listIngredientsDeRecette($idrecette);

            echo "<li class='recette-item'>";
            echo "<div class='recette-content'>";

            echo "<div class='recette-controls'>"; //Permet de centrer l'id recette et le bouton
            echo "<div class='recette-number'>$idrecette</div>";

            
            $urlSupprimer = "?objet=Recette&action=delete&IDRecette=$idrecette";
            echo "<a class='delete-link2' href='$urlSupprimer'><button class='supprimer-recette-btn'>Supprimer</button></a>";
            echo "</div>";
            echo "</div>";

            echo "<ul class='recette-ingredients'>";

            foreach ($ingredients as $ingredient) {
                $idingredient = $ingredient->get("IDIngredient");
                $qtIngredient = recette::quantiteDeLingredientDansLaRecette($idrecette, $idingredient);

                $ingredientNom = $ingredient->get("NomIngredient");
                echo "<li class='ingredient-recette-item'>$ingredientNom : $qtIngredient</li>";
            }

            echo "</ul>";
        }
        echo "</div>"; // Fin de .recette-content
        echo "</div>"; // Fin de .recette-item

        $valeurIDPizzaDefaut = $_GET['IDPizzaDefaut'];
        echo "<a href='?objet=Recette&action=displayCreationForm&IDPizzaDefaut=$valeurIDPizzaDefaut' class='ajouter-alerte-btn'>Ajouter Une Recette</a>";

        ?>
        </ul>
    </div>
</main>
