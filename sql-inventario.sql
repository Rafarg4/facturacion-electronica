-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         5.7.33 - MySQL Community Server (GPL)
-- SO del servidor:              Win64
-- HeidiSQL Versión:             11.2.0.6213
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

-- Volcando estructura para tabla facturacion.cajas
CREATE TABLE IF NOT EXISTS `cajas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `apertura` int(11) NOT NULL,
  `cierre` int(11) NOT NULL,
  `fecha` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.cajas: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `cajas` DISABLE KEYS */;
INSERT INTO `cajas` (`id`, `nombre`, `descripcion`, `apertura`, `cierre`, `fecha`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Caja 1', 'Caja de cobros', 90000, 5000, '2025-07-16 19:48:51', 'Activo', '2025-05-07 21:52:23', '2025-07-16 19:48:51', NULL),
	(2, 'Caja 2', 'Caja para cobros diarios', 900000, 0, '2025-05-13 22:13:43', 'Activo', '2025-05-07 21:53:11', '2025-05-13 22:13:43', NULL);
/*!40000 ALTER TABLE `cajas` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.categorias
CREATE TABLE IF NOT EXISTS `categorias` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.categorias: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `categorias` DISABLE KEYS */;
INSERT INTO `categorias` (`id`, `nombre`, `descripcion`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Lacteos', 'una descripcion', '2025-05-01 14:39:52', '2025-05-01 14:39:52', NULL),
	(2, 'Bebidas', 'una descripcion', '2025-05-01 14:40:08', '2025-05-01 14:40:08', NULL),
	(3, 'Frituras', 'una descripcion', '2025-05-01 15:42:50', '2025-05-01 15:42:50', NULL);
/*!40000 ALTER TABLE `categorias` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.cierres
CREATE TABLE IF NOT EXISTS `cierres` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_usuario` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_caja` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto_inicial` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto_final` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_apertura` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_cierre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `observaciones` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.cierres: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `cierres` DISABLE KEYS */;
INSERT INTO `cierres` (`id`, `id_usuario`, `id_caja`, `monto_inicial`, `monto_final`, `fecha_apertura`, `fecha_cierre`, `observaciones`, `created_at`, `updated_at`) VALUES
	(1, '4', '1', '46000', '46000', '2025-05-08', '2025-05-08', 'kk', NULL, NULL),
	(4, '4', '1', '0', '0', '2025-05-09', '2025-05-09', 'prueba de cierre 2', NULL, NULL),
	(5, '4', '1', '1200', '1200', '2025-05-09', '2025-05-09', 'prueba de cierre', NULL, NULL),
	(6, '4', '1', '29200', '29200', '2025-05-09', '2025-05-09', 'prueba3', NULL, NULL),
	(7, '4', '1', '41200', '29200', '2025-05-09', '2025-05-09', 'prueba final de cierre', NULL, NULL),
	(8, '4', '1', '29200', '47200', '2025-05-09', '2025-05-09', 'prueba de cierre', NULL, NULL),
	(9, '4', '1', '47200', '5000', '2025-05-13', '2025-05-13', 'prueba de cierre', NULL, NULL),
	(10, '4', '1', '5000', '5000', '2025-05-13', '2025-05-13', 'prueba de cierre', NULL, NULL),
	(11, '4', '1', '5000', '5000', '2025-05-13', '2025-05-13', 'prueba de cierre', NULL, NULL),
	(12, '4', '1', '50000', '5000', '2025-05-13', '2025-05-13', 'prueba de cierre 3', NULL, NULL);
