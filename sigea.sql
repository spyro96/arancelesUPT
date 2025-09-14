-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 09-09-2025 a las 14:34:15
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sigea`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `aranceles`
--

CREATE TABLE `aranceles` (
  `id` int NOT NULL,
  `nombre` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `precio` decimal(20,2) DEFAULT NULL,
  `categoria` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estatus` tinyint(1) DEFAULT NULL,
  `tipo` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `aranceles`
--

INSERT INTO `aranceles` (`id`, `nombre`, `precio`, `categoria`, `estatus`, `tipo`) VALUES
(1, 'Nuevo Ingreso', 110.00, 'inscripcion', 1, 'bolivares'),
(2, 'Inscripción Regulares', 100.00, 'inscripcion', 1, 'bolivares'),
(3, 'Certificación de Notas', 4.97, 'documento', 1, 'dolar'),
(4, 'Certificación de Títulos', 3.00, 'documento', 1, 'dolar'),
(5, 'Constancia de Culminación', 3.00, 'documento', 1, 'dolar'),
(6, 'Acto de Grado', 36.00, 'grado', 1, 'dolar'),
(7, 'Retiro de Título por Secretaría', 31.00, 'grado', 1, 'dolar'),
(8, 'Reingreso-Reincorporación', 2.20, 'inscripcion', 1, 'dolar'),
(9, 'Record Académico', 4.98, 'Academico', 1, 'dolar'),
(10, 'Verificación de Título', 3.00, 'documento', 1, 'dolar'),
(11, 'Carnet Estudiantil', 3.00, 'academico', 1, 'dolar'),
(15, 'Constacia De Inscripción', 100.00, 'academico', 1, 'bolivares'),
(18, 'Inscripcion Por Acreditación', 120.00, 'inscripcion', 1, 'bolivares');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bancos`
--

CREATE TABLE `bancos` (
  `id` int NOT NULL,
  `codigo` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `banco` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bancos`
--

INSERT INTO `bancos` (`id`, `codigo`, `banco`) VALUES
(1, '0102', 'BANCO DE VENEZUELA S.A BANCO UNIVERSAL'),
(2, '0104', 'BANCO VENEZOLANO DE CREDITO S.A.'),
(3, '0105', 'BANCO MERCANTIL C.A.'),
(4, '0108', 'BANCO PROVINCIAL BBVA'),
(5, '0114', 'BANCO DEL CARIBE C.A.'),
(6, '0115', 'BANCO EXTERIOR C.A.'),
(7, '0128', 'BANCO CARONI C.A. BANCO UNIVERSAL'),
(8, '0134', 'BANESCO BANCO UNIVERSAL'),
(9, '0137', 'BANCO SOFITASA'),
(10, '0138', 'BANCO PLAZA'),
(11, '0151', 'FONDO COMUN C.A BANCO UNIVERSAL'),
(12, '0156', '100%BANCO'),
(13, '0157', 'DELSUR BANCO UNIVERSAL'),
(14, '0163', 'BANCO DEL TESORO'),
(15, '0166', 'BANCO AGRICOLA'),
(16, '0168', 'BANCRECER S.A. BANCO DE DESARROLLO'),
(17, '0169', 'MIBANCO BANCO DE DESARROLLO C.A.'),
(18, '0171', 'BANCO ACTIVO BANCO COMERCIAL, C.A.'),
(19, '0172', 'BANCAMIGA BANCO MICROFINANCIERO, C.A.'),
(20, '0174', 'BANPLUS BANCO COMERCIAL C.A'),
(21, '0175', 'BANCO BICENTENARIO'),
(22, '0177', 'BANFANB'),
(23, '0191', 'BANCO NACIONAL DE CREDITO');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `bcv`
--

