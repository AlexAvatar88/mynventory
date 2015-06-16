-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 13-06-2015 a las 16:10:18
-- Versión del servidor: 5.6.17
-- Versión de PHP: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de datos: `mynventory`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `inventories`
--

CREATE TABLE IF NOT EXISTS `inventories` (
  `username` varchar(30) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `inventory_name` varchar(80) NOT NULL,
  `inventory_desc` varchar(200) NOT NULL,
  PRIMARY KEY (`username`,`inventory_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `inventories`
--

INSERT INTO `inventories` (`username`, `inventory_name`, `inventory_desc`) VALUES
('admin', 'Pilar', 'Inventario de la pilarica'),
('admin', 'Prueba 5', '1st attempt'),
('admin', 'Prueba1', 'prueba 1 prueba 1'),
('admin', 'Prueba2', 'prueba2'),
('admin', 'PRUEBA3', 'case sensitive'),
('admin', 'Prueba4', '4th attempt'),
('admin', 'Prueba6', '1st attempt'),
('admin', 'Prueba7', '1st attempt');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `username` varchar(30) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `password` varchar(30) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `email` varchar(100) NOT NULL,
  PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `users`
--

INSERT INTO `users` (`username`, `password`, `email`) VALUES
('admin', 'admin', 'admin@mynventory.com'),
('alex', 'alex', 'alex@mynventory.com'),
('bea', 'bea', 'bea@mynventory.com');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
