-- --------------------------------------------------------
-- Servidor:                     abitat.cndd5nogbuuf.us-east-2.rds.amazonaws.com
-- Versão do servidor:           5.7.26-log - Source distribution
-- OS do Servidor:               Linux
-- HeidiSQL Versão:              10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

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
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.clientes: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`id`, `id_empresa`, `id_cliente_tipo`, `id_cliente_segmento`, `nome`, `email`, `cnpj`, `cpf`, `telefone`, `celular`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(2, 1, 2, 2, 'Açaí dos meus Sonhos', 'acaidosmeussonhos@gmail.com', '16.138.154/0001-84', NULL, '(71) 9873-9218', '(71) 45564-6556', '2020-05-28 17:46:58', '2020-06-10 13:37:17', NULL),
	(4, 1, 1, 4, 'Mariana Luna de Jesus', 'mariana@gmail.com', '80.006.659/1854-54', '896.811.810-64', '(71) 9873-9218', '(71) 98530-0528', '2020-05-28 18:23:59', '2020-06-10 12:33:31', NULL),
	(5, 1, 2, 3, 'Pizzaria Segue o Baile', 'pizzariasegueobaile@hotmail.com', '50.902.478/0001-081', NULL, '(71) 98739-2183', '(71)98530-0528', '2020-05-28 21:13:44', '2020-06-10 12:33:27', NULL),
	(7, 1, 2, 2, 'Limpa Cano', 'limpacano@gmail.com', '41.977.238/0001-59', NULL, '(71) 9873-9218', '(71) 45564-6556', '2020-05-31 17:25:50', '2020-06-10 13:31:34', NULL),
	(18, 1, 2, 4, 'Têxtil Sul ', 'textilsul@hotmail.com', '84.039.937/0001-60', '', '(71) 5656-5656', '(71) 54665-6566', '2020-06-10 12:35:59', '2020-06-10 12:35:59', NULL);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Copiando estrutura para tabela syst.clientes_enderecos
CREATE TABLE IF NOT EXISTS `clientes_enderecos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL DEFAULT '0',
  `id_cliente` int(11) NOT NULL DEFAULT '0',
  `cep` varchar(50) DEFAULT NULL,
  `endereco` varchar(50) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `cidade` varchar(50) DEFAULT NULL,
  `estado` varchar(50) DEFAULT NULL,
  `numero` int(11) DEFAULT NULL,
  `complemento` text,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_clientes_enderecos_empresas` (`id_empresa`),
  KEY `FK_clientes_enderecos_clientes` (`id_cliente`),
  CONSTRAINT `FK_clientes_enderecos_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  CONSTRAINT `FK_clientes_enderecos_empresas` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.clientes_enderecos: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes_enderecos` DISABLE KEYS */;
INSERT INTO `clientes_enderecos` (`id`, `id_empresa`, `id_cliente`, `cep`, `endereco`, `bairro`, `cidade`, `estado`, `numero`, `complemento`, `created_at`, `updated_at`) VALUES
	(3, 1, 4, '41927210', '2ª travessa são benedito', 'Chapada do Rio vermelho', 'salvador', 'Bahia', 14, NULL, '2020-05-29 12:30:33', '2020-05-29 22:04:00'),
	(4, 1, 4, '41927210', '2ª travessa são benedito', 'Chapada do Rio vermelho', 'salvador', 'Bahia', 14, ' bg ', '2020-05-29 12:31:48', '2020-05-29 12:31:48'),
	(5, 1, 4, '41927210', '2ª travessa são benedito', 'Chapada do Rio vermelho', 'salvador', 'Bahia', 56, 'Casa', '2020-05-29 12:32:23', '2020-05-29 14:11:53'),
	(18, 1, 4, '41.927-210', '2ª Travessa São Benedito', 'Santa Cruz', 'Salvador', 'BA', 15, '', '2020-06-08 10:11:00', '2020-06-08 10:11:00');
/*!40000 ALTER TABLE `clientes_enderecos` ENABLE KEYS */;

