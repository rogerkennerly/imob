 <?php
  
  $botao = "CADASTRAR IMÓVEL";
  
  $op = $_REQUEST["op"];
  
  $agora = date("Y-m-d H:i:s");
  
  if($_GET["id_imovel"] OR $_GET["ref"]){
    $id_imovel = evita_injection($_GET["id_imovel"]);
    if(!$id_imovel){
      $ref = evita_injection($_GET["ref"]);
      $s = "SELECT id FROM imovel WHERE ref = '$ref'";
      $q = mysql_query($s);
      $r = mysql_fetch_assoc($q);
      $id_imovel = $r["id"];
    }
    $op = "editar";
  }
  if($_POST){
    $id_imovel       = evita_injection($_POST["id_imovel"]);
    $ref             = evita_injection($_POST["ref"]);
    $id_proprietario = evita_injection($_POST["id_proprietario"]);
    $id_corretor     = evita_injection($_POST["id_corretor"]);
    $finalidade      = $_POST["finalidade"];
    $tipo            = evita_injection($_POST["tipo"]);
    // $valor        = tratar_moeda($_POST["valor"],1);
    $cidade          = evita_injection($_POST["cidade"]);
    $bairro          = evita_injection($_POST["bairro"]);
    $endereco        = evita_injection($_POST["endereco"]);
    $cep             = evita_injection($_POST["cep"]);
    $detalhes        = addslashes(trim($_POST["detalhes"]));
    $obs             = addslashes(trim($_POST["obs"]));
    $disponivel      = evita_injection($_POST["disponivel"]);        if(!$disponivel)    {$disponivel     = "N";}
    $super_destaque  = evita_injection($_POST["super_destaque"]);    if(!$super_destaque){$super_destaque = "N";}
    $destaque        = evita_injection($_POST["destaque"]);          if(!$destaque)      {$destaque       = "N";}
    $financia        = evita_injection($_POST["financia"]);          if(!$financia)      {$financia       = "N";}
    $quarto          = evita_injection($_POST["quarto"]);
    $suite           = evita_injection($_POST["suite"]);
    $banheiro        = evita_injection($_POST["banheiro"]);
    $garagem         = evita_injection($_POST["garagem"]);
    $sala            = evita_injection($_POST["sala"]);
    $terreno         = evita_injection($_POST["terreno"]);
    $area_construida = evita_injection($_POST["area_construida"]);
    $video           = $_POST["video"]; $video = explode("?v=", $video); $video = $video[1];
    $item            = $_POST["item"];
  }
  
  $cadastro_global = true;
  if($_POST["novo_tipo"]){
    $nome = evita_injection($_POST["novo_tipo"]);
    $teste = mysql_query("SELECT * FROM tipo WHERE nome like '$nome'");
    
    if(mysql_num_rows($teste)>0){
      echo alerta("Tipo <strong>$nome</strong> já existe!");
      $add_tipo_name = $nome;
      $cadastro_global = false;
    }
    else{
      $s_tipo = "INSERT INTO tipo (nome) VALUES ('$nome')";
      mysql_query($s_tipo);
      $tipo = mysql_insert_id();
      
      $descricao_log = "Tipo incluido - $nome";
      gravalog($_SESSION["sessao_id_user"], 3, 1, $descricao_log, $s);
    }
  }
  
  if($_POST["nova_cidade"]){
    $nome = evita_injection($_POST["nova_cidade"]);
    $teste = mysql_query("SELECT * FROM cidade WHERE nome like '$nome'");
    
    if(mysql_num_rows($teste)>0){
      echo alerta("Cidade <strong>$nome</strong> já existe!");
      $add_cidade_name = $nome;
      $cadastro_global = false;
    }
    else{
      $s_cidade = "INSERT INTO cidade (nome) VALUES ('$nome')";
      mysql_query($s_cidade);
      $cidade = mysql_insert_id();
      
      $descricao_log = "Cidade incluida - $nome";
      gravalog($_SESSION["sessao_id_user"], 4, 1, $descricao_log, $s);
    }
  }
  
  if($_POST["novo_bairro"]){
    $nome = evita_injection($_POST["novo_bairro"]);
    
    $qc = mysql_query("SELECT nome FROM cidade WHERE id = '$cidade'");
    $rc = mysql_fetch_assoc($qc);
    $nome_cidadeb = $rc["nome"];
    
    $teste = mysql_query("SELECT * FROM bairro WHERE nome like '$nome' AND id_cidade = '$cidade'");
    
    if(mysql_num_rows($teste)>0){
      echo alerta("Bairro <strong>$nome / $nome_cidadeb</strong> já existe!");
      $add_bairro_name = $nome;
      $cadastro_global = false;
    }
    else{
      $s_bairro = "INSERT INTO bairro (nome, id_cidade) VALUES ('$nome', '$cidade')";
      mysql_query($s_bairro);
      $bairro = mysql_insert_id();
      
      $descricao_log = "Bairro incluido - $nome / $nome_cidadeb";
      gravalog($_SESSION["sessao_id_user"], 5, 1, $descricao_log, $s);
    }
  }
  
  if($op == "incluir"){
    
    $cadastro = true;
    $teste = mysql_query("SELECT id FROM imovel WHERE ref = '$ref'");
    if(mysql_num_rows($teste)>0){
      echo alerta("Já existe um imóvel com a Ref: $ref");
      $cadastro = false;
    }
    if(!$cadastro_global){
      $cadastro = false;
    }
    
    if($cadastro){
      $s = "INSERT INTO imovel (
      ref,
      id_proprietario,
      id_corretor,
      id_tipo,
      id_cidade,
      id_bairro,
      endereco,
      cep,
      detalhes,
      obs,
      disponivel,
      super_destaque,
      destaque,
      financia,
      quarto,
      suite,
      banheiro,
      garagem,
      sala,
      terreno,
      area_construida,
      video,
      data_cadastro
      ) VALUES (
      '$ref',
      '$id_proprietario',
      '$id_corretor',
      '$tipo',
      '$cidade',
      '$bairro',
      '$endereco',
      '$cep',
      '$detalhes',
      '$obs',
      '$disponivel',
      '$super_destaque',
      '$destaque',
      '$financia',
      '$quarto',
      '$suite',
      '$banheiro',
      '$garagem',
      '$sala',
      '$terreno',
      '$area_construida',
      '$video',
      '$agora'
      )";
      if($_POST){
        if(mysql_query($s)){
          $id_imovel = mysql_insert_id();
          $s_item_log = "";
          foreach($item as $id_item){
            $s_item = "INSERT INTO imovel_item (id_imovel, id_item) VALUES ('$id_imovel', '$id_item')";
            mysql_query($s_item);
            $s_item_log .= $s_item;
          }
          foreach($finalidade as $id_finalidade){
            $valor_finalidade      = tratar_moeda($_POST["valor_".$id_finalidade],1);
            $iptu_finalidade       = tratar_moeda($_POST["iptu_".$id_finalidade],1);
            $condominio_finalidade = tratar_moeda($_POST["condominio_".$id_finalidade],1);
            $s_item = "INSERT INTO imovel_finalidade (id_imovel, id_finalidade, valor, iptu, condominio) VALUES ('$id_imovel', '$id_finalidade', '$valor_finalidade', '$iptu_finalidade', '$condominio_finalidade')";
            mysql_query($s_item);
            $s_item_log .= $s_item;
            
            /////////////////////////////////////////////////////////////////////////////////////////
            //   INTEGRAÇÃO PORTAIS CASA  ||  INTEGRAÇÃO PORTAIS CASA  || INTEGRAÇÃO PORTAIS CASA  //
            /////////////////////////////////////////////////////////////////////////////////////////
            if($r_integracao["integracao"] == "casajau"){
              // Monta arrays com os tipos, classificações, cidades e bairros
              $sel_tipos	= mysql_query("SELECT * FROM tipo ORDER BY id ASC");
              while( $res_tipos = mysql_fetch_assoc($sel_tipos) ){
                $tipo_array[$res_tipos['id']] = $res_tipos['nome'];
              }
              $sel_classis	= mysql_query("SELECT * FROM finalidade ORDER BY id ASC");
              while( $res_classis = mysql_fetch_assoc($sel_classis) ){
                $finalidade_array[$res_classis['id']] = $res_classis['nome'];
              }
              $sel_cidades	= mysql_query("SELECT * FROM cidade ORDER BY id ASC");
              while( $res_cidades = mysql_fetch_assoc($sel_cidades) ){
                $cidade_array[$res_cidades['id']] = $res_cidades['nome'];
              }
              $sel_bairros	= mysql_query("SELECT * FROM bairro ORDER BY id ASC");
              while( $res_bairros = mysql_fetch_assoc($sel_bairros) ){
                $bairro_array[$res_bairros['id']][0] = $res_bairros['nome'];
                $bairro_array[$res_bairros['id']][1] = $cidade_array[$res_bairros['id_cidade']];
                $bairro_array[$res_bairros['id']][2] = $res_bairros['id_cidade'];
              }
              // Monta arrays com os tipos, classificações, cidades e bairros
              
              $xml["key"] = $r_integracao["key_integracao"];
              $xml["imoveis"]["imovel"]["referencia"]     = $ref;
              $xml["imoveis"]["imovel"]["status"]         = "S";
              $xml["imoveis"]["imovel"]["tipo"]	          = $tipo_array[$tipo];
              $xml["imoveis"]["imovel"]["finalidade"]     = $finalidade_array[$id_finalidade];
              $xml["imoveis"]["imovel"]["cidade"]	        = $cidade_array[$cidade][1];
              $xml["imoveis"]["imovel"]["bairro"]         = $bairro_array[$bairro][0];
              $xml["imoveis"]["imovel"]["endereco"]       = $endereco;
              $xml["imoveis"]["imovel"]["valor"]	        = $valor_finalidade;
              $xml["imoveis"]["imovel"]["financiamento"]  = $financia;
              $xml["imoveis"]["imovel"]["quartos"]	      = $quarto;
              $xml["imoveis"]["imovel"]["suites"]	        = $suite;
              $xml["imoveis"]["imovel"]["banheiros"]	    = $banheiro;
              $xml["imoveis"]["imovel"]["vagas"]	        = $garagem;
              $xml["imoveis"]["imovel"]["areaConstruida"] = $area_construida;
              $xml["imoveis"]["imovel"]["areaTotal"]	    = $terreno;
              $xml["imoveis"]["imovel"]["descricao"]	    = $detalhes;
              $xml["imoveis"]["imovel"]["video"]	        = $video;
              
              $sel_itens	= mysql_query("SELECT * FROM imovel_item WHERE id_imovel='".$id_imovel."'");
              while( $res_itens	= mysql_fetch_assoc($sel_itens) ){
                $sel_item	= mysql_query("SELECT * FROM item WHERE id='".$res_itens['id']."'");
                $res_item	= mysql_fetch_assoc($sel_item);
                $xml["imoveis"]["imovel"]["estruturas"]["estrutura"] = $res_item['nome'];
              }
        
              // Exportação das FOTOS do imóvel. Tenta a foto gigante, senão vai na foto grande "normal"
              $id_imovelz	= $res_imoveis['id'];
              $sql_ft = "SELECT nome FROM foto WHERE id_imovel = '$id_imovelz' ORDER BY posicao";
              $q_ft = mysql_query($sql_ft);
              $caminho	= 'clientes/'.DIRETORIO.'/fotos/'.$id_imovelz.'/t1/';
              while($r_ft = mysql_fetch_assoc($q_ft)){
                $file = $r_ft["nome"];
                $xml["imoveis"]["imovel"]['fotos']['foto'] = $end_site.$caminho.$file;
              }
              $xml = json_encode($xml);	
              
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL,"https://www.casajau.com.br/integracao_site/index.php");
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, "json=".$xml);

              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

              $server_output = curl_exec ($ch);
            }
            /////////////////////////////////////////////////////////////////////////////////////////
            //   INTEGRAÇÃO PORTAIS CASA  ||  INTEGRAÇÃO PORTAIS CASA  || INTEGRAÇÃO PORTAIS CASA  //
            /////////////////////////////////////////////////////////////////////////////////////////
          }
          
          // echo sucesso("Imóvel $ref cadastrado com sucesso!");
          // $op = "editar";
          $_SESSION["sucesso_include"] = 1;
          
          $descricao_log = "Imóvel ref. $ref Cadastrado.";
          gravalog($_SESSION["sessao_id_user"], 1, 1, $descricao_log, $s.$s_item_log);
          // echo $id_imovel;exit;
          ?><script>window.location.assign("index.php?pg=imovel&id_imovel=<?php echo $id_imovel;?>");</script><?php
        }else{
          echo alerta("Erro ao cadastrar o imóvel $ref");
        }
      }
    }
  }
  if($_SESSION["sucesso_include"] == 1){
    echo sucesso("Imóvel $ref cadastrado com sucesso!");
    $_SESSION["sucesso_include"] = 0;
  }
  if($op == "editar"){
    $botao = "SALVAR ALTERAÇÕES";
    
    $alteracao = true;
    if(!$cadastro_global){
      $alteracao = false;
    }
    
    if($alteracao){
      if($_POST["id_imovel"]){
        $s = "UPDATE imovel SET 
        ref = '$ref',
        id_proprietario = '$id_proprietario',
        id_corretor = '$id_corretor',
        id_tipo = '$tipo',
        id_cidade = '$cidade',
        id_bairro = '$bairro',
        endereco = '$endereco',
        cep = '$cep',
        detalhes = '$detalhes',
        obs = '$obs',
        disponivel = '$disponivel',
        super_destaque = '$super_destaque',
        destaque = '$destaque',
        financia = '$financia',
        quarto = '$quarto',
        suite = '$suite',
        banheiro = '$banheiro',
        garagem = '$garagem',
        sala = '$sala',
        terreno = '$terreno',
        area_construida = '$area_construida', 
        video = '$video',
        pre_cadastro = 0
        WHERE id = '$id_imovel'";
        // echo $s;
        if(mysql_query($s)){
          mysql_query("DELETE FROM imovel_item WHERE id_imovel = '$id_imovel'");
          $s_item_log = "";
          foreach($item as $id_item){
            $s_item = "INSERT INTO imovel_item (id_imovel, id_item) VALUES ('$id_imovel', '$id_item')";
            mysql_query($s_item);
            $s_item_log .= $s_item;
          }
          
          mysql_query("DELETE FROM imovel_finalidade WHERE id_imovel = '$id_imovel'");
          foreach($finalidade as $id_finalidade){
            $valor_finalidade      = tratar_moeda($_POST["valor_".$id_finalidade],1);
            $iptu_finalidade       = tratar_moeda($_POST["iptu_".$id_finalidade],1);
            $condominio_finalidade = tratar_moeda($_POST["condominio_".$id_finalidade],1);
            $s_item = "INSERT INTO imovel_finalidade (id_imovel, id_finalidade, valor, iptu, condominio) VALUES ('$id_imovel', '$id_finalidade', '$valor_finalidade', '$iptu_finalidade', '$condominio_finalidade')";
            mysql_query($s_item);
            
            mysql_query($s_finalidade);
            $s_item_log .= $s_finalidade;
            
            /////////////////////////////////////////////////////////////////////////////////////////
            //   INTEGRAÇÃO PORTAIS CASA  ||  INTEGRAÇÃO PORTAIS CASA  || INTEGRAÇÃO PORTAIS CASA  //
            /////////////////////////////////////////////////////////////////////////////////////////
            if($r_integracao["integracao"] == "casajau"){
              // Monta arrays com os tipos, classificações, cidades e bairros
              $sel_tipos	= mysql_query("SELECT * FROM tipo ORDER BY id ASC");
              while( $res_tipos = mysql_fetch_assoc($sel_tipos) ){
                $tipo_array[$res_tipos['id']] = $res_tipos['nome'];
              }
              $sel_classis	= mysql_query("SELECT * FROM finalidade ORDER BY id ASC");
              while( $res_classis = mysql_fetch_assoc($sel_classis) ){
                $finalidade_array[$res_classis['id']] = $res_classis['nome'];
              }
              $sel_cidades	= mysql_query("SELECT * FROM cidade ORDER BY id ASC");
              while( $res_cidades = mysql_fetch_assoc($sel_cidades) ){
                $cidade_array[$res_cidades['id']] = $res_cidades['nome'];
              }
              $sel_bairros	= mysql_query("SELECT * FROM bairro ORDER BY id ASC");
              while( $res_bairros = mysql_fetch_assoc($sel_bairros) ){
                $bairro_array[$res_bairros['id']][0] = $res_bairros['nome'];
                $bairro_array[$res_bairros['id']][1] = $cidade_array[$res_bairros['id_cidade']];
                $bairro_array[$res_bairros['id']][2] = $res_bairros['id_cidade'];
              }
              // Monta arrays com os tipos, classificações, cidades e bairros
              
              $xml["key"] = $r_integracao["key_integracao"];
              $xml["imoveis"]["imovel"]["referencia"]     = $ref;
              $xml["imoveis"]["imovel"]["status"]         = $disponivel;
              $xml["imoveis"]["imovel"]["tipo"]	          = $tipo_array[$tipo];
              $xml["imoveis"]["imovel"]["finalidade"]     = $finalidade_array[$id_finalidade];
              $xml["imoveis"]["imovel"]["cidade"]	        = $cidade_array[$cidade][1];
              $xml["imoveis"]["imovel"]["bairro"]         = $bairro_array[$bairro][0];
              $xml["imoveis"]["imovel"]["endereco"]       = $endereco;
              $xml["imoveis"]["imovel"]["valor"]	        = $valor_finalidade;
              $xml["imoveis"]["imovel"]["financiamento"]  = $financia;
              $xml["imoveis"]["imovel"]["quartos"]	      = $quarto;
              $xml["imoveis"]["imovel"]["suites"]	        = $suite;
              $xml["imoveis"]["imovel"]["banheiros"]	    = $banheiro;
              $xml["imoveis"]["imovel"]["vagas"]	        = $garagem;
              $xml["imoveis"]["imovel"]["areaConstruida"] = $area_construida;
              $xml["imoveis"]["imovel"]["areaTotal"]	    = $terreno;
              $xml["imoveis"]["imovel"]["descricao"]	    = $detalhes;
              $xml["imoveis"]["imovel"]["video"]	        = $video;
              
              $sel_itens	= mysql_query("SELECT * FROM imovel_item WHERE id_imovel='".$id_imovel."'");
              while( $res_itens	= mysql_fetch_assoc($sel_itens) ){
                $sel_item	= mysql_query("SELECT * FROM item WHERE id='".$res_itens['id']."'");
                $res_item	= mysql_fetch_assoc($sel_item);
                $xml["imoveis"]["imovel"]["estruturas"]["estrutura"] = $res_item['nome'];
              }
        
              // Exportação das FOTOS do imóvel. Tenta a foto gigante, senão vai na foto grande "normal"
              $id_imovelft	= $res_imoveis['id'];
              $sql_ft = "SELECT nome FROM foto WHERE id_imovel = '$id_imovelft' ORDER BY posicao";
              $q_ft = mysql_query($sql_ft);
              $caminho	= 'clientes/'.DIRETORIO.'/fotos/'.$id_imovelft.'/t1/';
              while($r_ft = mysql_fetch_assoc($q_ft)){
                $file = $r_ft["nome"];
                $xml["imoveis"]["imovel"]['fotos']['foto'] = $end_site.$caminho.$file;
              }
              $xmlz = json_encode($xml);	
              
              $ch = curl_init();
              curl_setopt($ch, CURLOPT_URL,"https://www.casajau.com.br/integracao_site/index.php");
              curl_setopt($ch, CURLOPT_POST, 1);
              curl_setopt($ch, CURLOPT_POSTFIELDS, "json=".$xmlz);

              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

              $server_output = curl_exec ($ch);
            }
            /////////////////////////////////////////////////////////////////////////////////////////
            //   INTEGRAÇÃO PORTAIS CASA  ||  INTEGRAÇÃO PORTAIS CASA  || INTEGRAÇÃO PORTAIS CASA  //
            /////////////////////////////////////////////////////////////////////////////////////////
          }
          
          echo sucesso("Imóvel $ref alterado com sucesso!");
          $imovel = listar_unico("imovel", $id_imovel);
          $item = item_listar($id_imovel);
          
          $descricao_log = "Imóvel ref. $ref Alterado.";
          gravalog($_SESSION["sessao_id_user"], 1, 2, $descricao_log, $s.$s_item_log);
        }else{
          echo alerta("Erro ao alterar o imóvel $ref");
          // echo alerta($s);
        }
      }
    }
  }
  
  if($_POST["id_imovel"]){$id_imovel = evita_injection($_POST["id_imovel"]);}elseif($_GET["id_imovel"]){$id_imovel = evita_injection($_GET["id_imovel"]);}
  
  
  
  //CARREGA INFORMAÇÕES
  $imovel = listar_unico("imovel", $id_imovel);
  $ref             = $imovel["ref"];
  $id_proprietario = $imovel["id_proprietario"];
  $id_corretor     = $imovel["id_corretor"];
  // $finalidade      = $imovel["id_finalidade"];
  $tipo            = $imovel["id_tipo"];
  $valor           = $imovel["valor"]; // VALOR E FINALIDADE FORAM COMENTADOS POIS ESTAO SENDO FEITOS DE OUTRA FORMA - MULTIPLAS FINALIDADES E SEUS VALORES
  $cidade          = $imovel["id_cidade"];
  $bairro          = $imovel["id_bairro"];
  $endereco        = $imovel["endereco"];
  $cep             = $imovel["cep"];
  $detalhes        = $imovel["detalhes"];
  $obs             = $imovel["obs"];
  $disponivel      = $imovel["disponivel"];    
  $super_destaque  = $imovel["super_destaque"];
  $destaque        = $imovel["destaque"];      
  $financia        = $imovel["financia"];      
  $quarto          = $imovel["quarto"];
  $suite           = $imovel["suite"];
  $banheiro        = $imovel["banheiro"];
  $garagem         = $imovel["garagem"];
  $sala            = $imovel["sala"];
  $terreno         = $imovel["terreno"];
  $area_construida = $imovel["area_construida"];
  $video           = $imovel["video"];
  $item            = item_listar($id_imovel);
  $finalidade      = finalidade_listar($id_imovel);
  $ultima_ref = '';
	$config = listar("config");//pega as configs do sistema - criado pra ver se a restrição de proprietarios está ativa
	$config = mysql_fetch_assoc($config);
  
  if(!$op){
    $op = "incluir";
    if(DIRETORIO == 'imobiliariaperlati'){
      $qref = mysql_query("SELECT ref FROM imovel ORDER BY id DESC");
      $rref = mysql_fetch_assoc($qref);
      $ref = '';
      $ultima_ref = $rref['ref'];
    }else{
      $qref = mysql_query("SELECT ref FROM imovel ORDER BY ref DESC");
      $rref = mysql_fetch_assoc($qref);
      $ref = $rref["ref"]+1;
    }
  }
