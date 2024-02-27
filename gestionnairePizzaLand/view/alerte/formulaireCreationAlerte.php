<main>
        <form class="create-form" action="index.php" method="get">
            <input type="hidden" name="objet" value="<?php echo $classe; ?>">
            <input type="hidden" name="action" value="create">
            <h1>Ajouter une Alerte</h1>
            <div class='form-group'>
                <label class='form-label' for='ingredient'>Ingrédient :</label>
                <select class='form-input' name='IDIngredient' required>
                    <?php
                    include("model/ingredient.php");
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
                <label class='form-label' for='quantite'>Avertir dès que moins de :</label>
                <input class='form-input' type='number' name='QtIngredientAlerte' placeholder='Quantité' required>
            </div>
            <button class='form-button' type='submit'>Créer</button>
        </form>
    </main>