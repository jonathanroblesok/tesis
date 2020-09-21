/*
SQLyog Community v8.71 
MySQL - 5.5.5-10.4.6-MariaDB : Database - db_sistema
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`db_sistema` /*!40100 DEFAULT CHARACTER SET latin1 */;

USE `db_sistema`;

/*Table structure for table `categorias` */

DROP TABLE IF EXISTS `categorias`;

CREATE TABLE `categorias` (
  `idcategoria` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idcategoria`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

/*Data for the table `categorias` */

insert  into `categorias`(`idcategoria`,`nombre`,`condicion`) values (1,'Telas',1),(2,'Cierres',1),(3,'Botones',1),(4,'Chombas',1),(5,'Cuellos',1),(6,'Remeras',1),(7,'Buzos',1),(13,'Pantalones',0),(14,'hkjk,',0);

/*Table structure for table `clientes` */

DROP TABLE IF EXISTS `clientes`;

CREATE TABLE `clientes` (
  `idcliente` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) NOT NULL,
  `tipo_cliente_id` int(11) NOT NULL,
  `fecha_alta` date NOT NULL,
  PRIMARY KEY (`idcliente`),
  KEY `fk_cliente_persona_idx` (`persona_id`),
  KEY `FK_cliente_tipo` (`tipo_cliente_id`),
  CONSTRAINT `FK_cliente_tipo` FOREIGN KEY (`tipo_cliente_id`) REFERENCES `tipo_clientes` (`idtipo_cliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_cliente_persona` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

/*Data for the table `clientes` */

insert  into `clientes`(`idcliente`,`persona_id`,`tipo_cliente_id`,`fecha_alta`) values (1,1,2,'2019-10-08'),(2,2,2,'2019-10-28'),(3,3,2,'2019-11-01'),(34,36,2,'2019-11-15'),(35,38,2,'2019-11-01'),(36,39,2,'2019-11-01');

/*Table structure for table `contactos` */

DROP TABLE IF EXISTS `contactos`;

CREATE TABLE `contactos` (
  `idcontacto` int(11) NOT NULL AUTO_INCREMENT,
  `telefono` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idcontacto`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `contactos` */

insert  into `contactos`(`idcontacto`,`telefono`,`email`) values (1,'123123','inka@hotmail.com'),(2,'12123123','inka@hotmail.com'),(3,'123123','inka@hotmail.com'),(4,'wewewe','inka@hotmail.com'),(5,'123123','inka@hotmail.com'),(6,'24323423','inka@hotmail.com'),(7,'3704816025','jcarlos.ad7@gmail.com'),(8,'13123123','martin20@gmail.com'),(9,'123123',''),(10,'123123',''),(11,'','');

/*Table structure for table `cuentas` */

DROP TABLE IF EXISTS `cuentas`;

CREATE TABLE `cuentas` (
  `idcuenta` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `monto_max_venta_real` decimal(11,2) DEFAULT NULL,
  `monto_max_venta_actual` decimal(11,2) DEFAULT NULL,
  `fecha_alta` datetime DEFAULT NULL,
  `condicion` tinyint(6) DEFAULT 1,
  PRIMARY KEY (`idcuenta`),
  KEY `FK_cuentas_cliente` (`cliente_id`),
  KEY `FK_cuentas_usuario` (`usuario_id`),
  CONSTRAINT `FK_cuentas_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_cuentas_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `cuentas` */

insert  into `cuentas`(`idcuenta`,`cliente_id`,`usuario_id`,`monto_max_venta_real`,`monto_max_venta_actual`,`fecha_alta`,`condicion`) values (9,1,1,'123.00','123.00','2020-09-17 00:00:00',1);

/*Table structure for table `cuentaxventa` */

DROP TABLE IF EXISTS `cuentaxventa`;

CREATE TABLE `cuentaxventa` (
  `idcuenta_venta` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta_id` int(11) NOT NULL,
  `venta_id` int(11) NOT NULL,
  `ultima_cuota_pagada` varchar(255) DEFAULT NULL,
  `total_cuotas` varchar(255) DEFAULT NULL,
  `monto_total` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`idcuenta_venta`),
  KEY `FK_cuentaxventa_cuenta` (`cuenta_id`),
  KEY `FK_cuentaxventa_venta` (`venta_id`),
  CONSTRAINT `FK_cuentaxventa_cuenta` FOREIGN KEY (`cuenta_id`) REFERENCES `cuentas` (`idcuenta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_cuentaxventa_venta` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`idventa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cuentaxventa` */

/*Table structure for table `cuotas` */

DROP TABLE IF EXISTS `cuotas`;

CREATE TABLE `cuotas` (
  `idcuota` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta_venta_id` int(11) NOT NULL,
  `fecha_vencimiento` date DEFAULT NULL,
  `fecha_pago` date DEFAULT NULL,
  `monto_cuota` varchar(255) DEFAULT NULL,
  `interes_por_demora` decimal(11,2) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idcuota`),
  KEY `FK_cuotas_cuentaxventas` (`cuenta_venta_id`),
  CONSTRAINT `FK_cuotas_cuentaxventas` FOREIGN KEY (`cuenta_venta_id`) REFERENCES `cuentaxventa` (`idcuenta_venta`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `cuotas` */

/*Table structure for table `detalle_ingresos` */

DROP TABLE IF EXISTS `detalle_ingresos`;

CREATE TABLE `detalle_ingresos` (
  `iddetalle_ingreso` int(11) NOT NULL AUTO_INCREMENT,
  `ingreso_id` int(11) NOT NULL,
  `insumo_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_compra` decimal(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_ingreso`),
  KEY `fk_detalle_ingreso_ing_idx` (`ingreso_id`),
  KEY `fk_detalle_ingreso_ins_idx` (`insumo_id`),
  CONSTRAINT `fk_detalle_ingreso_i` FOREIGN KEY (`ingreso_id`) REFERENCES `ingresos` (`idingreso`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_ingreso_ins` FOREIGN KEY (`insumo_id`) REFERENCES `insumos` (`idinsumo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8;

/*Data for the table `detalle_ingresos` */

insert  into `detalle_ingresos`(`iddetalle_ingreso`,`ingreso_id`,`insumo_id`,`cantidad`,`precio_compra`) values (1,1,1,10,'57.50'),(2,1,2,5,'200.00'),(3,2,3,10,'16.00');

/*Table structure for table `detalle_modelos` */

DROP TABLE IF EXISTS `detalle_modelos`;

CREATE TABLE `detalle_modelos` (
  `iddetalle_modelo` int(11) NOT NULL AUTO_INCREMENT,
  `modelo_id` int(11) NOT NULL,
  `insumo_id` int(11) NOT NULL,
  `cantidad` int(11) DEFAULT NULL,
  `precio_compra` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`iddetalle_modelo`),
  KEY `FK_detalle_modelos_modelo` (`modelo_id`),
  KEY `FK_detalle_modelos_insumo` (`insumo_id`),
  CONSTRAINT `FK_detalle_modelos_insumo` FOREIGN KEY (`insumo_id`) REFERENCES `insumos` (`idinsumo`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_detalle_modelos_modelo` FOREIGN KEY (`modelo_id`) REFERENCES `modelos` (`idmodelo`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

/*Data for the table `detalle_modelos` */

insert  into `detalle_modelos`(`iddetalle_modelo`,`modelo_id`,`insumo_id`,`cantidad`,`precio_compra`) values (8,5,1,1,'50'),(9,5,3,1,'40');

/*Table structure for table `detalle_pedidos` */

DROP TABLE IF EXISTS `detalle_pedidos`;

CREATE TABLE `detalle_pedidos` (
  `iddetalle_pedido` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `talla_id` int(11) NOT NULL,
  `cantidad_producto` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`iddetalle_pedido`),
  KEY `fk_detalle_pedido_pedido_idx` (`producto_id`),
  KEY `fk_detalle_pedido_talla_idx` (`talla_id`),
  KEY `FK_detalle_pedidos_producto` (`pedido_id`),
  CONSTRAINT `FK_detalle_pedidos_producto` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`idpedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_pedido_pedido` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_pedido_talla` FOREIGN KEY (`talla_id`) REFERENCES `tallas` (`idtalla`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2278 DEFAULT CHARSET=utf8;

/*Data for the table `detalle_pedidos` */

insert  into `detalle_pedidos`(`iddetalle_pedido`,`pedido_id`,`producto_id`,`talla_id`,`cantidad_producto`) values (2268,61,1,1,'2'),(2269,62,1,1,'2'),(2270,63,1,1,'2'),(2271,64,1,1,'1'),(2272,65,1,2,'2'),(2273,66,1,2,'2'),(2274,67,1,1,'2'),(2275,68,1,1,'3'),(2276,69,1,1,'2'),(2277,70,1,1,'40');

/*Table structure for table `detalle_ventas` */

DROP TABLE IF EXISTS `detalle_ventas`;

CREATE TABLE `detalle_ventas` (
  `iddetalle_venta` int(11) NOT NULL AUTO_INCREMENT,
  `venta_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `precio_unitario` decimal(11,2) NOT NULL,
  `descuento` decimal(11,2) NOT NULL,
  PRIMARY KEY (`iddetalle_venta`),
  KEY `fk_detalle_venta_v_idx` (`venta_id`),
  KEY `fk_detalle_venta_p_idx` (`producto_id`),
  CONSTRAINT `fk_detalle_venta_p` FOREIGN KEY (`producto_id`) REFERENCES `productos` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_detalle_venta_v` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`idventa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8;

/*Data for the table `detalle_ventas` */

insert  into `detalle_ventas`(`iddetalle_venta`,`venta_id`,`producto_id`,`cantidad`,`precio_unitario`,`descuento`) values (1,1,1,10,'30.00','5.00'),(2,1,1,2,'30.00','5.00'),(3,2,2,10,'250.00','10.00'),(4,2,2,1,'30.00','0.00'),(5,3,3,1,'250.00','0.00'),(6,3,3,4,'250.00','0.00'),(29,26,3,1,'90.00','0.00'),(31,27,1,1,'29.00','0.00'),(32,27,1,1,'29.00','0.00'),(33,28,1,2,'29.00','0.00'),(34,29,2,2,'70.00','0.00'),(35,30,2,2,'70.00','0.00'),(36,31,1,21,'29.00','0.00'),(37,32,1,30,'29.00','0.00'),(38,33,3,100,'90.00','0.00');

/*Table structure for table `devoluciones` */

DROP TABLE IF EXISTS `devoluciones`;

CREATE TABLE `devoluciones` (
  `iddevolucion` int(11) NOT NULL AUTO_INCREMENT,
  `venta_id` int(11) DEFAULT NULL,
  `cliente_id` int(11) DEFAULT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `fecha_devolucion` date DEFAULT NULL,
  `motivo` varchar(255) DEFAULT NULL,
  `condicion` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`iddevolucion`),
  KEY `FK_devoluciones_venta` (`venta_id`),
  KEY `FK_devoluciones_cliente` (`cliente_id`),
  KEY `FK_devoluciones` (`usuario_id`),
  CONSTRAINT `FK_devoluciones` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_devoluciones_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_devoluciones_venta` FOREIGN KEY (`venta_id`) REFERENCES `ventas` (`idventa`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `devoluciones` */

/*Table structure for table `domicilios` */

DROP TABLE IF EXISTS `domicilios`;

CREATE TABLE `domicilios` (
  `iddomicilio` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) NOT NULL,
  `localidad_id` int(11) NOT NULL,
  `ciudad` varchar(100) NOT NULL,
  `barrio` varchar(100) NOT NULL,
  `calle` varchar(100) NOT NULL,
  `altura` varchar(100) NOT NULL,
  `numero_casa` varchar(100) NOT NULL,
  `manzana` varchar(100) NOT NULL,
  PRIMARY KEY (`iddomicilio`),
  KEY `fk_domicilio_localidad_idx` (`localidad_id`),
  CONSTRAINT `fk_domicilio_localidad` FOREIGN KEY (`localidad_id`) REFERENCES `localidades` (`idlocalidad`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `domicilios` */

insert  into `domicilios`(`iddomicilio`,`persona_id`,`localidad_id`,`ciudad`,`barrio`,`calle`,`altura`,`numero_casa`,`manzana`) values (1,1,1,'Formosa','Liborsi','Av. Nestor Kirchner y Manuel Chacoso','000000','11','asdasd'),(2,2,2,'Formosa','Liborsi','Av. Nestor Kirchner y Manuel Chacoso','32323','11','asdasdsad'),(3,3,3,'Formosa','Liborsi','Av. Nestor Kirchner y Manuel Chacoso','11111','11','wasddasda'),(9,1,1,'wew','sdasd','ewads','d23','323','32'),(10,3,1,'fsa','dsad','ss','asdc','22','33'),(11,0,1,'Formosa','Av. Nestor Kirchner y Manuel Chacoso','Liborsi','1','11','asdasd'),(12,0,2,'Formosa','Av. Nestor Kirchner y Manuel Chacoso','Liborsi','000000','11','asdasd');

/*Table structure for table `ingresos` */

DROP TABLE IF EXISTS `ingresos`;

CREATE TABLE `ingresos` (
  `idingreso` int(11) NOT NULL AUTO_INCREMENT,
  `proveedor_id` int(11) NOT NULL,
  `usuario_id` int(11) DEFAULT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `serie_comprobante` varchar(7) DEFAULT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` datetime NOT NULL,
  `impuesto` decimal(4,2) NOT NULL,
  `total_compra` decimal(11,2) NOT NULL,
  `estado` varchar(20) NOT NULL,
  PRIMARY KEY (`idingreso`),
  KEY `fk_ingreso_proveedor_idx` (`proveedor_id`),
  KEY `fk_ingreso_usuario_idx` (`usuario_id`),
  CONSTRAINT `fk_ingreso_proveedor` FOREIGN KEY (`proveedor_id`) REFERENCES `proveedores` (`idproveedor`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_ingreso_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;

/*Data for the table `ingresos` */

insert  into `ingresos`(`idingreso`,`proveedor_id`,`usuario_id`,`tipo_comprobante`,`serie_comprobante`,`num_comprobante`,`fecha_hora`,`impuesto`,`total_compra`,`estado`) values (1,1,1,'Factura','001','0001','2019-08-20 00:00:00','18.00','1200.00','Aceptado'),(2,2,1,'Factura','001','008','2019-08-21 00:00:00','18.00','160.00','Aceptado'),(3,3,1,'Boleta','0002','0004','2019-10-22 00:00:00','0.00','2500.00','Anulado');

/*Table structure for table `insumos` */

DROP TABLE IF EXISTS `insumos`;

CREATE TABLE `insumos` (
  `idinsumo` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `stock` int(11) DEFAULT NULL,
  `precio_compra` decimal(11,2) DEFAULT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `condicion` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`idinsumo`),
  KEY `fk_insumo_categoria_idx` (`categoria_id`),
  CONSTRAINT `fk_insumo_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

/*Data for the table `insumos` */

insert  into `insumos`(`idinsumo`,`categoria_id`,`codigo`,`nombre`,`stock`,`precio_compra`,`descripcion`,`imagen`,`condicion`) values (1,3,'00458','Botones modelo A',20,'12.00','color negro','1574002083.png',1),(2,2,'0040kl','Cierres para Buzos',57,'12.00','color negro','1574002105.jpg',1),(3,5,'HJL-OP','Cuello para Chombas',60,'12.00','color blanco','1574001933.jpg',1);

/*Table structure for table `insumosxproveedores` */

DROP TABLE IF EXISTS `insumosxproveedores`;

CREATE TABLE `insumosxproveedores` (
  `idinsumoxproveedor` int(11) NOT NULL AUTO_INCREMENT,
  `proveedor_id` int(11) NOT NULL,
  `insumo_id` int(11) NOT NULL,
  `precio_compra` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`idinsumoxproveedor`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `insumosxproveedores` */

/*Table structure for table `localidades` */

DROP TABLE IF EXISTS `localidades`;

CREATE TABLE `localidades` (
  `idlocalidad` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  PRIMARY KEY (`idlocalidad`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `localidades` */

insert  into `localidades`(`idlocalidad`,`nombre`) values (1,'Formosa'),(2,'Laishi'),(3,'Pirane');

/*Table structure for table `modelos` */

DROP TABLE IF EXISTS `modelos`;

CREATE TABLE `modelos` (
  `idmodelo` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `talla_id` int(11) NOT NULL,
  `categoria_id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `total_compra` decimal(11,2) DEFAULT NULL,
  `estado` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`idmodelo`),
  KEY `FK_modelos_talla` (`talla_id`),
  KEY `FK_modelos_categoria` (`categoria_id`),
  CONSTRAINT `FK_modelos_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `FK_modelos_talla` FOREIGN KEY (`talla_id`) REFERENCES `tallas` (`idtalla`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `modelos` */

insert  into `modelos`(`idmodelo`,`usuario_id`,`talla_id`,`categoria_id`,`fecha`,`total_compra`,`estado`) values (5,1,1,4,'2019-11-26','90.00','Aceptado');

/*Table structure for table `pedidos` */

DROP TABLE IF EXISTS `pedidos`;

CREATE TABLE `pedidos` (
  `idpedido` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `fecha` date DEFAULT NULL,
  `observaciones` varchar(255) DEFAULT NULL,
  `total_pedido` decimal(11,2) DEFAULT NULL,
  `condicion` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`idpedido`),
  KEY `fk_pedido_cliente_idx` (`cliente_id`),
  KEY `fk_pedido_usuario_idx` (`usuario_id`),
  CONSTRAINT `fk_pedido_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_pedido_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8;

/*Data for the table `pedidos` */

insert  into `pedidos`(`idpedido`,`cliente_id`,`usuario_id`,`fecha`,`observaciones`,`total_pedido`,`condicion`) values (61,1,1,'2019-12-08','pedido new',NULL,0),(62,1,1,'2019-12-08','ew','60.00',0),(63,1,1,'2019-12-08','asd','24.00',0),(64,1,1,'2019-12-08','producto new','24.00',0),(65,1,1,'2019-12-08','jojojojojojojoasd1323','36.00',0),(66,1,1,'2019-12-08','edededed','24.00',0),(67,1,1,'2019-12-08','fefefef','24.00',0),(68,1,1,'2019-12-10','pedido new','36.00',1),(69,1,1,'2019-12-10','pedido a laa escuela nª27','48.00',0),(70,1,1,'2019-12-10','pedido a la epesnª87','480.00',0),(71,2,1,'2020-09-11','aewe','12.00',0),(72,1,1,'2020-09-11','123123','48.00',0),(73,1,1,'2020-09-12','new','12.00',0),(74,1,1,'2020-09-12','pedido de prueba nro1','12.00',0);

/*Table structure for table `pedidosxinsumos` */

DROP TABLE IF EXISTS `pedidosxinsumos`;

CREATE TABLE `pedidosxinsumos` (
  `idpedidoxinsumo` int(11) NOT NULL AUTO_INCREMENT,
  `pedido_id` int(11) NOT NULL,
  `producto_id` int(11) NOT NULL,
  `insumo_id` int(11) NOT NULL,
  `cantidad_insumo` varchar(200) DEFAULT NULL,
  `precio_compra` decimal(11,2) DEFAULT NULL,
  PRIMARY KEY (`idpedidoxinsumo`),
  UNIQUE KEY `idpedidoxinsumo` (`idpedidoxinsumo`),
  KEY `FK_pedidosxinsumos` (`pedido_id`),
  CONSTRAINT `FK_pedidosxinsumos` FOREIGN KEY (`pedido_id`) REFERENCES `pedidos` (`idpedido`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=latin1;

/*Data for the table `pedidosxinsumos` */

insert  into `pedidosxinsumos`(`idpedidoxinsumo`,`pedido_id`,`producto_id`,`insumo_id`,`cantidad_insumo`,`precio_compra`) values (15,61,1,1,'1','12.00'),(16,61,1,2,'1','12.00'),(17,61,1,1,'1','12.00'),(18,62,1,1,'3','12.00'),(19,62,1,2,'2','12.00'),(20,63,1,1,'1','12.00'),(21,63,1,2,'1','12.00'),(22,64,1,1,'1','12.00'),(23,64,1,2,'1','12.00'),(24,65,1,1,'2','12.00'),(25,65,1,2,'1','12.00'),(26,66,1,1,'1','12.00'),(27,66,1,2,'1','12.00'),(28,67,1,1,'1','12.00'),(29,67,1,2,'1','12.00'),(30,68,1,3,'3','12.00'),(31,69,1,3,'4','12.00'),(32,70,1,3,'40','12.00'),(33,71,1,1,'1','12.00'),(34,72,1,1,'2','12.00'),(35,72,1,2,'2','12.00'),(36,73,1,1,'1','12.00'),(37,74,1,1,'1','12.00');

/*Table structure for table `permisos` */

DROP TABLE IF EXISTS `permisos`;

CREATE TABLE `permisos` (
  `idpermiso` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) NOT NULL,
  PRIMARY KEY (`idpermiso`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `permisos` */

insert  into `permisos`(`idpermiso`,`nombre`) values (1,'Escritorio'),(2,'Almacen'),(3,'Compras'),(4,'Ventas'),(5,'Acceso'),(6,'Consulta Compras'),(7,'Consulta Ventas'),(8,'Pedidos');

/*Table structure for table `personas` */

DROP TABLE IF EXISTS `personas`;

CREATE TABLE `personas` (
  `idpersona` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_documento_id` int(11) NOT NULL,
  `contacto_id` int(11) NOT NULL,
  `nombre` varchar(100) NOT NULL,
  `apellido` varchar(100) DEFAULT NULL,
  `num_documento` varchar(20) DEFAULT NULL,
  `direccion` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`idpersona`),
  KEY `fk_persona_tipo_documento_idx` (`tipo_documento_id`),
  KEY `FK_persona_contacto` (`contacto_id`),
  CONSTRAINT `fk_persona_contacto` FOREIGN KEY (`contacto_id`) REFERENCES `contactos` (`idcontacto`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_persona_tipo_documento` FOREIGN KEY (`tipo_documento_id`) REFERENCES `tipo_documentos` (`idtipo_documento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;

/*Data for the table `personas` */

insert  into `personas`(`idpersona`,`tipo_documento_id`,`contacto_id`,`nombre`,`apellido`,`num_documento`,`direccion`) values (1,1,1,'jonathan','robles','12587845254',NULL),(2,2,2,'facundo','king','30224520',NULL),(3,1,3,'graciela','davalos','20485248751',NULL),(4,2,4,'gerard','we','40485245824',NULL),(5,2,5,'wewe','we','40485245824',NULL),(6,2,6,'wewe','we','40485245824',NULL),(36,1,7,'Remera con escote en V','ASDASDASDASD','40486665',NULL),(37,1,8,'martin','salain','40485245824',NULL),(38,1,9,'gracielaaa','davalos','20485248751',''),(39,1,10,'gac','davalos','20485248751',''),(40,1,11,'jonathan','robles','12587845254','1');

/*Table structure for table `porcentajes` */

DROP TABLE IF EXISTS `porcentajes`;

CREATE TABLE `porcentajes` (
  `idporcentaje` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) NOT NULL,
  `monto` varchar(11) DEFAULT NULL,
  `condicion` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`idporcentaje`),
  KEY `FK_porcentajes` (`categoria_id`),
  CONSTRAINT `FK_porcentajes` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

/*Data for the table `porcentajes` */

insert  into `porcentajes`(`idporcentaje`,`categoria_id`,`monto`,`condicion`) values (1,5,'15',1),(2,5,'10',1),(3,3,'15',1),(4,5,'15',1),(5,5,'15',1);

/*Table structure for table `productos` */

DROP TABLE IF EXISTS `productos`;

CREATE TABLE `productos` (
  `idproducto` int(11) NOT NULL AUTO_INCREMENT,
  `categoria_id` int(11) NOT NULL,
  `talla_id` int(11) NOT NULL,
  `codigo` varchar(50) DEFAULT NULL,
  `nombre` varchar(100) NOT NULL,
  `precio_unitario` decimal(11,2) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `stock_minimo` int(11) DEFAULT NULL,
  `descripcion` varchar(256) DEFAULT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `condicion` tinyint(4) DEFAULT 1,
  PRIMARY KEY (`idproducto`),
  KEY `fk_producto_categoria_idx` (`categoria_id`),
  KEY `FK_producto_talla_idx` (`talla_id`),
  CONSTRAINT `FK_producto_talla_idx` FOREIGN KEY (`talla_id`) REFERENCES `tallas` (`idtalla`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_producto_categoria` FOREIGN KEY (`categoria_id`) REFERENCES `categorias` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

/*Data for the table `productos` */

insert  into `productos`(`idproducto`,`categoria_id`,`talla_id`,`codigo`,`nombre`,`precio_unitario`,`stock`,`stock_minimo`,`descripcion`,`imagen`,`condicion`) values (1,6,1,'00458','Remera con escote en V','38.70',70,6,'Color blanco','escoteenv.jpg',1),(2,13,1,'0040kl','Pantalon con cierre','84.70',54,3,'color negro','1575838312.png',1),(3,4,1,'HJL-OP','Remeras con cuello','108.90',6,3,'color blanco','chombas.jpg',1);

/*Table structure for table `proveedores` */

DROP TABLE IF EXISTS `proveedores`;

CREATE TABLE `proveedores` (
  `idproveedor` int(11) NOT NULL AUTO_INCREMENT,
  `persona_id` int(11) NOT NULL,
  `razon_social` varchar(100) NOT NULL,
  PRIMARY KEY (`idproveedor`),
  KEY `fk_proveedor_persona_idx` (`persona_id`),
  CONSTRAINT `fk_proveedor_persona` FOREIGN KEY (`persona_id`) REFERENCES `personas` (`idpersona`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

/*Data for the table `proveedores` */

insert  into `proveedores`(`idproveedor`,`persona_id`,`razon_social`) values (1,4,'confetelas'),(2,5,'cierresavenida'),(3,6,'telasconf'),(9,37,'macedo');

/*Table structure for table `tallas` */

DROP TABLE IF EXISTS `tallas`;

CREATE TABLE `tallas` (
  `idtalla` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) NOT NULL,
  `tipo_persona_talla` varchar(50) NOT NULL,
  `condicion` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idtalla`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `tallas` */

insert  into `tallas`(`idtalla`,`nombre`,`tipo_persona_talla`,`condicion`) values (1,'S','Hombre',1),(2,'S','Mujer',1),(3,'S','Niño',1),(4,'M','Hombre',1);

/*Table structure for table `tipo_clientes` */

DROP TABLE IF EXISTS `tipo_clientes`;

CREATE TABLE `tipo_clientes` (
  `idtipo_cliente` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) NOT NULL,
  PRIMARY KEY (`idtipo_cliente`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tipo_clientes` */

insert  into `tipo_clientes`(`idtipo_cliente`,`descripcion`) values (1,'Responsable Inscripto'),(2,'Confumidor Final'),(3,'Monotributista');

/*Table structure for table `tipo_documentos` */

DROP TABLE IF EXISTS `tipo_documentos`;

CREATE TABLE `tipo_documentos` (
  `idtipo_documento` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(100) NOT NULL,
  PRIMARY KEY (`idtipo_documento`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

/*Data for the table `tipo_documentos` */

insert  into `tipo_documentos`(`idtipo_documento`,`descripcion`) values (1,'DNI'),(2,'CEDULA');

/*Table structure for table `tipo_pagos` */

DROP TABLE IF EXISTS `tipo_pagos`;

CREATE TABLE `tipo_pagos` (
  `idtipo_pago` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_pago` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idtipo_pago`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*Data for the table `tipo_pagos` */

/*Table structure for table `tipo_ventas` */

DROP TABLE IF EXISTS `tipo_ventas`;

CREATE TABLE `tipo_ventas` (
  `idtipo_venta` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`idtipo_venta`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

/*Data for the table `tipo_ventas` */

insert  into `tipo_ventas`(`idtipo_venta`,`descripcion`) values (1,'A'),(2,'B'),(3,'C');

/*Table structure for table `usuario_permisos` */

DROP TABLE IF EXISTS `usuario_permisos`;

CREATE TABLE `usuario_permisos` (
  `idusuario_permiso` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `permiso_id` int(11) NOT NULL,
  PRIMARY KEY (`idusuario_permiso`),
  KEY `fk_permiso_usuario_u_idx` (`usuario_id`),
  KEY `fk_usuario_permiso_p_idx` (`permiso_id`),
  CONSTRAINT `fk_permiso_usuario_u` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_permiso_p` FOREIGN KEY (`permiso_id`) REFERENCES `permisos` (`idpermiso`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=143 DEFAULT CHARSET=utf8;

/*Data for the table `usuario_permisos` */

insert  into `usuario_permisos`(`idusuario_permiso`,`usuario_id`,`permiso_id`) values (88,1,1),(89,1,2),(90,1,3),(91,1,4),(92,1,5),(93,1,6),(94,1,7),(95,1,8),(97,2,1),(98,2,4),(99,1,1),(100,1,2),(101,1,3),(102,1,4),(103,1,5),(104,1,6),(105,1,7),(106,1,8),(107,2,1),(108,2,4),(109,3,1),(110,3,3),(111,2,1),(112,2,4),(113,3,1),(114,3,3),(115,1,1),(116,1,2),(117,1,3),(118,1,4),(119,1,5),(120,1,6),(121,1,7),(122,1,8),(123,2,1),(124,2,4),(125,3,1),(126,3,3),(127,1,1),(128,1,2),(129,1,3),(130,1,4),(131,1,5),(132,1,6),(133,1,7),(134,1,8),(135,2,1),(136,2,4),(137,3,1),(138,3,3),(139,2,1),(140,2,4),(141,3,1),(142,3,3);

/*Table structure for table `usuarios` */

DROP TABLE IF EXISTS `usuarios`;

CREATE TABLE `usuarios` (
  `idusuario` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) NOT NULL,
  `tipo_documento` varchar(20) NOT NULL,
  `num_documento` varchar(20) NOT NULL,
  `direccion` varchar(70) DEFAULT NULL,
  `telefono` varchar(20) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `cargo` varchar(20) DEFAULT NULL,
  `login` varchar(20) NOT NULL,
  `clave` varchar(64) NOT NULL,
  `imagen` varchar(50) DEFAULT NULL,
  `ultimo_login` datetime DEFAULT NULL,
  `fecha` timestamp NOT NULL DEFAULT current_timestamp(),
  `condicion` tinyint(4) NOT NULL DEFAULT 1,
  PRIMARY KEY (`idusuario`),
  UNIQUE KEY `login_UNIQUE` (`login`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;

/*Data for the table `usuarios` */

insert  into `usuarios`(`idusuario`,`nombre`,`tipo_documento`,`num_documento`,`direccion`,`telefono`,`email`,`cargo`,`login`,`clave`,`imagen`,`ultimo_login`,`fecha`,`condicion`) values (1,'jonathan','DNI','40486665','Av, Nestor Kirchner y Manuel Chacoso','3704816025','yonathanrobles19@gmail.com','Administrador','admin','e33d5eaf4ccf2bea4c44d724e58291a7bb3bba66151c7b1ffada6021c6c082f7','1574002259.jpg',NULL,'2019-11-17 12:38:51',1),(2,'Facundo','DNI','30115425','Av. Gonzalez Lelong y Jujuy','054789521','facuvr@hotmail.com','Facundo','ventas','a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3','1574002276.png',NULL,'2019-11-17 12:38:51',1),(3,'Graciela','DNI','123123','Av. Gonzalez Lelong y Jujuy','13123123','gracieladavalos20@gmail.com','Graciela','compras','a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3','1574002286.png',NULL,'2019-11-17 12:38:51',1);

/*Table structure for table `variacion_precio` */

DROP TABLE IF EXISTS `variacion_precio`;

CREATE TABLE `variacion_precio` (
  `idvariacion_precio` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `nombre` varchar(255) DEFAULT NULL,
  `descripcion` varchar(255) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `precio_unitario` float DEFAULT NULL,
  `nuevo_precio_unitario` float DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`idvariacion_precio`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

/*Data for the table `variacion_precio` */

insert  into `variacion_precio`(`idvariacion_precio`,`nombre`,`descripcion`,`stock`,`precio_unitario`,`nuevo_precio_unitario`,`fecha`) values (2,'Remeras con cuello','color blanco',6,99,108.9,'2020-09-08'),(3,'Remera con escote en V','Color blanco',70,33.5,35.18,'2020-09-08'),(4,'Remera con escote en V','Color blanco',70,35.18,38.7,'2020-09-09');

/*Table structure for table `ventas` */

DROP TABLE IF EXISTS `ventas`;

CREATE TABLE `ventas` (
  `idventa` int(11) NOT NULL AUTO_INCREMENT,
  `cliente_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `tipo_venta_id` int(11) DEFAULT NULL,
  `tipo_comprobante` varchar(20) NOT NULL,
  `num_comprobante` varchar(10) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `impuesto` decimal(4,2) DEFAULT NULL,
  `total_venta` decimal(11,2) DEFAULT NULL,
  `estado` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`idventa`),
  KEY `fk_venta_cliente_idx` (`cliente_id`),
  KEY `fk_venta_usuario_idx` (`usuario_id`),
  KEY `FK_tipo_ventas` (`tipo_venta_id`),
  CONSTRAINT `FK_tipo_ventas` FOREIGN KEY (`tipo_venta_id`) REFERENCES `tipo_ventas` (`idtipo_venta`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_venta_cliente` FOREIGN KEY (`cliente_id`) REFERENCES `clientes` (`idcliente`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_venta_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`idusuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=utf8;

/*Data for the table `ventas` */

insert  into `ventas`(`idventa`,`cliente_id`,`usuario_id`,`tipo_venta_id`,`tipo_comprobante`,`num_comprobante`,`fecha_hora`,`impuesto`,`total_venta`,`estado`) values (1,1,1,2,'Boleta','0001','2020-09-14 18:15:26','0.00','338.00','Anulado'),(2,2,1,2,'Factura','0002','2020-09-14 18:15:27','18.00','760.00','Aceptado'),(3,3,1,2,'Ticket','0003','2020-09-14 18:15:28','0.00','450.00','Aceptado'),(26,1,1,2,'Factura','0004','2020-09-16 11:53:21','21.00','90.00','Aceptado'),(27,2,1,2,'Factura','0005','2020-09-16 11:53:30','18.00','58.00','Aceptado'),(28,2,1,2,'Factura','0006','2020-09-16 11:53:35','21.00','58.00','Aceptado'),(29,1,1,2,'Factura','0007','2020-09-16 11:53:44','21.00','140.00','Aceptado'),(30,3,1,2,'Factura','0008','2020-09-16 11:53:52','21.00','140.00','Aceptado'),(31,1,1,2,'Factura','0009','2020-09-16 11:53:59','21.00','609.00','Aceptado'),(32,1,1,2,'Factura','0010','2020-09-16 11:54:07','21.00','29.00','Aceptado'),(33,1,1,2,'Factura','0011','2020-09-16 11:54:14','21.00','10800.00','Anulado');

/* Trigger structure for table `detalle_ingresos` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tr_updStockIngresos` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tr_updStockIngresos` AFTER INSERT ON `detalle_ingresos` FOR EACH ROW BEGIN
UPDATE insumos SET stock=stock + NEW.cantidad
WHERE insumos.idinsumo = NEW.insumo_id;
END */$$


DELIMITER ;

/* Trigger structure for table `detalle_pedidos` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `update_stock_productos` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `update_stock_productos` AFTER INSERT ON `detalle_pedidos` FOR EACH ROW BEGIN
UPDATE productos SET stock = stock+NEW.cantidad_producto
WHERE productos.idproducto = NEW.producto_id;
    END */$$


DELIMITER ;

/* Trigger structure for table `detalle_pedidos` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `actualizar_stock_prod_pedido` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `actualizar_stock_prod_pedido` AFTER UPDATE ON `detalle_pedidos` FOR EACH ROW begin
	UPDATE pedidos SET condicion=1 WHERE pedidos.idpedido=new.pedido_id;
	update productos set stock= stock + cantidad_producto
	where productos.idproducto= new.producto_id;
    END */$$


DELIMITER ;

/* Trigger structure for table `detalle_ventas` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `tr_udpStockVentas` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `tr_udpStockVentas` AFTER INSERT ON `detalle_ventas` FOR EACH ROW BEGIN
UPDATE productos SET stock = stock - NEW.cantidad
WHERE productos.idproducto = NEW.producto_id;
END */$$


DELIMITER ;

/* Trigger structure for table `pedidosxinsumos` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `update_stock_insumos` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `update_stock_insumos` AFTER INSERT ON `pedidosxinsumos` FOR EACH ROW BEGIN
UPDATE insumos SET stock = stock-NEW.cantidad_insumo
WHERE insumos.idinsumo = NEW.insumo_id;
    END */$$


DELIMITER ;

/* Trigger structure for table `productos` */

DELIMITER $$

/*!50003 DROP TRIGGER*//*!50032 IF EXISTS */ /*!50003 `variacion_precios` */$$

/*!50003 CREATE */ /*!50017 DEFINER = 'root'@'localhost' */ /*!50003 TRIGGER `variacion_precios` BEFORE UPDATE ON `productos` FOR EACH ROW BEGIN
	if (new.precio_unitario <> old.precio_unitario) then
	 insert into variacion_precio(nombre,descripcion,stock,precio_unitario, nuevo_precio_unitario, fecha) 
	values(new.nombre, new.descripcion, new.stock, old.precio_unitario, new.precio_unitario, now());
	end if;
    END */$$


DELIMITER ;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
