-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 30-01-2021 a las 01:12:54
-- Versión del servidor: 5.7.24
-- Versión de PHP: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `sanoil`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `so_clientes`
--

CREATE TABLE `so_clientes` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_p` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_m` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `direccion` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `telefono` varchar(10) COLLATE utf8_spanish_ci DEFAULT NULL,
  `correo` varchar(255) COLLATE utf8_spanish_ci DEFAULT NULL,
  `negocio` varchar(300) COLLATE utf8_spanish_ci DEFAULT NULL,
  `tipo_id` int(11) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `so_facturacion`
--

CREATE TABLE `so_facturacion` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `razon_social` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `rfc` varchar(13) COLLATE utf8_spanish_ci NOT NULL,
  `domicilio_fiscal` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `telefono` varchar(10) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `so_insumos`
--

CREATE TABLE `so_insumos` (
  `id` int(11) NOT NULL,
  `nombre_insumos` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descripcion` varchar(300) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `so_permisos`
--

CREATE TABLE `so_permisos` (
  `id` int(11) NOT NULL,
  `permiso` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `so_permisos`
--

INSERT INTO `so_permisos` (`id`, `permiso`) VALUES
(1, 'full-access'),
(2, 'access-denied'),
(3, 'administrador'),
(4, 'vendedor');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `so_productos`
--

CREATE TABLE `so_productos` (
  `id` int(11) NOT NULL,
  `codigo_producto` varchar(30) COLLATE utf8_spanish_ci NOT NULL,
  `nombre_producto` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `descripcion` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `precio` double NOT NULL,
  `mililitros` double DEFAULT NULL,
  `mostrar` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `so_producto_venta`
--

CREATE TABLE `so_producto_venta` (
  `id` int(11) NOT NULL,
  `codigo_venta` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `vendedor_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_total` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `so_roles`
--

CREATE TABLE `so_roles` (
  `id` int(11) NOT NULL,
  `rol` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `permisos_id` varchar(100) COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `so_roles`
--

INSERT INTO `so_roles` (`id`, `rol`, `permisos_id`) VALUES
(1, 'Super Usuario', '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `so_rol_user`
--

CREATE TABLE `so_rol_user` (
  `user_id` int(11) NOT NULL,
  `rol_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `so_rol_user`
--

INSERT INTO `so_rol_user` (`user_id`, `rol_id`) VALUES
(1, 1),
(2, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `so_tipo`
--

CREATE TABLE `so_tipo` (
  `id` int(11) NOT NULL,
  `tipo_cliente` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `descuento` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `so_tipo`
--

INSERT INTO `so_tipo` (`id`, `tipo_cliente`, `descuento`) VALUES
(1, 'Nuveo Cliente', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `so_usuarios`
--

CREATE TABLE `so_usuarios` (
  `id` int(11) NOT NULL,
  `nombre` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_p` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `apellido_m` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `correo` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `password` varchar(150) COLLATE utf8_spanish_ci NOT NULL,
  `fecha` date NOT NULL,
  `mostrar` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Volcado de datos para la tabla `so_usuarios`
--

INSERT INTO `so_usuarios` (`id`, `nombre`, `apellido_p`, `apellido_m`, `correo`, `password`, `fecha`, `mostrar`) VALUES
(1, 'Angel David', 'Escutia', 'Lundez', 'blu_mr.conejo@hotmail.com', 'f87edceb31b76eea4b0c86578c2bdbd7bd9bbcbcb59ab35a7aee77220689bf33132ae2589f978d906a893ae9cd97326c998a5a872ccdb904036776e133e58761', '2020-12-08', 1),
(2, 'ad', 'mi', 'n', 'admin@gmail.com', '7e77279cb4b3e9ce20b50e853e466d5af7cd63faddca227c8ef7b6d5aaece35f340c1f35e9b468bebe73c29da1057bafa2790a5ec05176f3fb07cd3d9a43cb24', '2020-12-09', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `so_ventas`
--

CREATE TABLE `so_ventas` (
  `id` int(11) NOT NULL,
  `codigo_venta` varchar(200) COLLATE utf8_spanish_ci NOT NULL,
  `observacion` varchar(300) COLLATE utf8_spanish_ci NOT NULL,
  `total_venta` double NOT NULL,
  `descuento` double NOT NULL,
  `vendedor_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `factura` tinyint(1) NOT NULL,
  `fecha` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `so_venta_empleado`
--

CREATE TABLE `so_venta_empleado` (
  `id` int(11) NOT NULL,
  `codigo_venta` varchar(100) COLLATE utf8_spanish_ci NOT NULL,
  `venta_id` int(11) NOT NULL,
  `vendedor_id` int(11) NOT NULL,
  `total_venta` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `so_clientes`
--
ALTER TABLE `so_clientes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tipo_id` (`tipo_id`);

--
-- Indices de la tabla `so_facturacion`
--
ALTER TABLE `so_facturacion`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `so_insumos`
--
ALTER TABLE `so_insumos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `so_permisos`
--
ALTER TABLE `so_permisos`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `so_productos`
--
ALTER TABLE `so_productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_producto` (`codigo_producto`);

--
-- Indices de la tabla `so_producto_venta`
--
ALTER TABLE `so_producto_venta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `producto_id` (`producto_id`),
  ADD KEY `vendedor_id` (`vendedor_id`),
  ADD KEY `codigo_venta` (`codigo_venta`);

--
-- Indices de la tabla `so_roles`
--
ALTER TABLE `so_roles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `permisos_id` (`permisos_id`);

--
-- Indices de la tabla `so_rol_user`
--
ALTER TABLE `so_rol_user`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `rol_id` (`rol_id`);

--
-- Indices de la tabla `so_tipo`
--
ALTER TABLE `so_tipo`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `so_usuarios`
--
ALTER TABLE `so_usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `so_ventas`
--
ALTER TABLE `so_ventas`
  ADD PRIMARY KEY (`id`),
  ADD KEY `codigo_venta` (`codigo_venta`),
  ADD KEY `vendedor_id` (`vendedor_id`),
  ADD KEY `cliente_id` (`cliente_id`);

--
-- Indices de la tabla `so_venta_empleado`
--
ALTER TABLE `so_venta_empleado`
  ADD PRIMARY KEY (`id`),
  ADD KEY `venta_id` (`venta_id`),
  ADD KEY `venta_empleado_ibfk_1` (`vendedor_id`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `so_clientes`
--
ALTER TABLE `so_clientes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `so_facturacion`
--
ALTER TABLE `so_facturacion`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `so_insumos`
--
ALTER TABLE `so_insumos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `so_permisos`
--
ALTER TABLE `so_permisos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `so_productos`
--
ALTER TABLE `so_productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `so_producto_venta`
--
ALTER TABLE `so_producto_venta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `so_roles`
--
ALTER TABLE `so_roles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `so_tipo`
--
ALTER TABLE `so_tipo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `so_usuarios`
--
ALTER TABLE `so_usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `so_ventas`
--
ALTER TABLE `so_ventas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `so_venta_empleado`
--
ALTER TABLE `so_venta_empleado`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `so_clientes`
--
ALTER TABLE `so_clientes`
  ADD CONSTRAINT `so_clientes_ibfk_1` FOREIGN KEY (`tipo_id`) REFERENCES `so_tipo` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `so_producto_venta`
--
ALTER TABLE `so_producto_venta`
  ADD CONSTRAINT `so_producto_venta_ibfk_1` FOREIGN KEY (`producto_id`) REFERENCES `so_productos` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `so_producto_venta_ibfk_2` FOREIGN KEY (`vendedor_id`) REFERENCES `so_usuarios` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `so_rol_user`
--
ALTER TABLE `so_rol_user`
  ADD CONSTRAINT `so_rol_user_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `so_usuarios` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `so_rol_user_ibfk_2` FOREIGN KEY (`rol_id`) REFERENCES `so_roles` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `so_ventas`
--
ALTER TABLE `so_ventas`
  ADD CONSTRAINT `so_ventas_ibfk_2` FOREIGN KEY (`vendedor_id`) REFERENCES `so_usuarios` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `so_ventas_ibfk_3` FOREIGN KEY (`cliente_id`) REFERENCES `so_clientes` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `so_venta_empleado`
--
ALTER TABLE `so_venta_empleado`
  ADD CONSTRAINT `so_venta_empleado_ibfk_1` FOREIGN KEY (`vendedor_id`) REFERENCES `so_usuarios` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `so_venta_empleado_ibfk_2` FOREIGN KEY (`venta_id`) REFERENCES `so_ventas` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
