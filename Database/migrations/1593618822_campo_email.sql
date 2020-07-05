ALTER TABLE `empresas`
	ADD COLUMN `email` VARCHAR(50) NOT NULL AFTER `nome`;

ALTER TABLE `empresas`
	ADD COLUMN `telefone` VARCHAR(50) NULL AFTER `email`;

ALTER TABLE `empresas`
	ADD COLUMN `celular` VARCHAR(50) NULL AFTER `telefone`;