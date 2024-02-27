<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>PizzaLand - S'inscrire</title>
  <link rel="shortcut icon" href="../img/PIZZALAND.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="inscription.css">
  <link rel="stylesheet" href="../style.css">
</head>

<header>
        <div class="wrapper">
            <a href="../index.php"> <img id="Agauche" src="../img/PIZZALAND.png" alt="Logo"></a>
            <a class="navBar" href="../index.php">Pizzas</a>

            <div class="navBar">
                <a class="navBar" href="../?objet=Produit">Produits</a>
                <div class="sub-menu">
                    <a href="../?objet=Produit&action=listTypeProduit&TypeProduit=Gateau">Gâteaux</a>
                    <a href="../?objet=Produit&action=listTypeProduit&TypeProduit=Fruits">Fruits</a>
                    <a href="../?objet=Produit&action=listTypeProduit&TypeProduit=Boisson">Boissons</a>
                    <a href="../?objet=Produit&action=listTypeProduit&TypeProduit=Glace">Glaces</a>
                </div>
              </div>

            
            <a class="navBar" href="../?objet=client&action=displayApropos">A propos</a>

            <?php
if (!isset($_SESSION["loginClient"])) {
  echo '<a class="navBar" href="../?objet=client&action=displayConnectionForm">Connexion</a>';
} else {
  echo '<div class="navBar">';
  echo '   <a class="navBar" href="../?objet=client&action=displayProfil">Profil</a>';
  echo '   <div class="sub-menu">';
  echo '       <a href="../?objet=client&action=displayProfil">Voir Profil</a>';
  echo '       <a href="../?objet=client&action=displayHistorique">Historique des commandes</a>';
  echo '       <a href="../?objet=client&action=deconnect">Déconnexion</a>';
  echo '   </div>';
  echo '</div>';
}

            if (!isset($_SESSION["loginClient"])) {
                echo "<a href='../?objet=panier'><img id='Adroite' src='../img/panier0.png' alt='Panier'></a>";
            } else {
                include_once("model/panier.php");
                $clientConnecte = $_SESSION["IDClient"];
                $panierActuel = Panier::getPanierDeClient($clientConnecte);
                $idpanieractuel = $panierActuel->get("IDPanier");

                $nbElements = Panier::nbElementsDansPanier($idpanieractuel);
                $panierImgSrc = ($nbElements >= 0 && $nbElements <= 9) ? "panier$nbElements.png" : "panier9Plus.png";
                $idAdroite = ($nbElements == 0) ? "Adroite" : "AdroiteRempli";
                echo "<a href='../?objet=panier'><img id='$idAdroite' src='../img/$panierImgSrc' alt='Panier'></a>";
                
            }
            ?>

        </div>
    </header>


<body>



  
     <?php

    // if ($_SERVER["REQUEST_METHOD"] == "POST"){
    //   $mdpClient = $_POST['mdpClient'];
    //   $confirmMdp = $_POST['confirmMdp'];
  
    //   // Vérification de la confirmation de mot de passe
    //   if ($mdpClient != $confirmMdp) {
    //       echo "Retapez votre mot de passe de confirmation";
    //   }
    // }

    ?> 
  
   


  <section class="container">
    <h3>Inscrivez-vous à PizzaLand 🔥 </h3>
    <form action="../index.php" method="get">
      <input type="hidden" name="objet" value="client">
      <input type="hidden" name="action" value="createAccount">

      <div class="input-box">
        <label for="nom">
          <i class="fas fa-user"></i>

        </label>
        <input type="text" id="nom" name="NomClient" placeholder="Entrez votre nom" required />
        
      </div>
      <div class="input-box">
        <label for="prenom">
          <i class="fas fa-user"></i>
          
        </label>
        <input type="text" id="prenom" name="PrenomClient" placeholder="Entrez votre prénom" required />

      </div>

      <div class="input-box">
        <label for="tel">
          <i class="fas fa-phone"></i>
        </label>
        <input type="tel" id="tel" name="TelClient" placeholder="Entrez votre numéro de téléphone" required />
      </div>
      <div class="input-box">
        <label for="pays">
          <i class="fas fa-globe"></i>
          
        </label>
        <input type="text" id="pays" name="PaysClient" placeholder="De quel pays venez vous ?" required />
      </div>
      <div class="input-box">
        <label for="ville">
          <i class="fas fa-map-marker-alt"></i>
          
        </label>
        <input type="text" id="ville" name="VilleClient" placeholder="Entrez votre ville" required />
      </div>
      <div class="input-box">
        <label for="rue">
          <i class="fas fa-map-marker-alt"></i>

        </label>
        <input type="text" id="rue" name="RueClient" placeholder="Entrez votre rue" required />
      </div>
      <div class="input-box">
        <label for="login">
          <i class="fas fa-user"></i>
          
        </label>
        <input type="text" id="login" name="loginClient" placeholder="Entrez votre nom d'utilisateur (votre login)" required />
      </div>
      <div class="input-box">
        <label for="mdp">
          <i class="fas fa-lock"></i>
         
        </label>
        <input type="password" id="motdepasse" name="mdpClient" placeholder="Entrez votre mot de passe" required />
        <p class="mdp-rappel">Votre mot de passe doit contenir au moins 8 caractères</p>
      </div>
      </div>
      <div class="input-box">
        <label for="confirm-mdp">
          <i class="fas fa-lock"></i>
          
        </label>
        <input type="password" id="confirm-mdp" name="confirmMdp" placeholder="Confirmez votre mot de passe" required />
       
      </div>
     <div class="input-row">
        <div class="input-box checkbox">
          <label for="accepter">En créant un compte : j'accepte les conditions générales et la politique de confidentialité</label>
        </div>
      </div>
        <button type="submit">Envoyer</button>
      </form>
    </form>
  </section>
  <?php include_once("../view/fin.php"); ?>
</body>
</html>