<?php
// Modify ini settings
ini_set('memory_limit', '5000M');
ini_set('max_execution_time', 12000);
ini_set('date.timezone', 'America/Sao_Paulo');

// Report all errors
error_reporting(E_ALL);
set_time_limit(0);


//configurações que viriam do arquivo config.php
$imobiliaria_controle['cliente']   = 'imob.hospedaria.com.br';
$imobiliaria_controle['diretorio'] = 'gomesimoveisjau.com.br';
$imobiliaria_controle['userdb']    = 'rodrgus291r';
$imobiliaria_controle['passdb']    = '92Kfs251Gee1';	
$imobiliaria_controle['basedb']    = 'rodriguesimoveisjau_com_br_1';
define('DIRETORIO', $imobiliaria_controle['diretorio']);
$userdb = $imobiliaria_controle['userdb'];
$passdb = $imobiliaria_controle['passdb'];
$basedb = $imobiliaria_controle['basedb'];
$foto_caminho = "fotos/";
$foto_tamanhos[] = "1300"; //tamanho original da foto
$foto_tamanhos[] = "1300"; //tamanho original da foto
$foto_tamanhos[] = "470";
$foto_tamanhos[] = "310";
$foto_diretorios[] = "original/"; //caminho da foto original
$foto_diretorios[] = "t1/"; //caminho da foto original
$foto_diretorios[] = "t2/";
$foto_diretorios[] = "t3/";
//configurações que viriam do arquivo config.php




// include "../config.php";
include "../conexao.php";

// CONFIGURACOES DO IMPORTADOR

// ESSA VARIAVEL É USADA NA PARTE DAS FOTOS - SE FOR A PRIMEIRA IMPORTAÇÃO O SCRIPT VAI !DELETAR! TODAS AS FOTOS DO BANCO DE DADOS E DIRETÓRIOS
// 1 = SIM | 0 = NÃO
$primeira_importacao = 0;


// URL NAO ACESSIVEL PELO NAVEGADOR
// $url = 'http://www.valuegaia.com.br/integra/midia.ashx?midia=GaiaWebServiceImovel&p=0ENAc2QIdRUX0iygBiJELFDpokk0ZDChUxVbijZoc%2bXwySqfwJtEwL13JYqkti7QruRMsJ6O1aw%3d';
// $url = 'adm/teste_unico.xml';

// Get XML
// $xml = file_get_contents($url);

$url =  'http://gomesimoveisjau.com.br/exportador_casajau_5493145.php';

echo $url;


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_FAILONERROR,1);
// curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
$xmlData = curl_exec($ch);
curl_close($ch);

// Load the XML
$xmlData = str_replace("<![CDATA[", "", $xmlData);
$xmlData = str_replace("]]>", "", $xmlData);
$xml = simplexml_load_string($xmlData);
$json = json_encode($xml);
$properties = json_decode($json,TRUE);
$properties = $properties["imovel"];
// echo "<pre>";
// var_dump($properties);
// echo "</pre>";exit;


// Get the only properties
// $properties = $properties['Listings']['Listing'];

// Reset imported status
// mysql_query('UPDATE imovel SET importado = 0');
	
