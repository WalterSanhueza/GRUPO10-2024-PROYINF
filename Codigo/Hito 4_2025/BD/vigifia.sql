-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 01-06-2025 a las 04:40:25
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

CREATE DATABASE IF NOT EXISTS vigifia DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE vigifia;

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vigifia`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `boletines`
--

CREATE TABLE `boletines` (
  `idBoletin` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `fechaPublicacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `descripcion` varchar(255) NOT NULL,
  `pdf_url` varchar(255) NOT NULL,
  `parametros` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `boletines`
--

INSERT INTO `boletines` (`idBoletin`, `titulo`, `fechaPublicacion`, `descripcion`, `pdf_url`, `parametros`) VALUES
(1, 'Sistemas alimentarios sostenibles. N°1 septiembre 2022', '2024-10-18 21:55:41', 'FIA busca promover procesos de innovación, a través de los lineamientos estratégicos FIA para el sector silvoagropecuario y/o de la cadena agroalimentaria nacional, por medio del impulso, articulación, desarrollo de capacidades y difusión tecnológica de i', 'pdf/6.pdf', 'Innovación, FIA'),
(2, 'Apicultura Diciembre 2010', '2024-10-18 21:55:47', 'España-SII Jornada Apícola Atlántica y Pirenaica', 'pdf/7.pdf', 'Ferias, eventos, noticias, patentes'),
(3, 'Apicultura Noviembre 2010', '2024-10-18 21:55:52', 'Seminario web virtual sobre Apicultura para principiantes', 'pdf/8.pdf', 'Ferias, eventos, noticias, patentes'),
(4, 'Adaptación y mitigación al cambio climático. N°12 marzo 2025', '2024-10-18 21:55:58', 'Un nuevo sistema de predicción meteorológica basado en IA, Aardvark Weather, puede ofrecer pronósticos precisos decenas de veces más rápido y utilizando miles de veces menos poder de cómputo que los sistemas actuales basados en IA y física, según una investigación publicada en Nature.', 'pdf/9.pdf', 'Clima, Física, IA'),
(5, 'Gestión Sostenible de Recursos Hídricos. N°12 marzo 2025', '2024-10-18 22:07:36', 'Los robots agrícolas están transformando la agricultura mediante la automatización de tareas como la siembra, la cosecha y el monitoreo de cultivos', 'pdf/10.pdf', 'Hidríco, Agricultura sostenible, IA'),
(6, 'Sistemas Alimentarios Sostenibles. N°12 marzo 2025', '2024-10-18 22:07:46', 'Destacados profesionales de Perú y Chile participaron en el panel de conversación: “Principales desafíos de la cosecha, logística y postcosecha de arándanos en Perú” que se llevó a cabo en el marco del XXXIV Seminario Internacional Blueberries desarrollado en Lima', 'pdf/11.pdf', 'Cosecha, Seminario, Perú, Chile');
-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `borradores`
--

