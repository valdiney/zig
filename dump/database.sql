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

-- Copiando dados para a tabela syst.meios_pagamentos: ~3 rows (aproximadamente)
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
) ENGINE=InnoDB AUTO_INCREMENT=45 DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.usuarios: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `usuarios` DISABLE KEYS */;
INSERT INTO `usuarios` (`id`, `id_cliente`, `nome`, `email`, `password`, `id_sexo`, `id_perfil`, `imagem`, `created_at`, `updated_at`) VALUES
	(1, 1, 'Bastian Dantas', 'admin@admin.com', '3b5df72898847f008454f4ed60280d6bdffc890d', 1, 2, 'public/imagem/perfil_usuarios/1585493352.jpg', '2020-04-25 21:21:52', '2020-04-19 03:13:39'),
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
  `valor` float NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_vendas_meios_de_pagamento` (`id_meio_pagamento`),
  KEY `FK_vendas_usuarios` (`id_usuario`),
  KEY `FK_vendas_clientes` (`id_cliente`),
  CONSTRAINT `FK_vendas_clientes` FOREIGN KEY (`id_cliente`) REFERENCES `clientes` (`id`),
  CONSTRAINT `FK_vendas_meios_de_pagamento` FOREIGN KEY (`id_meio_pagamento`) REFERENCES `meios_pagamentos` (`id`),
  CONSTRAINT `FK_vendas_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Copiando dados para a tabela syst.vendas: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `vendas` DISABLE KEYS */;
INSERT INTO `vendas` (`id`, `id_usuario`, `id_meio_pagamento`, `id_cliente`, `valor`, `created_at`, `updated_at`) VALUES
	(1, 1, 1, 1, 10.5, '2020-04-25 01:58:13', '2020-04-25 01:58:13'),
	(2, 1, 3, 1, 12, '2020-04-25 01:58:43', '2020-04-25 01:58:43'),
	(3, 1, 2, 1, 50, '2020-04-25 01:59:08', '2020-04-25 01:59:08'),
	(4, 1, 1, 1, 20, '2020-04-25 21:29:26', '2020-04-25 21:29:26'),
	(6, 38, 2, 1, 40, '2020-04-25 19:22:24', '2020-04-25 19:22:24');
/*!40000 ALTER TABLE `vendas` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
