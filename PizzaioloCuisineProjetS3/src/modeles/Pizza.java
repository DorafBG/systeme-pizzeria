package modeles;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.*;

public class Pizza {

	private int IDPizza;
	private String NomPizzaDefaut;
	private boolean estCuisine;
	public ArrayList<Ingredient> lesIngredients; //ajoute ou supprime de la pizza
	
	public Pizza(int IDPizza, String NomPizzaDefaut, boolean estCuisine) {
		this.IDPizza = IDPizza;
		this.NomPizzaDefaut = NomPizzaDefaut;
		this.estCuisine = estCuisine;
		lesIngredients = new ArrayList<>();
		remplirIngredients();
		
	}
	
	private void remplirIngredients() {
        Connection connection = null;
        PreparedStatement statement = null;
        ResultSet resultSet = null;

        try {
            // Charger le pilote JDBC
        	Class.forName("com.mysql.cj.jdbc.Driver");

            // Établir une connexion à la base de données
            String url="";
            String utilisateur = "";
            String motDePasse = "";
            
            connection = DriverManager.getConnection(url, utilisateur, motDePasse);
           
            // Exécuter la requête pour récupérer les commandes
            String query = "SELECT * FROM Pizza NATURAL JOIN ChoixIngredient NATURAL JOIN contient_ingredients NATURAL JOIN Ingredient WHERE IDPizza = " + IDPizza + ";";
            statement = connection.prepareStatement(query);
            resultSet = statement.executeQuery();

            // Parcourir les résultats et créer des objets ingredients
            while (resultSet.next()) {
                int idingredient = resultSet.getInt("IDIngredient");
                String nomingredient = resultSet.getString("NomIngredient");
                int nbingredients = resultSet.getInt("nbIngredients");
                
                // Création de la pizza
                Ingredient lingredient = new Ingredient(idingredient, nomingredient, nbingredients);
                lesIngredients.add(lingredient);
                System.out.println("Ingredient ajouté dans pizza : " + IDPizza+ ": " + nomingredient);

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
	
	public ArrayList<ArrayList<Object>> ingredientsRecette() throws SQLException{
		ArrayList<ArrayList<Object>> lesIngredientsDeLaRecette = new ArrayList<>();
	    Connection connection = null;
	    PreparedStatement statement = null;
	    ResultSet resultSet = null;

	    try {
	        // Charger le pilote JDBC
	        Class.forName("com.mysql.cj.jdbc.Driver");

	        // Établir une connexion à la base de données
	        String url = "";
	        String utilisateur = "";
	        String motDePasse = "";
	        connection = DriverManager.getConnection(url, utilisateur, motDePasse);
	        
            String query = "SELECT NomIngredient, qtIngredientRecette FROM Pizza NATURAL JOIN PizzaDefaut NATURAL JOIN Recette NATURAL JOIN est_composee NATURAL JOIN Ingredient WHERE IDPizza = " + this.IDPizza + ";";
            statement = connection.prepareStatement(query);
            resultSet = statement.executeQuery();

            while (resultSet.next()) {
            	ArrayList<Object> unIngredientEtSaQuantite = new ArrayList<>();
                String nomIngredient = resultSet.getString("NomIngredient");
                int qtingredientrecette = resultSet.getInt("qtIngredientRecette");
                
                unIngredientEtSaQuantite.add(nomIngredient);
                unIngredientEtSaQuantite.add(qtingredientrecette);
                
                lesIngredientsDeLaRecette.add(unIngredientEtSaQuantite);                
            }
            
            return lesIngredientsDeLaRecette;
           
	        
	        
	    } catch (ClassNotFoundException e) {
	        e.printStackTrace();
	    } finally {
	        // Fermer les ressources (Statement, Connection)
	        try {
	            if (statement != null) statement.close();
	            if (connection != null) connection.close();
	        } catch (SQLException e) {
	            e.printStackTrace();
	        }
	    }
		return lesIngredientsDeLaRecette;
        
        
	}
	
	@SuppressWarnings("resource")
	public void pizzaDevientPrete(int numPizza) {
	    Connection connection = null;
	    PreparedStatement statement = null;

	    try {
	        // Charger le pilote JDBC
	        Class.forName("com.mysql.cj.jdbc.Driver");

	        // Établir une connexion à la base de données
	        String url = "";
	        String utilisateur = "";
	        String motDePasse = "";

	        connection = DriverManager.getConnection(url, utilisateur, motDePasse);

	        // Exécuter la requête pour mettre à jour la pizza
	        String query = "UPDATE Pizza SET estCuisine = true WHERE IDPizza = ?";
	        System.out.println("Modification de Pizza numero : " + numPizza);
	        statement = connection.prepareStatement(query);
	        statement.setInt(1, numPizza);
	        statement.execute();
	        System.out.println("Pizza mise à jour !");
	        
	
	    } catch (ClassNotFoundException | SQLException e) {
	        e.printStackTrace();
	    } finally {
	        // Fermer les ressources (Statement, Connection)
	        try {
	            if (statement != null) statement.close();
	            if (connection != null) connection.close();
	        } catch (SQLException e) {
	            e.printStackTrace();
	        }
	    }
	}
	
	public int getIDPizza() {
		return IDPizza;
	}
	public void setIDPizza(int iDPizza) {
		IDPizza = iDPizza;
	}
	public String getNomPizzaDefaut() {
		return NomPizzaDefaut;
	}
	public void setNomPizzaDefaut(String nomPizzaDefaut) {
		NomPizzaDefaut = nomPizzaDefaut;
	}
	public boolean isEstCuisine() {
		return estCuisine;
	}
	public void setEstCuisine(boolean estCuisine) {
		this.estCuisine = estCuisine;
	}
	public ArrayList<Ingredient> getIngredients(){
		return lesIngredients;
	}
	public String toString() {
		return "Pizza n°"+IDPizza+" : '" + NomPizzaDefaut + "'";
	}

}