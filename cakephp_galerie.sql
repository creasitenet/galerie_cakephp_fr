-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Lun 12 Octobre 2015 à 23:56
-- Version du serveur :  5.6.17
-- Version de PHP :  5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données :  `cakephp_galerie`
--

-- --------------------------------------------------------

--
-- Structure de la table `pictures`
--

CREATE TABLE IF NOT EXISTS `pictures` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) NOT NULL,
  `file_extension` varchar(20) NOT NULL,
  `file_type` varchar(255) NOT NULL,
  `file_size` int(20) NOT NULL DEFAULT '0',
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `pictures`
--

INSERT INTO `pictures` (`id`, `slug`, `file_extension`, `file_type`, `file_size`, `created`, `modified`) VALUES
(5, 'ventilo.jpg', 'jpg', 'image/jpeg', 75447, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'tel.jpg', 'jpg', 'image/jpeg', 104298, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(6, 'tel.jpg', 'jpg', 'image/jpeg', 104298, '2015-10-12 21:29:51', '2015-10-12 21:29:51'),
(7, 'ventilo.jpg', 'jpg', 'image/jpeg', 75447, '2015-10-12 21:30:19', '2015-10-12 21:30:19');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
