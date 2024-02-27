import java.io.IOException;
import java.net.HttpURLConnection;
import java.net.URL;
import java.text.Normalizer;
import java.util.Scanner;

import org.json.JSONArray;
import org.json.JSONObject;

public class Adresse {
	private static final String API_URL = "https://nominatim.openstreetmap.org/search";
	
    private String rue;
    private String ville;
    private String pays;

    public Adresse(String rue, String ville, String pays) {
        this.rue = sansAccents(rue);
        this.ville = sansAccents(ville);
        this.pays = sansAccents(pays);
    }

    public String getRue() {
        return rue;
    }

    public String getVille() {
        return ville;
    }

    public String getPays() {
        return pays;
    }
    
    private String sansAccents(String input) {
        if (input == null) {
            return null;
        }
        String normalise = Normalizer.normalize(input, Normalizer.Form.NFD);
        return normalise.replaceAll("\\p{InCombiningDiacriticalMarks}+", "");
    }
    
    public String toString() {
    	return this.rue + ", " + this.ville + ", " + this.pays;
    }
    
    public double[] getCoordonnees() throws IOException {
        String addressString = this.getRue() + ", " + this.getVille() + ", " + this.getPays();
        String formattedAddress = addressString.replace(" ", "%20");

        URL url = new URL(API_URL + "?format=json&q=" + formattedAddress);
        HttpURLConnection connection = (HttpURLConnection) url.openConnection();
        connection.setRequestMethod("GET");

        try (Scanner scanner = new Scanner(connection.getInputStream())) {
            StringBuilder response = new StringBuilder();
            while (scanner.hasNext()) {
                response.append(scanner.nextLine());
            }

            JSONArray jsonArray = new JSONArray(response.toString());

            if (jsonArray.length() > 0) {
                JSONObject firstResult = jsonArray.getJSONObject(0);
                double lat = firstResult.getDouble("lat");
                double lon = firstResult.getDouble("lon");
                return new double[]{lat, lon};
            } else {
                throw new IOException("L'adresse suivante n'existe pas : " + addressString); //adresse n'existe pas
            }
        } catch (IOException e) {
            throw new IOException("Adresse mal formaté", e);
        }
    }
    
    public static double calculDistance(Adresse adr1, Adresse adr2) throws IOException {
        
        double[] coord1 = adr1.getCoordonnees();
        double[] coord2 = adr2.getCoordonnees();
        
        if (coord1.length != 2 || coord2.length != 2) {
            throw new IllegalArgumentException("Adresses non valides !");
        }

        double lat1 = Math.toRadians(coord1[0]);
        double lon1 = Math.toRadians(coord1[1]);
        double lat2 = Math.toRadians(coord2[0]);
        double lon2 = Math.toRadians(coord2[1]);

        // Formule de Haversine
        double dLat = lat2 - lat1;
        double dLon = lon2 - lon1;

        double a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                   Math.cos(lat1) * Math.cos(lat2) *
                   Math.sin(dLon / 2) * Math.sin(dLon / 2);

        double c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

        double distance = 6371.0 * c;

        return distance;
    }
    
    
    
    public static void main(String[] args) {
        Adresse adresse1 = new Adresse("4 avenue des sciences", "Gif-Sur-Yvette", "France");
        Adresse adresse2 = new Adresse("2 Rue PAUL VAILLANT COUTURIER", "Paris", "France");

        try {
            double distance = Adresse.calculDistance(adresse1, adresse2);

            System.out.println("Il y a " + distance + " km entre les adresses :");
            System.out.println(adresse1);
            System.out.println("et");
            System.out.println(adresse2);
        } catch (IOException e) {
            e.printStackTrace();
        }
    }
    
}

