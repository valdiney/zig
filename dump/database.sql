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
  `nome` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.clientes: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `clientes` DISABLE KEYS */;
INSERT INTO `clientes` (`id`, `nome`, `created_at`, `updated_at`) VALUES
	(1, 'Cliente Teste', '2020-04-23 21:36:33', '2020-04-23 21:36:33');
/*!40000 ALTER TABLE `clientes` ENABLE KEYS */;

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
  `id_cliente` int(11) NOT NULL,
  `nome` varchar(50) NOT NULL,
  `preco` double NOT NULL DEFAULT '0',
  `descricao` text,
  `imagem` text,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_produtos_clientes` (`id_cliente`),
  CONSTRAINT `FK_produtos_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.produtos: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `produtos` DISABLE KEYS */;
INSERT INTO `produtos` (`id`, `id_cliente`, `nome`, `preco`, `descricao`, `imagem`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Açái Tradicional', 10.5, 'Tigela de Açaí tradicional!', 'public/imagem/produtos/1589923097.jpg', '2020-05-19 17:13:05', '2020-05-21 22:40:09'),
	(2, 1, 'Açaí de Banana', 13, 'bghghg', 'public/imagem/produtos/1589919313.jpg', '2020-05-19 17:15:13', '2020-05-19 17:15:13'),
	(3, 1, 'Dell Vale de Uva', 18, 'Néctar de Uva Del Valle 1 Litro', 'public/imagem/produtos/1589923950.jpg', '2020-05-19 18:32:30', '2020-05-19 18:32:30');
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

-- Copiando estrutura para tabela syst.usuarios
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cliente` int(11) NOT NULL DEFAULT '0',
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
  KEY `FK_usuarios_clientes` (`id_cliente`),
  CONSTRAINT `FK_usuarios_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  CONSTRAINT `FK_usuarios_perfis` FOREIGN KEY (`id_perfil`) REFERENCES `perfis` (`id`),
  CONSTRAINT `FK_usuarios_sexo` FOREIGN KEY (`id_sexo`) REFERENCES `sexos` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.usuarios: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`, `id_cliente`, `nome`, `email`, `password`, `id_sexo`, `id_perfil`, `imagem`, `created_at`, `updated_at`) VALUES
	(1, 1, 'França', 'admin@admin.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 2, 'public/imagem/perfil_usuarios/1585493352.jpg', '2020-05-16 06:06:45', '2020-05-16 03:06:43'),
	(2, 1, 'Renata de Jesus Lima', 'renata@hotmail.com', '3c023c12a311f1ffcb96ccfdbf324cbb6a842163', 2, 4, 'public/imagem/perfil_usuarios/1585493808.png', '2020-04-25 00:55:03', '2020-03-29 14:56:48'),
	(35, 1, 'João de Jesus', 'joao@gmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 4, 'public/imagem/perfil_usuarios/1585493875.png', '2020-04-25 00:54:58', '2020-03-29 14:57:55'),
	(36, 1, 'Mariana Pinheiro', 'mariana@gmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 2, 4, 'public/imagem/perfil_usuarios/1585494012.png', '2020-04-25 00:54:55', '2020-03-29 15:00:12'),
	(38, 1, 'Margarida Dantas', 'margarida@hotmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 2, 4, 'public/imagem/perfil_usuarios/1585493941.png', '2020-04-25 22:03:29', '2020-03-29 14:59:01'),
	(42, 1, 'Leonardo Dodge', 'leonardo@gmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 4, 'public/imagem/perfil_usuarios/1585494107.png', '2020-04-25 00:54:48', '2020-03-29 15:01:47'),
	(43, 1, 'Testador', 'testador@gmail.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 1, 'public/imagem/perfil_usuarios/1587774607.jpg', '2020-04-25 00:55:18', '2020-04-25 00:30:07');
/*!40000 ALTER TABLE `usuarios` ENABLE KEYS */;

-- Copiando estrutura para tabela syst.vendas
CREATE TABLE IF NOT EXISTS `vendas` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_meio_pagamento` int(11) NOT NULL,
  `id_cliente` int(11) NOT NULL,
  `id_produto` int(11) DEFAULT NULL,
  `preco` double DEFAULT '0',
  `quantidade` int(11) DEFAULT NULL,
  `valor` double NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vendas_meios_de_pagamento` (`id_meio_pagamento`),
  KEY `FK_vendas_usuarios` (`id_usuario`),
  KEY `FK_vendas_clientes` (`id_cliente`),
  CONSTRAINT `FK_vendas_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  CONSTRAINT `FK_vendas_meios_de_pagamento` FOREIGN KEY (`id_meio_pagamento`) REFERENCES `meios_pagamentos` (`id`),
  CONSTRAINT `FK_vendas_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=84 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.vendas: ~44 rows (aproximadamente)
/*!40000 ALTER TABLE `vendas` DISABLE KEYS */;
INSERT INTO `vendas` (`id`, `id_usuario`, `id_meio_pagamento`, `id_cliente`, `id_produto`, `preco`, `quantidade`, `valor`, `created_at`, `updated_at`) VALUES
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
	(61, 36, 3, 1, 0, 0, 0, 1250, '2020-05-18 22:28:53', '2020-05-18 22:28:53');
/*!40000 ALTER TABLE `vendas` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
