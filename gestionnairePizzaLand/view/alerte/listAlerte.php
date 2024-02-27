<main>
    <ul>
        <?php
        include("model/ingredient.php");
        include("script/alerte/alerte.php");
        foreach ($tableau as $unElement) {
            $ingredientID = $unElement->get('IDIngredient');
            $identifiant = static::$identifiant;
            $classe = static::$classe;
            $id = $unElement->get($identifiant);

            $ingredientDeLalerte = ingredient::getOne($ingredientID);
            $nomIngredient = $ingredientDeLalerte->getNomIngredient();
            $seuilQuantiteAlerte = $unElement->get('QtIngredientAlerte');
            $boutonSupprimer = "<button class='supprimer-alerte-btn'>Supprimer</button>";

            echo "<li class='table-row'>";
            echo "<span class='table-cell'>$nomIngredient</span>";
            echo "<span class='table-cell'>";
            echo "<strong>Avertir dès que moins de </strong> <input type='number' value='$seuilQuantiteAlerte' onchange='updateDatabase($id, \"$classe\", \"$identifiant\", this.value)' />";
            echo "<a class='delete-link' href='?objet=$classe&action=delete&$identifiant=$id'>$boutonSupprimer</a>";
            echo "</span>";
            echo "</li>";
        }
        ?>
    </ul>
    <a href="?objet=Alerte&action=displayCreationForm" class="ajouter-alerte-btn">Ajouter Une Alerte</a>
</main>
