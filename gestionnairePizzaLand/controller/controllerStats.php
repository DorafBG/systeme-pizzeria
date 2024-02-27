<?php
require_once("controller/controllerObjet.php");

class controllerStats extends controllerObjet {

    public static function displayAll() {
        $title = "PizzaLandGestion - Les Statistiques";
        include("view/debut.php");
        include("view/menu.html");
    
        // Récupérer les données pour le graphique
        $data = self::getCetteAnneeVentes();
        $ca = self::chiffreDaffaires();
    
        // Affichage des statistiques
        echo "<h1 class='titreStats'>Statistiques des ventes</h1>";
        echo "<h1 class='titreStats'>Chiffres d'affaires : $ca €</h1>";
        echo "<label class='select'>";
        echo "<select id='periodeSelector' onchange='updateGraph()'>
        <option value='cetteAnnee'>Cette année (2023)</option>
        <option value='moisActuel'>Mois actuel</option>
        <option value='cetteSemaine'>Cette semaine</option>
      </select>";
      echo "</label>";
    
        echo "<div class='graphStats'><canvas id='salesChart'></canvas></div>";
        // Générer le script JavaScript pour le graphique
        echo "<script src='https://cdn.jsdelivr.net/npm/chart.js'></script>";
        echo "<script>
            var ctx = document.getElementById('salesChart').getContext('2d');
            var salesChart;
        
            function updateGraph() {
                var periodeSelector = document.getElementById('periodeSelector');
                var selectedPeriode = periodeSelector.options[periodeSelector.selectedIndex].value;
        
                switch (selectedPeriode) {
                    case 'cetteAnnee':
                        loadGraphData(" . json_encode(self::getCetteAnneeVentes()) . ");
                        break;
                    case 'moisActuel':
                        loadGraphData(" . json_encode(self::getMoisActuelVentes()) . ");
                        break;
                    case 'cetteSemaine':
                        loadGraphData(" . json_encode(self::getCetteSemaineVentes()) . ");
                        break;
                    default:
                        break;
                }
            }
        
            function loadGraphData(data) {
                if (salesChart) {
                    salesChart.destroy();
                }
        
                salesChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Montant total des commandes (€)',
                            data: data.values,
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }
        
            // Appeler updateGraph() au chargement de la page
            updateGraph();
        </script>";
        
    
        include("view/fin.php");
    }
    
    private static function getCetteAnneeVentes() {
        // Utiliser la fonction SQL pour calculer le montant total des paniers par mois
        $query = "SELECT MONTH(DateCommande) as mois, SUM(prixTotal(IDPanier)) as montant
                  FROM Commande
                  GROUP BY MONTH(DateCommande)";
        $result = connexion::pdo()->query($query);
    
        // Initialiser les tableaux pour les labels et les valeurs
        $labels = [];
        $values = [];
    
        // Initialiser un tableau pour stocker les montants par mois
        $monthlyData = [];
    
        // Parcourir les résultats et remplir le tableau avec les montants par mois
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $monthlyData[$row['mois']] = $row['montant'];
        }
    
        // Parcourir tous les mois de l'année (1 à 12)
        for ($mois = 1; $mois <= 12; $mois++) {
            $labels[] = "Mois " . $mois;
            $values[] = isset($monthlyData[$mois]) ? $monthlyData[$mois] : 0;
        }
    
        return ['labels' => $labels, 'values' => $values];
    }

    public static function chiffreDaffaires(){
        $requetePreparee = "SELECT SUM(prixTotal(IDPanier)) FROM Panier NATURAL JOIN Commande;";
        $resultat = connexion::pdo()->prepare($requetePreparee);
        try{
            $resultat->execute();
            $resultat->setFetchmode(PDO::FETCH_ASSOC);
            $element = $resultat->fetchColumn();
            return $element;
        } catch (PDOException $e){
            echo $e->getMessage();
        }
    }


    private static function getMoisActuelVentes() {
        // Utiliser la fonction SQL pour calculer le montant total des paniers par semaine pour le mois actuel
        $query = "SELECT WEEK(DateCommande, 1) as semaine, COALESCE(SUM(prixTotal(IDPanier)), 0) as montant
                  FROM Commande
                  WHERE MONTH(DateCommande) = MONTH(CURDATE())
                  GROUP BY WEEK(DateCommande, 1)";
        $result = connexion::pdo()->query($query);
    
        // Initialiser les tableaux pour les labels et les valeurs
        $labels = [];
        $values = [];
    
        // Parcourir tous les numéros de semaine possibles (1 à 4)
        for ($semaine = 1; $semaine <= 4; $semaine++) {
            $labels[] = "Semaine " . $semaine;
            $montant = 0;
    
            // Si la semaine existe dans les résultats de la requête, mettre à jour le montant
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row['semaine'] == $semaine) {
                    $montant = $row['montant'];
                    break;
                }
            }
    
            $values[] = $montant;
            // Réinitialiser le curseur pour permettre la lecture à partir du début lors de la prochaine itération
            $result->execute();
        }
    
        return ['labels' => $labels, 'values' => $values];
    }
    


    private static function getCetteSemaineVentes() {
        // Utiliser la fonction SQL pour calculer le montant total des paniers par jour pour cette semaine
        $query = "SELECT DAYOFWEEK(DateCommande) as jourSemaine, COALESCE(SUM(prixTotal(IDPanier)), 0) as montant
                  FROM Commande
                  WHERE WEEK(DateCommande, 1) = WEEK(CURDATE(), 1)
                  GROUP BY DAYOFWEEK(DateCommande)";
        $result = connexion::pdo()->query($query);
    
        // Initialiser les tableaux pour les labels et les valeurs
        $labels = [];
        $values = [];
    
        // Parcourir tous les jours de la semaine possibles (1 à 7)
        for ($jour = 1; $jour <= 7; $jour++) {
            $labels[] = "Jour " . $jour;
            $montant = 0;
    
            // Si le jour existe dans les résultats de la requête, mettre à jour le montant
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                if ($row['jourSemaine'] == $jour) {
                    $montant = $row['montant'];
                    break;
                }
            }
    
            $values[] = $montant;
            // Réinitialiser le curseur pour permettre la lecture à partir du début lors de la prochaine itération
            $result->execute();
        }
    
        return ['labels' => $labels, 'values' => $values];
    }
    
    
    
    

    // Fonction pour obtenir le total des recettes
    private static function getTotalRecettes() {
        $query = "SELECT COUNT(*) FROM Recette";
        $result = connexion::pdo()->query($query);
        return $result->fetchColumn();
    }

    // Fonction pour obtenir la moyenne d'ingrédients par recette
    private static function getMoyenneIngredients() {
        $query = "SELECT AVG(ingredient_count) FROM (SELECT COUNT(IDIngredient) as ingredient_count FROM est_composee GROUP BY IDRecette) as ingredient_counts";
        $result = connexion::pdo()->query($query);
        return $result->fetchColumn();
    }
    

    // Fonction pour obtenir le total des allergènes utilisés
    private static function getTotalAllergenes() {
        $query = "SELECT COUNT(DISTINCT IDAllergene) FROM recette_comprend";
        $result = connexion::pdo()->query($query);
        return $result->fetchColumn();
    }
}
?>
