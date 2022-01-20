<?php
	// error_reporting(E_ERROR);
	// ****************************************************************************
	// Exportador de informações via XML - Portal Casa Jaú - www.casajau.com.br
	// 
	// ESTA VERSÃO EXPORTA TODOS IMÓVEIS ATIVOS <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
	//
	// http://www.casajau.com.br/ajuda/imporatao-xml-padrao
	// ****************************************************************************
	
	// Conexão com o Banco de Dados
	include_once('../config.php');
	include_once('../conexao.php');
  
  
  // $teste = mysql_query("SELECT chave FROM portais WHERE id = '1'");
  // $r_teste = mysql_fetch_assoc($teste);
  
  // if($_GET["chave"] != $r_teste["chave"]){
    // echo "<erro>Acesso negado! ";
    // echo "Chave de acesso invalida ou Webservice desativado.</erro>";
    // exit;
  // }
  
  
	//Configure o endereço do site
  $dominio= $_SERVER['HTTP_HOST'];
  $end_site = "http://" . $dominio."/";

  $xml = array();
  
  $s = "SELECT id_portal, usuario_portal FROM dados_imobiliaria";
  $q = mysql_query($s);
  $r = mysql_fetch_assoc($q);
  
  $xml["credenciais"]["codigo"] = $r["id_portal"];
  $xml["credenciais"]["usuario"]= $r["usuario_portal"];
  
	// Monta arrays com os tipos, classificações, cidades e bairros
	$sel_tipos	= mysql_query("SELECT * FROM tipo ORDER BY id ASC");
	while( $res_tipos = mysql_fetch_assoc($sel_tipos) ){
		$tipo[$res_tipos['id']] = $res_tipos['nome'];
	}
	$sel_classis	= mysql_query("SELECT * FROM finalidade ORDER BY id ASC");
	while( $res_classis = mysql_fetch_assoc($sel_classis) ){
		$finalidade[$res_classis['id']] = $res_classis['nome'];
	}
	$sel_cidades	= mysql_query("SELECT * FROM cidade ORDER BY id ASC");
	while( $res_cidades = mysql_fetch_assoc($sel_cidades) ){
		$cidade[$res_cidades['id']] = $res_cidades['nome'];
	}
	$sel_bairros	= mysql_query("SELECT * FROM bairro ORDER BY id ASC");
	while( $res_bairros = mysql_fetch_assoc($sel_bairros) ){
		$bairro[$res_bairros['id']][0] = $res_bairros['nome'];
		$bairro[$res_bairros['id']][1] = $cidade[$res_bairros['id_cidade']];
		$bairro[$res_bairros['id']][2] = $res_bairros['id_cidade'];
  }

	// Percorre todos os imóveis ativos para montar o XML
	$sel_imoveis	= mysql_query("SELECT * FROM imovel WHERE disponivel='S' AND ref<>'' ORDER BY id ASC");
  $x=0;
	while($res_imoveis	= mysql_fetch_assoc($sel_imoveis) ){
		$id_imovel	= $res_imoveis['id'];
    $s = "SELECT * FROM imovel_finalidade WHERE id_imovel = '$id_imovel'";
    $q = mysql_query($s);
    while($r_fin = mysql_fetch_assoc($q)){
      //inicio do node deste imóvel no XML
      $xml["imoveis"]["imovel"][$x]["referencia"]     = $res_imoveis['ref'];
      $xml["imoveis"]["imovel"][$x]["tipo"]	          = $tipo[$res_imoveis['id_tipo']];
      $xml["imoveis"]["imovel"][$x]["finalidade"]     = $finalidade[$r_fin['id_finalidade']];
      $xml["imoveis"]["imovel"][$x]["cidade"]	        = $bairro[$res_imoveis['id_cidade']][1];
      $xml["imoveis"]["imovel"][$x]["bairro"]         = $bairro[$res_imoveis['id_bairro']][0];
      $xml["imoveis"]["imovel"][$x]["endereco"]       = $res_imoveis['endereco'];
      $xml["imoveis"]["imovel"][$x]["valor"]	        = number_format($r_fin['valor'], 2, '.', '');
      $xml["imoveis"]["imovel"][$x]["financiamento"]  = $res_imoveis['financia'];
      $xml["imoveis"]["imovel"][$x]["quartos"]	      = $res_imoveis['quarto'];
      $xml["imoveis"]["imovel"][$x]["suites"]	        = $res_imoveis['suite'];
      $xml["imoveis"]["imovel"][$x]["banheiros"]	    = $res_imoveis['banheiro'];
      $xml["imoveis"]["imovel"][$x]["vagas"]	        = $res_imoveis['garagem'];
      $xml["imoveis"]["imovel"][$x]["areaConstruida"] = $res_imoveis['area_construida'];
      $xml["imoveis"]["imovel"][$x]["areaTotal"]	    = $res_imoveis['terreno'];
      $xml["imoveis"]["imovel"][$x]["descricao"]	    = $res_imoveis['detalhes'];
      $xml["imoveis"]["imovel"][$x]["video"]	        = urlencode($res_imoveis['video']);

      $sel_itens	= mysql_query("SELECT * FROM imovel_item WHERE id_imovel='".$res_imoveis['id']."'");
      while( $res_itens	= mysql_fetch_assoc($sel_itens) ){
        $sel_item	= mysql_query("SELECT * FROM item WHERE id='".$res_itens['id']."'");
        $res_item	= mysql_fetch_assoc($sel_item);
        $xml["imoveis"]["imovel"][$x]["estruturas"]["estrutura"] = $res_item['nome'];
      }
      
      // Exportação das FOTOS do imóvel. Tenta a foto gigante, senão vai na foto grande "normal"
      $id_imovel	= $res_imoveis['id'];
      $sql_ft = "SELECT nome FROM foto WHERE id_imovel = '$id_imovel' ORDER BY posicao";
      $q_ft = mysql_query($sql_ft);
      $caminho	= 'clientes/'.DIRETORIO.'/fotos/'.$id_imovel.'/t1/';
      while($r_ft = mysql_fetch_assoc($q_ft)){
        $file = $r_ft["nome"];
        $xml["imoveis"]["imovel"][$x]['fotos']['foto'] = $end_site.$caminho.$file;
      }
      $x++;
    }
  }
	$xml = json_encode($xml);	
  // echo "<pre>";  
  echo $xml;
  // echo "</pre>";
  

?>
