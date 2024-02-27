<?php
require_once("model/client.php");
require_once("controllerObjet.php");
class controllerClient extends ControllerObjet {
    protected static $champs = [
        'loginClient' => ['login', 'pseudo'],
        'mdpClient' => ['mdpClient', 'mot de passe'],
        'nomClient' => ['text', 'nom de famille'],
        'prenomClient' => ['text', 'prenom'],
        'rue' => ['text', 'rue'],
        'ville' => ['text', 'ville'],
        'pays' => ['text', 'pays'],
        'tel' => ['tel', 'telephone']
    ];
    public static function displayAddClient() {
        $champs = static::$champs;
        include("view/client/inscription/inscription.php");
    }

    public static function inscription() {
        $donnees = array();
        foreach($_POST as $key => $value){
            if($key != "objet" && $key != "action" && in_array($key, array_keys(static::$champs))){
                $donnees[$key] =$value;
            }
        }      
        $donnees['estGestionnaire'] = 0;
        Client::create($donnees);
        self::connect();
    }
    
    public static function displayConnectionForm(){
        include("view/debut.php");
        include("view/menu.php");

        include("connexion/index.html");

        include("view/fin.php");
    }

    public static function deconnect(){
        session_destroy();
        header("Location: ./index.php");
    }
    public static function displayAll(){
        $classeRecup = static::$classe;
        $title = "PizzaLand - Accueil";
        include("view/debut.php");
        include("view/menu.php");
        $tableau = static::$classe::getAll();
        include("view/pizzadefaut/listPizzaDefaut.php");
        

    }
    public static function connect(){
        if (isset($_GET['loginClient']) && isset($_GET['mdpClient'])) {
            $login = $_GET['loginClient'];
            $mdp = $_GET['mdpClient'];
            if(Client::checkMDP($login,$mdp))
            {
                $user = Client::getOne($login);
                $_SESSION['loginClient'] = $login;
                $_SESSION['IDClient'] = $user->getIDClient();
                // $_SESSION['isAdmin'] = $user->isAdmin();

                header("Location: ./index.php");
            }
            else {
                self::displayConnectionForm();
            }
        }
    }
    public static function createAccount()
    {
        $title = "création d'un client";
        $donnees = array();
        $confirm = $_GET['confirmMdp'];
        $mdp = $_GET['mdpClient'];
    
        // Vérification si les mots de passe correspondent
        if ($confirm != $mdp) {
            echo '<script type="text/javascript">alert("Les mots de passe ne sont pas les mêmes ! Veuillez retaper."); window.history.back();</script>';
        } else {
            // Vérification si le mot de passe contient au moins 8 caractères
            if (strlen($mdp) < 8) {
                echo '<script type="text/javascript">alert("Le mot de passe doit avoir au minimum 8 caractères ! ");</script>';
            } else {
                // Si le mot de passe respecte la contrainte, procédez à la création du compte
                foreach ($_GET as $key => $value) {
                    if ($key != "objet" && $key != "action" && $key != "confirmMdp") {
                        $donnees[$key] = $value;
                    }
                }
                client::create($donnees);
                self::connect();
            }
        }
    }
    

    public static function displayHistorique()
    {
        $title = "historique";
        $idClient = $_SESSION['IDClient'];
        include("view/debut.php");
        include("view/menu.php");
        $client = client::historique($idClient);
        include("view/historique/listHistorique.php");
        include("view/fin.php");
    }


public static function displayProfil(){
    $title = "PizzaLand - Profil";
    include("view/debut.php");
    include("view/menu.php");
    
  if (isset($_SESSION['loginClient'])) {
    // Récupérer les infos du client connecté
    $recupC = Client::getOne($_SESSION['loginClient']);
    $nbCommandes = Client::countOrdersByClient($_SESSION['loginClient']);
    $ptFidelite = $nbCommandes*1.5;
    include("view/profil/index.php");
    include("view/fin.php");
}
}


public static function displayEditProfil(){
    $title = "PizzaLand - Edit Profil";
    
    $recupC = Client::getOne($_SESSION['loginClient']); 
    if(isset($_POST['submit'])) {
        // On appelle la méthode update une fois que l'utilisateur envoie le forualaire
        self::updateProfil();
    }

    include("view/profil/edit.php");
    include("view/fin.php");
    
}

public static function updateProfil() {
$login = $_SESSION['loginClient'];

// Récupérer les informations du formulaire
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$rue = $_POST['rue'];
$ville = $_POST['ville'];
$pays = $_POST['pays'];
$tel = $_POST['tel'];

// Récupérer et mettre à jour 
$client = Client::getOne($login);
$client->set('NomClient', $nom);
$client->set('PrenomClient', $prenom);
$client->set('RueClient', $rue);
$client->set('VilleClient', $ville);
$client->set('PaysClient', $pays);
$client->set('TelClient', $tel);

// Appel de la fonction pour mettre à jour le profil
if($client->update()){
    echo "Veuillez rafraichir la page pour prendre en compte les modifications";
}
}


public static function displayApropos(){
    include("view/debut.php");
    include("view/menu.php");
    include("apropos/index.html");
    include("view/fin.php");
}
}
?>