/*!40000 ALTER TABLE `cierres` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.clientes: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`id`, `nombre`, `apellido`, `ci`, `telefono`, `correo`, `direccion`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Maria', 'Aquino', '123453', '0981278343', 'maria@gmail.com', 'San Pedro', '2025-05-01 19:23:44', '2025-05-01 19:23:44', NULL),
	(2, 'Marcos', 'Bordon', '344324', '09837438473', 'marcos@gmail.com', 'San Miguel', '2025-05-01 19:24:15', '2025-05-01 19:24:15', NULL),
	(3, 'Carmen', 'Escobar', '45393823', '0987344732', 'carmen@gmail.com', 'Barrio San Isidro', '2025-05-02 21:13:02', '2025-05-02 21:13:02', NULL),
	(4, 'Rafael', 'Escobar Paniagua', '4584860-2', '0981002965', 'rep141998@gmail.com', 'Encarnacion', '2025-05-06 21:37:27', '2025-05-06 21:37:27', NULL);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.cobros
CREATE TABLE IF NOT EXISTS `cobros` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `numero_comprobante` int(11) NOT NULL,
  `id_cliente` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_venta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_cobro` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cajero` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_caja` int(11) NOT NULL,
  `observacion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.cobros: ~9 rows (aproximadamente)
/*!40000 ALTER TABLE `cobros` DISABLE KEYS */;
INSERT INTO `cobros` (`id`, `numero_comprobante`, `id_cliente`, `id_venta`, `fecha_cobro`, `cajero`, `estado`, `id_caja`, `observacion`, `total`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 0, '3', '10', '2025-05-08', '1', 'Activo', 1, 'observacion', 0, '2025-05-08 14:43:57', '2025-05-08 14:43:57', NULL),
	(2, 0, '3', '10', '2025-05-08', '1', 'Activo', 0, 'observacion', 0, '2025-05-08 14:50:12', '2025-05-08 14:50:12', NULL),
	(3, 0, '3', '10', '2025-05-08', '1', 'Activo', 0, 'pago parcial', 0, '2025-05-08 17:44:23', '2025-05-08 17:44:23', NULL),
	(4, 0, '3', '10', '2025-05-09', '4', 'Activo', 1, 'pago parcial de cuota', 200, '2025-05-09 17:48:22', '2025-05-09 17:48:22', NULL),
	(5, 1, '3', '10', '2025-05-09', '4', 'Activo', 1, 'observacion', 1000, '2025-05-09 18:43:52', '2025-05-09 18:43:52', NULL),
	(10, 2, '4', '13', '2025-05-09', '4', 'Activo', 1, 'observacion', 12000, '2025-05-09 21:18:36', '2025-05-09 21:18:36', NULL),
	(11, 3, '4', '13', '2025-05-09', '4', 'Activo', 1, 'observacion', 6000, '2025-05-09 21:49:10', '2025-05-09 21:49:10', NULL),
	(12, 4, '4', '13', '2025-05-11', '4', 'Anulado', 1, 'observacion', 5000, '2025-05-11 20:33:55', '2025-05-11 20:33:55', NULL),
	(13, 5, '4', '13', '2025-05-13', '4', 'Activo', 1, 'observacion', 5000, '2025-05-13 22:17:57', '2025-05-13 22:17:57', NULL);
/*!40000 ALTER TABLE `cobros` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.cobro_detalles
CREATE TABLE IF NOT EXISTS `cobro_detalles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_cobro` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_venta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `nro_cuota` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `saldo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_vencimiento` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.cobro_detalles: ~9 rows (aproximadamente)
/*!40000 ALTER TABLE `cobro_detalles` DISABLE KEYS */;
INSERT INTO `cobro_detalles` (`id`, `id_cobro`, `id_venta`, `nro_cuota`, `monto`, `saldo`, `estado`, `fecha_vencimiento`, `created_at`, `updated_at`) VALUES
	(1, '1', '10', '1', '12500', '10000', 'Parcial', '2025-06-01', '2025-05-08 14:43:57', '2025-05-08 14:43:57'),
	(2, '2', '10', '1', '12500', '2500', 'Pagado', '2025-06-01', '2025-05-08 14:50:14', '2025-05-08 14:50:14'),
	(3, '3', '10', '2', '12500', '5000', 'Parcial', '2025-07-01', '2025-05-08 17:44:24', '2025-05-08 17:44:24'),
	(4, '4', '10', '2', '12500', '500', 'Parcial', '2025-07-01', '2025-05-09 17:48:22', '2025-05-09 17:48:22'),
	(5, '5', '10', '2', '12500', '1000', 'Parcial', '2025-07-01', '2025-05-09 18:43:52', '2025-05-09 18:43:52'),
	(10, '10', '13', '1', '28000', '12000', 'Parcial', '2025-06-08', '2025-05-09 21:18:36', '2025-05-09 21:18:36'),
	(11, '11', '13', '1', '28000', '6000', 'Parcial', '2025-06-08', '2025-05-09 21:49:10', '2025-05-09 21:49:10'),
	(12, '12', '13', '1', '28000', '5000', 'Anulado', '2025-06-08', '2025-05-11 20:33:55', '2025-05-11 20:33:55'),
	(13, '13', '13', '1', '28000', '5000', 'Parcial', '2025-06-08', '2025-05-13 22:17:57', '2025-05-13 22:17:57');