?>

<div class="page-content">
  <div class="page-header header-mobile">
    <h1>
      Incluir Imóvel
    <?php
    if($op == "editar"){?>
    <a href="?pg=gerenciar-fotos&id_imovel=<?php echo $id_imovel; ?>">
      <button class="btn-primary btn_mobile" style="float:right;margin-top:-9px;border:0;padding:1rem;">GERENCIAR FOTOS</button>
    </a>
    <?php
    }?>
    </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <div class="col-xs-12 controle-chosen">
      <form method="POST" action="">
        <input type="hidden" name="op" value="<?php echo $op; ?>">
        <input type="hidden" name="id_imovel" value="<?php echo $id_imovel; ?>">
        <div class="imob-50 imob-left imob-padding-20" style="margin-top:-2rem;">
          Referência:<br/>
          <input type="text" name="ref" class="input_padrao" placeholder="" size="10" value="<?php echo $ref; ?>">
          <?php if($ultima_ref){echo 'Última referencia cadastrada: <strong>'.$ultima_ref.'</strong>';} ?>
          
         
          <?php
					$mostrar_proprietarios = 1;
					if($config['restricao_proprietarios'] == 'S' AND $_SESSION["sessao_tipo_user"] == 1){
						if($id_corretor != $_SESSION['sessao_id_user']){
							$mostrar_proprietarios = 0;
						}
					}
					if($mostrar_proprietarios == 1){?>
					
          <br/><br/>
					
          Proprietário:<br/>
					<?php?>
          <div style="font-size:2.5rem;margin-top:-0.5rem;">
            <select name="id_proprietario" class="chosen-select input_padrao" style="min-width:30rem;max-width:60rem;float:left;">
              <option value="">Selecione o Proprietário</option>
              <?php
							$proprietario = mysql_query("SELECT * FROM proprietario");
              while($r = mysql_fetch_assoc($proprietario)){
                $selected = "";
                if($id_proprietario == $r["id"]){$selected = "selected";}?>
              <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
              <?php
              }
              if(mysql_num_rows($proprietario)<1){?>
                <option value="">Nenhum Proprietário cadastrado</option>
              <?php
              }?>
            </select>
            
            <?php
            if($op == 'editar'){
              $d_prop = listar_unico('proprietario', $id_proprietario);
              $prop_telefones = $d_prop['telefone']." | ".$d_prop['celular'];?>
              <span class='nav-list'>
                <span class='badge badge-transparent tooltip-sucess' title='<?php echo $prop_telefones; ?>' style="color:#000;font-size:2rem;">
                  <i class="icon-phone bigger-130" style="vertical-align:middle;"></i>
                </span>
              </span>
            <?php
            }?>
          </div>
					<?php
					}else{ echo "<br/>"; }?>
          
          <br/>
          
          Corretor:<br/>
          <?php
          $corretor = mysql_query("SELECT * FROM usuario WHERE tipo = 1");?>
          <select name="id_corretor" class="chosen-select input_padrao" style="min-width:20rem;">
            <option value="">Selecione o Corretor</option>
            <?php
            while($r = mysql_fetch_assoc($corretor)){
              $selected = "";
              if($id_corretor == $r["id"]){$selected = "selected";}?>
            <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
            <?php
            }
            if(mysql_num_rows($corretor)<1){?>
              <option value="">Nenhum Corretor cadastrado</option>
            <?php
            }?>
          </select>
          
          <br/><br/>
          
          Tipo:<br/>
          <?php
          $tipo_list = listar("tipo");?>
          <div class="input_padrao" style="float:left;">
            <select name="tipo" class="chosen-select input_padrao" style="min-width:20rem;">
              <?php
              while($r = mysql_fetch_assoc($tipo_list)){
                $selected = "";
                if($tipo == $r["id"]){$selected = "selected";}?>
              <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
              <?php
              }?>
            </select>
            <i class="fas fa-plus-circle icons_add" onclick="$('#add_tipo').fadeIn();"></i>
          </div>
          <?php
            $display_add = "none";
            if($add_tipo_name){$display_add = "block";}
          ?>
          <div id="add_tipo" style="float:left;display:<?php echo $display_add; ?>;">
            <input name="novo_tipo" id="ntipo" class="input_new" placeholder="Novo tipo" size="30" value="<?php echo $add_tipo_name; ?>">
            <i class="fas fa-times-circle icons_add" style="color:red;" onclick="$('#add_tipo').fadeOut();$('#ntipo').val('')"></i>
          </div>
          
          <br/><br/>
          
          <div style="float:left;width:100%;margin-top:2rem;padding:1rem 0;">
          Finalidade:<br/>
          <div style="float:left;width:100%;margin-bottom:2rem;margin-top:0.3rem;">
            <?php
            if($_POST["id_imovel"]){$id_imovel = evita_injection($_POST["id_imovel"]);}elseif($_GET["id_imovel"]){$id_imovel = evita_injection($_GET["id_imovel"]);}
            $finalidade_list = listar("finalidade");?>
            <div style="float:left;width:100%;">
              <div class="input_padrao" style="float:left;margin-bottom:1rem;">
                <select name="finalidade[]" id="select_finalidade" multiple class="chosen-select select_finalidades" style="min-width:30rem;height:3rem;" data-placeholder="Selecione a finalidade" onchange="controle_valor_finalidade($(this).val(), '<?php echo $id_imovel; ?>')">
                  <?php
                  while($r = mysql_fetch_assoc($finalidade_list)){
                    $selected = "";
                    if(in_array($r["id"], $finalidade)){$selected = "selected";}?>
                  <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
                  <?php
                  }?>
                </select>
              </div>
              <?php
                $display_add = "none";
                if($add_fin_name){$display_add = "block";}
              ?>
            </div>
            <style>.chosen-container-multi .chosen-choices{height:6rem !important;}</style>
            
            <br/><br/>
            
            <div class="campos_valores">
              <?php
              $sfin = "SELECT * FROM imovel_finalidade WHERE id_imovel = '$id_imovel' ORDER BY id_finalidade";
              $qfin = mysql_query($sfin);
              if(mysql_num_rows($qfin)>0){
                while($rfin = mysql_fetch_assoc($qfin)){
                  $s2 = "SELECT nome FROM finalidade WHERE id = '".$rfin["id_finalidade"]."'";
                  $q2 = mysql_query($s2);
                  $r2 = mysql_fetch_assoc($q2);
                  $nome_finalidade = $r2["nome"];?>
                  <div style="width:100%;float:left;margin-bottom:1rem;">
                    <div class="input_padrao sem_ml sem_mr" style="float:left;margin-right:1rem;">
                      Valor <?php echo $nome_finalidade; ?>:
                      <br />
                      <input type="text" class="input_padrao" name="valor_<?php echo $rfin["id_finalidade"]; ?>" placeholder="" size="15" class="money" data-affixes-stay="true" data-thousands="." data-decimal="," value="<?php echo tratar_moeda($rfin["valor"],2); ?>">
                    </div>
        
                    <div class="input_padrao sem_ml sem_mr" style="float:left;margin-right:1rem;">
                      IPTU <?php echo $nome_finalidade; ?>:
                      <br/>
                      <input type="text" class="input_padrao" name="iptu_<?php echo $rfin["id_finalidade"]; ?>" placeholder="" size="15" class="money" data-affixes-stay="true" data-thousands="." data-decimal="," value="<?php echo tratar_moeda($rfin["iptu"],2); ?>">
                    </div>
        
                    <div class="input_padrao sem_ml sem_mr" style="float:left;margin-right:1rem;">
                      Condominio <?php echo $nome_finalidade; ?>:
                      <br/>
                      <input type="text" class="input_padrao" name="condominio_<?php echo $rfin["id_finalidade"]; ?>" placeholder="" size="15" class="money" data-affixes-stay="true" data-thousands="." data-decimal="," value="<?php echo tratar_moeda($rfin["condominio"],2); ?>">
                    </div>
                  </div>
                <?php  
                }
              }
              else{?>
              <div class="valor_disabled">
                <div style="float:left;margin-right:1rem;">
                  Valor:<br/>
                  <input type="text" name="valor" placeholder="" size="15" class="money" data-affixes-stay="true" data-thousands="." data-decimal="," disabled>
                    <?php echo toltip("Selecione uma finalidade para liberar o campo valor"); ?>
                </div>
              </div>
              <?php
              }?>
            </div>
          </div>
          </div>
          
          <br/>
          
          Cidade:<br/>
          <?php
          $cidade_list = listar("cidade");?>
          <div class="input_padrao" style="float:left;">
            <select name="cidade" class="form_cadastro_cidade chosen-select input_padrao" style="min-width:20rem;" onchange="atualiza_bairro()">
              <?php
              while($r = mysql_fetch_assoc($cidade_list)){
                $selected = "";
                if($cidade == $r["id"]){$selected = "selected";}?>
              <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
              <?php
              }?>
            </select>
            <i class="fas fa-plus-circle icons_add" onclick="$('#add_cidade').fadeIn();"></i>
          </div>
          <?php
            $display_add = "none";
            if($add_cidade_name){$display_add = "block";}
          ?>
          <div id="add_cidade" style="float:left;display:<?php echo $display_add; ?>;">
            <input name="nova_cidade" id="ncidade" class="input_new" placeholder="Nova cidade" size="30" value="<?php echo $add_cidade_name; ?>">
            <i class="fas fa-times-circle icons_add" style="color:red;" onclick="$('#add_cidade').fadeOut();$('#ncidade').val('')"></i>
          </div>
          
          <br/><br/>
          
          Bairro:<br/>
          <?php
          if(!$cidade){$cidade = 1;}
          $bairro_list = mysql_query("SELECT * FROM bairro WHERE id_cidade = '$cidade' ORDER BY nome");?>
          <div class="retorno_cascata_bairro input_padrao" style="float:left;">
            <select name="bairro" class="chosen-select input_padrao" style="min-width:25rem;">
              <?php
              while($r = mysql_fetch_assoc($bairro_list)){
                $selected = "";
                if($bairro == $r["id"]){$selected = "selected";}?>
              <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
              <?php
              }?>
            </select>
            <i class="fas fa-plus-circle icons_add" onclick="$('#add_bairro').fadeIn();"></i>
          </div>
          <?php
            $display_add = "none";
            if($add_bairro_name){$display_add = "block";}
          ?>
          <div id="add_bairro" style="float:left;margin-left:0.5rem;display:<?php echo $display_add; ?>;">
            <input name="novo_bairro" id="nbairro" class="input_new" placeholder="Novo bairro" size="30" value="<?php echo $add_bairro_name; ?>">
            <?php echo toltip("O Bairro será cadastrado na cidade selecionada acima"); ?>
            <i class="fas fa-times-circle icons_add" style="color:red;" onclick="$('#add_bairro').fadeOut();$('#nbairro').val('')"></i>
          </div>
          
          <br/><br/>
          
          Cep:<br/>
          <input type="text" name="cep" placeholder="" size="10" value="<?php echo $cep; ?>">
          <?php echo toltip("Essa informação não será exibida no site."); ?>
          
          <br/><br/>
          
          Endereço:<br/>
          <input type="text" name="endereco" placeholder="" size="50" value="<?php echo $endereco; ?>">
          <?php echo toltip("Essa informação não será exibida no site."); ?>
          
          <br/><br/>
          
          Detalhes:<br/>
          <textarea name="detalhes" size="50" class="imob-100" style="height:150px;"><?php echo $detalhes; ?></textarea>
          
          <br/><br/>
          
          Observações:<br/>
          <textarea name="obs" size="50" class="imob-100" style="height:150px;"><?php echo $obs; ?></textarea>
        </div>
        
        <div class="imob-50 imob-right imob-border-left imob-padding-20 sem_borda">
          <div class="imob-100 imob-left">
            <table class="imob-tabela-20 imob-left">
              <tr>
                <td>Disponível:</td>
                <td>
                  <?php
                  $checked = "";
                  if($disponivel == 'S'){$checked = "checked";}?>
                  <input name="disponivel" <?php echo $checked; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S">
                  <span class="lbl"></span>
                  <?php echo toltip("Apenas imóveis disponíveis são exibidos no site."); ?>
                </td>
              </tr>
              <tr>
                <td>Super Destaque:</td>
                <td>
                  <?php
                  $checked = "";
                  if($super_destaque == 'S'){$checked = "checked";}?>
                  <input name="super_destaque" <?php echo $checked; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S">
                  <span class="lbl"></span>
                  <?php echo toltip('Exibido na aba "Nossos Lançamentos"'); ?>
                </td>
              </tr>
              <tr>
                <td>Destaque:</td>
                <td>
                  <?php
                  $checked = "";
                  if($destaque == 'S'){$checked = "checked";}?>
                  <input name="destaque" <?php echo $checked; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S">
                  <span class="lbl"></span>
                  <?php echo toltip('Exibido na aba Destaques na HOME'); ?>
                </td>
              </tr>
              <tr>
                <td>Financia:</td>
                <td>
                  <?php
                  $checked = "";
                  if($financia == 'S'){$checked = "checked";}?>
                  <input name="financia" <?php echo $checked; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S">
                  <span class="lbl"></span>
                  <?php echo toltip('Imóvel possui financiamento?'); ?>
                </td>
              </tr>
            </table>
          </div>
          
          <br/><br/>
          
          <div class="imob-100 imob-left imob-margin-top-20">
            <table class="imob-tabela-20 imob-left">
              <tr>
                <td>Quartos:</td>
                <td>
                  <input type="text" name="quarto" placeholder="" size="5" value="<?php echo $quarto; ?>">
                </td>
              </tr>
              <tr>
                <td>Suites:</td>
                <td>
                  <input type="text" name="suite" placeholder="" size="5" value="<?php echo $suite; ?>">
                </td>
              </tr>
              <tr>
                <td>Banheiros:</td>
                <td>
                  <input type="text" name="banheiro" placeholder="" size="5" value="<?php echo $banheiro; ?>">
                </td>
              </tr>
              <tr>
                <td>Garagem:</td>
                <td>
                  <input type="text" name="garagem" placeholder="" size="5" value="<?php echo $garagem; ?>">
                  <?php echo toltip("Garagem Coberta"); ?>
                </td>
              </tr>
              <tr>
                <td>Salas:</td>
                <td>
                  <input type="text" name="sala" placeholder="" size="5" value="<?php echo $sala; ?>">
                </td>
              </tr>
              <tr>
                <td>Terreno:</td>
                <td>
                  <input type="text" name="terreno" placeholder="" size="5" value="<?php echo $terreno; ?>"> m²
                </td>
              </tr>
              <tr>
                <td>Área Construida:</td>
                <td>
                  <input type="text" name="area_construida" placeholder="" size="5" value="<?php echo $area_construida; ?>"> m²
                </td>
              </tr>
              <tr>
                <td>Video Youtube:</td>
                <td>
                  <input type="text" name="video" placeholder="Ex: https://www.youtube.com/watch?v=HMUDVMiITOU" size="50" value="<?php if($video){echo "https://www.youtube.com/watch?v=".$video;} ?>">
                </td>
              </tr>
            </table>
            
            <div class="imob-100 imob-left imob-margin-top-20">
              <fieldset>
              <legend>Itens:</legend>
                <table class="imob-100">
                  <tr>
                    <?php
                    $itens = listar("item");
                    $cont = 0;
                    while($r = mysql_fetch_assoc($itens)){
                      $checked = "";
                      if(in_array($r["id"], $item)){$checked = "checked";}?>
                      <td class="imob-33">
                        <label>
                          <input name="item[]" type="checkbox" class="ace" value="<?php echo $r["id"]; ?>" <?php echo $checked; ?>>
                          <span class="lbl"> <?php echo $r["nome"]; ?></span>
                        </label>
                      </td>
                    <?php
                      $cont++;
                      if($cont % 3 == 0){
                        echo "</tr><tr>";
                      }
                    }?>
                  </tr>
                </table>
              </fieldset>
            </div>
          </div>
        </div>
        <div style="float:left;width:100%;padding-left:2rem;">
        <button class="btn-lg imob-botao-sucesso"><?php echo $botao; ?></button>
      </div>
    </form>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery.maskMoney.min.js" type="text/javascript"></script>

<script>
  //chosen plugin inside a modal will have a zero width because the select element is originally hidden
  //and its width cannot be determined.
  //so we set the width after modal is show
  $('#modal-form').on('shown.bs.modal', function () {
    $(this).find('.chosen-container').each(function(){
      $(this).find('a:first-child').css('width' , '210px');
      $(this).find('.chosen-drop').css('width' , '210px');
      $(this).find('.chosen-search input').css('width' , '200px');
    });
  })
  /**
  //or you can activate the chosen plugin after modal is shown
  //this way select element becomes visible with dimensions and chosen works as expected
  $('#modal-form').on('shown', function () {
    $(this).find('.modal-chosen').chosen();
  })
  */


  $(function() {
    $('.money').maskMoney();
  })
</script>

  