-- Copiando estrutura para tabela syst.clientes_segmentos
CREATE TABLE IF NOT EXISTS `clientes_segmentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.clientes_segmentos: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes_segmentos` DISABLE KEYS */;
INSERT INTO `clientes_segmentos` (`id`, `descricao`, `created_at`, `updated_at`) VALUES
	(1, 'Restaurante', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(2, 'Hamburgueria', '2020-05-28 10:28:08', '2020-05-28 10:28:09'),
	(3, 'Pizzaria', '2020-05-28 10:28:52', '2020-05-28 10:28:53'),
	(4, 'Outros...', '2020-06-02 00:00:26', '2020-06-02 00:00:27');
/*!40000 ALTER TABLE `clientes_segmentos` ENABLE KEYS */;

-- Copiando estrutura para tabela syst.clientes_tipos
CREATE TABLE IF NOT EXISTS `clientes_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.clientes_tipos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes_tipos` DISABLE KEYS */;
INSERT INTO `clientes_tipos` (`id`, `descricao`, `created_at`, `updated_at`) VALUES
	(1, 'Pessoa Fisica', '2020-05-28 10:24:51', '2020-05-28 10:24:52'),
	(2, 'Pessoa Juridica', '2020-05-28 10:25:05', '2020-05-28 10:25:06');
/*!40000 ALTER TABLE `clientes_tipos` ENABLE KEYS */;

-- Copiando estrutura para tabela syst.config_pdv
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

-- Copiando dados para a tabela syst.config_pdv: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `config_pdv` DISABLE KEYS */;
INSERT INTO `config_pdv` (`id`, `id_empresa`, `id_tipo_pdv`, `created_at`, `updated_at`) VALUES
	(3, 1, 2, '2020-05-23 15:37:10', '2020-06-08 21:34:09');
/*!40000 ALTER TABLE `config_pdv` ENABLE KEYS */;

-- Copiando estrutura para tabela syst.empresas
CREATE TABLE IF NOT EXISTS `empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.empresas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` (`id`, `nome`, `created_at`, `updated_at`) VALUES
	(1, 'Cliente Teste', '2020-04-23 21:36:33', '2020-04-23 21:36:33');
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;

-- Copiando estrutura para tabela syst.meios_pagamentos
CREATE TABLE IF NOT EXISTS `meios_pagamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `legenda` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.meios_pagamentos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `meios_pagamentos` DISABLE KEYS */;
INSERT INTO `meios_pagamentos` (`id`, `legenda`, `created_at`, `updated_at`) VALUES
	(1, 'Dinheiro', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(2, 'Crédito', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(3, 'Débito', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `meios_pagamentos` ENABLE KEYS */;

-- Copiando estrutura para tabela syst.perfis
CREATE TABLE IF NOT EXISTS `perfis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.perfis: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `perfis` DISABLE KEYS */;
INSERT INTO `perfis` (`id`, `descricao`, `created_at`, `updated_at`) VALUES
	(1, 'Zig-Admin', '2020-04-25 00:53:23', '0000-00-00 00:00:00'),
	(2, 'Admin', '2020-04-25 00:53:27', '0000-00-00 00:00:00'),
	(4, 'Vendedor', '2020-04-25 00:53:32', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `perfis` ENABLE KEYS */;

-- Copiando estrutura para tabela syst.produtos
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `preco` double NOT NULL DEFAULT '0',
  `descricao` text,
  `imagem` text,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_produtos_clientes` (`id_empresa`),
  CONSTRAINT `FK_produtos_clientes` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.produtos: ~9 rows (aproximadamente)
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` (`id`, `id_empresa`, `nome`, `preco`, `descricao`, `imagem`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Açái Tradicional', 10.5, 'Tigela de Açaí tradicional!', 'public/imagem/produtos/1589923097.jpg', '2020-05-19 17:13:05', '2020-05-25 08:36:19'),
	(2, 1, 'Açaí de Banana', 13, 'bghghg', 'public/imagem/produtos/1589919313.jpg', '2020-05-19 17:15:13', '2020-05-19 17:15:13'),
	(3, 1, 'Dell Vale de Uva', 18, 'Néctar de Uva Del Valle 1 Litro', 'public/imagem/produtos/1589923950.jpg', '2020-05-19 18:32:30', '2020-05-19 18:32:30'),
	(4, 1, 'Guaraná Antárctica', 3.49, '', 'public/imagem/produtos/1590197371.jpg', '2020-05-22 22:29:31', '2020-05-22 22:29:31'),
	(5, 1, 'Refrigerante zero coca-cola', 3.99, '', 'public/imagem/produtos/1590197622.jpg', '2020-05-22 22:33:42', '2020-05-22 22:33:42'),
	(6, 1, 'HAMBÚRGUER', 30, '', 'public/imagem/produtos/1590197749.jpg', '2020-05-22 22:35:49', '2020-05-22 22:35:49'),
	(7, 1, 'ESTROGONOFE', 25, '', 'public/imagem/produtos/1590197916.jpg', '2020-05-22 22:38:36', '2020-05-22 22:38:36'),
	(8, 1, 'Computador completo', 1500, '', 'public/imagem/produtos/1591662766.png', '2020-06-08 21:32:46', '2020-06-08 21:32:46'),
	(9, 1, 'Notebook Samsung ', 2580, 'Notebook Samsung Intel Core i3 4GB 1TB Tela 15,6" Windows 10 Home ', 'public/imagem/produtos/1591663383.png', '2020-06-08 21:43:03', '2020-06-08 21:43:03');
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;

-- Copiando estrutura para tabela syst.sexos
CREATE TABLE IF NOT EXISTS `sexos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.sexos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `sexos` DISABLE KEYS */;
INSERT INTO `sexos` (`id`, `descricao`, `created_at`, `updated_at`) VALUES
	(1, 'Masculino', '2020-02-21 14:08:58', '0000-00-00 00:00:00'),
	(2, 'Feminino', '2020-02-21 14:09:09', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `sexos` ENABLE KEYS */;

-- Copiando estrutura para tabela syst.tipos_pdv
CREATE TABLE IF NOT EXISTS `tipos_pdv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.tipos_pdv: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `tipos_pdv` DISABLE KEYS */;
INSERT INTO `tipos_pdv` (`id`, `descricao`, `created_at`, `updated_at`) VALUES
	(1, 'Padrão', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(2, 'Diferencial', '2020-05-23 17:02:09', '2020-05-23 17:02:09');
/*!40000 ALTER TABLE `tipos_pdv` ENABLE KEYS */;

-- Copiando estrutura para tabela syst.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL DEFAULT '0',
  `nome` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `id_sexo` int(11) DEFAULT NULL,
  `id_perfil` int(11) DEFAULT NULL,
  `imagem` text,
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_usuarios_sexo` (`id_sexo`),
  KEY `FK_usuarios_perfis` (`id_perfil`),
  KEY `FK_usuarios_clientes` (`id_empresa`),
  CONSTRAINT `FK_usuarios_clientes` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_usuarios_perfis` FOREIGN KEY (`id_perfil`) REFERENCES `perfis` (`id`),
  CONSTRAINT `FK_usuarios_sexo` FOREIGN KEY (`id_sexo`) REFERENCES `sexos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.usuarios: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`, `id_empresa`, `nome`, `email`, `password`, `id_sexo`, `id_perfil`, `imagem`, `created_at`, `updated_at`) VALUES
	(1, 1, 'França', 'admin@admin.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 2, 'public/imagem/perfil_usuarios/1585493352.jpg', '2020-05-27 18:29:11', '2020-05-27 15:29:09'),
	(2, 1, 'Renata de Jesus Lima', 'renata@hotmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 2, 4, 'public/imagem/perfil_usuarios/1585493808.png', '2020-05-24 17:21:48', '2020-05-24 14:21:45'),
	(35, 1, 'João de Jesus', 'joao@gmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 4, 'public/imagem/perfil_usuarios/1585493875.png', '2020-05-24 17:22:05', '2020-05-24 14:22:01'),
	(36, 1, 'Mariana Pinheiro', 'mariana@gmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 2, 4, 'public/imagem/perfil_usuarios/1585494012.png', '2020-04-25 00:54:55', '2020-03-29 15:00:12'),
	(38, 1, 'Margarida Dantas', 'margarida@hotmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 2, 4, 'public/imagem/perfil_usuarios/1585493941.png', '2020-04-25 22:03:29', '2020-03-29 14:59:01'),
	(42, 1, 'Leonardo Dodge', 'leonardo@gmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 4, 'public/imagem/perfil_usuarios/1585494107.png', '2020-04-25 00:54:48', '2020-03-29 15:01:47'),
	(43, 1, 'Testador', 'testador@gmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 1, 'public/imagem/perfil_usuarios/1587774607.jpg', '2020-04-25 00:55:18', '2020-04-25 00:30:07'),
	(46, 1, 'g6yg6yy', 'ffffff@admin.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 2, 'public/imagem/perfil_usuarios/1591646091.pdf', '2020-06-08 16:54:51', '2020-06-08 16:54:51'),
	(47, 1, '', ' nhnhhhjhjhjhjhjn@admin.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 2, 'public/imagem/perfil_usuarios/1591649929.pdf', '2020-06-08 17:58:49', '2020-06-08 17:58:49'),
	(48, 1, 'França França dos Santos', '44rc4@acdmin.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 1, 'public/imagem/perfil_usuarios/1591650006.pdf', '2020-06-08 18:00:06', '2020-06-08 18:00:06');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

-- Copiando estrutura para tabela syst.vendas
CREATE TABLE IF NOT EXISTS `vendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_meio_pagamento` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `preco` double DEFAULT '0',
  `quantidade` int(11) DEFAULT NULL,
  `valor` double NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vendas_meios_de_pagamento` (`id_meio_pagamento`),
  KEY `FK_vendas_usuarios` (`id_usuario`),
  KEY `FK_vendas_clientes` (`id_empresa`),
  CONSTRAINT `FK_vendas_clientes` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_vendas_meios_de_pagamento` FOREIGN KEY (`id_meio_pagamento`) REFERENCES `meios_pagamentos` (`id`),
  CONSTRAINT `FK_vendas_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=164 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.vendas: ~83 rows (aproximadamente)
/*!40000 ALTER TABLE `vendas` DISABLE KEYS */;
INSERT INTO `vendas` (`id`, `id_usuario`, `id_meio_pagamento`, `id_empresa`, `id_produto`, `preco`, `quantidade`, `valor`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 1, 0, 0, 0, 11, '2020-04-25 01:58:13', '2020-04-25 01:58:13'),
	(2, 1, 3, 1, 0, 0, 0, 12, '2020-04-25 01:58:43', '2020-04-25 01:58:43'),
	(3, 1, 2, 1, 0, 0, 0, 50, '2020-04-25 01:59:08', '2020-04-25 01:59:08'),
	(6, 38, 2, 1, 0, 0, 0, 40, '2020-04-25 19:22:24', '2020-04-25 19:22:24'),
	(8, 38, 3, 1, 0, 0, 0, 20, '2020-04-25 20:35:46', '2020-04-25 20:35:46'),
	(9, 38, 1, 1, 0, 0, 0, 12, '2020-04-25 21:38:50', '2020-04-25 21:38:50'),
	(10, 1, 1, 1, 0, 0, 0, 10, '2020-04-25 21:47:54', '2020-04-25 21:47:54'),
	(11, 38, 1, 1, 0, 0, 0, 15, '2020-04-26 09:26:22', '2020-04-26 09:26:22'),
	(12, 38, 2, 1, 0, 0, 0, 30, '2020-04-26 09:28:52', '2020-04-26 09:28:52'),
	(15, 38, 1, 1, 0, 0, 0, 15, '2020-04-26 09:49:29', '2020-04-26 09:49:29'),
	(16, 38, 3, 1, 0, 0, 0, 16, '2020-04-26 09:49:55', '2020-04-26 09:49:55'),
	(17, 1, 1, 1, 0, 0, 0, 25, '2020-04-27 23:08:22', '2020-04-27 23:08:22'),
	(18, 1, 2, 1, 0, 0, 0, 20, '2020-04-27 23:09:58', '2020-04-27 23:09:58'),
	(19, 38, 3, 1, 0, 0, 0, 15, '2020-04-27 23:10:28', '2020-04-27 23:10:28'),
	(20, 36, 1, 1, 0, 0, 0, 15, '2020-04-27 23:11:56', '2020-04-27 23:11:56'),
	(21, 1, 1, 1, 0, 0, 0, 15, '2020-04-28 16:03:18', '2020-04-28 16:03:18'),
	(22, 35, 2, 1, 0, 0, 0, 50, '2020-04-28 16:04:06', '2020-04-28 16:04:06'),
	(23, 36, 3, 1, 0, 0, 0, 12, '2020-04-28 16:04:24', '2020-04-28 16:04:24'),
	(24, 2, 1, 1, 0, 0, 0, 12, '2020-04-28 17:20:26', '2020-04-28 17:20:26'),
	(25, 1, 1, 1, 0, 0, 0, 15, '2020-04-28 17:45:52', '2020-04-28 17:45:52'),
	(26, 1, 1, 1, 0, 0, 0, 15, '2020-05-01 20:02:12', '2020-05-01 20:02:12'),
	(27, 35, 3, 1, 0, 0, 0, 25, '2020-05-01 20:02:36', '2020-05-01 20:02:36'),
	(28, 36, 2, 1, 0, 0, 0, 50, '2020-05-01 20:03:39', '2020-05-01 20:03:39'),
	(29, 36, 1, 1, 0, 0, 0, 12, '2020-05-01 20:52:10', '2020-05-01 20:52:10'),
	(30, 42, 1, 1, 0, 0, 0, 30, '2020-05-01 21:12:46', '2020-05-01 21:12:46'),
	(32, 1, 1, 1, 0, 0, 0, 0, '2020-05-03 13:32:15', '2020-05-03 13:32:15'),
	(33, 1, 1, 1, 0, 0, 0, 25, '2020-05-03 13:53:42', '2020-05-03 13:53:42'),
	(34, 1, 1, 1, 0, 0, 0, 50, '2020-05-05 21:35:54', '2020-05-05 21:35:54'),
	(35, 1, 3, 1, 0, 0, 0, 15, '2020-05-05 21:36:48', '2020-05-05 21:36:48'),
	(36, 35, 2, 1, 0, 0, 0, 12, '2020-05-05 21:55:46', '2020-05-05 21:55:46'),
	(37, 38, 2, 1, 0, 0, 0, 50, '2020-05-05 21:57:05', '2020-05-05 21:57:05'),
	(38, 1, 1, 1, 0, 0, 0, 15, '2020-05-16 03:05:30', '2020-05-16 03:05:30'),
	(39, 36, 3, 1, 0, 0, 0, 10, '2020-05-16 03:06:11', '2020-05-16 03:06:11'),
	(40, 1, 2, 1, 0, 0, 0, 25, '2020-05-16 18:26:12', '2020-05-16 18:26:12'),
	(41, 1, 3, 1, 0, 0, 0, 12, '2020-05-17 18:41:09', '2020-05-17 18:41:09'),
	(53, 1, 1, 1, 0, 0, 0, 2445, '2020-05-18 22:09:49', '2020-05-18 22:09:49'),
	(54, 1, 1, 1, 0, 0, 0, 2445, '2020-05-18 22:10:36', '2020-05-18 22:10:36'),
	(55, 1, 1, 1, 0, 0, 0, 2445.85, '2020-05-18 22:15:01', '2020-05-18 22:15:01'),
	(56, 1, 1, 1, 0, 0, 0, 2440.8, '2020-05-18 22:16:09', '2020-05-18 22:16:09'),
	(57, 1, 1, 1, 0, 0, 0, 25, '2020-05-18 22:16:28', '2020-05-18 22:16:28'),
	(58, 1, 1, 1, 0, 0, 0, 15.45, '2020-05-18 22:17:17', '2020-05-18 22:17:17'),
	(59, 1, 2, 1, 0, 0, 0, 1000, '2020-05-18 22:23:19', '2020-05-18 22:23:19'),
	(60, 1, 1, 1, 0, 0, 0, 1500, '2020-05-18 22:25:07', '2020-05-18 22:25:07'),
	(61, 36, 3, 1, 0, 0, 0, 1250, '2020-05-18 22:28:53', '2020-05-18 22:28:53'),
	(125, 1, 1, 1, 6, 30, 2, 60, '2020-05-23 01:32:46', '2020-05-23 01:32:46'),
	(126, 1, 1, 1, 5, 3.99, 2, 7.98, '2020-05-23 01:32:47', '2020-05-23 01:32:47'),
	(127, 1, 1, 1, 2, 13, 1, 13, '2020-05-23 18:50:07', '2020-05-23 18:50:07'),
	(128, 1, 1, 1, NULL, 0, NULL, 5, '2020-05-23 18:52:59', '2020-05-23 18:52:59'),
	(129, 1, 1, 1, NULL, 0, NULL, 15, '2020-05-24 14:20:28', '2020-05-24 14:20:28'),
	(130, 2, 3, 1, NULL, 0, NULL, 25, '2020-05-24 14:22:36', '2020-05-24 14:22:36'),
	(131, 42, 2, 1, NULL, 0, NULL, 120.1, '2020-05-24 14:23:43', '2020-05-24 14:23:43'),
	(132, 36, 2, 1, NULL, 0, NULL, 203.5, '2020-05-24 14:25:15', '2020-05-24 14:25:15'),
	(133, 1, 1, 1, 6, 30, 2, 60, '2020-05-25 08:56:17', '2020-05-25 08:56:17'),
	(134, 1, 1, 1, 5, 3.99, 1, 3.99, '2020-05-25 08:56:18', '2020-05-25 08:56:18'),
	(135, 1, 1, 1, 4, 3.49, 1, 3.49, '2020-05-25 08:56:19', '2020-05-25 08:56:19'),
	(136, 1, 1, 1, 7, 25, 1, 25, '2020-05-25 08:56:19', '2020-05-25 08:56:19'),
	(137, 1, 1, 1, NULL, 0, NULL, 0.1, '2020-05-25 16:52:15', '2020-05-25 16:52:15'),
	(138, 1, 2, 1, NULL, 0, NULL, 50, '2020-05-25 16:54:22', '2020-05-25 16:54:22'),
	(139, 1, 1, 1, NULL, 0, NULL, 25.2, '2020-05-25 23:14:09', '2020-05-25 23:14:09'),
	(140, 1, 3, 1, 6, 30, 1, 30, '2020-05-25 23:16:01', '2020-05-25 23:16:01'),
	(141, 1, 3, 1, 4, 3.49, 1, 3.49, '2020-05-25 23:16:02', '2020-05-25 23:16:02'),
	(142, 1, 2, 1, 6, 30, 1, 30, '2020-05-26 15:14:51', '2020-05-26 15:14:51'),
	(143, 1, 1, 1, 2, 13, 1, 13, '2020-05-27 05:24:56', '2020-05-27 05:24:56'),
	(144, 1, 1, 1, 5, 3.99, 1, 3.99, '2020-05-27 05:24:56', '2020-05-27 05:24:56'),
	(145, 1, 1, 1, 1, 10.5, 1, 10.5, '2020-05-27 05:24:57', '2020-05-27 05:24:57'),
	(146, 1, 2, 1, 3, 18, 1, 18, '2020-05-27 15:30:00', '2020-05-27 15:30:00'),
	(147, 1, 2, 1, 2, 13, 1, 13, '2020-05-27 15:30:04', '2020-05-27 15:30:04'),
	(148, 1, 2, 1, 5, 3.99, 2, 7.98, '2020-05-27 15:30:05', '2020-05-27 15:30:05'),
	(149, 1, 2, 1, 6, 30, 1, 30, '2020-05-27 15:30:07', '2020-05-27 15:30:07'),
	(150, 36, 3, 1, NULL, 0, NULL, 17, '2020-05-27 15:33:16', '2020-05-27 15:33:16'),
	(151, 1, 1, 1, 7, 25, 1, 25, '2020-05-28 22:14:06', '2020-05-28 22:14:06'),
	(152, 1, 1, 1, 4, 3.49, 2, 6.98, '2020-05-30 03:07:19', '2020-05-30 03:07:19'),
	(153, 1, 1, 1, 2, 13, 1, 13, '2020-06-06 01:59:38', '2020-06-06 01:59:38'),
	(154, 1, 1, 1, 1, 10.5, 5, 52.5, '2020-06-06 01:59:39', '2020-06-06 01:59:39'),
	(155, 1, 2, 1, 3, 18, 1, 18, '2020-06-06 20:45:01', '2020-06-06 20:45:01'),
	(156, 1, 2, 1, 4, 3.49, 1, 3.49, '2020-06-06 20:45:01', '2020-06-06 20:45:01'),
	(157, 35, 3, 1, NULL, 0, NULL, 25, '2020-06-06 20:45:48', '2020-06-06 20:45:48'),
	(158, 1, 1, 1, NULL, 0, NULL, 15, '2020-06-07 09:47:32', '2020-06-07 09:47:32'),
	(159, 38, 3, 1, NULL, 0, NULL, 38, '2020-06-08 10:38:15', '2020-06-08 10:38:15'),
	(160, 38, 2, 1, NULL, 0, NULL, 250, '2020-06-08 11:26:59', '2020-06-08 11:26:59'),
	(161, 1, 2, 1, 8, 1500, 1, 1500, '2020-06-08 21:35:16', '2020-06-08 21:35:16'),
	(162, 1, 2, 1, 9, 2580, 1, 2580, '2020-06-08 21:43:41', '2020-06-08 21:43:41'),
	(163, 1, 2, 1, 8, 1500, 1, 1500, '2020-06-08 21:43:42', '2020-06-08 21:43:42');
/*!40000 ALTER TABLE `vendas` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
