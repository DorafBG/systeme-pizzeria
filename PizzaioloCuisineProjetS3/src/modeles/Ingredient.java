package modeles;
public class Ingredient {

	private int IDIngredient;
	private String NomIngredient;
	private int nbIngredients;
	
	public Ingredient (int IDIngredient,String NomIngredient, int nbIngredients) {
		this.IDIngredient = IDIngredient;
		this.NomIngredient = NomIngredient;
		this.nbIngredients = nbIngredients;
	}
	
	public int getIDIngredient() {
		return IDIngredient;
	}
	public void setIDIngredient(int iDIngredient) {
		IDIngredient = iDIngredient;
	}
	public String getNomIngredient() {
		return NomIngredient;
	}
	public void setNomIngredient(String nomIngredient) {
		NomIngredient = nomIngredient;
	}
	public int getNbIngredients() {
		return nbIngredients;
	}
	public void setNbIngredients(int nbIngredients) {
		this.nbIngredients = nbIngredients;
	}

}