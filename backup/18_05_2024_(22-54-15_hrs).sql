SET FOREIGN_KEY_CHECKS=0;

CREATE DATABASE IF NOT EXISTS sigea;

USE sigea;

DROP TABLE IF EXISTS aranceles;

CREATE TABLE `aranceles` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `precio` decimal(20,2) DEFAULT NULL,
  `categoria` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estatus` tinyint(1) DEFAULT NULL,
  `tipo` varchar(15) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO aranceles VALUES ("1","Nuevo Ingreso","110.00","inscripcion","1","bolivares");
INSERT INTO aranceles VALUES ("2","Inscripción Regulares","100.00","inscripcion","1","bolivares");
INSERT INTO aranceles VALUES ("3","Certificación de Notas","4.97","documento","1","dolar");
INSERT INTO aranceles VALUES ("4","Certificación de Títulos","3.00","documento","1","dolar");
INSERT INTO aranceles VALUES ("5","Constancia de Culminación","3.00","documento","1","dolar");
INSERT INTO aranceles VALUES ("6","Acto de Grado","36.00","grado","1","dolar");
INSERT INTO aranceles VALUES ("7","Retiro de Título por Secretaría","31.00","grado","0","dolar");
INSERT INTO aranceles VALUES ("8","Reingreso-Reincorporación","2.20","inscripcion","1","dolar");
INSERT INTO aranceles VALUES ("9","Record Académico","4.98","Academico","1","dolar");
INSERT INTO aranceles VALUES ("10","Verificación de Título","3.00","documento","1","dolar");
INSERT INTO aranceles VALUES ("11","Carnet Estudiantil","3.00","academico","1","dolar");
INSERT INTO aranceles VALUES ("15","Constacia De Inscripción","100.00","academico","1","bolivares");
INSERT INTO aranceles VALUES ("18","Inscripcion Por Acreditación","120.00","inscripcion","1","bolivares");



DROP TABLE IF EXISTS bancos;

CREATE TABLE `bancos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `codigo` varchar(4) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `banco` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO bancos VALUES ("1","0102","BANCO DE VENEZUELA S.A BANCO UNIVERSAL");
INSERT INTO bancos VALUES ("2","0104","BANCO VENEZOLANO DE CREDITO S.A.");
INSERT INTO bancos VALUES ("3","0105","BANCO MERCANTIL C.A.");
INSERT INTO bancos VALUES ("4","0108","BANCO PROVINCIAL BBVA");
INSERT INTO bancos VALUES ("5","0114","BANCO DEL CARIBE C.A.");
INSERT INTO bancos VALUES ("6","0115","BANCO EXTERIOR C.A.");
INSERT INTO bancos VALUES ("7","0128","BANCO CARONI C.A. BANCO UNIVERSAL");
INSERT INTO bancos VALUES ("8","0134","BANESCO BANCO UNIVERSAL");
INSERT INTO bancos VALUES ("9","0137","BANCO SOFITASA");
INSERT INTO bancos VALUES ("10","0138","BANCO PLAZA");
INSERT INTO bancos VALUES ("11","0151","FONDO COMUN C.A BANCO UNIVERSAL");
INSERT INTO bancos VALUES ("12","0156","100%BANCO");
INSERT INTO bancos VALUES ("13","0157","DELSUR BANCO UNIVERSAL");
INSERT INTO bancos VALUES ("14","0163","BANCO DEL TESORO");
INSERT INTO bancos VALUES ("15","0166","BANCO AGRICOLA");
INSERT INTO bancos VALUES ("16","0168","BANCRECER S.A. BANCO DE DESARROLLO");
INSERT INTO bancos VALUES ("17","0169","MIBANCO BANCO DE DESARROLLO C.A.");
INSERT INTO bancos VALUES ("18","0171","BANCO ACTIVO BANCO COMERCIAL, C.A.");
INSERT INTO bancos VALUES ("19","0172","BANCAMIGA BANCO MICROFINANCIERO, C.A.");
INSERT INTO bancos VALUES ("20","0174","BANPLUS BANCO COMERCIAL C.A");
INSERT INTO bancos VALUES ("21","0175","BANCO BICENTENARIO");
INSERT INTO bancos VALUES ("22","0177","BANFANB");
INSERT INTO bancos VALUES ("23","0191","BANCO NACIONAL DE CREDITO");



DROP TABLE IF EXISTS bcv;