/*!40000 ALTER TABLE `cobro_detalles` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.compras
CREATE TABLE IF NOT EXISTS `compras` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pedido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_compra` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_comprobante` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_comprobante` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `forma_pago` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `observacion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.compras: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `compras` DISABLE KEYS */;
INSERT INTO `compras` (`id`, `id_pedido`, `fecha_compra`, `tipo_comprobante`, `numero_comprobante`, `total`, `forma_pago`, `estado`, `observacion`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, '2', '2025-05-15', 'Recibo', '2', '75000', 'Efectivo', 'Activo', 'compra para reestablecer', '2025-05-15 13:57:16', '2025-05-15 13:57:16', NULL),
	(2, '3', '2025-05-15', 'Factura', '12345', '120000', 'Efectivo', 'Activo', 'compra de coca para venta', '2025-05-15 18:42:48', '2025-05-15 18:42:48', NULL),
	(3, '3', '2025-05-15', 'Factura', '12345', '120000', 'Efectivo', 'Activo', 'compra de coca para venta', '2025-05-15 18:43:03', '2025-05-15 18:43:03', NULL),
	(4, '3', '2025-05-15', 'Recibo', '45645', '120000', 'Transferencia', 'Activo', 'pago por nuevo', '2025-05-15 18:50:04', '2025-05-15 18:50:04', NULL),
	(5, '4', '2025-07-18', 'Recibo', '534', '4110000', 'Efectivo', 'Activo', 'prueba de detalles', '2025-07-18 19:18:08', '2025-07-18 19:18:08', NULL),
	(6, '5', '2025-07-18', 'Factura', '777', '87500', 'Efectivo', 'Anulado', 'prueba de detalles de compra', '2025-07-18 19:39:45', '2025-07-18 20:18:53', NULL);
