<main>
    <form class="create-form" action="index.php" method="get">
        <input type="hidden" name="objet" value="<?php echo $classe; ?>">
        <input type="hidden" name="action" value="create">
        <?php
        $class = static::$classe;
        foreach ($champs as $champ => $details) {
            echo "<div class='form-group'>";
            echo "<label class='form-label' for=\"$champ\">$details[1]</label>";
            echo "<input class='form-input' type=\"$details[0]\" name=\"$champ\" placeholder=\"$details[1]\" required>";
            echo "</div>";
        }
        ?>
        <button class='form-button' type="submit">Créer</button>
    </form>
</main>
