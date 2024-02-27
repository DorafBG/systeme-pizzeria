package modeles;
import java.time.Duration;
import java.time.LocalDateTime;
import java.util.*;

public class Commande {

	private int IDCommande;
	private Date dateCommande;
	ArrayList<Pizza> lesPizzas;
	
	public Commande(int IDCommande, Date dateCommande) {
		lesPizzas =  new ArrayList<>();
		this.IDCommande = IDCommande;
		this.dateCommande = dateCommande;
	}
	
	public int getIDCommande() {
		return IDCommande;
	}
	public void setIDCommande(int iDCommande) {
		IDCommande = iDCommande;
	}
	
	public void ajouterPizza(Pizza lapizz) {
		lesPizzas.add(lapizz);
	}
	public void retirerPizza(Pizza pizza) {
	    lesPizzas.remove(pizza);
	}
	
	public Collection<Pizza> getLesPizzas(){
		return lesPizzas;
	}
	
	public String toString() {
		return "Commande n°" + IDCommande + " - Pizzas : " + lesPizzas;
	}

	public Date getDateCommande() {
		return dateCommande;
	}

	public void setDateCommande(java.sql.Date dateCommande) {
		this.dateCommande = dateCommande;
	}
	
	public String tempsPasse() {
	    LocalDateTime now = LocalDateTime.now();

	    LocalDateTime dateCommandeLocal = LocalDateTime.ofInstant(dateCommande.toInstant(), java.time.ZoneId.systemDefault());

	    Duration difference = Duration.between(dateCommandeLocal, now);

	    long heures = difference.toHours();
	    long minutes = difference.toMinutesPart();

	    return String.format("%dh%02dmin", heures, minutes);
	}
	
	public long tempsPasseMinutesOnly() {
	    LocalDateTime now = LocalDateTime.now();
	    LocalDateTime dateCommandeLocal = LocalDateTime.ofInstant(dateCommande.toInstant(), java.time.ZoneId.systemDefault());
	    Duration difference = Duration.between(dateCommandeLocal, now);
	    long minutes = difference.toMinutesPart();

	    return minutes;
	}
	
	public long tempsPasseHeuresOnly() {
	    LocalDateTime now = LocalDateTime.now();
	    LocalDateTime dateCommandeLocal = LocalDateTime.ofInstant(dateCommande.toInstant(), java.time.ZoneId.systemDefault());
	    Duration difference = Duration.between(dateCommandeLocal, now);
	    long heures = difference.toHours();

	    return heures;
	}

	

}