CREATE TABLE `bcv` (
  `id` int NOT NULL,
  `tasa` float(7,4) DEFAULT NULL,
  `fecha` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `bcv`
--

INSERT INTO `bcv` (`id`, `tasa`, `fecha`) VALUES
(1, 36.5129, '2024-05-25');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categorias`
--

CREATE TABLE `categorias` (
  `id` int NOT NULL,
  `nombre` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `categorias`
--

INSERT INTO `categorias` (`id`, `nombre`) VALUES
(1, 'documento'),
(2, 'grado'),
(3, 'academico'),
(4, 'inscripcion');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_personales`
--

CREATE TABLE `datos_personales` (
  `id` int NOT NULL,
  `nombres` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apellidos` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nacionalidad` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cedula` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usuarioId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `datos_verificar`
--

CREATE TABLE `datos_verificar` (
  `id` int NOT NULL,
  `nombres` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apellidos` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nacionalidad` varchar(1) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cedula` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estatus` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pagos`
--

CREATE TABLE `pagos` (
  `id` int NOT NULL,
  `n_referencia` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `imagen` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `banco` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `solicitudes_detalles_id` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pnf`
--

CREATE TABLE `pnf` (
  `id` int NOT NULL,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `pnf`
--

INSERT INTO `pnf` (`id`, `nombre`) VALUES
(1, 'Informática'),
(2, 'Materiales Industriales'),
(3, 'Higiene y Seguridad Laboral'),
(4, 'Electricidad'),
(5, 'Geociencias'),
(6, 'Mecánica'),
(7, 'Química'),
(8, 'Orfebrería y Joyería'),
(9, 'Sistemas de Calidad y Ambiente'),
(10, 'Agroalimentación'),
(11, 'Ingenería de Mantenimiento'),
(12, 'Distribución y Logística');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preguntas_seguridad`
--

CREATE TABLE `preguntas_seguridad` (
  `id` int NOT NULL,
  `pregunta1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `respuesta1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pregunta2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `respuesta2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usuarioId` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `preguntas_seguridad`
--

INSERT INTO `preguntas_seguridad` (`id`, `pregunta1`, `respuesta1`, `pregunta2`, `respuesta2`, `usuarioId`) VALUES
(2, '¿Cuál es el nombre de tu primer mascota?', 'niño', '¿Cuál es el nombre de tu color favorito?', 'azul', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes`
--

CREATE TABLE `solicitudes` (
  `id` int NOT NULL,
  `datos_personalesId` int DEFAULT NULL,
  `solicitudes_detalles_id2` int DEFAULT NULL,
  `tipo_u_modelo` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `id_modelo` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `solicitudes_detalles`
--

CREATE TABLE `solicitudes_detalles` (
  `id` int NOT NULL,
  `aranceles` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `categoria` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total` float(8,2) DEFAULT NULL,
  `estatus` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'por pagar',
  `pnf` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `n_solicitud` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `fecha_expiracion` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  `terceros` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int NOT NULL,
  `correo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rol` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estatus` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `correo`, `password`, `rol`, `estatus`) VALUES
(2, 'admin@gmail.com', '$2y$10$8RKYZmfUDGd.Y9rEerqJ/.ZHKyo8xU2YfRQzd017ihGUzGHr4RE/O', 'admin', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `aranceles`
--
ALTER TABLE `aranceles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bancos`
--
ALTER TABLE `bancos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `bcv`
--
ALTER TABLE `bcv`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `datos_personales`
--
ALTER TABLE `datos_personales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarioId` (`usuarioId`);

--
-- Indices de la tabla `datos_verificar`
--
ALTER TABLE `datos_verificar`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD PRIMARY KEY (`id`),
  ADD KEY `solicitudesId` (`solicitudes_detalles_id`) USING BTREE;

--
-- Indices de la tabla `pnf`
--
ALTER TABLE `pnf`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `preguntas_seguridad`
--
ALTER TABLE `preguntas_seguridad`
  ADD PRIMARY KEY (`id`),
  ADD KEY `usuarioId` (`usuarioId`);

--
-- Indices de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `datos_personalesId` (`datos_personalesId`),
  ADD KEY `solicitudesId` (`solicitudes_detalles_id2`) USING BTREE;

--
-- Indices de la tabla `solicitudes_detalles`
--
ALTER TABLE `solicitudes_detalles`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `aranceles`
--
ALTER TABLE `aranceles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `bancos`
--
ALTER TABLE `bancos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `bcv`
--
ALTER TABLE `bcv`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT de la tabla `datos_personales`
--
ALTER TABLE `datos_personales`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `datos_verificar`
--
ALTER TABLE `datos_verificar`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `pagos`
--
ALTER TABLE `pagos`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `pnf`
--
ALTER TABLE `pnf`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT de la tabla `preguntas_seguridad`
--
ALTER TABLE `preguntas_seguridad`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `solicitudes_detalles`
--
ALTER TABLE `solicitudes_detalles`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `datos_personales`
--
ALTER TABLE `datos_personales`
  ADD CONSTRAINT `FK_datos_personales_usuarios` FOREIGN KEY (`usuarioId`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `FK_datos_bancarios_solicitudes` FOREIGN KEY (`solicitudes_detalles_id`) REFERENCES `solicitudes_detalles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `preguntas_seguridad`
--
ALTER TABLE `preguntas_seguridad`
  ADD CONSTRAINT `FK_preguntas_seguridad_usuarios` FOREIGN KEY (`usuarioId`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `solicitudes`
--
ALTER TABLE `solicitudes`
  ADD CONSTRAINT `FK_solicitudes_estudiantes_datos_personales` FOREIGN KEY (`datos_personalesId`) REFERENCES `datos_personales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_solicitudes_estudiantes_solicitudes` FOREIGN KEY (`solicitudes_detalles_id2`) REFERENCES `solicitudes_detalles` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
