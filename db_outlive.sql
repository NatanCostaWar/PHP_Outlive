-- phpMyAdmin SQL Dump
-- version 4.0.4.2
-- http://www.phpmyadmin.net
--
-- Máquina: localhost
-- Data de Criação: 05-Out-2019 às 20:30
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
-- Estrutura da tabela `builds`
--

CREATE TABLE IF NOT EXISTS `builds` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `game` int(11) NOT NULL,
  `user` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `amount` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `game` (`game`),
  KEY `user` (`user`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;

-- --------------------------------------------------------

--
-- Estrutura da tabela `house`
--

CREATE TABLE IF NOT EXISTS `house` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` int(11) NOT NULL,
  `game` int(11) NOT NULL,
  `level` int(3) NOT NULL DEFAULT '0',
  `build_spot_1` varchar(110) NOT NULL DEFAULT 'empty',
  `build_spot_2` varchar(110) NOT NULL DEFAULT 'empty',
  `build_spot_3` varchar(110) NOT NULL DEFAULT 'empty',
  `build_spot_4` varchar(110) NOT NULL DEFAULT 'empty',
  `build_spot_5` varchar(110) NOT NULL DEFAULT 'empty',
  `build_spot_6` varchar(110) NOT NULL DEFAULT 'empty',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `game` (`game`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
  `fertilizers` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user` (`user`),
  KEY `game` (`game`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Constraints for dumped tables
--

--
-- Limitadores para a tabela `builds`
--
ALTER TABLE `builds`
  ADD CONSTRAINT `builds_ibfk_1` FOREIGN KEY (`game`) REFERENCES `game` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `builds_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

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
