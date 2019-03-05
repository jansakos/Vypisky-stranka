-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1:3306
-- Vytvořeno: Ned 03. bře 2019, 19:37
-- Verze serveru: 5.7.21
-- Verze PHP: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: ``
--

-- --------------------------------------------------------

--
-- Struktura tabulky `notif`
--

DROP TABLE IF EXISTS `notif`;
CREATE TABLE IF NOT EXISTS `notif` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `text` text CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL,
  `tothe` varchar(6) CHARACTER SET utf8 COLLATE utf8_bin DEFAULT NULL,
  `exp` date DEFAULT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
