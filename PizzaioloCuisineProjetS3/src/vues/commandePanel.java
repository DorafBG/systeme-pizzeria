package vues;

import javax.swing.*;
import java.awt.*;
import java.util.Collection;
import modeles.Commande;
import modeles.Ingredient;
import modeles.Pizza;
import modeles.Tableau;

public class commandePanel extends JPanel {
    /**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	// Déclaration des attributs
    private JLabel titreLabel;
    private JPanel pizzasPanel;
    @SuppressWarnings("unused")
	private JButton validerButton;
    private Commande modele;
    
    private tableauPanel tableauPanelRef;

    public commandePanel(Commande modele, tableauPanel tableauPanelRef) {
        setLayout(new BorderLayout());
        this.setTableauPanelRef(tableauPanelRef);
        this.setModele(modele);
        
        String enretard = "";
        
        if(modele.tempsPasseHeuresOnly() == 0 && modele.tempsPasseMinutesOnly() > 15) {
        	enretard = "<b><font color='red'> (EN RETARD) </font></b>";
        }
        
        if(modele.tempsPasseHeuresOnly() > 0) {
        	enretard = "<b><font color='red'> (EN RETARD) </font></b>";
        }

        titreLabel = new JLabel("<html>Commande n°" + modele.getIDCommande() + " <font color='black'>- Passée il y a </font><font color='red'>" + modele.tempsPasse() + "</font> " + enretard  +"</html>");

        pizzasPanel = new JPanel();
        validerButton = new JButton("Valider");

        pizzasPanel.setLayout(new GridLayout(0, 1));

        for (Pizza pizza : modele.getLesPizzas()) {
            pizzasPanel.add(new pizzaPanel(pizza, this));
        }

        JScrollPane pizzasScrollPane = new JScrollPane(pizzasPanel);

        add(titreLabel, BorderLayout.NORTH);
        add(pizzasScrollPane, BorderLayout.CENTER);


    }


	public tableauPanel getTableauPanelRef() {
		return tableauPanelRef;
	}


	public void setTableauPanelRef(tableauPanel tableauPanelRef) {
		this.tableauPanelRef = tableauPanelRef;
	}


	public Commande getModele() {
		return modele;
	}


	public void setModele(Commande modele) {
		this.modele = modele;
	}
}
