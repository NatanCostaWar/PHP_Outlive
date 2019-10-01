-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 01-Out-2019 às 00:29
-- Versão do servidor: 5.6.13
-- versão do PHP: 5.4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de Dados: `db_outlive`
--
CREATE DATABASE IF NOT EXISTS `db_outlive` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `db_outlive`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `game`
--

CREATE TABLE IF NOT EXISTS `game` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `day` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `house`
--

CREATE TABLE IF NOT EXISTS `house` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `game` int(11) NOT NULL,
  `build_spot_1` varchar(100) NOT NULL DEFAULT 'empty',
  `build_spot_2` varchar(100) NOT NULL DEFAULT 'empty',
  `build_spot_3` varchar(100) NOT NULL DEFAULT 'empty',
  `build_spot_4` varchar(100) NOT NULL DEFAULT 'empty',
  `build_spot_5` varchar(100) NOT NULL DEFAULT 'empty',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `game` (`game`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=16 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `inventory`
--

CREATE TABLE IF NOT EXISTS `inventory` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `game` int(11) NOT NULL,
  `guns` int(11) NOT NULL DEFAULT '0',
  `bullets` int(11) NOT NULL DEFAULT '0',
  `nails` int(11) NOT NULL DEFAULT '0',
  `cigarettes` int(11) NOT NULL,
  `woods` int(11) NOT NULL,
  `scraps` int(11) NOT NULL,
  `pipes` int(11) NOT NULL,
  `herbal_seeds` int(11) NOT NULL,
  `vegetable_seeds` int(11) NOT NULL,
  `melee_weapons` int(11) NOT NULL,
  `beers` int(11) NOT NULL,
  `bottles_of_water` int(11) NOT NULL,
  `vegetables` int(11) NOT NULL,
  `meats` int(11) NOT NULL,
  `canned_foods` int(11) NOT NULL,
  `medicines` int(11) NOT NULL,
  `tools` int(11) NOT NULL,
  `coffees` int(11) NOT NULL,
  `herbs` int(11) NOT NULL,
  `gun_parts` int(11) NOT NULL,
  `gears` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `game` (`game`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `player`
--

CREATE TABLE IF NOT EXISTS `player` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `game` int(11) NOT NULL,
  `life` int(100) NOT NULL DEFAULT '100',
  `hunger` int(100) NOT NULL DEFAULT '100',
  `thirst` int(100) NOT NULL DEFAULT '100',
  `rest` int(11) NOT NULL DEFAULT '100',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `game` (`game`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `password` varchar(128) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `game`
--
ALTER TABLE `game`
  ADD CONSTRAINT `game_ibfk_4` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `house`
--
ALTER TABLE `house`
  ADD CONSTRAINT `house_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `house_ibfk_2` FOREIGN KEY (`game`) REFERENCES `game` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `inventory`
--
ALTER TABLE `inventory`
  ADD CONSTRAINT `inventory_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `inventory_ibfk_2` FOREIGN KEY (`game`) REFERENCES `game` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Limitadores para a tabela `player`
--
ALTER TABLE `player`
  ADD CONSTRAINT `player_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `player_ibfk_2` FOREIGN KEY (`game`) REFERENCES `game` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
