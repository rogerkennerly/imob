-- phpMyAdmin SQL Dump
-- version 4.0.10.15
-- http://www.phpmyadmin.net
--
-- Servidor: localhost:3306
-- Tempo de Geração: 07/05/2019 às 16:39
-- Versão do servidor: 5.1.61
-- Versão do PHP: 5.3.3

-- --------------------------------------------------------

--
-- Estrutura para tabela `bairro`
--

CREATE TABLE IF NOT EXISTS `bairro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `id_cidade` int(11) NOT NULL,
  `latitude` varchar(20) NOT NULL,
  `longitude` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_cidade` (`id_cidade`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=526 ;
ALTER TABLE  `bairro` ADD INDEX (  `id_cidade` ) ;
--
-- Fazendo dump de dados para tabela `bairro`
--

INSERT INTO `bairro` (`id`, `nome`, `id_cidade`, `latitude`, `longitude`) VALUES
(1, 'Jardim América', 1, '-23.5708777', '-46.670355'),
(2, 'Centro', 1, '-22.30275', '-48.5755491'),
(3, 'Jardim Nova Jaú', 1, '-22.3114624', '-48.5800246'),
(4, 'Vila Santa Terezinha', 1, '-22.3094463', '-48.5499908'),
(5, 'Vila Santa Maria', 1, '-22.287677', '-48.5709502'),
(6, 'Jardim Orlando Chesini Ometto', 1, '-22.3354128', '-48.5474887'),
(7, 'Jardim Bela Vista', 1, '-22.2832677', '-48.5675085'),
(8, 'Vila Hilst', 1, '-22.2884773', '-48.5554903'),
(9, 'Jardim Ferreira Dias', 1, '-22.2800161', '-48.5393577'),
(10, 'Jardim Sanzovo', 1, '-22.2993027', '-48.5800246'),
(11, 'Jardim São Caetano', 1, '-22.2950115', '-48.5681343'),
(12, 'Jardim Maria Luiza I', 1, '-22.303082', '-48.5706373'),
(13, 'Vila Nova Brasil', 1, '-22.3048942', '-48.5568721'),
(15, 'Vila Assis', 1, '-22.2940836', '-48.5474887'),
(16, 'Vila Ribeiro', 1, '-22.30275', '-48.5755491'),
(17, 'Jardim Cila de Lúcio Bauab', 1, '-22.2727684', '-48.5394342'),
(18, 'Chácara Doutor Lopes', 1, '-22.2853638', '-48.5533478'),
(19, 'Jardim Santa Rosa', 1, '-22.275102', '-48.5431103'),
(20, 'Jardim Maria Luiza IV', 1, '-22.3100412', '-48.5656314'),
(21, 'Chácara Nunes', 1, '-22.3065496', '-48.5543697'),
(22, 'Jardim João Paulo', 2, '-22.415361', '-48.44446'),
(23, 'Jardim Pedro Ometto', 1, '-22.3167398', '-48.5499908'),
(24, 'Jardim Santa Helena', 1, '-22.2871698', '-48.578147'),
(25, 'Vila Jardim Brasília', 1, '-22.3033942', '-48.5481142'),
(26, 'Vila Nova', 1, '-22.2909236', '-48.5706373'),
(27, 'Jardim Itamarati', 1, '-22.2771715', '-48.5399832'),
(28, 'Chácara Bela Vista', 1, '-22.2843594', '-48.5474887'),
(46, 'Jardim Padre Augusto Sani', 1, '-22.3162217', '-48.5875356'),
(47, 'Jardim Diamante', 1, '-22.2917565', '-48.5399832'),
(48, 'Vila Sampaio', 1, '-22.2868649', '-48.5645767'),
(31, 'Jardim Dona Emilia', 1, '-22.2662919', '-48.5491957'),
(32, 'Jardim Maria Luiza II', 1, '-22.3067295', '-48.5706373'),
(33, 'Jardim Maria Luiza III', 1, '-22.3115669', '-48.5725146'),
(34, 'Jardim Novo Horizonte', 1, '-22.2657394', '-48.5462377'),
(35, 'Vila Maria', 1, '-22.2704686', '-48.5556209'),
(36, 'Vila Industrial', 1, '-22.2928883', '-48.5750178'),
(37, 'Jardim São Francisco', 1, '-22.2785847', '-48.548653'),
(38, 'Conj Hab Comericiários', 1, '-22.2824998', '-48.51699'),
(39, 'Jardim Estádio', 1, '-22.2994082', '-48.5725146'),
(40, 'Distrito de Potunduva', 1, '-22.3111018', '-48.533789'),
(41, 'Santo Antônio', 1, '-22.3033829', '-48.562917'),
(42, 'Residêncial Bela Vista (Condom', 1, '-22.2703433', '-48.5476891'),
(44, 'Jardim Planalto', 1, '-22.7514101', '-47.6599895'),
(49, 'Vila Lobo', 1, '-23.5546028', '-46.5418618'),
(50, 'Jardim Pires I', 1, '-22.2746609', '-48.5344987'),
(51, 'Chácara Flora', 1, '-22.2932494', '-48.578147'),
(52, 'Jardim Alvorada', 1, '-22.284464', '-48.5399832'),
(78, 'Campos Eliseos', 11, '-22.272662', '-48.1138531'),
(54, 'Jardim das Paineiras', 1, '-22.3038853', '-48.5418594'),
(55, 'Jardim Carolina', 1, '-22.276053', '-48.5618772'),
(56, 'Jardim Pires II', 1, '-22.2773802', '-48.5249751'),
(57, 'Zona Rural', 1, '-22.3674586', '-48.3831645'),
(58, 'Jardim Conde do Pinhal I', 1, '-22.3096013', '-48.5681343'),
(59, 'Jardim Campos Prado', 1, '-22.2761061', '-48.5581233'),
(60, 'Jardim Conde do Pinhal II', 1, '-22.3131446', '-48.5756436'),
(61, 'Jardim Flamboyant', 1, '-22.3185146', '-48.5754308'),
(62, 'Jardim Juliana', 1, '-23.479495', '-47.4372982'),
(63, 'Jardim Paraty', 1, '-22.2847746', '-48.5174726'),
(64, 'Jardim Rosa Branca', 1, '-22.3083206', '-48.5434231'),
(65, 'Jardim Doutor Luciano', 1, '-22.3062648', '-48.5456122'),
(66, 'Vila Vicente', 1, '-22.2778415', '-48.5499908'),
(67, 'Jardim São José', 1, '-22.2799545', '-48.5725146'),
(68, 'Jardim São Crispim', 1, '-22.2717373', '-48.5518674'),
(69, 'Jardim Sempre Verde', 1, '-22.3098069', '-48.5384196'),
(70, 'Residencial Bernardi', 1, '-22.2804665', '-48.5201729'),
(71, 'Vila Carvalho', 1, '-22.2889176', '-48.5663781'),
(72, 'Vila Ivan', 1, '-22.2866593', '-48.5568721'),
(73, 'Jardim Paulista', 1, '-22.3104636', '-48.5742283'),
(77, 'Jardim Victório Marangoni', 9, '-22.147104', '-48.527196'),
(75, 'Centro', 9, '-22.1424169', '-48.5204279'),
(76, 'Jardim Residencial Guarantâ', 9, '-21.0282858', '-48.0381434'),
(79, 'Jardim Santa Cecilia III', 11, '-23.4426372', '-46.5312771'),
(80, 'Jardim Jorge Atalla', 1, '-22.2990492', '-48.5399832'),
(82, 'Área Urbana', 2, '-22.4353496', '-48.4587382'),
(83, 'Jardim Lizandra', 12, '-22.7233058', '-47.3312019'),
(84, 'Jardim Odete', 1, '-22.289936', '-48.583154'),
(86, 'Jardim Regina', 1, '-22.2858474', '-48.550553'),
(87, 'Jardim Infante Dom Henrique', 13, '-22.3445942', '-49.0506105'),
(88, 'Residencial Chácaras do Botelh', 1, '-22.2943106', '-48.556422'),
(89, 'Jardim Maria Luiza', 4, '-22.0821025', '-48.7358144'),
(90, 'Chácara Braz Miraglia', 1, '-22.2899709', '-48.5518674'),
(91, 'Chácara Auler', 1, '-22.2827824', '-48.5443613'),
(103, 'Barequeçaba', 16, '', ''),
(107, 'Mansões Santo Antonio', 17, '-22.8522138', '-47.0497877'),
(109, 'Residencial Jardim Europa', 18, '-22.4101426', '-47.5717516'),
(110, 'Vila Romana Lapa', 19, '', ''),
(115, 'Selva de Pedra', 20, '-24.00216', '-48.3502638'),
(150, 'Centro', 14, '-22.4189543', '-48.4508212'),
(154, 'Distrito Industrial', 21, '', ''),
(157, 'Av. Getulio Vargas', 33, '-22.3478282', '-49.0542044'),
(159, 'Rodovia Jaú Barra ', 15, '-22.2758805', '-48.4957853'),
(160, 'Distrito Industrial', 34, '-22.4883875', '-48.5648957'),
(162, 'Rural', 35, '-14.4268795', '-54.052897'),
(163, 'Centro', 36, '-22.075317', '-48.7417603'),
(171, 'Entrada da Cidade', 37, '-22.389112', '-48.396843'),
(176, 'Bela Vista ', 19, '', ''),
(189, 'Rural', 48, '-13.7975426', '-47.4604406'),
(205, 'Em frente ao trevo', 36, '', ''),
(206, 'Livramento', 36, '', ''),
(211, 'Rural', 56, '-21.2740117', '-47.1659023'),
(220, 'Rural', 61, '-13.7733778', '-50.2818278'),
(224, 'Grande São Paulo', 19, '-24.0088603', '-46.412475'),
(228, 'Vila do Golfe', 68, '', ''),
(229, '7º Distrito', 15, '-22.3377087', '-48.5470371'),
(230, 'Rural', 69, '', ''),
(231, 'Jardim Altos da Barra', 34, '', ''),
(235, 'Jardim Botânico', 68, '', ''),
(237, 'Vista Alegre', 33, '', ''),
(241, 'Taquaral', 70, '-22.2743886', '-48.1414754'),
(242, 'Astúrias', 71, '', ''),
(243, 'Próximo ao Centro', 72, '', ''),
(244, 'Centro', 73, '', ''),
(246, 'Jardim Pompéia', 74, '', ''),
(252, 'Vale do Igapó', 33, '', ''),
(253, 'Rodovia', 75, '', ''),
(257, 'Próximo Centro', 21, '-22.1430244', '-48.5255753'),
(258, 'Próximo a USC', 33, '', ''),
(259, 'Centro', 57, '', ''),
(261, 'Condomínio Saint Paul', 72, '', ''),
(264, 'Rural', 37, '-22.3674586', '-48.3831645'),
(265, 'Enseada', 71, '', ''),
(266, 'Jardim Leonidia', 15, '-22.3036064', '-48.5494363'),
(268, 'Mirante do Jacaré', 72, '-21.9848535', '-48.8000848'),
(271, 'Centro', 76, '', ''),
(275, 'Vila Nery', 77, '', ''),
(276, 'Rural', 78, '', ''),
(278, 'Centro', 34, '', ''),
(287, 'condomínio Guarantã (pesqueiro)', 21, '-22.1771672', '-48.5122347'),
(288, 'Rural', 33, '-22.3459242', '-49.0571352'),
(290, 'Irmãos Franchesch', 73, '', ''),
(291, 'Terras do Himalaia', 21, '-22.1430244', '-48.5255753'),
(292, 'Condomínio Vale Verde', 14, '-22.4125235', '-48.4514593'),
(293, 'Centro', 79, '', ''),
(294, 'São Fernando (Bauneário)', 80, '', ''),
(295, 'Jardim Regina', 70, '', ''),
(296, 'Rural', 34, '-22.4933753', '-48.5537146'),
(297, 'Campos', 14, '', ''),
(299, 'Centro', 21, '-22.1430244', '-48.5255753'),
(300, 'Jardim Europa', 14, '', ''),
(307, 'Jardim primavera', 73, '', ''),
(308, 'Ao lado do condomínio Alvorada', 15, '-22.2905986', '-48.5540765'),
(309, 'Terra de Santa Maria', 73, '-22.2527814', '-48.7172477'),
(311, 'Rural', 87, '', ''),
(312, 'moóca', 19, '-23.5603265', '-46.5995903'),
(313, 'Jardim Paulista', 37, '', ''),
(315, 'Estrada de Macatuba', 88, '', ''),
(316, 'Bosque do Jacaré', 11, '-22.2927556', '-48.5525929'),
(317, 'Residencial Sargentin', 34, '', ''),
(320, 'Vila Tupi', 89, '', ''),
(327, 'Jardim Morumbi', 90, '', ''),
(328, 'Santa Cruz', 68, '', ''),
(330, 'Vila melhado (molhado)', 91, '', ''),
(331, 'Clube de campo', 73, '', ''),
(332, 'Maria Luiza 2 ', 36, '-22.086254', '-48.7340922'),
(333, 'Residencial da Colina', 34, '-22.4866066', '-48.5573107'),
(335, 'Bonifácio', 92, '', ''),
(336, 'Jardim Santana', 21, '', ''),
(340, 'Vale Igapó', 76, '', ''),
(342, 'Vila Americana', 36, '', ''),
(344, 'Riviera de Santa Cristina III', 93, '-23.405037', '-49.117126'),
(345, 'Altos da Alvorada', 76, '', ''),
(346, 'Centro', 75, '-21.7547777', '-48.8316984'),
(351, 'Jardim Caraminguava', 95, '', ''),
(367, 'Jardim Bela Vista', 110, '', ''),
(368, 'Jardim Bela Vista', 111, '', ''),
(369, 'Jardim Bela Vista', 112, '', ''),
(370, 'Jardim Bela Vista', 113, '', ''),
(371, 'Jardim Bela Vista', 114, '', ''),
(372, 'Jardim João Ballan II', 1, '-22.3103298', '-48.5343456'),
(373, 'Chácara Ferreira Dias', 1, '', ''),
(374, '1 km Centro', 2, '', ''),
(375, 'Vila Netinho Prado', 1, '', ''),
(376, 'Jardim dos Comerciários', 1, '', ''),
(377, 'Jardim Maria Cibele', 1, '-22.2738819', '-48.5578105'),
(378, '5° Distrito', 1, '', ''),
(379, 'Vila Brasil', 1, '', ''),
(380, 'LOCAÇÃO ', 1, '', ''),
(381, 'Vila Nassif Name (Vila Lobo)', 1, '', ''),
(382, 'Jardim Continental', 1, '', ''),
(383, 'Condomínio Eldorado', 1, '', ''),
(384, 'Jardim Olimpia', 1, '', ''),
(385, 'Jardim São Crispim I', 1, '', ''),
(386, 'Jardim Pires de Campos II', 1, '', ''),
(387, 'Jardim Ibirapuera', 1, '', ''),
(388, 'Jardim Leonidia', 1, '', ''),
(389, 'Jardim Pedro Ometo', 1, '', ''),
(390, '1ª Zona Industrial', 1, '', ''),
(391, 'Jardim Ameriquinha', 1, '', ''),
(392, 'Jardim Alvorada II', 1, '', ''),
(393, 'Jardim Orlando Ometto', 1, '', ''),
(394, 'Condomínio Flamboyant', 1, '', ''),
(395, 'Jardim Santa Terezinha', 1, '', ''),
(396, 'Villágio di Roma', 1, '', ''),
(397, 'Jardim Concha de Ouro', 1, '', ''),
(398, 'Jardim Pires de Campos I', 1, '', ''),
(399, 'Estância Soave (Biquinha)', 1, '', ''),
(400, 'Jardim Bela Vista II', 1, '', ''),
(401, 'Condomínio Itaúna', 1, '', ''),
(402, 'Entrada da Cidade', 115, '', ''),
(403, 'Vila 15', 1, '', ''),
(404, 'Edificio Villagio Di Firenze', 1, '', ''),
(405, 'Distrito Industrial', 8, '', ''),
(406, 'Pouso Alegre de Baixo', 1, '', ''),
(407, 'Ao lado da pista', 72, '', ''),
(409, 'Quinta da Colina', 1, '', ''),
(412, 'Jardim Antonina', 1, '', ''),
(413, '7º Distrito', 1, '', ''),
(414, 'Jardim João Ballan I', 1, '', ''),
(419, 'Jardim Brasília', 1, '', ''),
(420, 'Chácara Peciolli', 1, '', ''),
(421, 'Edifício Heaven Tower', 1, '', ''),
(422, 'Jardim Campos Prado II', 1, '', ''),
(423, 'Chácara do Botelho', 1, '', ''),
(426, 'Condomínio Alvorada', 1, '', ''),
(427, 'Rural', 122, '', ''),
(428, 'Jardim São Crispim II ', 1, '', ''),
(429, 'Vila Alves', 1, '', ''),
(430, 'Bosque do Jacaré', 1, '', ''),
(431, 'Ao lado do condomínio Alvorada', 1, '', ''),
(432, 'Condomínio Residencial Primavera I', 1, '', ''),
(438, 'Condomínio Residencial Primavera II', 1, '', ''),
(439, 'Centro', 4, '', ''),
(440, 'Jardim São Benedito', 1, '', ''),
(441, 'Edificio Ouro verde', 1, '', ''),
(442, 'Estrada Jaú - Mineiros do Tietê', 1, '', ''),
(443, 'Edifício Santa Mônica', 1, '', ''),
(444, 'Recanto Feliz', 128, '', ''),
(445, 'Barra do Una', 16, '', ''),
(446, 'Jardim Maria Isabel', 1, '', ''),
(451, 'Jardim Bernardi ', 1, '', ''),
(452, 'Condomínio Portal das Araras', 1, '-22.3677199', '-48.6744915'),
(453, '2ª Zona Industrial', 1, '', ''),
(459, 'Jaú - Bauru - Próx. a Guaianás', 138, '', ''),
(460, 'Condomínio Parque dos Principes', 1, '', ''),
(464, 'Condomínio Frei Galvão', 1, '', ''),
(465, 'Jardim Itatiaia', 1, '', ''),
(466, 'Rural', 142, '', ''),
(467, 'Condomínio Residencial Campos Prado', 1, '', ''),
(468, 'Residencial Marcio Soufen Redi', 1, '', ''),
(474, 'Bairro Anhumas ', 1, '', ''),
(475, 'Vicinal José Maria Verdini - Jaú', 1, '', ''),
(476, 'Jardim Santo Onofre', 1, '', ''),
(477, 'Jardim Santo Antônio', 1, '', ''),
(478, 'Vila Falcão', 1, '', ''),
(479, 'Jardim Orlando Ometto II', 1, '', ''),
(480, 'Vila Nossa Senhora de Fátima', 1, '', ''),
(481, 'Residencial Primavera I', 1, '', ''),
(482, 'Edifício Novo Mundo', 1, '', ''),
(483, 'Cecap', 1, '', ''),
(484, 'Jardim Pedro Julian', 1, '', ''),
(485, 'Jardim Paulista', 6, '', ''),
(486, 'Pitangueiras', 71, '', ''),
(487, 'Rodovia Jaú X Brotas', 1, '', ''),
(488, 'Conjunto Residencial Bernardi', 1, '', ''),
(489, 'Conjunto Habitacional dos Comerciários I', 1, '-22.28237', '-48.5155971'),
(490, 'Residencial Sencelles', 1, '', ''),
(491, 'Jardim Geraldo Valentim(Dist.Potunduva)', 1, '', ''),
(492, 'Residencial Pedro Julian (Potunduva) ', 1, '', ''),
(493, 'Jardim Netinho Prado', 1, '', ''),
(494, 'Condomínio Vila Real', 1, '', ''),
(495, 'Cohab', 8, '', ''),
(496, 'Baixão da Serra', 2, '', ''),
(497, 'Residencial Parque Ferreira Dias', 1, '', ''),
(498, 'Rural - SÍTIO', 7, '', ''),
(499, 'Yang 3', 4, '', ''),
(500, 'Bruno Cury', 5, '', ''),
(501, 'Distrito de Potuntuva', 1, '', ''),
(502, 'SÍTIO - Rural', 2, '', ''),
(503, 'Jardim Dr. Roberto Pacheco', 1, '', ''),
(504, 'Loteamento Residencial Maria Isabel  ', 1, '', ''),
(505, 'Parque Ferreira Dias', 1, '', ''),
(506, 'Edifício Alvorada', 1, '', ''),
(507, 'Residencial Palma de Malorca', 1, '', ''),
(508, 'Residencial dos Pássaros', 1, '', ''),
(509, 'Santana', 9, '', ''),
(510, 'Edifício Mareno Di Piave (Jaú Serve) ', 1, '', ''),
(511, 'Jardim Frei Galvão (Potunduva)', 1, '', ''),
(512, 'Vila Buscariolo', 1, '', ''),
(513, 'Jardim Europa', 2, '', ''),
(514, 'Condomínio Morada do Sol', 1, '', ''),
(515, 'Condomínio Vale Verde', 2, '', ''),
(516, 'Rural', 7, '', ''),
(517, 'Jd Planalto 3', 5, '', ''),
(518, 'Jardim Veneza', 2, '', ''),
(519, 'Vila Sampaio Bueno', 1, '', ''),
(520, 'Jardim Roberto Pacheco', 1, '', ''),
(521, 'Jd nova morada (Distrito de Potunduva)', 1, '', ''),
(522, 'Terra de Santa Maria', 7, '', ''),
(523, 'Jardim Nova Bocaina II', 9, '', ''),
(524, 'Vila Aviação', 13, '', ''),
(525, 'Condomínio Primavera(ao lado do Caiçara)', 1, '', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `banner`
--

CREATE TABLE IF NOT EXISTS `banner` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(200) NOT NULL,
  `posicao` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Fazendo dump de dados para tabela `banner`
--
-- --------------------------------------------------------

--
-- Estrutura para tabela `cidade`
--

CREATE TABLE IF NOT EXISTS `cidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `id_estado` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_estado` (`id_estado`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=148 ;

--
-- Fazendo dump de dados para tabela `cidade`
--

INSERT INTO `cidade` (`id`, `nome`, `id_estado`) VALUES
(1, 'Jaú', 1),
(2, 'Mineiros do Tietê', 1),
(4, 'Bariri', 1),
(5, 'Pederneiras', 1),
(6, 'Dois Córregos', 1),
(7, 'Itapui', 1),
(8, 'Barra Bonita', 1),
(9, 'Bocaina', 1),
(11, 'Brotas', 1),
(13, 'Bauru', 1);

-- --------------------------------------------------------

--
-- Estrutura para tabela `config`
--

CREATE TABLE IF NOT EXISTS `config` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `banner` char(1) NOT NULL,
  `lancamentos` int(11) NOT NULL,
  `paginacao` int(11) NOT NULL,
  `destaques_grande` int(11) NOT NULL,
  `destaques_pequeno` int(11) NOT NULL,
  `cor_layout` varchar(30) NOT NULL,
  `cor_botao` varchar(30) NOT NULL,
  `scripts` text NOT NULL,
  `captcha` char(1) NOT NULL,
  `key_captcha` varchar(100) NOT NULL,
  `layout` varchar(100) NOT NULL,
  `versao_sistema` varchar(10) NOT NULL,
	`restricao_proprietarios` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `config`
--

INSERT INTO `config` (`id`, `banner`, `lancamentos`, `paginacao`, `destaques_grande`, `destaques_pequeno`, `cor_layout`, `cor_botao`, `scripts`, `captcha`, `key_captcha`, `layout`, `versao_sistema`) VALUES
(1, 'N', 0, 12, 0, 0, '#d9534f', '#d9534f', '', 'N', '', 'modelo1', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `contato`
--

CREATE TABLE IF NOT EXISTS `contato` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `mensagem` text NOT NULL,
  `tipo` int(1) NOT NULL COMMENT '1 = pagina imovel | 2 = pagina contato',
  `data` datetime NOT NULL,
  `ip` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Estrutura para tabela `dados_imobiliaria`
--

CREATE TABLE IF NOT EXISTS `dados_imobiliaria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(50) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `marcadagua` varchar(255) NOT NULL,
  `pessoa` char(1) DEFAULT 'J',
  `doc` varchar(50) NOT NULL,
  `telefone` varchar(50) NOT NULL,
  `celular` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `estado` char(2) NOT NULL,
  `cidade` varchar(50) NOT NULL,
  `bairro` varchar(50) NOT NULL,
  `endereco` varchar(50) NOT NULL,
  `cep` varchar(15) NOT NULL,
  `facebook` varchar(250) NOT NULL,
  `twitter` varchar(250) NOT NULL,
  `instagram` varchar(250) NOT NULL,
  `youtube` varchar(200) NOT NULL,
  `latitude` varchar(30) NOT NULL,
  `longitude` varchar(30) NOT NULL,
  `creci` varchar(20) NOT NULL,
  `integracao` varchar(20) NOT NULL,
  `key_integracao` varchar(100) NOT NULL,
  `logo_boleto` varchar(255) NOT NULL,
  `inst1` varchar(60) NOT NULL,
  `inst2` varchar(60) NOT NULL,
  `inst3` varchar(60) NOT NULL,
  `inst4` varchar(60) NOT NULL,
  `id_cidade` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `dados_imobiliaria`
--

INSERT INTO `dados_imobiliaria` (`id`, `nome`, `logo`, `marcadagua`, `pessoa`, `doc`, `telefone`, `celular`, `email`, `estado`, `cidade`, `bairro`, `endereco`, `cep`, `facebook`, `twitter`, `instagram`, `youtube`, `latitude`, `longitude`, `creci`, `integracao`, `key_integracao`, `logo_boleto`, `inst1`, `inst2`, `inst3`, `inst4`, `id_cidade`) VALUES
(1, 'Nova Imobiliária', '73798_marcos-adriano-logo.png', '62310_marca.png', 'J', '', '(14) 3636-3636', '(14) 99999-9999', 'contato@imobiliaria.com.br', 'SP', 'Jaú', 'Bairro', 'Rua Exemplo, 100', '', 'facebook.com/exemplo', '', '', '', '-22.2963134', '-48.5598394', '25.008-J', '', '', '', '', '', '', '', 1);


-- --------------------------------------------------------

--
-- Estrutura para tabela `estado`
--

CREATE TABLE IF NOT EXISTS `estado` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `sigla` char(2) NOT NULL,
  `nome` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `estado`
--

INSERT INTO `estado` (`id`, `sigla`, `nome`) VALUES
(1, 'SP', 'Sao Paulo');

-- --------------------------------------------------------

--
-- Estrutura para tabela `favoritos`
--

CREATE TABLE IF NOT EXISTS `favoritos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_cookie` int(11) NOT NULL,
  `id_imovel` int(11) NOT NULL,
  `id_finalidade` int(11) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_imovel` (`id_imovel`),
  KEY `id_cookie` (`id_cookie`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=7 ;


-- --------------------------------------------------------

--
-- Estrutura para tabela `finalidade`
--

CREATE TABLE IF NOT EXISTS `finalidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Fazendo dump de dados para tabela `finalidade`
--

INSERT INTO `finalidade` (`id`, `nome`) VALUES
(1, 'Venda'),
(2, 'Aluguel');

-- --------------------------------------------------------

--
-- Estrutura para tabela `foto`
--

CREATE TABLE IF NOT EXISTS `foto` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_imovel` int(11) NOT NULL,
  `nome` varchar(255) NOT NULL,
  `data` datetime NOT NULL,
  `posicao` int(11) NOT NULL,
  `data_modificacao` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Estrutura para tabela `imovel`
--

CREATE TABLE IF NOT EXISTS `imovel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `ref` varchar(10) NOT NULL,
  `id_proprietario` int(11) NOT NULL,
  `id_corretor` int(11) NOT NULL,
  `id_tipo` int(11) NOT NULL DEFAULT '0',
  `id_estado` int(11) NOT NULL,
  `id_cidade` int(11) NOT NULL,
  `id_bairro` int(11) NOT NULL DEFAULT '0',
  `cep` varchar(20) NOT NULL,
  `endereco` varchar(255) DEFAULT NULL,
  `detalhes` text,
  `obs` text NOT NULL,
  `disponivel` char(1) NOT NULL DEFAULT 'N',
  `super_destaque` char(1) NOT NULL DEFAULT 'N',
  `destaque` char(1) NOT NULL DEFAULT 'N',
  `financia` char(1) NOT NULL DEFAULT 'N',
  `quarto` tinyint(4) NOT NULL DEFAULT '0',
  `suite` tinyint(4) NOT NULL DEFAULT '0',
  `banheiro` tinyint(4) NOT NULL DEFAULT '0',
  `garagem` tinyint(4) NOT NULL DEFAULT '0',
  `sala` tinyint(4) NOT NULL DEFAULT '0',
  `terreno` varchar(40) DEFAULT NULL,
  `area_construida` varchar(20) DEFAULT NULL,
  `data_cadastro` datetime NOT NULL,
  `visualizacao` int(11) DEFAULT '0',
  `ultimo_acesso` datetime NOT NULL,
  `excluido` char(1) NOT NULL DEFAULT 'N',
  `video` varchar(50) NOT NULL,
  `importado` tinyint(1) NOT NULL,
  `data_inativo` date NOT NULL,
  `pre_cadastro` int(1) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `disponivel` (`disponivel`),
  KEY `id_proprietario` (`id_proprietario`),
  KEY `id_tipo` (`id_tipo`),
  KEY `id_estado` (`id_estado`),
  KEY `id_cidade` (`id_cidade`),
  KEY `id_bairro` (`id_bairro`),
  KEY `super_destaque` (`super_destaque`),
  KEY `destaque` (`destaque`),
  KEY `financia` (`financia`),
  KEY `quarto` (`quarto`),
  KEY `suite` (`suite`),
  KEY `banheiro` (`banheiro`),
  KEY `garagem` (`garagem`),
  KEY `sala` (`sala`),
  KEY `visualizacao` (`visualizacao`),
  KEY `pre_cadastro` (`pre_cadastro`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Estrutura para tabela `imovel_finalidade`
--

CREATE TABLE IF NOT EXISTS `imovel_finalidade` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_imovel` int(11) NOT NULL,
  `id_finalidade` int(11) NOT NULL,
  `valor` double(13,2) NOT NULL,
  `iptu` double(10,2) NOT NULL,
  `condominio` double(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_imovel` (`id_imovel`),
  KEY `id_finalidade` (`id_finalidade`),
  KEY `valor` (`valor`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Estrutura para tabela `imovel_item`
--

CREATE TABLE IF NOT EXISTS `imovel_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_imovel` int(11) NOT NULL,
  `id_item` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_imovel` (`id_imovel`),
  KEY `id_item` (`id_item`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Estrutura para tabela `item`
--

CREATE TABLE IF NOT EXISTS `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `tags` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=22 ;

--
-- Fazendo dump de dados para tabela `item`
--

INSERT INTO `item` (`id`, `nome`, `tags`) VALUES
(4, 'Cozinha', ''),
(5, 'Portão Eletrônico', ''),
(6, 'Ar condicionado', ''),
(7, 'Copa', ''),
(8, 'Churrasqueira', ''),
(9, 'Área de lazer', ''),
(10, 'Lavabo', ''),
(11, 'Escritório', ''),
(12, 'Despensa', ''),
(13, 'Lavanderia', ''),
(14, 'Sauna', ''),
(15, 'Piscina', ''),
(16, 'Banheira', ''),
(18, 'Edícula', ''),
(19, 'Sobrado', ''),
(20, 'Jardim de Inverno', ''),
(21, 'Suíte', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `log`
--

CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `id_recurso` int(11) NOT NULL,
  `descricao` text NOT NULL,
  `query` text NOT NULL,
  `data` datetime NOT NULL,
  `ip` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


-- --------------------------------------------------------

--
-- Estrutura para tabela `modulo`
--

CREATE TABLE IF NOT EXISTS `modulo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `ativo` char(1) NOT NULL DEFAULT 'S',
  `icone` varchar(255) NOT NULL,
  `ordem` int(11) NOT NULL,
  `log` char(1) NOT NULL DEFAULT 'S',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=102 ;

--
-- Fazendo dump de dados para tabela `modulo`
--

INSERT INTO `modulo` (`id`, `nome`, `ativo`, `icone`, `ordem`, `log`) VALUES
(1, 'Imóveis', 'S', '<i class="fas fa-home"></i>', 100, 'S'),
(8, 'Banner', 'S', '<i class="fas fa-desktop"></i>', 800, 'S'),
(9, 'Config', 'S', '<i class="fas fa-cog"></i>', 900, 'S'),
(10, 'Usuários', 'S', '<i class="fas fa-users"></i>', 1000, 'S'),
(4, 'Cidades', 'S', '<i class="fab fa-cuttlefish"></i>', 400, 'S'),
(3, 'Tipos', 'S', '<i class="fab fa-tumblr"></i>', 300, 'S'),
(2, 'Finalidades', 'S', '<i class="fab fa-foursquare"></i>', 200, 'S'),
(5, 'Bairros', 'S', '<i class="fab fa-blogger-b"></i>', 500, 'S'),
(6, 'Itens', 'S', '<i class="fab fa-ioxhost"></i>', 600, 'S'),
(7, 'Contatos', 'S', '<i class="far fa-envelope"></i>', 700, 'S'),
(11, 'Webservice', 'S', '<i class="fab fa-mixcloud"></i>', 1100, 'S'),
(12, 'Proprietários', 'S', '<i class="fab fa-jenkins"></i>', 601, 'S'),
(13, 'Logs', 'S', '<i class="far fa-list-alt"></i>', 1200, 'N'),
(100, 'Login', 'N', '', 0, 'S'),
(101, 'Fotos Imóvel', 'N', '', 0, 'S'),
(14, 'Corretores', 'S', '<i class="fas fa-user-tie"></i>', 602, 'S');

-- --------------------------------------------------------

--
-- Estrutura para tabela `modulo_item`
--

CREATE TABLE IF NOT EXISTS `modulo_item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_modulo` int(11) NOT NULL,
  `nome` varchar(150) NOT NULL,
  `menu` char(1) NOT NULL DEFAULT 'S',
  `ativo` char(1) NOT NULL DEFAULT 'S',
  `link` varchar(255) NOT NULL,
  `pg` varchar(100) NOT NULL,
  `log` char(1) NOT NULL DEFAULT 'S',
  `ordem` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=49 ;

--
-- Fazendo dump de dados para tabela `modulo_item`
--

INSERT INTO `modulo_item` (`id`, `id_modulo`, `nome`, `menu`, `ativo`, `link`, `pg`, `log`, `ordem`) VALUES
(1, 1, 'Incluir Imóvel', 'S', 'S', 'index.php?pg=imovel', 'imovel', 'S', 100),
(2, 1, 'Listar Imóveis', 'S', 'S', 'index.php?pg=listar-imoveis', 'listar-imoveis', 'S', 101),
(4, 8, 'Gerenciar Banner', 'S', 'S', 'index.php?pg=banner', 'banner', 'S', 800),
(6, 9, 'Dados Imobiliaria', 'S', 'S', 'index.php?pg=dados-imobiliaria', 'dados-imobiliaria', 'S', 900),
(7, 9, 'Configurações do Site', 'S', 'S', 'index.php?pg=config-site', 'config-site', 'S', 902),
(8, 2, 'Gerenciar Finalidades', 'S', 'S', 'index.php?pg=finalidades', 'finalidades', 'S', 200),
(10, 3, 'Gerenciar Tipos', 'S', 'S', 'index.php?pg=tipos', 'tipos', 'S', 300),
(12, 4, 'Gerenciar Cidades', 'S', 'S', 'index.php?pg=cidades', 'cidades', 'S', 400),
(14, 5, 'Gerenciar Bairros', 'S', 'S', 'index.php?pg=bairros', 'bairros', 'S', 500),
(16, 6, 'Gerenciar Itens', 'S', 'S', 'index.php?pg=itens', 'itens', 'S', 600),
(18, 10, 'Incluir Usuário', 'S', 'S', 'index.php?pg=incluir-usuario', 'incluir-usuario', 'S', 1000),
(19, 10, 'Listar Usuários', 'S', 'S', 'index.php?pg=usuarios', 'usuarios', 'S', 1001),
(21, 7, 'Listar Contatos', 'S', 'S', 'index.php?pg=listar-contatos', 'listar-contatos', 'S', 700),
(22, 9, 'Cores do site', 'S', 'S', 'index.php?pg=layout', 'layout', 'S', 904),
(23, 9, 'Sobre a Imobiliária', 'S', 'S', 'index.php?pg=sobre-imobiliaria', 'sobre-imobiliaria', 'S', 901),
(24, 11, 'Gerenciar Portais', 'S', 'S', '?pg=gerenciar-portais', 'gerenciar-portais', 'S', 1100),
(25, 1, 'Gerenciar Fotos', 'N', 'S', '?ph=gerenciar-fotos', 'gerenciar-fotos', 'S', 0),
(26, 12, 'Incluir Proprietário', 'S', 'S', '?pg=proprietario', 'proprietario', 'S', 1200),
(27, 12, 'Listar Proprietários', 'S', 'S', '?pg=listar-proprietario', 'listar-proprietario', 'S', 1201),
(28, 10, 'Editar Usuário', 'N', 'S', '?pg=editar-usuario', 'editar-usuario', 'S', 0),
(29, 10, 'Perfil', 'N', 'S', '?pg=perfil', 'perfil', 'S', 0),
(30, 13, 'Relatório de Logs', 'S', 'S', '?pg=logs', 'logs', 'N', 1300),
(31, 9, 'Scripts', 'S', 'S', '?pg=scripts', 'scripts', 'S', 903),
(32, 14, 'Incluir Corretor', 'S', 'S', 'index.php?pg=incluir-corretor', 'incluir-corretor', 'S', 1400),
(33, 14, 'Listar Corretores', 'S', 'S', 'index.php?pg=corretores', 'corretores', 'S', 1401),
(34, 14, 'Editar Corretor', 'N', 'S', 'index.php?pg=editar-corretor', 'editar-corretor', 'S', 0),
(35, 9, 'Layout', 'S', 'S', 'index.php?pg=layouts', 'layouts', 'S', 905),
(36, 1, 'Listar Imóveis Pré Cadastrados', 'S', 'S', 'index.php?pg=listar-imoveis-pre-cad', 'listar-imoveis-pre-cad', 'S', 102),
(48, 1, 'Excluir imóvel', 'N', 'S', '', '', 'S', 0),
(47, 1, 'Editar Imóvel', 'N', 'S', 'index.php?pg=imovel', 'imovel', 'S', 0),
(45, 1, 'Ver Dados Imóvel', 'N', 'S', 'index.php?pg=ver-dados-imovel', 'ver-dados-imovel', 'N', 0);

-- --------------------------------------------------------

--
-- Estrutura para tabela `permissao`
--

CREATE TABLE IF NOT EXISTS `permissao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_usuario` int(11) NOT NULL,
  `id_modulo` int(11) NOT NULL,
  `id_modulo_item` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=600 ;

--
-- Fazendo dump de dados para tabela `permissao`
--

INSERT INTO `permissao` (`id`, `id_usuario`, `id_modulo`, `id_modulo_item`) VALUES
(281, 1, 15, 62),
(280, 1, 15, 61),
(279, 1, 15, 60),
(278, 1, 1, 45),
(277, 1, 1, 47),
(276, 1, 1, 48),
(275, 1, 1, 38),
(274, 1, 1, 36),
(273, 1, 9, 35),
(272, 1, 14, 33),
(271, 1, 14, 32),
(270, 1, 9, 31),
(269, 1, 13, 30),
(268, 1, 12, 28),
(267, 1, 12, 27),
(266, 1, 12, 26),
(265, 1, 11, 24),
(264, 1, 9, 23),
(263, 1, 9, 22),
(262, 1, 7, 21),
(261, 1, 10, 19),
(260, 1, 10, 18),
(259, 1, 6, 16),
(258, 1, 5, 14),
(257, 1, 4, 12),
(256, 1, 3, 10),
(255, 1, 2, 8),
(254, 1, 9, 7),
(253, 1, 9, 6),
(252, 1, 8, 4),
(251, 1, 1, 2),
(250, 1, 1, 1),
(249, 1, 0, 28),
(248, 1, 0, 29),
(200, 1, 1, 25),
(247, 1, 0, 34);
-- --------------------------------------------------------

--
-- Estrutura para tabela `portais`
--

CREATE TABLE IF NOT EXISTS `portais` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(255) NOT NULL,
  `arquivo` varchar(40) NOT NULL,
  `chave` varchar(40) NOT NULL,
  `ativo` char(1) NOT NULL DEFAULT 'N',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Fazendo dump de dados para tabela `portais`
--

INSERT INTO `portais` (`id`, `nome`, `arquivo`, `chave`, `ativo`) VALUES
(1, 'Portal Casa Jaú', 'exportador_casajau.php', '3f99bca1729e86f1b93e7ed1484af6ab', 'S');

-- --------------------------------------------------------

--
-- Estrutura para tabela `proprietario`
--

CREATE TABLE IF NOT EXISTS `proprietario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(150) NOT NULL,
  `rg` varchar(30) NOT NULL,
  `cpf` varchar(30) NOT NULL,
  `data_nascimento` date NOT NULL,
  `telefone` varchar(20) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `cidade` varchar(100) NOT NULL,
  `bairro` varchar(100) NOT NULL,
  `cep` varchar(30) NOT NULL,
  `endereco` varchar(255) NOT NULL,
  `detalhes` text NOT NULL,
  `data_cadastro` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2707 ;

--
-- Fazendo dump de dados para tabela `proprietario`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `sobre_empresa`
--

CREATE TABLE IF NOT EXISTS `sobre_empresa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo` varchar(255) NOT NULL,
  `texto` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Fazendo dump de dados para tabela `sobre_empresa`
--

INSERT INTO `sobre_empresa` (`id`, `titulo`, `texto`) VALUES
(1, 'Sobre a Imobiliária', '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipo`
--

CREATE TABLE IF NOT EXISTS `tipo` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nome` varchar(30) NOT NULL,
  `nome_referencia` varchar(100) NOT NULL,
  `tags_usuario` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Fazendo dump de dados para tabela `tipo`
--

INSERT INTO `tipo` (`id`, `nome`, `nome_referencia`, `tags_usuario`) VALUES
(1, 'Casa', 'casa', 'Casas | Casa Térrea | Sobrado | Sobrados | Sobrado   | Casa Nova | Residential / Home| Residential / Condo | Residential / Sobrado | Commercial / Residential Income '),
(3, 'Apartamento', 'apartamento', 'Apartamentos | Temporada | Apto. Alto Padrão  | Cobertura  | Apartamentos - Padrão | Residential / Apartment | Residential / Penthouse '),
(4, 'Sala ou Salão Comercial', 'sala ou salao comercial', 'Comercial/industrial | Sala(ão) Comercial | Salão Comercial | Residencia com salão comercial | Salas Comerciais | Sala Para Consultório Médico | apart. comercial | Apart. Comercial | Sala Comercial | Predio Comercial | Imóvel C/ Comércio | Residencia Com Salão Comercial | Conjunto Comercial | | Salão Na Frente E Casa No Fundo  | Salões Comerciais  | Motel  | Supermercado  | Comercial - Galpão/depósito/barração  | Comercial - Loja/salão | Commercial / Consultorio | Commercial / Office '),
(5, 'Chácara, Sítio ou Fazenda', 'characara, sitio ou fazenda', 'Sítio Ou Chácara | Chácaras | Sítios | Sitios | Rancho | Ranchos | Fazenda | Fazendas | Rural | Chácaras e Sítios | Fazenda/sítio/rancho | Chácara, Sítio ou Rancho | CHACARA / RANCHO | Rancho - Rio Jacaré Sítio | Chácaras | Sítio / Chácara | Fazendas Sítio/Fazenda  | Sítio/fazenda/chacár  | Sítio / Chácara / Fazendas  | Sítio / Chácaras  | Fazenda Ou Sítio  | Chácara Ou Rancho  | Rancho | chacara | siteo | Fazenda/sã­tio/rancho  | Chácara,terreno  | Imóvel Rural  | Chácara/sítio/fazend  | Chácara  | Rural - Chácara  | Rural - Sítio | Residential / Farm Ranch | Commercial / Agricultural '),
(6, 'Edícula', 'edicula', 'Edículas | Ediculas | Edã­cula  | Edicula - Carnaval '),
(8, 'Barracão', 'barracao', 'Barracões | Galpão | Galpões | ÁREAS/GALPÕES INDUSTRIAIS | Galpão Industrial | Salão / Barracão  | Barracão E Terreno  | Galpão  | Barracão Industrial  | Barracão Comercial / Industrial  | Galpões - Empresarial  | Barracão,terreno | Commercial / Industrial '),
(9, 'Kitnet', 'kitnet', 'Kit Net | Kit Net | Kitnet | KIT NET E SALAS COMERCIAIS | Aptos e Kitnets | Kitnete | | Quitinetes  | Kitinete  | Kitnet E Salas Comerciais | Residential / Kitnet '),
(10, 'Pátio ou Estacionamento', 'patio,estacionamento', 'Patio | Estacionamento | GARAGEM VEICULOS | Garagem Caminhoes  | Garagem Mensal  | Pátio/ Garagem De Veículos '),
(11, 'Comercial ou Industrial', 'comercial ou industrial', 'Barracão Ou Comércio | Barracão / Comércio | imóveis comerciais | Sala Para Consultórios  | Hotel  | Fundo De Comércio  | área Industr/transp  | Pousada  | Imóvel Comercial  | Prédio Comercial  | Industrial  | Prédio Com 2 Ou Mais Andares  | Prédio 2 Andares  | Loja Shopping Do Calçado  | Ponto Comercial/industrial |  Commercial / Building'),
(12, 'Flat', 'flat', ' | Flat/aparthotel  | Pousada/flat | Residential / Flat ');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(100) NOT NULL DEFAULT '',
  `senha` varchar(20) NOT NULL DEFAULT '',
  `ativo` char(1) NOT NULL,
  `nome` varchar(30) NOT NULL,
  `avatar` varchar(100) NOT NULL,
  `data_nascimento` date NOT NULL,
  `data_cadastro` datetime NOT NULL,
  `ultimo_login` datetime NOT NULL,
  `tipo` int(1) NOT NULL,
  `detalhes` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=27 ;

--
-- Fazendo dump de dados para tabela `usuario`
--

INSERT INTO `usuario` (`id`, `usuario`, `senha`, `ativo`, `nome`, `avatar`, `data_nascimento`, `data_cadastro`, `ultimo_login`, `tipo`, `detalhes`) VALUES
(1, 'admin', 'admin2391', 'S', 'Admin', 'admin.png', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 3, '');

-- --------------------------------------------------------

--
-- Estrutura para tabela `visualizacao`
--

CREATE TABLE IF NOT EXISTS `visualizacao` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contador` int(11) NOT NULL,
  `data` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Fazendo dump de dados para tabela `visualizacao`
--
