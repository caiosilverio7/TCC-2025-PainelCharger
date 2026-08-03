-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/11/2025 às 14:00
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `3binfo`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `categorias`
--

CREATE TABLE `categorias` (
  `id_categoria` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `situacao` enum('Ativo','Bloqueado') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `categorias`
--

INSERT INTO `categorias` (`id_categoria`, `nome`, `situacao`) VALUES
(11, 'Pontos de carregamento', 'Ativo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `estabelecimentos`
--

CREATE TABLE `estabelecimentos` (
  `id_estabelecimento` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `logo` varchar(100) DEFAULT NULL,
  `endereco` varchar(255) NOT NULL,
  `detalhes` text DEFAULT NULL,
  `latitude` varchar(50) DEFAULT NULL,
  `longitude` varchar(50) DEFAULT NULL,
  `id_categoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Despejando dados para a tabela `estabelecimentos`
--

INSERT INTO `estabelecimentos` (`id_estabelecimento`, `nome`, `logo`, `endereco`, `detalhes`, `latitude`, `longitude`, `id_categoria`) VALUES
(12, 'Vicentinaranha', NULL, 'Av. São João, 440 - Jardim Esplanada, São José dos Campos - SP, 12242-000, Brasil', 'Parque', '-23.1957766', '-45.89730300000001', 11);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamentos`
--

CREATE TABLE `pagamentos` (
  `id_pagamento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `tempo` int(11) NOT NULL,
  `valor` decimal(10,2) NOT NULL,
  `status` enum('pendente','ativo','finalizado','expirado') DEFAULT 'pendente',
  `inicio` datetime DEFAULT NULL,
  `fim` datetime DEFAULT NULL,
  `criado_em` timestamp NOT NULL DEFAULT current_timestamp(),
  `atualizado_em` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pagamentos`
--

INSERT INTO `pagamentos` (`id_pagamento`, `id_usuario`, `tempo`, `valor`, `status`, `inicio`, `fim`, `criado_em`, `atualizado_em`) VALUES
(45, 3, 30, 15.00, 'pendente', NULL, NULL, '2025-11-18 14:35:18', '2025-11-18 14:35:18'),
(46, 3, 10, 5.00, 'pendente', NULL, NULL, '2025-11-18 14:38:09', '2025-11-18 14:38:09'),
(47, 3, 10, 5.00, 'pendente', NULL, NULL, '2025-11-18 14:44:27', '2025-11-18 14:44:27'),
(48, 3, 10, 5.00, 'pendente', NULL, NULL, '2025-11-18 14:44:28', '2025-11-18 14:44:28'),
(49, 3, 10, 5.00, 'pendente', NULL, NULL, '2025-11-18 14:45:26', '2025-11-18 14:45:26'),
(50, 3, 60, 30.00, 'pendente', NULL, NULL, '2025-11-18 14:46:08', '2025-11-18 14:46:08'),
(51, 3, 10, 5.00, 'pendente', NULL, NULL, '2025-11-18 14:46:11', '2025-11-18 14:46:11'),
(52, 3, 10, 5.00, 'pendente', NULL, NULL, '2025-11-18 14:53:41', '2025-11-18 14:53:41'),
(53, 3, 10, 5.00, 'pendente', NULL, NULL, '2025-11-18 14:53:42', '2025-11-18 14:53:42'),
(54, 3, 60, 30.00, 'pendente', NULL, NULL, '2025-11-18 14:54:08', '2025-11-18 14:54:08'),
(55, 3, 20, 10.00, 'pendente', NULL, NULL, '2025-11-18 14:55:58', '2025-11-18 14:55:58'),
(56, 3, 20, 10.00, 'pendente', NULL, NULL, '2025-11-18 14:57:20', '2025-11-18 14:57:20'),
(57, 3, 20, 10.00, 'pendente', NULL, NULL, '2025-11-18 14:57:21', '2025-11-18 14:57:21'),
(58, 3, 10, 5.00, 'pendente', NULL, NULL, '2025-11-18 14:59:10', '2025-11-18 14:59:10'),
(59, 5, 10, 5.00, 'pendente', NULL, NULL, '2025-11-18 15:07:15', '2025-11-18 15:07:15'),
(60, 3, 10, 5.00, 'pendente', NULL, NULL, '2025-11-18 15:15:58', '2025-11-18 15:15:58'),
(61, 3, 10, 5.00, 'pendente', NULL, NULL, '2025-11-18 15:18:18', '2025-11-18 15:18:18'),
(62, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-18 15:18:22', '2025-11-18 15:18:22'),
(63, 6, 60, 30.00, 'pendente', NULL, NULL, '2025-11-19 14:05:54', '2025-11-19 14:05:54'),
(64, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-24 02:23:23', '2025-11-24 02:23:23'),
(65, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-24 14:15:09', '2025-11-24 14:15:09'),
(66, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-24 15:10:03', '2025-11-24 15:10:03'),
(67, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-24 15:12:26', '2025-11-24 15:12:26'),
(68, 3, 60, 30.00, 'pendente', NULL, NULL, '2025-11-24 15:12:43', '2025-11-24 15:12:43'),
(69, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-25 15:27:25', '2025-11-25 15:27:25'),
(70, 3, 10, 5.00, 'pendente', NULL, NULL, '2025-11-25 15:31:11', '2025-11-25 15:31:11'),
(71, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-26 11:21:05', '2025-11-26 11:21:05'),
(72, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-26 11:24:22', '2025-11-26 11:24:22'),
(73, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-26 11:42:51', '2025-11-26 11:42:51'),
(74, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-26 11:55:41', '2025-11-26 11:55:41'),
(75, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-26 12:06:49', '2025-11-26 12:06:49'),
(76, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-26 12:12:12', '2025-11-26 12:12:12'),
(77, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-26 12:22:12', '2025-11-26 12:22:12'),
(78, 3, 10, 5.00, 'pendente', NULL, NULL, '2025-11-26 16:10:25', '2025-11-26 16:10:25'),
(79, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-26 16:11:35', '2025-11-26 16:11:35'),
(80, 3, 10, 5.00, 'pendente', NULL, NULL, '2025-11-26 16:15:32', '2025-11-26 16:15:32'),
(81, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-27 10:40:00', '2025-11-27 10:40:00'),
(82, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-27 10:41:25', '2025-11-27 10:41:25'),
(83, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-27 12:14:09', '2025-11-27 12:14:09'),
(84, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-27 12:24:19', '2025-11-27 12:24:19'),
(85, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-27 12:31:00', '2025-11-27 12:31:00'),
(86, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-27 12:50:36', '2025-11-27 12:50:36'),
(87, 3, 2, 1.50, 'pendente', NULL, NULL, '2025-11-27 13:10:42', '2025-11-27 13:10:42');

-- --------------------------------------------------------

--
-- Estrutura para tabela `recarga`
--

CREATE TABLE `recarga` (
  `id_recarga` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_pagamento` int(11) NOT NULL,
  `situacao` enum('ativo','inativo') DEFAULT 'inativo',
  `data_inicio` datetime DEFAULT NULL,
  `data_fim` datetime DEFAULT NULL,
  `plano` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `recarga`
--

INSERT INTO `recarga` (`id_recarga`, `id_usuario`, `id_pagamento`, `situacao`, `data_inicio`, `data_fim`, `plano`) VALUES
(38, 3, 70, 'inativo', '2025-11-25 12:31:11', '2025-11-26 08:11:00', '10 minutos'),
(39, 3, 71, 'inativo', '2025-11-26 08:21:05', '2025-11-26 08:25:00', '2 minutos'),
(40, 3, 72, 'inativo', '2025-11-26 08:24:22', '2025-11-26 08:51:00', '2 minutos'),
(41, 3, 73, 'inativo', '2025-11-26 08:42:51', '2025-11-26 08:44:51', '2 minutos'),
(42, 3, 74, 'inativo', '2025-11-26 08:55:41', '2025-11-26 08:57:41', '2 minutos'),
(43, 3, 75, 'inativo', '2025-11-26 09:06:49', '2025-11-26 09:08:49', '2 minutos'),
(44, 3, 76, 'inativo', '2025-11-26 09:12:12', '2025-11-26 09:14:12', '2 minutos'),
(45, 3, 77, 'inativo', '2025-11-26 09:22:12', '2025-11-26 09:24:12', '2 minutos'),
(46, 3, 78, 'inativo', '2025-11-26 13:10:25', '2025-11-26 13:20:25', '10 minutos'),
(47, 3, 79, 'inativo', '2025-11-26 13:11:35', '2025-11-26 13:13:35', '2 minutos'),
(48, 3, 80, 'inativo', '2025-11-26 13:15:32', '2025-11-26 13:25:32', '10 minutos'),
(49, 3, 81, 'inativo', '2025-11-27 07:40:00', '2025-11-27 07:42:00', '2 minutos'),
(50, 3, 82, 'inativo', '2025-11-27 07:41:25', '2025-11-27 07:43:25', '2 minutos'),
(51, 3, 83, 'inativo', '2025-11-27 09:14:09', '2025-11-27 09:16:09', '2 minutos'),
(52, 3, 84, 'inativo', '2025-11-27 09:24:19', '2025-11-27 09:26:19', '2 minutos'),
(53, 3, 85, 'inativo', '2025-11-27 09:31:00', '2025-11-27 09:33:00', '2 minutos'),
(54, 3, 86, 'inativo', '2025-11-27 09:50:36', '2025-11-27 09:52:36', '2 minutos'),
(55, 3, 87, 'inativo', '2025-11-27 10:10:42', '2025-11-27 10:15:00', '2 minutos');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `senha` varchar(255) NOT NULL,
  `data_cadastro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id_usuario`, `nome`, `email`, `cpf`, `senha`, `data_cadastro`) VALUES
(3, 'Lamm', 'lamm@gmail.com', '12345678900', '$2y$10$SRQuUNu4WpvjTykQUhubF.CdrsiXoEKkgVHUQCUk3tybzemKsCpti', '2025-11-18 02:00:51'),
(4, 'Admin', 'admin@gmail.com', '11122233344', '$2y$10$H0rT1LC6E114QeFItabDfOhBYqFYTKLo8sGYPZmv/CvuPT0YHjWO6', '2025-11-18 12:24:53'),
(5, 'Maria', 'maria@gmail.com', '99999999999', '$2y$10$pNtEEAL4tacxhg1LRq35FONQnBPL1A79qolJqp5aXx6qlekm0nviO', '2025-11-18 15:06:55'),
(6, 'ximpa', 'ximpa777@gmail.com', '53364273800', '$2y$10$QmtyLeJnzkJVwWWArNHuMe0jWrbhj0ADI/yvDfYZbDI2zH27xdBUK', '2025-11-19 14:05:27'),
(9, 'jose fabio', 'josefabio@gmail.com', '08125150803', '$2y$10$EatB5n34b6vEcDwd.vLL.uK9z8LgqXuKSmPPbBrqNvcEBT2d7F/6S', '2025-11-27 13:10:05');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `categorias`
--
ALTER TABLE `categorias`
  ADD PRIMARY KEY (`id_categoria`),
  ADD UNIQUE KEY `nome` (`nome`);

--
-- Índices de tabela `estabelecimentos`
--
ALTER TABLE `estabelecimentos`
  ADD PRIMARY KEY (`id_estabelecimento`),
  ADD KEY `id_categoria` (`id_categoria`);

--
-- Índices de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD PRIMARY KEY (`id_pagamento`),
  ADD KEY `id_usuario` (`id_usuario`);

--
-- Índices de tabela `recarga`
--
ALTER TABLE `recarga`
  ADD PRIMARY KEY (`id_recarga`),
  ADD KEY `id_usuario` (`id_usuario`),
  ADD KEY `id_pagamento` (`id_pagamento`);

--
-- Índices de tabela `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `cpf` (`cpf`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `categorias`
--
ALTER TABLE `categorias`
  MODIFY `id_categoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de tabela `estabelecimentos`
--
ALTER TABLE `estabelecimentos`
  MODIFY `id_estabelecimento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT de tabela `pagamentos`
--
ALTER TABLE `pagamentos`
  MODIFY `id_pagamento` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT de tabela `recarga`
--
ALTER TABLE `recarga`
  MODIFY `id_recarga` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=56;

--
-- AUTO_INCREMENT de tabela `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `estabelecimentos`
--
ALTER TABLE `estabelecimentos`
  ADD CONSTRAINT `estabelecimentos_ibfk_1` FOREIGN KEY (`id_categoria`) REFERENCES `categorias` (`id_categoria`);

--
-- Restrições para tabelas `pagamentos`
--
ALTER TABLE `pagamentos`
  ADD CONSTRAINT `pagamentos_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Restrições para tabelas `recarga`
--
ALTER TABLE `recarga`
  ADD CONSTRAINT `recarga_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `recarga_ibfk_2` FOREIGN KEY (`id_pagamento`) REFERENCES `pagamentos` (`id_pagamento`) ON DELETE CASCADE ON UPDATE CASCADE;

DELIMITER $$
--
-- Eventos
--
$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
