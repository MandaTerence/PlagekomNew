-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 21 mai 2021 à 13:57
-- Version du serveur :  10.3.27-MariaDB-0+deb10u1
-- Version de PHP : 7.3.27-1~deb10u1
use plagekom;


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
-- Structure de la table `Privilege_detail`
--

CREATE TABLE `Privilege_detail` (
  `Id` int(250) NOT NULL,
  `Designation` varchar(150) NOT NULL,
  `valeur` int(11) NOT NULL,
  `Id_privilege` int(250) NOT NULL,
  `Id_type_privilege` int(250) NOT NULL,
  `Statut` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `Privilege_detail`
--

INSERT INTO `Privilege_detail` (`Id`, `Designation`, `valeur`, `Id_privilege`, `Id_type_privilege`, `Statut`) VALUES
(1, 'Bonus mensuel', 10000, 9, 1, 'on'),
(8, 'Bonus sur journée travaillée *uniquement pour les commerciaux locaux', 600, 9, 7, 'on'),
(9, 'Participation sur les frais de connexion par jour en MGA', 600, 9, 2, 'on'),
(10, 'Supplément sur le panier de nourriture par jour en MGA ', 500, 9, 2, 'on'),
(11, 'Bonus mensuel', 20000, 10, 1, 'on'),
(12, 'Bonus par journée travaillée *uniquement pour les commerciaux locaux', 800, 10, 7, 'on'),
(13, 'Participation sur les frais de connexion par jour en MGA', 600, 10, 2, 'on'),
(14, 'Supplément sur le panier de nourriture par jour en MGA  ', 1000, 10, 2, 'on'),
(15, 'Bonus mensuel ', 30000, 11, 1, 'on'),
(16, 'Bonus par journée travaillée *uniquement pour les commerciaux locaux ', 1200, 11, 7, 'on'),
(17, 'Participation sur les frais de connexion par jour en MGA ', 600, 11, 2, 'on'),
(18, 'Supplément sur le panier de nourriture par jour en MGA ', 1200, 11, 2, 'on'),
(26, 'jour de repos supplémentaire après mission : 5 jours', 0, 11, 3, 'on'),
(27, 'Réduction de s téléphoniques : 75%', 0, 11, 3, 'on'),
(28, 'Réduction de s sur absence : 75%', 0, 11, 3, 'on'),
(29, 'Réduction de Malus : 100%', 0, 11, 3, 'on'),
(30, 'Réduction de frais de transport en cas d\'abandon sur mission (cas de force majeur): 60%', 0, 11, 3, 'on'),
(31, 'Remboursement sur les frais médicaux: 35%', 0, 11, 3, 'on'),
(32, 'priorité sur avances sur salaire à la hauteur de _ _ pourcent du salaire en cours: 60%', 0, 11, 3, 'on'),
(33, 'choix de 2 articles hors panier par jour', 0, 11, 3, 'on'),
(35, 'Priorité sur la remise des marchandises le soir', 0, 11, 3, 'on'),
(36, 'Priorité sur les marchandises en cas d\'insuffisance de produits', 0, 11, 3, 'on'),
(38, 'Jour de repos supplémentaire après mission: 2 jours', 0, 10, 3, 'on'),
(39, 'Réduction de S téléphoniques : 60%', 0, 10, 3, 'on'),
(40, 'Réduction de S sur absence: 40%', 0, 10, 3, 'on'),
(41, 'Réduction de Malus : 80%', 0, 10, 3, 'on'),
(42, 'Réduction de frais de transport en cas d\'abandon sur mission ( cas de force majeure) : 40%', 0, 10, 3, 'on'),
(45, 'Remboursement sur frais médicaux: 25%', 0, 10, 3, 'on'),
(46, 'Choix de 2 articles hors panier par jour', 0, 10, 3, 'on'),
(47, 'Priorité sur la distribution des marchandises le matin', 0, 11, 3, 'on'),
(48, 'Priorité sur la remise des marchandises le soir', 0, 10, 3, ''),
(49, 'Priorité sur les marchandises en cas d\'insuffisance de produits', 0, 10, 3, 'on'),
(50, 'Priorité sur avances sur salaire à hauteur de _ _ pourcent du salaire en cours: 0%', 0, 10, 3, 'on'),
(51, 'Jour de repos supplémentaire après mission* : 1 jours', 0, 9, 3, 'on'),
(52, 'Réduction de s téléphoniques : 50%', 0, 9, 3, 'on'),
(53, 'Réduction de s sur absence : 30%', 0, 9, 3, 'on'),
(54, 'Réduction de Malus : 50%', 0, 9, 3, 'on'),
(55, 'Déduction de frais de transport en cas d\'abandon sur mission (cas de force majeure) : 20%', 0, 9, 3, 'on'),
(58, 'Remboursement sur frais médicaux:20%', 0, 9, 3, 'on'),
(59, 'Choix d\'un article hors panier par jour', 0, 9, 3, 'on'),
(60, 'Priorité sur la distribution des marchandises le matin', 0, 9, 3, 'on'),
(61, 'Priorité sur la remise des marchandises le soir\r\n', 0, 9, 3, 'on'),
(62, 'Autorisé à percevoir un pourboire de 15%', 0, 9, 3, 'on'),
(63, 'Réduction de s téléphoniques : 30%\r\n', 0, 8, 3, 'on'),
(64, 'Réduction de s sur absence : 10%\r\n', 0, 8, 3, 'on'),
(65, 'Réduction de Malus : 30%', 0, 8, 3, 'on'),
(66, 'Réduction de s téléphoniques : 20%\r\n', 0, 7, 3, 'on'),
(67, 'Réduction de s sur absence : 0%\r\n', 0, 7, 3, 'on'),
(68, 'Réduction de Malus : 20%', 0, 7, 3, 'on'),
(69, '13 ème mois sur moyenne de salaire net hors avantages sur 12 mois:20%', 0, 13, 3, 'on'),
(70, 'Panier garnie ', 30000, 13, 1, 'on'),
(71, 'Avances spéciales annuelles remboursables sur 2 mois - Renouvelable 2 fois: 60,000.00 Ar', 0, 13, 3, 'on'),
(72, '13 ème mois sur moyenne de salaire net hors avantages sur 12 mois:50%', 0, 14, 3, 'on'),
(73, 'Panier garnie', 80000, 14, 1, 'on'),
(74, 'Avances spéciales annuelles remboursables sur 3 mois - Renouvelable 3 fois: 120.000,00 Ar', 0, 14, 3, 'on'),
(75, '13 ème mois sur moyenne de salaire net hors avantages sur 12 mois:100%', 0, 15, 3, 'on'),
(76, 'Panier garni ', 100000, 15, 1, 'on'),
(77, 'Avances spéciales annuelles remboursables sur 6 mois - Renouvelable 1 fois: 360.000,00 Ar', 0, 15, 3, 'on'),
(78, 'Bonus Mensuel', 0, 7, 1, 'on'),
(80, 'Participation sur les frais de connexion par jour', 0, 7, 2, 'on'),
(81, 'Participation sur les frais de deplacement par jour', 0, 7, 2, 'on'),
(82, 'Participation sur le panier de nourriture par jour', 0, 7, 2, 'on'),
(83, 'Bonus Mensuel', 0, 8, 1, 'on'),
(84, 'Participation sur les frais de connexion par jour', 0, 8, 2, 'on'),
(85, 'Participation sur les frais de deplacement par jour', 0, 8, 2, 'on'),
(86, 'Participation sur le panier de nourriture par jour', 0, 8, 2, 'on'),
(87, 'Bonus par journée travaillée *uniquement pour les commerciaux locaux ', 0, 7, 7, 'on'),
(88, 'Bonus par journée travaillée *uniquement pour les commerciaux locaux ', 0, 8, 4, 'on'),
(89, 'choix de 0 articles hors panier par jour', 0, 7, 3, 'on'),
(90, 'choix de 0 articles hors panier par jour', 0, 8, 3, 'on'),
(91, 'jour de repos supplémentaire après mission : 0 jours', 0, 7, 3, 'on'),
(92, 'jour de repos supplémentaire après mission : 0 jours', 0, 8, 3, 'on'),
(93, 'Priorité sur avances sur salaire à la hauteur de _ _ pourcent du salaire en cours \r\n0%', 0, 7, 3, 'on'),
(94, 'Priorité sur avances sur salaire à la hauteur de _ _ pourcent du salaire en cours \r\n0%', 0, 8, 3, 'on'),
(95, 'Priorité sur avances sur salaire à la hauteur de _ _ pourcent du salaire en cours \r\n0%', 0, 9, 3, 'on'),
(96, 'Priorité sur la distribution des marchandises le matin ( Non )', 0, 7, 3, 'on'),
(97, 'Priorité sur la distribution des marchandises le matin ( Non )', 0, 8, 3, 'on'),
(98, 'Priorité sur la distribution des marchandises le matin ', 0, 10, 3, 'on'),
(99, 'Priorité sur la remise des marchandises le soir', 0, 10, 3, 'on'),
(100, 'Priorité sur la remise des marchandises le soir ( Non )', 0, 7, 3, 'on'),
(101, 'Priorité sur la remise des marchandises le soir ( Non )', 0, 8, 3, 'on'),
(102, 'Priorité sur les marchandises en cas d\'insuffisance de produits ( Non )', 0, 9, 3, 'on'),
(103, 'Priorité sur les marchandises en cas d\'insuffisance de produits ( Non )', 0, 7, 3, 'on'),
(104, 'Priorité sur les marchandises en cas d\'insuffisance de produits ( Non )', 0, 8, 3, 'on'),
(105, 'Réduction de frais de transport en cas d\'abandon sur mission (cas de force majeur): 20%', 0, 9, 3, 'on'),
(106, 'Réduction de frais de transport en cas d\'abandon sur mission (cas de force majeur): 0%', 0, 8, 3, 'on'),
(107, 'Réduction de frais de transport en cas d\'abandon sur mission (cas de force majeur): 0%', 0, 7, 3, 'on'),
(108, 'Remboursement sur les frais médicaux: 0%', 0, 7, 3, 'on'),
(109, 'Remboursement sur les frais médicaux: 0%', 0, 8, 3, 'on'),
(110, 'Bonus mensuel', 5000, 18, 1, 'on'),
(111, 'Bonus par journée travaillée *uniquement pour les commerciaux locaux', 0, 18, 7, 'on'),
(112, 'Jour de repos supplémentaire après mission: 1 jour', 0, 18, 3, 'on'),
(113, 'Reduction de sanctions téléphoniques: 40%', 0, 18, 3, 'on'),
(114, 'Reduction de sanctions sur absence: 30%', 0, 18, 3, 'on'),
(115, 'Reduction de Malus: 40%', 0, 18, 3, 'on'),
(117, 'Reduction de frais de transport en cas  d\'abandon sur mission: 0%', 0, 18, 3, 'on'),
(118, 'Participation sur les frais de connexion par jour', 300, 18, 2, 'on'),
(119, 'Participation sur les frais de deplacement par jour', 0, 18, 2, 'on'),
(120, 'Participation sur le panier de nourriture par jour', 0, 18, 2, 'on'),
(121, 'Choix d\'article hors panier par jour: 0', 0, 18, 3, 'on'),
(122, 'Priorité sur la distribution des marchandises le matin ( Non )', 0, 18, 3, 'on'),
(123, 'Priorité sur la remise des marchandises le soir ( Non )', 0, 18, 3, 'on'),
(124, 'Priorité sur les marchandises en cas d\'insuffisance de produits ( Non )', 0, 18, 3, 'on'),
(125, 'Priorité sur avances sur salaire à hauteur de _ _ pourcent du salaire en cours: 0%', 0, 18, 3, 'on'),
(126, 'Participation sur les frais de deplacement par jour', 800, 11, 2, 'on'),
(127, 'Participation sur les frais de deplacement par jour', 600, 10, 2, 'on'),
(128, 'Participation sur les frais de deplacement par jour', 400, 9, 2, 'on'),
(129, 'Panier garni: 0,00 Ar', 0, 12, 1, 'on'),
(130, '13 ème mois sur moyenne de salaire net hors avantages sur 12 mois: 0%', 0, 12, 1, 'on'),
(131, 'Avances spéciales annuelles: 0,00Ar', 0, 12, 1, 'on');

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

-- --------------------------------------------------------

--
-- Structure de la table `privillege_non_afficher`
--

CREATE TABLE `privillege_non_afficher` (
  `Id` int(11) NOT NULL,
  `Id_privillege_detail` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `privillege_non_afficher`
--

INSERT INTO `privillege_non_afficher` (`Id`, `Id_privillege_detail`) VALUES
(1, 78),
(2, 80),
(3, 81),
(4, 82),
(5, 83),
(6, 84),
(10, 85),
(9, 86);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `Privilege_detail`
--
ALTER TABLE `Privilege_detail`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_privilege` (`Id_privilege`),
  ADD KEY `fk_type_privilege` (`Id_type_privilege`);

--
-- Index pour la table `privillege`
--
ALTER TABLE `privillege`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `privillege_non_afficher`
--
ALTER TABLE `privillege_non_afficher`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_privillege_detail` (`Id_privillege_detail`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `Privilege_detail`
--
ALTER TABLE `Privilege_detail`
  MODIFY `Id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=132;

--
-- AUTO_INCREMENT pour la table `privillege`
--
ALTER TABLE `privillege`
  MODIFY `Id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `Privilege_detail`
--
ALTER TABLE `Privilege_detail`
  ADD CONSTRAINT `Privilege_detail_ibfk_1` FOREIGN KEY (`Id_privilege`) REFERENCES `privillege` (`Id`),
  ADD CONSTRAINT `fk_type_privilege` FOREIGN KEY (`Id_type_privilege`) REFERENCES `type_privilege_detail` (`Id`);

--
-- Contraintes pour la table `privillege_non_afficher`
--
ALTER TABLE `privillege_non_afficher`
  ADD CONSTRAINT `privillege_non_afficher_ibfk_1` FOREIGN KEY (`Id_privillege_detail`) REFERENCES `Privilege_detail` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
