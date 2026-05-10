-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1:3306
-- Généré le : dim. 10 mai 2026 à 11:52
-- Version du serveur : 8.4.7
-- Version de PHP : 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `comments_gestion`
--

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

DROP TABLE IF EXISTS `comments`;
CREATE TABLE IF NOT EXISTS `comments` (
  `comments_id` int NOT NULL AUTO_INCREMENT,
  `comments_users` int NOT NULL,
  `contents` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`comments_id`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`comments_id`, `comments_users`, `contents`) VALUES
(2, 2, 'Esperons que cela marche '),
(3, 1, 'Et cette fois'),
(4, 1, 'Ange est vilain '),
(19, 1, 'je suis Riaz votre ainee\r\n'),
(15, 3, 'Je vous envoie tous autant que vous etes au diable '),
(16, 1, 'vraiment vilain \r\n'),
(17, 1, 'Bizzare hein '),
(18, 3, 'Error');

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `userId` int NOT NULL AUTO_INCREMENT,
  `nameUser` varchar(256) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pass` varchar(150) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tel` int NOT NULL,
  PRIMARY KEY (`userId`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Déchargement des données de la table `users`
--

INSERT INTO `users` (`userId`, `nameUser`, `mail`, `pass`, `tel`) VALUES
(1, 'Riaz', 'jkn@hdhd', '3030', 96023431),
(2, 'Capriati', 'riazsanni1@gmail.com', '96023124', 42323127),
(3, 'Ange', 'ange@gmail.com', '9090', 16968358),
(4, 'Jemima', 'Jemima@gmail.com', '0000', 42323127);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
