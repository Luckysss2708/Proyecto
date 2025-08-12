-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 12-08-2025
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- 
-- Base de datos: `juego_decisiones`
--

-- --------------------------------------------------------

--
-- Tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL UNIQUE,
  `password_hash` varchar(255) NOT NULL,
  `fecha_registro` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabla `escenas`
--

CREATE TABLE `escenas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) DEFAULT NULL,
  `texto` text NOT NULL,
  `opcion_a` varchar(255) NOT NULL,
  `opcion_b` varchar(255) NOT NULL,
  `siguiente_a` int(11) DEFAULT NULL,
  `siguiente_b` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar datos escena
INSERT INTO `escenas` (`id`, `nombre`, `texto`, `opcion_a`, `opcion_b`, `siguiente_a`, `siguiente_b`) VALUES
(1, 'Despertar en el laboratorio', 'Despiertas en un laboratorio lúgubre y desordenado. La cabeza te duele y no recuerdas cómo llegaste aquí. Alguien menciona el nombre "Dr. Severino Bassus" en un susurro lejano. Luces parpadean y sonidos metálicos resuenan. ¿Qué haces?', 'Explorar el pasillo izquierdo.', 'Avanzar hacia el laboratorio principal.', 2, 3),
(2, 'Pasillo oscuro', 'El pasillo está envuelto en sombras, y a lo lejos ves una puerta con símbolos de peligro biológico. Un panel bloquea la entrada y parece requerir un código. ¿Intentas forzar la puerta o buscas otra ruta?', 'Forzar la puerta con tus herramientas.', 'Buscar otra ruta alrededor.', 4, 5),
(3, 'Laboratorio principal', 'Entras y ves a un colega tirado en el suelo, inconsciente y con heridas extrañas. Cerca hay un frasco con líquido verde y un monitor parpadeante con datos confidenciales. ¿Intentas ayudar al colega o buscas una salida rápida?', 'Intentar ayudar al colega.', 'Buscar la salida rápidamente.', 6, 5),
(4, 'Forzar la puerta', 'Al manipular el panel, se activa una alarma silenciosa. Escuchas pasos apresurados y voces. Guardias de seguridad se acercan. ¿Te escondes o enfrentas?', 'Esconderse en un armario cercano.', 'Enfrentar a los guardias.', 7, 8),
(5, 'Otra ruta', 'Encuentras una escalera que baja a un sótano lleno de máquinas oxidadas y frascos rotos. Hay una ventana con barrotes y un pasillo oscuro. ¿Bajas al sótano o regresas al laboratorio principal?', 'Bajar al sótano.', 'Volver al laboratorio principal.', 9, 3),
(6, 'Ayudar al colega', 'El colega abre los ojos lentamente. Su voz es débil, pero menciona a Severino Bassus y un experimento prohibido. Te implora que destruyas el laboratorio o salves datos cruciales. ¿Qué haces?', 'Destruir el laboratorio antes que cause más daño.', 'Salvar la información para exponer la verdad.', 10, 11),
(7, 'Escondido', 'Dentro del armario, escuchas cómo los guardias inspeccionan la zona, pero no te encuentran. En el armario hay un dispositivo portátil con acceso restringido. ¿Intentas hackearlo o esperas y sigues explorando?', 'Hackear el dispositivo para obtener información.', 'Esperar y salir a explorar.', 12, 9),
(8, 'Enfrentar a guardias', 'Intentas pelear, pero son más fuertes y te reducen rápidamente. Te obligan a firmar documentos que te incriminan como cómplice. Tu única opción es colaborar o morir. Fin.', '--', '--', NULL, NULL),
(9, 'Sótano oscuro', 'El sótano está frío y húmedo. Encuentras un cuchillo oxidado y un extintor. Se oyen ruidos que no puedes identificar. ¿Sales por la ventana rota o preparas una defensa improvisada?', 'Salir por la ventana y escapar.', 'Preparar defensa con lo encontrado.', 13, 14),
(10, 'Destruir laboratorio', 'Con determinación, colocas explosivos y destruyes gran parte del laboratorio. La alarma suena y el edificio comienza a derrumbarse. Escapas justo a tiempo, pero ahora eres un fugitivo perseguido por todos. Fin.', '--', '--', NULL, NULL),
(11, 'Salvar datos', 'Descargas archivos secretos que prueban experimentos humanos ilegales dirigidos por Severino Bassus. El riesgo es alto, ¿publicas los datos para salvar a las víctimas o guardas la información para usarla en el momento oportuno?', 'Publicar la información y enfrentar las consecuencias.', 'Guardar los datos para negociar más tarde.', 15, 16),
(12, 'Hackeo exitoso', 'Consigues acceso al sistema y encuentras planos del laboratorio y registros ocultos. También hay un mapa con rutas de escape secretas. ¿Sigues buscando más datos o usas el mapa para salir?', 'Buscar más información comprometedora.', 'Usar el mapa para escapar.', 17, 18),
(13, 'Escapar por ventana', 'Logras escapar al bosque cercano, el aire fresco te da un respiro. Sabes que el laboratorio intentará encontrarte, pero por ahora estás libre. Fin.', '--', '--', NULL, NULL),
(14, 'Preparar defensa', 'Te preparas con el extintor y el cuchillo. Alguien baja las escaleras. Logras neutralizarlo en un forcejeo. Encuentras un pasadizo oculto. ¿Lo tomas o regresas?', 'Tomar el pasadizo oculto.', 'Regresar al laboratorio principal.', 19, 3),
(15, 'Publicar datos', 'Publicas la verdad en internet. El mundo reacciona con indignación, pero tu identidad queda expuesta. Te conviertes en un símbolo incómodo de justicia. Fin.', '--', '--', NULL, NULL),
(16, 'Guardar datos', 'Guardas la información y planeas usarla en el futuro. La incertidumbre y el miedo te acompañan, pero posees poder para negociar. Fin.', '--', '--', NULL, NULL),
(17, 'Buscar más información', 'Descubres que Severino Bassus está dispuesto a todo para continuar sus experimentos, incluyendo eliminar a cualquiera que se interponga. ¿Alertas a las autoridades o intentas chantajear al laboratorio?', 'Alertar a las autoridades con pruebas.', 'Enviar un mensaje anónimo para chantajear.', 20, 21),
(18, 'Usar mapa para escapar', 'Siguiendo el mapa, llegas a una salida bloqueada por un sistema de seguridad. ¿Intentas desactivar el sistema o buscas otra ruta?', 'Desactivar el sistema de seguridad.', 'Buscar otra salida.', 22, 23),
(19, 'Pasadizo oculto', 'El pasadizo es oscuro y húmedo, pero te lleva a un túnel de ventilación. Al final, ves la luz del exterior. ¿Sales o investigas más?', 'Salir inmediatamente.', 'Investigar más el túnel.', 24, 25),
(20, 'Alertar autoridades', 'Intentas enviar las pruebas, pero un guardia aparece. ¿Te rindes o luchas?', 'Rendirse y enfrentar las consecuencias.', 'Luchar y enviar las pruebas.', 26, 27),
(21, 'Chantaje', 'Envías un mensaje anónimo a Severino Bassus, amenazando con exponerlo. Te proponen un trato: colaborar o desaparecer. ¿Aceptas o rechazas?', 'Aceptar colaborar con Bassus.', 'Rechazar y huir.', 28, 29),
(22, 'Desactivar seguridad', 'Logras desactivar el sistema y accedes a la salida. Afuera hay un bosque oscuro. ¿Escapas o vuelves a buscar datos?', 'Escapar por el bosque.', 'Volver a buscar más datos.', 30, 17),
(23, 'Buscar otra salida', 'No encuentras otra ruta y los guardias te capturan. Fin.', '--', '--', NULL, NULL),
(24, 'Salir del túnel', 'Sales del túnel y estás libre. Sientes la brisa fresca y el peso de todo lo vivido. Fin.', '--', '--', NULL, NULL),
(25, 'Investigar túnel', 'Encuentras una cámara oculta con más información y evidencia. ¿Descargas todo o solo tomas lo esencial?', 'Descargar toda la información.', 'Tomar solo lo esencial y escapar.', 31, 24),
(26, 'Rendirse', 'Te capturan y enfrentas un futuro oscuro sin esperanza. Fin.', '--', '--', NULL, NULL),
(27, 'Luchar', 'Logras neutralizar al guardia y envías las pruebas. La ayuda llegará pronto. Fin.', '--', '--', NULL, NULL),
(28, 'Colaborar con Bassus', 'Colaboras y te conviertes en parte de los oscuros experimentos. La culpa y el miedo te consumen. Fin.', '--', '--', NULL, NULL),
(29, 'Huir de Bassus', 'Rechazas colaborar y debes escapar rápido. ¿Buscas la salida principal o un túnel secreto?', 'Salir por la puerta principal.', 'Tomar un túnel secreto.', 32, 33),
(30, 'Escapar por bosque', 'Logras escapar entre los árboles, con el corazón latiendo rápido. La libertad tiene un precio, y sabes que Bassus no te olvidará. Fin.', '--', '--', NULL, NULL),
(31, 'Descargar toda info', 'Descargas la información completa. La evidencia es abrumadora y podrá derribar a Bassus, pero el riesgo es inmenso. ¿Intentas contactar a las autoridades o guardas la info para ti?', 'Contactar autoridades inmediatamente.', 'Guardar la información para usarla después.', 20, 16),
(32, 'Salida principal', 'En la salida principal te esperan guardias. Te capturan y tu huida termina en fracaso. Fin.', '--', '--', NULL, NULL),
(33, 'Túnel secreto', 'El túnel oscuro te lleva a un respiradero que conecta con el exterior. Escapas justo a tiempo. Fin.', '--', '--', NULL, NULL);

-- --------------------------------------------------------

--
-- Tabla `finales`
--

CREATE TABLE `finales` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `descripcion` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabla `usuario_finales`
--

CREATE TABLE `usuario_finales` (
  `usuario_id` int(11) NOT NULL,
  `final_id` int(11) NOT NULL,
  `fecha_desbloqueo` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`usuario_id`, `final_id`),
  FOREIGN KEY (`usuario_id`) REFERENCES usuarios(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (`final_id`) REFERENCES finales(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Tabla `respuestas`
--

CREATE TABLE `respuestas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_escena` int(11) NOT NULL,
  `opcion_elegida` enum('a','b') NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `id_escena` (`id_escena`),
  CONSTRAINT `respuestas_ibfk_1` FOREIGN KEY (`id_escena`) REFERENCES `escenas` (`id`),
  CONSTRAINT `respuestas_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

COMMIT;