CREATE TABLE `bcv` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tasa` float(7,4) DEFAULT NULL,
  `fecha` date DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO bcv VALUES ("1","36.5763","2024-05-07");



DROP TABLE IF EXISTS categorias;

CREATE TABLE `categorias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO categorias VALUES ("1","documento");
INSERT INTO categorias VALUES ("2","grado");
INSERT INTO categorias VALUES ("3","Academico");
INSERT INTO categorias VALUES ("4","inscripcion");



DROP TABLE IF EXISTS datos_bancarios;

CREATE TABLE `datos_bancarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `n_referencia` varchar(8) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL DEFAULT '0',
  `imagen` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci,
  `banco` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `solicitudesId` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `solicitudesId` (`solicitudesId`),
  CONSTRAINT `FK_datos_bancarios_solicitudes` FOREIGN KEY (`solicitudesId`) REFERENCES `solicitudes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO datos_bancarios VALUES ("1","3944599","143cc90cf0482ea0a917c7ddea1c83dc.jpg","BANCO MERCANTIL C.A.","40");
INSERT INTO datos_bancarios VALUES ("2","123456","357eb8ad1398f72df7ff4f690b3043e4.jpg","BANCO DE VENEZUELA S.A BANCO UNIVERSAL","41");
INSERT INTO datos_bancarios VALUES ("3","0","imagen.jpg","notificar","42");
INSERT INTO datos_bancarios VALUES ("4","666521","6f1a832e34bbd18a88df0e09b3b12440.jpg","BANESCO BANCO UNIVERSAL","43");
INSERT INTO datos_bancarios VALUES ("5","0","imagen.jpg","notificar","44");
INSERT INTO datos_bancarios VALUES ("6","253600","imagen.jpg","BANCO DE VENEZUELA S.A BANCO UNIVERSAL","45");
INSERT INTO datos_bancarios VALUES ("8","55236","imagen.jpg","BANCO DE VENEZUELA S.A BANCO UNIVERSAL","47");
INSERT INTO datos_bancarios VALUES ("9","0","imagen.jpg","notificar","48");
INSERT INTO datos_bancarios VALUES ("10","45875","imagen.jpg","BANCO MERCANTIL C.A.","49");
INSERT INTO datos_bancarios VALUES ("11","123456","04e2be5d731d58ff120ebefbe31dc334.jpg","BANCO EXTERIOR C.A.","50");
INSERT INTO datos_bancarios VALUES ("12","0","imagen.jpg","notificar","51");
INSERT INTO datos_bancarios VALUES ("13","0","imagen.jpg","notificar","52");
INSERT INTO datos_bancarios VALUES ("14","0","imagen.jpg","notificar","53");
INSERT INTO datos_bancarios VALUES ("15","0058795","imagen.jpg","BANCO MERCANTIL C.A.","54");
INSERT INTO datos_bancarios VALUES ("16","6665441","fb8ec8dd4c9ae092a203cd5faf88a6c6.jpg","BANCO MERCANTIL C.A.","55");
INSERT INTO datos_bancarios VALUES ("17","2654914","imagen.jpg","BANCO DE VENEZUELA S.A BANCO UNIVERSAL","56");
INSERT INTO datos_bancarios VALUES ("19","0","imagen.jpg","notificar","73");
INSERT INTO datos_bancarios VALUES ("20","0","imagen.jpg","notificar","74");
INSERT INTO datos_bancarios VALUES ("21","0","imagen.jpg","notificar","75");
INSERT INTO datos_bancarios VALUES ("22","0","imagen.jpg","notificar","76");
INSERT INTO datos_bancarios VALUES ("23","123456","imagen.jpg","BANCO DE VENEZUELA S.A BANCO UNIVERSAL","77");



DROP TABLE IF EXISTS datos_personales;

