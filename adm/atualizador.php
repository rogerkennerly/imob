<?php
  //esse arquivo � chamado na index
  //esse arquivo faz a atualiza��o autom�tica de campos e valores do banco de dados
  //a nova vers�o precisa ser atualizada manualmente neste arquivo

  include "../conexao.php";
  $s = "SELECT versao_sistema FROM config";
  $q = mysql_query($s);
  $r = mysql_fetch_assoc($q);
  
  $nova_versao = "37";
  
  if($r["versao_sistema"] < $nova_versao){
    
		mysql_query("INSERT INTO `modulo` (`id`, `nome`, `ativo`, `icone`, `ordem`, `log`) VALUES (15, 'Clientes', 'S', '<i class=\"fas fa-user-friends\"></i>', '603', 'S');");
		
		mysql_query("INSERT INTO `modulo_item` (`id`, `id_modulo`, `nome`, `menu`, `ativo`, `link`, `pg`, `log`, `ordem`) VALUES (60, '15', 'Incluir Cliente', 'S', 'S', 'index.php?pg=incluir-cliente', 'incluir-cliente', 'S', '1500');");
		
		mysql_query("INSERT INTO `permissao` (`id`, `id_usuario`, `id_modulo`, `id_modulo_item`) VALUES (NULL, '1', '15', '60');");
		
		mysql_query("INSERT INTO `modulo_item` (`id`, `id_modulo`, `nome`, `menu`, `ativo`, `link`, `pg`, `log`, `ordem`) VALUES (NULL, '15', 'Listar Clientes', 'S', 'S', '?pg=listar-cliente', 'listar-cliente', 'S', '1501');");
		
		mysql_query("INSERT INTO `permissao` (`id`, `id_usuario`, `id_modulo`, `id_modulo_item`) VALUES (NULL, '1', '15', '61');");
		
		mysql_query("INSERT INTO `modulo_item` (`id`, `id_modulo`, `nome`, `menu`, `ativo`, `link`, `pg`, `log`, `ordem`) VALUES (NULL, '15', 'Preferencias do Cliente', 'N', 'S', '?pg=preferencias-cliente', 'preferencias-cliente', 'S', '1501');");
		
		mysql_query("CREATE TABLE `cliente_preferencia` (`id` int(11) NOT NULL, `id_cliente` int(11) NOT NULL, `cidades` varchar(255) NOT NULL, `bairros` varchar(255) NOT NULL, `tipos` varchar(255) NOT NULL, `finalidades` varchar(255) NOT NULL, `valor_max` float(13,2) NOT NULL, `valor_min` float(13,2) NOT NULL, `quartos` int(11) NOT NULL, `suites` int(11) NOT NULL, `banheiros` int(11) NOT NULL, `garagem` int(11) NOT NULL, `area_total` int(11) NOT NULL, `area_util` int(11) NOT NULL, `itens` varchar(255) NOT NULL, `data` datetime NOT NULL) ENGINE=InnoDB DEFAULT CHARSET=latin1;");
		
		mysql_query("ALTER TABLE `cliente_preferencia` ADD PRIMARY KEY (`id`);");
		
		mysql_query("CREATE TABLE `cliente` ( `id` int(11) NOT NULL, `nome` varchar(150) NOT NULL, `rg` varchar(30) NOT NULL, `cpf` varchar(30) NOT NULL, `data_nascimento` date NOT NULL, `telefone` varchar(20) NOT NULL, `celular` varchar(20) NOT NULL, `email` varchar(100) NOT NULL, `cidade` varchar(100) NOT NULL, `bairro` varchar(100) NOT NULL, `cep` varchar(30) NOT NULL, `endereco` varchar(255) NOT NULL, `detalhes` text NOT NULL, `data_cadastro` datetime NOT NULL) ENGINE=MyISAM DEFAULT CHARSET=latin1;");
		
		mysql_query("ALTER TABLE `cliente` ADD PRIMARY KEY (`id`);");
		
		mysql_query("ALTER TABLE `cliente` CHANGE `id` `id` INT( 11 ) NOT NULL AUTO_INCREMENT ;");
		
		mysql_query("ALTER TABLE `cliente_preferencia` CHANGE `id` `id` INT( 11 ) NOT NULL AUTO_INCREMENT ;");
  }
		
  
  $nova_versao = "38";
  
  if($r["versao_sistema"] < $nova_versao){
		//--------------------------------------------------------------------------------------------------- 3.8
		
		mysql_query("ALTER TABLE `config` ADD `restricao_clientes` CHAR(1) NOT NULL DEFAULT 'S' AFTER `restricao_proprietarios`;");
		
		mysql_query("ALTER TABLE `cliente` ADD `id_corretor` INT NOT NULL AFTER `id`;");
    
    mysql_query("UPDATE config SET versao_sistema = '$nova_versao'");
	}
?>
