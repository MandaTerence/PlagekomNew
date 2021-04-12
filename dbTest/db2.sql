-- phpMyAdmin SQL Dump
-- version 5.0.3
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost:3306
-- Généré le : lun. 08 mars 2021 à 11:23
-- Version du serveur :  10.2.32-MariaDB-cll-lve
-- Version de PHP : 7.3.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `database_exploitation`
--

-- --------------------------------------------------------

--
-- Structure de la table `equipe_coach`
--

CREATE TABLE `equipe_coach` (
  `Id` int(11) NOT NULL,
  `Coach` varchar(20) NOT NULL,
  `Commercial` varchar(20) NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `equipe_coach`
--

INSERT INTO `equipe_coach` (`Id`, `Coach`, `Commercial`, `Date`) VALUES
(1, 'COTN102', 'VP21110', '2021-03-01'),
(2, 'COTN102', 'VP21106', '2021-03-01'),
(3, 'COTN102', 'VP21112', '2021-03-01'),
(4, 'COTN102', 'VP21104', '2021-03-01'),
(5, 'COTN111', 'VP21109', '2021-03-01'),
(6, 'COTN111', 'VP21107', '2021-03-01'),
(7, 'COTN111', 'VP21102', '2021-03-01'),
(8, 'COTN131', 'VP21111', '2021-03-01'),
(9, 'COTN131', 'VP21113', '2021-03-01'),
(10, 'COTN131', 'VP21114', '2021-03-01');

-- --------------------------------------------------------

--
-- Structure de la table `mesaccompanement`
--

CREATE TABLE `mesaccompanement` (
  `Id` int(50) NOT NULL,
  `Id_de_la_mission` varchar(60) NOT NULL,
  `Commercial` varchar(10) NOT NULL,
  `Coach` varchar(10) NOT NULL,
  `Date` date NOT NULL,
  `Heure_debut` time NOT NULL,
  `Heure_fin` time DEFAULT NULL,
  `Ordre` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `mesaccompanement`
--

INSERT INTO `mesaccompanement` (`Id`, `Id_de_la_mission`, `Commercial`, `Coach`, `Date`, `Heure_debut`, `Heure_fin`, `Ordre`) VALUES
(1, 'TEST_2020_03_27', 'VP00080', 'COTNTEST', '2020-05-28', '11:32:37', '13:32:37', 2),
(2, 'TEST_2020_03_27', 'AP19637', 'COTNTEST', '2020-05-05', '08:11:20', '09:00:00', 1),
(3, 'TEST_2020_03_27', 'VP00630', 'COTNTEST', '2020-05-06', '08:36:06', '10:00:00', 1),
(4, 'TEST_2020_03_27', 'AP19638', 'COTNTEST', '2020-05-06', '13:00:00', '16:00:00', 2),
(5, 'TEST_2020_03_27', 'VP00080', 'COTNTEST', '2020-06-10', '11:32:37', '19:00:00', 1),
(6, 'TEST_2020_03_27', 'VPTEST', 'COTNTEST', '2020-06-13', '08:00:00', '10:00:00', 1),
(7, 'TEST_2020_03_27', 'VPDG', 'COTNTEST', '2020-06-13', '10:00:00', '12:00:00', 2),
(8, 'LOCAL_2020_17_06', 'VPDG', 'COTNX', '2020-06-17', '08:00:00', '10:00:00', 1),
(9, 'LOCAL_2020_17_06', 'VPTEST', 'COTNX', '2020-06-17', '14:00:00', '16:00:00', 2),
(10, 'LOCAL_2020_17_06', 'VPOTO189', 'COTNX', '2020-06-17', '14:00:00', '16:00:00', 3),
(11, 'LOCAL_2020_17_06', 'VPDG', 'COTNX', '2020-07-22', '11:31:27', '16:31:27', 2),
(12, 'LOCAL_2020_17_06', 'VPOTO189', 'COTNX', '2020-07-22', '08:31:27', '12:31:27', 1),
(17, 'ROAD_SHOW_2020_08_03', 'VP11725', 'COTNX', '2020-08-03', '10:00:00', '00:00:00', 2),
(18, 'ROAD_SHOW_2020_08_03', 'COTNX', 'COTNX', '2020-08-03', '08:00:00', '09:00:00', 1),
(19, 'ROAD_SHOW_2020_08_05', 'VP12683', 'COTN005', '2020-08-05', '06:00:00', '07:30:00', 1),
(20, 'ROAD_SHOW_2020_08_05', 'VP20109', 'COTN005', '2020-08-05', '07:30:00', '09:00:00', 2),
(21, 'ROAD_SHOW_2020_08_05', 'VP20113', 'COTN005', '2020-08-05', '09:00:00', '10:30:00', 3),
(22, 'ROAD_SHOW_2020_08_05', 'VP20099', 'COTN005', '2020-08-05', '10:30:00', '12:00:00', 4),
(23, 'ROAD_SHOW_2020_08_05', 'VP12087', 'COTN103', '2020-08-05', '06:00:00', '07:30:00', 1),
(24, 'ROAD_SHOW_2020_08_05', 'VP19736', 'COTN103', '2020-08-05', '07:30:00', '09:00:00', 2),
(25, 'ROAD_SHOW_2020_08_05', 'VP20098', 'COTN103', '2020-08-05', '09:00:00', '10:30:00', 3),
(26, 'ROAD_SHOW_2020_08_05', 'VP20111', 'COTN103', '2020-08-05', '10:30:00', '12:00:00', 4),
(27, 'ROAD_SHOW_2020_08_07', 'VP20111', 'COTN103', '2020-08-07', '06:00:00', '07:30:00', 1),
(28, 'ROAD_SHOW_2020_08_07', 'VP20099', 'COTN103', '2020-08-07', '07:30:00', '09:00:00', 2),
(29, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-08-10', '08:00:00', '10:00:00', 1),
(30, 'MISSION_SAMBAVA_2020', 'VP19135', 'COTN01', '2020-08-10', '10:00:00', '00:00:00', 2),
(31, 'MISSION_SAMBAVA_2020', 'VP20034', 'COTN01', '2020-08-11', '07:00:00', '09:00:00', 1),
(32, 'MISSION_SAMBAVA_2020', 'VP20010', 'COTN01', '2020-08-11', '09:00:00', '12:00:00', 2),
(33, 'MISSION_SAMBAVA_2020', 'VP19119', 'COTN01', '2020-08-12', '07:00:00', '10:00:00', 1),
(34, 'MISSION_SAMBAVA_2020', 'VP19170', 'COTN01', '2020-08-12', '10:00:00', '12:00:00', 2),
(35, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-08-13', '07:00:00', '09:00:00', 1),
(36, 'MISSION_SAMBAVA_2020', 'VP19135', 'COTN01', '2020-08-13', '10:00:00', '00:00:00', 2),
(37, 'MISSION_SAMBAVA_2020', 'VP20010', 'COTN01', '2020-08-14', '07:00:00', '09:00:00', 1),
(38, 'MISSION_SAMBAVA_2020', 'VP20034', 'COTN01', '2020-08-14', '09:00:00', '00:00:00', 2),
(39, 'ROAD_SHOW_2020_08_14', 'VP20001', 'COTN107', '2020-08-14', '07:00:00', '10:00:00', 1),
(40, 'ROAD_SHOW_2020_08_14', 'VP19736', 'COTN107', '2020-08-14', '10:00:00', '00:00:00', 2),
(41, 'ROAD_SHOW_2020_08_14', 'VP20096', 'COTN107', '2020-08-14', '00:00:00', '15:00:00', 3),
(42, 'MISSION_SAMBAVA_2020', 'VP19119', 'COTN01', '2020-08-17', '07:00:00', '09:00:00', 1),
(43, 'MISSION_SAMBAVA_2020', 'VP19170', 'COTN01', '2020-08-17', '09:00:00', '00:00:00', 2),
(44, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-08-17', '07:00:00', '09:00:00', 1),
(45, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-08-17', '10:00:00', '12:00:00', 2),
(46, 'MISSION_SAMBAVA_2020', 'VP20010', 'COTN01', '2020-08-18', '07:00:00', '09:00:00', 1),
(47, 'MISSION_SAMBAVA_2020', 'VP20034', 'COTN01', '2020-08-18', '09:00:00', '00:00:00', 2),
(48, 'MISSION_SAMBAVA_2020', 'VP19119', 'COTN01', '2020-08-19', '07:00:00', '09:00:00', 1),
(49, 'MISSION_SAMBAVA_2020', 'VP19170', 'COTN01', '2020-08-19', '09:00:00', '11:00:00', 2),
(50, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-08-20', '07:00:00', '09:00:00', 1),
(51, 'MISSION_SAMBAVA_2020', 'VP19135', 'COTN01', '2020-08-20', '10:00:00', '00:00:00', 2),
(52, 'MISSION_SAMBAVA_2020', 'VP20010', 'COTN01', '2020-08-21', '07:00:00', '09:00:00', 1),
(53, 'MISSION_SAMBAVA_2020', 'VP20034', 'COTN01', '2020-08-21', '09:00:00', '00:00:00', 2),
(54, 'MISSION_SAMBAVA_2020', 'VP19119', 'COTN01', '2020-08-22', '07:00:00', '09:00:00', 1),
(55, 'MISSION_SAMBAVA_2020', 'VP19170', 'COTN01', '2020-08-22', '09:00:00', '00:00:00', 2),
(56, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-08-24', '07:00:00', '09:00:00', 1),
(57, 'MISSION_SAMBAVA_2020', 'VP19135', 'COTN01', '2020-08-24', '09:00:00', '00:00:00', 2),
(58, 'MISSION_SAMBAVA_2020', 'VP20010', 'COTN01', '2020-08-25', '07:00:00', '09:00:00', 1),
(59, 'MISSION_SAMBAVA_2020', 'VP20034', 'COTN01', '2020-08-25', '09:00:00', '12:00:00', 2),
(60, 'MISSION_SAMBAVA_2020', 'VP19119', 'COTN01', '2020-08-26', '07:00:00', '09:00:00', 1),
(61, 'MISSION_SAMBAVA_2020', 'VP19170', 'COTN01', '2020-08-26', '09:00:00', '12:00:00', 2),
(62, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-08-27', '07:00:00', '09:00:00', 1),
(63, 'MISSION_SAMBAVA_2020', 'VP19135', 'COTN01', '2020-08-27', '09:00:00', '12:00:00', 2),
(64, 'MISSION_SAMBAVA_2020', 'VP20010', 'COTN01', '2020-08-28', '07:00:00', '09:00:00', 1),
(65, 'MISSION_SAMBAVA_2020', 'VP20034', 'COTN01', '2020-08-28', '09:00:00', '12:00:00', 2),
(66, 'MISSION_SAMBAVA_2020', 'VP19119', 'COTN01', '2020-08-29', '07:00:00', '09:00:00', 1),
(67, 'MISSION_SAMBAVA_2020', 'VP19170', 'COTN01', '2020-08-29', '09:00:00', '00:00:00', 2),
(68, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-08-31', '07:00:00', '09:00:00', 1),
(69, 'MISSION_SAMBAVA_2020', 'VP19135', 'COTN01', '2020-08-31', '09:00:00', '08:00:00', 0),
(70, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-09-01', '07:00:00', '09:00:00', 1),
(71, 'MISSION_SAMBAVA_2020', 'VP19135', 'COTN01', '2020-09-01', '09:00:00', '12:00:00', 2),
(72, 'MISSION_SAMBAVA_2020', 'VP19119', 'COTN01', '2020-09-02', '07:00:00', '09:00:00', 1),
(73, 'MISSION_SAMBAVA_2020', 'VP19170', 'COTN01', '2020-09-02', '09:00:00', '12:00:00', 2),
(74, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-09-03', '07:00:00', '09:00:00', 1),
(75, 'MISSION_SAMBAVA_2020', 'VP19135', 'COTN01', '2020-09-03', '09:00:00', '12:00:00', 2),
(76, 'MISSION_SAMBAVA_2020', 'VP20010', 'COTN01', '2020-09-04', '07:00:00', '09:00:00', 1),
(77, 'MISSION_SAMBAVA_2020', 'VP20034', 'COTN01', '2020-09-04', '09:00:00', '12:00:00', 2),
(78, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-09-07', '07:00:00', '09:00:00', 1),
(79, 'MISSION_SAMBAVA_2020', 'VP19135', 'COTN01', '2020-09-07', '09:00:00', '12:00:00', 2),
(80, 'MISSION_SAMBAVA_2020', 'VP20010', 'COTN01', '2020-09-08', '09:00:00', '12:00:00', 2),
(81, 'MISSION_SAMBAVA_2020', 'VP20034', 'COTN01', '2020-09-08', '07:00:00', '09:00:00', 1),
(82, 'MISSION_SAMBAVA_2020', 'VP19119', 'COTN01', '2020-09-09', '07:00:00', '08:00:00', 1),
(83, 'MISSION_SAMBAVA_2020', 'VP19170', 'COTN01', '2020-09-09', '09:00:00', '12:00:00', 2),
(84, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-09-10', '07:00:00', '09:00:00', 1),
(85, 'MISSION_SAMBAVA_2020', 'VP19135', 'COTN01', '2020-09-10', '09:00:00', '12:00:00', 2),
(86, 'MISSION_SAMBAVA_2020', 'VP20010', 'COTN01', '2020-09-11', '07:00:00', '09:00:00', 1),
(87, 'MISSION_SAMBAVA_2020', 'VP20034', 'COTN01', '2020-09-11', '09:00:00', '12:00:00', 2),
(88, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-09-14', '07:00:00', '09:00:00', 1),
(89, 'MISSION_SAMBAVA_2020', 'VP19135', 'COTN01', '2020-09-14', '09:00:00', '12:00:00', 2),
(90, 'MISSION_SAMBAVA_2020', 'VP20010', 'COTN01', '2020-09-15', '07:00:00', '09:00:00', 1),
(91, 'MISSION_SAMBAVA_2020', 'VP19119', 'COTN01', '2020-09-16', '07:00:00', '09:00:00', 1),
(92, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-09-17', '07:00:00', '09:00:00', 1),
(93, 'MISSION_SAMBAVA_2020', 'VP19135', 'COTN01', '2020-09-17', '09:00:00', '12:00:00', 2),
(94, 'MISSION_SAMBAVA_2020', 'VP19119', 'COTN01', '2020-09-19', '07:00:00', '09:00:00', 1),
(95, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-09-21', '07:00:00', '09:00:00', 1),
(96, 'MISSION_SAMBAVA_2020', 'VP19135', 'COTN01', '2020-09-21', '09:00:00', '12:00:00', 2),
(97, 'MISSION_SAMBAVA_2020', 'VP20010', 'COTN01', '2020-09-22', '07:00:00', '09:00:00', 1),
(98, 'MISSION_SAMBAVA_2020', 'VP19119', 'COTN01', '2020-09-23', '07:00:00', '09:00:00', 1),
(99, 'MISSION_SAMBAVA_2020', 'VP20011', 'COTN01', '2020-09-24', '07:00:00', '09:00:00', 1),
(100, 'MISSION_SAMBAVA_2020', 'VP19135', 'COTN01', '2020-09-24', '09:00:00', '12:00:00', 2),
(101, 'MISSION_SAMBAVA_2020', 'VP20010', 'COTN01', '2020-09-25', '07:00:00', '09:00:00', 1),
(102, 'MISSION_SAMBAVA_2020', 'VP19119', 'COTN01', '2020-09-26', '07:00:00', '09:00:00', 1),
(103, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP20075', 'COTN102', '2020-09-21', '07:00:00', '09:00:00', 1),
(104, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP20099', 'COTN102', '2020-09-21', '09:00:00', '12:00:00', 2),
(105, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP19534', 'COTN102', '2020-09-22', '07:00:00', '09:00:00', 1),
(106, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP19042', 'COTN102', '2020-09-22', '09:00:00', '12:00:00', 2),
(107, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VT00556', 'COTN102', '2020-09-23', '07:00:00', '09:00:00', 1),
(108, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP00902', 'COTN102', '2020-09-23', '09:00:00', '12:00:00', 2),
(109, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP12683', 'COTN102', '2020-09-24', '07:00:00', '09:00:00', 1),
(110, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VT00005', 'COTN102', '2020-09-24', '09:00:00', '12:00:00', 2),
(111, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP20075', 'COTN102', '2020-09-25', '07:00:00', '09:00:00', 1),
(112, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP20099', 'COTN102', '2020-09-25', '09:00:00', '12:00:00', 2),
(113, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP19534', 'COTN102', '2020-09-26', '07:00:00', '09:00:00', 1),
(114, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP19042', 'COTN102', '2020-09-26', '09:00:00', '12:00:00', 2),
(115, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VT00556', 'COTN102', '2020-09-28', '07:00:00', '09:00:00', 1),
(116, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP00902', 'COTN102', '2020-09-28', '09:00:00', '12:00:00', 2),
(117, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP12683', 'COTN102', '2020-09-29', '07:00:00', '09:00:00', 1),
(118, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VT00005', 'COTN102', '2020-09-29', '09:00:00', '12:00:00', 2),
(119, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP20075', 'COTN102', '2020-09-30', '01:00:00', '09:00:00', 1),
(120, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP20099', 'COTN102', '2020-09-30', '09:00:00', '12:00:00', 2),
(121, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP19534', 'COTN102', '2020-10-01', '07:00:00', '09:00:00', 1),
(122, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP19042', 'COTN102', '2020-10-01', '09:00:00', '12:00:00', 2),
(123, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VT00556', 'COTN102', '2020-10-03', '07:00:00', '09:00:00', 1),
(124, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP00902', 'COTN102', '2020-10-03', '09:00:00', '12:00:00', 2),
(131, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VT00005', 'COTN102', '2020-10-05', '07:00:00', '09:00:00', 1),
(132, 'MISSION_ MANANARA_FENOARIVO_EST_19_09_2020', 'VP12683', 'COTN102', '2020-10-05', '09:00:00', '12:00:00', 2),
(133, 'MISSION_SAMBAVA_2020', 'VP20010', 'COTN01', '2020-10-06', '07:00:00', '09:00:00', 1),
(134, 'MISSION_SAMBAVA_2020', 'VP19119', 'COTN01', '2020-10-07', '07:00:00', '10:00:00', 1),
(135, 'MISSION_DIEGO_25_10_2020', 'VP20129', 'COTN01', '2020-10-26', '09:00:00', '12:00:00', 1),
(136, 'MISSION_DIEGO_25_10_2020', 'VP20127', 'COTN01', '2020-10-26', '12:00:00', '16:00:00', 2),
(137, 'MISSION_DIEGO_25_10_2020', 'VP20152', 'COTN01', '2020-10-28', '07:00:00', '10:00:00', 0),
(138, 'MISSION_DIEGO_25_10_2020', 'VP20156', 'COTN01', '2020-10-28', '12:00:00', '16:00:00', 0),
(139, 'MISSION_DIEGO_25_10_2020', 'VP20129', 'COTN01', '2020-10-29', '07:00:00', '12:00:00', 1),
(140, 'MISSION_DIEGO_25_10_2020', 'VP20127', 'COTN01', '2020-10-29', '13:00:00', '16:00:00', 2),
(141, 'MISSION_DIEGO_25_10_2020', 'VP20156', 'COTN01', '2020-10-30', '07:00:00', '12:00:00', 1),
(142, 'MISSION_DIEGO_25_10_2020', 'VP20139', 'COTN01', '2020-10-30', '13:00:00', '17:00:00', 2),
(143, 'MISSION_DIEGO_25_10_2020', 'VP20156', 'COTN01', '2020-10-31', '07:00:00', '12:00:00', 1),
(144, 'MISSION_DIEGO_25_10_2020', 'VP20152', 'COTN01', '2020-10-31', '12:00:00', '17:00:00', 2),
(145, 'MISSION_DIEGO_25_10_2020', 'VP20156', 'COTN01', '2020-11-02', '07:00:00', '12:00:00', 1),
(146, 'MISSION_DIEGO_25_10_2020', 'VP20139', 'COTN01', '2020-11-02', '12:00:00', '16:00:00', 2),
(147, 'MISSION_DIEGO_25_10_2020', 'VP20156', 'COTN01', '2020-11-03', '07:00:00', '12:00:00', 1),
(148, 'MISSION_DIEGO_25_10_2020', 'VP20152', 'COTN01', '2020-11-03', '13:00:00', '16:00:00', 1),
(149, 'MISSION_DIEGO_25_10_2020', 'VP20139', 'COTN01', '2020-11-05', '07:00:00', '11:00:00', 1),
(150, 'MISSION_DIEGO_25_10_2020', 'VP20135', 'COTN01', '2020-11-05', '13:00:00', '16:00:00', 2),
(151, 'MISSION_DIEGO_25_10_2020', 'VP20135', 'COTN01', '2020-11-09', '08:00:00', '12:00:00', 1),
(152, 'MISSION_DIEGO_25_10_2020', 'VP20156', 'COTN01', '2020-11-09', '13:00:00', '10:00:00', 2),
(153, 'MISSION_DIEGO_25_10_2020', 'VP20151', 'COTN01', '2020-11-11', '08:00:00', '12:00:00', 1),
(154, 'MISSION_DIEGO_25_10_2020', 'VP20127', 'COTN01', '2020-11-11', '13:00:00', '16:00:00', 2),
(157, 'MISSION_DIEGO_25_10_2020', 'VP20135', 'COTN01', '2020-11-12', '08:00:00', '12:00:00', 1),
(158, 'MISSION_DIEGO_25_10_2020', 'VP20139', 'COTN103', '2020-11-12', '12:00:00', '16:00:00', 2),
(159, 'MISSION_DIEGO_25_10_2020', 'VP20156', 'COTN01', '2020-11-13', '08:00:00', '12:00:00', 1),
(160, 'MISSION_DIEGO_25_10_2020', 'VP20135', 'COTN01', '2020-11-13', '13:00:00', '16:00:00', 2),
(161, 'MISSION_DIEGO_25_10_2020', 'COTN01', 'COTN01', '2020-11-17', '08:00:00', '12:00:00', 1),
(162, 'MISSION_DIEGO_25_10_2020', 'VP20139', 'COTN01', '2020-11-17', '08:00:00', '12:00:00', 1),
(163, 'MISSION_DIEGO_25_10_2020', 'VP20156', 'COTN01', '2020-11-17', '14:00:00', '16:00:00', 2),
(164, 'MISSION_DIEGO_25_10_2020', 'VP20135', 'COTN01', '2020-11-18', '12:00:00', '16:00:00', 1),
(165, 'MISSION_DIEGO_25_10_2020', 'VP20156', 'COTN01', '2020-11-18', '12:00:00', '16:00:00', 1),
(167, 'MISSION_DIEGO_25_10_2020', 'COTN01', 'COTN01', '2020-11-19', '08:00:00', '12:00:00', 0),
(168, 'MISSION_DIEGO_25_10_2020', 'COTN01', 'COTN01', '2020-11-19', '14:00:00', '16:00:00', 0),
(169, 'MISSION_DIEGO_25_10_2020', 'VP20129', 'COTN01', '2020-11-19', '08:00:00', '12:00:00', 1),
(170, 'MISSION_DIEGO_25_10_2020', 'VP20152', 'COTN01', '2020-11-19', '14:00:00', '16:00:00', 1),
(171, 'MISSION_DIEGO_25_10_2020', 'VP20135', 'COTN01', '2020-11-21', '08:00:00', '12:00:00', 1),
(172, 'MISSION_DIEGO_25_10_2020', 'VP20135', 'COTN01', '2020-11-21', '14:00:00', '16:00:00', 2),
(173, 'MISSION_VATOMANDRY_2020_11_28', 'VP20156', 'COTN01', '2020-12-01', '08:00:00', '16:00:00', 1),
(174, 'MISSION_VATOMANDRY_2020_11_28', 'VP20163', 'COTN01', '2020-12-01', '08:00:00', '16:00:00', 2),
(175, 'MISSION_VATOMANDRY_2020_11_28', 'VP20096', 'COTN01', '2020-12-02', '09:00:00', '12:00:00', 1),
(176, 'MISSION_VATOMANDRY_2020_11_28', 'VP20096', 'COTN01', '2020-12-03', '09:00:00', '12:00:00', 1),
(177, 'MISSION_VATOMANDRY_2020_11_28', 'VP2013', 'COTN01', '2020-12-03', '14:00:00', '16:00:00', 2),
(178, 'MISSION_VATOMANDRY_2020_11_28', 'VP20211', 'COTN01', '2020-12-04', '09:00:00', '12:00:00', 1),
(179, 'MISSION_VATOMANDRY_2020_11_28', 'VP20096', 'COTN01', '2020-12-04', '14:00:00', '16:00:00', 2),
(180, 'MISSION_VATOMANDRY_2020_11_28', 'VP20210', 'COTN01', '2020-12-07', '08:00:00', '12:00:00', 1),
(181, 'MISSION_VATOMANDRY_2020_11_28', 'VP20209', 'COTN01', '2020-12-07', '14:00:00', '16:00:00', 2),
(182, 'MISSION_VATOMANDRY_2020_11_28', 'VP20135', 'COTN01', '2020-12-08', '07:02:00', '08:02:00', 1),
(183, 'MISSION_VATOMANDRY_2020_11_28', 'VP20096', 'COTN01', '2020-12-08', '17:03:00', '17:03:00', 2),
(184, 'MISSION_VATOMANDRY_2020_11_28', 'VP20156', 'COTN01', '2020-12-10', '08:00:00', '10:00:00', 1),
(185, 'MISSION_VATOMANDRY_2020_11_28', 'VP20163', 'COTN01', '2020-12-10', '14:00:00', '16:00:00', 2),
(186, 'MISSION_VATOMANDRY_2020_11_28', 'VP20209', 'COTN01', '2020-12-11', '08:00:00', '10:00:00', 1),
(187, 'MISSION_VATOMANDRY_2020_11_28', 'VP20210', 'COTN01', '2020-12-11', '14:00:00', '16:00:00', 2),
(188, 'MISSION_VATOMANDRY_2020_11_28', 'VP20211', 'COTN01', '2020-12-14', '08:00:00', '10:00:00', 1),
(189, 'MISSION_VATOMANDRY_2020_11_28', 'VP20129', 'COTN01', '2020-12-14', '14:00:00', '16:00:00', 2),
(190, 'Miarinarivo', 'VP20180', 'COTN01', '2020-12-26', '08:00:00', '10:00:00', 1),
(191, 'Miarinarivo', 'VP20186', 'COTN01', '2020-12-26', '14:00:00', '16:00:00', 2),
(192, 'Miarinarivo', 'VP20172', 'COTN102', '2020-12-28', '08:00:00', '10:00:00', 1),
(193, 'Miarinarivo', 'VP20180', 'COTN01', '2020-12-28', '14:00:00', '16:17:00', 2),
(194, 'Miarinarivo', 'VP20180', 'COTN01', '2020-12-29', '12:58:00', '14:58:00', 1),
(195, 'Miarinarivo', 'VP20186', 'COTN01', '2020-12-29', '14:00:00', '16:00:00', 2),
(196, 'Miarinarivo', 'VP20177', 'COTN01', '2020-12-30', '08:00:00', '10:00:00', 1),
(197, 'Miarinarivo', 'VP20174', 'COTN01', '2020-12-30', '14:00:00', '16:00:00', 2),
(198, 'MANAKARA', 'VP20242', 'COTN121', '2021-01-05', '14:00:00', '16:00:00', 2),
(199, 'MANAKARA', 'VP20254', 'COTN121', '2021-01-05', '08:00:00', '10:00:00', 1),
(200, 'MANAKARA', 'VP20239', 'COTN126', '2021-01-05', '08:00:00', '10:00:00', 1),
(201, 'MANAKARA', 'VP20190', 'COTN126', '2021-01-05', '14:00:00', '16:00:00', 2),
(202, 'MAHAJANGA', 'VP20127', 'COTN125', '2021-01-06', '08:00:00', '10:00:00', 1),
(203, 'MAHAJANGA', 'VP20096', 'COTN125', '2021-01-06', '14:00:00', '16:00:00', 2),
(204, 'MAHAJANGA', 'VP20165', 'COTN113', '2021-01-06', '08:00:00', '10:00:00', 2),
(205, 'MAHAJANGA', 'VP20174', 'COTN113', '2021-01-06', '14:00:00', '16:00:00', 1),
(206, 'DIEGO_26_01_2021', 'VP21023', 'COTN113', '2021-01-26', '08:00:00', '10:00:00', 1),
(207, 'DIEGO_26_01_2021', 'VP20127', 'COTN113', '2021-01-26', '14:00:00', '16:00:00', 2),
(208, 'DIEGO_26_01_2021', 'VP21015', 'COTN125', '2021-01-26', '08:00:00', '10:00:00', 1),
(209, 'DIEGO_26_01_2021', 'VP21022', 'COTN125', '2021-01-26', '14:00:00', '16:00:00', 2),
(210, 'TOLIARA', 'VP21008', 'COTN121', '2021-02-02', '08:00:00', '10:00:00', 1),
(211, 'TOLIARA', 'VP21041', 'COTN121', '2021-02-02', '14:00:00', '16:00:00', 2),
(212, 'TOLIARA', 'VP21037', 'COTN126', '2021-02-02', '08:00:00', '10:00:00', 1),
(213, 'TOLIARA', 'VP20206', 'COTN126', '2021-02-02', '14:00:00', '16:00:00', 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `equipe_coach`
--
ALTER TABLE `equipe_coach`
  ADD PRIMARY KEY (`Id`);

--
-- Index pour la table `mesaccompanement`
--
ALTER TABLE `mesaccompanement`
  ADD PRIMARY KEY (`Id`),
  ADD KEY `Commrecial` (`Commercial`),
  ADD KEY `Coach` (`Coach`),
  ADD KEY `Id_de_la_mission` (`Id_de_la_mission`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `equipe_coach`
--
ALTER TABLE `equipe_coach`
  MODIFY `Id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT pour la table `mesaccompanement`
--
ALTER TABLE `mesaccompanement`
  MODIFY `Id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=214;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
