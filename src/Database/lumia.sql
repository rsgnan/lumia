-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 18/08/2026 às 15:14
-- Versão do servidor: 11.8.8-MariaDB
-- Versão do PHP: 8.5.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `lumia`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `activity_logs`
--

CREATE TABLE `activity_logs` (
  `id` int(10) UNSIGNED NOT NULL,
  `record_type` varchar(50) NOT NULL,
  `record_id` int(10) UNSIGNED NOT NULL,
  `action` varchar(50) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `icon_svg` mediumtext DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Despejando dados para a tabela `categories`
--

INSERT INTO `categories` (`id`, `name`, `icon_svg`, `created_at`, `updated_at`) VALUES
(1, 'Vestuários', '<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><circle cx=\"12\" cy=\"4\" r=\"1.4\"/><path d=\"M12 5.4v2.2\"/><path d=\"M12 7.6l-9 6.4c-1 .7-.5 2.3.7 2.3h16.6c1.2 0 1.7-1.6.7-2.3l-9-6.4z\"/><line x1=\"4\" y1=\"20\" x2=\"20\" y2=\"20\"/></svg>', '2026-08-01 15:56:53', '2026-08-17 15:53:00'),
(2, 'Pedras', '<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M6 3h12l3 5-9 13L3 8z\"/><path d=\"M3 8h18\"/><path d=\"M9 3l-2 5 5 13 5-13-2-5\"/></svg>', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(3, 'Guias', '<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M4 6c2 6 6 9 8 9s6-3 8-9\"/><circle cx=\"4\" cy=\"6\" r=\"1.4\" fill=\"currentColor\" stroke=\"none\"/><circle cx=\"7.5\" cy=\"11.5\" r=\"1.4\" fill=\"currentColor\" stroke=\"none\"/><circle cx=\"12\" cy=\"14.5\" r=\"1.6\" fill=\"currentColor\" stroke=\"none\"/><circle cx=\"16.5\" cy=\"11.5\" r=\"1.4\" fill=\"currentColor\" stroke=\"none\"/><circle cx=\"20\" cy=\"6\" r=\"1.4\" fill=\"currentColor\" stroke=\"none\"/></svg>', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(4, 'Livros', '<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M12 6c-1.5-1.3-3.6-2-6.5-2-1 0-1.5.3-1.5 1v13c0 .7.5 1 1.5 1 2.9 0 5 .7 6.5 2\"/><path d=\"M12 6c1.5-1.3 3.6-2 6.5-2 1 0 1.5.3 1.5 1v13c0 .7-.5 1-1.5 1-2.9 0-5 .7-6.5 2V6z\"/></svg>', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(5, 'Banhos', '<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><path d=\"M12 2s7 8.5 7 13a7 7 0 01-14 0c0-4.5 7-13 7-13z\"/></svg>', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(6, 'Velas', '<svg viewBox=\"0 0 24 24\" fill=\"none\" stroke=\"currentColor\" stroke-width=\"2\" stroke-linecap=\"round\" stroke-linejoin=\"round\"><rect x=\"9\" y=\"10\" width=\"6\" height=\"11\" rx=\"1\"/><path d=\"M12 10c-1.5-1.8-1.2-3.6 0-5.5C13.2 6.4 13.5 8.2 12 10z\"/></svg>', '2026-08-17 15:53:00', '2026-08-17 15:53:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `products`
--

CREATE TABLE `products` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `category_id` int(10) UNSIGNED NOT NULL,
  `tag` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `stock` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `description` text NOT NULL,
  `photo` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Despejando dados para a tabela `products`
--

INSERT INTO `products` (`id`, `name`, `category_id`, `tag`, `price`, `stock`, `description`, `photo`, `created_at`, `updated_at`) VALUES
(5, 'Saia Branca Rendada', 1, 'Ritual', 89.90, 18, 'Saia longa em tecido leve com barra rendada, ideal para gira e rituais de Umbanda.', 'vestuario-saia-branca-rendada.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(6, 'Blusa de Cetim Branca', 1, 'Gira', 69.90, 22, 'Blusa de manga longa em cetim branco, corte tradicional para trabalhos de terreiro.', 'vestuario-blusa-de-cetim-branca.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(7, 'Turbante Branco Amarrado', 1, 'Cabeça', 39.90, 30, 'Turbante em tecido de algodão já modelado, pronto para uso em rituais e giras.', 'vestuario-turbante-branco-amarrado.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(8, 'Pano da Costa Estampado', 1, 'Ombro', 79.90, 15, 'Pano da costa em algodão estampado, usado sobre o ombro em cerimônias de Umbanda.', 'vestuario-pano-da-costa-estampado.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(9, 'Anágua de Balão', 1, 'Rodada', 54.90, 20, 'Anágua rodada em tecido fresco, dá volume às saias rituais.', 'vestuario-anagua-de-balao.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(10, 'Camisa de Alinhavo Masculina', 1, 'Terno', 74.90, 14, 'Camisa branca de linho com alinhavo bordado à mão, uso masculino em cerimônias.', 'vestuario-camisa-de-alinhavo-masculina.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(11, 'Saia Rodada Sete Cores', 1, 'Pombagira', 99.90, 10, 'Saia rodada com fitas nas sete cores, referência às linhas de Pombagira.', 'vestuario-saia-rodada-sete-cores.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(12, 'Blusa Ciganinha Vermelha', 1, 'Cigana', 64.90, 16, 'Blusa ombro a ombro vermelha, modelo cigana usado em giras de Exu e Pombagira.', 'vestuario-blusa-ciganinha-vermelha.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(13, 'Quartzo Rosa Bruto', 2, 'Amor', 24.90, 40, 'Pedra bruta de quartzo rosa, associada ao amor próprio e à harmonia afetiva.', 'pedra-quartzo-rosa-bruto.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(14, 'Ametista Ponta Natural', 2, 'Proteção', 34.90, 35, 'Ponta natural de ametista, usada para proteção espiritual e elevação da energia.', 'pedra-ametista-ponta-natural.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(15, 'Olho de Tigre Rolado', 2, 'Prosperidade', 19.90, 45, 'Pedra rolada de olho de tigre, associada à prosperidade e à firmeza de propósito.', 'pedra-olho-de-tigre-rolado.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(16, 'Quartzo Branco Lapidado', 2, 'Limpeza', 22.90, 38, 'Quartzo branco lapidado, indicado para limpeza e equilíbrio energético do ambiente.', 'pedra-quartzo-branco-lapidado.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(17, 'Turmalina Negra Bruta', 2, 'Aterramento', 29.90, 28, 'Pedra bruta de turmalina negra, usada para aterramento e proteção contra energias densas.', 'pedra-turmalina-negra-bruta.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(18, 'Citrino Ponta Natural', 2, 'Abundância', 32.90, 25, 'Ponta natural de citrino, associada à abundância e à alegria.', 'pedra-citrino-ponta-natural.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(19, 'Ágata Azul Rolada', 2, 'Calma', 21.90, 32, 'Pedra rolada de ágata azul, indicada para trazer calma e clareza mental.', 'pedra-agata-azul-rolada.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(20, 'Obsidiana Negra Polida', 2, 'Blindagem', 26.90, 30, 'Pedra polida de obsidiana negra, usada como blindagem energética.', 'pedra-obsidiana-negra-polida.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(21, 'Guia de Oxalá', 3, 'Paz', 119.90, 12, 'Guia de contas brancas dedicada a Oxalá, símbolo de paz e criação.', 'guia-guia-de-oxala.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(22, 'Guia de Iemanjá', 3, 'Mar', 129.90, 12, 'Guia de contas em tons de azul e cristal, dedicada a Iemanjá, rainha do mar.', 'guia-guia-de-iemanja.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(23, 'Guia de Ogum', 3, 'Vitória', 109.90, 14, 'Guia de contas azul-marinho, dedicada a Ogum, orixá guerreiro.', 'guia-guia-de-ogum.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(24, 'Guia de Oxóssi', 3, 'Mata', 114.90, 13, 'Guia de contas verdes, dedicada a Oxóssi, senhor das matas.', 'guia-guia-de-oxossi.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(25, 'Guia de Xangô', 3, 'Justiça', 124.90, 11, 'Guia de contas marrom e branco, dedicada a Xangô, orixá da justiça.', 'guia-guia-de-xango.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(26, 'Guia de Iansã', 3, 'Ventania', 109.90, 13, 'Guia de contas amarelas e vermelhas, dedicada a Iansã, senhora dos ventos.', 'guia-guia-de-iansa.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(27, 'Guia de Oxum', 3, 'Amor', 119.90, 12, 'Guia de contas douradas, dedicada a Oxum, orixá do amor e das águas doces.', 'guia-guia-de-oxum.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(28, 'Guia de Pombagira', 3, 'Mulher', 99.90, 15, 'Guia de contas coloridas, dedicada às Pombagiras, entidades femininas da Umbanda.', 'guia-guia-de-pombagira.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(29, 'Umbanda Sagrada', 4, 'Fundamentos', 49.90, 20, 'Livro introdutório sobre os fundamentos e a história da Umbanda.', 'livro-umbanda-sagrada.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(30, 'Pontos Cantados na Umbanda', 4, 'Cânticos', 39.90, 24, 'Coletânea de pontos cantados usados em giras e rituais.', 'livro-pontos-cantados-na-umbanda.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(31, 'As Sete Linhas de Umbanda', 4, 'Linhas', 44.90, 18, 'Estudo sobre as sete linhas de trabalho espiritual da Umbanda.', 'livro-as-sete-linhas-de-umbanda.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(32, 'Ervas Sagradas na Umbanda', 4, 'Ervas', 42.90, 19, 'Guia prático sobre o uso ritualístico de ervas na Umbanda.', 'livro-ervas-sagradas-na-umbanda.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(33, 'Orixás — Mitos e Mensagens', 4, 'Mitologia', 54.90, 16, 'Livro sobre a mitologia e as mensagens dos orixás africanos.', 'livro-orixas-mitos-e-mensagens.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(34, 'O Livro dos Médiuns Umbandistas', 4, 'Mediunidade', 47.90, 17, 'Obra dedicada ao desenvolvimento mediúnico dentro da Umbanda.', 'livro-o-livro-dos-mediuns-umbandistas.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(35, 'Exu — O Guardião das Encruzilhadas', 4, 'Exu', 45.90, 20, 'Estudo sobre a figura de Exu e seu papel como guardião espiritual.', 'livro-exu-o-guardiao-das-encruzilhadas.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(36, 'Preto Velho — Sabedoria Ancestral', 4, 'Preto Velho', 41.90, 21, 'Livro sobre a sabedoria e a história dos Pretos Velhos na Umbanda.', 'livro-preto-velho-sabedoria-ancestral.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(37, 'Banho de Arruda', 5, 'Descarrego', 14.90, 50, 'Banho ritual à base de arruda, indicado para descarrego energético.', 'banho-banho-de-arruda.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(38, 'Banho de Alecrim', 5, 'Proteção', 15.90, 48, 'Banho ritual à base de alecrim, indicado para proteção espiritual.', 'banho-banho-de-alecrim.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(39, 'Banho de Rosas Brancas', 5, 'Amor Próprio', 16.90, 40, 'Banho ritual à base de pétalas de rosas brancas, indicado para amor próprio.', 'banho-banho-de-rosas-brancas.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(40, 'Banho de Sete Ervas', 5, 'Abertura de Caminhos', 18.90, 35, 'Banho ritual composto por sete ervas, indicado para abertura de caminhos.', 'banho-banho-de-sete-ervas.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(41, 'Banho de Manjericão', 5, 'Prosperidade', 15.90, 42, 'Banho ritual à base de manjericão, associado à prosperidade.', 'banho-banho-de-manjericao.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(42, 'Banho de Espada de Ogum', 5, 'Força', 17.90, 30, 'Banho ritual à base de espada-de-ogum, indicado para força e coragem.', 'banho-banho-de-espada-de-ogum.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(43, 'Banho de Alfazema', 5, 'Harmonia', 16.90, 38, 'Banho ritual à base de alfazema, indicado para harmonia no lar.', 'banho-banho-de-alfazema.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(44, 'Banho de Folha de Louro', 5, 'Sorte', 14.90, 45, 'Banho ritual à base de folhas de louro, associado à sorte.', 'banho-banho-de-folha-de-louro.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(45, 'Vela Branca 7 Dias', 6, 'Paz', 12.90, 60, 'Vela branca de sete dias, usada para pedidos de paz e harmonia.', 'vela-vela-branca-7-dias.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(46, 'Vela Vermelha', 6, 'Paixão', 8.90, 70, 'Vela vermelha, associada à paixão e à força vital.', 'vela-vela-vermelha.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(47, 'Vela Azul', 6, 'Cura', 8.90, 65, 'Vela azul, associada à cura e à tranquilidade.', 'vela-vela-azul.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(48, 'Vela Amarela', 6, 'Prosperidade', 8.90, 68, 'Vela amarela, associada à prosperidade e à conquista.', 'vela-vela-amarela.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(49, 'Vela Verde', 6, 'Esperança', 8.90, 66, 'Vela verde, associada à esperança e à cura financeira.', 'vela-vela-verde.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(50, 'Vela Roxa', 6, 'Espiritualidade', 9.90, 55, 'Vela roxa, associada à espiritualidade e à elevação.', 'vela-vela-roxa.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(51, 'Vela de Exu Preta e Vermelha', 6, 'Exu', 11.90, 40, 'Vela bicolor preta e vermelha, usada em trabalhos para Exu.', 'vela-vela-de-exu-preta-e-vermelha.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00'),
(52, 'Vela de Pombagira Rosa', 6, 'Pombagira', 11.90, 40, 'Vela rosa, usada em trabalhos e oferendas para Pombagira.', 'vela-vela-de-pombagira-rosa.jpg', '2026-08-17 15:53:00', '2026-08-17 15:53:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sales`
--

CREATE TABLE `sales` (
  `id` int(10) UNSIGNED NOT NULL,
  `customer_name` varchar(150) NOT NULL,
  `discount_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `total_amount` decimal(10,2) NOT NULL DEFAULT 0.00,
  `status` varchar(20) NOT NULL DEFAULT 'completed',
  `user_id` int(10) UNSIGNED DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Despejando dados para a tabela `sales`
--

INSERT INTO `sales` (`id`, `customer_name`, `discount_amount`, `total_amount`, `status`, `user_id`, `created_at`, `updated_at`) VALUES
(1, 'Maria das Graças Souza', 15.00, 41.99, 'completed', NULL, '2026-08-16 15:53:00', '2026-08-16 15:53:00'),
(2, 'João Pedro Almeida', 0.00, 540.10, 'completed', NULL, '2026-08-15 15:53:00', '2026-08-15 15:53:00'),
(3, 'Fernanda Lima', 0.00, 82.42, 'completed', NULL, '2026-08-12 15:53:00', '2026-08-12 15:53:00'),
(4, 'Carlos Eduardo Santos', 15.00, 323.98, 'completed', NULL, '2026-08-09 15:53:00', '2026-08-09 15:53:00'),
(5, 'Aparecida Ferreira', 0.00, 74.70, 'completed', NULL, '2026-08-05 15:53:00', '2026-08-05 15:53:00'),
(6, 'Ricardo Nascimento', 0.00, 354.92, 'completed', NULL, '2026-08-03 15:53:00', '2026-08-03 15:53:00'),
(7, 'Juliana Costa', 0.00, 193.60, 'cancelled', NULL, '2026-08-02 15:53:00', '2026-08-02 15:53:00'),
(8, 'Antônio Carlos Pereira', 5.00, 409.60, 'completed', NULL, '2026-07-30 15:53:00', '2026-07-30 15:53:00'),
(9, 'Vera Lúcia Rodrigues', 5.00, 98.10, 'completed', NULL, '2026-07-27 15:53:00', '2026-07-27 15:53:00'),
(10, 'Marcos Vinícius Oliveira', 0.00, 372.38, 'completed', NULL, '2026-07-23 15:53:00', '2026-07-23 15:53:00'),
(11, 'Rosana Batista', 15.00, 329.20, 'completed', NULL, '2026-07-19 15:53:00', '2026-07-19 15:53:00'),
(12, 'Sebastião Duarte', 15.00, 20.70, 'completed', NULL, '2026-07-18 15:53:00', '2026-07-18 15:53:00'),
(13, 'Cíntia Barbosa', 0.00, 108.30, 'completed', NULL, '2026-07-17 15:53:00', '2026-07-17 15:53:00'),
(14, 'Eduardo Martins', 0.00, 99.90, 'completed', NULL, '2026-07-16 15:53:00', '2026-07-16 15:53:00'),
(15, 'Neide Ramos', 5.00, 30.70, 'completed', NULL, '2026-07-14 15:53:00', '2026-07-14 15:53:00'),
(16, 'Paulo Henrique Cardoso', 10.00, 476.00, 'completed', NULL, '2026-07-10 15:53:00', '2026-07-10 15:53:00'),
(17, 'Sandra Regina Melo', 0.00, 301.33, 'completed', NULL, '2026-07-06 15:53:00', '2026-07-06 15:53:00'),
(18, 'Wagner Teixeira', 15.00, 60.60, 'cancelled', NULL, '2026-07-02 15:53:00', '2026-07-02 15:53:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(10) UNSIGNED NOT NULL,
  `sale_id` int(10) UNSIGNED NOT NULL,
  `product_id` int(10) UNSIGNED DEFAULT NULL,
  `product_name` varchar(150) NOT NULL,
  `original_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `unit_price` decimal(10,2) NOT NULL DEFAULT 0.00,
  `quantity` int(10) UNSIGNED NOT NULL DEFAULT 1,
  `subtotal` decimal(10,2) NOT NULL DEFAULT 0.00,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Despejando dados para a tabela `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `product_id`, `product_name`, `original_price`, `unit_price`, `quantity`, `subtotal`, `created_at`, `updated_at`) VALUES
(1, 1, 6, 'Blusa de Cetim Branca', 69.90, 56.99, 1, 56.99, '2026-08-16 15:53:00', '2026-08-16 15:53:00'),
(2, 2, 7, 'Turbante Branco Amarrado', 39.90, 39.90, 1, 39.90, '2026-08-15 15:53:00', '2026-08-15 15:53:00'),
(3, 2, 6, 'Blusa de Cetim Branca', 69.90, 69.90, 3, 209.70, '2026-08-15 15:53:00', '2026-08-15 15:53:00'),
(4, 2, 10, 'Camisa de Alinhavo Masculina', 74.90, 74.90, 3, 224.70, '2026-08-15 15:53:00', '2026-08-15 15:53:00'),
(5, 2, 18, 'Citrino Ponta Natural', 32.90, 32.90, 2, 65.80, '2026-08-15 15:53:00', '2026-08-15 15:53:00'),
(6, 3, 49, 'Vela Verde', 8.90, 8.90, 1, 8.90, '2026-08-12 15:53:00', '2026-08-12 15:53:00'),
(7, 3, 32, 'Ervas Sagradas na Umbanda', 42.90, 36.76, 2, 73.52, '2026-08-12 15:53:00', '2026-08-12 15:53:00'),
(8, 4, 43, 'Banho de Alfazema', 16.90, 16.90, 1, 16.90, '2026-08-09 15:53:00', '2026-08-09 15:53:00'),
(9, 4, 21, 'Guia de Oxalá', 119.90, 101.19, 2, 202.38, '2026-08-09 15:53:00', '2026-08-09 15:53:00'),
(10, 4, 7, 'Turbante Branco Amarrado', 39.90, 39.90, 3, 119.70, '2026-08-09 15:53:00', '2026-08-09 15:53:00'),
(11, 5, 50, 'Vela Roxa', 9.90, 9.90, 2, 19.80, '2026-08-05 15:53:00', '2026-08-05 15:53:00'),
(12, 5, 9, 'Anágua de Balão', 54.90, 54.90, 1, 54.90, '2026-08-05 15:53:00', '2026-08-05 15:53:00'),
(13, 6, 34, 'O Livro dos Médiuns Umbandistas', 47.90, 47.90, 1, 47.90, '2026-08-03 15:53:00', '2026-08-03 15:53:00'),
(14, 6, 45, 'Vela Branca 7 Dias', 12.90, 12.90, 3, 38.70, '2026-08-03 15:53:00', '2026-08-03 15:53:00'),
(15, 6, 28, 'Guia de Pombagira', 99.90, 89.44, 3, 268.32, '2026-08-03 15:53:00', '2026-08-03 15:53:00'),
(16, 7, 34, 'O Livro dos Médiuns Umbandistas', 47.90, 47.90, 3, 143.70, '2026-08-02 15:53:00', '2026-08-02 15:53:00'),
(17, 7, 29, 'Umbanda Sagrada', 49.90, 49.90, 1, 49.90, '2026-08-02 15:53:00', '2026-08-02 15:53:00'),
(18, 8, 7, 'Turbante Branco Amarrado', 39.90, 39.90, 1, 39.90, '2026-07-30 15:53:00', '2026-07-30 15:53:00'),
(19, 8, 25, 'Guia de Xangô', 124.90, 124.90, 3, 374.70, '2026-07-30 15:53:00', '2026-07-30 15:53:00'),
(20, 9, 46, 'Vela Vermelha', 8.90, 8.90, 3, 26.70, '2026-07-27 15:53:00', '2026-07-27 15:53:00'),
(21, 9, 36, 'Preto Velho — Sabedoria Ancestral', 41.90, 38.20, 2, 76.40, '2026-07-27 15:53:00', '2026-07-27 15:53:00'),
(22, 10, 42, 'Banho de Espada de Ogum', 17.90, 17.90, 1, 17.90, '2026-07-23 15:53:00', '2026-07-23 15:53:00'),
(23, 10, 30, 'Pontos Cantados na Umbanda', 39.90, 32.88, 1, 32.88, '2026-07-23 15:53:00', '2026-07-23 15:53:00'),
(24, 10, 28, 'Guia de Pombagira', 99.90, 99.90, 3, 299.70, '2026-07-23 15:53:00', '2026-07-23 15:53:00'),
(25, 10, 19, 'Ágata Azul Rolada', 21.90, 21.90, 1, 21.90, '2026-07-23 15:53:00', '2026-07-23 15:53:00'),
(26, 11, 40, 'Banho de Sete Ervas', 18.90, 18.90, 3, 56.70, '2026-07-19 15:53:00', '2026-07-19 15:53:00'),
(27, 11, 5, 'Saia Branca Rendada', 89.90, 89.90, 3, 269.70, '2026-07-19 15:53:00', '2026-07-19 15:53:00'),
(28, 11, 48, 'Vela Amarela', 8.90, 8.90, 2, 17.80, '2026-07-19 15:53:00', '2026-07-19 15:53:00'),
(29, 12, 51, 'Vela de Exu Preta e Vermelha', 11.90, 11.90, 3, 35.70, '2026-07-18 15:53:00', '2026-07-18 15:53:00'),
(30, 13, 45, 'Vela Branca 7 Dias', 12.90, 12.90, 1, 12.90, '2026-07-17 15:53:00', '2026-07-17 15:53:00'),
(31, 13, 37, 'Banho de Arruda', 14.90, 14.90, 3, 44.70, '2026-07-17 15:53:00', '2026-07-17 15:53:00'),
(32, 13, 43, 'Banho de Alfazema', 16.90, 16.90, 3, 50.70, '2026-07-17 15:53:00', '2026-07-17 15:53:00'),
(33, 14, 28, 'Guia de Pombagira', 99.90, 99.90, 1, 99.90, '2026-07-16 15:53:00', '2026-07-16 15:53:00'),
(34, 15, 51, 'Vela de Exu Preta e Vermelha', 11.90, 11.90, 3, 35.70, '2026-07-14 15:53:00', '2026-07-14 15:53:00'),
(35, 16, 40, 'Banho de Sete Ervas', 18.90, 18.90, 1, 18.90, '2026-07-10 15:53:00', '2026-07-10 15:53:00'),
(36, 16, 15, 'Olho de Tigre Rolado', 19.90, 19.90, 3, 59.70, '2026-07-10 15:53:00', '2026-07-10 15:53:00'),
(37, 16, 21, 'Guia de Oxalá', 119.90, 119.90, 3, 359.70, '2026-07-10 15:53:00', '2026-07-10 15:53:00'),
(38, 16, 38, 'Banho de Alecrim', 15.90, 15.90, 3, 47.70, '2026-07-10 15:53:00', '2026-07-10 15:53:00'),
(39, 17, 12, 'Blusa Ciganinha Vermelha', 64.90, 54.06, 3, 162.18, '2026-07-06 15:53:00', '2026-07-06 15:53:00'),
(40, 17, 20, 'Obsidiana Negra Polida', 26.90, 26.90, 1, 26.90, '2026-07-06 15:53:00', '2026-07-06 15:53:00'),
(41, 17, 19, 'Ágata Azul Rolada', 21.90, 20.49, 1, 20.49, '2026-07-06 15:53:00', '2026-07-06 15:53:00'),
(42, 17, 9, 'Anágua de Balão', 54.90, 45.88, 2, 91.76, '2026-07-06 15:53:00', '2026-07-06 15:53:00'),
(43, 18, 39, 'Banho de Rosas Brancas', 16.90, 16.90, 3, 50.70, '2026-07-02 15:53:00', '2026-07-02 15:53:00'),
(44, 18, 13, 'Quartzo Rosa Bruto', 24.90, 24.90, 1, 24.90, '2026-07-02 15:53:00', '2026-07-02 15:53:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(150) NOT NULL,
  `username` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(255) NOT NULL,
  `last_ip` varchar(45) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_uca1400_ai_ci;

--
-- Despejando dados para a tabela `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `email`, `password`, `last_ip`, `created_at`, `updated_at`) VALUES
(1, 'Administrador', 'admin', 'admin@email.com', '$2y$10$5SADRdU961B7gcUhhFAHTu3SVyeBy8t4gjjGTZk.xHfGVtGk1NqNa', NULL, '2026-08-16 15:59:40', '2026-08-16 15:59:40');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_record` (`record_type`,`record_id`),
  ADD KEY `idx_user` (`user_id`),
  ADD KEY `idx_action` (`action`);

--
-- Índices de tabela `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_products_category` (`category_id`),
  ADD KEY `idx_products_name` (`name`);

--
-- Índices de tabela `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idx_sales_customer` (`customer_name`),
  ADD KEY `idx_sales_status` (`status`),
  ADD KEY `fk_sales_user` (`user_id`);

--
-- Índices de tabela `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_sale_items_sale` (`sale_id`),
  ADD KEY `fk_sale_items_product` (`product_id`);

--
-- Índices de tabela `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `activity_logs`
--
ALTER TABLE `activity_logs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de tabela `products`
--
ALTER TABLE `products`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=53;

--
-- AUTO_INCREMENT de tabela `sales`
--
ALTER TABLE `sales`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT de tabela `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT de tabela `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `activity_logs`
--
ALTER TABLE `activity_logs`
  ADD CONSTRAINT `fk_activity_logs_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Restrições para tabelas `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `fk_products_category` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON UPDATE CASCADE;

--
-- Restrições para tabelas `sales`
--
ALTER TABLE `sales`
  ADD CONSTRAINT `fk_sales_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Restrições para tabelas `sale_items`
--
ALTER TABLE `sale_items`
  ADD CONSTRAINT `fk_sale_items_product` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_sale_items_sale` FOREIGN KEY (`sale_id`) REFERENCES `sales` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
