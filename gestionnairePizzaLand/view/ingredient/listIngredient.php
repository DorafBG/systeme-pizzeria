<main>
    <ul>
        <?php
        foreach ($tableau as $unElement) {
            $nomIngredient = $unElement->get('NomIngredient');
            $stockIngredient = $unElement->get('QtIngredientStock');

            $identifiant = static::$identifiant;
            $classe = static::$classe;
            $id = $unElement->get($identifiant);

            echo "<li class='table-row'>";
            echo "<span class='table-cell ingredient-name'>$nomIngredient</span>";
            echo "<span class='table-cell quantity-buttons'>";
            echo "<a class='quantity-button' href='?objet=$classe&action=decremente&$identifiant=$id'>-</a>";
            echo "<span class='quantity'>$stockIngredient</span>";
            echo "<a class='quantity-button' href='?objet=$classe&action=incremente&$identifiant=$id'>+</a>";
            echo "</span>";
            echo "</li>";
        }
        ?>
    </ul>
</main>
