<main>
    <ul>
        <?php
        foreach ($tableau as $unElement) {
            $identifiant = static::$identifiant;
            $classe = static::$classe;
            $id = $unElement->get($identifiant); // Accès à la propriété statique
            $lienDetails = "<a class='link' href='?objet=$classe&action=displayOne&$identifiant=$id'>détails</a>";
            $lienSupprimer = "<a class='delete-link' href='?objet=$classe&action=delete&$identifiant=$id'>supprimer</a>";
            echo "<li class='table-row'>";
            echo "<span class='table-cell'>$classe {$unElement->get($identifiant)}</span>";
            echo "<span class='table-cell'>$lienDetails</span>";
            echo "<span class='table-cell'>$lienSupprimer</span>";
            echo "</li>";
        }
        ?>
    </ul>
</main>
