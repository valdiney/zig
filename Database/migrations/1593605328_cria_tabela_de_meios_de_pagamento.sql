
-- Copiando estrutura para tabela syst.meios_pagamentos
CREATE TABLE IF NOT EXISTS `meios_pagamentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `legenda` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL,
  `updated_at` timestamp NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