$qtd = 0;
// echo "contador=".count($properties);exit;
foreach ($properties as $property) {
	$qtd++;
	
	echo "<pre>";
	var_dump($property);
	echo "</pre><hr>";

	// if($qtd > 1){exit;}
	
	echo "<br><br>Importando Imovel ".$property['referencia']."\n<br>";
	
	
	//============================================================================================================
	// ZERO AS VARIAVEIS QUE SERAO USADAS ========================================================================
	$ref 						= "";
	$tipo 			    = "";
	$finalidade     = "";
	$valor_aluguel 	= "";
	$valor_venda 		= "";
	$detalhes 			= "";
	$dormitorios 		= "";
	$suites 				= "";
	$banheiros 			= "";
	$vagas 					= "";
	$area_util 			= "";	
	$area_total			= "";	
	$itens 					= "";
	$estado 	      = "";
	$cidade					= "";
	$bairro   			= "";
	$endereco				= "";
	$cep  					= "";
	
	
	//============================================================================================================
	// PEGA OS DADOS DO XML ================================================================================
  $ref = $property['referencia'];
  $tipo = $property['tipo'];
  if(!$tipo){ continue; }
  $teste_tipo = mysql_query("SELECT nome,id FROM tipo WHERE nome = '$tipo'");
  if(mysql_num_rows($teste_tipo)>0){
    $r_tipo = mysql_fetch_assoc($teste_tipo);
    $tipo = $r_tipo['id'];
  }else{
    mysql_query("INSERT INTO tipo (nome) VALUES ('$tipo')");
    $tipo = mysql_insert_id();
  }
  
  $finalidade = $property['finalidade'];
  if(strtolower($finalidade) == "venda"){
    $finalidade = 1;
    $valor_venda = $property['valor'];
    // continue;	
  }
  else{
    $finalidade = 2;
    $valor_aluguel = $property['valor'];
    echo "<HR>DEU CERTO ALUGUEL<HR>";
  }
  
  
  if(isset($property['descricao'])){$detalhes = urldecode(str_replace("%0D%0A", "", $property['descricao'])); }else{ $detalhes = ''; }
  if(!$detalhes){$detalhes = '';}
  $dormitorios = $property['quartos'];
  @$suites     = $property['Suites'];
  $banheiros   = $property['banheiros'];
  $vagas       = $property['vagas'];
  if(isset($property['areaConstruida']) AND !empty($property['endereco'])){$area_util   = $property['areaConstruida'];}else{$area_util = '';}
  if(isset($property['areaTotal']) 		  AND !empty($property['endereco'])){$area_total = $property['areaTotal'];}else{$area_total = '';}
  
  if(isset($property['estruturas']) AND !empty($property['estruturas'])){
		foreach($property['estruturas']['estrutura'] as $item){
			$s = "SELECT id FROM item WHERE nome = '$item'";
			$q = mysql_query($s);
			if(mysql_num_rows($q)>0){
				$r = mysql_fetch_assoc($q);
				$itens[] = $r["id"];
			}
			else{
				mysql_query("INSERT INTO item (nome) VALUES ('$item')");
				$itens[] = mysql_insert_id();
			}
		}
  }
  
  // $estado   = $property['Location']['State'];
  // $q_estado = mysql_query("SELECT id FROM estado WHERE nome = '$estado'");
  // $r_estado = mysql_fetch_assoc($q_estado);
  // $estado   = $r_estado["id"];
  
  $cidade   = $property['cidade'];
  if($cidade AND strtolower($cidade) != "array"){
    $q_cidade = mysql_query("SELECT id FROM cidade WHERE nome = '$cidade'");
    if(mysql_num_rows($q_cidade)>0){
      $r_cidade = mysql_fetch_assoc($q_cidade);
      $cidade   = $r_cidade["id"];
    }
    else{
      $q_cidade = mysql_query("INSERT INTO cidade (nome, id_estado) VALUES ('$cidade', '$estado')");
      $cidade = mysql_insert_id();
    }
  }
  
  $bairro   = $property['bairro'];
  if($bairro AND strtolower($bairro) != "array"){
    $q_bairro = mysql_query("SELECT id FROM bairro WHERE nome = '$bairro' AND id_cidade = '$cidade'");
    if(mysql_num_rows($q_bairro)>0){
      $r_bairro = mysql_fetch_assoc($q_bairro);
      $bairro   = $r_bairro["id"];
    }
    else{
      $q_bairro = mysql_query("INSERT INTO bairro (nome, id_cidade) VALUES ('$bairro', '$cidade')");
      $bairro = mysql_insert_id();
    }
  }
  
  if(isset($property['endereco']) AND !empty($property['endereco'])){$endereco = $property['endereco'];}else{$endereco = "";}
  if(isset($property['enderobseco'])){$obs = $property['obs'];}else{$obs = '';}
  // $cep = $property['Location']['PostalCode'];
  
  $s_existe = "SELECT id FROM imovel WHERE ref = '$ref'";
  $q_existe = mysql_query($s_existe);
  if(mysql_num_rows($q_existe)>0){
    $acao = "alterar";
    $r_existe = mysql_fetch_assoc($q_existe);
    $id_imovel = $r_existe["id"];
    continue;
  }else{
    $acao = "inserir";
  }
  
  if($acao == "inserir"){
    $s = "INSERT INTO imovel (
    ref,
    id_tipo,
    detalhes,
    obs,
    quarto,
    suite,
    banheiro,
    garagem,
    area_construida,
    terreno,
    id_estado,
    id_cidade,
    id_bairro,
    endereco,
    cep,
    disponivel,
    importado
    ) VALUES (
    '$ref',
    '$tipo',
    '$detalhes',
    '$obs',
    '$dormitorios',
    '$suites',
    '$banheiros',
    '$vagas',
    '$area_util',
    '$area_total',
    '$estado',
    '$cidade',
    '$bairro',
    '$endereco',
    '$cep',
    'S',
    1
    )
    ";
    echo "<br>## ".$s."<br>";
    $q = mysql_query($s);
    $id_imovel = mysql_insert_id();
  }
  elseif($acao == "alterar"){
    $s = "UPDATE imovel SET 
    id_tipo = '$tipo',
    detalhes = '$detalhes',
    obs = '$obs',
    quarto = '$dormitorios',
    suite = '$suites',
    banheiro = '$banheiros',
    garagem = '$vagas',
    area_construida = '$area_util',
    terreno = '$area_total',
    id_estado = '$estado',
    id_cidade = '$cidade',
    id_bairro = '$bairro',
    endereco = '$endereco',
    cep = '$cep',
    disponivel = 'S',
    importado = 1
    WHERE id = '$id_imovel'";
    echo "<br>## ".$s."<br>";
    $q = mysql_query($s);
  }
  
  //ROTINA DA FINALIDADE
  mysql_query("DELETE FROM imovel_finalidade WHERE id_imovel = '$id_imovel'");
  if($valor_venda){
    mysql_query("INSERT INTO imovel_finalidade (id_imovel, id_finalidade, valor, iptu, condominio) VALUES ('$id_imovel', '1', '$valor_venda', '', '')");
  }
  if($valor_aluguel){
    mysql_query("INSERT INTO imovel_finalidade (id_imovel, id_finalidade, valor, iptu, condominio) VALUES ('$id_imovel', '2', '$valor_aluguel', '', '')");
  }
  
	echo "----- FOTOS -----";
  if(!empty($property['fotos']['foto'])){
		echo "<br>tem fotos<br>";
		
    mysql_query("UPDATE foto SET status = 0 WHERE id_imovel = '$id_imovel'");
    
    $posicao = 1;
    $marcadagua = false;
    foreach($property['fotos']['foto'] as $photo){
			echo "Primeira foto -----------------------------<br/>";
      // PEGA O NOME DO ARQUIVO SEM O RESTO DA URL
      $photo_file = explode('/', $photo);
      $foto_nome = end($photo_file); 
      // PEGA O NOME DO ARQUIVO SEM O RESTO DA URL
      $url =  $photo;
      $chb = curl_init();
      curl_setopt($chb, CURLOPT_URL,$photo);
      curl_setopt($chb, CURLOPT_FAILONERROR,1);
      // curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
      curl_setopt($chb, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($chb, CURLOPT_TIMEOUT, 15);
      $foto_binaria = curl_exec($chb);
      curl_close($chb);
      // echo "<hr>Url: ".$photo;
      // echo "<br>RETORNO CURL BINARIO: ".$foto_binaria;
      
      $cheader = curl_init(); 
      curl_setopt($cheader, CURLOPT_URL,            $photo); 
      curl_setopt($cheader, CURLOPT_HEADER,         true); 
      // curl_setopt($cheader, CURLOPT_FOLLOWLOCATION, true);
      curl_setopt($cheader, CURLOPT_NOBODY,         true); 
      curl_setopt($cheader, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($cheader, CURLOPT_RETURNTRANSFER, true); 
      curl_setopt($cheader, CURLOPT_TIMEOUT,        15); 
      $photo_headers = curl_exec($cheader);
      curl_close($cheader);
      // echo "<br>RETORNO CURL HEADER: ".$photo_headers."<hr>";
      
      preg_match('/Last-Modified:(.*)\\n/i', $photo_headers, $encontrados);
      $data_modificacao	= trim($encontrados[1]);
      // preg_match('/content-type:(.*)\\n/i', $r, $encontrados2);
      // $foto_type	= trim($encontrados2[1]);      
      
      $q_teste_foto = mysql_query("SELECT id FROM foto WHERE nome = '$foto_nome' AND data_modificacao = '$data_modificacao' AND id_imovel = '$id_imovel'");
      if(mysql_num_rows($q_teste_foto)<1){ //não encontrou a foto ou foi modificada, portanto deve ser importada
				echo "foto nova e sera importada<br>";
      
        //verifica se o imóvel ja tem uma pasta de fotos
        // if(!is_dir(DIRETORIO.$path)) {	mkdir($path0, 0777, true); } // CRIA O DIRETÓRIO COM A PERMISSÃO NECESSÁRIA
        
        // Verifica se os diretorios dos tamanhos já existem
        foreach($foto_diretorios as $path){
          $pasta = "../clientes/".DIRETORIO."/".$foto_caminho;
          if(!is_dir($pasta)) {	mkdir($pasta, 0777); } // CRIA O DIRETÓRIO COM A PERMISSÃO NECESSÁRIA
          $pasta = "../clientes/".DIRETORIO."/".$foto_caminho.$id_imovel;
          if(!is_dir($pasta)) {	mkdir($pasta, 0777); } // CRIA O DIRETÓRIO COM A PERMISSÃO NECESSÁRIA
          $pasta = "../clientes/".DIRETORIO."/".$foto_caminho.$id_imovel."/".$path;
          if(!is_dir($pasta)) {	mkdir($pasta, 0777); } // CRIA O DIRETÓRIO COM A PERMISSÃO NECESSÁRIA

        }
        
        // PEGA A FOTO E GRAVA NO BANCO DE DADOS E NO DIRETÓRIO
        echo "NOME DA FOTO -> ".$foto_nome."<br>\n";
        
        $pasta = "../clientes/".DIRETORIO."/".$foto_caminho.$id_imovel."/".$foto_diretorios[0];
        $fp = fopen($pasta.$foto_nome, "a");
 
        // Escreve "exemplo de escrita" no bloco1.txt
        $escreve = fwrite($fp, $foto_binaria);
         
        // Fecha o arquivo
        fclose($fp);
        
        mysql_query("INSERT INTO foto (id_imovel, nome, data, posicao, data_modificacao, status) VALUES ('$id_imovel', '$foto_nome', NOW(), '$posicao', '$data_modificacao', 1)");
        
        $diretorio_original = "../clientes/".DIRETORIO."/".$foto_caminho.$id_imovel."/".$foto_diretorios[0];
        $raiz = "../clientes/".DIRETORIO."/";
        for($z=0 ; $z<count($foto_diretorios) ; $z++){
          $diretorio = "../clientes/".DIRETORIO."/".$foto_caminho.$id_imovel."/".$foto_diretorios[$z];
          
          //pulo a foto [0] pois é a foto com tamanho original. Esta foto é gravada acima no move_uploaded_file
          echo "<br>a=".$diretorio_original.$foto_nome."<br>";
          if($z>0){ 
            gera_thumb($diretorio_original.$foto_nome, $diretorio.$foto_nome, $foto_tamanhos[$z], 0, 0, 0);
          }
          if($z == 1 AND $marcadagua == "true"){
            coloca_logo($diretorio.$foto_nome, $raiz.$foto_marca_dagua);
          }
        }
      }
      else{
        $r_nao_modificada = mysql_fetch_assoc($q_teste_foto);
        $id_nao_modificada = $r_nao_modificada["id"];
        mysql_query("UPDATE foto SET status = 1, posicao = '$posicao' WHERE id = '$id_nao_modificada'");
      }
      $posicao++;
    }
    
    
    //DELETA AS FOTOS QUE NAO CONSTAM NO XML
    $s_del = "SELECT * FROM foto WHERE id_imovel = '$id_imovel' AND status = 0";
    $q_del = mysql_query($s_del);
    while($r_del = mysql_fetch_assoc($q_del)){
      $id_foto_del = $r_del["id"];
      $nome_foto_del = $r_del["nome"];
      for($z=0 ; $z<count($foto_diretorios) ; $z++){
        $diretorio = "../clientes/".DIRETORIO."/".$foto_caminho.$id_imovel."/".$foto_diretorios[$z];
        unlink($diretorio.$nome_foto_del);
      }
      mysql_query("DELETE FROM foto WHERE id = '$id_foto_del'");
    }
  }
  // SE O IMÓVEL NAO TEM FOTOS NO XML DELETA TODAS AS FOTOS NO BANCO DE DADOS
  else{
    $deleta_fotos = mysql_query("SELECT nome FROM foto WHERE id_imovel = '$id_imovel'");
    while($rd_fotos = mysql_fetch_assoc($deleta_fotos)){
      $nome_foto_del = $rd_fotos["nome"];
      for($z=0 ; $z<count($foto_diretorios) ; $z++){
        $diretorio = "../clientes/".DIRETORIO."/".$foto_caminho.$id_imovel."/".$foto_diretorios[$z];
        unlink($diretorio.$nome_foto_del);
      }
    }
    mysql_query("DELETE FROM foto WHERE id_imovel = '$id_imovel'");
    
    echo "IMOVEL NAO TEM FOTOS NO XML, TODAS AS FOTOS DO SISTEMA FORAM DELETADAS \n"; 
  }
  // ############################################################################################################################################
	// ############################################################################################################################################
	// ############################################################################################################################################
	
	
  // if($qtd >= 1){exit;}
}
echo "<br>\n";
echo "TOTAL DE IMOVEIS = ".$qtd;


// "Delete" not imported properties
// mysql_query("UPDATE imovel SET disponivel = 'N', data_inativo = NOW() WHERE importado = 0");  

// Close database connection
mysql_close();




// FUNCOES

function gera_thumb($original, $miniatura, $largura, $altura, $larg_maxima, $altu_maxima){
  //FUNCAO USANDO APENAS A GDLIB 
	$system[0]	= substr($original, 0, strlen($original)-4);
	$system[1]	= preg_replace("/[.]/i", "", substr($original, -4));

  while ($system[0] == '') {
      array_shift($system);
  }

	//FAZ A CHECAGEM DO TIPO DA IMAGEM
  if (preg_match('/jpg|jpeg/i', $system[1])) {
      $img_origi = imagecreatefromjpeg($original);
  } // Verifica o tipo da imagem

  if (preg_match('/png/i', $system[1])) {
      $img_origi = imagecreatefrompng($original);
  } // Verifica o tipo da imagem

  if (preg_match('/gif/i', $system[1])) {
      $img_origi = imagecreatefromgif($original);
  } // Verifica o tipo da imagem

  $larg_original = imageSX($img_origi); // Pega as dimensões da imagem original
  $altu_original = imageSY($img_origi); // Pega as dimensões da imagem original 

  if ($largura != 0) { // Calcula a largura proporcional
      $altura = round(($altu_original / $larg_original) * $largura);
      if ($altura > $altu_maxima && $altu_maxima > 0) {
          $altura = $altu_maxima;
      }
  }

  if ($altura != 0) { // Calcula a altura proporcional
      $largura = round(($larg_original / $altu_original) * $altura);
      if ($largura > $larg_maxima && $larg_maxima > 0) {
          $largura = $larg_maxima;
      }
  }

  $dst_img = ImageCreateTrueColor($largura, $altura); // Cria a nova imagem com o novo tamanho
  imagecopyresampled($dst_img, $img_origi, 0, 0, 0, 0, $largura, $altura, $larg_original, $altu_original); // Copia a imagem redimensionada

  if (preg_match("/png/i", $system[1])) {
      imagepng($dst_img, $miniatura);
  } // Gera a imagem de destino conforme a origem

  if (preg_match("/jpg|jpeg/i", $system[1])) {
      imagejpeg($dst_img, $miniatura);
  }

  if (preg_match("/gif/i", $system[1])) {
      imagegif($dst_img, $miniatura);
  }

  imagedestroy($dst_img);
  imagedestroy($img_origi);
}

function coloca_logo($original, $logo){
	$system[0]	= substr($original, 0, strlen($original)-4);
	$system[1]	= preg_replace("/[.]/i", "", substr($original, -4));

  if (preg_match('/jpg|jpeg/i', $system[1])) {
      $img_origi = @imagecreatefromjpeg($original);
      if (!$img_origi) {
          $system[1] = 'gif';
      }
  } // Verifica o tipo da imagem

  if (preg_match('/gif/i', $system[1])) {
      $img_origi = @imagecreatefromgif($original);
      if (!$img_origi) {
          $system[1] = 'png';
      }
  } // Verifica o tipo da imagem

  if (preg_match('/png/i', $system[1])) {
      $img_origi = imagecreatefrompng($original);
  } // Verifica o tipo da imagem

  $size_origi = getimagesize($original);
  $size_logo = getimagesize($logo);

  $logo = imagecreatefrompng($logo);
  imagecopyresampled($img_origi, $logo, $size_origi[0] - ($size_logo[0] + 5), $size_origi[1] - ($size_logo[1] + 5), 0, 0, $size_logo[0], $size_logo[1], $size_logo[0], $size_logo[1]);

  if (preg_match("/jpg|jpeg/i", $system[1])) {
      imagejpeg($img_origi, $original);
  }

  if (preg_match("/gif/i", $system[1])) {
      imagegif($img_origi, $original);
  }

  if (preg_match("/png/i", $system[1])) {
      imagepng($img_origi, $original);
  } // Gera a imagem de destino conforme a origem

  imagedestroy($logo);
  imagedestroy($img_origi);
}
?>