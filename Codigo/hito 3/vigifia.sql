-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-10-2024 a las 00:30:44
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12


SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


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
(9, 'Sistemas alimentarios sostenibles', '2024-10-18 21:55:41', 'FIA busca promover procesos de innovación, a través de los lineamientos estratégicos FIA para el sector silvoagropecuario y/o de la cadena agroalimentaria nacional, por medio del impulso, articulación, desarrollo de capacidades y difusión tecnológica de i', 'pdf/6.pdf', 'Innovación, FIA'),
(10, 'Apicultura Diciembre 2010', '2024-10-18 21:55:47', 'España-SII Jornada Apícola Atlántica y Pirenaica', 'pdf/7.pdf', 'Ferias, eventos, noticias, patentes'),
(11, 'Apicultura Noviembre 2010', '2024-10-18 21:55:52', 'Seminario web virtual sobre Apicultura para principiantes', 'pdf/8.pdf', 'Ferias, eventos, noticias, patentes'),
(12, 'Producción primaria, recolección y poscosecha', '2024-10-18 21:55:58', 'El presente boletín es una muestra inicial del proceso de vigilancia en torno al lineamiento \"Sistemas  Alimentarios  Sostenibles\",  entrega  una selección de Noticias, Publicaciones científicas, Patentes,  Proyectos,  Políticas  Públicas,  Mercado  y Eve', 'pdf/6.pdf', 'Sostenible'),
(15, 'Adaptación y mitigación al cambio climático', '2024-10-18 22:07:36', 'Este boletín presenta estrategias del Ministerio de Agricultura para enfrentar el cambio climático, incluyendo medidas de adaptación y acciones de mitigación sostenibles.', 'pdf/1.pdf', 'Adaptación climática, Agricultura sostenible'),
(16, 'Modelos de IA capaces de predecir condiciones futuras de sequía', '2024-10-18 22:07:46', 'Este boletín destaca el avance de científicos que han desarrollado modelos de inteligencia artificial para predecir condiciones futuras de sequía. Estas herramientas permiten mejorar la planificación agrícola y la gestión de recursos hídricos, contribuyen', 'pdf/2.pdf', 'Sequías, Inteligencia artifical agrícola');

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
(93, 'Adaptación y mitigación al cambio climático', 'Este boletín presenta estrategias del Ministerio de Agricultura para enfrentar el cambio climático, incluyendo medidas de adaptación y acciones de mitigación sostenibles.', 'pdf/1.pdf', 'Adaptación climática, Agricultura sostenible', 'En revisión'),
(94, 'Modelos de IA capaces de predecir condiciones futuras de sequía', 'Este boletín destaca el avance de científicos que han desarrollado modelos de inteligencia artificial para predecir condiciones futuras de sequía. Estas herramientas permiten mejorar la planificación agrícola y la gestión de recursos hídricos, contribuyen', 'pdf/2.pdf', 'Sequías, Inteligencia artifical agrícola', 'En revisión'),
(95, 'Gestión sostenible de recursos hídricos', 'Este boletín explora estrategias para gestionar de manera sostenible los recursos hídricos en la agricultura. Se presentan iniciativas que promueven el uso eficiente del agua y la conservación de cuencas, adoptando tecnologías innovadoras para un acceso r', 'pdf/3.pdf', 'Uso eficiente del agua, Conservación hídrica', 'En revisión'),
(96, 'La importancia de invertir en tecnologías para el uso eficiente del agua en la agricultura', 'Este boletín resalta la inversión en tecnologías para el uso eficiente del agua en agricultura, optimizando recursos y mejorando la sostenibilidad del sector.', 'pdf/4.pdf', 'Riego, Agricultura sostenible', 'En revisión'),
(97, 'La papa cultivada en laboratorio resolvería un problema de almacenamiento', 'Este boletín examina cómo la papa cultivada en laboratorio podría resolver problemas de almacenamiento, aumentando la resistencia y reduciendo pérdidas postcosecha.', 'pdf/5.pdf', 'Papa, Postcosecha', 'En revisión');

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
(79);

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
(2, 'hola', 'DSFDSAFA', '202023564-3', 'por revisar');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `rut` varchar(12) NOT NULL,
  `email` varchar(255) NOT NULL,
  `nombres` varchar(255) DEFAULT NULL,
  `contraseña` varchar(255) DEFAULT NULL,
  `rol` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`rut`, `email`, `nombres`, `contraseña`, `rol`) VALUES
('202023564-3', 'walter.sanhueza@fia.cl', 'Walter Sanhueza', 'contraseña3', 'Bibliotecóloga'),
('23456789', 'ana.gomez@example.com', 'Ana Gomez', 'contraseña2', 'Usuario normal'),
('45678901', 'Maca.pozos@fia.cl', 'Macarena del Pozo', 'contraseña4', 'Bibliotecóloga'),
('77.777.888-9', 'minis.terio@minAgri.com', 'Ministerio de agricultura', 'contraseña1', 'Cliente');

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
  MODIFY `idBoletin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `borradores`
--
ALTER TABLE `borradores`
  MODIFY `idBorrador` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `idSoli` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

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
