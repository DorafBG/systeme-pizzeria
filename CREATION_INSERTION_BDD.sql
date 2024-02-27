-- phpMyAdmin SQL Dump
-- version 5.2.1deb1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : mar. 27 fév. 2024 à 16:09
-- Version du serveur : 10.11.6-MariaDB-0+deb12u1-log
-- Version de PHP : 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `BDD-PIZZERIA`
--

DELIMITER $$
--
-- Procédures
--
CREATE DEFINER=`pizzeria`@`%` PROCEDURE `lesIngredientsDe` (`nPizza` TEXT)   BEGIN
	SELECT nomingredient FROM Ingredient
	NATURAL JOIN est_composee
	NATURAL JOIN Recette
	NATURAL JOIN PizzaDefaut
	WHERE nompizzadefaut=nPizza;
END$$

CREATE DEFINER=`pizzeria`@`%` PROCEDURE `modifStockIngredient` (`numPizzaDefaut` INT)   BEGIN
	DECLARE ingredient_id INT;
    DECLARE ingredient_qt INT;
    DECLARE finished INTEGER DEFAULT 0;
    
    DECLARE ingredient_curseur CURSOR FOR
    	SELECT DISTINCT IDIngredient, QtIngredientRecette
        FROM Panier
        NATURAL JOIN Pizza NATURAL JOIN PizzaDefaut NATURAL JOIN Recette
        NATURAL JOIn est_composee
        WHERE IDPizzaDefaut = numPizzaDefaut;
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;
    
     OPEN ingredient_curseur;
        majStockIngredients:LOOP
        	FETCH ingredient_curseur INTO ingredient_id, ingredient_qt;
            IF finished = 1 THEN
            	LEAVE majStockIngredients;
            END IF;
     	UPDATE Ingredient SET QtIngredientStock = QtIngredientStock - ingredient_qt
    	WHERE IDIngredient = ingredient_id;
        END LOOP majStockIngredients;
        CLOSE ingredient_curseur;
    
END$$

CREATE DEFINER=`pizzeria`@`%` PROCEDURE `SupprimerProduitDuPanier` (IN `p_IDPanier` INT, IN `p_IDProduit` INT)   BEGIN
    DELETE FROM Possede WHERE IDPanier = p_IDPanier AND IDProduit = p_IDProduit;
END$$

CREATE DEFINER=`pizzeria`@`%` PROCEDURE `updatePanierAndCreateCommande` (IN `panierID` INT)   BEGIN
    DECLARE clientID INT;
    
    SELECT IDClient INTO clientID FROM Panier WHERE IDPanier = panierID;
    
    UPDATE Panier SET estCommande = 1 WHERE IDPanier = panierID;

    INSERT INTO Commande (DateCommande, ModePaiement, StatutPaiement, IDPanier, IDClient)
    VALUES (NOW(), 'En Ligne', 'Payée', panierID, clientID);
    
    INSERT INTO Panier (estCommande, IDClient) VALUES (0, clientID);
END$$

CREATE DEFINER=`pizzeria`@`%` PROCEDURE `UpdateStatutLivraison` (IN `p_IDLivraison` INT, IN `p_StatutLivraison` VARCHAR(10))   BEGIN
    UPDATE Livraison SET StatutLivraison = p_StatutLivraison WHERE IDLivraison = p_IDLivraison;
END$$

--
-- Fonctions
--
CREATE DEFINER=`pizzeria`@`%` FUNCTION `prixTotal` (`numPanier` INT) RETURNS DOUBLE  BEGIN
    DECLARE prixTotalPizza DOUBLE;
    DECLARE prixTotalProduit DOUBLE;
    DECLARE prixTotal DOUBLE;
    
    SELECT SUM(prixpizzadefaut) INTO prixTotalPizza
	FROM Panier
	NATURAL JOIN Pizza
	NATURAL JOIN PizzaDefaut
    WHERE IDPanier = numPanier;

	SELECT SUM(prixproduit * possede.quantite) INTO prixTotalProduit
	FROM Panier
	NATURAL JOIN possede
	NATURAL JOIN Produit
    WHERE IDPanier = numPanier;
    
    SET prixTotal = COALESCE(prixTotalPizza, 0) + COALESCE(prixTotalProduit, 0);

    RETURN prixTotal;

END$$

CREATE DEFINER=`pizzeria`@`%` FUNCTION `RegardeSiIngredientDisponible` (`ingredient_id` INT, `quantity` INT) RETURNS TINYINT(1)  BEGIN
    DECLARE available_stock INT;

    -- Get the available stock of the ingredient
    SELECT QtIngredientStock INTO available_stock
    FROM Ingredient
    WHERE IDIngredient = ingredient_id;

    -- Check if there is enough stock
    IF available_stock >= quantity THEN
        RETURN TRUE;
    ELSE
        RETURN FALSE;
    END IF;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `Alerte`
--

