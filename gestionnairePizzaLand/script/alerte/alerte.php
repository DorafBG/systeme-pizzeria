<script>
function updateDatabase(id, classe, identifiant, nouvelleValeur) {
    // Utiliser AJAX ou Fetch API pour envoyer la requête au serveur
    // Exemple avec Fetch API :
    fetch(`index.php?objet=${classe}&action=update&${identifiant}=${id}&attribut=QtIngredientAlerte&nouvelleValeur=${nouvelleValeur}`)
        .then(data => {
            console.log('Mise à jour réussie!');
        })
        .catch(error => {
            console.error('Erreur:', error);
        });
}
</script>