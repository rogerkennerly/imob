<?php
	header("Content-type: text/xml; charset=utf-8");
	error_reporting(E_ERROR);
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
  
  $teste = mysql_query("SELECT chave FROM portais WHERE id = '1'");
  $r_teste = mysql_fetch_assoc($teste);
  
  if($_GET["chave"] != $r_teste["chave"]){
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    echo "<erro>Acesso negado! ";
    echo "Chave de acesso invalida ou Webservice desativado.</erro>";
    exit;
  }
  
  
	//Configure o endereço do site
  $dominio= $_SERVER['HTTP_HOST'];
  $end_site = "http://" . $dominio."/";

	
	//Cabeçalho do arquivo XML
	$xml	= "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n
		<!-- Arquivo gerado em ".date('Y-m-d H:i')." -->\n
		<imoveis>\n";
    echo $xml; $xml = '';
    
    
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
	while($res_imoveis	= mysql_fetch_assoc($sel_imoveis) ){
		$id_imovel	= $res_imoveis['id'];
    $s = "SELECT * FROM imovel_finalidade WHERE id_imovel = '$id_imovel'";
    $q = mysql_query($s);
    while($r_fin = mysql_fetch_assoc($q)){
		//inicio do node deste imóvel no XML
		$xml	.= "			  <imovel>\n";
		$xml	.= "				<referencia>".$res_imoveis['ref']."</referencia>\n";
		$xml	.= "				<tipo>".$tipo[$res_imoveis['id_tipo']]."</tipo>\n";
		$xml	.= "				<finalidade>".$finalidade[$r_fin['id_finalidade']]."</finalidade>\n";
		// $xml	.= "				<video>".urlencode($res_imoveis['YOUTUBE'])."</video>\n";
		$xml	.= "				<cidade>".$bairro[$res_imoveis['id_bairro']][1]."</cidade>\n";
		$xml	.= "				<bairro>".$bairro[$res_imoveis['id_bairro']][0]."</bairro>\n";
		$xml	.= "				<valor>".number_format($r_fin['valor'], 2, '.', '')."</valor>\n";
		$xml	.= "				<financiamento>".$res_imoveis['financia']."</financiamento>\n";
		
		//Se o campo no banco de dados está vazio, tenta pegar o valor do campo detalhes
		if( $res_imoveis['quarto']=='0' ){ 
			preg_match('/([0-9]) dormitórios/i', $res_imoveis['detalhes'], $quartos);
			if( is_numeric($quartos[1]) ){
				$xml	.= "				<quartos>".$quartos['1']."</quartos>\n";
			}
		} else {
			$xml	.= "				<quartos>".$res_imoveis['quarto']."</quartos>\n";
		}
		//Se o campo no banco de dados está vazio, tenta pegar o valor do campo detalhes
		if( $res_imoveis['banheiro']=='0' ){ 
			preg_match('/([0-9])? WC/i', $res_imoveis['detalhes'], $banheiros);
			if( is_numeric($banheiros[1]) ){
				$xml	.= "				<banheiros>".$banheiros['1']."</banheiros>\n";
			} elseif( !empty($banheiros[0]) ) { // Se não encontrou o número de banheiros, mas encontrou a palavra WC, então tem pelo menos 1 banheiro
				$xml	.= "				<banheiros>1</banheiros>\n";
			}
		} else {
			$xml	.= "				<banheiros>".$res_imoveis['banheiro']."</banheiros>\n";
		}
		//Se o campo no banco de dados está vazio, tenta pegar o valor do campo detalhes
		if( $res_imoveis['garagem']=='0' ){ 
			preg_match('/([0-9]) auto/i', $res_imoveis['detalhes'], $vagas);
			if( is_numeric($vagas[1]) ){
				$xml	.= "				<vagas>".$vagas['1']."</vagas>\n";
			}
		} else {
			$xml	.= "				<vagas>".$res_imoveis['garagem']."</vagas>\n";
		}
		//Se o campo no banco de dados está vazio, tenta pegar o valor do campo detalhes
		if( !is_numeric($res_imoveis['area_construida']) || $res_imoveis['area_construida']==0 ){ 
			preg_match('/([0-9]+)[ ]+m2[ ]+[(]área construída[)]/i', $res_imoveis['detalhes'], $areac);
			if( is_numeric($areac[1]) ){
				$xml	.= "				<areaConstruida>".$areac['1']."</areaConstruida>\n";
			}
		} else {
			$xml	.= "				<areaConstruida>".$res_imoveis['area_construida']."</areaConstruida>\n";
		}
		//Se o campo no banco de dados está vazio, tenta pegar o valor do campo detalhes
		if( !is_numeric($res_imoveis['terreno']) || $res_imoveis['terreno']==0 ){ 
			preg_match('/([0-9]+)[ ]+m2[ ]+[(]terreno[)]/i', $res_imoveis['detalhes'], $areat);
			if( is_numeric($areat[1]) ){
				$xml	.= "				<areaTotal>".$areat['1']."</areaTotal>\n";
			}
		} else {
			$xml	.= "				<areaTotal>".$res_imoveis['terreno']."</areaTotal>\n";
		}

		$xml	.= "				<descricao><![CDATA[";
		if(!empty($res_imoveis['COMPLEMENTO']) ){ $xml	.= "* OBS ref. ao Valor do anúncio: ".$res_imoveis['COMPLEMENTO'].".".urlencode("<br>")."  \n"; }
		$xml	.= preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $res_imoveis['detalhes']);
		$xml	.= "]]></descricao>\n";

		$xml	.= "				<estruturas>\n";
		if( $res_imoveis['suite']>0 ){ 				$xml	.= "					<estrutura>Suíte</estrutura>\n"; }
		$sel_itens	= mysql_query("SELECT * FROM imovel_item WHERE id_imovel='".$res_imoveis['id']."'");
		while( $res_itens	= mysql_fetch_assoc($sel_itens) ){
			$sel_item	= mysql_query("SELECT * FROM item WHERE id='".$res_itens['id']."'");
			$res_item	= mysql_fetch_assoc($sel_item);
			$xml	.= "					<estrutura>".$res_item['nome']."</estrutura>\n";
		}
		$xml	.= "				</estruturas>\n";
		
		// Exportação das FOTOS do imóvel. Tenta a foto gigante, senão vai na foto grande "normal"
		$xml	.= "				<fotos>\n";
        $sql_ft = "SELECT nome FROM foto WHERE id_imovel = '$id_imovel' ORDER BY posicao";
        $q_ft = mysql_query($sql_ft);
            $caminho	= 'clientes/'.DIRETORIO.'/fotos/'.$id_imovel.'/t1/';
        while($r_ft = mysql_fetch_assoc($q_ft)){
            $file = $r_ft["nome"];
                    $xml	.= "					<foto>".$end_site.$caminho.$file."</foto>\n";
        }
    
		$xml	.= "				</fotos>\n";

		//fim do node deste imóvel no XML
		$xml	.= "			</imovel>\n";
        
        echo $xml; $xml = '';
	
    }
  }
	$xml	.= "<!-- Fim do processamento ".date('Y-m-d H:i')." -->\n";
	$xml	.= "</imoveis>\n";
		
    echo $xml; $xml = '';

?>
