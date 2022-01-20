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
	
	//Configure o endereço do site
	$end_site	= 'http://www.gomesimoveisjau.com.br/'; //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<


	// Conexão com o Banco de Dados
	include_once('i_adm/connection.php');

	
	//Cabeçalho do arquivo XML
	$xml	= "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n
		<!-- Arquivo gerado em ".date('Y-m-d H:i')." -->\n
		<imoveis>\n";
	
	// Monsta arrays com os tipos, classificações, cidades e bairros
	$sel_tipos	= mysql_query("SELECT * FROM tipos ORDER BY CODIGO ASC");
	while( $res_tipos = mysql_fetch_assoc($sel_tipos) ){
		$tipo[$res_tipos['CODIGO']] = $res_tipos['TIPO'];
	}
	$sel_classis	= mysql_query("SELECT * FROM classif ORDER BY CODIGO ASC");
	while( $res_classis = mysql_fetch_assoc($sel_classis) ){
		$classi[$res_classis['CODIGO']] = $res_classis['CLASSI'];
	}
	$sel_cidades	= mysql_query("SELECT * FROM cidades ORDER BY CODIGO ASC");
	while( $res_cidades = mysql_fetch_assoc($sel_cidades) ){
		$cidade[$res_cidades['CODIGO']] = $res_cidades['CIDADE'];
	}
	$sel_bairros	= mysql_query("SELECT * FROM bairros ORDER BY CODIGO ASC");
	while( $res_bairros = mysql_fetch_assoc($sel_bairros) ){
		$bairro[$res_bairros['CODIGO']][0] = $res_bairros['BAIRRO'];
		$bairro[$res_bairros['CODIGO']][1] = $cidade[$res_bairros['CODCIDADE']];
		
		if( empty($bairro[$res_bairros['CODIGO']][0]) ){ $bairro[$res_bairros['CODIGO']][0] = 'Centro'; }
	}

	// Percorre todos os imóveis ativos para montar o XML
	$sel_imoveis	= mysql_query("SELECT * FROM imoveis WHERE ATIVO='S' AND VENDIDO<>'S' AND NUMREF<>'' ORDER BY CODIGO ASC");
	while($res_imoveis	= mysql_fetch_assoc($sel_imoveis) ){
		//inicio do node deste imóvel no XML
		$xml	.= "			<imovel>\n";
		$xml	.= "				<referencia>".utf8_encode($res_imoveis['NUMREF'])."</referencia>\n";
		$xml	.= "				<tipo>".utf8_encode($classi[$res_imoveis['CODCLASSI']])."</tipo>\n";
		$xml	.= "				<finalidade>".utf8_encode($tipo[$res_imoveis['CODTIPO']])."</finalidade>\n";
		$xml	.= "				<cidade>".utf8_encode($bairro[$res_imoveis['CODBAIRRO']][1])."</cidade>\n";
		$xml	.= "				<bairro>".utf8_encode($bairro[$res_imoveis['CODBAIRRO']][0])."</bairro>\n";
		$xml	.= "				<valor>".utf8_encode(number_format($res_imoveis['VALOR'], 2, '.', ''))."</valor>\n";
		$xml	.= "				<financiamento>".$res_imoveis['FINANCIA']."</financiamento>\n";
		
		//Se o campo no banco de dados está vazio, tenta pegar o valor do campo detalhes
		if( $res_imoveis['QUARTO']=='0' ){ 
			preg_match('/([0-9]) dormitórios/i', utf8_encode($res_imoveis['DETALHES']), $quartos);
			if( is_numeric($quartos[1]) ){
				$xml	.= "				<quartos>".utf8_encode($quartos['1'])."</quartos>\n";
			}
		} else {
			$xml	.= "				<quartos>".utf8_encode($res_imoveis['QUARTO'])."</quartos>\n";
		}
		//Se o campo no banco de dados está vazio, tenta pegar o valor do campo detalhes
		if( $res_imoveis['BANHEIRO']=='0' ){ 
			preg_match('/([0-9])? WC/i', $res_imoveis['DETALHES'], $banheiros);
			if( is_numeric($banheiros[1]) ){
				$xml	.= "				<banheiros>".utf8_encode($banheiros['1'])."</banheiros>\n";
			} elseif( !empty($banheiros[0]) ) { // Se não encontrou o número de banheiros, mas encontrou a palavra WC, então tem pelo menos 1 banheiro
				$xml	.= "				<banheiros>1</banheiros>\n";
			}
		} else {
			$xml	.= "				<banheiros>".utf8_encode($res_imoveis['BANHEIRO'])."</banheiros>\n";
		}
		//Se o campo no banco de dados está vazio, tenta pegar o valor do campo detalhes
		if( $res_imoveis['GARAGEM']=='0' ){ 
			preg_match('/([0-9]) auto/i', $res_imoveis['DETALHES'], $vagas);
			if( is_numeric($vagas[1]) ){
				$xml	.= "				<vagas>".utf8_encode($vagas['1'])."</vagas>\n";
			}
		} else {
			$xml	.= "				<vagas>".utf8_encode($res_imoveis['GARAGEM'])."</vagas>\n";
		}
		//Se o campo no banco de dados está vazio, tenta pegar o valor do campo detalhes
		if( !is_numeric($res_imoveis['AREACONSTRU']) || $res_imoveis['AREACONSTRU']==0 ){ 
			preg_match('/([0-9]+)[ ]+m2[ ]+[(]área construída[)]/i', utf8_encode($res_imoveis['DETALHES']), $areac);
			if( is_numeric($areac[1]) ){
				$xml	.= "				<areaConstruida>".utf8_encode($areac['1'])."</areaConstruida>\n";
			}
		} else {
			$xml	.= "				<areaConstruida>".utf8_encode($res_imoveis['AREACONSTRU'])."</areaConstruida>\n";
		}
		//Se o campo no banco de dados está vazio, tenta pegar o valor do campo detalhes
		if( !is_numeric($res_imoveis['METROQ']) || $res_imoveis['METROQ']==0 ){ 
			preg_match('/([0-9]+)[ ]+m2[ ]+[(]terreno[)]/i', utf8_encode($res_imoveis['DETALHES']), $areat);
			if( is_numeric($areat[1]) ){
				$xml	.= "				<areaTotal>".utf8_encode($areat['1'])."</areaTotal>\n";
			}
		} else {
			$xml	.= "				<areaTotal>".utf8_encode($res_imoveis['METROQ'])."</areaTotal>\n";
		}

		$xml	.= "				<descricao>";
		if(!empty($res_imoveis['COMPLEMENTO']) ){ $xml	.= "* OBS: Valor do anúncio ".utf8_encode($res_imoveis['COMPLEMENTO']).".".urlencode("<br>")."\n"; }
		$xml	.= utf8_encode($res_imoveis['DETALHES']);
		$xml	.= "</descricao>\n";

		$xml	.= "				<estruturas>\n";
		if( $res_imoveis['SUITE']>0 ){ 				$xml	.= "					<estrutura>Suíte</estrutura>\n"; }
		if( $res_imoveis['COPA']>0 ){ 				$xml	.= "					<estrutura>Copa</estrutura>\n"; }
		if( $res_imoveis['DISPENSA']>0 ){ 			$xml	.= "					<estrutura>Despensa</estrutura>\n"; }
		if( $res_imoveis['PISCINA']=='S' ){			$xml	.= "					<estrutura>Piscina</estrutura>\n"; }
		if( $res_imoveis['SAUNA']=='S' ){ 			$xml	.= "					<estrutura>Sauna</estrutura>\n"; }
		if( $res_imoveis['EDICULA']=='S' ){		 	$xml	.= "					<estrutura>Edícula</estrutura>\n"; }
		if( $res_imoveis['CHURRASQUEIRA']=='S' ){	$xml	.= "					<estrutura>Churrasqueira</estrutura>\n"; }
		if( $res_imoveis['PORTAOE']=='S' ){			$xml	.= "					<estrutura>Portão Eletrônico</estrutura>\n"; }
		if( $res_imoveis['LANCAMENTO']=='S' ){		$xml	.= "					<estrutura>Lançamento</estrutura>\n"; }
		if( $res_imoveis['ALTOPADRAO']=='S' ){		$xml	.= "					<estrutura>Alto Padrão</estrutura>\n"; }
		if( $res_imoveis['JDINVERNO']=='S' ){		$xml	.= "					<estrutura>Jardim de Inverno</estrutura>\n"; }
		if( $res_imoveis['CLOSET']=='S' ){			$xml	.= "					<estrutura>Closet</estrutura>\n"; }
		$xml	.= "				</estruturas>\n";
		
		// Exportação das FOTOS do imóvel. Tenta a foto gigante, senão vai na foto grande "normal"
		$xml	.= "				<fotos>\n";
		$id_imovel	= $res_imoveis['CODIGO'];
		$num_fotos	= 0;
		$caminho	= 'fotos/O/'.$id_imovel.'/';
		if ($fotos = opendir($caminho)) {
			while (false !== ($file = readdir($fotos))) {
				if( is_file($caminho.$file) ){
					$var_fotos[$num_fotos]	= $file;
					$num_fotos++;
				}
			}
			sort($var_fotos);
			foreach($var_fotos as $file){
				$xml	.= "					<foto>".$end_site.$caminho.$file."</foto>\n";
			}
			closedir($fotos);
		} 
		if( $num_fotos==0 ){
			$caminho	= 'imoveis/'.$id_imovel.'/';
			if ($fotos = opendir($caminho)) {
				while (false !== ($file = readdir($fotos))) {
					if( is_file($caminho.$file) ){
						$var_fotos[$num_fotos]	= $file;
						$num_fotos++;
					}
				}
				sort($var_fotos);
				foreach($var_fotos as $file){
					$xml	.= "					<foto>".$end_site.$caminho.$file."</foto>\n";
				}
				closedir($fotos);
			} 
		}
		unset($var_fotos);
		$xml	.= "				</fotos>\n";

		//fim do node deste imóvel no XML
		$xml	.= "			</imovel>\n";
	}
	$xml	.= "<!-- Fim do processamento ".date('Y-m-d H:i')." -->\n";
	$xml	.= "</imoveis>\n";
		
	echo $xml;

?>