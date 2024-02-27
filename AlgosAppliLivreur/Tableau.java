import java.sql.*;
import java.sql.Date;
import java.util.*;

public class Tableau {

    private ArrayList<Commande> lesCommandes;

    public Tableau() {
        lesCommandes = new ArrayList<>();
        remplirCommandesDepuisBDD();
    }

    public ArrayList<Commande> getLesCommandes() {
        return lesCommandes;
    }

    public void setLesCommandes(ArrayList<Commande> lesCommandes) {
        this.lesCommandes = lesCommandes;
    }
    


    private void remplirCommandesDepuisBDD() {
        Connection connection = null;
        PreparedStatement statement = null;
        ResultSet resultSet = null;

        try {
            
        	Class.forName("com.mysql.cj.jdbc.Driver");

            
            String url="";
            String utilisateur = "";
            String motDePasse = "";
            
            
            
            connection = DriverManager.getConnection(url, utilisateur, motDePasse);
           
            
            

            
            String query = "SELECT * FROM Commande NATURAL JOIN Client;";
            statement = connection.prepareStatement(query);
            resultSet = statement.executeQuery();

            
            while (resultSet.next()) {
                int idCommande = resultSet.getInt("IDCommande");
                Date dateCommande = resultSet.getDate("DateCommande");
                int idClient = resultSet.getInt("IDClient");
                String nClient = resultSet.getString("NomClient");
                String pClient = resultSet.getString("PrenomClient");
                String rueClient = resultSet.getString("RueClient");
                String villeClient = resultSet.getString("VilleClient");
                String paysClient = resultSet.getString("PaysClient");
                String telClient = resultSet.getString("TelClient");
                
                Adresse aClient = new Adresse (rueClient, villeClient, paysClient);
                
                lesCommandes.add(new Commande(idCommande, new Client(idClient, nClient, pClient, aClient, telClient), aClient, dateCommande));
                System.out.println("Commande ajoute!");
            }
        } catch (ClassNotFoundException | SQLException e) {
            e.printStackTrace();
        } finally {
            
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
  
    }
        
}
