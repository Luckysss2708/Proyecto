-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 04-08-2025 a las 21:33:03
-- Versión del servidor: 10.4.24-MariaDB
-- Versión de PHP: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `juego_decisiones`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `escenas`
--

CREATE TABLE `escenas` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `texto` text NOT NULL,
  `opcion_a` varchar(255) NOT NULL,
  `opcion_b` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `escenas`
--

INSERT INTO `escenas` (`id`, `nombre`, `texto`, `opcion_a`, `opcion_b`) VALUES
(1, 'Inicio del Viaje', 'Te despiertas en un bosque desconocido. ¿Qué haces?', 'Explorar el bosque', 'Quedarte quieto'),
(2, 'El Encuentro', 'Te encuentras con un extraño viajero. ¿Lo sigues?', 'Sí, seguirlo', 'No, ignorarlo'),
(3, 'El Río', 'Llegas a un río caudaloso. ¿Cruzas por el puente o por el agua?', 'Cruzar por el puente', 'Cruzar por el agua');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL,
  `id_escena` int(11) NOT NULL,
  `opcion_elegida` enum('a','b') NOT NULL,
  `jugador_hash` varchar(50) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id`, `id_escena`, `opcion_elegida`, `jugador_hash`, `fecha`) VALUES
(1, 1, 'a', '68910ad55ac57', '2025-08-04 19:32:39'),
(2, 2, 'b', '68910ad55ac57', '2025-08-04 19:32:42'),
(3, 3, 'a', '68910ad55ac57', '2025-08-04 19:32:44');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `escenas`
--
ALTER TABLE `escenas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_escena` (`id_escena`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `escenas`
--
ALTER TABLE `escenas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `respuestas`
--
ALTER TABLE `respuestas`
  ADD CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`id_escena`) REFERENCES `escenas` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
