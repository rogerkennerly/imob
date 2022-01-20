<?php
  function listar($tabela){
    $s = "SELECT * FROM $tabela";
    $q = mysql_query($s);
    return $q;
  }
  
  function listar_unico($tabela, $id){
    $s = "SELECT * FROM $tabela WHERE id = '$id'";
    $q = mysql_query($s);
    $r = mysql_fetch_assoc($q);
    return $r;
  }
  
  function retorna_nome($tabela, $id){
    $s = "SELECT nome FROM $tabela WHERE id = '$id'";
    $q = mysql_query($s);
    $r = mysql_fetch_assoc($q);
    return $r["nome"];
  }
  
  function retorna_campo($tabela, $campo, $id){
    $s = "SELECT $campo FROM $tabela WHERE id = '$id'";
    $q = mysql_query($s);
    $r = mysql_fetch_assoc($q);
    return $r[$campo];
  }
  
  function item_listar($id_imovel){
    $s = "SELECT * FROM imovel_item WHERE id_imovel = '$id_imovel'";
    $q = mysql_query($s);
    while($r = mysql_fetch_assoc($q)){
      $itens[] = $r["id_item"];
    }
    return $itens;
  }
  
  function finalidade_listar($id_imovel){
    $s = "SELECT * FROM imovel_finalidade WHERE id_imovel = '$id_imovel'";
    $q = mysql_query($s);
    while($r = mysql_fetch_assoc($q)){
      $finalidades[] = $r["id_finalidade"];
    }
    return $finalidades;
  }
  
  function finalidade_listar_unico($id_imovel){
    $s = "SELECT * FROM imovel_finalidade WHERE id_imovel = '$id_imovel'";
    $q = mysql_query($s);
    $finalidade = "";
    while($r = mysql_fetch_assoc($q)){
      if($finalidade){echo " | ";}
      $finalidade = retorna_nome("finalidade", $r["id_finalidade"]);
      echo $finalidade;
    }
  }
  
  function avatar($id, $tamanho){
    $s = "SELECT avatar FROM usuario WHERE id = '$id'";
    $q = mysql_query($s);
    $r = mysql_fetch_assoc($q);
    return $r["avatar"];
  }
  
  
  function toltip($frase){
    return "
    <span class='nav-list'>
      <span class='badge badge-transparent tooltip-error' title='$frase'>
        <i class='icon-warning-sign red bigger-130'></i>
      </span>
    </span>
    ";
  }
  
  function alerta($frase){
    return "
      <div class='alert alert-block alert-danger'>
        <button type='button' class='close' data-dismiss='alert'>
          <i class='icon-remove'></i>
        </button>
        <i class='icon-remove red'></i>
        $frase
      </div>
    ";
  }
  
  function sucesso($frase){
    return "
      <div class='alert alert-block alert-sucess'>
        <button type='button' class='close' data-dismiss='alert'>
          <i class='icon-remove'></i>
        </button>
        <i class='icon-ok green'></i>
        $frase
      </div>
    ";
  }
  

  
  function deltree($delpath){
    if ( is_dir($delpath) == true )
    { $handle=opendir($delpath);    
      while (($file = readdir($handle))!==false)
      { if ($file != "." && $file != "..")
        { if (filetype($delpath."/".$file) == "dir")
          { deltree($delpath."/".$file);
            if (is_dir($delpath."/".$file)) { rmdir($delpath."/".$file); }
          } else 
          { unlink($delpath."/".$file); }
        }
      }
      closedir($handle);
      if (is_dir($delpath)) { rmdir($delpath); }
    }
  }

	function tratar_moeda($valor, $tipo){ 
	 //funcao que trata valores da moeda em 2 modos
	 //tipo -> 1 = arruma para mandar no banco 
	 //tipo -> 2 = mostra no site

	 if($tipo == 1){  //formato para gravar no banco -> R$ 1.500,00 = 1500.00
		$valor = str_replace(".","",$valor);
		$valor = str_replace(",",".",$valor);
	 }
	 else{ // tipo = 2 -> formato para resgatar a informa��o do banco e mostrar no site -> 1500.00 = 1.500,00
		$valor = number_format($valor, 2, ',', '.'); // retorna R$100.000,50
	 }
	 
	 return $valor;
	}
  
  function tratar_data($valor, $tipo){
    //funcao que trata a Data
    //tipo = 1 -> data para gravar no banco -> 2012-10-07
    //tipo = 2 -> data do banco para o admin -> 07/10/2012
    if($tipo == 1){
      $dd = explode("/",$valor);
      $xdia = $dd[0];
      $xmes = $dd[1];
      $xano = $dd[2];
      $data = $xano."-".$xmes."-".$xdia;
      return $data;
    }else{
      $dd = explode("-",$valor);
      $xdia = $dd[2];
      $xmes = $dd[1];
      $xano = $dd[0];
      $data = $xdia."/".$xmes."/".$xano;
      return $data;
    }
  }
  
  function tratar_data_hora($valor){
      $data = explode(" ",$valor);
      $value = $data[0];
      $hora = $data[1];
      $dd = explode("-",$value);
      $xdia = $dd[2];
      $xmes = $dd[1];
      $xano = $dd[0];
      $data = $xdia."/".$xmes."/".$xano;
      return $data." ".$hora ;
  }
  
  function evita_injection($valor, $limite=0, $tipo='', $pathlog=''){
		//**************************************************************************************************************************************************************************************
		//Como usar: evita_injection('Valor do campo', 'limite de caracteres PADR�O: ilimitado', 'tipo de valor - I=apenas n�meros e menos, F=n�meros v�rgula ponto e menos, T=tudo(texto) PADR�O: T');
		//**************************************************************************************************************************************************************************************

		// Guarda valor passado para fins de LOG
		$valor_ant = $valor;
		$log_comp  = '';
		
		//Verifica se h� limite especificado
    settype($limite,'integer');
		if($limite > 0){
			if(strlen($valor)>$limite){ $log_comp	.= "String maior que limite (string: ".strlen($valor)." - limite: ".$limite."); "; }
			$valor = substr($valor, 0, $limite);
		}
		//Procura por caracteres inv�lidos e loga se encontrar
		//if(eregi("[#$%&*|=]", $valor)){ $log_comp	.= "String cont�m caracteres inv�lidos [#$%&*|=]; "; }
    //$valor = eregi_replace("[#$%&*|=]", "", $valor);
    if(preg_match('/[#$%&*|=]/', $valor)){ $log_comp	.= 'String cont�m caracteres inv�lidos [#$%&*|=]; '; }
		$valor = preg_replace('/[#$%&*|=]/i', '', $valor);
		
		//Procura por comandos SQL
		//if(eregi("(select|join|union|update|drop)[ ].", $valor)){ $log_comp	.= "String cont�m comandos SQL (select|join|union|update|drop); "; }
		//$valor = eregi_replace("(select|join|union|update|drop)[ ].", "", $valor);
    if(preg_match('/(select|join|union|update|drop)[ ]+/i', $valor)){ $log_comp	.= 'String cont�m comandos SQL (select|join|union|update|drop); '; }
		$valor = preg_replace('/(select|join|union|update|drop)[ ]./i', '', $valor);

		//Aplica m�todos de preven��o nativos
		$valor = strip_tags($valor);
		$valor = mysql_real_escape_string($valor);
		$valor = trim($valor);
		
		//Verifica se foi setado um tipo (I ou F) e aplica os filtros
    if($tipo=="I"){ $valor = preg_replace('/[^0-9-]/', '', $valor); }
		if($tipo=="F"){ $valor = preg_replace('/[^0-9.,-]/', '', $valor); }
		
		//grava o Log do filtro
		$linha_log	= $_SERVER["REMOTE_ADDR"]." || ".date("Y.m.d || H:i:s")." || ".$valor_ant." || ".$valor." || ".$log_comp." || ".$_SERVER ['REQUEST_URI']."\r\n";
		$fp = fopen($pathlog.'log_campo_injection.txt', "a");
		fwrite ($fp,$linha_log);
		fclose ($fp);
		
		return $valor;
	}
  
  function paginacao($finalidade,$tipo,$cidade,$bairro,$valor_min,$valor_max,$quartos,$suites,$banheiros,$vagas,$ordem=''){ //global $link;
		$resp = '?pg=busca';
		if ($finalidade  > 0) { $resp .= '&finalidade='			.$finalidade;  }
		if ($cidade      > 0) { $resp .= '&cidade='  				.$cidade; }
    for($x=0;$x<count($bairro);$x++){
      $codbairro = $bairro[$x];
      if ($codbairro > 0) { $resp .= "&bairro[".$x."]="  				.$codbairro; }
    }
    for($x=0;$x<count($tipo);$x++){
      $codtipo = $tipo[$x];
      if ($codtipo   > 0) { $resp .= "&tipo_imovel[".$x."]="  				.$codtipo; }
    }
		if ($valor_min   > 0) { $resp .= '&valor_min='  .$valor_min;  }
		if ($valor_max   > 0) { $resp .= '&valor_max='  .$valor_max;  }
		if ($quartos     > 0) { $resp .= '&quartos='   .$quartos;    }
    if ($suites      > 0) { $resp .= '&suites='   .$suites;    }
    if ($banheiros   > 0) { $resp .= '&banheiros='   .$banheiros;    }
		if ($vagas       > 0) { $resp .= '&vagas='    		.$vagas; }   
		if ($ordem      !='') { $resp .= "&ordem=".$ordem; }
		// if ($pagina 		 < 1) { $pagina = 1;}
		// $resp .= "&pagina=".$pagina;
		return $resp;
	}

  function url_paginacao($url, $pagina_atual, $pagina_replace){
    $url = str_replace("pagina=".$pagina_atual, "pagina=".$pagina_replace, $url);

    return $url;
  }

  function url_ordenacao($url, $ordem_atual, $ordem_replace){
    // $url = str_replace('ordem='.$ordem_atual, 'ordem='.$ordem_replace, $url);
    $url = str_replace($ordem_atual, $ordem_replace, $url);

    return $url;
    // return $ordem_atual;
  }
	
  function usuario_tipo($id){
    if($id == 1){
      return "Corretor";
    }
    elseif($id == 2){
      return "Editor";
    }
    elseif($id == 3){
      return "Administrador";
    }
  }
  
  function idade($data){
    $dia = date('d');
    $mes = date('m');
    $ano = date('Y');
    
    $nascimento = explode('-', $data);
    $dianasc = ($nascimento[2]);
    $mesnasc = ($nascimento[1]);
    $anonasc = ($nascimento[0]);
    
    $idade = $ano - $anonasc;
    
    if($mes < $mesnasc){
      $idade--;
      return $idade;
    }
    elseif($mes == $mesnasc && $dia <= $dianasc){
      $idade--;
      return $idade;
    }
    else{
      return $idade;
    }
  }

  function get_client_ip() {
    $ipaddress = '';
    if ($_SERVER['HTTP_CLIENT_IP'])
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if($_SERVER['HTTP_X_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if($_SERVER['HTTP_X_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if($_SERVER['HTTP_FORWARDED_FOR'])
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if($_SERVER['HTTP_FORWARDED'])
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if($_SERVER['REMOTE_ADDR'])
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';

    return $ipaddress;
  }

  function gravalog($id_usuario, $id_modulo, $id_recurso, $descricao, $query){
    $query = mysql_escape_string($query);
    $ip = get_client_ip();
    mysql_query("INSERT INTO log (id_usuario, id_modulo, id_recurso, descricao, query, data, ip) VALUES ('$id_usuario', '$id_modulo', '$id_recurso', '$descricao', '$query', NOW(), '$ip')");
    
    return false;
  }

  // function breadcrumbs($sep = "&nbsp; <i class='fa fa-angle-right'></i> &nbsp;", $home = "Home") {
  //   $bc     =   '<ol class="breadcrumb">';
  //   //Pegando a url base do site
  //   $site   =   'http://'.$_SERVER['HTTP_HOST'];
  //   //Pegando e tratando as v�riaveis get
  //   $crumbs =   strstr($_SERVER["REQUEST_URI"], '&', true);
  //   $crumbs =   array_filter( explode("/index.php?pg=",$crumbs) );
  //   if($_GET['finalidade'] AND $_GET['finalidade'] != 'todas' AND $_GET['pg'] == 'busca'){
  //     $crumbs[] .= "Imoveis para ". retorna_nome('finalidade', $_GET['finalidade']);
  //   }
  //   if((!$_GET['finalidade'] OR $_GET['finalidade'] == 'todas') AND $_GET['pg'] == 'busca'){
  //     $crumbs[] .= "Todos imoveis";
  //   }
  //   if($_GET['cidade'] AND $_GET['pg'] == 'busca'){
  //     $crumbs[] .= retorna_nome('cidade', $_GET['cidade']);
  //   }
  //   if($_GET['id'] AND $_GET['pg'] == 'imovel'){
  //     $crumbs[] .= "Ref. ". retorna_campo('imovel', 'ref', $_GET['id']);
  //   }
  //   //Cria o crumb da Home
  //   $bc    .=   '<li><a href="'.$site.'">'.$home.'</a>'.$sep.'</li>';
  //   //Conta os breadcrumbs que nao s�o vazios
  //   $nm     =   count($crumbs);
  //   $i      =   1;

  //   foreach($crumbs as $crumb){
  //     //Pegando o �ltimo crumb
  //     $last_piece = end($crumbs);
  //     //Tratando o estilo do link
  //     $link    =  ucfirst( str_replace( array(".php","-","_"), array(""," "," ") ,$crumb) );
  //     //Se for o ultimo crumb n�o exibe o separador
  //     $sep     =  $i==$nm?'':$sep;
  //     //Add crumbs to the root
  //     $site   .=  '/'.$crumb;
  //     //V� se � o ultimo crumb
  //     if ($last_piece!==$crumb){
  //       //Cria o proximo crumb
  //       $bc     .= '<li>'.$link.$sep.'</li>';
  //     }
  //     else {
  //       //Se for o ultimo crumb n�o ser� um link
  //       $bc     .= '<li class="active">'.ucfirst( str_replace( array(".php","-","_"), array(""," "," ") ,$last_piece)).'</li>';
  //     }
  //     $i++;
  //   }
  //   $bc .=  '</ol>';
    
  //   return $bc;
  // }


  function breadcrumbs($sep = "&nbsp; <i class='fa fa-angle-right'></i> &nbsp;", $home = "Home") {
    $bc     =   '<ol class="breadcrumb">';
    //Pegando a url base do site
    $site   =   'http://'.$_SERVER['HTTP_HOST'];
    //Pegando e tratando as váriaveis get
    if($_GET['finalidade'] AND $_GET['finalidade'] != 'todas' AND $_GET['pg'] == 'busca'){
      $crumbs[] .= "Imóveis para ". retorna_nome('finalidade', $_GET['finalidade']);
    }
    if((!$_GET['finalidade'] OR $_GET['finalidade'] == 'todas') AND $_GET['pg'] == 'busca'){
      $crumbs[] .= "Todos imóveis";
    }
    if($_GET['pg'] == 'favoritos'){
      $crumbs[] = "Favoritos";
    }
    if($_GET['cidade'] AND $_GET['pg'] == 'busca'){
      $crumbs[] .= retorna_nome('cidade', $_GET['cidade']);
    }
    if($_GET['id'] AND $_GET['pg'] == 'imovel'){
      $crumbs[] .= "Imóvel";
      $crumbs[] .= "Ref. ". retorna_campo('imovel', 'ref', $_GET['id']);
    }
    //Cria o crumb da Home
    $bc    .=   '<li><a href="'.$site.'">'.$home.'</a>'.$sep.'</li>';
    //Conta os breadcrumbs que nao são vazios
    $nm     =   count($crumbs);
    $i      =   1;

    foreach($crumbs as $crumb){
      //Pegando o �ltimo crumb
      $last_piece = end($crumbs);
      //Tratando o estilo do link
      $link    =  ucfirst( str_replace( array(".php","-","_"), array(""," "," ") ,$crumb) );
      //Se for o ultimo crumb não exibe o separador
      $sep     =  $i==$nm?'':$sep;
      //Add crumbs to the root
      $site   .=  '/'.$crumb;
      //V� se � o ultimo crumb
      if ($last_piece!==$crumb){
        //Cria o proximo crumb
        $bc     .= '<li>'.$link.$sep.'</li>';
      }
      else {
        //Se for o ultimo crumb não será um link
        $bc     .= '<li class="active">'.ucfirst( str_replace( array(".php","-","_"), array(""," "," ") ,$last_piece)).'</li>';
      }
      $i++;
    }
    $bc .=  '</ol>';
    
    return $bc;
  }
  
  function ativo($status){
    if($status == 'S'){
      return '<i class="fas fa-check-circle" style="color:green;font-size:1.6rem;"></i>';
    }
    elseif($status == 'N'){
      return '<i class="fas fa-times-circle" style="color:red;font-size:1.6rem;"></i>';
    }
    else{
      return $status;
    }
  }

?>
