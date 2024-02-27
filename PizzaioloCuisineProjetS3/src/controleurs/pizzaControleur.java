package controleurs;

import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.sql.SQLException;
import java.util.ArrayList;

import javax.swing.JOptionPane;

import modeles.Commande;
import modeles.Pizza;
import vues.commandePanel;
import vues.pizzaPanel;
import vues.tableauPanel;

public class pizzaControleur implements ActionListener{
	
	Pizza _modele;
	pizzaPanel _vue;
	commandePanel _panelcommande;
	tableauPanel _tabPanel;
	
	public pizzaControleur(Pizza modele, pizzaPanel vue, commandePanel panelcommande){
		
		_modele = modele;
		_vue = vue;
		_panelcommande = panelcommande;
		_tabPanel = _panelcommande.getTableauPanelRef();

	}

    public void actionPerformed(ActionEvent e) {
        if (e.getActionCommand().equals("ValiderPizza")) {
            System.out.println("Pizza Valide numero : " + _modele.getIDPizza() +
                    " de la commande : " + _panelcommande.getModele().getIDCommande());
            
            _modele.pizzaDevientPrete(_modele.getIDPizza());
            
            _tabPanel.redessiner();
            JOptionPane.showMessageDialog(_tabPanel, "Pizza n°" + _modele.getIDPizza() + " terminée !");
        }
        
        if (e.getActionCommand().equals("AfficherRecette")) {
            try {
                ArrayList<ArrayList<Object>> ingredientsRecette = _modele.ingredientsRecette();

                // Construire la chaîne d'ingrédients
                StringBuilder ingredientsStringBuilder = new StringBuilder();
                for (ArrayList<Object> ingredient : ingredientsRecette) {
                    String nomIngredient = (String) ingredient.get(0);
                    int qteIngredient = (int) ingredient.get(1);

                    ingredientsStringBuilder.append(nomIngredient)
                                            .append(": ")
                                            .append(qteIngredient)
                                            .append(" unités\n");
                }

                // Afficher la boîte de dialogue avec la liste des ingrédients
                String message = "Voici les ingrédients de la pizza " + _modele.getNomPizzaDefaut() + " :\n\n" + ingredientsStringBuilder.toString();
                JOptionPane.showMessageDialog(_tabPanel, message);

            } catch (SQLException e1) {
                e1.printStackTrace();
            }
            _tabPanel.redessiner();
        }
    }

}
