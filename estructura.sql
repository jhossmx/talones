



-- Dumping structure for table pagos.c_anios
CREATE TABLE IF NOT EXISTS `c_anios` (
  `cn_id` int unsigned NOT NULL AUTO_INCREMENT,
  `da_nombre` varchar(80) NOT NULL,
  `da_status` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5;

-- Dumping data for table pagos.c_anios: ~4 rows (approximately)
/*!40000 ALTER TABLE `c_anios` DISABLE KEYS */;
INSERT INTO `c_anios` (`cn_id`, `da_nombre`, `da_status`) VALUES
	(1, '2019', 'A'),
	(2, '2020', 'A'),
	(3, '2021', 'A'),
	(4, '2022', 'A');
/*!40000 ALTER TABLE `c_anios` ENABLE KEYS */;

-- Dumping structure for table pagos.c_quincenas
CREATE TABLE IF NOT EXISTS `c_quincenas` (
  `cn_id` int unsigned NOT NULL AUTO_INCREMENT,
  `da_nombre` varchar(80) NOT NULL,
  `da_status` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25

-- Dumping data for table pagos.c_quincenas: ~24 rows (approximately)
/*!40000 ALTER TABLE `c_quincenas` DISABLE KEYS */;
INSERT INTO `c_quincenas` (`cn_id`, `da_nombre`, `da_status`) VALUES
	(1, 'Quincena 01', 'A'),
	(2, 'Quincena 02', 'A'),
	(3, 'Quincena 03', 'A'),
	(4, 'Quincena 04', 'A'),
	(5, 'Quincena 05', 'A'),
	(6, 'Quincena 06', 'A'),
	(7, 'Quincena 07', 'A'),
	(8, 'Quincena 08', 'A'),
	(9, 'Quincena 09', 'A'),
	(10, 'Quincena 10', 'A'),
	(11, 'Quincena 11', 'A'),
	(12, 'Quincena 12', 'A'),
	(13, 'Quincena 13', 'A'),
	(14, 'Quincena 14', 'A'),
	(15, 'Quincena 15', 'A'),
	(16, 'Quincena 16', 'A'),
	(17, 'Quincena 17', 'A'),
	(18, 'Quincena 18', 'A'),
	(19, 'Quincena 19', 'A'),
	(20, 'Quincena 20', 'A'),
	(21, 'Quincena 21', 'A'),
	(22, 'Quincena 22', 'A'),
	(23, 'Quincena 23', 'A'),
	(24, 'Quincena 24', 'A');
/*!40000 ALTER TABLE `c_quincenas` ENABLE KEYS */;

-- Dumping structure for table pagos.c_tiponomina
CREATE TABLE IF NOT EXISTS `c_tiponomina` (
  `cn_id` int unsigned NOT NULL AUTO_INCREMENT,
  `da_nombre` varchar(80) NOT NULL,
  `da_status` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4;

-- Dumping data for table pagos.c_tiponomina: ~3 rows (approximately)
/*!40000 ALTER TABLE `c_tiponomina` DISABLE KEYS */;
INSERT INTO `c_tiponomina` (`cn_id`, `da_nombre`, `da_status`) VALUES
	(1, 'ORDINARIA', 'A'),
	(2, 'EXTRAORDINARIA', 'A'),
	(3, 'NP', 'A');
/*!40000 ALTER TABLE `c_tiponomina` ENABLE KEYS */;

-- Dumping structure for table pagos.c_tipousuarios
CREATE TABLE IF NOT EXISTS `c_tipousuarios` (
  `cn_id` int unsigned NOT NULL AUTO_INCREMENT,
  `da_nombre` varchar(80) NOT NULL,
  `da_status` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3

-- Dumping data for table pagos.c_tipousuarios: ~2 rows (approximately)
/*!40000 ALTER TABLE `c_tipousuarios` DISABLE KEYS */;
INSERT INTO `c_tipousuarios` (`cn_id`, `da_nombre`, `da_status`) VALUES
	(1, 'ADMINISTRADOR', 'A'),
	(2, 'USUARIO', 'A');
/*!40000 ALTER TABLE `c_tipousuarios` ENABLE KEYS */;

-- Dumping structure for table pagos.c_tipo_percepcion
CREATE TABLE IF NOT EXISTS `c_tipo_percepcion` (
  `cn_id` int unsigned NOT NULL AUTO_INCREMENT,
  `da_nombre` varchar(80) NOT NULL,
  `da_status` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3;

-- Dumping data for table pagos.c_tipo_percepcion: ~2 rows (approximately)
/*!40000 ALTER TABLE `c_tipo_percepcion` DISABLE KEYS */;
INSERT INTO `c_tipo_percepcion` (`cn_id`, `da_nombre`, `da_status`) VALUES
	(1, 'PERCEPCION', 'A'),
	(2, 'DEDUCCION', 'A');
/*!40000 ALTER TABLE `c_tipo_percepcion` ENABLE KEYS */;

-- Dumping structure for table pagos.s_usuarios
CREATE TABLE IF NOT EXISTS `s_usuarios` (
  `cn_id` int unsigned NOT NULL AUTO_INCREMENT,
  `da_email` varchar(120) NOT NULL,
  `da_clave` varchar(120) NOT NULL,
  `da_nombre` varchar(80) NOT NULL,
  `da_apell1` varchar(80) NOT NULL,
  `da_apell2` varchar(80) DEFAULT NULL,
  `fn_tipousuario` int unsigned NOT NULL,
  `da_status` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cn_id`),
  UNIQUE KEY `da_email` (`da_email`),
  KEY `S_USUARIOS_fn_tipousuario_foreign` (`fn_tipousuario`),
  CONSTRAINT `S_USUARIOS_fn_tipousuario_foreign` FOREIGN KEY (`fn_tipousuario`) REFERENCES `c_tipousuarios` (`cn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3;

-- Dumping data for table pagos.s_usuarios: ~2 rows (approximately)
/*!40000 ALTER TABLE `s_usuarios` DISABLE KEYS */;
INSERT INTO `s_usuarios` (`cn_id`, `da_email`, `da_clave`, `da_nombre`, `da_apell1`, `da_apell2`, `fn_tipousuario`, `da_status`) VALUES
	(1, 'jhossmx@gmail.com', '$2y$10$f2ZQoqzqJKoWfprMGmprrOqkGBjBt6W7Em153ilnorLmLLplWBLtu', 'JOSE LUIS', 'RODRIGUEZ', 'VILLALOBOS', 1, 'A'),
	(2, 'lizbethsin@gmail.com', '$2y$10$O5E3GSOQeZe0YAZrLyfLDOVSL3tUB.scgeO0HsSvkrkULW0HzovzW', 'LIZBETH KARINA', 'LUQUE', 'OCHOA', 1, 'A');



-- Dumping data for table pagos.d_pagos: ~0 rows (approximately)
/*!40000 ALTER TABLE `d_pagos` DISABLE KEYS */;
/*!40000 ALTER TABLE `d_pagos` ENABLE KEYS */;

-- Dumping structure for table pagos.migrations
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9;

-- Dumping data for table pagos.migrations: ~8 rows (approximately)
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
	(1, '2021-05-10-162452', 'App\\Database\\Migrations\\TipoMomina', 'default', 'App', 1651458641, 1),
	(2, '2021-05-10-162453', 'App\\Database\\Migrations\\Anios', 'default', 'App', 1651458641, 1),
	(3, '2021-05-10-162454', 'App\\Database\\Migrations\\Tipousuario', 'default', 'App', 1651458641, 1),
	(4, '2021-05-10-162455', 'App\\Database\\Migrations\\Tipopercepcion', 'default', 'App', 1651458641, 1),
	(5, '2021-05-10-162456', 'App\\Database\\Migrations\\Quincenas', 'default', 'App', 1651458641, 1),
	(6, '2021-05-10-162458', 'App\\Database\\Migrations\\Users', 'default', 'App', 1651458642, 1),
	(7, '2021-05-10-171015', 'App\\Database\\Migrations\\Pagos', 'default', 'App', 1651458642, 1),
	(8, '2021-05-10-183400', 'App\\Database\\Migrations\\Detallesconceptos', 'default', 'App', 1651458642, 1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;

-- Dumping structure for table pagos.m_pagos
CREATE TABLE IF NOT EXISTS `m_pagos` (
  `cn_id` int unsigned NOT NULL AUTO_INCREMENT,
  `fn_usuario` int unsigned NOT NULL,
  `fn_nomina` int unsigned NOT NULL,
  `fn_anio` int unsigned NOT NULL,
  `fn_quincena` int unsigned NOT NULL,
  `df_fecha_pago` datetime DEFAULT NULL,
  `df_fecha_inicio_pago` datetime DEFAULT NULL,
  `df_fecha_fin_pago` datetime DEFAULT NULL,
  `dn_dias_pago` int unsigned NOT NULL,
  `dn_subtotal` float(10,2) NOT NULL,
  `dn_decucciones` float(10,2) NOT NULL,
  `dn_total` float(10,2) NOT NULL,
  `da_uuid` varchar(80) NOT NULL,
  `da_status` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cn_id`),
  KEY `M_PAGOS_fn_usuario_foreign` (`fn_usuario`),
  KEY `M_PAGOS_fn_nomina_foreign` (`fn_nomina`),
  KEY `M_PAGOS_fn_anio_foreign` (`fn_anio`),
  KEY `M_PAGOS_fn_quincena_foreign` (`fn_quincena`),
  CONSTRAINT `M_PAGOS_fn_anio_foreign` FOREIGN KEY (`fn_anio`) REFERENCES `c_anios` (`cn_id`),
  CONSTRAINT `M_PAGOS_fn_nomina_foreign` FOREIGN KEY (`fn_nomina`) REFERENCES `c_tiponomina` (`cn_id`),
  CONSTRAINT `M_PAGOS_fn_quincena_foreign` FOREIGN KEY (`fn_quincena`) REFERENCES `c_quincenas` (`cn_id`),
  CONSTRAINT `M_PAGOS_fn_usuario_foreign` FOREIGN KEY (`fn_usuario`) REFERENCES `s_usuarios` (`cn_id`)
) ENGINE=InnoDB;


-- Dumping structure for table pagos.d_pagos
CREATE TABLE IF NOT EXISTS `d_pagos` (
  `cn_id` int unsigned NOT NULL AUTO_INCREMENT,
  `fn_pago` int unsigned NOT NULL,
  `fn_usuario` int unsigned NOT NULL,
  `fn_nomina` int unsigned NOT NULL,
  `fn_anio` int unsigned NOT NULL,
  `fn_quincena` int unsigned NOT NULL,
  `fn_tipoPercepcion` int unsigned NOT NULL,
  `fn_tipoConcepto` int unsigned NOT NULL,
  `da_clave` varchar(20) NOT NULL,
  `da_descripcion` varchar(200) NOT NULL,
  `dn_importe_gravado` float(10,2) NOT NULL,
  `dn_importe_exento` float(10,2) NOT NULL,
  `da_status` varchar(1) NOT NULL DEFAULT 'A',
  PRIMARY KEY (`cn_id`),
  KEY `D_PAGOS_fn_pago_foreign` (`fn_pago`),
  KEY `D_PAGOS_fn_usuario_foreign` (`fn_usuario`),
  KEY `D_PAGOS_fn_nomina_foreign` (`fn_nomina`),
  KEY `D_PAGOS_fn_anio_foreign` (`fn_anio`),
  KEY `D_PAGOS_fn_tipoPercepcion_foreign` (`fn_tipoPercepcion`),
  KEY `D_PAGOS_fn_quincena_foreign` (`fn_quincena`),
  CONSTRAINT `D_PAGOS_fn_anio_foreign` FOREIGN KEY (`fn_anio`) REFERENCES `c_anios` (`cn_id`),
  CONSTRAINT `D_PAGOS_fn_nomina_foreign` FOREIGN KEY (`fn_nomina`) REFERENCES `c_tiponomina` (`cn_id`),
  CONSTRAINT `D_PAGOS_fn_pago_foreign` FOREIGN KEY (`fn_pago`) REFERENCES `m_pagos` (`cn_id`),
  CONSTRAINT `D_PAGOS_fn_quincena_foreign` FOREIGN KEY (`fn_quincena`) REFERENCES `c_quincenas` (`cn_id`),
  CONSTRAINT `D_PAGOS_fn_tipoPercepcion_foreign` FOREIGN KEY (`fn_tipoPercepcion`) REFERENCES `c_tipo_percepcion` (`cn_id`),
  CONSTRAINT `D_PAGOS_fn_usuario_foreign` FOREIGN KEY (`fn_usuario`) REFERENCES `s_usuarios` (`cn_id`)
) ENGINE=InnoDB;


-- Dumping data for table pagos.m_pagos: ~0 rows (approximately)
/*!40000 ALTER TABLE `m_pagos` DISABLE KEYS */;
/*!40000 ALTER TABLE `m_pagos` ENABLE KEYS */;

