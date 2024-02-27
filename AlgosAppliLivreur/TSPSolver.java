import java.util.*;
import java.sql.Date;


public class TSPSolver {

    public static List<Commande> algorithmeGlouton(List<Commande> Commande) {
    	
        List<Commande> chemin = new ArrayList<>();
        Commande adresseCourante = Commande.get(0);
        Commande.remove(adresseCourante);
        chemin.add(adresseCourante);

        while (!Commande.isEmpty()) {
            double distanceMinimale = Double.MAX_VALUE;
            Commande prochaineAdresse = null;

            for (Commande adr : Commande) {
                double distance = calculerDistance(adresseCourante.getAdresse(), adr.getAdresse());
                if (distance < distanceMinimale) {
                    distanceMinimale = distance;
                    prochaineAdresse = adr;
                }
            }

            if (prochaineAdresse != null) {
                Commande.remove(prochaineAdresse);
                chemin.add(prochaineAdresse);
                adresseCourante = prochaineAdresse;
            }
        }

        return chemin;
    }


    public static List<Commande> programmationDynamique(List<Commande> Commandes) {
        List<Commande> chemin = new ArrayList<>();
        chemin.add(Commandes.get(0));
        Commandes.remove(0);
        chemin.addAll(aidePD(Commandes, Commandes.get(0)));

        return chemin;
    }

    private static List<Commande> aidePD(List<Commande> commandes, Commande CommandeCourante) {
        List<Commande> chemin = new ArrayList<>();

        if (commandes.isEmpty()) {
            return chemin;
        }

        double distanceMinimale = Double.MAX_VALUE;
        Commande prochaineAdresse = null;

        for (Commande adr : commandes) {
            double distance = calculerDistance(CommandeCourante.getAdresse(), adr.getAdresse());
            if (distance < distanceMinimale) {
                distanceMinimale = distance;
                prochaineAdresse = adr;
            }
        }

        if (prochaineAdresse != null) {
            commandes.remove(prochaineAdresse);
            chemin.add(prochaineAdresse);
            chemin.addAll(aidePD(commandes, prochaineAdresse));
        }

        return chemin;
    }



    public static List<Commande> memoisation(List<Commande> Commandes) {
        Map<Etat, List<Commande>> memo = new HashMap<>();
        List<Commande> chemin = new ArrayList<>();
        chemin.add(Commandes.get(0));
        Commandes.remove(0);
        chemin.addAll(aideMemoisation(Commandes, Commandes.get(0), memo));

        return chemin;
    }



    private static List<Commande> aideMemoisation(List<Commande> commandes, Commande commande, Map<Etat, List<Commande>> memo) {
        List<Commande> chemin = new ArrayList<>();

        if (commandes.isEmpty()) {
            return chemin;
        }

        Etat etatCourant = new Etat(commande, new ArrayList<>(commandes));

        if (memo.containsKey(etatCourant)) {
            return memo.get(etatCourant);
        }

        double distanceMinimale = Double.MAX_VALUE;
        Commande prochaineCommande= null;

        for (Commande adr : commandes) {
            double distance = calculerDistance(commande.getAdresse(), adr.getAdresse());
            if (distance < distanceMinimale) {
                distanceMinimale = distance;
                prochaineCommande = adr;
            }
        }

        if (prochaineCommande.getAdresse()!= null || prochaineCommande != null) {
            commandes.remove(prochaineCommande);
            chemin.add(prochaineCommande);
            chemin.addAll(aideMemoisation(commandes, prochaineCommande, memo));
            memo.put(etatCourant, chemin);
        }

        return chemin;
    }



	public void trierCommandesParDateHeure(ArrayList<Commande> lesCommandes) {
        Collections.sort(lesCommandes, new Comparator<Commande>() {
            public int compare(Commande commande1, Commande commande2) {
                // Comparaison des dates de commande pour le tri
                return commande1.getDateCommande().compareTo(commande2.getDateCommande());
            }
        });
	}



	

	// Voici les algorithmes en fonction de la duree que met un livreur à livrer une commande

	public static double getDuree(double distance) { //temps qu'un livreur met pour parcourir la distance 'distance'
		double temps = distance * 60 / Livreur.vitesseDefaut;
		return temps;
	}