CREATE TABLE `Alerte` (
  `IDAlerte` int(11) NOT NULL,
  `QtIngredientAlerte` int(11) DEFAULT NULL,
  `IDIngredient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Alerte`
--

INSERT INTO `Alerte` (`IDAlerte`, `QtIngredientAlerte`, `IDIngredient`) VALUES
(1, 10, 8),
(2, 5, 4),
(4, 5, 16),
(5, 8, 1),
(10, 5, 22),
(11, 2, 11);

-- --------------------------------------------------------

--
-- Structure de la table `Allergene`
--

CREATE TABLE `Allergene` (
  `IDAllergene` int(11) NOT NULL,
  `NomAllergene` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Allergene`
--

INSERT INTO `Allergene` (`IDAllergene`, `NomAllergene`) VALUES
(1, 'Anchois'),
(2, 'Câpres'),
(3, 'Olives'),
(4, 'Jambon'),
(5, 'Champignons'),
(6, 'Oeuf'),
(7, 'Poivrons'),
(8, 'Oignons'),
(9, 'Sauce barbecue'),
(10, 'Saumon fumé'),
(11, 'Crevettes'),
(12, 'Ail'),
(13, 'Persil'),
(14, 'Boeuf haché'),
(15, 'Bacon'),
(16, 'Cheddar'),
(17, 'Chèvre'),
(18, 'Miel'),
(19, 'Noix'),
(20, 'Pesto'),
(21, 'Tomates cerises'),
(22, 'Roquette'),
(23, 'Parmesan'),
(24, 'Prosciutto'),
(25, 'Jalapeños'),
(26, 'Gluten'),
(27, 'Lactose'),
(28, 'Arachides'),
(29, 'Fruits à coque'),
(30, 'Crustacés'),
(31, 'Oeufs'),
(32, 'Soja'),
(33, 'Poisson'),
(34, 'Mollusques'),
(35, 'Céleri'),
(36, 'Moutarde'),
(37, 'Sésame'),
(38, 'Sulfites');

-- --------------------------------------------------------

--
-- Structure de la table `ChoixIngredient`
--

CREATE TABLE `ChoixIngredient` (
  `IDChoixIngredient` int(11) NOT NULL,
  `IDPanier` int(11) NOT NULL,
  `IDPizza` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `ChoixIngredient`
--

INSERT INTO `ChoixIngredient` (`IDChoixIngredient`, `IDPanier`, `IDPizza`) VALUES
(2, 2, 3),
(3, 3, 7),
(4, 4, 10),
(5, 7, 8),
(6, 8, 9),
(7, 9, 11),
(8, 5, 6),
(9, 6, 4),
(10, 10, 5),
(12, 19, 15),
(13, 1, 21),
(14, 21, 22),
(16, 35, 25),
(17, 36, 26),
(18, 34, 27),
(19, 39, 29),
(20, 41, 33),
(21, 46, 95),
(22, 47, 97),
(23, 48, 98),
(29, 37, 127),
(30, 52, 130),
(32, 53, 131),
(33, 53, 133),
(34, 51, 138),
(35, 65, 139),
(38, 70, 142),
(39, 73, 143),
(40, 73, 144),
(43, 81, 147),
(44, 81, 148),
(45, 82, 149),
(46, 82, 150),
(47, 82, 151),
(48, 83, 152),
(49, 83, 153),
(50, 83, 154),
(51, 84, 155),
(53, 85, 157),
(54, 85, 158),
(55, 85, 159),
(56, 85, 160),
(57, 87, 161),
(58, 87, 162),
(59, 89, 163),
(60, 89, 164),
(61, 89, 165),
(62, 88, 166),
(66, 91, 170),
(67, 92, 171),
(68, 92, 172),
(69, 93, 173),
(70, 93, 174),
(71, 90, 175),
(72, 90, 176),
(73, 94, 177),
(74, 93, 179),
(75, 93, 180);

-- --------------------------------------------------------

--
-- Structure de la table `Client`
--

CREATE TABLE `Client` (
  `IDClient` int(11) NOT NULL,
  `loginClient` varchar(50) DEFAULT NULL,
  `mdpClient` varchar(50) DEFAULT NULL,
  `NomClient` varchar(50) NOT NULL,
  `PrenomClient` varchar(50) DEFAULT NULL,
  `RueClient` varchar(100) NOT NULL,
  `VilleClient` varchar(50) DEFAULT NULL,
  `PaysClient` varchar(50) NOT NULL,
  `TelClient` varchar(14) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Client`
--

INSERT INTO `Client` (`IDClient`, `loginClient`, `mdpClient`, `NomClient`, `PrenomClient`, `RueClient`, `VilleClient`, `PaysClient`, `TelClient`) VALUES
(1, 'login', 'mdp', 'Automatique', 'Test', '50', 'Paris', 'France', '06 44 59 65 75'),
(2, 'martin1234', 'martinbob91', 'Martin', 'Bob', '15 Avenue des Roses', 'Orsay', 'France', '0743518563'),
(3, 'claire1234', 'clairedubois94', 'Dubois', 'Claire', '28 Rue Principale', 'Rungis', 'France', '0734219988'),
(4, 'david1234', 'daviddurand94', 'Durand', 'David', '7 Boulevard Voltaire', 'Thiais', 'France', '0642316392'),
(5, 'emma1234', 'emmalefevre91', 'Lefevre', 'Emma', '9 Rue du Commerce', 'Corbeil', 'France', '0743536677'),
(6, 'frank1234', 'frankmoreau93', 'Moreau', 'Frank', '42 Avenue de la République', 'Rosny', 'France', '0691554423'),
(7, 'sophie1234', 'sophiegarcia95', 'Garcia', 'Sophie', '3 Rue Saint-Louis', 'Sarcelles', 'France', '0712349967'),
(8, 'gabriel1234', 'gabrielrodriguez95', 'Rodriguez', 'Gabriel', '56 Boulevard Haussmann', 'Argenteuil', 'France', '0614879211'),
(9, 'helene1234', 'helenefournier93', 'Fournier', 'Hélène', '27 Avenue Foch', 'Pantin', 'France', '0724345322'),
(10, 'ivan1234', 'ivangirard93', 'Girard', 'Ivan', '14 Rue des Lilas', 'Sevran', 'France', '0623879911'),
(11, 'alice1234', 'alicedupont91', 'Dupont', 'Alice', '1 Rue de la Liberté', 'Evry', 'France', '0692387543'),
(12, 'admin', 'admin', 'admin', NULL, '', NULL, '', NULL),
(13, 'bilel78,venez en Force', 'ghdqfdq', 'elmediouni', 'bilel', 'jfshfho', 'Poissy', 'France', '05654654'),
(24, 'alexandre.malfreyt@gmail.com', 'mdp', 'MALFREYT', 'Alexandre', 'non', 'Longjumeau', 'France', '0762042148'),
(25, '!!!!!', '!!!!!!!', 'Il y\'a des failles', 'dans votre base', '!!!!!!', 'possible', 'le plus rapidement', 'securisez sa'),
(26, 'jphilippe', 'mdp', 'Philippe', 'Janota', '5', 'Paris', 'France', '0666666666'),
(27, 'saes3-mperei16', '123', 'CHRETIEN', 'Noé', 'LePullLidleDeQuentin', 'LePullLidleDeQuentin', 'LePullLidleDeQuentin', '000000000'),
(29, 'nkali', 'root', 'KALI', 'Nacim', '01', 'Paris', 'France', '01010101'),
(30, 'fsfs', 'fsfs', 'fsfs', 'fsfs', 'fsfs', 'sfs', 'sfsf', 'fsf'),
(31, 'dzdz', 'test', 'dzzd', 'zdzd', 'dzdzdz', 'zdz', 'dzd', 'zdz'),
(32, 'dq', 'dqd', 'dqd', 'dq', 'qq', 'dq', 'qdq', 'qd'),
(33, 'sfs', 'fsf', 'fs', 'fsf', 'sfsf', 'sf', 'sfs', 'sf'),
(34, 'fs', 'fs', 'sfs', 'fsf', 'sfs', 'sf', 'sf', 'sf'),
(39, 'vnv', 'vn', 'nvnv', 'nv', 'nv', 'nv', 'nv', 'nv'),
(40, 'hrh', 'hzrhr', 'rherh', 'er', 'rhrhr', 'hrh', 'rhr', 'ehr'),
(41, 'vsv', 'svsvs', 'svfvs', 'vsv', 'vs', 'vs', 'svs', 'svsv'),
(42, 'gege', 'pe', 'geqge', 'gerg', 'ege', 'egeg', 'eg', 'erg'),
(43, 'a', 'a', 'a', 'a', 'a', 'a', 'a', 'a'),
(45, 'alexzegamer', 'mdp', 'MALFREYT', 'Alexandre', 'non', 'Longjumeau', 'France', '+33762042148'),
(46, 'zrz', 'u-u-u-u', 'rzrz', 'rzr', 'rzrzr', 'zrz', 'rzr', 'zrz'),
(47, 'yr', 'ui', 'ruru', 'ryr', 'ryr', 'ry', 'ry', 'yry'),
(48, 'zzz', 'tt', 'taatr', 'aztaz', 'ztz', 'tzt', 'zz', 'azr'),
(49, 'rjrj', 'rr', 'kryjk', 'rtjtrj', 'jtrjrt', 'rtjrt', 'jrj', 'rtjtr'),
(50, 'mohamed', 'macaronauchocolat', 'larbi', 'Mohamed', 'Acco Della Rosa, 06300 Nice', 'nice', 'france', '0672893487'),
(51, 'OQBKG', 'COUCOUCOUCOU', 'princesse', 'bouteille', 'p&\"\'ui £', 'Zingourourou', 'Madagascar', '89795U897984'),
(52, 'jean.duboit', 'gggggggg', 'kjfdqhfuh', ';j;xgljshln', 'kbfgskljsh', 'orsay', 'France', '06124578'),
(54, 'feur', 'feur', 'feur', 'feur', 'feur', 'feur', 'feur', '01');

--
-- Déclencheurs `Client`
--
DELIMITER $$
CREATE TRIGGER `creerNouveauPanier` AFTER INSERT ON `Client` FOR EACH ROW BEGIN

    INSERT INTO Panier (estCommande, IDClient) VALUES (FALSE, NEW.IDClient);

END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `Commande`
--

CREATE TABLE `Commande` (
  `IDCommande` int(11) NOT NULL,
  `DateCommande` datetime DEFAULT NULL,
  `ModePaiement` varchar(10) DEFAULT NULL,
  `StatutPaiement` varchar(10) DEFAULT NULL,
  `IDPanier` int(11) NOT NULL,
  `IDClient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Commande`
--

INSERT INTO `Commande` (`IDCommande`, `DateCommande`, `ModePaiement`, `StatutPaiement`, `IDPanier`, `IDClient`) VALUES
(2, '2023-12-02 17:30:00', 'Espèces', 'Payée', 2, 3),
(3, '2023-12-03 11:15:00', 'Carte', 'En attente', 3, 4),
(4, '2023-12-03 11:30:00', 'Espèces', 'Payée', 4, 5),
(5, '2023-12-03 11:45:00', 'Carte', 'En attente', 5, 6),
(6, '2023-12-09 15:30:00', 'Carte', 'En attente', 6, 7),
(7, '2023-12-12 10:00:00', 'Carte', 'En attente', 7, 8),
(8, '2023-11-25 12:45:00', 'TicketR', 'En attente', 8, 9),
(9, '2023-10-18 18:30:00', 'TicketR', 'Payée', 9, 10),
(10, '2023-09-05 16:20:00', 'Espèces', 'Payée', 10, 11),
(58, '2023-12-21 16:11:45', 'En Ligne', 'Payée', 1, 1),
(59, '2023-12-21 16:26:22', 'En Ligne', 'Payée', 33, 1),
(60, '2023-12-21 20:43:58', 'En Ligne', 'Payée', 35, 26),
(61, '2023-12-21 21:08:33', 'En Ligne', 'Payée', 34, 1),
(62, '2023-12-22 08:33:26', 'En Ligne', 'Payée', 36, 26),
(63, '2023-12-22 08:34:42', 'En Ligne', 'Payée', 39, 27),
(65, '2023-12-22 08:36:31', 'En Ligne', 'Payée', 40, 27),
(66, '2023-12-22 08:37:17', 'En Ligne', 'Payée', 41, 27),
(67, '2023-12-22 08:41:41', 'En Ligne', 'Payée', 42, 27),
(68, '2023-12-22 08:48:29', 'En Ligne', 'Payée', 38, 26),
(69, '2023-12-22 09:06:19', 'En Ligne', 'Payée', 44, 26),
(70, '2023-12-22 09:07:35', 'En Ligne', 'Payée', 45, 26),
(71, '2023-12-22 09:15:54', 'En Ligne', 'Payée', 46, 26),
(72, '2023-12-22 09:31:20', 'En Ligne', 'Payée', 47, 26),
(73, '2023-12-22 09:38:47', 'En Ligne', 'Payée', 43, 27),
(74, '2023-12-22 09:38:48', 'En Ligne', 'Payée', 48, 26),
(78, '2023-12-22 13:14:18', 'En Ligne', 'Payée', 50, 26),
(79, '2023-12-22 16:39:48', 'En Ligne', 'Payée', 37, 1),
(84, '2023-12-22 19:07:36', 'En Ligne', 'Payée', 52, 1),
(96, '2024-01-05 20:40:29', 'En Ligne', 'Payée', 53, 1),
(97, '2024-01-07 23:38:49', 'En Ligne', 'Payée', 61, 1),
(98, '2024-01-08 10:32:11', 'En Ligne', 'Payée', 62, 1),
(99, '2024-01-08 10:33:26', 'En Ligne', 'Payée', 63, 1),
(100, '2024-01-08 10:35:12', 'En Ligne', 'Payée', 64, 1),
(101, '2024-01-08 12:05:43', 'En Ligne', 'Payée', 51, 26),
(102, '2024-01-08 14:48:42', 'En Ligne', 'Payée', 65, 1),
(104, '2024-01-08 20:42:56', 'En Ligne', 'Payée', 70, 1),
(105, '2024-01-08 20:51:56', 'En Ligne', 'Payée', 72, 1),
(108, '2024-01-09 14:54:16', 'En Ligne', 'Payée', 73, 1),
(109, '2024-01-09 15:55:12', 'En Ligne', 'Payée', 81, 1),
(110, '2024-01-09 16:55:27', 'En Ligne', 'Payée', 82, 1),
(111, '2024-01-10 16:48:57', 'En Ligne', 'Payée', 83, 1),
(112, '2024-01-10 16:49:23', 'En Ligne', 'Payée', 84, 1),
(113, '2024-01-11 10:41:39', 'En Ligne', 'Payée', 85, 1),
(114, '2024-01-11 11:05:01', 'En Ligne', 'Payée', 89, 52),
(117, '2024-01-11 11:48:54', 'En Ligne', 'Payée', 88, 1),
(118, '2024-01-12 08:34:05', 'En Ligne', 'Payée', 91, 1),
(119, '2024-01-12 09:51:50', 'En Ligne', 'Payée', 92, 1),
(120, '2024-01-12 14:18:31', 'En Ligne', 'Payée', 90, 52);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `CommandesEnAttenteLivraison`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `CommandesEnAttenteLivraison` (
`IDCommande` int(11)
,`DateCommande` datetime
,`NomClient` varchar(50)
,`PrenomClient` varchar(50)
,`TelClient` varchar(14)
,`RueClient` varchar(100)
,`VilleClient` varchar(50)
,`PaysClient` varchar(50)
,`StatutLivraison` varchar(10)
);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `CommandesEnCoursLivraison`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `CommandesEnCoursLivraison` (
`IDCommande` int(11)
,`DateCommande` datetime
,`StatutPaiement` varchar(10)
,`DateLivraison` datetime
,`StatutLivraison` varchar(10)
,`NomClient` varchar(50)
,`PrenomClient` varchar(50)
);

-- --------------------------------------------------------

--
-- Structure de la table `contient_ingredients`
--

CREATE TABLE `contient_ingredients` (
  `IDIngredient` int(11) NOT NULL,
  `IDChoixIngredient` int(11) NOT NULL,
  `nbIngredients` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `contient_ingredients`
--

INSERT INTO `contient_ingredients` (`IDIngredient`, `IDChoixIngredient`, `nbIngredients`) VALUES
(1, 14, 5),
(1, 19, 6),
(1, 22, 1),
(1, 23, 7),
(1, 35, 3),
(1, 40, 2),
(1, 45, 1),
(1, 48, 2),
(1, 53, 1),
(1, 66, 0),
(1, 67, 1),
(2, 2, 3),
(2, 48, -1),
(3, 3, 2),
(4, 4, 2),
(5, 5, 4),
(5, 18, 0),
(6, 18, 1),
(6, 35, 2),
(7, 7, 3),
(7, 18, 1),
(7, 35, -5),
(7, 71, 2),
(8, 8, 5),
(8, 34, 1),
(9, 9, 2),
(10, 10, 2),
(10, 44, -1),
(10, 66, 1),
(10, 67, 0),
(12, 67, -1),
(12, 71, -1),
(14, 19, 0),
(14, 21, 2),
(14, 30, 3),
(15, 44, 2),
(17, 73, 1),
(18, 57, 1),
(18, 69, -5),
(20, 18, 1),
(23, 20, 11),
(23, 30, -3),
(26, 18, 1);

--
-- Déclencheurs `contient_ingredients`
--
DELIMITER $$
CREATE TRIGGER `before_insert_check_max_ingredients` BEFORE UPDATE ON `contient_ingredients` FOR EACH ROW BEGIN
    IF NEW.nbIngredients > 3 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Error: Attention, vous ne pouvez pas ajouter plus de 3 fois le meme ingrédient.';
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `DetailsCommandesLivreur`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `DetailsCommandesLivreur` (
`IDLivreur` int(11)
,`NomLivreur` varchar(50)
,`PrenomLivreur` varchar(50)
,`DateLivraison` datetime
,`StatutLivraison` varchar(10)
,`IDCommande` int(11)
,`ModePaiement` varchar(10)
);

-- --------------------------------------------------------

--
-- Structure de la table `est_composee`
--

CREATE TABLE `est_composee` (
  `IDIngredient` int(11) NOT NULL,
  `IDRecette` int(11) NOT NULL,
  `qtIngredientRecette` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `est_composee`
--

INSERT INTO `est_composee` (`IDIngredient`, `IDRecette`, `qtIngredientRecette`) VALUES
(1, 1, 5),
(1, 2, 2),
(1, 4, 2),
(1, 5, 2),
(1, 6, 2),
(1, 7, 2),
(1, 8, 2),
(1, 10, 2),
(1, 11, 2),
(1, 12, 1),
(1, 14, 2),
(1, 15, 2),
(1, 17, 1),
(2, 1, 3),
(2, 2, 1),
(2, 3, 2),
(2, 4, 2),
(2, 5, 2),
(2, 6, 2),
(2, 7, 2),
(2, 8, 1),
(2, 9, 1),
(2, 10, 2),
(2, 12, 1),
(2, 14, 1),
(2, 15, 1),
(3, 1, 1),
(4, 2, 3),
(5, 2, 1),
(6, 2, 4),
(6, 4, 4),
(6, 6, 3),
(7, 4, 2),
(7, 5, 2),
(7, 6, 1),
(7, 16, 5),
(7, 17, 2),
(8, 4, 6),
(8, 6, 1),
(8, 7, 2),
(10, 7, 1),
(10, 14, 2),
(10, 17, 2),
(11, 5, 1),
(11, 7, 2),
(11, 8, 1),
(12, 16, 1),
(13, 9, 1),
(13, 17, 1),
(14, 9, 2),
(14, 16, 2),
(15, 10, 10),
(16, 10, 2),
(17, 3, 1),
(17, 12, 5),
(18, 11, 2),
(18, 14, 1),
(19, 11, 2),
(20, 3, 2),
(20, 11, 2),
(20, 13, 1),
(22, 12, 1),
(23, 3, 2),
(25, 13, 6),
(25, 17, 3),
(26, 15, 5),
(27, 13, 3),
(28, 15, 3);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `HistoriquePaiement`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `HistoriquePaiement` (
`idCommande` int(11)
,`nomClient` varchar(50)
,`prenomclient` varchar(50)
,`datecommande` datetime
,`modePaiement` varchar(10)
,`NomPizzaDefaut` varchar(50)
,`PrixPizzaDefaut` double
);

-- --------------------------------------------------------

--
-- Structure de la table `Ingredient`
--

CREATE TABLE `Ingredient` (
  `IDIngredient` int(11) NOT NULL,
  `NomIngredient` varchar(50) DEFAULT NULL,
  `QtIngredientStock` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Ingredient`
--

INSERT INTO `Ingredient` (`IDIngredient`, `NomIngredient`, `QtIngredientStock`) VALUES
(1, 'Tomate', 53),
(2, 'Mozzarella', 80),
(3, 'Basilic', 30),
(4, 'Anchois', 20),
(5, 'Câpres', 10),
(6, 'Olives', 20),
(7, 'Jambon', 25),
(8, 'Champignons', 10),
(9, 'Oeuf', 10),
(10, 'Poivrons', 20),
(11, 'Oignons', 30),
(12, 'Sauce barbecue', 28),
(13, 'Crème fraîche', 20),
(14, 'Saumon fumé', 46),
(15, 'Crevettes', 20),
(16, 'Ail', 10),
(17, 'Persil', 39),
(18, 'Boeuf haché', 30),
(19, 'Bacon', 23),
(20, 'Cheddar', 25),
(21, 'Chèvre', 30),
(22, 'Miel', 19),
(23, 'Noix', 12),
(24, 'Pesto', 30),
(25, 'Tomates cerises', 11),
(26, 'Roquette', 20),
(27, 'Parmesan', 27),
(28, 'Prosciutto', 30),
(29, 'Jalapeños', 15);

-- --------------------------------------------------------

--
-- Structure de la table `Livraison`
--

CREATE TABLE `Livraison` (
  `IDLivraison` int(11) NOT NULL,
  `DateLivraison` datetime DEFAULT NULL,
  `StatutLivraison` varchar(10) DEFAULT NULL,
  `IDCommande` int(11) NOT NULL,
  `IDLivreur` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Livraison`
--

INSERT INTO `Livraison` (`IDLivraison`, `DateLivraison`, `StatutLivraison`, `IDCommande`, `IDLivreur`) VALUES
(2, '2023-12-02 17:45:00', 'En attente', 2, 2),
(3, '2023-12-03 11:45:00', 'En cours', 3, 3),
(4, '2023-12-03 12:15:00', 'Livré', 4, 4),
(5, '2023-12-03 12:25:00', 'Livré', 5, 5),
(6, '2023-12-09 15:45:00', 'En attente', 6, 6),
(7, '2023-12-12 10:45:00', 'En attente', 7, 7),
(8, '2023-11-25 13:10:00', 'En cours', 8, 8),
(9, '2023-10-18 19:15:00', 'En attente', 9, 9),
(10, '2023-09-05 17:10:00', 'Livré', 10, 10);

-- --------------------------------------------------------

--
-- Structure de la table `Livreur`
--

CREATE TABLE `Livreur` (
  `IDLivreur` int(11) NOT NULL,
  `NomLivreur` varchar(50) DEFAULT NULL,
  `PrenomLivreur` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Livreur`
--

INSERT INTO `Livreur` (`IDLivreur`, `NomLivreur`, `PrenomLivreur`) VALUES
(1, 'Dubois', 'Jean'),
(2, 'Martin', 'Pierre'),
(3, 'Bernard', 'Lucas'),
(4, 'Thomas', 'Antoine'),
(5, 'Leroy', 'Gabriel'),
(6, 'Laurent', 'Louis'),
(7, 'Girard', 'Hugo'),
(8, 'Robin', 'Paul'),
(9, 'Marchand', 'Maxime'),
(10, 'Lopez', 'Théo'),
(11, 'Dufour', 'Alexandre'),
(12, 'Gauthier', 'Matéo'),
(13, 'Navarro', 'Enzo'),
(14, 'Picard', 'Nathan'),
(15, 'Michel', 'Tom'),
(16, 'Dumas', 'Romain'),
(17, 'Fabre', 'Noah'),
(18, 'Guerin', 'Adam'),
(19, 'Dupuis', 'Mathis'),
(20, 'Roussel', 'Léo'),
(21, 'Colin', 'Arthur'),
(22, 'Renard', 'Ethan'),
(23, 'Philippe', 'Oscar'),
(24, 'Roger', 'Victor'),
(25, 'Carpentier', 'Eliott'),
(26, 'Legrand', 'Lucas'),
(27, 'Lemoine', 'Sacha'),
(28, 'Leclercq', 'Timéo'),
(29, 'Barbier', 'Jules'),
(30, 'Guillaume', 'Baptiste');

-- --------------------------------------------------------

--
-- Structure de la table `Paiement`
--

CREATE TABLE `Paiement` (
  `IDPaiement` int(11) NOT NULL,
  `NomPorteurCB` varchar(50) DEFAULT NULL,
  `codeCartePaiement` varchar(30) DEFAULT NULL,
  `datePeremptionPaiement` varchar(5) DEFAULT NULL,
  `cryptogrammePaiement` int(11) DEFAULT NULL,
  `IDCommande` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Paiement`
--

INSERT INTO `Paiement` (`IDPaiement`, `NomPorteurCB`, `codeCartePaiement`, `datePeremptionPaiement`, `cryptogrammePaiement`, `IDCommande`) VALUES
(2, 'Asta', '0000000000000000', '00/00', 123, 58),
(3, 'Jean Philippe', '0424423240293029', '12/25', 355, 60),
(4, 'mk', '9482309572305723', '42343', 4134, 61),
(5, 'Jean Philippe', '0001000200030004', '02/04', 112, 62),
(6, 'Bonjour', '0000000000000000', '23/23', 310, NULL),
(7, 'Bonjour2', '4546456389656439', '45645', 4564, 65),
(8, 'harcelement', '8464684684648485', '64646', 4646, 66),
(9, 'Jean Philippe', '0002000300040005', '12/26', 123, 68),
(10, 'Jean Philippe', '0001000200030004', '02/25', 123, 69),
(11, 'Jean Philippe', '0001000200030004', '02/24', 132, 70),
(12, 'Jean Philippe', '0001000200030004', '01/21', 123, 71),
(13, 'Jean Philippe', '0001000200030004', '12/29', 123, 72),
(14, 'j\'ai faim', '6426428468537544', '12/13', 123, 73),
(15, 'Jean Philippe', '0001000200030004', '12/25', 123, 74),
(19, 'SDarfsd', '0000000000000000', '01/12', 123, 78),
(24, 'asta ', '0000000000000000', '00/00', 123, 84),
(35, ';jhjj', '2455555555555555', '52452', 5245, 96),
(36, 'gdf', '1111111111111111', '01/25', 252, 99),
(37, 'fds', '111111111111111111', '11/11', 111, 100),
(38, 'Jean Philippe', '1000200030004000', '02/52', 123, 101),
(39, 'bcg', '11111111111111111111', '11111', 111, 104),
(40, 'sdq', '11111111111111111111111', '11111', 111, 105),
(43, 'Jean Philippe', '0001000200030004', '12/26', 123, 108),
(44, 'Monsieur Login', '0001000200030004', '12/26', 123, 109),
(45, 'Monsieur Login', '0001000200030004', '01/06', 165, 110),
(46, 'gdghdgdg', '2133541654156416', '11/25', 4656, 113),
(47, 'gkgkgkg', '6767676776767676', '12/23', 7676, 114),
(48, 'gkgkgkg', '6767676776767676', '12/23', 7676, NULL),
(49, 'gdghdgdg', '2133541654156416', '11/25', 4656, NULL),
(50, 'Jean Philippe', '1232144245155411', '12/56', 135, 117),
(51, 'Monsieur Login', '9191919283847488', '12/29', 173, 118),
(52, 'Jean Philippe', '2135415454545555', '12/24', 5555, 119),
(53, 'Jean Philippe', '1111111111111111', '11/25', 2525, 120);

-- --------------------------------------------------------

--
-- Structure de la table `Panier`
--

CREATE TABLE `Panier` (
  `IDPanier` int(11) NOT NULL,
  `estCommande` tinyint(1) DEFAULT NULL,
  `IDClient` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Panier`
--

INSERT INTO `Panier` (`IDPanier`, `estCommande`, `IDClient`) VALUES
(1, 1, 1),
(2, 1, 2),
(3, 0, 3),
(4, 0, 4),
(5, 0, 6),
(6, 1, 7),
(7, 1, 8),
(8, 1, 5),
(9, 1, 10),
(10, 1, 11),
(11, 1, 12),
(19, 0, 24),
(20, 0, 25),
(21, 1, 1),
(33, 1, 1),
(34, 1, 1),
(35, 1, 26),
(36, 1, 26),
(37, 1, 1),
(38, 1, 26),
(39, 1, 27),
(40, 1, 27),
(41, 1, 27),
(42, 1, 27),
(43, 1, 27),
(44, 1, 26),
(45, 1, 26),
(46, 1, 26),
(47, 1, 26),
(48, 1, 26),
(49, 0, 27),
(50, 1, 26),
(51, 1, 26),
(52, 1, 1),
(53, 1, 1),
(54, 0, 29),
(55, 0, 30),
(56, 0, 31),
(57, 0, 32),
(58, 0, 33),
(59, 0, 34),
(60, 0, 39),
(61, 1, 1),
(62, 1, 1),
(63, 1, 1),
(64, 1, 1),
(65, 1, 1),
(66, 0, 40),
(67, 0, 41),
(68, 0, 26),
(69, 0, 42),
(70, 1, 1),
(71, 0, 43),
(72, 1, 1),
(73, 1, 1),
(74, 1, 45),
(75, 1, 45),
(76, 0, 45),
(77, 0, 46),
(78, 0, 47),
(79, 0, 48),
(80, 0, 49),
(81, 1, 1),
(82, 1, 1),
(83, 1, 1),
(84, 1, 1),
(85, 1, 1),
(86, 0, 50),
(87, 0, 51),
(88, 1, 1),
(89, 1, 52),
(90, 1, 52),
(91, 1, 1),
(92, 1, 1),
(93, 0, 1),
(94, 0, 52),
(95, 0, 54);

-- --------------------------------------------------------

--
-- Structure de la table `Pizza`
--

CREATE TABLE `Pizza` (
  `IDPizza` int(11) NOT NULL,
  `IDPanier` int(11) NOT NULL,
  `IDPizzaDefaut` int(11) NOT NULL,
  `estCuisine` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Pizza`
--

INSERT INTO `Pizza` (`IDPizza`, `IDPanier`, `IDPizzaDefaut`, `estCuisine`) VALUES
(3, 2, 5, 1),
(4, 3, 9, 1),
(5, 4, 12, 1),
(6, 5, 14, 1),
(7, 6, 7, 1),
(8, 7, 10, 1),
(9, 8, 2, 1),
(10, 8, 4, 1),
(11, 9, 6, 1),
(12, 10, 11, 1),
(13, 5, 1, 1),
(15, 19, 9, 0),
(16, 19, 9, 0),
(17, 19, 9, 0),
(18, 19, 9, 0),
(19, 19, 9, 0),
(20, 19, 15, 0),
(21, 1, 9, 1),
(22, 21, 2, 0),
(23, 33, 1, 1),
(25, 35, 3, 1),
(26, 36, 9, 1),
(27, 34, 9, 1),
(28, 34, 3, 1),
(29, 39, 9, 1),
(30, 39, 1, 1),
(31, 40, 1, 1),
(32, 40, 2, 1),
(33, 41, 2, 1),
(34, 42, 1, 1),
(50, 42, 9, 1),
(92, 38, 9, 1),
(93, 44, 4, 1),
(94, 45, 9, 1),
(95, 46, 13, 1),
(96, 46, 2, 1),
(97, 47, 9, 1),
(98, 48, 1, 1),
(102, 50, 2, 1),
(106, 50, 9, 1),
(117, 37, 9, 1),
(118, 37, 9, 1),
(119, 37, 9, 1),
(120, 37, 9, 1),
(121, 37, 9, 1),
(122, 37, 9, 1),
(123, 37, 9, 1),
(124, 37, 9, 1),
(125, 37, 9, 1),
(126, 37, 9, 1),
(127, 37, 9, 1),
(128, 37, 9, 1),
(129, 37, 9, 1),
(130, 52, 3, 1),
(131, 53, 9, 1),
(133, 53, 9, 1),
(135, 61, 5, 1),
(136, 62, 9, 1),
(137, 64, 9, 1),
(138, 51, 16, 1),
(139, 65, 16, 1),
(142, 70, 17, 1),
(143, 73, 16, 1),
(144, 73, 3, 1),
(147, 81, 17, 0),
(148, 81, 14, 0),
(149, 82, 4, 0),
(150, 82, 3, 0),
(151, 82, 2, 0),
(152, 83, 10, 0),
(153, 83, 3, 0),
(154, 83, 3, 0),
(155, 84, 16, 0),
(157, 85, 2, 0),
(158, 85, 3, 0),
(159, 85, 4, 0),
(160, 85, 3, 0),
(161, 87, 13, 0),
(162, 87, 11, 0),
(163, 89, 16, 0),
(164, 89, 17, 0),
(165, 89, 7, 0),
(166, 88, 16, 0),
(170, 91, 2, 1),
(171, 92, 16, 1),
(172, 92, 4, 0),
(173, 93, 16, 0),
(174, 93, 1, 0),
(175, 90, 16, 0),
(176, 90, 4, 0),
(177, 94, 16, 0),
(178, 94, 16, 0),
(179, 93, 16, 0),
(180, 93, 1, 0);

--
-- Déclencheurs `Pizza`
--
DELIMITER $$
CREATE TRIGGER `majStockApresCuisson` BEFORE UPDATE ON `Pizza` FOR EACH ROW BEGIN
    DECLARE ingredient_id INT;
    DECLARE ingredient_qt INT;
    DECLARE finished INTEGER DEFAULT 0;
    DECLARE ingredient_cursor CURSOR FOR
        SELECT DISTINCT idingredient, qtingredientrecette
        FROM Panier
        NATURAL JOIN Pizza
        NATURAL JOIN PizzaDefaut
        NATURAL JOIN Recette
        NATURAL JOIN est_composee
        WHERE IDPizzaDefaut = NEW.IDPizzaDefaut;


     DECLARE CONTINUE HANDLER FOR NOT FOUND SET finished = 1;

    IF NEW.estCuisine = TRUE AND OLD.estCuisine = FALSE THEN

        OPEN ingredient_cursor;

        majStockIngredients:LOOP
            FETCH ingredient_cursor INTO ingredient_id, ingredient_qt;
            IF finished = 1 THEN 
                LEAVE majStockIngredients;
            END IF;

            UPDATE Ingredient
            SET QtIngredientStock = QtIngredientStock - ingredient_qt
            WHERE IDIngredient = ingredient_id;
        END LOOP majStockIngredients;

        CLOSE ingredient_cursor;
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Structure de la table `PizzaDefaut`
--

CREATE TABLE `PizzaDefaut` (
  `IDPizzaDefaut` int(11) NOT NULL,
  `NomPizzaDefaut` varchar(50) DEFAULT NULL,
  `DescriptionPizzaDefaut` varchar(200) DEFAULT NULL,
  `PrixPizzaDefaut` double DEFAULT NULL,
  `PizzaDuMoment` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `PizzaDefaut`
--

INSERT INTO `PizzaDefaut` (`IDPizzaDefaut`, `NomPizzaDefaut`, `DescriptionPizzaDefaut`, `PrixPizzaDefaut`, `PizzaDuMoment`) VALUES
(1, 'Margherita', 'La pizza pour les rats experts ! Pour ceux qui ont un petit creux (les étudiants) ', 10, 0),
(2, 'Napolitaine', 'On est pas encore retourné à l\'ère ancien ! Je parle bien de Napoléon !', 12, 0),
(3, 'Quatre fromages', 'Pour nos bons savoyards ! Parfaite pour les fans de fromage.', 14, 0),
(4, 'Royale', 'Exclusivement pour nos clients les rois de ce monde !', 15, 0),
(5, 'Hawaïenne', 'Qui prend encore cette pizza sérieux ? ( mise à part les goats )', 13, 0),
(6, 'Calzone', 'Une calzone qui n\'en est pas vraiment une ... Rien ne vaut le coup d\'essai !', 16, 0),
(7, 'Végétarienne', 'Pour nos amis les végans qu\'on oublie souvent ... On vous aime', 14, 0),
(8, 'Poulet barbecue', 'Une pizza sous-côté mais qui peut être à la vue de tous !', 15, 0),
(9, 'Saumon fumé', 'Pour les amateurs de la mer ! Hmmmm du saumon fumé', 16, 0),
(10, 'Crevettes', 'Aussi pour les amateurs de la mer ! Faut juste les décortiquer', 17, 0),
(11, 'Bacon cheeseburger', 'La pizza pour les bons gros fans de gras et de porc. Tout est bon dans le cochon', 18, 0),
(12, 'Chèvre miel', 'Je déteste cette pizza perso mais pourquoi pas essayer', 15, 0),
(13, 'Pesto', 'Pourquoi le pesto est-il toujours détendu? Parce qu\'il a la bonne \"herbe\" dans sa vie ! (blague de GPT)', 14, 0),
(14, 'Mexicaine', 'Non on ne fera pas d\'appropriation mais elle vous fera voyager !', 16, 0),
(15, 'Prosciutto', 'Pour les italiens en herbe ! Vous ne serez pas déçus eheh !', 17, 0),
(16, 'Pizza De La Mama', 'La délicieuse pizza du youtubeur Mister V !!!!!! Hmmm à table !!', 16, 1),
(17, 'La truffio', 'Une pizza en édition limitée ! Pour se sentir riche une fois dans sa vie !', 25, 0),
(18, 'MCT', 'Ceci est un MCT', 15, 0);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `PizzaPlusCommandee`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `PizzaPlusCommandee` (
`IDPizzaDefaut` int(11)
,`NomPizzaDefaut` varchar(50)
,`NombreDeCommandes` bigint(21)
);

-- --------------------------------------------------------

--
-- Structure de la table `possede`
--

CREATE TABLE `possede` (
  `IDProduit` int(11) NOT NULL,
  `IDPanier` int(11) NOT NULL,
  `quantite` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `possede`
--

INSERT INTO `possede` (`IDProduit`, `IDPanier`, `quantite`) VALUES
(1, 87, 1),
(1, 93, 2),
(2, 2, 1),
(2, 40, 1),
(2, 70, 1),
(2, 72, 2),
(3, 3, 1),
(3, 37, 1),
(3, 39, 1),
(3, 46, 1),
(3, 48, 1),
(3, 68, 2),
(3, 70, 2),
(3, 83, 1),
(4, 2, 1),
(5, 4, 1),
(5, 42, 1),
(5, 53, 1),
(6, 39, 1),
(6, 50, 1),
(6, 52, 1),
(7, 1, 1),
(7, 5, 1),
(7, 37, 1),
(7, 93, 1),
(8, 9, 1),
(8, 36, 1),
(8, 37, 1),
(8, 90, 1),
(9, 3, 1),
(9, 44, 1),
(10, 4, 1),
(10, 37, 1),
(10, 82, 1),
(10, 87, 1),
(13, 87, 1),
(14, 63, 1),
(16, 35, 1),
(17, 87, 1),
(20, 53, 1),
(20, 87, 1),
(21, 87, 1),
(24, 37, 1),
(24, 40, 1),
(24, 87, 1);

-- --------------------------------------------------------

--
-- Structure de la table `Produit`
--

CREATE TABLE `Produit` (
  `IDProduit` int(11) NOT NULL,
  `TypeProduit` varchar(50) DEFAULT NULL,
  `NomProduit` varchar(50) DEFAULT NULL,
  `PrixProduit` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Produit`
--

INSERT INTO `Produit` (`IDProduit`, `TypeProduit`, `NomProduit`, `PrixProduit`) VALUES
(1, 'Gateau', 'Tiramisu', 4.99),
(2, 'Gateau', 'Panna Cotta', 5.49),
(3, 'Fruits', 'Salade de Fruits Frais', 3.99),
(4, 'Boisson', 'Café Expresso', 1.99),
(5, 'Boisson', 'Thé Vert', 2.49),
(6, 'Boisson', 'Soda Citron 33cl', 2.29),
(7, 'Boisson', 'Eau Gazeuse 50cl', 1.99),
(8, 'Gateau', 'Muffin aux Pépites de Chocolat', 3.49),
(9, 'Gateau', 'Yaourt aux Fruits', 2.99),
(10, 'Boisson', 'Smoothie Fraise-Banane', 4.49),
(11, 'Boisson', 'Cappuccino', 3.49),
(12, 'Boisson', 'Jus d\'Orange Frais 25cl', 2.99),
(13, 'Boisson', 'Chocolat Chaud', 3.99),
(14, 'Gateau', 'Brownie aux Noix', 4.99),
(15, 'Boisson', 'Eau Plate 50cl', 1.49),
(16, 'Boisson', 'Café Américain', 2.29),
(17, 'Gateau', 'Mousse au Chocolat', 4.49),
(18, 'Boisson', 'Thé à la Menthe', 2.99),
(19, 'Boisson', 'Limonade Artisanale', 3.99),
(20, 'Gateau', 'Cheesecake aux Fruits Rouges', 5.99),
(21, 'Gateau', 'Cookie aux Pépites de Chocolat', 2.49),
(22, 'Boisson', 'Café Latte', 3.49),
(23, 'Boisson', 'Thé Earl Grey', 2.79),
(24, 'Glace', 'Glace Vanille', 3.99),
(25, 'Gateau', 'Tarte aux Pommes', 5.49),
(26, 'Boisson', 'Milkshake à la Fraise', 4.99),
(27, 'Gateau', 'Muffin aux Myrtilles', 3.49),
(28, 'Boisson', 'Jus de Pomme Bio 25cl', 2.99),
(29, 'Gateau', 'Gâteau au Citron', 4.49),
(30, 'Boisson', 'Eau de Coco 33cl', 3.29);

-- --------------------------------------------------------

--
-- Structure de la table `produit_comprend`
--

CREATE TABLE `produit_comprend` (
  `IDProduit` int(11) NOT NULL,
  `IDAllergene` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `produit_comprend`
--

INSERT INTO `produit_comprend` (`IDProduit`, `IDAllergene`) VALUES
(1, 26),
(2, 27),
(8, 2),
(8, 26),
(9, 27),
(11, 27),
(13, 27),
(14, 26),
(14, 29),
(17, 27),
(20, 2),
(20, 26),
(21, 2),
(21, 31),
(22, 29),
(24, 27),
(25, 26),
(26, 27),
(27, 32),
(29, 37);

-- --------------------------------------------------------

--
-- Structure de la table `Recette`
--

CREATE TABLE `Recette` (
  `IDRecette` int(11) NOT NULL,
  `IDPizzaDefaut` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `Recette`
--

INSERT INTO `Recette` (`IDRecette`, `IDPizzaDefaut`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 4),
(5, 5),
(6, 6),
(7, 7),
(8, 8),
(9, 9),
(10, 10),
(11, 11),
(12, 12),
(13, 13),
(14, 14),
(15, 15),
(16, 16),
(17, 17);

-- --------------------------------------------------------

--
-- Structure de la table `recette_comprend`
--

CREATE TABLE `recette_comprend` (
  `IDRecette` int(11) NOT NULL,
  `IDAllergene` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `recette_comprend`
--

INSERT INTO `recette_comprend` (`IDRecette`, `IDAllergene`) VALUES
(1, 2),
(1, 3),
(1, 25),
(2, 4),
(2, 5),
(2, 6),
(3, 2),
(3, 17),
(3, 20),
(3, 23),
(4, 6),
(4, 7),
(4, 8),
(5, 7),
(5, 11),
(6, 6),
(6, 7),
(6, 8),
(7, 6),
(7, 8),
(7, 10),
(7, 11),
(8, 11),
(9, 13),
(9, 14),
(9, 17),
(10, 7),
(10, 11),
(10, 16),
(10, 17),
(11, 8),
(11, 11),
(11, 19),
(12, 17),
(12, 22),
(13, 20),
(13, 25),
(14, 8),
(14, 10),
(14, 11);

-- --------------------------------------------------------

--
-- Doublure de structure pour la vue `VueGestionPizzas`
-- (Voir ci-dessous la vue réelle)
--
CREATE TABLE `VueGestionPizzas` (
`idingredient` int(11)
,`nomingredient` varchar(50)
,`qtingredientstock` int(11)
,`idalerte` int(11)
,`qtingredientalerte` int(11)
);

-- --------------------------------------------------------

--
-- Structure de la vue `CommandesEnAttenteLivraison`
--
DROP TABLE IF EXISTS `CommandesEnAttenteLivraison`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pizzeria`@`%` SQL SECURITY DEFINER VIEW `CommandesEnAttenteLivraison`  AS SELECT `c`.`IDCommande` AS `IDCommande`, `c`.`DateCommande` AS `DateCommande`, `cl`.`NomClient` AS `NomClient`, `cl`.`PrenomClient` AS `PrenomClient`, `cl`.`TelClient` AS `TelClient`, `cl`.`RueClient` AS `RueClient`, `cl`.`VilleClient` AS `VilleClient`, `cl`.`PaysClient` AS `PaysClient`, `l`.`StatutLivraison` AS `StatutLivraison` FROM ((`Commande` `c` join `Client` `cl` on(`c`.`IDClient` = `cl`.`IDClient`)) join `Livraison` `l` on(`c`.`IDCommande` = `l`.`IDCommande`)) WHERE `l`.`StatutLivraison` = 'En attente' ;

-- --------------------------------------------------------

--
-- Structure de la vue `CommandesEnCoursLivraison`
--
DROP TABLE IF EXISTS `CommandesEnCoursLivraison`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pizzeria`@`%` SQL SECURITY DEFINER VIEW `CommandesEnCoursLivraison`  AS SELECT `c`.`IDCommande` AS `IDCommande`, `c`.`DateCommande` AS `DateCommande`, `c`.`StatutPaiement` AS `StatutPaiement`, `l`.`DateLivraison` AS `DateLivraison`, `l`.`StatutLivraison` AS `StatutLivraison`, `cl`.`NomClient` AS `NomClient`, `cl`.`PrenomClient` AS `PrenomClient` FROM ((`Commande` `c` join `Livraison` `l` on(`c`.`IDCommande` = `l`.`IDCommande`)) join `Client` `cl` on(`c`.`IDClient` = `cl`.`IDClient`)) WHERE `l`.`StatutLivraison` = 'En cours' ;

-- --------------------------------------------------------

--
-- Structure de la vue `DetailsCommandesLivreur`
--
DROP TABLE IF EXISTS `DetailsCommandesLivreur`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pizzeria`@`%` SQL SECURITY DEFINER VIEW `DetailsCommandesLivreur`  AS SELECT `l`.`IDLivreur` AS `IDLivreur`, `l`.`NomLivreur` AS `NomLivreur`, `l`.`PrenomLivreur` AS `PrenomLivreur`, `lv`.`DateLivraison` AS `DateLivraison`, `lv`.`StatutLivraison` AS `StatutLivraison`, `c`.`IDCommande` AS `IDCommande`, `c`.`ModePaiement` AS `ModePaiement` FROM ((`Livreur` `l` join `Livraison` `lv` on(`l`.`IDLivreur` = `lv`.`IDLivreur`)) join `Commande` `c` on(`lv`.`IDCommande` = `c`.`IDCommande`)) ;

-- --------------------------------------------------------

--
-- Structure de la vue `HistoriquePaiement`
--
DROP TABLE IF EXISTS `HistoriquePaiement`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pizzeria`@`%` SQL SECURITY DEFINER VIEW `HistoriquePaiement`  AS SELECT `CO`.`IDCommande` AS `idCommande`, `C`.`NomClient` AS `nomClient`, `C`.`PrenomClient` AS `prenomclient`, `CO`.`DateCommande` AS `datecommande`, `CO`.`ModePaiement` AS `modePaiement`, `PI`.`NomPizzaDefaut` AS `NomPizzaDefaut`, `PI`.`PrixPizzaDefaut` AS `PrixPizzaDefaut` FROM (((`Commande` `CO` join `Client` `C` on(`CO`.`IDClient` = `C`.`IDClient`)) join `Panier` `P` on(`CO`.`IDClient` = `P`.`IDClient` and `CO`.`IDPanier` = `P`.`IDPanier`)) join `PizzaDefaut` `PI`) ;

-- --------------------------------------------------------

--
-- Structure de la vue `PizzaPlusCommandee`
--
DROP TABLE IF EXISTS `PizzaPlusCommandee`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pizzeria`@`%` SQL SECURITY DEFINER VIEW `PizzaPlusCommandee`  AS SELECT `P`.`IDPizzaDefaut` AS `IDPizzaDefaut`, `PD`.`NomPizzaDefaut` AS `NomPizzaDefaut`, count(0) AS `NombreDeCommandes` FROM (`Pizza` `P` join `PizzaDefaut` `PD` on(`P`.`IDPizzaDefaut` = `PD`.`IDPizzaDefaut`)) GROUP BY `P`.`IDPizzaDefaut`, `PD`.`NomPizzaDefaut` ORDER BY count(0) DESC ;

-- --------------------------------------------------------

--
-- Structure de la vue `VueGestionPizzas`
--
DROP TABLE IF EXISTS `VueGestionPizzas`;

CREATE ALGORITHM=UNDEFINED DEFINER=`pizzeria`@`%` SQL SECURITY DEFINER VIEW `VueGestionPizzas`  AS SELECT `I`.`IDIngredient` AS `idingredient`, `I`.`NomIngredient` AS `nomingredient`, `I`.`QtIngredientStock` AS `qtingredientstock`, `A`.`IDAlerte` AS `idalerte`, `A`.`QtIngredientAlerte` AS `qtingredientalerte` FROM (`Ingredient` `I` join `Alerte` `A` on(`I`.`IDIngredient` = `A`.`IDIngredient`)) ;

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Alerte`
--
ALTER TABLE `Alerte`
  ADD PRIMARY KEY (`IDAlerte`),
  ADD KEY `IDIngredient` (`IDIngredient`);

--
-- Index pour la table `Allergene`
--
ALTER TABLE `Allergene`
  ADD PRIMARY KEY (`IDAllergene`);

--
-- Index pour la table `ChoixIngredient`
--
ALTER TABLE `ChoixIngredient`
  ADD PRIMARY KEY (`IDChoixIngredient`),
  ADD UNIQUE KEY `IDPizza` (`IDPizza`),
  ADD UNIQUE KEY `IDPizza_2` (`IDPizza`),
  ADD KEY `IDPanier` (`IDPanier`);

--
-- Index pour la table `Client`
--
ALTER TABLE `Client`
  ADD PRIMARY KEY (`IDClient`),
  ADD UNIQUE KEY `loginClient` (`loginClient`);

--
-- Index pour la table `Commande`
--
ALTER TABLE `Commande`
  ADD PRIMARY KEY (`IDCommande`),
  ADD UNIQUE KEY `IDPanier` (`IDPanier`),
  ADD KEY `IDClient` (`IDClient`);

--
-- Index pour la table `contient_ingredients`
--
ALTER TABLE `contient_ingredients`
  ADD PRIMARY KEY (`IDIngredient`,`IDChoixIngredient`),
  ADD KEY `IDChoixIngredient` (`IDChoixIngredient`);

--
-- Index pour la table `est_composee`
--
ALTER TABLE `est_composee`
  ADD PRIMARY KEY (`IDIngredient`,`IDRecette`),
  ADD KEY `IDRecette` (`IDRecette`);

--
-- Index pour la table `Ingredient`
--
ALTER TABLE `Ingredient`
  ADD PRIMARY KEY (`IDIngredient`);

--
-- Index pour la table `Livraison`
--
ALTER TABLE `Livraison`
  ADD PRIMARY KEY (`IDLivraison`),
  ADD UNIQUE KEY `IDCommande` (`IDCommande`),
  ADD KEY `IDLivreur` (`IDLivreur`);

--
-- Index pour la table `Livreur`
--
ALTER TABLE `Livreur`
  ADD PRIMARY KEY (`IDLivreur`);

--
-- Index pour la table `Paiement`
--
ALTER TABLE `Paiement`
  ADD PRIMARY KEY (`IDPaiement`),
  ADD KEY `IDCommande` (`IDCommande`);

--
-- Index pour la table `Panier`
--
ALTER TABLE `Panier`
  ADD PRIMARY KEY (`IDPanier`),
  ADD KEY `IDClient` (`IDClient`);

--
-- Index pour la table `Pizza`
--
ALTER TABLE `Pizza`
  ADD PRIMARY KEY (`IDPizza`),
  ADD KEY `IDPanier` (`IDPanier`),
  ADD KEY `IDPizzaDefaut` (`IDPizzaDefaut`);

--
-- Index pour la table `PizzaDefaut`
--
ALTER TABLE `PizzaDefaut`
  ADD PRIMARY KEY (`IDPizzaDefaut`);

--
-- Index pour la table `possede`
--
ALTER TABLE `possede`
  ADD PRIMARY KEY (`IDProduit`,`IDPanier`),
  ADD KEY `IDPanier` (`IDPanier`);

--
-- Index pour la table `Produit`
--
ALTER TABLE `Produit`
  ADD PRIMARY KEY (`IDProduit`);

--
-- Index pour la table `produit_comprend`
--
ALTER TABLE `produit_comprend`
  ADD PRIMARY KEY (`IDProduit`,`IDAllergene`),
  ADD KEY `IDAllergene` (`IDAllergene`);

--
-- Index pour la table `Recette`
--
ALTER TABLE `Recette`
  ADD PRIMARY KEY (`IDRecette`),
  ADD KEY `IDPizzaDefaut` (`IDPizzaDefaut`);

--
-- Index pour la table `recette_comprend`
--
ALTER TABLE `recette_comprend`
  ADD PRIMARY KEY (`IDRecette`,`IDAllergene`),
  ADD KEY `IDAllergene` (`IDAllergene`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Alerte`
--
ALTER TABLE `Alerte`
  MODIFY `IDAlerte` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pour la table `ChoixIngredient`
--
ALTER TABLE `ChoixIngredient`
  MODIFY `IDChoixIngredient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT pour la table `Client`
--
ALTER TABLE `Client`
  MODIFY `IDClient` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT pour la table `Commande`
--
ALTER TABLE `Commande`
  MODIFY `IDCommande` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=121;

--
-- AUTO_INCREMENT pour la table `Paiement`
--
ALTER TABLE `Paiement`
  MODIFY `IDPaiement` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT pour la table `Panier`
--
ALTER TABLE `Panier`
  MODIFY `IDPanier` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Alerte`
--
ALTER TABLE `Alerte`
  ADD CONSTRAINT `Alerte_ibfk_1` FOREIGN KEY (`IDIngredient`) REFERENCES `Ingredient` (`IDIngredient`);

--
-- Contraintes pour la table `ChoixIngredient`
--
ALTER TABLE `ChoixIngredient`
  ADD CONSTRAINT `ChoixIngredient_ibfk_1` FOREIGN KEY (`IDPanier`) REFERENCES `Panier` (`IDPanier`),
  ADD CONSTRAINT `ChoixIngredient_ibfk_2` FOREIGN KEY (`IDPizza`) REFERENCES `Pizza` (`IDPizza`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Commande`
--
ALTER TABLE `Commande`
  ADD CONSTRAINT `Commande_ibfk_1` FOREIGN KEY (`IDPanier`) REFERENCES `Panier` (`IDPanier`),
  ADD CONSTRAINT `Commande_ibfk_2` FOREIGN KEY (`IDClient`) REFERENCES `Client` (`IDClient`);

--
-- Contraintes pour la table `contient_ingredients`
--
ALTER TABLE `contient_ingredients`
  ADD CONSTRAINT `contient_ingredients_ibfk_1` FOREIGN KEY (`IDIngredient`) REFERENCES `Ingredient` (`IDIngredient`),
  ADD CONSTRAINT `contient_ingredients_ibfk_2` FOREIGN KEY (`IDChoixIngredient`) REFERENCES `ChoixIngredient` (`IDChoixIngredient`) ON DELETE CASCADE;

--
-- Contraintes pour la table `est_composee`
--
ALTER TABLE `est_composee`
  ADD CONSTRAINT `est_composee_ibfk_1` FOREIGN KEY (`IDIngredient`) REFERENCES `Ingredient` (`IDIngredient`),
  ADD CONSTRAINT `est_composee_ibfk_2` FOREIGN KEY (`IDRecette`) REFERENCES `Recette` (`IDRecette`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Livraison`
--
ALTER TABLE `Livraison`
  ADD CONSTRAINT `Livraison_ibfk_1` FOREIGN KEY (`IDCommande`) REFERENCES `Commande` (`IDCommande`),
  ADD CONSTRAINT `Livraison_ibfk_2` FOREIGN KEY (`IDLivreur`) REFERENCES `Livreur` (`IDLivreur`);

--
-- Contraintes pour la table `Paiement`
--
ALTER TABLE `Paiement`
  ADD CONSTRAINT `Paiement_ibfk_1` FOREIGN KEY (`IDCommande`) REFERENCES `Commande` (`IDCommande`) ON DELETE CASCADE;

--
-- Contraintes pour la table `Panier`
--
ALTER TABLE `Panier`
  ADD CONSTRAINT `Panier_ibfk_1` FOREIGN KEY (`IDClient`) REFERENCES `Client` (`IDClient`);

--
-- Contraintes pour la table `Pizza`
--
ALTER TABLE `Pizza`
  ADD CONSTRAINT `Pizza_ibfk_1` FOREIGN KEY (`IDPanier`) REFERENCES `Panier` (`IDPanier`),
  ADD CONSTRAINT `Pizza_ibfk_2` FOREIGN KEY (`IDPizzaDefaut`) REFERENCES `PizzaDefaut` (`IDPizzaDefaut`) ON DELETE CASCADE;

--
-- Contraintes pour la table `possede`
--
ALTER TABLE `possede`
  ADD CONSTRAINT `possede_ibfk_1` FOREIGN KEY (`IDProduit`) REFERENCES `Produit` (`IDProduit`),
  ADD CONSTRAINT `possede_ibfk_2` FOREIGN KEY (`IDPanier`) REFERENCES `Panier` (`IDPanier`);

--
-- Contraintes pour la table `produit_comprend`
--
ALTER TABLE `produit_comprend`
  ADD CONSTRAINT `produit_comprend_ibfk_1` FOREIGN KEY (`IDProduit`) REFERENCES `Produit` (`IDProduit`),
  ADD CONSTRAINT `produit_comprend_ibfk_2` FOREIGN KEY (`IDAllergene`) REFERENCES `Allergene` (`IDAllergene`);

--
-- Contraintes pour la table `Recette`
--
ALTER TABLE `Recette`
  ADD CONSTRAINT `Recette_ibfk_1` FOREIGN KEY (`IDPizzaDefaut`) REFERENCES `PizzaDefaut` (`IDPizzaDefaut`);

--
-- Contraintes pour la table `recette_comprend`
--
ALTER TABLE `recette_comprend`
  ADD CONSTRAINT `recette_comprend_ibfk_1` FOREIGN KEY (`IDRecette`) REFERENCES `Recette` (`IDRecette`),
  ADD CONSTRAINT `recette_comprend_ibfk_2` FOREIGN KEY (`IDAllergene`) REFERENCES `Allergene` (`IDAllergene`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
