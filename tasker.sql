-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le : mer. 19 oct. 2022 à 17:54
-- Version du serveur : 10.4.24-MariaDB
-- Version de PHP : 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `tasker`
--

-- --------------------------------------------------------

--
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `categorie` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `categories`
--

INSERT INTO `categories` (`id`, `categorie`) VALUES
(29, 'Cuisiner'),
(30, 'Maison'),
(31, 'Programmation');

-- --------------------------------------------------------

--
-- Structure de la table `membres`
--

CREATE TABLE `membres` (
  `id` int(11) NOT NULL,
  `pseudo` varchar(20) NOT NULL,
  `mdp` varchar(100) NOT NULL,
  `role` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `membres`
--

INSERT INTO `membres` (`id`, `pseudo`, `mdp`, `role`) VALUES
(1, 'bon', '$2y$10$rXc7uw8aIQ57nxakqEEYEuDFJH4rebBqty.5LemVfDfNZp8nPSJ..', 0),
(2, 'tonpere', '$2y$10$oc5X64xVLdZmn0qScdiWU.7e/W/EPPvGDc5DUTYhD27PucflIepyS', 0),
(3, 'cedric123', '$2y$10$gPzgldUBNqdpML3bKVHv7uGeBjij4gpNGRTt2gZp.rAco8iJKBFp2', 0),
(4, 'cedric1234', '$2y$10$YQAKjIJSN2hnYb26PkCNQeMGcHFNuCP.XgJUiOYm0bLhGiZ08S2LO', 0),
(5, 'filsdeawole', '$2y$10$MKHZOoP2dQ4DDBuAcEsdOOeZZHCKUiKh/JCDV3CJMhnEnNq2VYdwK', 0),
(6, 'tamertamer', '$2y$10$JzemEKEM.LIBk4ir.p7H6eySV3nWHDJazBr8vI8TSMBRD3VwrvI5i', 0),
(7, 'tamertamer2', '$2y$10$TpP9iMz/lb8FGvyYrH7lUeWRxkBFK9y53D1cWiYMePh1bRKBwZezG', 0),
(8, 'moncaporal', '$2y$10$ATYWoNM/S0pVmZQuBsK12uBF30B1THZqW5jt2x2f.gCigBJ4IbQ9C', 0),
(9, 'moncaporal2', '$2y$10$Y9w3F7coTl21YvBiPVW48.YT436cUISlrHLLqsW1XRP2IcUWChIuu', 0),
(10, 'moncaporal3', '$2y$10$in1QUVlRUYcC/RBPOVfUr.t1JNimrpRFQeG69PNRax8tPqCJMSxIm', 0),
(11, 'popopopopo', '$2y$10$yCU5d4aNeti8nk73JzxyBOXjkltggPjH2C6zZuhP3TBDrolYj.ZKq', 0),
(12, 'popopopopo2', '$2y$10$qGECr7alfEvza7/AY.4VKOk5Y7XwYmBYMDwSl75hiZ5fRXG5x9bGu', 0),
(13, 'moncaporalmoncaporal', '$2y$10$Z47F.ju4ADzH014nUjgAteKkk4IbjefmWKOo2oZX1dskpGiqxSIaO', 0),
(14, 'moncaporal123', '$2y$10$eCW0bLnsWVdQ6zRGarR5KOD7y3h9jAWWR.IbJir2s.3ngX0b8ucky', 0);

-- --------------------------------------------------------

--
-- Structure de la table `taches`
--

CREATE TABLE `taches` (
  `id` int(11) NOT NULL,
  `id_categorie` int(11) NOT NULL,
  `nom_tache` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `rappel` timestamp NULL DEFAULT NULL,
  `importance` tinyint(4) NOT NULL,
  `complete` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Déchargement des données de la table `taches`
--

INSERT INTO `taches` (`id`, `id_categorie`, `nom_tache`, `description`, `date`, `rappel`, `importance`, `complete`) VALUES
(22, 31, 'Recoder le football 2', 'J\'aime pas le foot ni  codé !', '2022-10-12 11:36:39', '2022-10-26 22:00:00', 2, 1),
(23, 31, 'Coder le football 2', 'J\'aime pas le foot mais faut que je me force hein !', '2022-10-12 11:44:20', '2022-10-25 22:00:00', 1, 1),
(24, 29, 'Silence mon ami', '', '2022-10-09 22:00:00', '2022-10-01 22:00:00', 3, 0),
(25, 30, 'BATIR', '', '2022-10-12 11:31:51', '2022-10-02 22:00:00', 0, 0),
(26, 30, 'CONSTRUIRE', '', '2022-10-10 07:57:44', '2022-09-30 22:00:00', 0, 0),
(27, 30, 'CONSTRUIRE 2', '', '2022-10-09 09:20:20', '2022-10-18 22:00:00', 1, 1),
(28, 30, 'DST2', '', '2022-10-09 22:00:00', '2022-10-02 22:00:00', 1, 0),
(30, 31, 'promener la mascotte', '', '2022-10-09 09:20:16', '2022-10-08 22:00:00', 0, 1),
(31, 31, 'Programmer un site', 'Il faut absolument programmer le site.', '2022-10-11 14:41:31', '2022-10-24 22:00:00', 0, 1);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `membres`
--
ALTER TABLE `membres`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `taches`
--
ALTER TABLE `taches`
  ADD PRIMARY KEY (`id`),
  ADD KEY `taches` (`id_categorie`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- AUTO_INCREMENT pour la table `membres`
--
ALTER TABLE `membres`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT pour la table `taches`
--
ALTER TABLE `taches`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `taches`
--
ALTER TABLE `taches`
  ADD CONSTRAINT `taches` FOREIGN KEY (`id_categorie`) REFERENCES `categories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
