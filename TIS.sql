/*
Navicat MySQL Data Transfer

Source Server         : RAM
Source Server Version : 50527
Source Host           : localhost:3306
Source Database       : tis

Target Server Type    : MYSQL
Target Server Version : 50527
File Encoding         : 65001

Date: 2014-05-06 05:31:46
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `actividad_convocatoria`
-- ----------------------------
DROP TABLE IF EXISTS `actividad_convocatoria`;
CREATE TABLE `actividad_convocatoria` (
  `id_actividad_convocatoria` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_actividad_convocatoria` int(11) NOT NULL,
  `fecha_inicio` date DEFAULT NULL,
  `fecha_fin` date DEFAULT NULL,
  `activo` tinyint(1) NOT NULL,
  `gestion` int(11) NOT NULL,
  `descripcion` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id_actividad_convocatoria`),
  KEY `fk_actividad_tipo_actividad1_idx` (`tipo_actividad_convocatoria`),
  KEY `fk_gestion` (`gestion`),
  CONSTRAINT `fk_actividad_tipo_actividad1` FOREIGN KEY (`tipo_actividad_convocatoria`) REFERENCES `tipo_actividad_convocatoria` (`id_tipo_actividad_convocatoria`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_gestion` FOREIGN KEY (`gestion`) REFERENCES `gestion_empresa_tis` (`id_gestion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of actividad_convocatoria
-- ----------------------------
INSERT INTO `actividad_convocatoria` VALUES ('1', '1', null, null, '1', '1', null);
INSERT INTO `actividad_convocatoria` VALUES ('2', '2', null, null, '1', '1', null);
INSERT INTO `actividad_convocatoria` VALUES ('3', '3', null, null, '1', '1', null);
INSERT INTO `actividad_convocatoria` VALUES ('4', '4', null, null, '1', '1', null);
INSERT INTO `actividad_convocatoria` VALUES ('5', '5', null, null, '1', '1', null);
INSERT INTO `actividad_convocatoria` VALUES ('6', '6', null, null, '1', '1', null);
INSERT INTO `actividad_convocatoria` VALUES ('7', '7', null, null, '1', '1', null);

-- ----------------------------
-- Table structure for `actividad_grupo_empresa`
-- ----------------------------
DROP TABLE IF EXISTS `actividad_grupo_empresa`;
CREATE TABLE `actividad_grupo_empresa` (
  `id_actividad_grupo_empresa` int(11) NOT NULL AUTO_INCREMENT,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  `entrega_producto` int(11) NOT NULL,
  PRIMARY KEY (`id_actividad_grupo_empresa`),
  KEY `fk_actividad_grupo_empresa_entrega_producto1_idx` (`entrega_producto`),
  CONSTRAINT `fk_actividad_grupo_empresa_entrega_producto1` FOREIGN KEY (`entrega_producto`) REFERENCES `entrega_producto` (`id_entrega_producto`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of actividad_grupo_empresa
-- ----------------------------

-- ----------------------------
-- Table structure for `anuncio`
-- ----------------------------
DROP TABLE IF EXISTS `anuncio`;
CREATE TABLE `anuncio` (
  `id_anuncio` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(64) NOT NULL,
  `contenido` varchar(1024) DEFAULT NULL,
  `adjunto` varchar(256) DEFAULT NULL,
  `usuario` varchar(20) NOT NULL,
  PRIMARY KEY (`id_anuncio`),
  KEY `fk_anuncio_usuario1_idx` (`usuario`),
  CONSTRAINT `fk_anuncio_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`nombre_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of anuncio
-- ----------------------------

-- ----------------------------
-- Table structure for `avance_semanal`
-- ----------------------------
DROP TABLE IF EXISTS `avance_semanal`;
CREATE TABLE `avance_semanal` (
  `id_avance_semanal` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_empresa` varchar(20) NOT NULL,
  `fecha_establecida` date NOT NULL,
  `titulo_avance` varchar(45) NOT NULL,
  `desc_avance` varchar(128) DEFAULT NULL,
  `fecha_entregado` varchar(45) DEFAULT NULL,
  `enlace_entregable` varchar(128) DEFAULT NULL,
  `observacion` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`id_avance_semanal`),
  KEY `fk_avance_semanal_grupo_empresa1_idx` (`grupo_empresa`),
  CONSTRAINT `fk_avance_semanal_grupo_empresa1` FOREIGN KEY (`grupo_empresa`) REFERENCES `grupo_empresa` (`nombre_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of avance_semanal
-- ----------------------------

-- ----------------------------
-- Table structure for `carrera`
-- ----------------------------
DROP TABLE IF EXISTS `carrera`;
CREATE TABLE `carrera` (
  `id_carrera` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_carrera` varchar(45) NOT NULL,
  PRIMARY KEY (`id_carrera`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of carrera
-- ----------------------------
INSERT INTO `carrera` VALUES ('1', 'Licenciatura en Informática');
INSERT INTO `carrera` VALUES ('2', 'Ingeniería de Sistemas');

-- ----------------------------
-- Table structure for `consultor_tis`
-- ----------------------------
DROP TABLE IF EXISTS `consultor_tis`;
CREATE TABLE `consultor_tis` (
  `nombre_usuario` varchar(20) NOT NULL,
  `nombre` varchar(32) NOT NULL,
  `apellido` varchar(32) NOT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `tiene_curriculum` tinyint(1) NOT NULL,
  `ruta_curriculum` varchar(128) DEFAULT NULL,
  `tiene_foto` tinyint(1) NOT NULL,
  `ruta_foto` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`nombre_usuario`),
  KEY `fk_consultor_tis_usuario_idx` (`nombre_usuario`),
  CONSTRAINT `fk_consultor_tis_usuario` FOREIGN KEY (`nombre_usuario`) REFERENCES `usuario` (`nombre_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of consultor_tis
-- ----------------------------
INSERT INTO `consultor_tis` VALUES ('corina', 'Corina', 'Flores', '4485698', '0', null, '0', null);

-- ----------------------------
-- Table structure for `documento_consultor`
-- ----------------------------
DROP TABLE IF EXISTS `documento_consultor`;
CREATE TABLE `documento_consultor` (
  `id_documento_consultor` int(11) NOT NULL AUTO_INCREMENT,
  `nombre_documento` varchar(64) NOT NULL,
  `descripsion_documento` varchar(256) DEFAULT NULL,
  `ruta_documento` varchar(128) DEFAULT NULL,
  `fecha_documento` datetime NOT NULL,
  `documento_jefe` tinyint(1) NOT NULL,
  `consultor_tis` varchar(20) NOT NULL,
  `gestion` int(11) NOT NULL,
  PRIMARY KEY (`id_documento_consultor`),
  KEY `fk_documento_consultor_consultor_tis1_idx` (`consultor_tis`),
  KEY `fk_gestion3` (`gestion`),
  CONSTRAINT `fk_documento_consultor_consultor_tis1` FOREIGN KEY (`consultor_tis`) REFERENCES `consultor_tis` (`nombre_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_gestion3` FOREIGN KEY (`gestion`) REFERENCES `gestion_empresa_tis` (`id_gestion`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of documento_consultor
-- ----------------------------

-- ----------------------------
-- Table structure for `entrega_producto`
-- ----------------------------
DROP TABLE IF EXISTS `entrega_producto`;
CREATE TABLE `entrega_producto` (
  `id_entrega_producto` int(11) NOT NULL AUTO_INCREMENT,
  `grupo_empresa` varchar(20) NOT NULL,
  `fecha_establecida` date NOT NULL,
  `descripcion` varchar(128) NOT NULL,
  `fecha_entrega` date DEFAULT NULL,
  `observacion` varchar(128) DEFAULT NULL,
  `pago_asociado` int(11) NOT NULL,
  PRIMARY KEY (`id_entrega_producto`),
  KEY `fk_entrega_producto_grupo_empresa1_idx` (`grupo_empresa`),
  CONSTRAINT `fk_entrega_producto_grupo_empresa1` FOREIGN KEY (`grupo_empresa`) REFERENCES `grupo_empresa` (`nombre_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of entrega_producto
-- ----------------------------

-- ----------------------------
-- Table structure for `gestion_empresa_tis`
-- ----------------------------
DROP TABLE IF EXISTS `gestion_empresa_tis`;
CREATE TABLE `gestion_empresa_tis` (
  `id_gestion` int(11) NOT NULL AUTO_INCREMENT,
  `gestion` varchar(20) NOT NULL,
  `fecha_ini_gestion` date NOT NULL,
  `fecha_fin_gestion` date DEFAULT NULL,
  `gestion_activa` tinyint(1) NOT NULL,
  `descripcion_gestion` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id_gestion`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of gestion_empresa_tis
-- ----------------------------
INSERT INTO `gestion_empresa_tis` VALUES ('1', '0', '2014-02-17', null, '1', 'Permanente');

-- ----------------------------
-- Table structure for `grupo_empresa`
-- ----------------------------
DROP TABLE IF EXISTS `grupo_empresa`;
CREATE TABLE `grupo_empresa` (
  `nombre_usuario` varchar(20) NOT NULL,
  `nombre_largo` varchar(64) NOT NULL,
  `nombre_corto` varchar(20) NOT NULL,
  `consultor_tis` varchar(20) NOT NULL,
  `rep_legal` int(11) DEFAULT NULL,
  `sociedad` int(11) DEFAULT NULL,
  `fecha_sobre_a` date DEFAULT NULL,
  `sobre_a` varchar(128) DEFAULT NULL,
  `fecha_sobre_b` date DEFAULT NULL,
  `sobre_b` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`nombre_usuario`,`nombre_largo`),
  KEY `fk_grupo_empresa_consultor_tis1_idx` (`consultor_tis`),
  KEY `fk_grupo_empresa_integrante1_idx` (`rep_legal`),
  KEY `fk_grupo_empresa_sociedad` (`sociedad`),
  CONSTRAINT `fk_grupo_empresa_consultor_tis1` FOREIGN KEY (`consultor_tis`) REFERENCES `consultor_tis` (`nombre_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_empresa_integrante1` FOREIGN KEY (`rep_legal`) REFERENCES `integrante` (`id_integrante`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_empresa_sociedad` FOREIGN KEY (`sociedad`) REFERENCES `sociedad` (`id_sociedad`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_grupo_empresa_usuario1` FOREIGN KEY (`nombre_usuario`) REFERENCES `usuario` (`nombre_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of grupo_empresa
-- ----------------------------

-- ----------------------------
-- Table structure for `integrante`
-- ----------------------------
DROP TABLE IF EXISTS `integrante`;
CREATE TABLE `integrante` (
  `id_integrante` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(32) NOT NULL,
  `apellido` varchar(32) NOT NULL,
  `telefono` varchar(12) DEFAULT NULL,
  `codigo_sis` varchar(9) NOT NULL,
  `foto` tinyint(1) NOT NULL,
  `ruta_foto` varchar(128) DEFAULT NULL,
  `carrera` int(11) NOT NULL,
  `grupo_empresa` varchar(20) NOT NULL,
  `nombre_usuario` varchar(20) NOT NULL,
  PRIMARY KEY (`id_integrante`),
  KEY `fk_integrante_carrera1_idx` (`carrera`),
  KEY `fk_integrante_grupo_empresa1_idx` (`grupo_empresa`),
  KEY `fk_integrante_usuario1_idx` (`nombre_usuario`),
  CONSTRAINT `fk_integrante_carrera1` FOREIGN KEY (`carrera`) REFERENCES `carrera` (`id_carrera`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_integrante_grupo_empresa1` FOREIGN KEY (`grupo_empresa`) REFERENCES `grupo_empresa` (`nombre_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_integrante_usuario1` FOREIGN KEY (`nombre_usuario`) REFERENCES `usuario` (`nombre_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of integrante
-- ----------------------------

-- ----------------------------
-- Table structure for `mensaje`
-- ----------------------------
DROP TABLE IF EXISTS `mensaje`;
CREATE TABLE `mensaje` (
  `id_mensaje` int(11) NOT NULL AUTO_INCREMENT,
  `de_usuario` varchar(20) NOT NULL,
  `para_usuario` varchar(20) NOT NULL,
  `contenido` varchar(1024) NOT NULL,
  PRIMARY KEY (`id_mensaje`),
  KEY `fk_mensaje_usuario1_idx` (`de_usuario`),
  KEY `fk_mensaje_usuario2_idx` (`para_usuario`),
  CONSTRAINT `fk_mensaje_usuario1` FOREIGN KEY (`de_usuario`) REFERENCES `usuario` (`nombre_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_mensaje_usuario2` FOREIGN KEY (`para_usuario`) REFERENCES `usuario` (`nombre_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of mensaje
-- ----------------------------

-- ----------------------------
-- Table structure for `notificacion`
-- ----------------------------
DROP TABLE IF EXISTS `notificacion`;
CREATE TABLE `notificacion` (
  `id_notificacion` int(11) NOT NULL AUTO_INCREMENT,
  `tipo_notificacion` int(11) NOT NULL,
  `usuario` varchar(20) NOT NULL,
  `leido` tinyint(1) NOT NULL,
  PRIMARY KEY (`id_notificacion`),
  KEY `fk_notificacion_tipo_notificacion1_idx` (`tipo_notificacion`),
  KEY `fk_notificacion_usuario1_idx` (`usuario`),
  CONSTRAINT `fk_notificacion_tipo_notificacion1` FOREIGN KEY (`tipo_notificacion`) REFERENCES `tipo_notificacion` (`id_tipo_notificacion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_notificacion_usuario1` FOREIGN KEY (`usuario`) REFERENCES `usuario` (`nombre_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of notificacion
-- ----------------------------

-- ----------------------------
-- Table structure for `rol`
-- ----------------------------
DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
  `id_rol` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `descripcion` varchar(256) NOT NULL,
  PRIMARY KEY (`id_rol`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rol
-- ----------------------------
INSERT INTO `rol` VALUES ('1', 'Representante Legal', 'El Representante Legal contacta con la Empresa TIS para todo efecto legal.');
INSERT INTO `rol` VALUES ('2', 'Product Owner', 'En Scrum, el Product Owner estudia los requerimientos del cliente y los comunica al Equipo.');
INSERT INTO `rol` VALUES ('3', 'Scrum Master', 'En Scrum, el Scrum Master dirige el proceso de desarrollo.');
INSERT INTO `rol` VALUES ('4', 'Desarrollador', 'El Desarrollador es \"el pan y la mantequilla\" de todo proceso de desarrollo de software.');
INSERT INTO `rol` VALUES ('5', 'Tester', 'El Tester se encarga de probar la funcionalidad de los producto de los desarrolladores.');
INSERT INTO `rol` VALUES ('6', 'Encargado Base de Datos', 'El Encargado de la Base de Datos está continuamente trabajando con la reingeniería de la base de datos.');
INSERT INTO `rol` VALUES ('7', 'Documentador', 'El Documentador redacta los documentos necesarios para controlar, verificar y avalar el proceso.');

-- ----------------------------
-- Table structure for `rol_integrante`
-- ----------------------------
DROP TABLE IF EXISTS `rol_integrante`;
CREATE TABLE `rol_integrante` (
  `integrante` int(11) NOT NULL,
  `rol` int(11) NOT NULL,
  KEY `fk_rol_integrante_integrante1_idx` (`integrante`),
  KEY `fk_rol_integrante_rol1_idx` (`rol`),
  CONSTRAINT `fk_rol_integrante_integrante1` FOREIGN KEY (`integrante`) REFERENCES `integrante` (`id_integrante`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_rol_integrante_rol1` FOREIGN KEY (`rol`) REFERENCES `rol` (`id_rol`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of rol_integrante
-- ----------------------------

-- ----------------------------
-- Table structure for `sociedad`
-- ----------------------------
DROP TABLE IF EXISTS `sociedad`;
CREATE TABLE `sociedad` (
  `id_sociedad` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(64) NOT NULL,
  `abreviatura` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id_sociedad`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of sociedad
-- ----------------------------
INSERT INTO `sociedad` VALUES ('1', 'Sociedad Anónima', 'S.A.');
INSERT INTO `sociedad` VALUES ('2', 'Sociedad de Responsabilidad Limitada', 'S.R.L.');
INSERT INTO `sociedad` VALUES ('3', 'Empresa Individual de Responsabilidad Limitada', 'E.I.R.L.');
INSERT INTO `sociedad` VALUES ('4', 'Sociedad en Comandita', 'S.Co.');
INSERT INTO `sociedad` VALUES ('5', 'Sociedad Colectiva', 'S.C.');
INSERT INTO `sociedad` VALUES ('6', 'Sociedad de Hecho', 'S.H.');

-- ----------------------------
-- Table structure for `tarea`
-- ----------------------------
DROP TABLE IF EXISTS `tarea`;
CREATE TABLE `tarea` (
  `id_tarea` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(128) NOT NULL,
  `integrante` int(11) NOT NULL,
  `actividad_grupo_empresa` int(11) NOT NULL,
  `fecha_inicio` date NOT NULL,
  `fecha_fin` date NOT NULL,
  `resultado` varchar(128) NOT NULL,
  `verificable` varchar(256) DEFAULT NULL,
  `color_tarea` varchar(20) DEFAULT NULL,
  `color_texto` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id_tarea`),
  KEY `fk_tarea_integrante1_idx` (`integrante`),
  KEY `fk_tarea_actividad_grupo_empresa1_idx` (`actividad_grupo_empresa`),
  CONSTRAINT `fk_tarea_actividad_grupo_empresa1` FOREIGN KEY (`actividad_grupo_empresa`) REFERENCES `actividad_grupo_empresa` (`id_actividad_grupo_empresa`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_tarea_integrante1` FOREIGN KEY (`integrante`) REFERENCES `integrante` (`id_integrante`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tarea
-- ----------------------------

-- ----------------------------
-- Table structure for `tipo_actividad_convocatoria`
-- ----------------------------
DROP TABLE IF EXISTS `tipo_actividad_convocatoria`;
CREATE TABLE `tipo_actividad_convocatoria` (
  `id_tipo_actividad_convocatoria` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id_tipo_actividad_convocatoria`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tipo_actividad_convocatoria
-- ----------------------------
INSERT INTO `tipo_actividad_convocatoria` VALUES ('1', 'Lanzamiento de la Convocatoria Pública');
INSERT INTO `tipo_actividad_convocatoria` VALUES ('2', 'Inicio del Registro de Grupo Empresas');
INSERT INTO `tipo_actividad_convocatoria` VALUES ('3', 'Conclusión Registro de Grupo Empresas');
INSERT INTO `tipo_actividad_convocatoria` VALUES ('4', 'Firma de Contratos');
INSERT INTO `tipo_actividad_convocatoria` VALUES ('5', 'Inicio del Proceso de Desarrollo');
INSERT INTO `tipo_actividad_convocatoria` VALUES ('6', 'Final del Proceso de Desarrollo');
INSERT INTO `tipo_actividad_convocatoria` VALUES ('7', 'Fin de la Convocatoria');

-- ----------------------------
-- Table structure for `tipo_notificacion`
-- ----------------------------
DROP TABLE IF EXISTS `tipo_notificacion`;
CREATE TABLE `tipo_notificacion` (
  `id_tipo_notificacion` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_tipo_notificacion`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tipo_notificacion
-- ----------------------------
INSERT INTO `tipo_notificacion` VALUES ('1', 'Contrato');
INSERT INTO `tipo_notificacion` VALUES ('2', 'Recepcion Contrato');
INSERT INTO `tipo_notificacion` VALUES ('3', 'Rechazo Contrato');

-- ----------------------------
-- Table structure for `tipo_usuario`
-- ----------------------------
DROP TABLE IF EXISTS `tipo_usuario`;
CREATE TABLE `tipo_usuario` (
  `id_tipo_usuario` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  PRIMARY KEY (`id_tipo_usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of tipo_usuario
-- ----------------------------
INSERT INTO `tipo_usuario` VALUES ('1', 'Administrador');
INSERT INTO `tipo_usuario` VALUES ('2', 'Jefe Consultor TIS');
INSERT INTO `tipo_usuario` VALUES ('3', 'Consultor TIS');
INSERT INTO `tipo_usuario` VALUES ('4', 'Grupo Empresa');
INSERT INTO `tipo_usuario` VALUES ('5', 'Integrante');

-- ----------------------------
-- Table structure for `usuario`
-- ----------------------------
DROP TABLE IF EXISTS `usuario`;
CREATE TABLE `usuario` (
  `nombre_usuario` varchar(20) NOT NULL,
  `clave` varchar(20) NOT NULL,
  `email` varchar(48) NOT NULL,
  `tipo_usuario` int(11) NOT NULL,
  `habilitado` tinyint(1) DEFAULT NULL,
  `gestion` int(11) NOT NULL,
  PRIMARY KEY (`nombre_usuario`),
  KEY `fk_usuario_tipo_usuario1_idx` (`tipo_usuario`),
  KEY `fk_gestion2` (`gestion`),
  CONSTRAINT `fk_gestion2` FOREIGN KEY (`gestion`) REFERENCES `gestion_empresa_tis` (`id_gestion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_usuario_tipo_usuario1` FOREIGN KEY (`tipo_usuario`) REFERENCES `tipo_usuario` (`id_tipo_usuario`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of usuario
-- ----------------------------
INSERT INTO `usuario` VALUES ('admin', 'admin', 'master@gmail.com', '1', '1', '1');
INSERT INTO `usuario` VALUES ('corina', 'corina', 'corina@gmail.com', '2', '1', '1');
DROP TRIGGER IF EXISTS `crear_actividades`;
DELIMITER ;;
CREATE TRIGGER `crear_actividades` AFTER INSERT ON `gestion_empresa_tis` FOR EACH ROW -- Edit trigger body code below this line. Do not edit lines above this one
BEGIN
	INSERT INTO `actividad_convocatoria`(tipo_actividad_convocatoria,activo,gestion) VALUES (1,1,NEW.id_gestion);
	INSERT INTO `actividad_convocatoria`(tipo_actividad_convocatoria,activo,gestion) VALUES (2,1,NEW.id_gestion);
	INSERT INTO `actividad_convocatoria`(tipo_actividad_convocatoria,activo,gestion) VALUES (3,1,NEW.id_gestion);
	INSERT INTO `actividad_convocatoria`(tipo_actividad_convocatoria,activo,gestion) VALUES (4,1,NEW.id_gestion);
	INSERT INTO `actividad_convocatoria`(tipo_actividad_convocatoria,activo,gestion) VALUES (5,1,NEW.id_gestion);
	INSERT INTO `actividad_convocatoria`(tipo_actividad_convocatoria,activo,gestion) VALUES (6,1,NEW.id_gestion);
	INSERT INTO `actividad_convocatoria`(tipo_actividad_convocatoria,activo,gestion) VALUES (7,1,NEW.id_gestion);
END
;;
DELIMITER ;
