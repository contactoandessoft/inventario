-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3307
-- Tiempo de generación: 11-01-2025 a las 17:07:32
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
-- Base de datos: `empresa`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `formulario`
--

CREATE TABLE `formulario` (
  `id_formulario` int(11) NOT NULL,
  `numero_inventario` varchar(50) DEFAULT NULL,
  `descripcion` varchar(255) NOT NULL,
  `id_marcas` int(11) NOT NULL,
  `modelo` varchar(100) NOT NULL,
  `ano_fabricacion` int(11) NOT NULL,
  `valor_adquisicion` decimal(10,2) NOT NULL,
  `id_responsable` int(11) NOT NULL,
  `estado` enum('Activo','Baja') NOT NULL,
  `numero_serie` varchar(100) DEFAULT NULL,
  `vida_util` int(11) DEFAULT NULL,
  `id_tipo_equipo` int(11) NOT NULL,
  `fecha_alta` date DEFAULT NULL,
  `seccion` varchar(255) DEFAULT NULL,
  `dependencia` varchar(255) DEFAULT NULL,
  `comentarios` text DEFAULT NULL,
  `imagen` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `formulario`
--

INSERT INTO `formulario` (`id_formulario`, `numero_inventario`, `descripcion`, `id_marcas`, `modelo`, `ano_fabricacion`, `valor_adquisicion`, `id_responsable`, `estado`, `numero_serie`, `vida_util`, `id_tipo_equipo`, `fecha_alta`, `seccion`, `dependencia`, `comentarios`, `imagen`) VALUES
(1, 'II_20KL', 'Tarjetas Gráficas Ultimo modelo', 3, 'RTX serie 50', 2024, 700000.00, 1, 'Activo', '203020', 3, 0, '2025-01-11', 'F_84', '', '', ''),
(2, 'LL_350A', 'Escritorios ', 1, 'Escritorio_PL', 2020, 650000.00, 1, 'Baja', '908090', 3, 0, '0000-00-00', 'H_90', '', '', ''),
(3, 'RYT_00', 'Teléfonos', 4, 'Iphone_20', 2000, 100000.00, 3, 'Baja', '6590', 1, 0, '2025-01-10', '', '', '', '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `marcas`
--

CREATE TABLE `marcas` (
  `id_marcas` int(11) NOT NULL,
  `nombre_marca` varchar(50) NOT NULL,
  `vigencia` tinyint(4) NOT NULL,
  `fecha_audita` date NOT NULL DEFAULT current_timestamp(),
  `id_usuario` smallint(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `marcas`
--

INSERT INTO `marcas` (`id_marcas`, `nombre_marca`, `vigencia`, `fecha_audita`, `id_usuario`) VALUES
(1, 'AMD', 1, '2025-01-11', 5),
(2, 'INTEL', 1, '2025-01-11', 6),
(3, 'NVIDIA', 1, '2025-01-11', 7),
(4, 'APPLE', 1, '2025-01-11', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `responsables`
--

CREATE TABLE `responsables` (
  `id_responsable` int(11) NOT NULL,
  `nombre_responsable` varchar(100) NOT NULL,
  `vigencia` tinyint(4) NOT NULL,
  `fecha_audita` date NOT NULL,
  `id_usuario` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `responsables`
--

INSERT INTO `responsables` (`id_responsable`, `nombre_responsable`, `vigencia`, `fecha_audita`, `id_usuario`) VALUES
(1, 'Mauricio', 1, '2025-01-11', 5),
(2, 'Eduardo', 1, '2025-01-11', 9),
(3, 'Francisca', 1, '2025-01-11', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipocuenta`
--

CREATE TABLE `tipocuenta` (
  `id_cuenta` int(11) NOT NULL,
  `num_cuenta` int(11) NOT NULL,
  `descripcion` varchar(100) NOT NULL,
  `vigencia` tinyint(4) NOT NULL,
  `fecha_audita` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_usuario` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_equipo`
--

CREATE TABLE `tipo_equipo` (
  `id_tipo_equipo` int(11) NOT NULL,
  `nombre_tipo_equipo` varchar(50) NOT NULL,
  `vigencia` tinyint(1) NOT NULL,
  `fecha_audita` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_usuario` smallint(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `tipo_equipo`
--

INSERT INTO `tipo_equipo` (`id_tipo_equipo`, `nombre_tipo_equipo`, `vigencia`, `fecha_audita`, `id_usuario`) VALUES
(5, 'Tipo Equipo 1', 1, '2024-12-26 15:24:18', 5),
(6, 'Tipo Equipo 2', 1, '2024-12-26 15:24:18', 6),
(7, 'Tipo Equipo 3', 1, '2024-12-26 15:24:18', 7),
(8, 'Tipo Equipo 4', 1, '2024-12-26 15:24:18', 8);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` smallint(6) NOT NULL,
  `user` varchar(100) NOT NULL,
  `nombre_usuario` varchar(100) NOT NULL,
  `clave` varchar(100) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `vigencia` tinyint(4) NOT NULL,
  `fecha_audita` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `user`, `nombre_usuario`, `clave`, `correo`, `vigencia`, `fecha_audita`) VALUES
(5, 'Ale', 'Alejandra', '$2y$10$R4.tV68xWY/Gw5WKNZer1eD0PCMn2D.mp1Q1vw32mDoplryJKIPdS', 'alejandra@gmail.com', 1, '2024-12-25 22:16:21'),
(6, 'Robert', 'Roberto', '$2y$10$wn.KvBcqJ8eFCVgiGoZos.XoniwsI9GhKubfVVy3L/bWAXI1IpPrG', 'robert@gmail.com', 1, '2024-12-25 22:18:58'),
(7, 'Benjita', 'Benjamin', '$2y$10$CKSrF1N0lGI4GCjEd7H2C.45W8zerokB99gFEQ3w3aZd6hQ9s1Wq2', 'benja@gmail.com', 1, '2025-01-11 14:13:38'),
(8, 'Javierss', 'Javier', '$2y$10$Ns2f6wiifrZt5sm7ayrL9utQHyKEeYsr4m7yZ2tobHWjHwCKursx.', 'javier@gmail.com', 1, '2025-01-11 14:13:17'),
(9, 'Matias', 'Matias', '$2y$10$FEM4pVeWXEO/GZRrA8Lo5Oamlj4rfgLnjtd0BoCF0.vrnQ.uEygJO', 'matias@gmail.com', 1, '2025-01-11 14:13:30');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `formulario`
--
ALTER TABLE `formulario`
  ADD PRIMARY KEY (`id_formulario`),
  ADD UNIQUE KEY `numero_inventario` (`numero_inventario`),
  ADD KEY `id_tipo_equipo` (`id_tipo_equipo`),
  ADD KEY `formulario_ibfk_1` (`id_marcas`),
  ADD KEY `formulario_ibfk_2` (`id_responsable`);

--
-- Indices de la tabla `marcas`
--
ALTER TABLE `marcas`
  ADD PRIMARY KEY (`id_marcas`),
  ADD KEY `fk_marcas_usuarios` (`id_usuario`);

--
-- Indices de la tabla `responsables`
--
ALTER TABLE `responsables`
  ADD PRIMARY KEY (`id_responsable`),
  ADD KEY `fk_responsables_usuarios` (`id_usuario`);

--
-- Indices de la tabla `tipocuenta`
--
ALTER TABLE `tipocuenta`
  ADD PRIMARY KEY (`id_cuenta`),
  ADD KEY `fk_tipocuenta_cuentas` (`id_usuario`);

--
-- Indices de la tabla `tipo_equipo`
--
ALTER TABLE `tipo_equipo`
  ADD PRIMARY KEY (`id_tipo_equipo`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `formulario`
--
ALTER TABLE `formulario`
  MODIFY `id_formulario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `marcas`
--
ALTER TABLE `marcas`
  MODIFY `id_marcas` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `responsables`
--
ALTER TABLE `responsables`
  MODIFY `id_responsable` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipocuenta`
--
ALTER TABLE `tipocuenta`
  MODIFY `id_cuenta` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_equipo`
--
ALTER TABLE `tipo_equipo`
  MODIFY `id_tipo_equipo` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `formulario`
--
ALTER TABLE `formulario`
  ADD CONSTRAINT `formulario_ibfk_1` FOREIGN KEY (`id_marcas`) REFERENCES `marcas` (`id_marcas`),
  ADD CONSTRAINT `formulario_ibfk_2` FOREIGN KEY (`id_responsable`) REFERENCES `responsables` (`id_responsable`);

--
-- Filtros para la tabla `tipocuenta`
--
ALTER TABLE `tipocuenta`
  ADD CONSTRAINT `fk_tipocuenta_cuentas` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

--
-- Filtros para la tabla `tipo_equipo`
--
ALTER TABLE `tipo_equipo`
  ADD CONSTRAINT `fk_tipo_equipo_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
