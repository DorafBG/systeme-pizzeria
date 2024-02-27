<main>
    <form class="create-form" action="index.php" method="get">
        <input type="hidden" name="objet" value="<?php echo $classe; ?>">
        <input type="hidden" name="action" value="create">
        <input type="hidden" name="IDPizzaDefaut" value="<?php echo $_GET['IDPizzaDefaut']?>">
        <input type="hidden" name="IDRecette" value="<?php echo recette::nextID(); ?>">
        <h1>Ajouter une Recette</h1>
        <div class='form-group'>
            <label class='form-label' for='ingredient'>Pour la pizza N°:<?php echo $_GET['IDPizzaDefaut']?></label>
        </div>
        <div class="ingredient-section">
            <div class='form-group'>
                <label class='form-label' for='ingredient[]'>Ingrédient :</label>
                <select class='form-input' name='IDIngredient[]' required>
                    <?php
                    // Récupérer tous les ingrédients depuis la base de données
                    $ingredients = ingredient::getAll();

                    // Afficher chaque ingrédient dans le menu déroulant
                    foreach ($ingredients as $ingredient) {
                        echo "<option value=\"{$ingredient->getIDIngredient()}\">{$ingredient->getNomIngredient()}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class='form-group'>
                <label class='form-label' for='quantite[]'>Quantité :</label>
                <input class='form-input' type='number' name='qtIngredientRecette[]' placeholder='Quantité' required>
            </div>
        </div>
        <div id="ingredient-container"></div>
        <button class='form-button' type='button' onclick="addIngredient()">Ajouter un ingrédient</button>
        <button class='form-button' type='submit'>Créer</button>
    </form>

    <script>
        function addIngredient() {
            var container = document.getElementById('ingredient-container');
            var newIngredientSection = document.createElement('div');
            newIngredientSection.className = 'ingredient-section';
            newIngredientSection.innerHTML = document.querySelector('.ingredient-section').innerHTML;
            container.appendChild(newIngredientSection);
        }
    </script>
</main>
