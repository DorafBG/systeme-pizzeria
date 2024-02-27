<header>
        <div class="wrapper">
            <a class="navBar" href="index.php">Accueil</a>

            <div class="navBar">
                <a class="navBar" href="?objet=Produit">Produits</a>
                <div class="sub-menu">
                    <a href="?objet=Produit&action=listTypeProduit&TypeProduit=Gateau">Gâteau</a>
                    <a href="?objet=Produit&action=listTypeProduit&TypeProduit=Fruits">Fruits</a>
                    <a href="?objet=Produit&action=listTypeProduit&TypeProduit=Boisson">Boisson</a>
                    <a href="?objet=Produit&action=listTypeProduit&TypeProduit=Glace">Glace</a>
                </div>
              </div>

            
            <a class="navBar" href="?objet=apropos">A propos</a>

            <?php
if (!isset($_SESSION["loginClient"])) {
  echo '<a class="navBar" href="?objet=client&action=displayConnectionForm">Connexion</a>';
} else {
  echo '<div class="navBar">';
  echo '   <a class="navBar" href="#">Profil</a>';
  echo '   <div class="sub-menu">';
  echo '       <a href="?objet=client&action=displayProfil">Voir Profil</a>';
  echo '       <a href="?objet=client&action=deconnect">Déconnexion</a>';
  echo '   </div>';
  echo '</div>';
}

            if (!isset($_SESSION["loginClient"])) {
                echo "<a href='?objet=panier'><img id='Adroite' src='./img/panier0.png' alt='Panier'></a>";
            } else {
                include_once("model/panier.php");
                $clientConnecte = $_SESSION["IDClient"];
                $panierActuel = Panier::getPanierDeClient($clientConnecte);
                $idpanieractuel = $panierActuel->get("IDPanier");

                $nbElements = Panier::nbElementsDansPanier($idpanieractuel);
                $panierImgSrc = ($nbElements >= 0 && $nbElements <= 9) ? "panier$nbElements.png" : "panier9Plus.png";
                echo "<a href='?objet=panier'><img id='Adroite' src='./img/$panierImgSrc' alt='Panier'></a>";
            }
            ?>

        </div>
    </header>