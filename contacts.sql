-- phpMyAdmin SQL Dump
-- version 3.5.7
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1:3307
-- Время создания: Янв 10 2014 г., 21:54
-- Версия сервера: 5.6.10-log
-- Версия PHP: 5.4.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `contacts`
--
CREATE DATABASE `contacts` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `contacts`;

-- --------------------------------------------------------

--
-- Структура таблицы `cont_groups`
--

CREATE TABLE IF NOT EXISTS `cont_groups` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_name` int(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id_name` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL COMMENT 'Имя ',
  `s_name` text NOT NULL COMMENT 'Фамилия',
  `m_name` text NOT NULL COMMENT 'Отчество',
  PRIMARY KEY (`id_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `groups`
--

CREATE TABLE IF NOT EXISTS `groups` (
  `id_group` int(11) NOT NULL AUTO_INCREMENT,
  `group_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id_group`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Структура таблицы `number`
--

CREATE TABLE IF NOT EXISTS `number` (
  `id_phone` int(11) NOT NULL AUTO_INCREMENT,
  `Id_name` int(11) NOT NULL,
  `telephone` varchar(255) NOT NULL,
  PRIMARY KEY (`id_phone`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
