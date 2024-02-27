
<main>
    <h1>Ajouter une Alerte</h1>
    <form action="traitement_alerte.php" method="post">
        <label for="ingredient">Ingrédient :</label>
        <?php echo "<strong>voici les ingredients :</strong>";
        include("model/ingredient.php");
                    $ingredients = ingredient::getAll();
            
                    echo $ingredients;
        ?>
        <select name="ingredient" id="ingredient">
            <?php
             
            include("model/ingredient.php");
            // Récupérer tous les ingrédients depuis la base de données

            $ingredients = ingredient::getAll();
            
            echo $ingredients;

            // Afficher chaque ingrédient dans le menu déroulant
            foreach ($ingredients as $ingredient) {
                echo $ingredient;
                echo "<option value=\"{$ingredient->getIDIngredient()}\">{$ingredient->getNomIngredient()}</option>";
            }
            ?>
        </select>

        <label for="quantite">Avertir dès que moins de :</label>
        <input type="number" name="quantite" id="quantite" />

        <button type="submit">Ajouter l'Alerte</button>
    </form>
</main>

