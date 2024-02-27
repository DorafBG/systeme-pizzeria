
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PizzaLand - Edition</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="view/profil/style1.css">
</head>
<body>
 
<div>
<div>
    <h2>Édition du profil</h2>

    <?php
    // Vérifier si le formulaire a été soumis
    if(isset($_POST['submit'])) { 
       // On affiche ce messagee lorsque l'utilisateur appuie sur "Mettre a jour"
        echo '<p class="success-message"><i class="fas fa-check-circle"></i> Modification réussie</p>';
    }
    ?>
    <form method="POST" action="index.php?objet=client&action=displayEditProfil">
    <label for="nom">Nom :</label>
    <input type="text" id="nom" name="nom" value=<?php echo $recupC->get('NomClient'); ?>>

    <label for="prenom">Prénom :</label>
    <input type="text" id="prenom" name="prenom" value=<?php echo $recupC->get('PrenomClient'); ?>>

    <label for="rue">Rue :</label>
    <input type="text" id="rue" name="rue" value=<?php echo $recupC->get('RueClient'); ?>>

    <label for="ville">Ville :</label>
    <input type="text" id="ville" name="ville" value="<?php echo $recupC->get('VilleClient'); ?>">

    <label for="pays">Pays :</label>
    <input type="text" id="pays" name="pays" value="<?php echo $recupC->get('PaysClient'); ?>">

    <label for="tel">Téléphone :</label>
    <input type="tel" id="tel" name="tel" value="<?php echo $recupC->get('TelClient'); ?>">

    <input type="submit" name="submit" value="Mettre à jour">
    
</form>
<a href="index.php" class="button">Quitter</a>
  </div>
</div>



</body>
</html>