    public static List<Commande> algorithmeGloutonDuree(List<Commande> commandes) {
        List<Commande> chemin = new ArrayList<>();
        Commande adresseCourante = commandes.get(0);
        commandes.remove(adresseCourante);
        chemin.add(adresseCourante);

        while (!commandes.isEmpty()) {
            double dureeMinimale = Double.MAX_VALUE;
            Commande prochaineAdresse = null;

            for (Commande adr : commandes) {
                double distance = calculerDistance(adresseCourante.getAdresse(), adr.getAdresse());
                double duree = getDuree(distance);
                if (duree < dureeMinimale) {
                    dureeMinimale = duree;
                    prochaineAdresse = adr;
                }
            }

            if (prochaineAdresse != null) {
                commandes.remove(prochaineAdresse);
                chemin.add(prochaineAdresse);
                adresseCourante = prochaineAdresse;
            }
        }

        return chemin;
    }




    public static List<Commande> programmationDynamiqueDuree(List<Commande> commandes) {
        List<Commande> chemin = new ArrayList<>();
        chemin.add(commandes.get(0));
        commandes.remove(0);
        chemin.addAll(aidePDDuree(commandes, commandes.get(0)));

        return chemin;
    }




    private static List<Commande> aidePDDuree(List<Commande> commandes, Commande commandeCourante) {
        List<Commande> chemin = new ArrayList<>();

        if (commandes.isEmpty()) {
            return chemin;
        }

        double dureeMinimale = Double.MAX_VALUE;
        Commande prochaineAdresse = null;

        for (Commande adr : commandes) {
            double distance = calculerDistance(commandeCourante.getAdresse(), adr.getAdresse());
            double duree = getDuree(distance);
            if (duree < dureeMinimale) {
                dureeMinimale = duree;
                prochaineAdresse = adr;
            }
        }

        if (prochaineAdresse != null) {
            commandes.remove(prochaineAdresse);
            chemin.add(prochaineAdresse);
            chemin.addAll(aidePDDuree(commandes, prochaineAdresse));
        }

        return chemin;
    }
	
	
	
	
    private static double calculerDistance(Adresse adr1, Adresse adr2) {
        try {
            return Adresse.calculDistance(adr1, adr2);
        } catch (Exception e) {
            e.printStackTrace();
            return Double.MAX_VALUE;
        }
    }
	
    private static void afficherChemin(List<Commande> chemin) {
        for (Commande adr : chemin) {
            System.out.println(adr);
        }
    }
    
    private static class Etat {
        @SuppressWarnings("unused")
		private final Commande adresseCourante;
        @SuppressWarnings("unused")
		private final List<Commande> adressesRestantes;

        public Etat(Commande adresseCourante, List<Commande> adressesRestantes) {
            this.adresseCourante = adresseCourante;
            this.adressesRestantes = adressesRestantes;
        }
    }
    

    @SuppressWarnings("deprecation")
	public static void main(String[] args) {
        List<Commande> Commandes = new ArrayList<>();
        Adresse a1 = new Adresse("4 avenue des sciences", "Gif-Sur-Yvette", "France");
        Adresse a2 = new Adresse("2 Rue PAUL VAILLANT COUTURIER", "Paris", "France");
        Adresse a3 = new Adresse("Avenue Paul Séramy", "Chessy", "France");
        Adresse a4 = new Adresse("2 Rue du Fond d'Orval", "Noisy-le-Sec", "France");
        
        Client c1 = new Client(1, "DUPOND", "Alain", a1, "0768458563");
        
        Commandes.add(new Commande(1, c1, a1, new Date(2023, 12, 19)));
        Commandes.add(new Commande(1, c1, a2, new Date(2023, 12, 19)));
        Commandes.add(new Commande(1, c1, a3, new Date(2023, 12, 19)));
        Commandes.add(new Commande(1, c1, a3, new Date(2023, 12, 19)));

        System.out.println("Ordre des adresses pour l'algorithme glouton :");
        List<Commande> cheminGlouton = algorithmeGlouton(new ArrayList<>(Commandes));
        afficherChemin(cheminGlouton);

        System.out.println("\nOrdre des adresses pour l'algorithme de programmation dynamique :");
        List<Commande> cheminDynamique = programmationDynamique(new ArrayList<>(Commandes));
        afficherChemin(cheminDynamique);

        System.out.println("\nOrdre des adresses pour l'algorithme de memoisation :");
        List<Commande> cheminMemo = memoisation(new ArrayList<>(Commandes));
        afficherChemin(cheminMemo);
    }


}
