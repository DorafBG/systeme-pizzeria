package vues;
import javax.swing.*;

import java.awt.*;
import java.util.ArrayList;
import java.util.List;
import modeles.Commande;
import modeles.Tableau;

import java.util.concurrent.Executors;
import java.util.concurrent.ScheduledExecutorService;
import java.util.concurrent.TimeUnit;

public class tableauPanel extends JPanel {
    /**
	 * 
	 */
	private static final long serialVersionUID = 1L;
	private List<commandePanel> commandePanels;
    private Tableau tableauModele;
    
    private final ScheduledExecutorService scheduler = Executors.newScheduledThreadPool(1);

    public tableauPanel(Tableau tabModele) {
    	this.tableauModele = tabModele;
    	dessiner();
    	scheduler.scheduleAtFixedRate(this::redessiner, 0, 5, TimeUnit.SECONDS);
    }
    

    

    
    public void dessiner() {
        setLayout(new BoxLayout(this, BoxLayout.Y_AXIS));
        List<Commande> commandes = tableauModele.getLesCommandes();
        commandePanels = new ArrayList<>();
       

        // Fixed size for CommandePanel
        Dimension panelSize = new Dimension(300, 150);
        //JButton validerButton = new JButton("Actualiser");
        //validerButton.addActionListener(e -> redessiner());
        //add(validerButton, BorderLayout.EAST);

        // Create CommandePanel for each Commande
        for (Commande commande : commandes) {
            commandePanel commandePanel = new commandePanel(commande, this);
            commandePanel.setPreferredSize(panelSize);
            commandePanel.setMaximumSize(panelSize); // Set maximum size to prevent expansion
            commandePanels.add(commandePanel);

            // Add spacing between CommandePanels
            add(Box.createRigidArea(new Dimension(0, 20))); // Adjust the space as needed

            // Add CommandePanel with a black border
            JPanel borderedPanel = new JPanel();
            borderedPanel.setLayout(new BorderLayout());
            borderedPanel.setBorder(BorderFactory.createLineBorder(Color.BLACK));
            borderedPanel.add(commandePanel);
            add(borderedPanel);
        }
    }
    
    public void redessiner() {
    	System.out.println("Redessiner ..");
        SwingUtilities.invokeLater(() -> {
            this.removeAll();
            tableauModele.remplirCommandesDepuisBDD();
            dessiner();
            revalidate();
            repaint();
        });
    }
}
