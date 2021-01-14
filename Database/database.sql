-- --------------------------------------------------------
-- Servidor:                     162.241.2.127
-- Versão do servidor:           5.7.21-21 - Percona Server (GPL), Release 21, Revision 2a37e4e
-- OS do Servidor:               Linux
-- HeidiSQL Versão:              10.3.0.5771
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Copiando estrutura para tabela robotece_zig.clientes
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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_clientes_tipos_clientes` (`id_cliente_tipo`),
  KEY `FK_clientes_clientes_segmentos` (`id_cliente_segmento`),
  KEY `FK_clientes_empresas` (`id_empresa`),
  CONSTRAINT `FK_clientes_clientes_segmentos` FOREIGN KEY (`id_cliente_segmento`) REFERENCES `clientes_segmentos` (`id`),
  CONSTRAINT `FK_clientes_empresas` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_clientes_tipos_clientes` FOREIGN KEY (`id_cliente_tipo`) REFERENCES `clientes_tipos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.clientes: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`id`, `id_empresa`, `id_cliente_tipo`, `id_cliente_segmento`, `nome`, `email`, `cnpj`, `cpf`, `telefone`, `celular`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(2, 1, 2, 2, 'Açaí dos meus Sonhos', 'acaidosmeussonhos@gmail.com', '16.138.154/0001-84', NULL, '(71) 9873-9218', '(71) 45564-6556', '2020-05-28 17:46:58', '2020-06-10 13:37:17', NULL),
	(4, 1, 1, 4, 'Mariana Luna de Jesus', 'mariana@gmail.com', '80.006.659/1854-54', '896.811.810-64', '(71) 9873-9218', '(71) 98530-0528', '2020-05-28 18:23:59', '2020-06-10 12:33:31', NULL),
	(5, 1, 2, 3, 'Pizzaria Segue o Baile', 'pizzariasegueobaile@hotmail.com', '50.902.478/0001-081', NULL, '(71) 98739-2183', '(71)98530-0528', '2020-05-28 21:13:44', '2020-06-10 12:33:27', NULL),
	(7, 1, 2, 2, 'Limpa Cano', 'limpacano@gmail.com', '41.977.238/0001-59', NULL, '(71) 9873-9218', '(71) 45564-6556', '2020-05-31 17:25:50', '2020-06-10 13:31:34', NULL),
	(18, 1, 2, 4, 'Têxtil Sul ', 'textilsul@hotmail.com', '84.039.937/0001-60', '', '(71) 5656-5656', '(71) 54665-6566', '2020-06-10 12:35:59', '2020-06-14 10:22:36', NULL);
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

-- Copiando estrutura para tabela robotece_zig.clientes_enderecos
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
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_clientes_enderecos_empresas` (`id_empresa`),
  KEY `FK_clientes_enderecos_clientes` (`id_cliente`),
  CONSTRAINT `FK_clientes_enderecos_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  CONSTRAINT `FK_clientes_enderecos_empresas` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.clientes_enderecos: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes_enderecos` DISABLE KEYS */;
INSERT INTO `clientes_enderecos` (`id`, `id_empresa`, `id_cliente`, `cep`, `endereco`, `bairro`, `cidade`, `estado`, `numero`, `complemento`, `created_at`, `updated_at`) VALUES
	(3, 1, 4, '41927210', '2ª travessa são benedito', 'Chapada do Rio vermelho', 'salvador', 'Bahia', 14, NULL, '2020-05-29 12:30:33', '2020-05-29 22:04:00'),
	(4, 1, 4, '41927210', '2ª travessa são benedito', 'Chapada do Rio vermelho', 'salvador', 'Bahia', 14, ' bg ', '2020-05-29 12:31:48', '2020-05-29 12:31:48'),
	(5, 1, 4, '41927210', '2ª travessa são benedito', 'Chapada do Rio vermelho', 'salvador', 'Bahia', 56, 'Casa', '2020-05-29 12:32:23', '2020-05-29 14:11:53'),
	(18, 1, 4, '41.927-210', '2ª Travessa São Benedito', 'Santa Cruz', 'Salvador', 'BA', 15, '', '2020-06-08 10:11:00', '2020-06-08 10:11:00'),
	(19, 1, 18, '41.927-210', '2ª Travessa São Benedito', 'Santa Cruz', 'Salvador', 'BA', 3, '', '2020-06-22 13:56:12', '2020-06-22 13:56:12');
