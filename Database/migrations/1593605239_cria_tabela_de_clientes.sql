-- Copiando estrutura para tabela syst.clientes
CREATE TABLE IF NOT EXISTS `clientes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `id_cliente_tipo` int(11) NOT NULL,
  `id_cliente_segmento` int(11) DEFAULT NULL,
  `nome` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `cnpj` varchar(50) DEFAULT NULL,
  `cpf` varchar(50) DEFAULT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `celular` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_clientes_tipos_clientes` (`id_cliente_tipo`),
  KEY `FK_clientes_clientes_segmentos` (`id_cliente_segmento`),
  KEY `FK_clientes_empresas` (`id_empresa`),
  CONSTRAINT `FK_clientes_clientes_segmentos` FOREIGN KEY (`id_cliente_segmento`) REFERENCES `clientes_segmentos` (`id`),
  CONSTRAINT `FK_clientes_empresas` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_clientes_tipos_clientes` FOREIGN KEY (`id_cliente_tipo`) REFERENCES `clientes_tipos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
