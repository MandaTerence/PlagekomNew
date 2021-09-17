-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 26 mai 2021 à 14:37
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
-- Structure de la table `malus`
--

CREATE TABLE `malus` (
  `Id` int(250) NOT NULL,
  `Designation` varchar(20) NOT NULL,
  `Id_zone` int(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `malus`
--

INSERT INTO `malus` (`Id`, `Designation`, `Id_zone`) VALUES
(1, 'Malus mission', 1),
(2, 'Malus local', 5),
(3, 'Malus sava', 2);

-- --------------------------------------------------------

--
-- Structure de la table `malus_absence`
--

CREATE TABLE `malus_absence` (
  `Id` int(250) NOT NULL,
  `Designation` varchar(50) NOT NULL,
  `Valeur` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `malus_absence`
--

INSERT INTO `malus_absence` (`Id`, `Designation`, `Valeur`) VALUES
(1, 'Aucune mission', 0),
(2, 'LOCAL', 5000),
(3, 'MISSION', 10000),
(4, 'MISSION SAVA', 10000),
(5, 'MISSION NOSY BE', 10000);

-- --------------------------------------------------------

--
-- Structure de la table `malus_detail`
--

CREATE TABLE `malus_detail` (
  `Id` int(250) NOT NULL,
  `Id_malus` int(250) NOT NULL,
  `montant_vente` int(15) NOT NULL,
  `valeur_malus` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `malus_detail`
--

INSERT INTO `malus_detail` (`Id`, `Id_malus`, `montant_vente`, `valeur_malus`) VALUES
(3, 2, 20000, 1000),
(4, 1, 36000, 10000),
(5, 1, 45000, 5000),
(6, 1, 55000, 2500),
(7, 3, 80000, 10000),
(8, 3, 90000, 5000),
(9, 3, 110000, 2500);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `malus`
--
ALTER TABLE `malus`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_zone` (`Id_zone`);

--
-- Index pour la table `malus_absence`
--
ALTER TABLE `malus_absence`
  ADD PRIMARY KEY (`Id`),
  ADD UNIQUE KEY `constraint_unique_designation` (`Designation`);

--
-- Index pour la table `malus_detail`
--
ALTER TABLE `malus_detail`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Id_malus` (`Id_malus`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `malus`
--
ALTER TABLE `malus`
  MODIFY `Id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `malus_absence`
--
ALTER TABLE `malus_absence`
  MODIFY `Id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT pour la table `malus_detail`
--
ALTER TABLE `malus_detail`
  MODIFY `Id` int(250) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `malus`
--
ALTER TABLE `malus`
  ADD CONSTRAINT `malus_ibfk_1` FOREIGN KEY (`Id_zone`) REFERENCES `zone` (`Id`);

--
-- Contraintes pour la table `malus_detail`
--
ALTER TABLE `malus_detail`
  ADD CONSTRAINT `malus_detail_ibfk_1` FOREIGN KEY (`Id_malus`) REFERENCES `malus` (`Id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
