

public class Livreur {

	private int idlivreur;
	private String nomlivreur;
	private String prenomlivreur;
	
	public static int vitesseDefaut = 30; //km par h
	
	public Livreur(int i, String n, String p) {
		this.idlivreur = i;
		this.nomlivreur = n;
		this.prenomlivreur = p;
	}
	
	public int getID() {
		return idlivreur;
	}
	
	public String getNom() {
		return nomlivreur;
	}
	
	public void setNom(String nom) {
		this.nomlivreur = nom;
	}
	
	public void setPrenom(String prenom) {
		this.prenomlivreur = prenom;
	}
	
	public String getPrenom() {
		return prenomlivreur;
	}
	
}
