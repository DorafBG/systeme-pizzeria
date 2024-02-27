<main>
        <form class="create-form" action="index.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="objet" value="<?php echo $classe; ?>">
            <input type="hidden" name="action" value="create">
            <input type="hidden" name="IDPizzaDefaut" value="<?php echo $idpizzadefaut; ?>">
            <h1>Ajouter une Pizza</h1>
            <div class='form-group'>
                <label class='form-label' for='imagePizza'>Image de la Pizza :</label>
                <input class='form-input' type='file' name='ImagePizza' accept='image/*' required>
            </div>
            <div class='form-group'>
                <label class='form-label' for='nomPizza'>Nom de la Pizza :</label>
                <input class='form-input' type='text' name='NomPizzaDefaut' placeholder='Calzone' required>
            </div>
            <div class='form-group'>
                <label class='form-label' for='descriptionPizza'>Description de la Pizza :</label>
                <input class='form-input' type='text' name='DescriptionPizzaDefaut' placeholder='Une pizza délicieuse ...' required>
            </div>
            <div class='form-group'>
                <label class='form-label' for='prixPizza'>Prix de la Pizza :</label>
                <input class='form-input' type='number' name='PrixPizzaDefaut' placeholder='XX' required>
            </div>

            <input type="hidden" name="PizzaDuMoment" value="0">
            <button class='form-button' type='submit'>Créer</button>
        </form>
    </main>