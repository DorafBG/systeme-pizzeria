<main>

<div class="allergene-container">
<?php
    echo "<h2 class='allergene-title'>Liste allergène de $pizzanom</h2>";
    echo "<ul class='allergene-list'>";
        foreach ($tableau as $unElement) {
            $nomAllergene = $unElement->get('NomAllergene');
            
            echo "<li class='allergene-item'>$nomAllergene</li>";
        }
        ?>
    </ul>
</div>

    </main>