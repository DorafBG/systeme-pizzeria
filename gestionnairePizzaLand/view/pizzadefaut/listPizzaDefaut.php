<main>
    <ul>
        <?php
        foreach ($tableau as $unElement) {
            $nomPizza = $unElement->get('NomPizzaDefaut');
            $idPizza = $unElement->get('IDPizzaDefaut');
            $idAllergenesBouton = "allergensButton_$idPizza";
            $idRecettesBouton = "recettesBouton_$idPizza";


            $recettesBouton = "<a class='recipes-button' id='$idRecettesBouton' href='#'>Recettes</a>";
            $pizzaDuMomentButton = $unElement->get('PizzaDuMoment') ?
                "<a class='pizza-du-moment-button red-button' href='?objet=PizzaDefaut&action=setPizzaDuMoment&IDPizzaDefaut=$idPizza&PizzaDuMoment=0'>Pizza Du Moment</a>" :
                "<a class='pizza-du-moment-button gray-button' href='?objet=PizzaDefaut&action=setPizzaDuMoment&IDPizzaDefaut=$idPizza&PizzaDuMoment=1'>Pizza Du Moment</a>";



            echo "<li class='table-row'>";
            echo "<span class='table-cell pizza-name'>$nomPizza</span>";
            echo "<span class='table-cell'><a class='allergens-button' id='$idAllergenesBouton' href='#'>Liste allergènes</a></span>";
            echo "<span class='table-cell'>$recettesBouton</span>";
            echo "<span class='table-cell'>$pizzaDuMomentButton</span>";
            echo "</li>";

            echo "<script>
            document.getElementById('$idAllergenesBouton').addEventListener('click', function(event) {
                event.preventDefault();
                window.open('?objet=PizzaDefaut&action=listAllergenes&IDPizzaDefaut=$idPizza', 'AllergenesPopup', 'width=500,height=500');
            });

            document.getElementById('$idRecettesBouton').addEventListener('click', function(event) {
                event.preventDefault();
                window.open('?objet=PizzaDefaut&action=listRecettes&IDPizzaDefaut=$idPizza', 'RecettePopup', 'width=500,height=500');
            });
          </script>";
        }
        echo "<a href='?objet=PizzaDefaut&action=displayCreationForm' class='ajouter-alerte-btn'>Ajouter Une Pizza</a>";
        ?>
    </ul>
</main>
