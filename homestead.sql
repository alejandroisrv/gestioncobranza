-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 08, 2019 at 08:59 AM
-- Server version: 10.1.37-MariaDB-0+deb9u1
-- PHP Version: 7.0.33-9+0~20190712.17+debian9~1.gbp3af52c

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `homestead`
--

-- --------------------------------------------------------

--
-- Table structure for table `acuerdos_pagos`
--

CREATE TABLE IF NOT EXISTS `acuerdos_pagos` (
  `id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `venta_id` int(10) UNSIGNED NOT NULL,
  `periodo_pago` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cuotas` int(11) NOT NULL,
  `cuotas_pagadas` int(11) DEFAULT '0',
  `monto` decimal(10,3) DEFAULT NULL,
  `estado` int(2) NOT NULL DEFAULT '0',
  `finished_at` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `acuerdos_pagos_venta_id_foreign` (`venta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `acuerdos_pagos`
--

INSERT INTO `acuerdos_pagos` (`id`, `cliente_id`, `venta_id`, `periodo_pago`, `cuotas`, `cuotas_pagadas`, `monto`, `estado`, `finished_at`, `created_at`, `updated_at`) VALUES
(1, 17, 3, 'Mensual', 2, 1, '150.000', 0, '2019-09-13 03:46:48', '2019-07-15 08:46:48', '2019-07-15 08:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `bodegas`
--

CREATE TABLE IF NOT EXISTS `bodegas` (
  `id` int(11) NOT NULL,
  `sucursal_id` int(10) UNSIGNED NOT NULL,
  `encargado_id` int(10) UNSIGNED NOT NULL,
  `telefono` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `municipio_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `bodegas_municipio_id_foreign` (`municipio_id`),
  KEY `bodegas_sucursal_id_foreign` (`sucursal_id`),
  KEY `bodegas_encargado_id_foreign` (`encargado_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `bodegas`
--

INSERT INTO `bodegas` (`id`, `sucursal_id`, `encargado_id`, `telefono`, `direccion`, `municipio_id`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '04142987911', 'Av Palo alto #33', 1, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `clientes`
--

CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL,
  `sucursal_id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cedula` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `municipio_id` int(10) UNSIGNED NOT NULL,
  `ruta` int(11) NOT NULL DEFAULT '0' COMMENT '0: Sin ruta',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `clientes_municipio_id_foreign` (`municipio_id`),
  KEY `clientes_sucursal_id_foreign` (`sucursal_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `clientes`
--

INSERT INTO `clientes` (`id`, `sucursal_id`, `nombre`, `apellido`, `cedula`, `direccion`, `email`, `telefono`, `municipio_id`, `ruta`, `created_at`, `updated_at`) VALUES
(17, 1, 'Alejandro', 'Sojo', '124545454', 'Av Sucre 1000', 'Alejandro@gmail.com', '2123231231', 1, 1, '2019-06-23 22:11:57', '2019-08-02 08:19:42'),
(18, 1, 'Alfonso', 'urgarte', '10312032103', 'asdsadsa', 'aaasdas@gmail.com', '13123213123131231123', 0, 1, '2019-06-25 05:18:27', '2019-08-02 08:19:42'),
(19, 1, 'Maileny', 'Ruiz', '12454900', 'Av castrovirreina 158', 'asdsadsad', '12121212', 0, 1, '2019-07-07 06:16:36', '2019-08-02 08:19:42'),
(20, 1, 'Persona', 'Otra persona', '1231232131', 'Av Brasil 1121', '1323132', '1232131', 0, 0, '2019-07-07 06:17:01', '2019-08-02 08:19:43');

-- --------------------------------------------------------

--
-- Table structure for table `cobros`
--

CREATE TABLE IF NOT EXISTS `cobros` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `ruta_id` int(11) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `comision` decimal(10,0) NOT NULL DEFAULT '0',
  `fecha_inicio` datetime DEFAULT NULL,
  `fecha_culminacion` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cobros`
--

INSERT INTO `cobros` (`id`, `user_id`, `ruta_id`, `estado`, `comision`, `fecha_inicio`, `fecha_culminacion`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 0, '0', '2019-07-14 07:30:00', '2019-07-14 18:00:00', '2019-07-15 01:53:56', '2019-07-15 01:53:56'),
(2, 2, 1, 2, '0', '2019-07-14 07:30:00', '2019-07-14 18:00:00', '2019-07-15 01:59:27', '2019-07-15 01:59:27'),
(3, 2, 1, 0, '0', '2019-07-14 07:30:00', '2019-07-14 18:00:00', '2019-07-15 01:59:38', '2019-07-15 01:59:38'),
(4, 2, 1, 0, '0', '2019-07-14 07:30:00', '2019-07-14 18:00:00', '2019-07-15 02:02:17', '2019-07-15 02:02:17'),
(5, 2, 1, 1, '0', '2019-07-14 07:30:00', '2019-07-14 18:00:00', '2019-07-15 02:02:22', '2019-07-15 02:02:22'),
(6, 2, 1, 0, '0', '2019-07-14 07:30:00', '2019-07-14 18:00:00', '2019-07-15 02:03:13', '2019-07-15 02:03:13'),
(7, 1, 1, 0, '0', '2019-07-14 07:30:00', '2019-07-23 14:00:00', '2019-07-15 03:44:01', '2019-07-15 03:44:01'),
(8, 2, 1, 0, '0', '2019-07-14 07:30:00', '2019-07-16 18:04:00', '2019-07-15 03:47:15', '2019-07-15 03:47:15'),
(9, 2, 1, 0, '0', '2019-07-14 07:30:00', '2019-07-16 18:04:00', '2019-07-15 03:47:20', '2019-07-15 03:47:20'),
(10, 2, 1, 0, '0', '2019-07-14 07:30:00', '2019-07-16 18:04:00', '2019-07-15 03:48:08', '2019-07-15 03:48:08'),
(11, 2, 1, 0, '0', '2019-07-14 07:30:00', '2019-07-16 18:04:00', '2019-07-15 03:48:21', '2019-07-15 03:48:21'),
(12, 2, 1, 0, '0', '2019-07-14 07:30:00', '2019-07-21 18:04:00', '2019-07-15 03:50:10', '2019-07-15 03:50:10'),
(13, 2, 1, 0, '0', '2019-07-16 07:30:00', '2019-07-16 18:00:00', '2019-07-17 00:23:59', '2019-07-17 00:23:59'),
(14, 2, 1, 0, '0', '2019-07-23 07:30:00', '2019-07-23 18:00:00', '2019-07-23 05:05:51', '2019-07-23 05:05:51'),
(15, 2, 1, 0, '0', '2019-07-23 07:30:00', '2019-07-23 18:00:00', '2019-07-23 22:46:19', '2019-07-23 22:46:19'),
(16, 1, 1, 0, '0', '2019-07-26 07:30:00', '2019-07-26 18:00:00', '2019-07-27 00:42:21', '2019-07-27 00:42:21');

-- --------------------------------------------------------

--
-- Table structure for table `cobros_jornada`
--

CREATE TABLE IF NOT EXISTS `cobros_jornada` (
  `id` int(11) NOT NULL,
  `cobro_id` int(11) NOT NULL,
  `ruta_item_id` int(11) NOT NULL,
  `acuerdo_pago_id` int(11) NOT NULL,
  `monto` decimal(10,3) NOT NULL,
  `comision` decimal(10,3) NOT NULL,
  `estado` int(11) NOT NULL DEFAULT '0',
  `observacion` int(11) DEFAULT NULL,
  `fecha_culminacion` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cobros_jornada`
--

INSERT INTO `cobros_jornada` (`id`, `cobro_id`, `ruta_item_id`, `acuerdo_pago_id`, `monto`, `comision`, `estado`, `observacion`, `fecha_culminacion`) VALUES
(1, 10, 1, 1, '75.000', '7.500', 0, NULL, NULL),
(2, 11, 1, 1, '75.000', '7.500', 0, NULL, NULL),
(3, 12, 1, 1, '75.000', '7.500', 0, NULL, NULL),
(4, 13, 16, 1, '75.000', '7.500', 0, NULL, NULL),
(5, 14, 16, 1, '75.000', '7.500', 0, NULL, NULL),
(6, 15, 16, 1, '75.000', '7.500', 0, NULL, NULL),
(7, 16, 19, 1, '75.000', '7.500', 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `comisiones`
--

CREATE TABLE IF NOT EXISTS `comisiones` (
  `id` int(11) NOT NULL,
  `item_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `tipo` int(11) NOT NULL,
  `monto` decimal(10,3) NOT NULL,
  `estado` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `comision_ventas_venta_id_foreign` (`item_id`),
  KEY `comision_ventas_vendedor_id_foreign` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `comisiones`
--

INSERT INTO `comisiones` (`id`, `item_id`, `user_id`, `tipo`, `monto`, `estado`, `created_at`, `updated_at`) VALUES
(1, 2, 2, 1, '300.000', 'Pagado', '2019-07-15 08:45:40', '2019-07-21 22:41:12'),
(2, 3, 2, 1, '100.000', 'Pagado', '2019-07-15 08:46:48', '2019-07-30 04:32:59');

-- --------------------------------------------------------

--
-- Table structure for table `contabilidad`
--

CREATE TABLE IF NOT EXISTS `contabilidad` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `tipo` int(11) NOT NULL,
  `monto` decimal(10,3) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contabilidad`
--

INSERT INTO `contabilidad` (`id`, `user_id`, `descripcion`, `tipo`, `monto`, `created_at`, `updated_at`) VALUES
(1, 2, 'Gasto ordinario', 3, '2000.000', '2019-08-08 03:57:35', '2019-08-08 03:57:35');

-- --------------------------------------------------------

--
-- Table structure for table `contabilidad_categoria`
--

CREATE TABLE IF NOT EXISTS `contabilidad_categoria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text NOT NULL,
  `operacion` tinyint(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `contabilidad_categoria`
--

INSERT INTO `contabilidad_categoria` (`id`, `descripcion`, `operacion`) VALUES
(1, 'Transaccion realizada por comision de cobro', -1),
(2, 'Transaccion realizada por comision de venta', -1),
(3, 'Gastos diarios', -1);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `movimientos`
--

CREATE TABLE IF NOT EXISTS `movimientos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `operacion` int(11) NOT NULL,
  `descripcion` text NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `movimientos`
--

INSERT INTO `movimientos` (`id`, `producto_id`, `user_id`, `cantidad`, `operacion`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 4, 2, 3, -1, 'Entrega de productos a Pedro Perez', '2019-08-04 00:00:00', '2019-08-04 00:00:00'),
(2, 4, 2, 3, -1, 'Abastecimiento de productos', '2019-08-04 00:00:00', '2019-08-04 00:00:00'),
(3, 4, 2, 10, 1, 'Abastecimiento de productos', '2019-08-05 00:34:50', '2019-08-05 00:34:50'),
(4, 8, 2, 10, 1, 'Abastecimiento de productos', '2019-08-08 03:44:05', '2019-08-08 03:44:05');

-- --------------------------------------------------------

--
-- Table structure for table `movimientos_tipos`
--

CREATE TABLE IF NOT EXISTS `movimientos_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` text NOT NULL,
  `operacion` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `municipios`
--

CREATE TABLE IF NOT EXISTS `municipios` (
  `id` int(11) NOT NULL,
  `municipio` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `sucursal_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `municipios`
--

INSERT INTO `municipios` (`id`, `municipio`, `created_at`, `updated_at`, `sucursal_id`) VALUES
(1, 'Granada', NULL, NULL, 1),
(2, 'Risaralda', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `notificaciones`
--

CREATE TABLE IF NOT EXISTS `notificaciones` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mensaje` text NOT NULL,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_access_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth_access_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_auth_codes`
--

CREATE TABLE IF NOT EXISTS `oauth_auth_codes` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `scopes` text COLLATE utf8mb4_unicode_ci,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `oauth_clients`
--

CREATE TABLE IF NOT EXISTS `oauth_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `secret` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `redirect` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `personal_access_client` tinyint(1) NOT NULL,
  `password_client` tinyint(1) NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_clients`
--

INSERT INTO `oauth_clients` (`id`, `user_id`, `name`, `secret`, `redirect`, `personal_access_client`, `password_client`, `revoked`, `created_at`, `updated_at`) VALUES
(1, NULL, 'Laravel Personal Access Client', 'K8Z2PEfcs6BKVaofV9ZyVeIUtOLacucyYju0DGH1', 'http://localhost', 1, 0, 0, '2019-06-14 11:34:06', '2019-06-14 11:34:06'),
(2, NULL, 'Laravel Password Grant Client', 'ViNDIofLiItDmgep5EYVc28Cn1iQo7UkboZHuGGg', 'http://localhost', 0, 1, 0, '2019-06-14 11:34:06', '2019-06-14 11:34:06');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_personal_access_clients`
--

CREATE TABLE IF NOT EXISTS `oauth_personal_access_clients` (
  `id` int(10) UNSIGNED NOT NULL,
  `client_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `oauth_personal_access_clients`
--

INSERT INTO `oauth_personal_access_clients` (`id`, `client_id`, `created_at`, `updated_at`) VALUES
(1, 1, '2019-06-14 11:34:06', '2019-06-14 11:34:06');

-- --------------------------------------------------------

--
-- Table structure for table `oauth_refresh_tokens`
--

CREATE TABLE IF NOT EXISTS `oauth_refresh_tokens` (
  `id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `access_token_id` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `revoked` tinyint(1) NOT NULL,
  `expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pagos_clientes`
--

CREATE TABLE IF NOT EXISTS `pagos_clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `acuerdo_pago_id` int(11) NOT NULL,
  `monto` decimal(11,3) NOT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `pagos_clientes`
--

INSERT INTO `pagos_clientes` (`id`, `cliente_id`, `venta_id`, `acuerdo_pago_id`, `monto`, `created_at`, `updated_at`) VALUES
(1, 17, 3, 1, '100.000', '2019-08-01 23:08:00', '2019-08-01 23:08:00');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permissions`
--

CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_role`
--

CREATE TABLE IF NOT EXISTS `permission_role` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `permission_user`
--

CREATE TABLE IF NOT EXISTS `permission_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `permission_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `productos`
--

CREATE TABLE IF NOT EXISTS `productos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `bodega_id` int(10) UNSIGNED NOT NULL,
  `sucursal_id` int(10) UNSIGNED NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_costo` decimal(10,3) NOT NULL,
  `precio_credito` decimal(10,2) NOT NULL,
  `precio_contado` decimal(10,3) NOT NULL,
  `comision` decimal(10,3) NOT NULL,
  `cantidad` int(11) DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `productos`
--

INSERT INTO `productos` (`id`, `bodega_id`, `sucursal_id`, `nombre`, `descripcion`, `precio_costo`, `precio_credito`, `precio_contado`, `comision`, `cantidad`, `created_at`, `updated_at`) VALUES
(4, 1, 1, 'Armario grande', 'Descripcion del armario', '100.000', '100.00', '100.000', '1000.000', 20, '2019-06-18 09:17:57', '2019-08-05 05:34:50'),
(5, 1, 1, 'Armario mediano', 'Armario mediano para televisor', '100.000', '1000.00', '100.000', '100.000', 10, '2019-06-18 09:18:18', '2019-07-30 06:38:39'),
(6, 1, 1, 'Televisor de 24 \'\'', 'Televisor', '1033.000', '1123.00', '232.000', '100.000', 9, '2019-06-18 09:25:17', '2019-07-30 06:38:39'),
(7, 1, 1, 'casa', 'asdsadsasa', '1010.000', '150.00', '100.000', '100.000', 11, '2019-07-01 17:37:14', '2019-07-30 06:38:39'),
(8, 1, 1, 'Producto nuevo', 'Esto es un producto nuevo', '150.000', '1100.00', '1000.000', '100.000', 10, '2019-08-08 08:43:53', '2019-08-08 08:44:27');

-- --------------------------------------------------------

--
-- Table structure for table `productos_entregadas`
--

CREATE TABLE IF NOT EXISTS `productos_entregadas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vendedor_id` int(11) NOT NULL,
  `bodega_id` int(11) NOT NULL,
  `comentario` text,
  `estado` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `productos_entregadas`
--

INSERT INTO `productos_entregadas` (`id`, `vendedor_id`, `bodega_id`, `comentario`, `estado`, `created_at`, `updated_at`) VALUES
(2, 1, 1, NULL, 0, '2019-08-04 01:03:23', '2019-08-04'),
(3, 1, 1, NULL, 0, '2019-08-04 01:04:03', '2019-08-04');

-- --------------------------------------------------------

--
-- Table structure for table `productos_vendedores`
--

CREATE TABLE IF NOT EXISTS `productos_vendedores` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `producto_id` int(10) UNSIGNED NOT NULL,
  `detalle` int(11) NOT NULL,
  `producto` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `estado` int(11) DEFAULT NULL,
  `comentario` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `productos_vendedores`
--

INSERT INTO `productos_vendedores` (`id`, `producto_id`, `detalle`, `producto`, `cantidad`, `estado`, `comentario`, `created_at`, `updated_at`) VALUES
(1, 5, 2, NULL, 3, NULL, NULL, '2019-08-04 06:03:23', '2019-08-04 06:03:23'),
(2, 4, 3, NULL, 3, NULL, NULL, '2019-08-04 06:04:03', '2019-08-04 06:04:03');

-- --------------------------------------------------------

--
-- Table structure for table `productos_ventas`
--

CREATE TABLE IF NOT EXISTS `productos_ventas` (
  `id` int(11) NOT NULL,
  `producto_id` int(10) NOT NULL,
  `venta_id` int(10) UNSIGNED NOT NULL,
  `producto` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cantidad` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `productos_ventas`
--

INSERT INTO `productos_ventas` (`id`, `producto_id`, `venta_id`, `producto`, `cantidad`, `created_at`, `updated_at`) VALUES
(1, 4, 1, 'Armario grande', 10, '2019-07-14 07:29:11', '2019-07-14 07:29:11'),
(2, 5, 1, 'Armario mediano', 2, '2019-07-14 07:29:11', '2019-07-14 07:29:11'),
(3, 7, 2, 'casa', 2, '2019-07-14 07:33:52', '2019-07-14 07:33:52'),
(4, 6, 1, 'Televisor de 24 \'\'', 10, '2019-07-14 07:55:51', '2019-07-14 07:55:51'),
(5, 5, 1, 'Armario mediano', 2, '2019-07-14 07:55:51', '2019-07-14 07:55:51'),
(6, 6, 2, 'Televisor de 24 \'\'', 4, '2019-07-14 07:57:58', '2019-07-14 07:57:58'),
(7, 6, 3, 'Televisor de 24 \'\'', 10, '2019-07-15 02:42:40', '2019-07-15 02:42:40'),
(8, 6, 4, 'Televisor de 24 \'\'', 10, '2019-07-15 02:48:18', '2019-07-15 02:48:18'),
(9, 6, 5, 'Televisor de 24 \'\'', 10, '2019-07-15 02:48:33', '2019-07-15 02:48:33'),
(10, 6, 6, 'Televisor de 24 \'\'', 10, '2019-07-15 02:49:00', '2019-07-15 02:49:00'),
(11, 6, 7, 'Televisor de 24 \'\'', 10, '2019-07-15 02:49:18', '2019-07-15 02:49:18'),
(12, 6, 8, 'Televisor de 24 \'\'', 10, '2019-07-15 02:49:57', '2019-07-15 02:49:57'),
(13, 6, 9, 'Televisor de 24 \'\'', 10, '2019-07-15 02:51:16', '2019-07-15 02:51:16'),
(14, 6, 10, 'Televisor de 24 \'\'', 10, '2019-07-15 02:53:20', '2019-07-15 02:53:20'),
(15, 6, 11, 'Televisor de 24 \'\'', 10, '2019-07-15 02:53:21', '2019-07-15 02:53:21'),
(16, 6, 12, 'Televisor de 24 \'\'', 10, '2019-07-15 02:53:56', '2019-07-15 02:53:56'),
(17, 6, 13, 'Televisor de 24 \'\'', 2, '2019-07-15 03:31:52', '2019-07-15 03:31:52'),
(18, 4, 13, 'Armario grande', 10, '2019-07-15 03:31:52', '2019-07-15 03:31:52'),
(19, 6, 14, 'Televisor de 24 \'\'', 2, '2019-07-15 03:31:53', '2019-07-15 03:31:53'),
(20, 4, 14, 'Armario grande', 10, '2019-07-15 03:31:53', '2019-07-15 03:31:53'),
(21, 5, 15, 'Armario mediano', 2, '2019-07-15 04:29:16', '2019-07-15 04:29:16'),
(22, 5, 16, 'Armario mediano', 2, '2019-07-15 04:29:22', '2019-07-15 04:29:22'),
(23, 5, 17, 'Armario mediano', 2, '2019-07-15 04:29:43', '2019-07-15 04:29:43'),
(24, 6, 18, 'Televisor de 24 \'\'', 2, '2019-07-15 04:30:56', '2019-07-15 04:30:56'),
(25, 7, 18, 'casa', 3, '2019-07-15 04:30:57', '2019-07-15 04:30:57'),
(26, 6, 2, 'Televisor de 24 \'\'', 3, '2019-07-15 08:45:40', '2019-07-15 08:45:40'),
(27, 7, 3, 'casa', 1, '2019-07-15 08:46:48', '2019-07-15 08:46:48');

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `special` enum('all-access','no-access') COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `slug`, `description`, `created_at`, `updated_at`, `special`) VALUES
(1, 'Administrador', 'admin', 'Administrador de la plataforma', NULL, NULL, NULL),
(0, 'Administrador de bodegas', 'administrador-de-bodegas', 'Encargado de una bodega', '2019-08-29 05:00:00', '2019-08-23 05:00:00', NULL),
(0, 'Cobrador', 'cobrador', 'Persona encargada de hacer la gestion de cobranza', '2019-08-01 05:00:00', '2019-08-01 05:00:00', NULL),
(0, 'Vendedor', 'vendedor', 'Vendedor persona encargada de cerrar las ventas', '2019-08-01 05:00:00', '2019-08-23 05:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `role_user`
--

CREATE TABLE IF NOT EXISTS `role_user` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role_id` bigint(20) UNSIGNED NOT NULL,
  `user_id` bigint(20) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `role_user`
--

INSERT INTO `role_user` (`id`, `role_id`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 1, 18, NULL, NULL),
(2, 1, 3, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `rutas`
--

CREATE TABLE IF NOT EXISTS `rutas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `municipio_id` int(11) DEFAULT NULL,
  `nombre` text,
  `created_at` date DEFAULT NULL,
  `updated_at` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `rutas`
--

INSERT INTO `rutas` (`id`, `municipio_id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 1, 'Ruta principal', '2019-07-14', '2019-08-02');

-- --------------------------------------------------------

--
-- Table structure for table `ruta_items`
--

CREATE TABLE IF NOT EXISTS `ruta_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ruta_id` int(11) NOT NULL,
  `cliente_id` int(11) NOT NULL,
  `orden` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ruta_items`
--

INSERT INTO `ruta_items` (`id`, `ruta_id`, `cliente_id`, `orden`) VALUES
(4, 1, 17, 1),
(5, 1, 18, 2),
(6, 1, 19, 3),
(7, 1, 20, 4);

-- --------------------------------------------------------

--
-- Table structure for table `sucursales`
--

CREATE TABLE IF NOT EXISTS `sucursales` (
  `id` int(11) NOT NULL,
  `encargado_id` int(10) UNSIGNED NOT NULL,
  `telefono` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `municipio_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sucursales`
--

INSERT INTO `sucursales` (`id`, `encargado_id`, `telefono`, `direccion`, `municipio_id`, `created_at`, `updated_at`) VALUES
(1, 2, '111', 'asdada', 1, '2019-06-19 17:14:36', '2019-06-19 17:14:36');

-- --------------------------------------------------------

--
-- Table structure for table `sucursal_enalce`
--

CREATE TABLE IF NOT EXISTS `sucursal_enalce` (
  `sucursal_id` int(11) NOT NULL,
  `sucursal_enlace_id` int(11) NOT NULL,
  `sucursal_enlace_type` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tipos_ventas`
--

CREATE TABLE IF NOT EXISTS `tipos_ventas` (
  `id` int(11) NOT NULL,
  `descripcion` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `tipos_ventas`
--

INSERT INTO `tipos_ventas` (`id`, `descripcion`) VALUES
(1, 'de contado'),
(2, 'a crédito ');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `sucursal_id` int(11) DEFAULT NULL,
  `bodega_id` int(11) DEFAULT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cedula` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `api_token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `sucursal_id`, `bodega_id`, `name`, `cedula`, `telefono`, `direccion`, `email`, `api_token`, `password`, `remember_token`, `email_verified_at`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'Pedro Perez', NULL, NULL, NULL, 'usuario', 'QZKS4P6ovpGrnjmkOy7br3qw8PA2YYyQIZFqkMm5NSeqrGkOf4', '$2y$10$hP3s1DP5tlG/xv/bDGLsv.n0MBSIynOZxvvSPllViwdgvwsHFeBM6', NULL, NULL, '2019-06-14 11:34:48', '2019-06-14 11:34:48'),
(2, 1, 1, 'Alejandro Sojo', NULL, NULL, NULL, 'admin', '1WQu2uyXO1gc5fJJ2G0B7DxghZsn8HtnwaAZg2AIUIEWcGNby2n29N9DvR2j', '$2y$10$3PYr4PWVfgCSKyHPRvPPm.SkTCMzNsprbV.epSkHNtTNHDUkj8A6K', NULL, NULL, '2019-06-18 05:44:17', '2019-08-08 17:53:32'),
(3, NULL, NULL, 'JUAN DAVID', '121212', '3103221231', 'CLL 2', 'JUNDA', '0', NULL, NULL, NULL, '2019-07-24 03:48:52', '2019-07-24 03:48:52');

-- --------------------------------------------------------

--
-- Table structure for table `ventas`
--

CREATE TABLE IF NOT EXISTS `ventas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) UNSIGNED NOT NULL,
  `cliente_id` int(10) UNSIGNED NOT NULL,
  `tipo_venta` int(10) UNSIGNED NOT NULL,
  `total` decimal(10,3) NOT NULL,
  `subtotal` decimal(10,3) NOT NULL DEFAULT '0.000',
  `abono` decimal(10,3) NOT NULL DEFAULT '0.000',
  `descuento` decimal(10,3) NOT NULL DEFAULT '0.000',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ventas`
--

INSERT INTO `ventas` (`id`, `user_id`, `cliente_id`, `tipo_venta`, `total`, `subtotal`, `abono`, `descuento`, `created_at`, `updated_at`) VALUES
(1, 2, 18, 1, '3369.000', '0.000', '0.000', '0.000', '2019-07-17 08:44:26', '2019-07-15 08:44:26'),
(2, 2, 18, 1, '3369.000', '0.000', '0.000', '0.000', '2019-07-15 08:45:39', '2019-07-15 08:45:39'),
(3, 2, 17, 2, '150.000', '0.000', '0.000', '0.000', '2019-07-15 08:46:48', '2019-07-15 08:46:48');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
