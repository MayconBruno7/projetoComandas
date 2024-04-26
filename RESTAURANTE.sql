-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 23-Nov-2023 às 18:55
-- Versão do servidor: 8.0.31
-- versão do PHP: 8.0.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `restaurante_povoado`
--

-- --------------------------------------------------------

--
-- Estrutura da tabela `comanda`
--

DROP TABLE IF EXISTS `comanda`;
CREATE TABLE IF NOT EXISTS `comanda` (
  `ID_COMANDA` int NOT NULL AUTO_INCREMENT,
  `SITUACAO_COMANDA` int NOT NULL DEFAULT '1' COMMENT '1 - ABERTO\r\n2 - PAGO\r\n3 - CANCELADO',
  `DESCRICAO_COMANDA` varchar(40) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT '',
  `DATA_ABERTURA` timestamp NOT NULL,
  `DATA_FECHAMENTO` timestamp NULL DEFAULT NULL,
  `MESA_ID_MESA` int DEFAULT NULL,
  PRIMARY KEY (`ID_COMANDA`),
  KEY `MESA_ID_MESA` (`MESA_ID_MESA`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `fin_comanda`
--

DROP TABLE IF EXISTS `fin_comanda`;
CREATE TABLE IF NOT EXISTS `fin_comanda` (
  `ID_FIN` int NOT NULL AUTO_INCREMENT,
  `COMANDA_ID_COMANDA` int DEFAULT NULL,
  `PAGAMENTO_ID_PAGAMENTO` int DEFAULT NULL,
  `VALOR_PAGAMENTO` int DEFAULT '0',
  PRIMARY KEY (`ID_FIN`),
  KEY `COMANDA_ID_COMANDA` (`COMANDA_ID_COMANDA`),
  KEY `PAGAMENTO_ID_PAGAMENTO` (`PAGAMENTO_ID_PAGAMENTO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `formas_pagamento`
--

DROP TABLE IF EXISTS `formas_pagamento`;
CREATE TABLE IF NOT EXISTS `formas_pagamento` (
  `ID_FORMA_PAGAMENTO` int NOT NULL AUTO_INCREMENT,
  `DESCRICAO_FORMA_PAGAMENTO` varchar(50) NOT NULL,
  `SITUACAO_FORMA_PAGAMENTO` int NOT NULL COMMENT '1 - ATIVO\r\n2 - INATIVO',
  PRIMARY KEY (`ID_FORMA_PAGAMENTO`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Extraindo dados da tabela `formas_pagamento`
--

INSERT INTO `formas_pagamento` (`ID_FORMA_PAGAMENTO`, `DESCRICAO_FORMA_PAGAMENTO`, `SITUACAO_FORMA_PAGAMENTO`) VALUES
(1, 'Dinheiro', 1),
(2, 'Cartão de Crédito', 1),
(3, 'Cartão de Débito', 1),
(4, 'Pix', 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `itens_comanda`
--

DROP TABLE IF EXISTS `itens_comanda`;
CREATE TABLE IF NOT EXISTS `itens_comanda` (
  `PRODUTOS_ID_PRODUTOS` int NOT NULL,
  `COMANDA_ID_COMANDA` int NOT NULL,
  `QUANTIDADE` int NOT NULL,
  `VALOR_ITEM` double NOT NULL,
  KEY `PRODUTOS_ID_PRODUTOS` (`PRODUTOS_ID_PRODUTOS`),
  KEY `COMANDA_ID_COMANDA` (`COMANDA_ID_COMANDA`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `mesas`
--

DROP TABLE IF EXISTS `mesas`;
CREATE TABLE IF NOT EXISTS `mesas` (
  `ID_MESA` int NOT NULL AUTO_INCREMENT,
  `DESCRICAO_MESA` longtext NOT NULL,
  `SITUACAO_MESA` int NOT NULL DEFAULT '1' COMMENT '1 - DISPONIVEL\r\n2 - INDISPONIVEL',
  `COMANDA_SITUACAO_COMANDA` int DEFAULT NULL,
  PRIMARY KEY (`ID_MESA`),
  KEY `FK1_COMANDA_SITUACAO_COMANDA` (`COMANDA_SITUACAO_COMANDA`) USING BTREE
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto`
--

DROP TABLE IF EXISTS `produto`;
CREATE TABLE IF NOT EXISTS `produto` (
  `ID_PRODUTOS` int NOT NULL AUTO_INCREMENT,
  `DESCRICAO` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `CARACTERISTICAS` longtext CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `QTD_ESTOQUE` decimal(14,3) NOT NULL,
  `CUSTO_TOTAL_ESTOQUE` decimal(14,2) NOT NULL,
  `STATUS_PRODUTO` int NOT NULL DEFAULT '1' COMMENT '1=Ativo; 2=Inativo',
  `IMAGEM` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci DEFAULT NULL,
  `ID_PRODUTO_CATEGORIA` int NOT NULL,
  `VALOR_UNITARIO` decimal(14,2) NOT NULL DEFAULT '0.00',
  `LOTE` varchar(30) NOT NULL DEFAULT '',
  `PRECO_FABRICA` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`ID_PRODUTOS`) USING BTREE,
  KEY `FK1_produto_produtocategoria_id` (`ID_PRODUTO_CATEGORIA`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produto`
--

INSERT INTO `produto` (`ID_PRODUTOS`, `DESCRICAO`, `CARACTERISTICAS`, `QTD_ESTOQUE`, `CUSTO_TOTAL_ESTOQUE`, `STATUS_PRODUTO`, `IMAGEM`, `ID_PRODUTO_CATEGORIA`, `VALOR_UNITARIO`, `LOTE`, `PRECO_FABRICA`) VALUES
(1, 'APEROL SPRIZ', '', '39.000', '0.00', 1, NULL, 1, '29.00', '', 0),
(2, 'BASIL SMASH', '', '91.000', '0.00', 1, NULL, 1, '29.00', '', 0),
(3, 'BLOOD VAMP', '', '78.000', '0.00', 1, NULL, 1, '26.90', '', 0),
(4, 'BOSSA NOVA', '', '42.000', '0.00', 1, NULL, 1, '24.90', '', 0),
(5, 'CAIP FRUTA', '', '134.000', '0.00', 1, NULL, 1, '18.00', '', 0),
(6, 'CLERICOT', '', '43.000', '0.00', 1, NULL, 1, '29.00', '', 0),
(7, 'COSMOPOLITAN', '', '93.000', '0.00', 1, NULL, 1, '22.00', '', 0),
(8, 'DAIQUIRI', '', '44.000', '0.00', 1, NULL, 1, '20.00', '', 0),
(9, 'ELETRO MUSIC', '', '53.000', '0.00', 1, NULL, 1, '24.90', '', 0),
(10, 'ESPECIAL', '', '64.000', '0.00', 1, NULL, 1, '27.00', '', 0),
(11, 'FROZEN CREMOSO', '', '146.000', '0.00', 1, NULL, 1, '28.00', '', 0),
(12, 'GIN TONICA', '', '42.000', '0.00', 1, NULL, 1, '28.00', '', 0),
(13, 'GIN TROPICAL', '', '68.000', '0.00', 1, NULL, 1, '33.00', '', 0),
(14, 'JUX X', '', '156.000', '0.00', 1, NULL, 1, '18.00', '', 0),
(15, 'LIMONCELLO SPRITZ', '', '43.000', '0.00', 1, NULL, 1, '29.00', '', 0),
(16, 'MANSAO TIKKI', '', '36.000', '0.00', 1, NULL, 1, '25.00', '', 0),
(17, 'MARACUJACK', '', '144.000', '0.00', 1, NULL, 1, '34.00', '', 0),
(18, 'MARGARITA', '', '117.000', '0.00', 1, NULL, 1, '25.00', '', 0),
(19, 'MICHELADA', '', '32.000', '0.00', 1, NULL, 1, '16.00', '', 0),
(20, 'MOJITO', '', '101.000', '0.00', 1, NULL, 1, '20.00', '', 0),
(21, 'MOSCOW MULE', '', '37.000', '0.00', 1, NULL, 1, '25.00', '', 0),
(22, 'NEGRONI', '', '67.000', '0.00', 1, NULL, 1, '34.00', '', 0),
(23, 'PAGODE', '', '103.000', '0.00', 1, NULL, 1, '24.90', '', 0),
(24, 'PINA COLADA', '', '86.000', '0.00', 1, NULL, 1, '22.00', '', 0),
(25, 'PUMPKIN CRAZY', '', '94.000', '0.00', 1, NULL, 1, '26.90', '', 0),
(26, 'RED FRUITS', '', '137.000', '0.00', 1, NULL, 1, '31.00', '', 0),
(27, 'ROCK NIGHT', '', '102.000', '0.00', 1, NULL, 1, '24.90', '', 0),
(28, 'SEX ON THE BEACH', '', '83.000', '0.00', 1, NULL, 1, '20.00', '', 0),
(29, 'STRAWBERRY FIELDS', '', '127.000', '0.00', 1, NULL, 1, '24.00', '', 0),
(30, 'VANILLA BERRY', '', '154.000', '0.00', 1, NULL, 1, '18.00', '', 0),
(31, 'PETIT GATEAU', '', '83.000', '0.00', 1, NULL, 2, '24.00', '', 0),
(32, 'SORVETE', '', '77.000', '0.00', 1, NULL, 2, '14.00', '', 0),
(33, 'TORTA BANOFFE', '', '41.000', '0.00', 1, NULL, 2, '19.00', '', 0),
(34, 'AGUA COM GAS', '', '137.000', '0.00', 1, NULL, 3, '5.00', '', 0),
(35, 'AGUA SEM GAS', '', '153.000', '0.00', 1, NULL, 3, '4.00', '', 0),
(36, 'AGUA TONICA', '', '154.000', '0.00', 1, NULL, 3, '7.00', '', 0),
(37, 'AGUA TONICA ZERO', '', '40.000', '0.00', 1, NULL, 3, '7.00', '', 0),
(38, 'COCA COLA', '', '144.000', '0.00', 1, NULL, 3, '7.00', '', 0),
(39, 'COCA COLA ZERO', '', '64.000', '0.00', 1, NULL, 3, '7.00', '', 0),
(40, 'FANTA LARANJA', '', '66.000', '0.00', 1, NULL, 3, '7.00', '', 0),
(41, 'GUARANA ANTARTICA', '', '78.000', '0.00', 1, NULL, 3, '7.00', '', 0),
(42, 'H20 LIMAO', '', '59.000', '0.00', 1, NULL, 3, '8.00', '', 0),
(43, 'RED BULL ', '', '64.000', '0.00', 1, NULL, 3, '16.00', '', 0),
(44, 'RED BULL TROPICAL', '', '139.000', '0.00', 1, NULL, 3, '16.00', '', 0),
(45, 'SCHWEPPES ', '', '136.000', '0.00', 1, NULL, 3, '6.90', '', 0),
(46, 'SUCO DEL VALE', '', '108.000', '0.00', 1, NULL, 3, '9.00', '', 0),
(47, 'TNT', '', '48.000', '0.00', 1, NULL, 3, '12.00', '', 0),
(48, 'ABACAXI', '', '110.000', '0.00', 1, NULL, 4, '9.00', '', 0),
(49, 'ABACAXI COM HORTELA', '', '75.000', '0.00', 1, NULL, 4, '9.00', '', 0),
(50, 'ACEROLA', '', '64.000', '0.00', 1, NULL, 4, '9.00', '', 0),
(51, 'GRAVIOLA', '', '83.000', '0.00', 1, NULL, 4, '9.00', '', 0),
(52, 'LARANJA', '', '81.000', '0.00', 1, NULL, 4, '9.00', '', 0),
(53, 'LIMAO', '', '80.000', '0.00', 1, NULL, 4, '9.00', '', 0),
(54, 'MARACUJA', '', '100.000', '0.00', 1, NULL, 4, '9.00', '', 0),
(55, 'MORANGO', '', '43.000', '0.00', 1, NULL, 4, '9.00', '', 0),
(56, 'CHOPP CLARO', '', '121.000', '0.00', 1, NULL, 5, '9.00', '', 0),
(57, 'CHOPP VINHO', '', '145.000', '0.00', 1, NULL, 5, '12.00', '', 0),
(58, 'BEATS', '', '46.000', '0.00', 1, NULL, 6, '13.90', '', 0),
(59, 'BEATS GT', '', '57.000', '0.00', 1, NULL, 6, '13.90', '', 0),
(60, 'BLACK PRINCESS 600ML', '', '78.000', '0.00', 1, NULL, 6, '14.00', '', 0),
(61, 'BRAHMA 600', '', '112.000', '0.00', 1, NULL, 6, '12.00', '', 0),
(62, 'BUDWEISER (LONG NECK)', '', '133.000', '0.00', 1, NULL, 6, '9.00', '', 0),
(63, 'BUDWEISER 600 ML ', '', '105.000', '0.00', 1, NULL, 6, '13.00', '', 0),
(64, 'CORONA LN', '', '133.000', '0.00', 1, NULL, 6, '14.00', '', 0),
(65, 'EISENBAHN', '', '59.000', '0.00', 1, NULL, 6, '12.00', '', 0),
(66, 'HEINEKEN (LONG NECK)', '', '38.000', '0.00', 1, NULL, 6, '12.00', '', 0),
(67, 'HEINEKEN 600 ML ', '', '61.000', '0.00', 1, NULL, 6, '16.00', '', 0),
(68, 'HEINEKEN ZERO LN ', '', '137.000', '0.00', 1, NULL, 6, '14.00', '', 0),
(69, 'HENEKEN 0 ALCOOL (LN)', '', '74.000', '0.00', 1, NULL, 6, '13.00', '', 0),
(70, 'ORIGINAL 600 ML ', '', '119.000', '0.00', 1, NULL, 6, '13.00', '', 0),
(71, 'PETRA (LONG NECK)', '', '111.000', '0.00', 1, NULL, 6, '9.00', '', 0),
(72, 'PETRA 600 ML', '', '130.000', '0.00', 1, NULL, 6, '13.00', '', 0),
(73, 'STELLA (LONG NECK)', '', '63.000', '0.00', 1, NULL, 6, '10.00', '', 0),
(74, 'ALMA NEGRA', '', '60.000', '0.00', 1, NULL, 7, '330.00', '', 0),
(75, 'BARRICADO ', '', '111.000', '0.00', 1, NULL, 7, '127.60', '', 0),
(76, 'BENEDICTUM III ROSADO', '', '57.000', '0.00', 1, NULL, 7, '99.00', '', 0),
(77, 'BIG CHANDON', '', '60.000', '0.00', 1, NULL, 7, '400.00', '', 0),
(78, 'CALVET VARIETALS ', '', '139.000', '0.00', 1, NULL, 7, '217.00', '', 0),
(79, 'CASAL GARCIA VINHO VERDE', '', '148.000', '0.00', 1, NULL, 7, '156.00', '', 0),
(80, 'CASILLERO DEL DIABLO', '', '132.000', '0.00', 1, NULL, 7, '139.00', '', 0),
(81, 'CHANDON BRUT', '', '101.000', '0.00', 1, NULL, 7, '200.00', '', 0),
(82, 'CHANDON ROSE', '', '112.000', '0.00', 1, NULL, 7, '220.00', '', 0),
(83, 'CICONIA ALENTEJO DOC', '', '34.000', '0.00', 1, NULL, 7, '169.50', '', 0),
(84, 'QUINTA DE BONS VENTOS', '', '38.000', '0.00', 1, NULL, 7, '140.00', '', 0),
(85, 'SOGNO ITALIANO BRANCO', '', '117.000', '0.00', 1, NULL, 7, '103.00', '', 0),
(86, 'SOGNO ITALIANO ROSATO', '', '33.000', '0.00', 1, NULL, 7, '103.00', '', 0),
(87, 'SOGNO ITALIANO TINTO', '', '40.000', '0.00', 1, NULL, 7, '103.00', '', 0),
(88, 'TANTEHUE CABERNET SAUVIGNON', '', '50.000', '0.00', 1, NULL, 7, '89.00', '', 0),
(89, 'TANTEHUE SAUVIGNON BLANC', '', '71.000', '0.00', 1, NULL, 7, '79.00', '', 0),
(90, 'VICTORIUM III', '', '34.000', '0.00', 1, NULL, 7, '99.00', '', 0),
(91, 'VINHO CASAL GARCIA', '', '33.000', '0.00', 1, NULL, 7, '156.00', '', 0),
(92, 'MEIA/MEIA PIZZA FAMILIA (35 CM)', '', '94.000', '0.00', 1, NULL, 8, '0.01', '', 0),
(93, 'MEIA/MEIA PIZZA MEDIA (25 CM)', '', '84.000', '0.00', 1, NULL, 8, '0.01', '', 0),
(94, 'PIZZA DOCE (25CM)', '', '88.000', '0.00', 1, NULL, 8, '38.00', '', 0),
(95, 'PIZZA DOCE (35CM)', '', '136.000', '0.00', 1, NULL, 8, '53.00', '', 0),
(96, 'PIZZA ESPECIAL (25CM)', '', '42.000', '0.00', 1, NULL, 8, '40.00', '', 0),
(97, 'PIZZA ESPECIAL (35CM)', '', '98.000', '0.00', 1, NULL, 8, '58.00', '', 0),
(98, 'PIZZA FAMILIA (35 CM)', '', '96.000', '0.00', 1, NULL, 8, '53.00', '', 0),
(99, 'PIZZA MEDIA (25 CM)', '', '85.000', '0.00', 1, NULL, 8, '38.00', '', 0),
(100, 'BATATA FRITA', '', '31.000', '0.00', 1, NULL, 9, '22.00', '', 0),
(101, 'BATATA FRITA COM CHEDDAR E BACON', '', '140.000', '0.00', 1, NULL, 9, '33.00', '', 0),
(102, 'BATATA PORTUGUESA', '', '83.000', '0.00', 1, NULL, 9, '24.00', '', 0),
(103, 'BATATA RUSTICA ', '', '107.000', '0.00', 1, NULL, 9, '24.00', '', 0),
(104, 'BOLINHO DE BACALHAU', '', '41.000', '0.00', 1, NULL, 9, '38.00', '', 0),
(105, 'CAMARAO ', '', '61.000', '0.00', 1, NULL, 9, '68.00', '', 0),
(106, 'CEVICHE', '', '124.000', '0.00', 1, NULL, 9, '23.00', '', 0),
(107, 'CRISPY CHICKEN', '', '79.000', '0.00', 1, NULL, 9, '30.90', '', 0),
(108, 'CROQUETE CHARQUE', '', '139.000', '0.00', 1, NULL, 9, '48.00', '', 0),
(109, 'CROQUETE DE COSTELA', '', '97.000', '0.00', 1, NULL, 9, '39.00', '', 0),
(110, 'CROQUETE DE FEIJOADA', '', '36.000', '0.00', 1, NULL, 9, '33.00', '', 0),
(111, 'DADINHO DE TAPIOCA', '', '66.000', '0.00', 1, NULL, 9, '33.00', '', 0),
(112, 'ESPETO MANSAO ', '', '47.000', '0.00', 1, NULL, 9, '25.90', '', 0),
(113, 'FILE AO MOLHO GORGONZOLA', '', '96.000', '0.00', 1, NULL, 9, '80.00', '', 0),
(114, 'FILE MIGNON COM FRITAS', '', '62.000', '0.00', 1, NULL, 9, '75.00', '', 0),
(115, 'FRANGO À PASSARINHO', '', '33.000', '0.00', 1, NULL, 9, '38.00', '', 0),
(116, 'ISCAS DE FRANGO', '', '95.000', '0.00', 1, NULL, 9, '38.00', '', 0),
(117, 'ISCAS DE PEIXE', '', '69.000', '0.00', 1, NULL, 9, '48.00', '', 0),
(118, 'MIX DE QUEIJOS ', '', '89.000', '0.00', 1, NULL, 9, '42.00', '', 0),
(119, 'PALMITO ', '', '129.000', '0.00', 1, NULL, 9, '32.00', '', 0),
(120, 'PASTELZINHO DE CAMARAO', '', '126.000', '0.00', 1, NULL, 9, '38.00', '', 0),
(121, 'PICANHA ESPECIAL', '', '153.000', '0.00', 1, NULL, 9, '98.00', '', 0),
(122, 'PORK B.B.Q.', '', '96.000', '0.00', 1, NULL, 9, '80.00', '', 0),
(123, 'PROVOLONE A MILANESA', '', '81.000', '0.00', 1, NULL, 9, '42.00', '', 0),
(124, 'SALAMINHHO ', '', '139.000', '0.00', 1, NULL, 9, '22.00', '', 0),
(125, 'SALAMINHO E AZEITONAS ', '', '136.000', '0.00', 1, NULL, 9, '28.00', '', 0),
(126, 'TABUA DE FRIOS', '', '135.000', '0.00', 1, NULL, 9, '78.00', '', 0),
(127, '1/2 REFEIÇAO INDIVIDUAL', '', '73.000', '0.00', 1, NULL, 10, '45.00', '', 0),
(128, 'COMBINADO GASTRO PUB', '', '116.000', '0.00', 1, NULL, 10, '195.00', '', 0),
(129, 'FILE A MODA DO CHEFE', '', '126.000', '0.00', 1, NULL, 10, '152.00', '', 0),
(130, 'FILE MIGNON AO MOLHO MADEIRA', '', '83.000', '0.00', 1, NULL, 10, '152.00', '', 0),
(131, 'MANSAO FIT', '', '113.000', '0.00', 1, NULL, 10, '98.00', '', 0),
(132, 'PICANHA A MODA DA CASA', '', '146.000', '0.00', 1, NULL, 10, '168.00', '', 0),
(133, 'REFEIÇAO 2 PESSOAS', '', '80.000', '0.00', 1, NULL, 10, '109.00', '', 0),
(134, 'REFEIÇAO 3 PESSOAS', '', '52.000', '0.00', 1, NULL, 10, '149.00', '', 0),
(135, 'REFEIÇAO INDIVIDUAL', '', '67.000', '0.00', 1, NULL, 10, '56.00', '', 0),
(136, 'TILAPIA P COMPARTILHAR ', '', '142.000', '0.00', 1, NULL, 10, '125.00', '', 0),
(137, 'ARROZ', '', '142.000', '0.00', 1, NULL, 11, '15.00', '', 0),
(138, 'ARROZ COM ALHO', '', '98.000', '0.00', 1, NULL, 11, '18.00', '', 0),
(139, 'ARROZ PIAMONTESE', '', '33.000', '0.00', 1, NULL, 11, '29.00', '', 0),
(140, 'BATATA CHIPS', '', '56.000', '0.00', 1, NULL, 11, '24.00', '', 0),
(141, 'BATATA FRITA', '', '38.000', '0.00', 1, NULL, 11, '22.00', '', 0),
(142, 'FEIJAO PRETO', '', '139.000', '0.00', 1, NULL, 11, '28.00', '', 0),
(143, 'FEIJAO TROPEIRO', '', '106.000', '0.00', 1, NULL, 11, '28.00', '', 0),
(144, 'PURE DE BATATA DOCE', '', '55.000', '0.00', 1, NULL, 11, '22.00', '', 0),
(145, 'SALADA MIX DE FOLHAS', '', '85.000', '0.00', 1, NULL, 11, '28.00', '', 0),
(146, 'APERITIVO MANSAO', '', '32.000', '0.00', 1, NULL, 12, '9.90', '', 0),
(147, 'APEROL DOSE', '', '35.000', '0.00', 1, NULL, 12, '18.00', '', 0),
(148, 'BACARDI DOSE', '', '137.000', '0.00', 1, NULL, 12, '10.00', '', 0),
(149, 'BLACK LABEL DOSE', '', '78.000', '0.00', 1, NULL, 12, '20.00', '', 0),
(150, 'BLACK LABEL GARRAFA', '', '70.000', '0.00', 1, NULL, 12, '325.00', '', 0),
(151, 'CACHAÇA DOSE', '', '157.000', '0.00', 1, NULL, 12, '8.90', '', 0),
(152, 'CAMPARI DOSE', '', '130.000', '0.00', 1, NULL, 12, '12.00', '', 0),
(153, 'CAMPARI GARRAFA', '', '73.000', '0.00', 1, NULL, 12, '155.00', '', 0),
(154, 'GIN SEAGERS DOSE', '', '158.000', '0.00', 1, NULL, 12, '14.00', '', 0),
(155, 'GIN SEAGERS GARRAFA', '', '130.000', '0.00', 1, NULL, 12, '180.00', '', 0),
(156, 'GIN TANQUERY DOSE', '', '122.000', '0.00', 1, NULL, 12, '20.00', '', 0),
(157, 'GIN TANQUERY GARRAFA', '', '132.000', '0.00', 1, NULL, 12, '310.00', '', 0),
(158, 'JACK APPLE DOSE', '', '116.000', '0.00', 1, NULL, 12, '28.00', '', 0),
(159, 'JACK APPLE GARRAFA', '', '124.000', '0.00', 1, NULL, 12, '550.00', '', 0),
(160, 'JACK DANIELS DOSE', '', '124.000', '0.00', 1, NULL, 12, '20.00', '', 0),
(161, 'JACK DANIELS GARRAFA', '', '141.000', '0.00', 1, NULL, 12, '350.00', '', 0),
(162, 'JACK HONEY DOSE', '', '46.000', '0.00', 1, NULL, 12, '20.00', '', 0),
(163, 'JACK HONEY GARRAFA ', '', '111.000', '0.00', 1, NULL, 12, '360.00', '', 0),
(164, 'LICOR 43', '', '54.000', '0.00', 1, NULL, 12, '18.00', '', 0),
(165, 'LICOR COINTREAU DOSE', '', '34.000', '0.00', 1, NULL, 12, '18.00', '', 0),
(166, 'MARTINI DOSE', '', '151.000', '0.00', 1, NULL, 12, '12.00', '', 0),
(167, 'RED LABEL DOSE', '', '146.000', '0.00', 1, NULL, 12, '18.00', '', 0),
(168, 'RED LABEL GARRAFA', '', '34.000', '0.00', 1, NULL, 12, '265.00', '', 0),
(169, 'SHOT CHARQUE 1 UN', '', '55.000', '0.00', 1, NULL, 12, '9.00', '', 0),
(170, 'SHOT CHARQUE 3 UNI', '', '97.000', '0.00', 1, NULL, 12, '26.00', '', 0),
(171, 'TEQUILA DOSE', '', '68.000', '0.00', 1, NULL, 12, '17.00', '', 0),
(172, 'TEQUILA GARRAFA', '', '113.000', '0.00', 1, NULL, 12, '256.00', '', 0),
(173, 'VODKA ABSOLUT DOSE', '', '141.000', '0.00', 1, NULL, 12, '16.00', '', 0),
(174, 'VODKA ABSOLUT GARRAFA', '', '129.000', '0.00', 1, NULL, 12, '240.00', '', 0),
(175, 'VODKA CIROC DOSE', '', '116.000', '0.00', 1, NULL, 12, '28.00', '', 0),
(176, 'VODKA CIROC GARRAFA', '', '74.000', '0.00', 1, NULL, 12, '348.00', '', 0),
(177, 'VODKA CIROC RED BERRY', '', '153.000', '0.00', 1, NULL, 12, '28.00', '', 0),
(178, 'VODKA NORDKA DOSE', '', '156.000', '0.00', 1, NULL, 12, '8.00', '', 0),
(179, 'VODKA NORDKA GARRAFA', '', '155.000', '0.00', 1, NULL, 12, '125.00', '', 0),
(180, 'VODKA SMIRNOFF DOSE', '', '143.000', '0.00', 1, NULL, 12, '12.00', '', 0),
(181, 'VODKA SMIRNOFF GARRAFA', '', '137.000', '0.00', 1, NULL, 12, '170.00', '', 0),
(182, 'BOMBOM SONHO DE VALSA', '', '151.000', '0.00', 1, NULL, 13, '2.00', '', 0),
(183, 'CIGARRO VAREJO ', '', '97.000', '0.00', 1, NULL, 13, '2.50', '', 0),
(184, 'DUNHILL', '', '125.000', '0.00', 1, NULL, 13, '12.00', '', 0),
(185, 'HALLS', '', '60.000', '0.00', 1, NULL, 13, '2.50', '', 0),
(186, 'MAGNETO 2L', '', '152.000', '0.00', 1, NULL, 13, '15.00', '', 0),
(187, 'MAIONESE ', '', '73.000', '0.00', 1, NULL, 13, '1.50', '', 0),
(188, 'MINI ISQUEIRO BIC', '', '89.000', '0.00', 1, NULL, 13, '6.00', '', 0),
(189, 'MOLHO ADICIONAL', '', '45.000', '0.00', 1, NULL, 13, '5.00', '', 0),
(190, 'OLD FOXY PALHA', '', '45.000', '0.00', 1, NULL, 13, '20.00', '', 0),
(191, 'ROLHA', '', '119.000', '0.00', 1, NULL, 13, '40.00', '', 0),
(192, 'SOUZA PAIOL OURO ', '', '56.000', '0.00', 1, NULL, 13, '25.00', '', 0),
(193, 'SOUZA PAIOL TRAD', '', '143.000', '0.00', 1, NULL, 13, '20.00', '', 0),
(194, 'TRIDENT', '', '75.000', '0.00', 1, NULL, 13, '3.00', '', 0),
(195, 'CALDO ', '', '71.000', '0.00', 1, NULL, 14, '15.00', '', 0),
(196, 'MANSÃO BURGUER', '', '134.000', '0.00', 1, NULL, 15, '24.90', '', 0),
(197, 'MANSÃO CRISPY', '', '103.000', '0.00', 1, NULL, 15, '36.90', '', 0),
(198, 'MANSÃO DOUBLE', '', '112.000', '0.00', 1, NULL, 15, '29.90', '', 0),
(199, 'MANSÃO RIBS BURGUER', '', '60.000', '0.00', 1, NULL, 15, '29.90', '', 0),
(200, 'BATATA FRITA (MEIA PORÇÃO)', '', '75.000', '0.00', 1, NULL, 18, '13.20', '', 0),
(201, 'BATATA FRITA COM CHEDDAR E BACON (MEIA PORÇÃO)', '', '111.000', '0.00', 1, NULL, 18, '19.80', '', 0),
(202, 'BATATA PORTUGUESA (MEIA PORÇÃO)', '', '56.000', '0.00', 1, NULL, 18, '14.40', '', 0),
(203, 'BATATA RUSTICA (MEIA) ', '', '88.000', '0.00', 1, NULL, 18, '14.40', '', 0),
(204, 'BOLINHO DE BACALHAU (MEIA PORÇÃO)', '', '51.000', '0.00', 1, NULL, 18, '22.80', '', 0),
(205, 'CAMARAO (MEIA PORÇÃO)', '', '80.000', '0.00', 1, NULL, 18, '40.80', '', 0),
(206, 'CRISPY CHICKEN (MEIA PORÇÃO)', '', '37.000', '0.00', 1, NULL, 18, '18.50', '', 0),
(207, 'CROQUETE CHARQUE (MEIA PORÇÃO)', '', '151.000', '0.00', 1, NULL, 18, '28.80', '', 0),
(208, 'CROQUETE DE COSTELA (MEIA PORÇÃO)', '', '55.000', '0.00', 1, NULL, 18, '23.40', '', 0),
(209, 'CROQUETE DE FEIJOADA (MEIA PORÇÃO)', '', '149.000', '0.00', 1, NULL, 18, '19.80', '', 0),
(210, 'DADINHO DE TAPIOCA (MEIA PORÇÃO)', '', '136.000', '0.00', 1, NULL, 18, '19.80', '', 0),
(211, 'FILE AO MOLHO GORGONZOLA ( MEIA PORÇÃO)', '', '157.000', '0.00', 1, NULL, 18, '48.00', '', 0),
(212, 'FILE MIGNON COM FRITAS (MEIA PORÇÃO)', '', '103.000', '0.00', 1, NULL, 18, '45.00', '', 0),
(213, 'ISCAS DE FRANGO (MEIA PORÇÃO)', '', '99.000', '0.00', 1, NULL, 18, '22.80', '', 0),
(214, 'ISCAS DE PEIXE (MEIA PORÇÃO)', '', '144.000', '0.00', 1, NULL, 18, '28.80', '', 0),
(215, 'PASTELZINHO DE CAMARAO (MEIA PORÇÃO)', '', '129.000', '0.00', 1, NULL, 18, '23.40', '', 0),
(216, 'PICANHA ESPECIAL (MEIA PORÇÃO)', '', '64.000', '0.00', 1, NULL, 18, '58.80', '', 0),
(217, 'PORK B.B.Q. (MEIA PORÇÃO)', '', '114.000', '0.00', 1, NULL, 18, '48.00', '', 0),
(218, 'PROVOLONE A MILANESA (MEIA PORÇÃO)', '', '60.000', '0.00', 1, NULL, 18, '25.20', '', 0),
(219, 'TABUA DE FRIOS (MEIA PORÇÃO)', '', '94.000', '0.00', 1, NULL, 18, '47.40', '', 0),
(220, 'COMBINADO RESERVA ADULTO', '', '92.000', '0.00', 1, NULL, 19, '39.00', '', 0),
(221, 'COMBINADO RESERVA INFANTIL', '', '91.000', '0.00', 1, NULL, 19, '53.00', '', 0),
(222, 'REFEIÇÃO FILE MIGNON', '', '40.000', '0.00', 1, NULL, 19, '45.00', '', 0),
(223, 'AÇAI', '', '39.000', '0.00', 1, NULL, 20, '8.00', '', 0),
(224, 'PICOLÉ PREMIUM ', '', '151.000', '0.00', 1, NULL, 20, '8.00', '', 0),
(225, 'SORVETE ', '', '56.000', '0.00', 1, NULL, 20, '14.00', '', 0),
(226, 'ADICIONAL BATATA ', '', '111.000', '0.00', 1, NULL, 21, '10.00', '', 0),
(227, 'BATATA FRITA ', '', '144.000', '0.00', 1, NULL, 21, '14.00', '', 0),
(228, 'HAMBURGUER ', '', '115.000', '0.00', 1, NULL, 21, '10.00', '', 0),
(229, 'X BACON BURGUER', '', '148.000', '0.00', 1, NULL, 21, '16.00', '', 0),
(230, 'X EGG BURGUER ', '', '48.000', '0.00', 1, NULL, 21, '14.00', '', 0),
(231, 'X TUDO', '', '107.000', '0.00', 1, NULL, 21, '20.00', '', 0),
(232, 'R. CALDOS', '', '126.000', '0.00', 1, NULL, 22, '29.90', '', 0),
(233, 'R. CHOPP', '', '125.000', '0.00', 1, NULL, 22, '49.90', '', 0),
(234, 'R. PETISCOS', '', '54.000', '0.00', 1, NULL, 22, '49.90', '', 0),
(235, 'R. PIZZA', '', '109.000', '0.00', 1, NULL, 22, '39.90', '', 0),
(236, 'R. PIZZA + REFRI', '', '101.000', '0.00', 1, NULL, 22, '44.90', '', 0),
(237, 'R. PIZZA CRIANÇA ', '', '146.000', '0.00', 1, NULL, 22, '19.95', '', 0),
(238, 'CHANDON + FRIOS', '', '160.000', '0.00', 1, NULL, 28, '278.00', '', 0),
(239, 'COMBO ABSOLUT + FRIOS + DADINHO', '', '123.000', '0.00', 1, NULL, 28, '350.00', '', 0),
(240, 'COMBO SMIRNOFF + FRIOS', '', '62.000', '0.00', 1, NULL, 28, '248.00', '', 0),
(241, 'EXECUTIVO FILE (INDIVIDUAL)', '', '72.000', '0.00', 1, NULL, 30, '39.00', '', 0),
(242, 'FETTUCCINE FILE (INDIVIDUAL)', '', '90.000', '0.00', 1, NULL, 30, '56.00', '', 0),
(243, 'FETTUCCINE SHRIMP (INDIVIDUAL)', '', '62.000', '0.00', 1, NULL, 30, '56.00', '', 0),
(244, 'FILE A MODA DO CHEF (INDIVIDUAL)', '', '148.000', '0.00', 1, NULL, 30, '45.00', '', 0),
(245, 'FILE DE FRANGO A PARMEGIANA (INDIVIDUAL)', '', '128.000', '0.00', 1, NULL, 30, '39.00', '', 0),
(246, 'KIT ESPECIAL MULHER', '', '132.000', '0.00', 1, NULL, 30, '79.00', '', 0),
(247, 'TILAPIA À MILANESA (INDIVIDUAL)', '', '107.000', '0.00', 1, NULL, 30, '39.00', '', 0),
(248, 'COMBO: ABSOLUT + 5 RED BULL ', '', '80.000', '0.00', 1, NULL, 31, '330.00', '', 0),
(249, 'COMBO: CIROC + 5 RED BULL ', '', '49.000', '0.00', 1, NULL, 31, '430.00', '', 0),
(250, 'COMBO: NORDKA + 5 RED BULL ', '', '107.000', '0.00', 1, NULL, 31, '210.00', '', 0),
(251, 'COMBO: RED LABEL + 5 RED BULL ', '', '117.000', '0.00', 1, NULL, 31, '350.00', '', 0),
(252, 'COMBO: SMIRNOFF + 5 RED BULL ', '', '127.000', '0.00', 1, NULL, 31, '260.00', '', 0),
(253, 'COMBO: TANQUERAY + 5 RED BULL ', '', '126.000', '0.00', 1, NULL, 31, '390.00', '', 0),
(254, 'CORAÇÃO 100GR', '', '85.000', '0.00', 1, NULL, 32, '13.00', '', 0),
(255, 'LINGUIÇA 100GR', '', '125.000', '0.00', 1, NULL, 32, '8.00', '', 0),
(256, 'PICANHA 500G', '', '76.000', '0.00', 1, NULL, 32, '90.00', '', 0),
(257, 'PICANHA P/ 1 PESSOA', '', '93.000', '0.00', 1, NULL, 32, '59.40', '', 0),
(258, 'PICANHA P/ 2 PESSOAS', '', '130.000', '0.00', 1, NULL, 32, '99.00', '', 0);

-- --------------------------------------------------------

--
-- Estrutura da tabela `produto_categoria`
--

DROP TABLE IF EXISTS `produto_categoria`;
CREATE TABLE IF NOT EXISTS `produto_categoria` (
  `ID_CATEGORIA` int NOT NULL AUTO_INCREMENT,
  `DESCRICAO_CATEGORIA` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `STATUS_CATEGORIA` int NOT NULL DEFAULT '1' COMMENT '1=Ativo; 2=Inativo',
  `TIPO_CATEGORIA` int NOT NULL DEFAULT '1' COMMENT '1=Produto; 2=Serviço',
  PRIMARY KEY (`ID_CATEGORIA`) USING BTREE,
  UNIQUE KEY `descricao` (`DESCRICAO_CATEGORIA`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `produto_categoria`
--

INSERT INTO `produto_categoria` (`ID_CATEGORIA`, `DESCRICAO_CATEGORIA`, `STATUS_CATEGORIA`, `TIPO_CATEGORIA`) VALUES
(1, 'DRINKS', 1, 1),
(2, 'SOBREMESAS', 1, 1),
(3, 'BEBIDAS', 1, 1),
(4, 'SUCO NATURAL', 1, 1),
(5, 'CHOPPS', 1, 1),
(6, 'CERVEJAS', 1, 1),
(7, 'VINHOS E ESPUMANTES', 1, 1),
(8, 'PIZZAS', 1, 1),
(9, 'PORÇÕES', 1, 1),
(10, 'REFEIÇÕES', 1, 1),
(11, 'GUARNIÇÕES', 1, 1),
(12, 'DESTILADOS', 1, 1),
(13, 'OUTROS', 1, 1),
(14, 'CALDOS', 1, 1),
(15, 'SANDUICHES', 1, 1),
(16, 'ARRAIA', 1, 1),
(17, 'COUVERT', 1, 1),
(18, 'MEIA PORÇÃO', 1, 1),
(19, 'MENU COMBINADOS', 1, 1),
(20, 'SORVETE', 1, 1),
(21, 'LANCHES', 1, 1),
(22, 'RODIZIOS', 1, 1),
(23, 'DIA DOS NAMORADOS', 1, 1),
(24, 'ARRAIA 2', 1, 1),
(25, 'FOUR', 1, 1),
(26, 'ALMOÇO', 1, 1),
(27, 'ALMOÇO COPA', 1, 1),
(28, 'REVEILLON', 1, 1),
(29, 'CAIXA', 1, 1),
(30, 'PRATOS INDIVIDUAIS', 1, 1),
(31, 'COMBOS', 1, 1),
(32, 'CHURRASCO', 1, 1);

-- --------------------------------------------------------

--
-- Estrutura da tabela `usuario`
--

DROP TABLE IF EXISTS `usuario`;
CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nivel` int NOT NULL DEFAULT '2' COMMENT '1=Administrador; 2=Garçom',
  `statusRegistro` int NOT NULL DEFAULT '1' COMMENT '1=Ativo; 2=Inativo',
  `nome` varchar(60) NOT NULL,
  `login` varchar(150) NOT NULL,
  `senha` varchar(250) NOT NULL,
  `email` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Extraindo dados da tabela `usuario`
--

INSERT INTO `usuario` (`id`, `nivel`, `statusRegistro`, `nome`, `login`, `senha`, `email`) VALUES
(1, 1, 1, 'Administrador', '', '$2y$10$mvqmp9KxwUOwcBgk6Ys4Ye9446uzB4bAl9rnGP3kW.pZMPE1xpO32', 'sistemacomanda@gmail.com');

--
-- Restrições para despejos de tabelas
--

--
-- Limitadores para a tabela `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `FK_produto_produtocategoria` FOREIGN KEY (`ID_PRODUTO_CATEGORIA`) REFERENCES `produto_categoria` (`ID_CATEGORIA`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
