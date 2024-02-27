
<head>
    <title>PizzaLand - Profil</title>
    <link rel="stylesheet" type="text/css" href="view/profil/style.css">
</head>

  <div class="card">
  <div class="left-container">
      
  
    <img class='pp' src="view/profil/img/pizza1.jpg" alt="Profile Image">
    <h2 class="gradienttext"><?php echo $recupC->get('PrenomClient'); echo " "; echo $recupC->get('NomClient'); ?></h2>
    <p style='color: #ffbf63;'>Votre Profil</p>
    <button class ="boutton1">
      <div>
      <div class="default-btn">
        <svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round" fill="none" stroke-width="2" stroke="#FFF" height="20" width="20" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle r="3" cy="12" cx="12"></circle></svg>
        <span>Offre du moment</span>
      </div>
      <div class="hover-btn">
        <svg class="css-i6dzq1" stroke-linejoin="round" stroke-linecap="round" fill="none" stroke-width="2" stroke="#ffd300" height="20" width="20" viewBox="0 0 24 24"><circle r="1" cy="21" cx="9"></circle><circle r="1" cy="21" cx="20"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
        <a href="index.php"><span>Commandez vite !!!</span></a>
      </div>
      </div>
    </button>

    <br> </br>

    <a href="index.php?objet=client&action=displayEditProfil"><button class="button-5" role="button">Modifier votre profil</button></a>

 
  </div>
  <div class="right-container">
    <h3 class="gradienttext">Détails de votre profil</h3>
    <table>
        <tr>
        <td>Login : <?php echo $recupC->getLoginClient(); ?><td>
        </tr>
        <tr>
        <td>Nom : <?php echo $recupC->get('NomClient'); ?></td>
      </tr>
      <tr>
      <td>Prénom : <?php echo $recupC->get('PrenomClient'); ?></td>
      </tr>
      <tr>
      <td>Rue: <?php echo $recupC->get('RueClient'); ?></td>
      </tr>
      <tr>
      <td>Ville: <?php echo $recupC->get('VilleClient'); ?></td>
      </tr>
      <tr>
      <td>Pays : <?php echo $recupC->get('PaysClient'); ?></td>
      </tr> 
      <tr>
      <td>Téléphone : <?php echo $recupC->get('TelClient'); ?></td>
      </tr> 
    </table>
    
    <div class="loyalty-section">
      <h3 class="gradienttext">Votre fidelité</h3>
      <p class='fideliteP'>Commandes: <?php echo $nbCommandes; ?></p>
      <p class='fideliteP'>Point de fidelité: <?php echo $ptFidelite; ?></p>
    </div>
  </div>

</div>