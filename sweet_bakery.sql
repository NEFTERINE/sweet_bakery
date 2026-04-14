-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost
-- Tiempo de generación: 14-04-2026 a las 06:09:35
-- Versión del servidor: 8.0.39
-- Versión de PHP: 8.2.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sweet bakery`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_compras`
--

CREATE TABLE `historial_compras` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `item_id` varchar(50) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `item_nombre` varchar(100) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `precio` int DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `historial_compras`
--

INSERT INTO `historial_compras` (`id`, `usuario_id`, `item_id`, `item_nombre`, `precio`, `fecha`) VALUES
(1, 1, NULL, NULL, NULL, '2026-04-06 10:32:52'),
(2, 1, NULL, NULL, NULL, '2026-04-06 10:41:34'),
(3, 1, NULL, NULL, NULL, '2026-04-06 10:45:42'),
(4, 1, NULL, NULL, NULL, '2026-04-06 10:47:14'),
(5, 1, NULL, NULL, NULL, '2026-04-06 10:48:30'),
(6, 1, 'chocolate', 'Chocolate', 18, '2026-04-06 11:24:48'),
(7, 1, 'huevos', 'Huevos', 12, '2026-04-06 11:25:38'),
(8, 1, 'chispas', 'Chispas', 15, '2026-04-06 11:45:05'),
(9, 1, 'harina', 'Harina', 10, '2026-04-06 12:31:54'),
(10, 1, 'harina', 'Harina', 10, '2026-04-14 11:52:44'),
(11, 1, 'agua', 'Agua', 5, '2026-04-14 11:52:46'),
(12, 1, 'levadura', 'Levadura', 8, '2026-04-14 11:52:48'),
(13, 1, 'harina', 'Harina', 10, '2026-04-14 12:56:19'),
(14, 1, 'huevos', 'Huevos', 12, '2026-04-14 12:56:22'),
(15, 1, 'azucar', 'Azúcar', 8, '2026-04-14 12:56:23'),
(16, 1, 'mantequilla', 'Mantequilla', 15, '2026-04-14 12:56:25'),
(17, 1, 'agua', 'Agua', 5, '2026-04-14 12:56:26'),
(18, 1, 'chocolate', 'Chocolate', 18, '2026-04-14 12:56:31'),
(19, 1, 'harina', 'Harina', 10, '2026-04-14 12:57:04'),
(20, 1, 'azucar', 'Azúcar', 8, '2026-04-14 12:57:05'),
(21, 1, 'mantequilla', 'Mantequilla', 15, '2026-04-14 12:57:06'),
(22, 1, 'agua', 'Agua', 5, '2026-04-14 12:58:16'),
(23, 1, 'agua', 'Agua', 5, '2026-04-14 12:58:19');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `historial_horneados`
--

CREATE TABLE `historial_horneados` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `receta_id` int DEFAULT NULL,
  `receta_nombre` varchar(100) COLLATE utf8mb3_spanish_ci DEFAULT NULL,
  `recompensa` int DEFAULT NULL,
  `fecha` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `historial_horneados`
--

INSERT INTO `historial_horneados` (`id`, `usuario_id`, `receta_id`, `receta_nombre`, `recompensa`, `fecha`) VALUES
(1, 1, 3, 'Pastel de Chocolate', 50, '2026-04-06 11:25:50'),
(2, 1, 1, 'Pan Básico', 20, '2026-04-06 11:45:25'),
(3, 1, 1, 'Pan Básico', 20, '2026-04-14 11:53:05'),
(4, 1, 2, 'Galletas', 25, '2026-04-14 12:57:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `progreso_juego`
--

CREATE TABLE `progreso_juego` (
  `id` int NOT NULL,
  `usuario_id` int NOT NULL,
  `monedas` int DEFAULT '100',
  `inventario` text COLLATE utf8mb3_spanish_ci,
  `recetas_desbloqueadas` text COLLATE utf8mb3_spanish_ci,
  `ultima_actualizacion` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `monedas_gastadas` int DEFAULT '0',
  `total_horneados` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `progreso_juego`
--

INSERT INTO `progreso_juego` (`id`, `usuario_id`, `monedas`, `inventario`, `recetas_desbloqueadas`, `ultima_actualizacion`, `monedas_gastadas`, `total_horneados`) VALUES
(1, 1, 89, '[]', '[1,2]', '2026-04-14 05:57:23', 0, 0),
(2, 3, 100, '[]', '[]', '2026-04-14 03:39:39', 0, 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `nombre_usuario` varchar(50) COLLATE utf8mb3_spanish_ci NOT NULL,
  `correo` varchar(100) COLLATE utf8mb3_spanish_ci NOT NULL,
  `contraseña` varchar(255) COLLATE utf8mb3_spanish_ci NOT NULL,
  `tipo` enum('admin','user') COLLATE utf8mb3_spanish_ci DEFAULT 'user',
  `estatus` enum('activo','inactivo','bloqueado') COLLATE utf8mb3_spanish_ci DEFAULT 'activo',
  `fecha_registro` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `ultimo_login` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_spanish_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre_usuario`, `correo`, `contraseña`, `tipo`, `estatus`, `fecha_registro`, `ultimo_login`) VALUES
(1, 'maria', 'emily6941190764@gmail.com', '$2y$10$1KGCwnQo5PVUSzjM52cN5eMMliFlZtljfjl3zQ5cX3i7ngqUb712G', 'admin', 'activo', '2026-04-05 07:43:03', '2026-04-14 05:25:49'),
(3, 'admin', 'admin@gmail.com', '$2y$10$GTMIypUD90em2bO8udIWCeLnuJv8/79AYOnWy7UE/54sG8Zg8.3bS', 'admin', 'activo', '2026-04-14 03:39:38', NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `historial_horneados`
--
ALTER TABLE `historial_horneados`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuario_id` (`usuario_id`);

--
-- Indices de la tabla `progreso_juego`
--
ALTER TABLE `progreso_juego`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_usuario` (`usuario_id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nombre_usuario` (`nombre_usuario`),
  ADD UNIQUE KEY `correo` (`correo`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `historial_horneados`
--
ALTER TABLE `historial_horneados`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `progreso_juego`
--
ALTER TABLE `progreso_juego`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `historial_compras`
--
ALTER TABLE `historial_compras`
  ADD CONSTRAINT `historial_compras_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `historial_horneados`
--
ALTER TABLE `historial_horneados`
  ADD CONSTRAINT `historial_horneados_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;

--
-- Filtros para la tabla `progreso_juego`
--
ALTER TABLE `progreso_juego`
  ADD CONSTRAINT `progreso_juego_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
