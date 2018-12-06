-- phpMyAdmin SQL Dump
-- version 4.5.1
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 05-12-2018 a las 16:03:42
-- Versión del servidor: 10.1.10-MariaDB
-- Versión de PHP: 5.6.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `id8138591_clientes`
--
CREATE DATABASE IF NOT EXISTS `id8138591_clientes`;
USE `id8138591_clientes`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cities`
--

CREATE TABLE IF NOT EXISTS `cities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `city` varchar(50) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `city` (`city`)
) ENGINE=InnoDB AUTO_INCREMENT=33;

--
-- Volcado de datos para la tabla `cities`
--

INSERT INTO `cities` (`id`, `city`) VALUES
(1, 'Amazonas'),
(2, 'Antióquia'),
(3, 'Arauca'),
(26, 'Archipiélago de San Andrés'),
(4, 'Atlántico'),
(5, 'Bolívar'),
(6, 'Boyacá'),
(7, 'Caldas'),
(8, 'Caquetá'),
(9, 'Casanare'),
(10, 'Cauca'),
(11, 'Cesar'),
(12, 'Chocó'),
(13, 'Córdoba'),
(14, 'Cundinamarca'),
(15, 'Guainía'),
(16, 'Guaviare'),
(17, 'Huila'),
(18, 'La Guajira'),
(19, 'Magdalena'),
(20, 'Meta'),
(21, 'Nariño'),
(22, 'Norte de Santander'),
(23, 'Putumayo'),
(24, 'Quindío'),
(25, 'Risaralda'),
(27, 'Santander'),
(28, 'Sucre'),
(29, 'Tolima'),
(30, 'Valle Del Cauca'),
(31, 'Vaupés'),
(32, 'Vichada');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `clients`
--

CREATE TABLE IF NOT EXISTS `clients` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `name` varchar(40) NOT NULL,
  `last_name` varchar(50) NOT NULL,
  `type_document` int(11) NOT NULL,
  `document` int(14) NOT NULL,
  `email` varchar(70) NOT NULL,
  `city` int(11) NOT NULL,
  `address` varchar(90) NOT NULL,
  `movile` int(14) NOT NULL,
  `phone` int(14) NOT NULL,
  `state` tinyint(1) NOT NULL,
  `last_update` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 ;
