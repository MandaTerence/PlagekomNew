-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mar. 18 mai 2021 à 10:16
-- Version du serveur :  10.3.27-MariaDB-0+deb10u1
-- Version de PHP : 7.3.27-1~deb10u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `combo1588192`
--

-- --------------------------------------------------------

--
-- Structure de la table `privillege`
--

CREATE TABLE `privillege` (
  `Id` int(250) NOT NULL,
  `Periode` varchar(250) NOT NULL,
  `Fonction` varchar(10) NOT NULL,
  `Designation` varchar(50) NOT NULL,
  `Contenu` text NOT NULL,
  `Point_initial` int(11) NOT NULL,
  `Point_final` int(11) NOT NULL,
  `couleur` varchar(7) NOT NULL,
  `Date_de_creation` date NOT NULL,
  `Date_desactive` date NOT NULL,
  `Statut` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `privillege`
--

INSERT INTO `privillege` (`Id`, `Periode`, `Fonction`, `Designation`, `Contenu`, `Point_initial`, `Point_final`, `couleur`, `Date_de_creation`, `Date_desactive`, `Statut`) VALUES
(7, 'Bimestriels', 'Commercial', 'Beginner', '<ul class=\"beginner\"><li>Réduction des téléphoniques :20%</li><li>Réduction des sur absence : 0%</li><li>Réduction de Malus : 20%</li></ul>', 0, 1999, '#e91e63', '2020-04-07', '0000-00-00', 'On'),
(8, 'Bimestriels', 'Commercial', 'Intermediate', '<ul class=\"intermediate\"><li>Réduction de s téléphoniques : 30%</li><li>Réduction de s sur absence : 10%</li><li>Réduction de Malus : 30% </li></ul>', 2000, 3999, '#0099CC', '2020-04-07', '0000-00-00', 'On'),
(9, 'Bimestriels', 'Commercial', 'Confirmed', '<ul class=\"confirmed\"><li>Bonus mensuel : 10.000,00 Ar</li><li>Bonus sur journée travaillée *uniquement pour les commerciaux locaux : 600,00 Ar</li><li>Jour de repos supplémentaire après mission* : 1 jours </li>                           <li>Réduction de s téléphoniques : 50%</li><li>Réduction de s sur absence : 30%</li><li>Réduction de Malus : 50%</li><li>Déduction de frais de transport en cas d\'abandon sur mission (cas de force majeure) : 20%</li>\r\n<li>Participation sur les frais de connexion par jour en MGA : 600,00 Ar</li><li>Supplément sur le panier de nourriture par jour en MGA: 500,00 Ar</li><li>Remboursement sur frais médicaux:20%</li><li>Choix d\'un article hors panier par jour</li><li>Priorité sur la distribution des marchandises le matin</li><li>Priorité sur la remise des marchandises le soir</li><li>Autorisé à percevoir un pourboire de 15%</li></ul>', 6000, 9999, '#ad1457', '2020-04-07', '0000-00-00', 'On'),
(10, 'Bimestriels', 'Commercial', 'Professionnal', ' <ul class=\"professionnal\"><li>Bonus mensuel : 20.000,00 Ar </li><li>Bonus par journée travaillée *uniquement pour les commerciaux locaux : 800,00 Ar </li>\r\n<li>Jour de repos supplémentaire après mission* : 2 jours</li><li>Réduction de s téléphoniques : 60%</li><li>Réduction de s sur absence : 40%</li><li>Réduction de Malus : 70%</li><li>Réduction de frais de transport en cas d\'abandon sur mission ( cas de force majeure) : 30%</li><li>Participation sur les frais de connexion par jour en MGA: 600,00 Ar </li><li>Supplément sur le panier de nourriture par jour en MGA : 1.000,00 Ar </li><li>Remboursement sur frais médicaux: 25% </li><li>Choix de 2 articles hors panier par jour</li><li>Priorité sur la distribution des marchandises le matin</li><li>Priorité sur la remise des marchandises le soir</li><li>Priorité sur les marchandises en cas d\'insuffisance de produits</li><li>Priorité sur avances sur salaire à hauteur de _ _ pourcent du salaire en cours:30%</li></ul>', 10000, 12999, '#3949ab', '2020-04-07', '0000-00-00', 'On'),
(11, 'Bimestriels', 'Commercial', 'Expert', ' <ul class=\"expert\"> <li>Bonus mensuel : 30.000,00 Ar</li><li>Bonus par journée travaillée *uniquement pour les commerciaux locaux : 1.200,00 Ar</li><li>Jour de repos supplémentaire après mission* : 3 jours</li><li>Réduction de s téléphoniques : 70%</li><li>Réduction de s sur absence : 50%</li><li>Réduction de Malus : 90%</li><li>Réduction de frais de transport en cas d\'abandon sur mission ( cas de force majeure) : 50%</li><li>Participation sur les frais de connexion par jour en MGA : 600,00 Ar</li><li>Supplément sur le panier de nourriture par jour en MGA : 1.200,00 Ar</li><li>Remboursement sur frais médicaux:35%</li><li>Priorité sur avances sur salaire à hauteur de _ _ pourcent du salaire en cours : 60%</li><li>Choix de 2 articles hors panier par jour</li><li>Priorité sur la distribution des marchandises le matin</li><li>Priorité sur la remise des marchandises le soir</li><li>Priorité sur les marchandises en cas d\'insuffisance de produits</li><li>Priorité sur avances sur salaire à hauteur de _ _ pourcent du salaire en cours:30%</li></ul>', 13000, 9999999, '#00acc1', '2020-04-07', '0000-00-00', 'On'),
(12, 'Annuel', 'Commercial', 'Natural', '<ul class=\"nat\"><li>Aucun privilège</li></ul>', 0, 71999, '#149046', '2020-04-07', '0000-00-00', 'On'),
(13, 'Annuel', 'Commercial', 'Silver', '<ul class=\"silv\"><li>13 ème mois sur moyenne de salaire net hors avantages sur 12 mois:20%</li><li>Panier garnie :30.000,00 Ar</li><li>Avances spéciales annuelles remboursables sur 2 mois - Renouvelable 2 fois: 60,000.00 Ar</li>\r\n</ul>', 72000, 99999, '#C0C0C0', '2020-04-07', '0000-00-00', 'On'),
(14, 'Annuel', 'Commercial', 'Gold', '<ul class=\"gold\"><li>13 ème mois sur moyenne de salaire net hors avantages sur 12 mois:50%</li><li>Panier garnie :80.000,00 Ar</li><li>Avances spéciales annuelles remboursables sur 3 mois - Renouvelable 3 fois: 120.000,00 Ar</li>\r\n</ul>', 100000, 129999, '#efd807', '2020-04-07', '0000-00-00', 'On'),
(15, 'Annuel', 'Commercial', 'Platinum', '<ul class=\"plat\"><li>13 ème mois sur moyenne de salaire net hors avantages sur 12 mois:100%</li><li>Panier garni :100.000,00 Ar</li><li>Avances spéciales annuelles remboursables sur 6 mois - Renouvelable 1 fois: 360.000,00 Ar</li>\r\n</ul>', 130000, 9999999, '#e5e4e2', '2020-04-07', '0000-00-00', 'On'),
(16, 'Bimestriels', 'Coach', 'Beginner', '<ul class=\"beg\" style=\"lyst-style-type:none\"><li> - Réduction de sanctions téléphoniques : <h6 class=\"text-right formating\">20%</h6> </li><li> - Réduction de sanctions sur absences : <h6 class=\"text-right formating\">20%</h6></li>\r\n</ul>                    ', 0, 6400, '#e91e63', '2020-04-16', '0000-00-00', 'On'),
(17, 'Annuel', 'Coach', 'Natural', 'Aucun privilève', 0, 130000, '#008000', '2020-04-27', '0000-00-00', 'On'),
(18, 'Bimestriels', 'Commercial', 'Advanced', '<ul class=\"intermediate\"><li>Réduction de s téléphoniques : 30%</li><li>Réduction de s sur absence : 10%</li><li>Réduction de Malus : 30% </li></ul>', 4000, 5999, '#FFA500', '2020-04-07', '0000-00-00', 'On');

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `privillege`
--
ALTER TABLE `privillege`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `privillege`
--
ALTER TABLE `privillege`
  MODIFY `Id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