CREATE TABLE `borradores` (
  `idBorrador` int(11) NOT NULL,
  `titulo` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `pdf_url` varchar(255) NOT NULL,
  `parametros` varchar(255) NOT NULL,
  `estado` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `borradores`
--

INSERT INTO `borradores` (`idBorrador`, `titulo`, `descripcion`, `pdf_url`, `parametros`, `estado`) VALUES
(116, 'La importancia de invertir en tecnologías para el uso eficiente del agua en la agricultura', 'Este boletín resalta la inversión en tecnologías para el uso eficiente del agua en agricultura, optimizando recursos y mejorando la sostenibilidad del sector.', 'pdf/4.pdf', 'Riego, Agricultura sostenible', 'En revisión'),
(117, 'La papa cultivada en laboratorio resolvería un problema de almacenamiento', 'Este boletín examina cómo la papa cultivada en laboratorio podría resolver problemas de almacenamiento, aumentando la resistencia y reduciendo pérdidas postcosecha.', 'pdf/5.pdf', 'Papa, Postcosecha', 'En revisión');

--
-- Disparadores `borradores`
--
DELIMITER $$
CREATE TRIGGER `after_update_borradores` AFTER UPDATE ON `borradores` FOR EACH ROW BEGIN
    IF NEW.estado = 'Aceptado' THEN
        INSERT INTO BOLETINES (titulo, pdf_url, fechaPublicacion, descripcion, parametros)
        VALUES (NEW.titulo, NEW.pdf_url, NOW(), NEW.descripcion, NEW.parametros);
        INSERT INTO PENDING_DELETIONS (idBorrador) VALUES (NEW.idBorrador);
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pending_deletions`
--

CREATE TABLE `pending_deletions` (
  `idBorrador` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pending_deletions`
--

INSERT INTO `pending_deletions` (`idBorrador`) VALUES
(48),
(53),
(73),
(78),
(79),
(94),
(95),
(96),
(97),
(98),
(99),
(100),
(101),
(102),
(104),
(103),
(105),
(106),
(107),
(108),
(109),
(110),
(111),
(112),
(113),
(114),
(115);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `idSoli` int(11) NOT NULL,
  `parametros` varchar(255) NOT NULL,
  `descripcion` varchar(255) NOT NULL,
  `rutCliente` varchar(12) NOT NULL,
  `estado` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `solicitudes`
--

INSERT INTO `solicitudes` (`idSoli`, `parametros`, `descripcion`, `rutCliente`, `estado`) VALUES
(8, 'test3', 'test3, video', '77.777.888-9', 'Generando boletin'),
(9, 'test1', 'test1, video', '77.777.888-9', 'Generando boletin');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `rut` varchar(12) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nombres` varchar(255) DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `rol` varchar(255) DEFAULT NULL,
  `envios` tinyint(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`rut`, `email`, `nombres`, `contraseña`, `rol`, `envios`) VALUES
('00000000-0', 'diego.carlon@fia.cl', 'Diego Carlon', 'diego', 'Equipo TI', 0),
('202023564-3', 'walter.sanhueza@fia.cl', 'Walter Sanhueza', 'walter', 'Bibliotecóloga', 0),
('23456789', 'matias.perezo@fia.cl', 'Matias Perez', 'matias', 'Usuario normal', 0),
('321312132-7', 'walter.sanhueza@usm.cl', 'Walter Sanhueza', 'walter2', 'Usuario normal', 1),
('77.777.888-9', 'joshua.serin@fia.cl', 'Joshua Serín', 'joshua', 'Cliente', 0);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `boletines`
--
ALTER TABLE `boletines`
  ADD PRIMARY KEY (`idBoletin`),
  ADD UNIQUE KEY `idBoletin` (`idBoletin`);

--
-- Indices de la tabla `borradores`
--
ALTER TABLE `borradores`
  ADD PRIMARY KEY (`idBorrador`),
  ADD UNIQUE KEY `idBorrador` (`idBorrador`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`idSoli`),
  ADD KEY `rutCliente` (`rutCliente`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`rut`,`email`),
  ADD KEY `rut` (`rut`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `boletines`
--
ALTER TABLE `boletines`
  MODIFY `idBoletin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT de la tabla `borradores`
--
ALTER TABLE `borradores`
  MODIFY `idBorrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `idSoli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `solicitudes_ibfk_1` FOREIGN KEY (`rutCliente`) REFERENCES `usuarios` (`rut`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Eventos
--
CREATE DEFINER=`root`@`localhost` EVENT `process_pending_deletions` ON SCHEDULE EVERY 1 MINUTE STARTS '2024-10-17 00:16:54' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
    DELETE FROM BORRADORES WHERE idBorrador IN (SELECT idBorrador FROM PENDING_DELETIONS);
    DELETE FROM PENDING_DELETIONS WHERE idBorrador IN (SELECT idBorrador FROM PENDING_DELETIONS);
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
