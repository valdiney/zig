CREATE TABLE IF NOT EXISTS `situacoes_pedidos` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `legenda` varchar(50) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
    `created_at` timestamp NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
    `updated_at` timestamp NULL DEFAULT '0000-00-00 00:00:00',
    PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