/*!40000 ALTER TABLE `clientes_enderecos` ENABLE KEYS */;

-- Copiando estrutura para tabela robotece_zig.clientes_segmentos
CREATE TABLE IF NOT EXISTS `clientes_segmentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.clientes_segmentos: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes_segmentos` DISABLE KEYS */;
INSERT INTO `clientes_segmentos` (`id`, `descricao`, `created_at`, `updated_at`) VALUES
	(1, 'Restaurante', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(2, 'Hamburgueria', '2020-05-28 10:28:08', '2020-05-28 10:28:09'),
	(3, 'Pizzaria', '2020-05-28 10:28:52', '2020-05-28 10:28:53'),
	(4, 'Outros...', '2020-06-02 00:00:26', '2020-06-02 00:00:27');
/*!40000 ALTER TABLE `clientes_segmentos` ENABLE KEYS */;

-- Copiando estrutura para tabela robotece_zig.clientes_tipos
CREATE TABLE IF NOT EXISTS `clientes_tipos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.clientes_tipos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes_tipos` DISABLE KEYS */;
INSERT INTO `clientes_tipos` (`id`, `descricao`, `created_at`, `updated_at`) VALUES
	(1, 'Pessoa Fisica', '2020-05-28 10:24:51', '2020-05-28 10:24:52'),
	(2, 'Pessoa Juridica', '2020-05-28 10:25:05', '2020-05-28 10:25:06');
/*!40000 ALTER TABLE `clientes_tipos` ENABLE KEYS */;

-- Copiando estrutura para tabela robotece_zig.config_pdv
CREATE TABLE IF NOT EXISTS `config_pdv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `id_tipo_pdv` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_config_pdv_clientes` (`id_empresa`),
  KEY `FK_config_pdv_tipo_pdv` (`id_tipo_pdv`),
  CONSTRAINT `FK_config_pdv_clientes` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_config_pdv_tipo_pdv` FOREIGN KEY (`id_tipo_pdv`) REFERENCES `tipos_pdv` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.config_pdv: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `config_pdv` DISABLE KEYS */;
INSERT INTO `config_pdv` (`id`, `id_empresa`, `id_tipo_pdv`, `created_at`, `updated_at`) VALUES
	(3, 1, 2, '2020-06-28 10:17:42', '2020-06-28 10:17:42');
/*!40000 ALTER TABLE `config_pdv` ENABLE KEYS */;

-- Copiando estrutura para tabela robotece_zig.empresas
CREATE TABLE IF NOT EXISTS `empresas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `telefone` varchar(50) DEFAULT NULL,
  `celular` varchar(50) DEFAULT NULL,
  `id_segmento` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.empresas: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `empresas` DISABLE KEYS */;
INSERT INTO `empresas` (`id`, `nome`, `email`, `telefone`, `celular`, `id_segmento`, `created_at`, `updated_at`) VALUES
	(1, 'Cliente Teste', '', '', '', 0, '2020-04-23 21:36:33', '2020-04-23 21:36:33');
/*!40000 ALTER TABLE `empresas` ENABLE KEYS */;

-- Copiando estrutura para tabela robotece_zig.log_acessos
CREATE TABLE IF NOT EXISTS `log_acessos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL DEFAULT '0',
  `id_empresa` int(11) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `deleted_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_log_usuarios` (`id_usuario`),
  KEY `FK_log_clientes` (`id_empresa`),
  CONSTRAINT `FK_log_clientes` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_log_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.log_acessos: ~23 rows (aproximadamente)
/*!40000 ALTER TABLE `log_acessos` DISABLE KEYS */;
INSERT INTO `log_acessos` (`id`, `id_usuario`, `id_empresa`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(1, 1, 1, '2020-06-24 12:34:39', '2020-06-24 12:34:39', '0000-00-00 00:00:00'),
	(2, 1, 1, '2020-06-24 20:13:14', '2020-06-24 20:13:14', '0000-00-00 00:00:00'),
	(3, 1, 1, '2020-06-24 21:48:40', '2020-06-24 21:48:40', '0000-00-00 00:00:00'),
	(4, 1, 1, '2020-06-25 06:41:38', '2020-06-25 06:41:38', '0000-00-00 00:00:00'),
	(5, 1, 1, '2020-06-25 08:04:45', '2020-06-25 08:04:45', '0000-00-00 00:00:00'),
	(6, 1, 1, '2020-06-25 12:48:35', '2020-06-25 12:48:35', '0000-00-00 00:00:00'),
	(7, 1, 1, '2020-06-25 12:53:20', '2020-06-25 12:53:20', '0000-00-00 00:00:00'),
	(8, 1, 1, '2020-06-25 12:53:47', '2020-06-25 12:53:47', '0000-00-00 00:00:00'),
	(9, 1, 1, '2020-06-25 16:40:02', '2020-06-25 16:40:02', '0000-00-00 00:00:00'),
	(10, 1, 1, '2020-06-25 16:59:14', '2020-06-25 16:59:14', '0000-00-00 00:00:00'),
	(11, 1, 1, '2020-06-26 13:27:18', '2020-06-26 13:27:18', '0000-00-00 00:00:00'),
	(12, 1, 1, '2020-06-26 22:32:25', '2020-06-26 22:32:25', '0000-00-00 00:00:00'),
	(13, 1, 1, '2020-06-27 07:55:25', '2020-06-27 07:55:25', '0000-00-00 00:00:00'),
	(14, 1, 1, '2020-06-27 15:39:09', '2020-06-27 15:39:09', '0000-00-00 00:00:00'),
	(15, 1, 1, '2020-06-27 22:23:11', '2020-06-27 22:23:11', '0000-00-00 00:00:00'),
	(16, 1, 1, '2020-06-27 23:49:24', '2020-06-27 23:49:24', '0000-00-00 00:00:00'),
	(17, 1, 1, '2020-06-28 08:41:53', '2020-06-28 08:41:53', '0000-00-00 00:00:00'),
	(18, 1, 1, '2020-06-28 08:46:31', '2020-06-28 08:46:31', '0000-00-00 00:00:00'),
	(19, 1, 1, '2020-06-28 10:03:59', '2020-06-28 10:03:59', '0000-00-00 00:00:00'),
	(20, 1, 1, '2020-06-28 18:38:00', '2020-06-28 18:38:00', '0000-00-00 00:00:00'),
	(21, 1, 1, '2020-06-28 18:38:40', '2020-06-28 18:38:40', '0000-00-00 00:00:00'),
	(22, 1, 1, '2020-06-28 18:38:56', '2020-06-28 18:38:56', '0000-00-00 00:00:00'),
	(23, 38, 1, '2020-06-28 18:39:42', '2020-06-28 18:39:42', '0000-00-00 00:00:00'),
	(24, 38, 1, '2020-06-28 18:40:14', '2020-06-28 18:40:14', '0000-00-00 00:00:00'),
	(25, 1, 1, '2020-06-29 13:02:52', '2020-06-29 13:02:52', '0000-00-00 00:00:00'),
	(26, 1, 1, '2020-06-29 13:37:25', '2020-06-29 13:37:25', '0000-00-00 00:00:00'),
	(27, 1, 1, '2020-06-29 14:21:32', '2020-06-29 14:21:32', '0000-00-00 00:00:00'),
	(28, 1, 1, '2020-06-30 11:12:43', '2020-06-30 11:12:43', '0000-00-00 00:00:00'),
	(29, 1, 1, '2020-07-01 21:40:40', '2020-07-01 21:40:40', '0000-00-00 00:00:00'),
	(30, 1, 1, '2020-07-02 08:26:09', '2020-07-02 08:26:09', '0000-00-00 00:00:00'),
	(31, 1, 1, '2020-07-03 08:13:12', '2020-07-03 08:13:12', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `log_acessos` ENABLE KEYS */;

-- Copiando estrutura para tabela robotece_zig.meios_pagamentos
CREATE TABLE IF NOT EXISTS `meios_pagamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `legenda` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.meios_pagamentos: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `meios_pagamentos` DISABLE KEYS */;
INSERT INTO `meios_pagamentos` (`id`, `legenda`, `created_at`, `updated_at`) VALUES
	(1, 'Dinheiro', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(2, 'Crédito', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(3, 'Débito', '0000-00-00 00:00:00', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `meios_pagamentos` ENABLE KEYS */;

-- Copiando estrutura para tabela robotece_zig.modulos
CREATE TABLE IF NOT EXISTS `modulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.modulos: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `modulos` DISABLE KEYS */;
INSERT INTO `modulos` (`id`, `descricao`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(2, 'Inicio', '2020-06-24 06:55:45', '2020-06-24 06:55:46', NULL),
	(3, 'Empresas', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(4, 'Usuarios', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(5, 'PDV padrão', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(6, 'PDV diferencial', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(7, 'Clientes', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(8, 'Produtos', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(9, 'Pedidos', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(10, 'Relatorios', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(11, 'Configurações', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL);
/*!40000 ALTER TABLE `modulos` ENABLE KEYS */;

-- Copiando estrutura para tabela robotece_zig.perfis
CREATE TABLE IF NOT EXISTS `perfis` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.perfis: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `perfis` DISABLE KEYS */;
INSERT INTO `perfis` (`id`, `descricao`, `created_at`, `updated_at`) VALUES
	(1, 'Super Admin', '2020-06-21 13:00:15', '0000-00-00 00:00:00'),
	(2, 'Admin', '2020-04-25 00:53:27', '0000-00-00 00:00:00'),
	(4, 'Vendedor', '2020-04-25 00:53:32', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `perfis` ENABLE KEYS */;

-- Copiando estrutura para tabela robotece_zig.produtos
CREATE TABLE IF NOT EXISTS `produtos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_empresa` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `preco` double NOT NULL DEFAULT '0',
  `descricao` text,
  `imagem` text,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_produtos_clientes` (`id_empresa`),
  CONSTRAINT `FK_produtos_clientes` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.produtos: ~10 rows (aproximadamente)
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
	(9, 1, 'Notebook Samsung ', 2580, 'Notebook Samsung Intel Core i3 4GB 1TB Tela 15,6" Windows 10 Home ', 'public/imagem/produtos/1593041033.png', '2020-06-24 20:23:53', '2020-06-24 20:23:53'),
	(10, 1, 'HAMBÚRGUER ARTESANAL', 26, '', 'public/imagem/produtos/1592946951.png', '2020-06-23 18:15:51', '2020-06-23 18:15:51');
/*!40000 ALTER TABLE `produtos` ENABLE KEYS */;

-- Copiando estrutura para tabela robotece_zig.sexos
CREATE TABLE IF NOT EXISTS `sexos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.sexos: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `sexos` DISABLE KEYS */;
INSERT INTO `sexos` (`id`, `descricao`, `created_at`, `updated_at`) VALUES
	(1, 'Masculino', '2020-02-21 14:08:58', '0000-00-00 00:00:00'),
	(2, 'Feminino', '2020-02-21 14:09:09', '0000-00-00 00:00:00');
/*!40000 ALTER TABLE `sexos` ENABLE KEYS */;

-- Copiando estrutura para tabela robotece_zig.tipos_pdv
CREATE TABLE IF NOT EXISTS `tipos_pdv` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `descricao` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.tipos_pdv: ~2 rows (aproximadamente)
/*!40000 ALTER TABLE `tipos_pdv` DISABLE KEYS */;
INSERT INTO `tipos_pdv` (`id`, `descricao`, `created_at`, `updated_at`) VALUES
	(1, 'Padrão', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
	(2, 'Diferencial', '2020-05-23 17:02:09', '2020-05-23 17:02:09');
/*!40000 ALTER TABLE `tipos_pdv` ENABLE KEYS */;

-- Copiando estrutura para tabela robotece_zig.usuarios
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
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.usuarios: ~10 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`, `id_empresa`, `nome`, `email`, `password`, `id_sexo`, `id_perfil`, `imagem`, `created_at`, `updated_at`) VALUES
	(1, 1, 'França', 'admin@admin.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 2, 'public/imagem/perfil_usuarios/1585493352.jpg', '2020-05-27 18:29:11', '2020-05-27 15:29:09'),
	(2, 1, 'Renata de Jesus Lima', 'renata@hotmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 2, 4, 'public/imagem/perfil_usuarios/1585493808.png', '2020-05-24 17:21:48', '2020-05-24 14:21:45'),
	(35, 1, 'João de Jesus', 'joao@gmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 4, 'public/imagem/perfil_usuarios/1585493875.png', '2020-05-24 17:22:05', '2020-05-24 14:22:01'),
	(36, 1, 'Mariana Pinheiro', 'mariana@gmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 2, 4, 'public/imagem/perfil_usuarios/1585494012.png', '2020-04-25 00:54:55', '2020-03-29 15:00:12'),
	(38, 1, 'Margarida Dantas', 'margarida@hotmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 2, 4, 'public/imagem/perfil_usuarios/1585493941.png', '2020-04-25 22:03:29', '2020-03-29 14:59:01'),
	(42, 1, 'Leonardo Dodge', 'leonardo@gmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 4, 'public/imagem/perfil_usuarios/1585494107.png', '2020-04-25 00:54:48', '2020-03-29 15:01:47'),
	(43, 1, 'Testador', 'testador@gmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 1, 'public/imagem/perfil_usuarios/1587774607.jpg', '2020-04-25 00:55:18', '2020-04-25 00:30:07'),
	(46, 1, 'Lucas Amorin', 'lucas@hotmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 4, 'public/imagem/perfil_usuarios/1591812394.jpeg', '2020-06-10 18:07:50', '2020-06-10 15:07:50'),
	(47, 1, 'Leonardo Souza', 'leonardo@hotmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 4, 'public/imagem/perfil_usuarios/1591813053.jpg', '2020-06-10 18:17:33', '2020-06-10 15:17:33'),
	(49, 1, 'Anderson Oliveira', 'andersonoliver480@gmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 2, 'public/imagem/perfil_usuarios/1592172985.png', '2020-06-14 22:16:25', '2020-06-14 19:16:25');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

-- Copiando estrutura para tabela robotece_zig.usuarios_modulos
CREATE TABLE IF NOT EXISTS `usuarios_modulos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `consultar` int(11) NOT NULL DEFAULT '1',
  `criar` int(11) NOT NULL DEFAULT '1',
  `editar` int(11) NOT NULL DEFAULT '1',
  `excluir` int(11) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_usuarios_modulos_usuarios` (`id_usuario`),
  KEY `FK_usuarios_modulos_empresas` (`id_empresa`),
  KEY `FK_usuarios_modulos_modulos_permissoes` (`id_modulo`),
  CONSTRAINT `FK_usuarios_modulos_empresas` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_usuarios_modulos_modulos_permissoes` FOREIGN KEY (`id_modulo`) REFERENCES `modulos` (`id`),
  CONSTRAINT `FK_usuarios_modulos_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.usuarios_modulos: ~20 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios_modulos` DISABLE KEYS */;
INSERT INTO `usuarios_modulos` (`id`, `id_usuario`, `id_empresa`, `id_modulo`, `consultar`, `criar`, `editar`, `excluir`, `created_at`, `updated_at`, `deleted_at`) VALUES
	(4, 1, 1, 7, 1, 1, 1, 1, '2020-06-27 22:23:38', '2020-06-27 22:23:38', NULL),
	(5, 1, 1, 11, 1, 1, 1, 1, '2020-06-24 08:05:06', '2020-06-24 08:05:07', NULL),
	(6, 1, 1, 3, 1, 1, 1, 1, '2020-06-27 22:24:29', '2020-06-27 22:24:29', NULL),
	(7, 1, 1, 2, 1, 1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(8, 1, 1, 6, 1, 1, 1, 1, '2020-06-24 08:07:02', '2020-06-24 08:07:02', NULL),
	(9, 1, 1, 5, 1, 1, 1, 1, '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL),
	(10, 1, 1, 9, 1, 1, 1, 1, '2020-06-24 08:08:22', '2020-06-24 08:08:23', NULL),
	(11, 1, 1, 8, 1, 1, 1, 1, '2020-06-28 18:38:50', '2020-06-28 18:38:50', NULL),
	(12, 1, 1, 10, 1, 1, 1, 1, '2019-06-24 08:08:52', '2020-06-24 08:08:53', NULL),
	(13, 1, 1, 4, 1, 1, 1, 1, '2020-06-27 22:23:37', '2020-06-27 22:23:37', NULL),
	(14, 38, 1, 2, 1, 1, 1, 1, '2020-06-28 18:39:42', '2020-06-28 18:39:42', NULL),
	(15, 38, 1, 3, 0, 0, 0, 0, '2020-06-28 18:42:25', '2020-06-28 18:42:25', NULL),
	(16, 38, 1, 4, 1, 1, 1, 1, '2020-06-28 18:39:42', '2020-06-28 18:39:42', NULL),
	(17, 38, 1, 5, 0, 1, 1, 1, '2020-06-28 18:42:29', '2020-06-28 18:42:29', NULL),
	(18, 38, 1, 6, 1, 1, 1, 1, '2020-06-28 18:39:42', '2020-06-28 18:39:42', NULL),
	(19, 38, 1, 7, 1, 1, 1, 1, '2020-06-28 18:39:42', '2020-06-28 18:39:42', NULL),
	(20, 38, 1, 8, 1, 1, 1, 1, '2020-06-28 18:39:42', '2020-06-28 18:39:42', NULL),
	(21, 38, 1, 9, 1, 1, 1, 1, '2020-06-28 18:39:42', '2020-06-28 18:39:42', NULL),
	(22, 38, 1, 10, 1, 1, 1, 1, '2020-06-28 18:39:42', '2020-06-28 18:39:42', NULL),
	(23, 38, 1, 11, 1, 1, 1, 1, '2020-06-28 18:39:42', '2020-06-28 18:39:42', NULL);
/*!40000 ALTER TABLE `usuarios_modulos` ENABLE KEYS */;

-- Copiando estrutura para tabela robotece_zig.vendas
CREATE TABLE IF NOT EXISTS `vendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_meio_pagamento` int(11) NOT NULL,
  `id_empresa` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `preco` double DEFAULT '0',
  `quantidade` int(11) DEFAULT NULL,
  `valor` double NOT NULL DEFAULT '0',
  `data_compensacao` DATE NULL DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  PRIMARY KEY (`id`),
  KEY `FK_vendas_meios_de_pagamento` (`id_meio_pagamento`),
  KEY `FK_vendas_usuarios` (`id_usuario`),
  KEY `FK_vendas_clientes` (`id_empresa`),
  CONSTRAINT `FK_vendas_clientes` FOREIGN KEY (`id_empresa`) REFERENCES `empresas` (`id`),
  CONSTRAINT `FK_vendas_meios_de_pagamento` FOREIGN KEY (`id_meio_pagamento`) REFERENCES `meios_pagamentos` (`id`),
  CONSTRAINT `FK_vendas_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=241 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela robotece_zig.vendas: ~130 rows (aproximadamente)
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
	(163, 1, 2, 1, 8, 1500, 1, 1500, '2020-06-08 21:43:42', '2020-06-08 21:43:42'),
	(164, 1, 1, 1, 2, 13, 1, 13, '2020-06-10 14:23:51', '2020-06-10 14:23:51'),
	(165, 47, 2, 1, 9, 2580, 1, 2580, '2020-06-10 15:18:17', '2020-06-10 15:18:17'),
	(166, 1, 3, 1, 7, 25, 1, 25, '2020-06-10 19:42:33', '2020-06-10 19:42:33'),
	(167, 1, 3, 1, 5, 3.99, 1, 3.99, '2020-06-10 19:42:33', '2020-06-10 19:42:33'),
	(168, 1, 1, 1, 2, 13, 1, 13, '2020-06-11 20:29:11', '2020-06-11 20:29:11'),
	(169, 1, 1, 1, 6, 30, 1, 30, '2020-06-12 11:53:21', '2020-06-12 11:53:21'),
	(170, 1, 1, 1, 5, 3.99, 2, 7.98, '2020-06-12 11:53:21', '2020-06-12 11:53:21'),
	(171, 1, 1, 1, 5, 3.99, 1, 3.99, '2020-06-13 20:21:33', '2020-06-13 20:21:33'),
	(172, 49, 1, 1, 4, 3.49, 1, 3.49, '2020-06-14 20:32:40', '2020-06-14 20:32:40'),
	(173, 49, 2, 1, 6, 30, 2, 60, '2020-06-14 20:36:48', '2020-06-14 20:36:48'),
	(174, 49, 2, 1, 4, 3.49, 2, 6.98, '2020-06-14 20:36:49', '2020-06-14 20:36:49'),
	(175, 49, 1, 1, 3, 18, 1, 18, '2020-06-14 20:51:45', '2020-06-14 20:51:45'),
	(176, 1, 3, 1, 1, 10.5, 2, 21, '2020-06-14 20:52:21', '2020-06-14 20:52:21'),
	(177, 36, 2, 1, NULL, 0, NULL, 85, '2020-06-15 13:23:35', '2020-06-15 13:23:35'),
	(178, 1, 1, 1, NULL, 0, NULL, 50, '2020-06-15 18:10:38', '2020-06-15 18:10:38'),
	(179, 1, 1, 1, 3, 18, 1, 18, '2020-06-15 18:12:39', '2020-06-15 18:12:39'),
	(180, 1, 1, 1, 1, 10.5, 1, 10.5, '2020-06-15 18:12:40', '2020-06-15 18:12:40'),
	(181, 1, 2, 1, NULL, 0, NULL, 75, '2020-06-15 18:15:56', '2020-06-15 18:15:56'),
	(182, 1, 3, 1, NULL, 0, NULL, 25.5, '2020-06-15 18:49:01', '2020-06-15 18:49:01'),
	(183, 35, 2, 1, NULL, 0, NULL, 47, '2020-06-15 20:48:36', '2020-06-15 20:48:36'),
	(184, 46, 2, 1, NULL, 0, NULL, 150, '2020-06-15 21:07:21', '2020-06-15 21:07:21'),
	(185, 2, 1, 1, NULL, 0, NULL, 15, '2020-06-15 21:10:44', '2020-06-15 21:10:44'),
	(186, 1, 1, 1, NULL, 0, NULL, 0, '2020-06-16 08:41:52', '2020-06-16 08:41:52'),
	(187, 1, 1, 1, NULL, 0, NULL, 0, '2020-06-16 08:42:39', '2020-06-16 08:42:39'),
	(188, 1, 1, 1, NULL, 0, NULL, 17.5, '2020-06-16 08:42:47', '2020-06-16 08:42:47'),
	(189, 46, 1, 1, NULL, 0, NULL, 25, '2020-06-17 07:31:22', '2020-06-17 07:31:22'),
	(190, 38, 3, 1, NULL, 0, NULL, 115, '2020-06-17 18:22:28', '2020-06-17 18:22:28'),
	(191, 1, 1, 1, NULL, 0, NULL, 4, '2020-06-19 06:32:51', '2020-06-19 06:32:51'),
	(192, 1, 1, 1, NULL, 0, NULL, 42, '2020-06-19 06:33:06', '2020-06-19 06:33:06'),
	(193, 46, 2, 1, NULL, 0, NULL, 15, '2020-06-19 07:38:52', '2020-06-19 07:38:52'),
	(194, 38, 2, 1, NULL, 0, NULL, 175, '2020-06-19 07:39:20', '2020-06-19 07:39:20'),
	(195, 1, 1, 1, NULL, 0, NULL, 15, '2020-06-19 08:20:21', '2020-06-19 08:20:21'),
	(196, 1, 3, 1, NULL, 0, NULL, 7, '2020-06-19 08:32:59', '2020-06-19 08:32:59'),
	(197, 36, 3, 1, NULL, 0, NULL, 70, '2020-06-19 10:20:31', '2020-06-19 10:20:31'),
	(198, 1, 2, 1, NULL, 0, NULL, 1000, '2020-06-19 21:00:20', '2020-06-19 21:00:20'),
	(199, 35, 2, 1, NULL, 0, NULL, 150, '2020-06-20 09:23:51', '2020-06-20 09:23:51'),
	(200, 1, 1, 1, NULL, 0, NULL, 16, '2020-06-20 15:33:34', '2020-06-20 15:33:34'),
	(201, 1, 1, 1, NULL, 0, NULL, 16.5, '2020-06-21 05:53:36', '2020-06-21 05:53:36'),
	(202, 1, 2, 1, NULL, 0, NULL, 17, '2020-06-22 13:29:36', '2020-06-22 13:29:36'),
	(203, 1, 1, 1, 2, 13, 2, 26, '2020-06-22 13:30:25', '2020-06-22 13:30:25'),
	(204, 1, 1, 1, 1, 10.5, 1, 10.5, '2020-06-22 13:30:25', '2020-06-22 13:30:25'),
	(205, 1, 2, 1, 3, 18, 1, 18, '2020-06-22 20:57:46', '2020-06-22 20:57:46'),
	(206, 1, 2, 1, 6, 30, 1, 30, '2020-06-22 20:57:47', '2020-06-22 20:57:47'),
	(207, 1, 2, 1, 10, 26, 1, 26, '2020-06-23 18:16:39', '2020-06-23 18:16:39'),
	(208, 1, 2, 1, 4, 3.49, 1, 3.49, '2020-06-23 18:16:39', '2020-06-23 18:16:39'),
	(209, 1, 1, 1, 3, 18, 1, 18, '2020-06-24 11:50:24', '2020-06-24 11:50:24'),
	(210, 36, 3, 1, NULL, 0, NULL, 17, '2020-06-24 12:01:47', '2020-06-24 12:01:47'),
	(211, 1, 1, 1, 3, 18, 1, 18, '2020-06-24 20:15:14', '2020-06-24 20:15:14'),
	(212, 1, 2, 1, 2, 13, 1, 13, '2020-06-24 20:20:25', '2020-06-24 20:20:25'),
	(213, 1, 2, 1, 6, 30, 1, 30, '2020-06-24 20:20:25', '2020-06-24 20:20:25'),
	(214, 1, 2, 1, 9, 2580, 1, 2580, '2020-06-24 20:24:14', '2020-06-24 20:24:14'),
	(215, 1, 2, 1, 9, 2580, 1, 2580, '2020-06-25 06:42:43', '2020-06-25 06:42:43'),
	(216, 1, 2, 1, 9, 2580, 1, 2580, '2020-06-26 13:31:40', '2020-06-26 13:31:40'),
	(217, 1, 3, 1, 2, 13, 1, 13, '2020-06-26 13:31:59', '2020-06-26 13:31:59'),
	(218, 1, 1, 1, 6, 30, 1, 30, '2020-06-26 13:32:22', '2020-06-26 13:32:22'),
	(219, 1, 1, 1, 5, 3.99, 1, 3.99, '2020-06-26 13:32:23', '2020-06-26 13:32:23'),
	(220, 1, 1, 1, 1, 10.5, 3, 31.5, '2020-06-26 13:34:18', '2020-06-26 13:34:18'),
	(221, 1, 3, 1, 6, 30, 1, 30, '2020-06-26 22:32:52', '2020-06-26 22:32:52'),
	(222, 1, 3, 1, 5, 3.99, 2, 7.98, '2020-06-26 22:32:52', '2020-06-26 22:32:52'),
	(223, 1, 1, 1, NULL, 0, NULL, 45, '2020-06-26 22:33:25', '2020-06-26 22:33:25'),
	(224, 46, 1, 1, NULL, 0, NULL, 15.5, '2020-06-27 07:56:43', '2020-06-27 07:56:43'),
	(225, 38, 1, 1, NULL, 0, NULL, 28.1, '2020-06-27 07:57:55', '2020-06-27 07:57:55'),
	(226, 1, 2, 1, 6, 30, 1, 30, '2020-06-27 15:40:20', '2020-06-27 15:40:20'),
	(227, 1, 2, 1, 4, 3.49, 2, 6.98, '2020-06-27 15:40:20', '2020-06-27 15:40:20'),
	(228, 1, 1, 1, NULL, 0, NULL, 52, '2020-06-27 15:41:13', '2020-06-27 15:41:13'),
	(229, 38, 2, 1, NULL, 0, NULL, 7.84, '2020-06-28 08:46:58', '2020-06-28 08:46:58'),
	(230, 1, 1, 1, NULL, 0, NULL, 10, '2020-06-28 10:17:29', '2020-06-28 10:17:29'),
	(231, 1, 1, 1, 6, 30, 2, 60, '2020-06-28 10:19:07', '2020-06-28 10:19:07'),
	(232, 1, 1, 1, 5, 3.99, 2, 7.98, '2020-06-28 10:19:07', '2020-06-28 10:19:07'),
	(233, 1, 2, 1, 7, 25, 2, 50, '2020-06-29 13:03:22', '2020-06-29 13:03:22'),
	(234, 1, 2, 1, 4, 3.49, 2, 6.98, '2020-06-29 13:03:22', '2020-06-29 13:03:22'),
	(235, 1, 1, 1, 10, 26, 1, 26, '2020-06-29 13:39:17', '2020-06-29 13:39:17'),
	(236, 1, 2, 1, 8, 1500, 1, 1500, '2020-06-30 11:14:08', '2020-06-30 11:14:08'),
	(237, 1, 1, 1, 3, 18, 1, 18, '2020-07-01 21:41:09', '2020-07-01 21:41:09'),
	(238, 1, 2, 1, 10, 26, 2, 52, '2020-07-01 22:08:45', '2020-07-01 22:08:45'),
	(239, 1, 2, 1, 4, 3.49, 2, 6.98, '2020-07-01 22:08:45', '2020-07-01 22:08:45'),
	(240, 1, 1, 1, 2, 13, 1, 13, '2020-07-02 08:26:18', '2020-07-02 08:26:18');
/*!40000 ALTER TABLE `vendas` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
