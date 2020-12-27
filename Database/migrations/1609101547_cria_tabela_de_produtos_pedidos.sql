CREATE TABLE IF NOT EXISTS `produtos_pedidos` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `id_pedido` int(11) NOT NULL,
    `id_produto` int(11) NOT NULL,
    `preco` double NOT NULL DEFAULT '0',
    `quantidade` int(11) NOT NULL,
    `subtotal` double NOT NULL DEFAULT '0',
    `created_at` timestamp NULL DEFAULT NULL,
    `updated_at` timestamp NULL DEFAULT NULL,
    PRIMARY KEY (`id`),
    KEY `id_pedido` (`id_pedido`),
    KEY `id_produto` (`id_produto`)
) ENGINE=MyISAM AUTO_INCREMENT=326 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
