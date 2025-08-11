-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 11-08-2025 a las 22:02:26
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
  `opcion_b` varchar(255) NOT NULL,
  `siguiente_a` int(11) DEFAULT NULL,
  `siguiente_b` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `escenas`
--

INSERT INTO `escenas` (`id`, `nombre`, `texto`, `opcion_a`, `opcion_b`, `siguiente_a`, `siguiente_b`) VALUES
(1, 'Despertar en el laboratorio', 'Despiertas en un laboratorio oscuro y desordenado. No recuerdas cómo llegaste aquí. Escuchas ruidos extraños y luces intermitentes. ¿Qué haces?', 'Explorar el pasillo hacia la izquierda.', 'Ir al laboratorio principal al frente.', 2, 3),
(2, 'Pasillo oscuro', 'Caminas por el pasillo oscuro y ves una puerta con símbolos de peligro. Hay un panel para abrirla pero requiere un código. ¿Intentas forzar la puerta o buscas otra ruta?', 'Forzar la puerta.', 'Buscar otra ruta.', 4, 5),
(3, 'Laboratorio principal', 'Entras al laboratorio y ves a un colega inconsciente en el suelo. Hay un frasco con un líquido verde cerca. ¿Intentas ayudar al colega o buscas una salida rápida?', 'Intentar ayudar al colega.', 'Buscar la salida rápida.', 6, 5),
(4, 'Forzando la puerta', 'Intentas forzar la puerta, pero activas una alarma. Guardias se acercan rápido. ¿Te escondes o enfrentas a los guardias?', 'Esconderse en un armario.', 'Enfrentar a los guardias.', 7, 8),
(5, 'Otra ruta', 'Decides buscar otra ruta. Encuentras una escalera que lleva a un sótano oscuro. ¿Bajas o vuelves al laboratorio principal?', 'Bajar al sótano.', 'Volver al laboratorio principal.', 9, 3),
(6, 'Ayudar al colega', 'Intentas ayudar al colega y descubres que fue víctima de un experimento ilegal. Él te pide que destruyas el laboratorio para que nadie más sufra. ¿Destruyes el laboratorio o intentas salvar datos importantes?', 'Destruir el laboratorio.', 'Salvar los datos.', 10, 11),
(7, 'Escondido', 'Te escondes justo a tiempo. Los guardias pasan sin verte. Encuentras una computadora con acceso restringido. ¿Intentas hackearla o sigues explorando?', 'Hackear la computadora.', 'Seguir explorando.', 11, 9),
(8, 'Enfrentar guardias', 'Los guardias te capturan y te obligan a firmar documentos que implican tu colaboración. Pierdes la oportunidad de escapar. Fin.', '--', '--', NULL, NULL),
(9, 'Sótano oscuro', 'Bajas al sótano y encuentras un área llena de equipos científicos abandonados. Hay una ventana rota que da al exterior. ¿Intentas salir por la ventana o buscas un equipo para defenderte?', 'Salir por la ventana.', 'Buscar equipo para defenderte.', 12, 13),
(10, 'Destruir laboratorio', 'Destruyes el laboratorio causando un apagón general. Escapas por los pasillos mientras todo se derrumba. Logras salir con vida pero te conviertes en un fugitivo. Fin.', '--', '--', NULL, NULL),
(11, 'Salvar datos', 'Decides salvar los datos. Descargas información crucial sobre los experimentos ilegales. Con esto puedes exponer la verdad, pero corres peligro. ¿Publicas los datos o los guardas para ti?', 'Publicar los datos.', 'Guardar los datos.', 14, 15),
(12, 'Escapar por ventana', 'Sales por la ventana y logras escapar al bosque cercano. Estás libre pero sabes que te perseguirán. Fin.', '--', '--', NULL, NULL),
(13, 'Buscar equipo', 'Encuentras un extintor y un cuchillo oxidado. De repente, escuchas pasos. ¿Preparas una emboscada o intentas esconderte?', 'Preparar emboscada.', 'Esconderse.', 16, 7),
(14, 'Publicar datos', 'Publicas los datos en internet. La verdad sale a la luz, pero tu identidad queda expuesta. Te conviertes en un héroe incómodo. Fin.', '--', '--', NULL, NULL),
(15, 'Guardar datos', 'Guardas los datos para ti, planeando usarlos en el futuro. La incertidumbre pesa, pero al menos tienes poder para negociar. Fin.', '--', '--', NULL, NULL),
(16, 'Emboscada', 'La emboscada funciona y neutralizas a quien venía. Encuentras una salida secreta. Logras escapar. Fin.', '--', '--', NULL, NULL),
(17, 'Hackeo exitoso', 'Hackeas la computadora y encuentras planos del laboratorio y un mapa con salidas secretas. ¿Sigues buscando información o usas el mapa para escapar?', 'Buscar más información.', 'Usar el mapa para escapar.', 18, 19),
(18, 'Información sensible', 'Descubres que el laboratorio hace experimentos con humanos y quiere ocultarlo. ¿Alertas a las autoridades o usas esta información para chantajear?', 'Alertar a las autoridades.', 'Chantajear a los responsables.', 20, 21),
(19, 'Usar mapa', 'Siguiendo el mapa, llegas a una salida oculta bloqueada por un sistema de seguridad. ¿Intentas desactivar el sistema o buscas otra salida?', 'Desactivar el sistema.', 'Buscar otra salida.', 22, 23),
(20, 'Alertar autoridades', 'Intentas enviar la información, pero el sistema está bloqueado. Un guardia se acerca. ¿Te rindes o luchas?', 'Rendirse.', 'Luchar.', 24, 25),
(21, 'Chantaje', 'Mandas un mensaje anónimo a los jefes del laboratorio amenazando con divulgar todo. Te proponen un trato: colaborar o desaparecer. ¿Aceptas o rechazas?', 'Aceptar el trato.', 'Rechazar el trato.', 26, 27),
(22, 'Desactivar sistema', 'Logras desactivar el sistema pero el tiempo corre. Encuentras un túnel oscuro. ¿Lo tomas o regresas?', 'Tomar el túnel.', 'Regresar.', 28, 5),
(23, 'Buscar otra salida', 'No encuentras otra salida y te atrapan los guardias. Fin.', '--', '--', NULL, NULL),
(24, 'Rendirse', 'Te capturan y pierdes toda esperanza. Fin.', '--', '--', NULL, NULL),
(25, 'Luchar', 'Logras neutralizar al guardia y continúas intentando enviar la información. Finalmente logras enviar la alerta. Ayuda llegará pronto. Fin.', '--', '--', NULL, NULL),
(26, 'Aceptar trato', 'Colaboras con el laboratorio, pero tu conciencia se carga de culpa. Te conviertes en cómplice de lo que sucede. Fin.', '--', '--', NULL, NULL),
(27, 'Rechazar trato', 'Rechazas y debes escapar rápido antes que te encuentren. El riesgo es alto pero la integridad vale más. ¿Buscas la salida principal o un túnel secreto?', 'Salida principal.', 'Túnel secreto.', 29, 28),
(28, 'Túnel secreto', 'El túnel es oscuro pero te lleva hacia la superficie. Escapas justo cuando llegan los guardias. Fin.', '--', '--', NULL, NULL),
(29, 'Salida principal', 'En la salida principal te esperan guardias. Te capturan y todo termina mal. Fin.', '--', '--', NULL, NULL),
(30, 'Explorar laboratorio alternativo', 'Encuentras un laboratorio secundario con experimentos en animales. ¿Destruyes todo o intentas salvar alguna prueba para denunciar?', 'Destruir todo.', 'Salvar pruebas.', 10, 11);

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `respuestas`
--

INSERT INTO `respuestas` (`id`, `id_escena`, `opcion_elegida`, `jugador_hash`, `fecha`) VALUES
(4, 1, 'a', '689a4073b8d4d', '2025-08-11 19:11:47'),
(5, 2, 'a', '689a4073b8d4d', '2025-08-11 19:13:26'),
(6, 5, 'a', '689a4073b8d4d', '2025-08-11 19:14:42'),
(7, 9, 'b', '689a4073b8d4d', '2025-08-11 19:14:47'),
(8, 13, 'b', '689a4073b8d4d', '2025-08-11 19:14:50'),
(9, 7, 'b', '689a4073b8d4d', '2025-08-11 19:14:57'),
(10, 11, 'a', '689a4073b8d4d', '2025-08-11 19:15:31'),
(11, 14, 'a', '689a4073b8d4d', '2025-08-11 19:15:38'),
(12, 3, 'a', '689a4073b8d4d', '2025-08-11 19:25:26'),
(13, 6, 'b', '689a4073b8d4d', '2025-08-11 19:25:30');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT de la tabla `respuestas`
--
ALTER TABLE `respuestas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

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
