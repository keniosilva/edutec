-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 15/08/2025 às 01:00
-- Versão do servidor: 8.0.33
-- Versão do PHP: 8.2.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `edutec`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `equipamentos`
--

CREATE TABLE `equipamentos` (
  `id_equipamento` int NOT NULL,
  `nome_equipamento` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Despejando dados para a tabela `equipamentos`
--

INSERT INTO `equipamentos` (`id_equipamento`, `nome_equipamento`, `descricao`, `data_cadastro`) VALUES
(1, 'CHROMEBOOK LENOVO 100E', 'PRETO', '2025-03-06 00:00:00'),
(2, 'CHROMEBOOK CINZA', 'SAMSUNG CONNECT', '2025-03-06 00:00:00'),
(3, 'ALMOFADÃO GOTA CORINO ACQUA ', 'ALMOFADÃO', '2025-03-13 00:00:00'),
(4, 'ALMOFADÃO GOTA CORINO AMARELO ', 'ALMOFADÃO ', '2025-03-13 00:00:00'),
(5, 'ALMOFADÃO GOTA CORINO AZUL ROYAL ', 'ALMOFADÃO', '2025-03-13 00:00:00'),
(6, 'ALMOADÃO GOTA CORINO LARANJA ', 'ALMOFADÃO', '2025-03-13 00:00:00'),
(7, 'ALMOFADÃO GOTA CORINO VERMELHO ', 'ALMOFADÃO', '2025-03-13 00:00:00'),
(8, 'ARMÁRIO 2 PORTAS ', '120X60X60X74CM  BRANCO COM PRATELEIRAS ', '2025-03-13 00:00:00'),
(9, 'ARMÁRIO GAVETA ', '120X60X72 CM \r\nBRANCO', '2025-03-13 00:00:00'),
(10, 'BANCO BOOTH ', 'TECIDO ', '2025-03-13 00:00:00'),
(11, 'CADEIRA SUMMER AZUL', 'TAMANHO 7', '2025-03-13 00:00:00'),
(12, 'CADEIRA SUMMER VERDE PISTACHE ', 'TAMANHO 7 ', '2025-03-13 00:00:00'),
(13, 'ESTANTE MADEIRA MAKER', 'ESTANTE ABERTA', '2025-03-13 00:00:00'),
(14, 'MESA CONVIVÊNCIA ', 'REDONDA 110X74 TAMPO BRANCO', '2025-03-13 00:00:00'),
(15, 'MESA FLEX TRIANGULAR ', 'TAMPO BRANCO ', '2025-03-13 00:00:00'),
(16, 'MESA NOTE BRANCA ', 'MESA PEQUENA ', '2025-03-13 00:00:00'),
(17, 'MESA PROFESSOR REDONDA', 'TAMPO BRANCO ', '2025-03-13 00:00:00'),
(18, 'PUFF ARCO CORINO AMARELO ', '45CM \r\n', '2025-03-13 00:00:00'),
(19, 'PUFF ARCO CORINO VERMELHO ', '45CM', '2025-03-13 00:00:00'),
(20, 'PUFF MODELO GOOGLE', '45CM', '2025-03-13 00:00:00'),
(21, 'PUFF QUADRADO AMARELO ', '45CM', '2025-03-13 00:00:00'),
(22, 'PUFF QUADRADO ACQUA', '45CM', '2025-03-13 00:00:00'),
(23, 'PUFF QUADRADO AZUL ROYAL', '45CM', '2025-03-13 00:00:00'),
(24, 'PUFF QUADRADO LARANJA ', '45CM', '2025-03-13 00:00:00'),
(25, 'PROJETOR EPSON EXCEED YOUR VISION', 'CO_W01', '2025-03-13 00:00:00'),
(26, 'ESTAÇÃO DE CARGA E ARMAZENAMENTO 36', '36 PORTAS', '2025-03-13 00:00:00'),
(27, 'ESTAÇÃO E CARGA E ARMAZENAMENTO 24', '24 PORTAS', '2025-03-13 00:00:00'),
(28, 'LOUSA INTERATIVA PORTÁTIL', 'COM BATERIA ', '2025-03-13 00:00:00'),
(29, 'LOUSA LCD 75 IQT TOUCH', '75 POLEGADAS', '2025-03-13 00:00:00'),
(30, 'LOUSA LCD 75 VIEW SONIC ', '75 POLEGADAS', '2025-03-13 00:00:00'),
(31, 'MINI PC ', 'COMPUTADOR ULTRACOMPACTO E1P ', '2025-03-13 00:00:00'),
(32, 'CHROMEBOOK  SAMSUNG QUADRADO', 'CHROMEBOOK ', '2025-03-13 00:00:00'),
(33, 'MONITOR LED AOC', 'MONITOR 21', '2025-03-13 00:00:00'),
(34, 'KIT TECLADO/MOUSE', 'CBTECH K-W10BK ', '2025-03-13 00:00:00'),
(35, 'NOTEBOOK THINKPAD I5', 'CORE I5', '2025-03-13 00:00:00'),
(36, 'NOTEBOOK  THINKPAD AMD', 'AMD', '2025-03-13 00:00:00'),
(37, 'CADEIRA SUMMER ROXA', 'TAMANHO 7', '2025-03-13 00:00:00'),
(38, 'MESA RETAMGULAR ', 'TAMPO BRANCO', '2025-03-13 00:00:00'),
(39, 'CADEIRA SUMMER LARANJA', 'TAMANHO 7', '2025-03-13 00:00:00'),
(40, 'PUFF QUADRADO VERMELHO', '45CM', '2025-03-14 00:00:00'),
(41, 'CADEIRA SUMMER VERMELHA', 'TAM 7', '2025-03-18 00:00:00'),
(42, 'PUFF STAR CORINO LOARANJA', '45CM', '2025-03-18 00:00:00'),
(43, 'PUFF ARCO CORINO VERDE', '45CM', '2025-03-18 00:00:00'),
(44, 'CHOROMEBOOK CONNECT S/N: 08M89QARB007532', 'RESET FEITO ', '2025-03-24 00:00:00'),
(45, 'CHOROMEBBOOK CONNECT S/N:08M89QARB00196B PATRIMÔNIO 1230042', 'RESET FEITO', '2025-03-24 00:00:00'),
(46, 'CHOROMEBBOOK CONNECT S/N:08M89QAR902168L PATRIMÔNIO 1230044', 'RESET FEITO ', '2025-03-24 00:00:00'),
(47, 'CHOROMEBBOOK CONNECT S/N:08M89QAR901308V ', 'RESET FEITO ', '2025-03-24 00:00:00'),
(48, 'CHOROMEBBOOK CONNECT S/N:08M89QAR9000835F', 'RESET FEITO', '2025-03-24 00:00:00'),
(49, 'CHOROMEBBOOK CONNECT S/N:08M89QARB00658W', 'RESET FEITO', '2025-03-24 00:00:00'),
(50, 'CHROMEBOOK CONNECT S/N:08M89QARB00752L PATRIMÔNIO 1230034', 'RESET FEITO ', '2025-03-24 00:00:00'),
(51, 'CHOROMEBBOOK LENOVO 100E ', 'GEN 3', '2025-03-24 00:00:00'),
(52, 'PUFF QUADRADO ROXO', '45CM', '2025-04-22 00:00:00'),
(53, 'PUFF QUADRADO ROXO ', '45CM', '2025-05-09 00:00:00'),
(54, 'PUFF QUADRADO VERDE ', '45CM', '2025-05-09 00:00:00'),
(55, 'CHROMEBOOK 511 ACER  S/N NXKEQAL0014189EE859501', 'ACER TOUCHER', '2025-08-12 00:00:00'),
(56, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EE709501', 'ACER TOUCHER ', '2025-08-12 00:00:00'),
(57, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EE7C9501', 'ACER TOUCHER', '2025-08-12 00:00:00'),
(58, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EE7D9501', 'ACER TOUCHER', '2025-08-12 00:00:00'),
(59, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189ECA6901', 'ACER TOUCHER ', '2025-08-12 00:00:00'),
(60, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189ECD8901', 'ACER TOUCHER ', '2025-08-12 00:00:00'),
(61, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189ED809501', 'ACER TOUCHER ', '2025-08-12 00:00:00'),
(62, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189ED729501', 'ACER TOUCHER ', '2025-08-12 00:00:00'),
(63, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189ED769501', 'ACER TOUCHER ', '2025-08-12 00:00:00'),
(64, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EB659501', 'ACER TOUCHER', '2025-08-12 00:00:00'),
(65, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EEA49501', 'ACER TOUCHER', '2025-08-12 00:00:00'),
(66, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EDC39501', 'ACER TOUCHER', '2025-08-12 00:00:00'),
(67, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189ED959501', 'ACER TOUCHER ', '2025-08-12 00:00:00'),
(68, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189E92C9501', 'ACER TOUCHER', '2025-08-12 00:00:00'),
(69, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EAFD9501', 'ACER TOUCHER ', '2025-08-12 00:00:00'),
(70, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EE7A9501', 'ACER TOUCHER', '2025-08-12 00:00:00'),
(71, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EA8C9501', 'ACER TOUCHER', '2025-08-12 00:00:00'),
(72, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EC899501', 'ACER TOUCHER', '2025-08-12 00:00:00'),
(73, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EB459501', 'ACER TOUCHER', '2025-08-12 00:00:00'),
(74, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EDA99501', 'ACER TOUCHER', '2025-08-12 00:00:00'),
(75, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189E6A49501', 'ACER TOUCHER', '2025-08-13 00:00:00'),
(76, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EE809501', 'ACER TOUCHER', '2025-08-13 00:00:00'),
(77, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EDA39501', 'ACER TOUCHER', '2025-08-13 00:00:00'),
(78, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EB149501', 'ACER TOUCHER', '2025-08-13 00:00:00'),
(79, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189ECFE9501', 'ACER TOUCHER', '2025-08-13 00:00:00'),
(80, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EDA0901', 'ACER TOUCHER', '2025-08-13 00:00:00'),
(81, 'CHROMEBOOK 511 ACER S/N NXKEQAL0014189EDA09501', 'ACER TOUCHER', '2025-08-13 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `formacoes`
--

CREATE TABLE `formacoes` (
  `id_formacao` int NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `nome_formacao` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `id_unidade` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `documento_frequencia` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `fotos` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

-- --------------------------------------------------------

--
-- Estrutura para tabela `log_sistema`
--

CREATE TABLE `log_sistema` (
  `id` int NOT NULL,
  `tabela_afetada` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `acao` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `usuario` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `data_hora` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Despejando dados para a tabela `log_sistema`
--

INSERT INTO `log_sistema` (`id`, `tabela_afetada`, `acao`, `usuario`, `data_hora`) VALUES
(1, 'Unidade_Escolar', 'INSERT', 'cassia', '2025-03-13 19:18:27');

-- --------------------------------------------------------

--
-- Estrutura para tabela `unidade_equipamentos`
--

CREATE TABLE `unidade_equipamentos` (
  `id_registro` int NOT NULL,
  `id_unidade` int DEFAULT NULL,
  `id_equipamento` int DEFAULT NULL,
  `quantidade` int DEFAULT NULL,
  `ultima_atualizacao` datetime DEFAULT CURRENT_TIMESTAMP,
  `serie` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `patrimonio` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Despejando dados para a tabela `unidade_equipamentos`
--

INSERT INTO `unidade_equipamentos` (`id_registro`, `id_unidade`, `id_equipamento`, `quantidade`, `ultima_atualizacao`, `serie`, `patrimonio`) VALUES
(1, 2, 2, 1, '2025-03-10 09:24:21', NULL, NULL),
(2, 20, 27, 1, '2025-03-13 22:01:37', NULL, NULL),
(3, 20, 9, 1, '2025-03-13 22:03:16', NULL, NULL),
(4, 20, 5, 1, '2025-03-13 22:03:41', NULL, NULL),
(5, 20, 7, 1, '2025-03-13 22:03:55', NULL, NULL),
(6, 20, 10, 1, '2025-03-13 22:06:38', NULL, NULL),
(7, 20, 1, 1, '2025-03-18 15:51:08', '5548EW', '12WW'),
(8, 20, 11, 1, '2025-03-18 15:52:07', NULL, NULL),
(9, 20, 12, 2, '2025-03-18 15:52:21', NULL, NULL),
(10, 20, 41, 1, '2025-03-18 15:54:24', NULL, NULL),
(11, 20, 14, 1, '2025-03-18 15:54:43', NULL, NULL),
(12, 20, 16, 4, '2025-03-18 15:55:05', NULL, NULL),
(13, 20, 17, 1, '2025-03-18 15:55:26', NULL, NULL),
(14, 20, 20, 1, '2025-03-18 15:55:40', NULL, NULL),
(15, 20, 21, 2, '2025-03-18 15:56:08', NULL, NULL),
(16, 20, 23, 2, '2025-03-18 15:56:32', NULL, NULL),
(17, 20, 24, 1, '2025-03-18 15:56:44', NULL, NULL),
(18, 20, 40, 1, '2025-03-18 15:58:08', NULL, NULL),
(19, 20, 4, 1, '2025-03-18 15:58:28', NULL, NULL),
(20, 20, 42, 1, '2025-03-18 15:59:22', NULL, NULL),
(21, 20, 43, 1, '2025-03-18 16:01:38', NULL, NULL),
(22, 20, 19, 1, '2025-03-18 16:02:01', NULL, NULL),
(23, 20, 18, 1, '2025-03-18 16:02:10', NULL, NULL),
(24, 20, 29, 1, '2025-03-18 16:03:57', '10101QQ', '155EEWWS'),
(25, 27, 1, 1, '2025-03-18 16:08:16', '1', '1'),
(26, 27, 35, 1, '2025-03-18 16:09:54', NULL, NULL),
(27, 27, 4, 1, '2025-03-20 14:19:28', '1', '1'),
(28, 35, 1, 1, '2025-03-24 12:33:14', 'PX026011', '1230079'),
(29, 21, 1, 1, '2025-03-24 17:17:07', 'PX030701', '1230165'),
(30, 20, 1, 1, '2025-03-24 21:21:22', '123445', '122333'),
(31, 35, 1, 1, '2025-03-25 14:42:50', 'PX026014', '1230058'),
(32, 35, 1, 1, '2025-03-25 14:55:41', 'PX030553', '1230078'),
(33, 35, 1, 1, '2025-03-25 15:39:11', 'PX026007', '1230105'),
(34, 21, 1, 1, '2025-03-25 15:59:56', 'PX025916', '1230132'),
(35, 18, 1, 1, '2025-03-25 16:14:00', 'PX026057', '1230135'),
(36, 21, 1, 1, '2025-03-25 16:44:24', 'PX025928', '1230071'),
(37, 21, 1, 1, '2025-03-25 16:54:28', 'PX053384', '1230091'),
(38, 12, 1, 1, '2025-03-26 11:07:02', 'PX025926', '1230130'),
(39, 12, 1, 1, '2025-03-26 11:07:28', 'PX026080', '1230109'),
(40, 12, 1, 1, '2025-03-26 11:08:02', 'PX025657', '1230024'),
(41, 12, 2, 1, '2025-03-26 11:08:36', 'PX025907', '1230155'),
(42, 12, 1, 1, '2025-03-26 11:09:04', 'PX053510', '1230119'),
(43, 6, 26, 1, '2025-04-22 15:36:09', '00', '000'),
(44, 6, 8, 1, '2025-04-22 15:38:26', '0101', '0101'),
(45, 6, 3, 1, '2025-04-22 15:39:20', '010203', '010203'),
(46, 6, 5, 1, '2025-04-22 15:40:02', '0102', '0102'),
(47, 6, 7, 1, '2025-04-22 15:40:28', '01020304', '01020304'),
(48, 6, 11, 7, '2025-04-22 15:42:27', '0102030405', '0102030405'),
(49, 6, 12, 8, '2025-04-22 15:43:25', '010203040506', '010203040506'),
(50, 6, 41, 6, '2025-04-22 15:44:51', '010207', '010207'),
(51, 6, 14, 1, '2025-04-22 15:46:24', '010809', '010809'),
(52, 6, 15, 1, '2025-04-22 15:48:17', '010403', '010403'),
(53, 6, 17, 1, '2025-04-22 15:49:14', '030201', '030201'),
(54, 6, 20, 1, '2025-04-22 16:11:38', '0504030201', '0504030201'),
(55, 6, 22, 1, '2025-04-22 16:12:04', '01040203', '01040203'),
(56, 6, 52, 1, '2025-04-22 16:17:13', '020506', '020506'),
(57, 6, 23, 1, '2025-04-22 16:21:25', '060305', '060305'),
(58, 6, 24, 1, '2025-04-22 16:22:10', '070501', '070501'),
(59, 6, 4, 1, '2025-04-22 16:23:14', 'ZX', '01'),
(60, 6, 42, 1, '2025-04-22 16:24:08', 'CV', '02'),
(61, 6, 18, 1, '2025-04-22 16:25:14', 'BN', '03'),
(62, 6, 19, 1, '2025-04-22 16:25:47', 'ML', '04'),
(63, 6, 43, 1, '2025-04-22 16:27:10', 'QA', '05'),
(64, 6, 13, 1, '2025-04-22 16:28:22', 'DF', '06'),
(65, 6, 29, 1, '2025-04-22 16:30:24', 'LE075MDDGB005BBBK30025', '01000'),
(66, 13, 20, 1, '2025-04-22 16:43:13', 'HJ', '010101'),
(67, 13, 6, 1, '2025-04-22 16:50:18', 'LK', '03000'),
(68, 13, 3, 1, '2025-04-22 16:51:15', 'GR', '0006'),
(69, 11, 31, 1, '2025-05-07 11:07:50', '11008128', 'E1P'),
(70, 11, 34, 1, '2025-05-07 11:18:41', '112229391014001750', '0123'),
(71, 11, 25, 1, '2025-05-07 11:19:28', 'XBF22X01141', '01234'),
(72, 11, 28, 1, '2025-05-07 11:20:54', 'BP24173119 WD24175267 241175267', '45612'),
(73, 30, 31, 1, '2025-05-07 11:32:50', '11008089', '952'),
(74, 30, 34, 1, '2025-05-07 11:33:38', '112229391014000439', '753'),
(75, 30, 25, 1, '2025-05-07 11:34:14', 'XBF22X03927', '9512'),
(76, 30, 28, 1, '2025-05-07 11:36:04', 'BP24172333 WD24172945 24172945', '845'),
(77, 32, 31, 1, '2025-05-07 12:08:56', '11008170 ', '495'),
(78, 32, 34, 1, '2025-05-07 12:13:52', '112229391014000430', '4973'),
(79, 32, 25, 1, '2025-05-07 12:15:49', 'BP24172386 WD24172966 24172966', '3678'),
(80, 31, 31, 1, '2025-05-07 12:23:17', '11008184', '84637'),
(81, 31, 34, 1, '2025-05-07 12:24:01', '112229391014001749', '6579'),
(82, 31, 25, 1, '2025-05-07 12:25:02', 'XBF22X03960', '467913'),
(83, 31, 28, 1, '2025-05-07 12:25:51', 'BP24172336 WD24174810 24174810', '0249763'),
(84, 15, 31, 1, '2025-05-07 16:12:24', '11008086', '6734'),
(85, 15, 34, 1, '2025-05-07 16:14:27', '112229391014001397', '786453'),
(86, 15, 25, 1, '2025-05-07 16:18:42', 'XBF22X03923', '2793'),
(87, 15, 28, 1, '2025-05-07 16:19:54', 'BP24172687 WD24171095 24171095', '46379'),
(88, 4, 31, 1, '2025-05-09 12:32:52', '11007580', '16495'),
(89, 4, 34, 1, '2025-05-09 12:35:11', '112229391014001746', '67493'),
(90, 4, 25, 1, '2025-05-09 12:35:43', 'XBF22X0397', '46972'),
(91, 4, 28, 1, '2025-05-09 12:36:20', 'BP24173133 WD24171115 24175479', '956483'),
(92, 4, 12, 1, '2025-05-09 12:41:24', '00000000000000000000000', '0000000000000000000000000'),
(93, 4, 41, 1, '2025-05-09 12:41:55', '00000000000000', '0000000000'),
(94, 4, 17, 1, '2025-05-09 12:42:16', '001000000000000', '0000000000000200'),
(95, 4, 16, 2, '2025-05-09 12:43:02', '300000000000', '300000000'),
(96, 4, 42, 1, '2025-05-09 12:43:41', '00000100', '00000100'),
(97, 4, 40, 1, '2025-05-09 12:45:03', '00200003', '00200003'),
(98, 4, 52, 1, '2025-05-09 12:46:43', '0000003', '00003'),
(99, 4, 54, 1, '2025-05-09 12:47:20', '030200', '030200'),
(100, 20, 1, 1, '2025-06-03 16:34:02', 'PX053517', '1230073'),
(101, 20, 1, 1, '2025-06-03 16:34:59', 'PX030816', '1230158'),
(102, 20, 1, 1, '2025-06-03 16:35:44', 'PX025939', '1230120'),
(103, 20, 1, 1, '2025-06-03 16:36:37', 'PX026118', '1230059'),
(104, 20, 1, 1, '2025-06-03 16:37:22', 'PX053199', '0000000'),
(105, 20, 1, 1, '2025-06-03 16:38:49', 'PX030852', '1230026'),
(106, 20, 1, 1, '2025-06-03 16:39:45', 'PX025938', '1230072'),
(107, 20, 1, 1, '2025-06-03 16:42:05', 'PX025964', '1230097'),
(108, 20, 1, 1, '2025-06-03 16:42:40', 'PX0255949', '00000'),
(109, 20, 1, 1, '2025-06-03 16:43:14', 'PX030555', '1230140'),
(110, 20, 1, 1, '2025-06-03 16:44:03', 'PX029554', '1230108'),
(111, 20, 1, 1, '2025-06-03 16:44:57', 'PX030825', '1230062'),
(112, 7, 81, 1, '2025-08-13 09:53:00', 'EDA09501', '001'),
(113, 7, 79, 1, '2025-08-13 09:53:36', 'ECFE9501', '002'),
(114, 7, 78, 1, '2025-08-13 09:54:09', 'EB149501', '003'),
(115, 7, 77, 1, '2025-08-13 09:54:46', 'EDA39501', '004'),
(116, 7, 76, 1, '2025-08-13 09:55:44', 'EE809501', '005'),
(117, 7, 75, 1, '2025-08-13 09:56:33', 'E6A49501', '006'),
(118, 7, 72, 1, '2025-08-13 10:00:37', 'EC889501', '007'),
(119, 7, 74, 1, '2025-08-13 10:04:59', 'EDA99501', '008'),
(120, 7, 73, 1, '2025-08-13 10:06:40', 'EB459501', '009'),
(121, 7, 71, 1, '2025-08-13 10:07:36', 'EA8C9501', '010'),
(122, 7, 70, 1, '2025-08-13 10:09:17', 'EE7A9501', '011'),
(123, 7, 72, 1, '2025-08-13 10:16:07', 'EC899501', '012'),
(124, 25, 55, 1, '2025-08-13 10:19:26', 'EE859501', '013'),
(125, 25, 56, 1, '2025-08-13 10:24:36', 'EE709501', '014'),
(126, 25, 57, 1, '2025-08-13 10:26:17', 'EE7C9501', '015'),
(127, 25, 58, 1, '2025-08-13 10:40:28', 'EE7D9501', '016'),
(128, 25, 59, 1, '2025-08-13 10:51:49', 'ECA6901', '017'),
(129, 25, 60, 1, '2025-08-13 17:13:35', 'ECD8901', '018'),
(130, 25, 61, 1, '2025-08-13 17:14:34', 'ED809501', '019'),
(131, 25, 62, 1, '2025-08-13 17:15:32', 'ED729501', '020'),
(132, 25, 64, 1, '2025-08-13 17:16:21', 'EB659501', '021'),
(133, 25, 65, 1, '2025-08-13 17:17:11', 'EEA49501', '022'),
(134, 25, 66, 1, '2025-08-13 17:17:53', 'EDC39501', '023'),
(135, 25, 67, 1, '2025-08-13 17:19:33', 'ED959501', '024'),
(136, 25, 68, 1, '2025-08-13 17:20:16', 'E92C9501', '025'),
(137, 25, 69, 1, '2025-08-13 17:22:26', 'EAFD9501', '026');

-- --------------------------------------------------------

--
-- Estrutura para tabela `unidade_escolar`
--

CREATE TABLE `unidade_escolar` (
  `id_unidade` int NOT NULL,
  `nome_escola` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `habilita` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica se a unidade tem Sala Google (0 = Não, 1 = Sim)',
  `outros` tinyint(1) DEFAULT '0',
  `independentes` tinyint(1) DEFAULT NULL,
  `portatil` tinyint(1) DEFAULT NULL,
  `lcd` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Despejando dados para a tabela `unidade_escolar`
--

INSERT INTO `unidade_escolar` (`id_unidade`, `nome_escola`, `habilita`, `outros`, `independentes`, `portatil`, `lcd`) VALUES
(1, 'EMEF Assis Chateaubriand POLO 02', 0, 1, 0, 0, 0),
(2, 'EMEF Airton Ciraulo POLO 01', 0, 0, 0, 1, 0),
(3, 'EMEF Berenice Ribeiro POLO 01', 0, 1, 0, 0, 0),
(4, 'EMEF Jaime Caetano POLO 01', 0, 0, 0, 1, 0),
(5, 'Creche Lar Luz e Vida POLO 02', 0, 0, 0, 1, 0),
(6, 'EMEF Senador Ruy Carneiro POLO 01', 1, 0, 0, 0, 0),
(7, 'EMEF Joaquim Lafayette POLO 01', 0, 0, 0, 0, 1),
(8, 'EMEF Dom Helder Câmara POLO 02', 0, 0, 0, 1, 0),
(9, 'EMEF Rita Alves POLO 02', 0, 0, 0, 0, 0),
(10, 'EMEF Otilio Ciraulo POLO 02', 0, 0, 0, 0, 0),
(11, 'Creche Alice Suassuna POLO 01', 0, 0, 0, 1, 0),
(12, 'EMEF Edgard Seager POLO 02', 0, 0, 0, 0, 1),
(13, 'EMEF Tancredo de Almeida Neves POLO 02', 0, 1, 0, 0, 0),
(14, 'Creche Nossa Senhora da Aparecida POLO 03', 0, 0, 0, 1, 0),
(15, 'Creche Nossa Senhora da Conceição POLO 03', 0, 0, 0, 1, 0),
(16, 'EMEF Flávio Ribeiro Coutinho POLO 03', 0, 0, 0, 0, 0),
(17, 'EMEF Maria das Neves Lins POLO 03', 0, 0, 0, 0, 0),
(18, 'EMEF Petrônio Figueiredo POLO 03', 1, 0, 0, 0, 0),
(19, 'EMEF Pascoal Massilio POLO 03', 0, 0, 0, 0, 0),
(20, 'EMEF Fernando Cunha Lima POLO 03', 1, 0, 0, 0, 0),
(21, 'EMEF Luciano Ribeiro de Morais POLO 04', 0, 1, 0, 0, 0),
(22, 'EMEF Vereador João Belmiro dos Santos POLO 04', 1, 0, 0, 0, 0),
(23, 'Creche Vô Genesia POLO 04', 0, 0, 0, 1, 0),
(24, 'EMEF Sandra Maria Carneiro de Souza POLO 04', 0, 0, 0, 0, 0),
(25, 'EMEF Moacir Dantas POLO 04', 0, 1, 0, 0, 0),
(26, 'EMEF Maria do Carmo da Silveira Lima POLO 05', 0, 1, 0, 0, 0),
(27, 'EMEF Joana Fortunato de Sousa POLO 05', 1, 0, 0, 0, 0),
(28, 'EMEF João Jacinto Dantas POLO 05', 0, 0, 0, 0, 0),
(29, 'EMEF Maria José Pinto de Lima POLO 05', 0, 0, 0, 0, 0),
(30, 'Creche Clotilde Catão POLO 05', 0, 0, 0, 1, 0),
(31, 'Creche Mãe Manda POLO 05', 0, 0, 0, 1, 0),
(32, 'Creche Cristiano Martins POLO 04', 0, 0, 0, 1, 0),
(33, 'EMEF Jaide Rodrigues Menezes POLO 05', 0, 0, 0, 0, 0),
(34, 'EMEF João Fernandes de Lima POLO 02', 0, 0, 0, 0, 0),
(35, 'EMEF José Ribeiro de Morais POLO 01', 0, 1, 0, 0, 0),
(36, 'EMEF Francisco Joaquim de Brito POLO 04', 0, 0, 0, 0, 0),
(37, 'Telecentro', 0, 0, 1, 0, 0),
(38, 'SME', 0, 0, 1, 0, 0),
(39, 'CRIS', 0, 0, 1, 0, 0),
(40, 'Conselho de educação', 0, 0, 0, 0, 0),
(41, 'Creche Solar Joana D\'Angelis POLO 05', 0, 0, 0, 1, 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `visitas`
--

CREATE TABLE `visitas` (
  `id_visita` int NOT NULL,
  `id_unidade` int NOT NULL,
  `data_visita` date NOT NULL,
  `descricao` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `anexo` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `equipamentos`
--
ALTER TABLE `equipamentos`
  ADD PRIMARY KEY (`id_equipamento`);

--
-- Índices de tabela `formacoes`
--
ALTER TABLE `formacoes`
  ADD PRIMARY KEY (`id_formacao`),
  ADD KEY `id_unidade` (`id_unidade`);

--
-- Índices de tabela `log_sistema`
--
ALTER TABLE `log_sistema`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `unidade_equipamentos`
--
ALTER TABLE `unidade_equipamentos`
  ADD PRIMARY KEY (`id_registro`),
  ADD KEY `id_unidade` (`id_unidade`),
  ADD KEY `id_equipamento` (`id_equipamento`);

--
-- Índices de tabela `unidade_escolar`
--
ALTER TABLE `unidade_escolar`
  ADD PRIMARY KEY (`id_unidade`);

--
-- Índices de tabela `visitas`
--
ALTER TABLE `visitas`
  ADD PRIMARY KEY (`id_visita`),
  ADD KEY `id_unidade` (`id_unidade`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `equipamentos`
--
ALTER TABLE `equipamentos`
  MODIFY `id_equipamento` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT de tabela `formacoes`
--
ALTER TABLE `formacoes`
  MODIFY `id_formacao` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `log_sistema`
--
ALTER TABLE `log_sistema`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `unidade_equipamentos`
--
ALTER TABLE `unidade_equipamentos`
  MODIFY `id_registro` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=138;

--
-- AUTO_INCREMENT de tabela `unidade_escolar`
--
ALTER TABLE `unidade_escolar`
  MODIFY `id_unidade` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT de tabela `visitas`
--
ALTER TABLE `visitas`
  MODIFY `id_visita` int NOT NULL AUTO_INCREMENT;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `formacoes`
--
ALTER TABLE `formacoes`
  ADD CONSTRAINT `formacoes_ibfk_1` FOREIGN KEY (`id_unidade`) REFERENCES `unidade_escolar` (`id_unidade`) ON DELETE RESTRICT;

--
-- Restrições para tabelas `unidade_equipamentos`
--
ALTER TABLE `unidade_equipamentos`
  ADD CONSTRAINT `unidade_equipamentos_ibfk_1` FOREIGN KEY (`id_unidade`) REFERENCES `unidade_escolar` (`id_unidade`),
  ADD CONSTRAINT `unidade_equipamentos_ibfk_2` FOREIGN KEY (`id_equipamento`) REFERENCES `equipamentos` (`id_equipamento`);

--
-- Restrições para tabelas `visitas`
--
ALTER TABLE `visitas`
  ADD CONSTRAINT `visitas_ibfk_1` FOREIGN KEY (`id_unidade`) REFERENCES `unidade_escolar` (`id_unidade`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
