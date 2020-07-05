CREATE TABLE IF NOT EXISTS `config_pdv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `id_tipo_pdv` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_config_pdv_clientes` (`id_empresa`),
  KEY `FK_config_pdv_tipo_pdv` (`id_tipo_pdv`),
  CONSTRAINT `FK_config_pdv_clientes` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_config_pdv_tipo_pdv` FOREIGN KEY (`id_tipo_pdv`) REFERENCES `tipos_pdv` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
