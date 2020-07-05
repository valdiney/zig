-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: mysql
-- Generation Time: Jul 01, 2020 at 12:35 PM
-- Server version: 8.0.20
-- PHP Version: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `zig`
--

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int NOT NULL,
  `code` varchar(10) NOT NULL,
  `description` varchar(150) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `code`, `description`, `created_at`, `updated_at`) VALUES
(1, '1593604775', 'cria tabela migrations', '2020-07-01 12:33:40', NULL),
(2, '1593605007', 'cria tabela de clientes segmentos', '2020-07-01 12:33:40', NULL),
(3, '1593605094', 'cria tabela de clientes tipos', '2020-07-01 12:33:40', NULL),
(4, '1593605143', 'cria tabela de empresas', '2020-07-01 12:33:40', NULL),
(5, '1593605239', 'cria tabela de clientes', '2020-07-01 12:33:40', NULL),
(6, '1593605328', 'cria tabela de meios de pagamento', '2020-07-01 12:33:40', NULL),
(7, '1593605367', 'cria tabela de tipos pdv', '2020-07-01 12:33:40', NULL),
(8, '1593605428', 'cria tabela de clientes enderecos', '2020-07-01 12:33:40', NULL),
(9, '1593605466', 'cria tabela de config pdv', '2020-07-01 12:33:40', NULL),
(10, '1593605510', 'cria tabela de modulos', '2020-07-01 12:33:40', NULL),
(11, '1593605548', 'cria tabela de perfis', '2020-07-01 12:33:40', NULL),
(12, '1593605570', 'cria tabela de produtos', '2020-07-01 12:33:40', NULL),
(13, '1593605592', 'cria tabela de sexos', '2020-07-01 12:33:40', NULL),
(14, '1593605596', 'cria tabela de usuarios', '2020-07-01 12:33:40', NULL),
(15, '1593605654', 'cria tabela de modulos de usuarios', '2020-07-01 12:33:40', NULL),
(16, '1593605683', 'cria tabela de vendas', '2020-07-01 12:33:40', NULL),
(17, '1593608384', 'cria tabela de logs', '2020-07-01 12:33:40', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
