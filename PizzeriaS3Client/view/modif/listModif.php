<main>
    <title> PizzaLand - Modification de la Pizza</title>
    <div class="recette-container">
        <?php
        require_once("model/recette.php");
        require_once("model/ingredient.php");
        require_once("model/PizzaDefaut.php");
        foreach ($tableau as $unElement) { 

            $idrecette = $unElement['IDRecette'];
            $identifiant = static::$identifiant;
            $classe = static::$classe;
            $pizzanom = $lapizza->get('NomPizzaDefaut');
            $idPizza = $_GET['IDPizza'];
            $idPanier = $_GET['IDPanier'];
            $ingredients = recette::listIngredient($idrecette);
            $idChoixIngredient = PizzaDefaut::getChoixIngredient($idPizza, $idPanier);
            $ingredientChoix = choixIngredient::listIngredient($idChoixIngredient);


            echo "<div class='recette-content'>";
            $idPizzaDefaut = $lapizza->get("IDPizzaDefaut");

            
            $pathPizza = "img/pizza/{$idPizzaDefaut}.jfif";

            if (file_exists($pathPizza)) {
                $pathPizza = $pathPizza;
            } else {
                // Si l'image n'existe pas, utilise l'image de base
                $pathPizza = "img/pizza/0.png";
            }



            echo "<img class='recette-img' src='$pathPizza' alt='pizza'>";
            echo "<div class='recette-ingredients-container'>";
            echo "<h2 class='recette-title'>Recette de $pizzanom</h2>";
            echo "<ul class='recette-ingredients'>";
            foreach ($ingredients as $ingredient) {
                $idingredient = $ingredient->get("IDIngredient");
                $qtIngredient = recette::quantiteDeLingredientDansLaRecette($idrecette, $idingredient);
                $qtContientIngredient = recette::quantiteDeLingredientDansLeContient($idPizza, $idingredient);
                $ingredientNom = $ingredient->get("NomIngredient");
                if($qtIngredient != 0) {
                    echo "<li class='ingredient-recette-item'>$ingredientNom : $qtIngredient de base</li>";
                }
            }
            foreach($ingredientChoix as $ingredient)
            {
                $idingredient = $ingredient->get("IDIngredient");
                $nbIngredient = recette::quantiteDeLingredientDansLeContient($idPizza, $idingredient);
                $ingredientNom = $ingredient->get("NomIngredient");
                if($nbIngredient != 0) {
                echo "<li class='ingredient-recette-item'>$ingredientNom : $nbIngredient </li>";
                echo "<a href='?objet=PizzaDefaut&action=decremente&IDPizza=$idPizza&IDIngredient=$idingredient&IDPanier=$idPanier&IDChoixIngredient=$idChoixIngredient'><button>Retirer</button></a>";
                echo "<a href='?objet=PizzaDefaut&action=incremente&IDPizza=$idPizza&IDIngredient=$idingredient&IDPanier=$idPanier&IDChoixIngredient=$idChoixIngredient'><button>Ajouter</button></a>";
                }
            }
            echo "</ul>";
            echo "</div>"; // Fin de .recette-ingredients-container
    
            // Ajouter ingrédient
            echo "<div class='tout-ajt'>";
            echo "<form class='create-form' action='index.php' method='get'>";
            echo "<input type='hidden' name='objet' value='$classe'>";
            echo "<input type='hidden' name='action' value='ajout'>";
            echo "<input type='hidden' name='IDPizza' value='{$idPizza}'>";
            echo "<input type='hidden' name='IDChoixIngredient' value='{$idChoixIngredient}'>";
            echo "<input type='hidden' name='IDPanier' value='{$idPanier}'>";
    
            echo "<h3 class='add-ingredient-title'>Ajouter un Ingrédient</h3>";
            echo "<div class='ingredient-section'>";
            echo "<div class='form-group'>";
            echo "<label class='form-label' for='ingredient[]'>Ingrédient :</label>";
            echo "<select class='form-input' name='IDIngredient' required>"; // Change name to 'IDIngredient'
            // Récupérer tous les ingrédients depuis la base de données
            $ingredients = ingredient::getAll();
            // Afficher chaque ingrédient dans le menu déroulant
            foreach ($ingredients as $ingredient) {
                $idIngredient = $ingredient->get('IDIngredient');
                $nomIngredient = $ingredient->get('NomIngredient');
                echo "<option value='$idIngredient'>$nomIngredient</option>";
            }
            echo "</select>";
            echo "</div>";
            echo "<div class='form-group'>";
            // Vous pouvez ajouter d'autres champs ou éléments ici selon vos besoins
            echo "</div>";
            echo "</div>";
            echo "<div id='ingredient-container'></div>";
            echo "<button type='submit' class='form-button'>Ajouter</button>"; // Change the button type to submit
            echo "</form>";
            echo "</div>";
            // retirer un ingredient
            echo "<form class='create-form' action='index.php' method='get'>";
            echo "<input type='hidden' name='objet' value='$classe'>";
            echo "<input type='hidden' name='action' value='retrait'>";
            echo "<input type='hidden' name='IDPizza' value='{$idPizza}'>";
            echo "<input type='hidden' name='IDChoixIngredient' value='{$idChoixIngredient}'>";
            echo "<input type='hidden' name='IDPanier' value='{$idPanier}'>";
            echo "<h3 class='add-ingredient-title'>Retirer un Ingrédient</h3>";
            echo "<div class='ingredient-section'>";
            echo "<div class='form-group'>";
            echo "<label class='form-label' for='ingredient[]'>Ingrédient :</label>";
            echo "<select class='form-input' name='IDIngredient' required>"; // Change name to 'IDIngredient'
            // Récupérer tous les ingrédients de la pizza depuis la base de données
            $ingredients = recette::listIngredient($idrecette);
            // Afficher chaque ingrédient dans le menu déroulant
            foreach ($ingredients as $ingredient) {
                $idIngredient = $ingredient->get('IDIngredient');
                $nbIngredient = recette::quantiteDeLingredientDansLeContient($idPizza, $idIngredient);
                $nomIngredient = $ingredient->get('NomIngredient');
                echo "<option value='$idIngredient'>$nomIngredient</option>";
                echo $nbIngredient;
                if($nbIngredient != 0) {
                echo "<li class='ingredient-recette-item'>$ingredientNom : $nbIngredient </li>";
                echo "<a href='?objet=PizzaDefaut&action=decremente&IDPizza=$idPizza&IDIngredient=$idIngredient&IDPanier=$idPanier&IDChoixIngredient=$idChoixIngredient'><button>Retirer</button></a>";
                echo "<a href='?objet=PizzaDefaut&action=incremente&IDPizza=$idPizza&IDIngredient=$idIngredient&IDPanier=$idPanier&IDChoixIngredient=$idChoixIngredient'><button>Ajouter</button></a>";
                }
            }
            echo "</select>";
            echo "</div>";
            echo "</div>";
            echo "<button type='submit' class='form-button'>Retirer</button>"; // Change the button type to submit
            echo "</form>";
            echo "<br>";
        }
            echo "<a href='?objet=panier'><button class='validate-button'>Valider</button></a>";
            echo "</div>"; // Fin de .recette-content
            echo "</div>"; // Fin de .recette-item
        
        ?>
        </ul>
    </div>
</main>
