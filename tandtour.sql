-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 20-09-2024 a las 23:24:00
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `tandtour`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `actividad`
--

CREATE TABLE `actividad` (
  `id_actividad` int(11) NOT NULL,
  `nombre` varchar(200) NOT NULL,
  `lon` decimal(10,8) DEFAULT NULL,
  `lat` decimal(10,8) DEFAULT NULL,
  `tipoactividad` varchar(200) NOT NULL,
  `dificultad` varchar(3) NOT NULL,
  `duracion` time(6) NOT NULL,
  `tipogrupo` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `actividad`
--

INSERT INTO `actividad` (`id_actividad`, `nombre`, `lon`, `lat`, `tipoactividad`, `dificultad`, `duracion`, `tipogrupo`) VALUES
(1, 'Monumento Granitico \"El Centinela\"', -59.17268680, -37.35491360, '2', '1', '00:25:00.000000', 'Todos'),
(2, 'Parque Lítico La Movediza', -59.16851650, -37.30787110, '2', '0', '00:30:00.000000', 'Todos'),
(3, 'Réplica de la Piedra Movediza', -59.16953120, -37.30951330, '2', '1', '01:00:00.000000', 'Todos\r\n'),
(4, 'Camino Misterioso (o Encantado)', -59.08698280, -37.33940720, '2', '0', '01:40:00.000000', 'Todos'),
(7, 'Puñon Mapuche', -59.12754860, -37.34954220, '2', '0', '00:05:00.000000', 'Todos'),
(8, 'El Cerrito', -59.12054020, -37.33217160, '2', '1', '00:15:00.000000', 'Todos'),
(9, 'Parque Independencia', -59.13802430, -37.34036340, '2', '0', '00:15:00.000000', 'Todos'),
(10, 'Sendero de La Cascada', -59.10194370, -37.36560770, '2', '1', '00:25:00.000000', 'Todos'),
(11, 'Cruz y Santuario Virgen de Fatima', -59.09982100, -37.36631800, '2', '1', '00:15:00.000000', 'Todos'),
(12, 'Feria de Artesanos', -59.13103250, -37.35047850, '2', '0', '00:10:00.000000', 'Todos'),
(13, 'Cerro El Centinela', -59.17031000, -37.35493000, '3', '0', '00:00:00.000000', 'Todos'),
(14, 'Cristo de las Sierras', -59.11435220, -37.37357070, '2', '1', '00:40:00.000000', 'Todos'),
(15, 'Monte Calvario', -59.15226700, -37.32786230, '2', '1', '01:00:00.000000', 'Todos'),
(17, 'Monumento a Don Quijote de La Mancha', -59.12254440, -37.35054480, '2', '1', '00:30:00.000000', 'Todos'),
(19, 'Cartel de Tandil Dique', -59.13208390, -37.34284830, '3', '0', '00:15:00.000000', 'Todos');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `itinerario`
--

CREATE TABLE `itinerario` (
  `id_itine` int(200) NOT NULL,
  `tipogrupo` varchar(200) NOT NULL,
  `personas` varchar(200) NOT NULL,
  `dificultades` varchar(200) NOT NULL,
  `tipoactividad` varchar(200) NOT NULL,
  `duracion` varchar(200) NOT NULL,
  `movilidad` varchar(200) NOT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_usuario` int(11) DEFAULT NULL,
  `latitud` double DEFAULT NULL,
  `longitud` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `itinerario`
--

INSERT INTO `itinerario` (`id_itine`, `tipogrupo`, `personas`, `dificultades`, `tipoactividad`, `duracion`, `movilidad`, `fecha`, `id_usuario`, `latitud`, `longitud`) VALUES
(3, 'Familia', '4', '2', 'Gastronomía', '3 dias', 'Vehículo', '2024-08-06 22:30:43', 3, NULL, NULL),
(4, 'Solo', '1', '2', 'Atracciones Naturales y culturales', '2 dias', 'Bicicleta', '2024-08-06 22:31:39', 3, NULL, NULL),
(13, 'Familia', '3', '1', 'Atracciones Naturales y culturales', '3 días', 'Vehículo', '2024-08-08 22:19:59', 7, NULL, NULL),
(14, 'Contingente', '2', '2', 'Atracciones Naturales y culturales', '4 días', 'Vehículo', '2024-08-08 22:28:21', 8, NULL, NULL),
(15, 'Familia', '4', '1', 'Atracciones Naturales y culturales', '4 días', 'Bicicleta', '2024-08-08 23:17:03', 9, NULL, NULL),
(23, 'Solo', '1', '2', 'Gastronomía', '1 día', 'Vehículo', '2024-08-20 22:54:30', 6, NULL, NULL),
(49, 'Solo', '1', '0', '4', '+5 días', 'Caminando', '2024-09-12 22:48:32', 11, -37.3183405, -59.1357618),
(50, 'Solo', '1', '0', '4', '+5 días', 'Caminando', '2024-09-18 22:29:44', 12, -37.3129216, -59.1527936);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(200) NOT NULL,
  `nombres` varchar(200) NOT NULL,
  `apellido` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `foto` varchar(200) NOT NULL,
  `contraseña` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nombres`, `apellido`, `email`, `foto`, `contraseña`) VALUES
(3, 'benja', 'gonzalez', 'lucas@gmail.com', 'imagenes/perfil.jpg', '$2y$10$Ae1.kPQvWlRBLpNi3xR.KOZfoujdO34jO8zIgYp/X1RyRcubUAF1a'),
(6, 'benja', 'paez', 'paez@gmail.com1', 'uimg/1722988126taxi.png', '$2y$10$KTzTtMbggJDkICH2EiPSrOdm7jMDEV9QIkYbCd.yuWGpNcEoUktBi'),
(7, 'juan', 'pepe', 'jupe@gmail.com', 'imagenes/perfil.jpg', '$2y$10$G4BktbcO0JQWKiZDD.FGL.qAnNLgqhg1CKmjmBKRmMYDlwjA8T5p.'),
(8, 'pedro', 'manes', 'pema@gmail.com', 'imagenes/perfil.jpg', '$2y$10$uxv/dEWnqLa0GnfSatUsFe1vU2h9LsuiH8gpplXMkF4hNeMBxzlIi'),
(9, 'mario1', 'perez', 'mape@gmail.com', 'imagenes/perfil.jpg', '$2y$10$HAORkiFVRpbZ8qTk36vQ2OJKBskAcXsNGNw6nMhNpjhUbWrfMVee2'),
(11, 'Benja', 'Paez', 'paez@gmail.com', 'uimg/17261872001721681909logo.png', '$2y$10$W054mBZGfMxBzjkw6bJTAeCAMwlM0w9P7JHJaz2483HmxoI61eeFC'),
(12, 'Ezequiel', 'Benites', 'eze@gmail.com', 'imagenes/perfil.jpg', '$2y$10$1ycbUk0iRq7CkxvYLez3xuvy8MBQwSd2zsVcDKi8Xk4uSnIN8dvgO'),
(13, 'p', 'o', 'po@gmail.com', 'imagenes/perfil.jpg', '$2y$10$LZqvRdyDArSI3rUJfwibEe2R.0ShxC3HavDfl1G3yUOLFUXL0Bxm6');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `actividad`
--
ALTER TABLE `actividad`
  ADD PRIMARY KEY (`id_actividad`);

--
-- Indices de la tabla `itinerario`
--
ALTER TABLE `itinerario`
  ADD PRIMARY KEY (`id_itine`),
  ADD KEY `fk_usuario` (`id_usuario`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `actividad`
--
ALTER TABLE `actividad`
  MODIFY `id_actividad` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `itinerario`
--
ALTER TABLE `itinerario`
  MODIFY `id_itine` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=51;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(200) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `itinerario`
--
ALTER TABLE `itinerario`
  ADD CONSTRAINT `fk_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
