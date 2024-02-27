# Sytème de Gestion d'une Pizzeria

Ce système a été codé lors du mon SAé du S3 du BUT Informatique.<br>
Il comporte notamment :
- Un site web client **[PHP/HTML/CSS]**
- Un site web gestionnaire (administrateur) **[PHP/HTML/CSS]**
- Une application de gestion des pizzas cuisinés (cuisinier) **[JAVA]**
- Des classes modèles pour une application destinée aux livreurs. **[JAVA]**

## Fonctionnalités site web client :

⚠️ Ne pas oublier de remplacer les bonnes valeurs dans config/config.php !

	Se connecter, se déconnecter.

	Voir les pizzas.
	Voir la liste des allergènes d'une pizza.
	Voir les recettes d'une pizza, ajouter une recette à une pizza et y ajouter les ingrédients et la quantité qu'on veut.
	Qualifier une pizza du moment ou l'enlever.

	Regarder les statistiques des ventes annuelles, mensuelles et hebdomadaires.

	Regarder les stocks.
	Incrémenter les stocks d'ingrédients.
	Décrémenter les stocks d'ingrédients.

	Regarder les alertes.
	Modifier la quantité d'ingrédients dans une alerte.
	Supprimer une alerte.
	Ajouter une alerte pour l'ingrédient et la quantité souhaitée.

## Fonctionnalités site web gestionnaire :

⚠️ Ne pas oublier de remplacer les bonnes valeurs dans config/config.php !
__Accès :__
- Login : admin
- Mot De Passe : admin
```
- Sans être connecté :
	Regarder les pizzas, les produits.
	Se connecter.
	Créer un compte.
	
- Après s'être connecté :
	Se déconnecter.
	Accéder à ses informations personelles via une page profil.
	Accéder à son historique de commandes passées.
	Ajouter des pizzas/produits dans un panier.
	Regarder le contenu de son panier.
	Personnaliser une pizza dans un panier.
	Supprimer une pizza/produit d'un panier.
	Payer un panier en y entrant ses informations bancaires.

```

## Fonctionnalités application cuisinier :

⚠️ Ne pas oublier de remplacer les valeurs de connexion à une base de données MySQL dans les classes modèles.
Application codée grâce à l'IDE Eclipse.

    Voir les pizzas (uniquement les pizzas, pas les boissons et les desserts) contenues dans les dernières commandes et qui n'ont pas été cuisinées.
    Possibilité de passer les pizzas en "estCuisiné" une par une.
    Rappel des recettes pizzas commandés en cliquant sur un bouton.
    Voir les ingrédients personnalisés (en plus ou en moins).
    Voir quand la pizza a été commandée.
    Indique si la pizza est en retard ou pas (pas cuisinée depuis > 30 min).

## Fonctionnalités application livreurs :

⚠️ Ne pas oublier de remplacer les valeurs de connexion à une base de données MySQL dans les classes modèles.

    Voici les classes modèles suivantes : 
    - Adresse
        Une adresse est composée d'une rue, d'une ville et d'un pays.
        Cette classe comporte différentes fonctions, notamment la classe objet getCoordonnees() qui utilise l'api d'openstreetmaps pour renvoyer la longitude et la latitude.
        Et aussi la classe calculDistance(adr1, adr2) qui, en utilisant la formule de Haversine va renvoyer le nombre de kilomètres entre ces 2 adresses.
    - Client
        Un client est composé d'un identifiant, d'un nom, d'un prénom, d'une adresse et d'un numéro de téléphone (en accordance avec la base de données).
    - Commande
        Une commande est composée d'un identifiant, d'une adresse (là où il faut envoyer la commande), du client qui l'a passée et d'une date.
        Il y a aussi un attribut static lesLivreurs qui contient une liste de livreurs destinés à livrer les commandes. 
    - Livreur
        Un livreur possède un identifiant, un nom et un prénom.
        Il possède aussi un attribut static vitesseDefaut de 30 car chaque livreur roule à 30km/h.
    - Tableau
        La classe tableau contient comme attribut uniquement une arrayList de commandes à livrer car elle servira à les afficher.
        De plus, elle possède la fonction remplirCommandesDepuisBDD() qui est appelé dans son constructeur qui sert à récupérer toutes les commandes depuis la base de données qui doivent être livrer et à remplir donc l'attribut lesCommandes.
    - TSPSolver
        La classe ne possède aucun attributs mais uniquement des fonctions de tri.
        Elle possède des fonctions de tri dynamiques, glouton, memoiser ... etc en fonction de certains critères (énoncés dans le nom de la fonction).


## Base de Données

Le système entier se base sur une base de données **MySQL** dont vous trouverez le script de création et d'insertion généré par **phpMyAdmin** dans :
```
CREATION_INSERTION_BDD.sql
```

# Exemples

## Site web client

![Image du client](https://i.imgur.com/GIkifpY.png "Page d'accueil")

![Image du client](https://i.imgur.com/qf4eZEw.png "Page de connexion")

## Site web gestionnaire

![Image connexion gestionnaire](https://i.imgur.com/qzMfabE.png "Page de connexion")

![Image connexion gestionnaire](https://i.imgur.com/mygwWyS.png "Page de gestion des pizzas")

![Image connexion gestionnaire](https://i.imgur.com/2rgK514.png "Page de statistiques des ventes")