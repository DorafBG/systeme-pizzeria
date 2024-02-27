import java.sql.Connection;
import java.sql.Date;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.time.Duration;
import java.time.LocalDateTime;
import java.util.ArrayList;

public class Commande {
	
	static private ArrayList<Livreur> livreurs;
	
	private int idCommande;
	private Adresse sonAdresse;
	private Client sonClient;
	private Date dateCommande;
	
	public Commande(int i, Client c, Adresse a, Date d) {
		this.idCommande = i;
		this.sonAdresse = a;
		this.sonClient = c;
		this.dateCommande = d;
		
		if(livreurs == null) {
			livreurs = new ArrayList<Livreur>();

			
		      Connection connection = null;
		        PreparedStatement statement = null;
		        ResultSet resultSet = null;

		        try {
		            
		        	Class.forName("com.mysql.cj.jdbc.Driver");

		            
		            String url="";
		            String utilisateur = "";
		            String motDePasse = "";
		            
		            
		            
		            connection = DriverManager.getConnection(url, utilisateur, motDePasse);
		           
		            
		            

		            
		            String query = "SELECT * FROM Livreur;";
		            statement = connection.prepareStatement(query);
		            resultSet = statement.executeQuery();

		            
		            while (resultSet.next()) {
		                int idLivreur = resultSet.getInt("IDLivreur");
		                String nomLivreur = resultSet.getString("NomLivreur");
		                String prenomLivreur = resultSet.getString("PrenomLivreur");
		                
		                Livreur unLivreur = new Livreur (idLivreur, nomLivreur, prenomLivreur);
		                
		                livreurs.add(unLivreur);
		                System.out.println("Livreur ajoute!");
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
	}
	
	
	public static ArrayList<Livreur> getLivreurs() {
		return livreurs;
	}
	public static void setLivreurs(ArrayList<Livreur> livreurs) {
		Commande.livreurs = livreurs;
	}
	public Adresse getAdresse() {
		return sonAdresse;
	}
	public int getID() {
		return idCommande;
	}
	public void setAdresse(Adresse sonAdresse) {
		this.sonAdresse = sonAdresse;
	}
	public Client getClient() {
		return sonClient;
	}
	public void setClient(Client sonClient) {
		this.sonClient = sonClient;
	}
	public String toString() {
	    	return this.sonAdresse.toString();
	    }


	public Date getDateCommande() {
		return dateCommande;
	}


	public void setDateCommande(Date dateCommande) {
		this.dateCommande = dateCommande;
	}
	
	
	

}
