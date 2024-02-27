public class Client {

	private int idclient;
	private String nomclient;
	private String prenomclient;
	private Adresse adresseclient;
	private String numclient;
	
	public Client(int i, String n, String p, Adresse a, String num) {
		this.idclient = i;
		this.nomclient = n;
		this.prenomclient = p;
		this.adresseclient = a;
		this.numclient = num;
	}
	
	public int getID() {
		return idclient;
	}
	
	public String getNom() {
		return nomclient;
	}
	
	public void setNom(String nom) {
		this.nomclient = nom;
	}
	
	public void setPrenom(String prenom) {
		this.prenomclient = prenom;
	}
	
	public String getPrenom() {
		return prenomclient;
	}
	
	public Adresse getAdresse() {
		return adresseclient;
	}
	
	public void setAdresse(Adresse adresse) {
		this.adresseclient = adresse;
	}
	
	public String getNum() {
		return numclient;
	}
	
	public void setNum(String num) {
		this.numclient = num;
	}
	
	public String toString() {
		return "" + idclient + " " + nomclient + " " + prenomclient + " " + adresseclient + " " + numclient;
	}
	
}
