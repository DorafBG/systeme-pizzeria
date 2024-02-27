package vues;

import javax.swing.*;

import controleurs.pizzaControleur;
import java.awt.*;

import modeles.Commande;
import modeles.Ingredient;
import modeles.Pizza;

public class pizzaPanel extends JPanel {
    /**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private Pizza modele;
    private pizzaControleur ecouteur;
    @SuppressWarnings("unused")
	private commandePanel commandepanel;
    private JButton recetteButton;

    public pizzaPanel(Pizza modele, commandePanel commandepanel) {
        setLayout(new BorderLayout());

        this.commandepanel = commandepanel;
        this.setModele(modele);
        this.ecouteur = new pizzaControleur(this.modele, this, commandepanel);

        String lesIngredientsEnPlus = "";
        for (Ingredient lingredient : modele.getIngredients()) {
        	// si l'ingredient est le premier
        	if(lingredient == modele.getIngredients().get(0)) {
        		lesIngredientsEnPlus += "(";
        	}
        	
        	//Si nb ingredient afficher "+nb" sinon "-nb" pour le pizzaiolo
        	if(lingredient.getNbIngredients() > 0) {
        		lesIngredientsEnPlus += lingredient.getNomIngredient() + " : +" + lingredient.getNbIngredients();
        	} else {
        		lesIngredientsEnPlus += lingredient.getNomIngredient() + " : " + lingredient.getNbIngredients();
        	}
        	
        	
        	// si l'ingredient est le dernier
        	if(lingredient == modele.getIngredients().get(modele.getIngredients().size()-1)) {
        		lesIngredientsEnPlus += ")";
        	} else {
        		lesIngredientsEnPlus += " | ";
        	}
        }
        if(lesIngredientsEnPlus == "") {
        	lesIngredientsEnPlus = "(Aucune Personnalisation)";
        }
        
        JPanel boutons = new JPanel();

        
        // Create and add "Recette" button on the left side
        recetteButton = new JButton("Recette");
        boutons.add(recetteButton);
        recetteButton.setActionCommand("AfficherRecette"); // Changer si nécessaire
        recetteButton.addActionListener(ecouteur);
        
        // Display pizza information on the left side
        JLabel pizzaInfoLabel = new JLabel("Pizza " + modele.getNomPizzaDefaut() + " [ID: " + modele.getIDPizza() + "] - " + lesIngredientsEnPlus );
        add(pizzaInfoLabel, BorderLayout.WEST);
        

        // Create and add "Valider" button on the right side
        JButton validerButton = new JButton("Valider");
        boutons.add(validerButton);
        validerButton.setActionCommand("ValiderPizza");
        validerButton.addActionListener(ecouteur);
        
        add(boutons, BorderLayout.EAST);
    }


	public Pizza getModele() {
		return modele;
	}

	public void setModele(Pizza modele) {
		this.modele = modele;
	}
}
