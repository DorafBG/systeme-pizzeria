import javax.swing.*;
import modeles.*;
import vues.*;

public class PizzaioloMain {
  public static void main(String[] args) {
    JFrame fenetre = new JFrame("Pizzaiolo App - PizzaLand");
    fenetre.setSize(750, 950);
    fenetre.setResizable(false);
    fenetre.setDefaultCloseOperation(3);
    Tableau tabPrincipal = new Tableau();
    tableauPanel tabVuePrincipal = new tableauPanel(tabPrincipal);
    fenetre.add(tabVuePrincipal);
    fenetre.setVisible(true);
  }
}
