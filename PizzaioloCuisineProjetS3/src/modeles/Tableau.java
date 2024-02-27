package modeles;
import java.sql.*;
import java.util.ArrayList;

public class Tableau {

    private ArrayList<Commande> lesCommandes;

    public Tableau() {
    	System.out.println("Tableau en cours de création ..");
        lesCommandes = new ArrayList<>();
        remplirCommandesDepuisBDD();
    }

    public ArrayList<Commande> getLesCommandes() {
        return lesCommandes;
    }

    public void setLesCommandes(ArrayList<Commande> lesCommandes) {
        this.lesCommandes = lesCommandes;
    }
    
    public void addCommande(Commande c) {
    	lesCommandes.add(c);
    }

    public void remplirCommandesDepuisBDD() {
        Connection connection = null;
        PreparedStatement statement = null;
        ResultSet resultSet = null;
        
        lesCommandes = null;
        lesCommandes = new ArrayList<>();
        

        try {
            // Charger le pilote JDBC
        	Class.forName("com.mysql.cj.jdbc.Driver");

            // Établir une connexion à la base de données
            String url="";
            String utilisateur = "";
            String motDePasse = "";
            
            connection = DriverManager.getConnection(url, utilisateur, motDePasse);
           
            // Exécuter la requête pour récupérer les commandes
            String query = "SELECT * FROM Commande INNER JOIN Panier ON Commande.IDPanier = Panier.IDPanier INNER JOIN Pizza ON Panier.IDPanier = Pizza.IDPanier INNER JOIN PizzaDefaut ON Pizza.IDPizzaDefaut = PizzaDefaut.IDPizzaDefaut WHERE estCuisine = FALSE ORDER BY IDCommande;";
            statement = connection.prepareStatement(query);
            resultSet = statement.executeQuery();

            // Parcourir les résultats et créer des objets Commande
            while (resultSet.next()) {
                int idCommande = resultSet.getInt("IDCommande");
                
                Timestamp dateCommande = resultSet.getTimestamp("DateCommande");
                
                int idpizza = resultSet.getInt("IDPizza");
                String nompizzadefaut = resultSet.getString("NomPizzaDefaut");
                boolean estCuisine = resultSet.getBoolean("estCuisine");
                
                // Création de la pizza
                Pizza laPizza = new Pizza(idpizza, nompizzadefaut, estCuisine);

                // Vérification si la commande existe déjà dans la liste
                boolean commandeExistante = false;
                for (Commande existingCommande : lesCommandes) {
                    if (existingCommande.getIDCommande() == idCommande) {
                    	System.out.println("La commande existe déjà : " + existingCommande.getIDCommande());
                        existingCommande.ajouterPizza(laPizza);
                        commandeExistante = true;
                        break; 
                    }
                }

                if (!commandeExistante) {
                	System.out.println("nv commande");
                    Commande laCommande = new Commande(idCommande, dateCommande);
                    laCommande.ajouterPizza(laPizza);
                    lesCommandes.add(laCommande);
                }
            }
        } catch (ClassNotFoundException | SQLException e) {
            e.printStackTrace();
        } finally {
            // Fermer les ressources (ResultSet, Statement, Connection)
            try {
                if (resultSet != null) resultSet.close();
                if (statement != null) statement.close();
                if (connection != null) connection.close();
            } catch (SQLException e) {
                e.printStackTrace();
            }
        }     
    }
    
    public static void main(String[] args) {
    	Tableau t1 = new Tableau();
    	System.out.println("Voici : " + t1.getLesCommandes());
  
    }
        
}