CREATE TABLE `datos_personales` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombres` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `apellidos` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `telefono` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `nacionalidad` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `cedula` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pnf` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usuarioId` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuarioId` (`usuarioId`),
  CONSTRAINT `FK_datos_personales_usuarios` FOREIGN KEY (`usuarioId`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO datos_personales VALUES ("1","Luis Armando","Silva Afanador","04140999320","V","25036025","Informática","1");
INSERT INTO datos_personales VALUES ("23","Estefany Gabriela","Velasquez Rojas","04249111862","V","28375084","Informática","40");
INSERT INTO datos_personales VALUES ("24","Luis","Silva","04140999320","V","25036025","Informática","2");
INSERT INTO datos_personales VALUES ("27","Luis","Da Silva","04147894511","V","13799477","Materiales Industriales","45");



DROP TABLE IF EXISTS pnf;

CREATE TABLE `pnf` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO pnf VALUES ("1","Informática");
INSERT INTO pnf VALUES ("2","Materiales Industriales");
INSERT INTO pnf VALUES ("3","Higiene y Seguridad Laboral");
INSERT INTO pnf VALUES ("4","Electricidad");
INSERT INTO pnf VALUES ("5","Geociencias");
INSERT INTO pnf VALUES ("6","Mecánica");
INSERT INTO pnf VALUES ("7","Química");
INSERT INTO pnf VALUES ("8","Orfebrería y Joyería");
INSERT INTO pnf VALUES ("9","Sistemas de Calidad y Ambiente");
INSERT INTO pnf VALUES ("10","Agroalimentación");
INSERT INTO pnf VALUES ("11","Ingenería de Mantenimiento");
INSERT INTO pnf VALUES ("12","Distribución y Logística");



DROP TABLE IF EXISTS preguntas_seguridad;

CREATE TABLE `preguntas_seguridad` (
  `id` int NOT NULL AUTO_INCREMENT,
  `pregunta1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `respuesta1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `pregunta2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `respuesta2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `usuarioId` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `usuarioId` (`usuarioId`),
  CONSTRAINT `FK_preguntas_seguridad_usuarios` FOREIGN KEY (`usuarioId`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO preguntas_seguridad VALUES ("1","¿Cuál es el nombre de tu flor favorita?","isoras","¿Cuál es el nombre de tu videojuego preferido?","mortal kombat","1");
INSERT INTO preguntas_seguridad VALUES ("6","mi gato","niño","el novio de mi gato","baka","40");
INSERT INTO preguntas_seguridad VALUES ("8","color favorito","azul","comida favorita","pasta","2");
INSERT INTO preguntas_seguridad VALUES ("11","comida favorita","espagueti","color favorito","azul","45");



DROP TABLE IF EXISTS solicitudes;

CREATE TABLE `solicitudes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `aranceles` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `categoria` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `total` float(8,2) DEFAULT NULL,
  `estatus` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT 'por pagar',
  `pnf` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `n_solicitud` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `fecha_creacion` date DEFAULT NULL,
  `fecha_expiracion` date DEFAULT NULL,
  `hora` time DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO solicitudes VALUES ("40","Carnet Estudiantil","academico","108.21","listo","Informática","00001","2023-02-23","2023-02-24","18:00:13");
INSERT INTO solicitudes VALUES ("41","Record Académico","documento","179.63","pendiente","Informática","00002","2024-02-24","2024-02-25","19:00:00");
INSERT INTO solicitudes VALUES ("42","Verificación de Título","documento","108.21","expirado","Informática","00003","2024-02-24","2024-02-25","20:00:00");
INSERT INTO solicitudes VALUES ("43","Record Académico","documento","179.63","pendiente","Informática","00004","2024-02-24","2024-02-25","20:30:11");
INSERT INTO solicitudes VALUES ("44","Verificación de Título","documento","108.21","expirado","Informática","00005","2024-02-23","2024-02-24","11:52:00");
INSERT INTO solicitudes VALUES ("45","Carnet Estudiantil","academico","108.21","verificado","Informática","00006","2024-02-25","2024-02-26","15:53:00");
INSERT INTO solicitudes VALUES ("47","Certificación de Notas","documento","179.27","verificado","Informática","00007","2024-02-25","2024-02-26","18:01:00");
INSERT INTO solicitudes VALUES ("48","Verificación de Título","documento","108.21","expirado","Informática","00008","2024-02-25","2024-02-26","18:03:00");
INSERT INTO solicitudes VALUES ("49","Acto de Grado","grado","1298.51","pendiente","Informática","00009","2024-02-25","2024-02-26","18:04:00");
INSERT INTO solicitudes VALUES ("50","Certificación de Notas","documento","179.32","verificado","Informática","00010","2024-03-02","2024-03-03","07:23:00");
INSERT INTO solicitudes VALUES ("51","Carnet Estudiantil","academico","108.24","expirado","Informática","00011","2024-03-02","2024-03-03","12:45:00");
INSERT INTO solicitudes VALUES ("52","Nuevo Ingreso","inscripcion","79.38","expirado","Informática","00012","2024-03-02","2024-03-03","13:34:00");
INSERT INTO solicitudes VALUES ("53","Carnet Estudiantil","academico","108.24","expirado","Informática","00013","2024-03-13","2024-03-14","18:32:00");
INSERT INTO solicitudes VALUES ("54","Verificación de Título","documento","109.00","listo","Informática","00014","2024-03-28","2024-03-29","18:05:00");
INSERT INTO solicitudes VALUES ("55","Constancia de Culminación","documento","109.00","verificado","Informática","00015","2024-04-04","2024-04-05","19:14:00");
INSERT INTO solicitudes VALUES ("56","Nuevo Ingreso","inscripcion","110.00","listo","Informática","00016","2024-04-07","2024-04-08","15:24:00");
INSERT INTO solicitudes VALUES ("73","Carnet Estudiantil","academico","108.68","por pagar","Materiales Industriales","00017","2024-05-05","2024-05-06","17:49:00");
INSERT INTO solicitudes VALUES ("74","Certificación de Notas","documento","181.78","expirado","Informática","00018","2024-05-09","2024-05-10","08:17:00");
INSERT INTO solicitudes VALUES ("75","Certificación de Notas, Verificación de Título","documento","291.51","expirado","Informática","00019","2024-05-09","2024-05-10","08:28:00");
INSERT INTO solicitudes VALUES ("76","Certificación de Notas","documento","181.78","expirado","Informática","00020","2024-05-10","2024-05-11","11:02:00");
INSERT INTO solicitudes VALUES ("77","Certificación de Notas, Verificación de Título","documento","291.51","verificado","Informática","00021","2024-05-18","2024-05-19","22:17:00");



DROP TABLE IF EXISTS solicitudes_estudiantes;

CREATE TABLE `solicitudes_estudiantes` (
  `id` int NOT NULL AUTO_INCREMENT,
  `datos_personalesId` int DEFAULT NULL,
  `solicitudesId` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `solicitudesId` (`solicitudesId`),
  KEY `datos_personalesId` (`datos_personalesId`),
  CONSTRAINT `FK_solicitudes_estudiantes_datos_personales` FOREIGN KEY (`datos_personalesId`) REFERENCES `datos_personales` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_solicitudes_estudiantes_solicitudes` FOREIGN KEY (`solicitudesId`) REFERENCES `solicitudes` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO solicitudes_estudiantes VALUES ("43","1","40");
INSERT INTO solicitudes_estudiantes VALUES ("44","1","41");
INSERT INTO solicitudes_estudiantes VALUES ("45","1","42");
INSERT INTO solicitudes_estudiantes VALUES ("46","1","44");
INSERT INTO solicitudes_estudiantes VALUES ("47","1","45");
INSERT INTO solicitudes_estudiantes VALUES ("48","1","47");
INSERT INTO solicitudes_estudiantes VALUES ("49","1","48");
INSERT INTO solicitudes_estudiantes VALUES ("50","1","50");
INSERT INTO solicitudes_estudiantes VALUES ("51","1","51");
INSERT INTO solicitudes_estudiantes VALUES ("52","1","52");
INSERT INTO solicitudes_estudiantes VALUES ("53","1","53");
INSERT INTO solicitudes_estudiantes VALUES ("54","1","54");
INSERT INTO solicitudes_estudiantes VALUES ("55","1","55");
INSERT INTO solicitudes_estudiantes VALUES ("56","1","56");
INSERT INTO solicitudes_estudiantes VALUES ("57","27","73");
INSERT INTO solicitudes_estudiantes VALUES ("58","1","74");
INSERT INTO solicitudes_estudiantes VALUES ("59","1","75");
INSERT INTO solicitudes_estudiantes VALUES ("60","1","76");
INSERT INTO solicitudes_estudiantes VALUES ("61","1","77");



DROP TABLE IF EXISTS usuarios;

CREATE TABLE `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `correo` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `password` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `rol` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `estatus` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO usuarios VALUES ("1","luisilva96.ls@gmail.com","$2y$10$XcFoDuHX11MGXaocpirPJOC.GH3efgwJC/aqlsvHIEtOhn4kAAFfi","estudiante","1");
INSERT INTO usuarios VALUES ("2","admin@gmail.com","$2y$10$e/e4XVoeesARkD4meVVvseXObKP3Rmrv2UuIys/GOmIKdn8iq6Tvy","admin","1");
INSERT INTO usuarios VALUES ("40","estefany.rojas.200@gmail.com","$2y$10$oDtQdnwl3FsWmULJ0Ms1zeTWY2qUdawPTH4oEm9.bmXqj9/B9GuDC","estudiante","1");
INSERT INTO usuarios VALUES ("45","poetic_96@gmail.com","$2y$10$9zdbN0dhEL19p5PeVuWPMOLlXUnYOed2YWc4e6pQ9KiqTCiLajUde","estudiante","0");



SET FOREIGN_KEY_CHECKS=1;