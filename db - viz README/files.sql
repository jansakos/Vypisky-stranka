-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1:3306
-- Vytvořeno: Úte 05. bře 2019, 16:19
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
-- Struktura tabulky `files`
--

DROP TABLE IF EXISTS `files`;
CREATE TABLE IF NOT EXISTS `files` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Id souboru',
  `subject` tinytext CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL COMMENT 'Školní předmět',
  `name` varchar(50) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL COMMENT 'Název souboru',
  `address` varchar(150) CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL COMMENT 'Adresa umístění',
  `author` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL COMMENT 'Username autora',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