/*!40000 ALTER TABLE `compras` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.compra_detalles
CREATE TABLE IF NOT EXISTS `compra_detalles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_compra` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_pedido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_producto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_unitario` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.compra_detalles: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `compra_detalles` DISABLE KEYS */;
INSERT INTO `compra_detalles` (`id`, `id_compra`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`, `subtotal`, `estado`, `created_at`, `updated_at`) VALUES
	(1, '6', '5', '4', '5', '5500', '27500', 'Anulado', '2025-07-18 19:39:46', '2025-07-18 20:18:53'),
	(2, '6', '5', '1', '4', '15000', '60000', 'Anulado', '2025-07-18 19:39:46', '2025-07-18 20:18:53');
/*!40000 ALTER TABLE `compra_detalles` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.cotizacions
CREATE TABLE IF NOT EXISTS `cotizacions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tipo_moneda` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `compra` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `venta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.cotizacions: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `cotizacions` DISABLE KEYS */;
INSERT INTO `cotizacions` (`id`, `tipo_moneda`, `compra`, `venta`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'GS', '1200', '1300', '2026-06-08 08:53:54', '2026-06-08 08:53:54', NULL);
/*!40000 ALTER TABLE `cotizacions` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.detalle_ventas
CREATE TABLE IF NOT EXISTS `detalle_ventas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_venta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_producto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.detalle_ventas: ~12 rows (aproximadamente)
/*!40000 ALTER TABLE `detalle_ventas` DISABLE KEYS */;
INSERT INTO `detalle_ventas` (`id`, `id_venta`, `id_producto`, `cantidad`, `precio_unitario`, `subtotal`, `created_at`, `updated_at`) VALUES
	(14, '8', '1', 2, '10000', '20000', NULL, NULL),
	(15, '8', '2', 1, '23000', '23000', NULL, NULL),
	(16, '8', '3', 1, '5000', '5000', NULL, NULL),
	(17, '9', '1', 1, '10000', '10000', NULL, NULL),
	(18, '9', '3', 1, '5000', '5000', NULL, NULL),
	(19, '10', '1', 1, '10000', '10000', NULL, NULL),
	(20, '10', '3', 3, '5000', '15000', NULL, NULL),
	(21, '11', '1', 4, '10000', '40000', NULL, NULL),
	(22, '11', '2', 4, '23000', '92000', NULL, NULL),
	(23, '12', '2', 2, '23000', '46000', NULL, NULL),
	(24, '13', '3', 1, '5000', '5000', NULL, NULL),
	(25, '13', '2', 1, '23000', '23000', NULL, NULL);
/*!40000 ALTER TABLE `detalle_ventas` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.empresas
CREATE TABLE IF NOT EXISTS `empresas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ruc` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `logo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` text COLLATE utf8mb4_unicode_ci,
  `direccion` text COLLATE utf8mb4_unicode_ci,
  `timbrado` text COLLATE utf8mb4_unicode_ci,
  `telefono` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.empresas: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` (`id`, `nombre`, `ruc`, `descripcion`, `logo`, `correo`, `direccion`, `timbrado`, `telefono`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'CASA MIRÓ', '80112637-1', 'CASA MIRÓ SA PERFUMERIA COSMÉTICOS', 'imagen empresa.jpg', NULL, NULL, NULL, NULL, '2025-05-07 22:07:16', '2026-06-08 14:24:46', '2026-06-08 14:24:46'),
	(2, 'CASA MIRÓ', '80112637-1', 'CASA MIRÓ SA PERFUMERIA COSMÉTICOS.', '1780944581_imagen_empresa.jpg', 'casamiro@gmail.com', 'Serafina Davalos y, Encarnación 070124', '12345', '0991 465100', '2026-06-08 14:49:41', '2026-06-08 15:09:37', NULL);
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.failed_jobs
CREATE TABLE IF NOT EXISTS `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.failed_jobs: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.migrations: ~23 rows (aproximadamente)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
	(1, '2014_10_12_100000_create_password_resets_table', 1),
	(2, '2019_08_19_000000_create_failed_jobs_table', 1),
	(3, '2019_12_14_000001_create_personal_access_tokens_table', 1),
	(4, '2022_02_11_200905_create_permission_tables', 1),
	(5, '2022_02_12_000000_create_users_table', 1),
	(6, '2025_05_01_133046_create_clientes_table', 1),
	(7, '2025_05_01_140633_create_categorias_table', 2),
	(8, '2025_05_01_141516_create_proveedors_table', 3),
	(9, '2025_05_01_143122_create_productos_table', 4),
	(10, '2025_05_01_181152_create_ventas_table', 5),
	(11, '2025_05_01_182206_create_detalle_ventas_table', 6),
	(12, '2025_05_02_184031_create_saldo_ventas_table', 7),
	(13, '2025_05_02_195203_create_cobros_table', 8),
	(14, '2025_05_07_213637_create_cajas_table', 9),
	(15, '2025_05_07_215042_create_empresas_table', 10),
	(16, '2025_05_08_135458_create_cobro_detalles_table', 11),
	(17, '2025_05_08_210754_create_cierres_table', 12),
	(18, '2025_05_11_194208_create_compras_table', 13),
	(19, '2025_05_14_110019_create_pedidos_table', 14),
	(20, '2025_05_14_111549_create_pedido_detalles_table', 15),
	(21, '2025_07_18_192222_create_compra_detalles_table', 16),
	(22, '2026_05_29_201404_create_cotizacions_table', 17),
	(23, '2026_06_08_101636_create_rubros_table', 18);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.model_has_permissions
CREATE TABLE IF NOT EXISTS `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.model_has_permissions: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.model_has_roles
CREATE TABLE IF NOT EXISTS `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.model_has_roles: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` (`role_id`, `model_type`, `model_id`) VALUES
	(1, 'App\\Models\\User', 1),
	(2, 'App\\Models\\User', 2),
	(4, 'App\\Models\\User', 3),
	(1, 'App\\Models\\User', 4);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.password_resets
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.password_resets: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.pedidos
CREATE TABLE IF NOT EXISTS `pedidos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_proveedor` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.pedidos: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `pedidos` DISABLE KEYS */;
INSERT INTO `pedidos` (`id`, `id_proveedor`, `fecha`, `total`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(2, '2', '2025-05-15', '75000', 'Anulado', '2025-05-15 12:36:45', '2025-07-15 19:54:29', NULL),
	(3, '1', '2025-05-15', '120000', 'Aplicado', '2025-05-15 18:34:28', '2025-05-15 18:34:28', NULL),
	(4, '1', '2025-07-15', '4110000', 'Pendiente', '2025-07-15 20:26:52', '2025-07-15 20:26:52', NULL),
	(5, '2', '2025-07-18', '87500', 'Aplicado', '2025-07-18 19:39:04', '2025-07-18 19:39:04', NULL);
/*!40000 ALTER TABLE `pedidos` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.pedido_detalles
CREATE TABLE IF NOT EXISTS `pedido_detalles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_pedido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_producto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtotal` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.pedido_detalles: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `pedido_detalles` DISABLE KEYS */;
INSERT INTO `pedido_detalles` (`id`, `id_pedido`, `id_producto`, `cantidad`, `precio_unitario`, `subtotal`, `created_at`, `updated_at`) VALUES
	(1, '2', '1', 5, '10000', '50000', '2025-05-15 12:36:45', '2025-05-15 12:36:45'),
	(2, '2', '3', 5, '5000', '25000', '2025-05-15 12:36:45', '2025-05-15 12:36:45'),
	(3, '3', '1', 10, '12000', '120000', '2025-05-15 18:34:28', '2025-05-15 18:34:28'),
	(4, '4', '2', 5, '70000', '350000', '2025-07-15 20:26:53', '2025-07-15 20:26:53'),
	(5, '4', '3', 6, '50000', '300000', '2025-07-15 20:26:53', '2025-07-15 20:26:53'),
	(6, '4', '1', 4, '40000', '160000', '2025-07-15 20:26:53', '2025-07-15 20:26:53'),
	(7, '4', '1', 10, '90000', '900000', '2025-07-15 20:26:53', '2025-07-15 20:26:53'),
	(8, '4', '3', 20, '120000', '2400000', '2025-07-15 20:26:53', '2025-07-15 20:26:53'),
	(9, '5', '4', 5, '5500', '27500', '2025-07-18 19:39:04', '2025-07-18 19:39:04'),
	(10, '5', '1', 4, '15000', '60000', '2025-07-18 19:39:04', '2025-07-18 19:39:04');
/*!40000 ALTER TABLE `pedido_detalles` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.permissions
CREATE TABLE IF NOT EXISTS `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.permissions: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'crear', 'web', '2025-05-01 13:51:51', '2025-05-01 13:51:51'),
	(2, 'editar', 'web', '2025-05-01 13:51:51', '2025-05-01 13:51:51'),
	(3, 'eliminar', 'web', '2025-05-01 13:51:51', '2025-05-01 13:51:51'),
	(4, 'usuario', 'web', '2025-05-01 13:51:52', '2025-05-01 13:51:52'),
	(5, 'administrador', 'web', '2025-05-01 13:51:52', '2025-05-01 13:51:52');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.personal_access_tokens
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.personal_access_tokens: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.productos
CREATE TABLE IF NOT EXISTS `productos` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_categoria` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_rubro` int(11) DEFAULT NULL,
  `cantidad` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `cantidad_minima` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_venta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `precio_compra` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_proveedor` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.productos: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `productos` DISABLE KEYS */;
INSERT INTO `productos` (`id`, `nombre`, `descripcion`, `id_categoria`, `id_rubro`, `cantidad`, `cantidad_minima`, `precio_venta`, `precio_compra`, `estado`, `id_proveedor`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Coca Cola', 'Coca cola de 1 litro', '2', NULL, '36', '5', '10000', '15000', 'Activo', '1', '2025-05-01 14:56:46', '2025-05-01 14:56:46', NULL),
	(2, 'Papas fritas lays', 'papas de 500 gramos', '3', NULL, '12', '5', '23000', '18000', 'Activo', '2', '2025-05-01 15:44:07', '2025-05-01 15:44:07', NULL),
	(3, 'Harina', 'harian de 1 klio', '3', NULL, '16', '5', '5000', '5000', 'Activo', '2', '2025-05-01 22:02:08', '2025-05-01 22:02:08', NULL),
	(4, 'Jugo Ades', 'Jugo de soja', '2', NULL, '10', '5', '5000', '5500', 'Activo', NULL, '2025-07-18 19:38:04', '2025-07-18 19:38:04', NULL),
	(5, 'prueba 1', 'pruebaaa', '1', 3, '12', '1', '1200', '1300', 'Activo', NULL, '2026-06-08 10:54:44', '2026-06-08 10:54:44', NULL);
/*!40000 ALTER TABLE `productos` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.proveedors
CREATE TABLE IF NOT EXISTS `proveedors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `apellido` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ci` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `correo` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `direccion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `telefono` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `compania` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.proveedors: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `proveedors` DISABLE KEYS */;
INSERT INTO `proveedors` (`id`, `nombre`, `apellido`, `ci`, `correo`, `direccion`, `telefono`, `compania`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'Rodrigo', 'Bogado', '5211247', 'rodrigo@gmail.com', 'San Pedro', '0981568956', 'Rodrigo S.A', '2025-05-01 14:41:21', '2025-05-01 14:41:21', NULL),
	(2, 'Fredy', 'Vera', '12345', 'fredy@gmail.com', 'La amistad', '098454578', 'Fresy S.A', '2025-05-01 15:42:10', '2025-05-01 15:42:10', NULL);
/*!40000 ALTER TABLE `proveedors` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.roles
CREATE TABLE IF NOT EXISTS `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.roles: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
	(1, 'SuperAdmin', 'web', '2025-05-01 13:51:52', '2025-05-01 13:51:52'),
	(2, 'Administrador', 'web', '2025-05-01 13:51:52', '2025-05-01 13:51:52'),
	(3, 'Usuario', 'web', '2025-05-01 13:51:52', '2025-05-01 13:51:52'),
	(4, 'Cajero', 'web', '2025-05-01 13:51:52', '2025-05-01 13:51:52');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.role_has_permissions
CREATE TABLE IF NOT EXISTS `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.role_has_permissions: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
	(1, 1),
	(2, 1),
	(3, 1),
	(4, 1),
	(5, 1),
	(5, 2),
	(4, 3);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.rubros
CREATE TABLE IF NOT EXISTS `rubros` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `descripcion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.rubros: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `rubros` DISABLE KEYS */;
INSERT INTO `rubros` (`id`, `descripcion`, `estado`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 'prueba2', 'Activo', '2026-06-08 10:17:25', '2026-06-08 10:19:59', '2026-06-08 10:19:59'),
	(2, 'prueba', 'S', '2026-06-08 10:22:59', '2026-06-08 10:22:59', NULL),
	(3, 'prueba 2', 'S', '2026-06-08 10:40:12', '2026-06-08 10:40:12', NULL);
/*!40000 ALTER TABLE `rubros` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.saldo_ventas
CREATE TABLE IF NOT EXISTS `saldo_ventas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_venta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_cliente` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `monto` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `saldo` int(11) NOT NULL,
  `numero_cuota` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `pagado` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.saldo_ventas: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `saldo_ventas` DISABLE KEYS */;
INSERT INTO `saldo_ventas` (`id`, `id_venta`, `id_cliente`, `monto`, `saldo`, `numero_cuota`, `estado`, `fecha_vencimiento`, `pagado`, `created_at`, `updated_at`) VALUES
	(1, '8', '2', '16000', 16000, '1', 'Pendiente', '2025-06-01', '0', '2025-05-02 19:03:53', '2025-05-02 19:03:53'),
	(2, '8', '2', '16000', 16000, '2', 'Pendiente', '2025-07-01', '0', '2025-05-02 19:03:53', '2025-05-02 19:03:53'),
	(3, '8', '2', '16000', 16000, '3', 'Pendiente', '2025-07-31', '0', '2025-05-02 19:03:53', '2025-05-02 19:03:53'),
	(4, '10', '3', '12500', 0, '1', 'Pagado', '2025-06-01', '12500', '2025-05-02 21:31:10', '2025-05-08 14:50:14'),
	(5, '10', '3', '12500', 6000, '2', 'Parcial', '2025-07-01', '6500', '2025-05-02 21:31:10', '2025-05-09 18:43:52'),
	(6, '13', '4', '28000', 5000, '1', 'Parcial', '2025-06-08', '28000', '2025-05-09 19:09:59', '2025-05-13 22:17:57');
/*!40000 ALTER TABLE `saldo_ventas` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `role` bigint(20) unsigned DEFAULT NULL,
  `caja` int(11) NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_role_foreign` (`role`),
  CONSTRAINT `users_role_foreign` FOREIGN KEY (`role`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.users: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `role`, `caja`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
	(1, 'SuperAdmin', 'superadmin@gmail.com', NULL, 1, 0, '$2y$10$1n1Zn6nvYPES/SCjCfwrW.YHGWsou54kJHfYe10QJGWBH/zmkpFki', NULL, '2025-05-01 13:51:53', '2025-05-01 13:51:53'),
	(2, 'Administrador', 'admin@gmail.com', NULL, 3, 0, '$2y$10$cf0WsFzaoQGkvAnix129KesjTKNyLSjHkc.GiJOs5HuqUvBFcO10.', NULL, '2025-05-01 13:51:53', '2025-05-01 13:51:53'),
	(3, 'Cajero', 'cajero@gmail.com', NULL, 3, 2, '$2y$10$ZIAdAwDIILGXaBbfe34Y6.ADt88iQxpfleWCq8z7wZFNdpnHLCHeq', NULL, '2025-05-01 13:51:53', '2025-05-01 13:51:53'),
	(4, 'Rafael', 'rep141998@gmail.com', NULL, 1, 1, '$2y$10$UpFEGH44yEXpaIUNNgy4mO.ctMA3eqm8CW0QuT1kH2C8K3i4Jesxu', NULL, '2025-05-08 19:59:43', '2025-05-08 19:59:43');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;

-- Volcando estructura para tabla facturacion.ventas
CREATE TABLE IF NOT EXISTS `ventas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `id_cliente` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `fecha_venta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_usuario` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `tipo_comprobante` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `numero_comprobante` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `total` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `iva` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `forma_pago` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `condicion_venta` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `estado` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_caja` int(11) NOT NULL,
  `observacion` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Volcando datos para la tabla facturacion.ventas: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `ventas` DISABLE KEYS */;
INSERT INTO `ventas` (`id`, `id_cliente`, `fecha_venta`, `id_usuario`, `tipo_comprobante`, `numero_comprobante`, `total`, `iva`, `forma_pago`, `condicion_venta`, `estado`, `id_caja`, `observacion`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(8, '2', '2025-05-02', '1', 'Recibo', '1', '48000', '10', 'Efectivo', 'credito', 'Activo', 1, 'pagara en 3 cuotas', '2025-05-02 19:03:52', '2025-05-02 19:03:52', NULL),
	(9, '3', '2025-05-02', '1', 'Recibo', '2', '15000', '10', 'Efectivo', 'contado', 'Activo', 1, 'Sin observacion', '2025-05-02 21:13:46', '2025-05-02 21:13:46', NULL),
	(10, '3', '2025-05-02', '1', 'Recibo', '3', '25000', '10', 'Efectivo', 'credito', 'Activo', 1, 'hara en 2 pagos', '2025-05-02 21:31:10', '2025-05-02 21:31:10', NULL),
	(11, '4', '2025-05-06', '1', 'Factura', '1', '132000', '10', 'Efectivo', 'contado', 'Activo', 1, 'Sin observacion', '2025-05-06 21:38:26', '2025-05-06 21:38:26', NULL),
	(12, '3', '2025-05-08', '4', 'Recibo', '4', '46000', '10', 'Efectivo', 'contado', 'Anulado', 1, 'prueba de caja', '2025-05-08 21:47:09', '2025-05-11 20:36:18', NULL),
	(13, '4', '2025-05-09', '4', 'Recibo', '5', '28000', '10', 'Tarjeta', 'credito', 'Activo', 1, 'Sin observacion', '2025-05-09 19:09:58', '2025-05-09 19:09:58', NULL);
/*!40000 ALTER TABLE `ventas` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
