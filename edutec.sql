-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Tempo de geração: 12/08/2025 às 11:42
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
  `nome_equipamento` varchar(100) DEFAULT NULL,
  `descricao` text,
  `data_cadastro` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(54, 'PUFF QUADRADO VERDE ', '45CM', '2025-05-09 00:00:00');

-- --------------------------------------------------------

--
-- Estrutura para tabela `formacoes`
--

CREATE TABLE `formacoes` (
  `id_formacao` int NOT NULL,
  `data_inicio` date NOT NULL,
  `data_fim` date NOT NULL,
  `nome_formacao` varchar(255) NOT NULL,
  `descricao` text,
  `id_unidade` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `documento_frequencia` varchar(255) DEFAULT NULL,
  `fotos` text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `log_sistema`
--

CREATE TABLE `log_sistema` (
  `id` int NOT NULL,
  `tabela_afetada` varchar(50) NOT NULL,
  `acao` varchar(10) NOT NULL,
  `usuario` varchar(50) NOT NULL,
  `data_hora` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `log_sistema`
--

INSERT INTO `log_sistema` (`id`, `tabela_afetada`, `acao`, `usuario`, `data_hora`) VALUES
(1, 'Unidade_Escolar', 'INSERT', 'cassia', '2025-03-13 19:18:27');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__bookmark`
--

CREATE TABLE `pma__bookmark` (
  `id` int UNSIGNED NOT NULL,
  `dbase` varchar(255) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `user` varchar(255) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `label` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '',
  `query` text COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='Bookmarks';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__central_columns`
--

CREATE TABLE `pma__central_columns` (
  `db_name` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `col_name` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `col_type` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `col_length` text COLLATE utf8mb3_bin,
  `col_collation` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `col_isNull` tinyint(1) NOT NULL,
  `col_extra` varchar(255) COLLATE utf8mb3_bin DEFAULT '',
  `col_default` text COLLATE utf8mb3_bin
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='Central list of columns';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__column_info`
--

CREATE TABLE `pma__column_info` (
  `id` int UNSIGNED NOT NULL,
  `db_name` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `column_name` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `comment` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '',
  `mimetype` varchar(255) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT '',
  `transformation` varchar(255) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `transformation_options` varchar(255) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `input_transformation` varchar(255) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `input_transformation_options` varchar(255) COLLATE utf8mb3_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='Column information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__designer_settings`
--

CREATE TABLE `pma__designer_settings` (
  `username` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `settings_data` text COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='Settings related to Designer';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__export_templates`
--

CREATE TABLE `pma__export_templates` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `export_type` varchar(10) COLLATE utf8mb3_bin NOT NULL,
  `template_name` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `template_data` text COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='Saved export templates';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__favorite`
--

CREATE TABLE `pma__favorite` (
  `username` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `tables` text COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='Favorite tables';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__history`
--

CREATE TABLE `pma__history` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `db` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `table` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sqlquery` text COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='SQL history for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__navigationhiding`
--

CREATE TABLE `pma__navigationhiding` (
  `username` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `item_name` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `item_type` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='Hidden items of navigation tree';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__pdf_pages`
--

CREATE TABLE `pma__pdf_pages` (
  `db_name` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `page_nr` int UNSIGNED NOT NULL,
  `page_descr` varchar(50) CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='PDF relation pages for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__recent`
--

CREATE TABLE `pma__recent` (
  `username` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `tables` text COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='Recently accessed tables';

--
-- Despejando dados para a tabela `pma__recent`
--

INSERT INTO `pma__recent` (`username`, `tables`) VALUES
('root', '[{\"db\":\"rh\",\"table\":\"usuario\"},{\"db\":\"rh\",\"table\":\"log\"},{\"db\":\"rh\",\"table\":\"frequencia\"}]');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__relation`
--

CREATE TABLE `pma__relation` (
  `master_db` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `master_table` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `master_field` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `foreign_db` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `foreign_table` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `foreign_field` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='Relation table';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__savedsearches`
--

CREATE TABLE `pma__savedsearches` (
  `id` int UNSIGNED NOT NULL,
  `username` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `db_name` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `search_name` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `search_data` text COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='Saved searches';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__table_coords`
--

CREATE TABLE `pma__table_coords` (
  `db_name` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `pdf_page_number` int NOT NULL DEFAULT '0',
  `x` float UNSIGNED NOT NULL DEFAULT '0',
  `y` float UNSIGNED NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='Table coordinates for phpMyAdmin PDF output';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__table_info`
--

CREATE TABLE `pma__table_info` (
  `db_name` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `table_name` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT '',
  `display_field` varchar(64) COLLATE utf8mb3_bin NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='Table information for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__table_uiprefs`
--

CREATE TABLE `pma__table_uiprefs` (
  `username` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `db_name` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `prefs` text COLLATE utf8mb3_bin NOT NULL,
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='Tables'' UI preferences';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__tracking`
--

CREATE TABLE `pma__tracking` (
  `db_name` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `table_name` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `version` int UNSIGNED NOT NULL,
  `date_created` datetime NOT NULL,
  `date_updated` datetime NOT NULL,
  `schema_snapshot` text COLLATE utf8mb3_bin NOT NULL,
  `schema_sql` text COLLATE utf8mb3_bin,
  `data_sql` longtext COLLATE utf8mb3_bin,
  `tracking` set('UPDATE','REPLACE','INSERT','DELETE','TRUNCATE','CREATE DATABASE','ALTER DATABASE','DROP DATABASE','CREATE TABLE','ALTER TABLE','RENAME TABLE','DROP TABLE','CREATE INDEX','DROP INDEX','CREATE VIEW','ALTER VIEW','DROP VIEW') COLLATE utf8mb3_bin DEFAULT NULL,
  `tracking_active` int UNSIGNED NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='Database changes tracking for phpMyAdmin';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__userconfig`
--

CREATE TABLE `pma__userconfig` (
  `username` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `timevalue` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `config_data` text COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='User preferences storage for phpMyAdmin';

--
-- Despejando dados para a tabela `pma__userconfig`
--

INSERT INTO `pma__userconfig` (`username`, `timevalue`, `config_data`) VALUES
('root', '2025-07-05 19:11:24', '{\"Console\\/Mode\":\"collapse\",\"lang\":\"pt_BR\"}');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__usergroups`
--

CREATE TABLE `pma__usergroups` (
  `usergroup` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `tab` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `allowed` enum('Y','N') COLLATE utf8mb3_bin NOT NULL DEFAULT 'N'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='User groups with configured menu items';

-- --------------------------------------------------------

--
-- Estrutura para tabela `pma__users`
--

CREATE TABLE `pma__users` (
  `username` varchar(64) COLLATE utf8mb3_bin NOT NULL,
  `usergroup` varchar(64) COLLATE utf8mb3_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_bin COMMENT='Users and their assignments to user groups';

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(111, 20, 1, 1, '2025-06-03 16:44:57', 'PX030825', '1230062');

-- --------------------------------------------------------

--
-- Estrutura para tabela `unidade_escolar`
--

CREATE TABLE `unidade_escolar` (
  `id_unidade` int NOT NULL,
  `nome_escola` varchar(255) DEFAULT NULL,
  `habilita` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indica se a unidade tem Sala Google (0 = Não, 1 = Sim)',
  `outros` tinyint(1) DEFAULT '0',
  `independentes` tinyint(1) DEFAULT NULL,
  `portatil` tinyint(1) DEFAULT NULL,
  `lcd` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(25, 'EMEF Moacir Dantas POLO 04', 0, 0, 0, 0, 0),
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
-- Índices de tabela `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  ADD PRIMARY KEY (`id`);

--
-- Índices de tabela `pma__central_columns`
--
ALTER TABLE `pma__central_columns`
  ADD PRIMARY KEY (`db_name`,`col_name`);

--
-- Índices de tabela `pma__column_info`
--
ALTER TABLE `pma__column_info`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `db_name` (`db_name`,`table_name`,`column_name`);

--
-- Índices de tabela `pma__designer_settings`
--
ALTER TABLE `pma__designer_settings`
  ADD PRIMARY KEY (`username`);

--
-- Índices de tabela `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_user_type_template` (`username`,`export_type`,`template_name`);

--
-- Índices de tabela `pma__favorite`
--
ALTER TABLE `pma__favorite`
  ADD PRIMARY KEY (`username`);

--
-- Índices de tabela `pma__history`
--
ALTER TABLE `pma__history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `username` (`username`,`db`,`table`,`timevalue`);

--
-- Índices de tabela `pma__navigationhiding`
--
ALTER TABLE `pma__navigationhiding`
  ADD PRIMARY KEY (`username`,`item_name`,`item_type`,`db_name`,`table_name`);

--
-- Índices de tabela `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  ADD PRIMARY KEY (`page_nr`),
  ADD KEY `db_name` (`db_name`);

--
-- Índices de tabela `pma__recent`
--
ALTER TABLE `pma__recent`
  ADD PRIMARY KEY (`username`);

--
-- Índices de tabela `pma__relation`
--
ALTER TABLE `pma__relation`
  ADD PRIMARY KEY (`master_db`,`master_table`,`master_field`),
  ADD KEY `foreign_field` (`foreign_db`,`foreign_table`);

--
-- Índices de tabela `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `u_savedsearches_username_dbname` (`username`,`db_name`,`search_name`);

--
-- Índices de tabela `pma__table_coords`
--
ALTER TABLE `pma__table_coords`
  ADD PRIMARY KEY (`db_name`,`table_name`,`pdf_page_number`);

--
-- Índices de tabela `pma__table_info`
--
ALTER TABLE `pma__table_info`
  ADD PRIMARY KEY (`db_name`,`table_name`);

--
-- Índices de tabela `pma__table_uiprefs`
--
ALTER TABLE `pma__table_uiprefs`
  ADD PRIMARY KEY (`username`,`db_name`,`table_name`);

--
-- Índices de tabela `pma__tracking`
--
ALTER TABLE `pma__tracking`
  ADD PRIMARY KEY (`db_name`,`table_name`,`version`);

--
-- Índices de tabela `pma__userconfig`
--
ALTER TABLE `pma__userconfig`
  ADD PRIMARY KEY (`username`);

--
-- Índices de tabela `pma__usergroups`
--
ALTER TABLE `pma__usergroups`
  ADD PRIMARY KEY (`usergroup`,`tab`,`allowed`);

--
-- Índices de tabela `pma__users`
--
ALTER TABLE `pma__users`
  ADD PRIMARY KEY (`username`,`usergroup`);

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
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `equipamentos`
--
ALTER TABLE `equipamentos`
  MODIFY `id_equipamento` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

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
-- AUTO_INCREMENT de tabela `pma__bookmark`
--
ALTER TABLE `pma__bookmark`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pma__column_info`
--
ALTER TABLE `pma__column_info`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pma__export_templates`
--
ALTER TABLE `pma__export_templates`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pma__history`
--
ALTER TABLE `pma__history`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pma__pdf_pages`
--
ALTER TABLE `pma__pdf_pages`
  MODIFY `page_nr` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `pma__savedsearches`
--
ALTER TABLE `pma__savedsearches`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `unidade_equipamentos`
--
ALTER TABLE `unidade_equipamentos`
  MODIFY `id_registro` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=112;

--
-- AUTO_INCREMENT de tabela `unidade_escolar`
--
ALTER TABLE `unidade_escolar`
  MODIFY `id_unidade` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

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
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
