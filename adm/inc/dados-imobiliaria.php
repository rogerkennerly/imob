<?php
  $dados_imobiliaria = mysql_query('SELECT marcadagua FROM dados_imobiliaria');
  $dados_imobiliaria = mysql_fetch_assoc($dados_imobiliaria);
  $foto_marca_dagua = "fotos/".$dados_imobiliaria['marcadagua'];

  if($_POST){
    $nome       = evita_injection($_POST["nome"]);
    $doc        = evita_injection($_POST["doc"]);
    $pessoa     = evita_injection($_POST["pessoa"]);
    $creci      = evita_injection($_POST["creci"]);
    $telefone   = evita_injection($_POST["telefone"]);
    $celular    = evita_injection($_POST["celular"]);
    $email      = evita_injection($_POST["email"]);
    $estado     = evita_injection($_POST["estado"]);
    $id_cidade  = evita_injection($_POST["id_cidade"]);
    $bairro     = evita_injection($_POST["bairro"]);
    $enderecoold= evita_injection($_POST["enderecoold"]);
    $endereco   = evita_injection($_POST["endereco"]);
    $cep        = evita_injection($_POST["cep"]);
    $tipo       = evita_injection($_POST["tipo"]);
    $facebook   = evita_injection($_POST["facebook"]);
    $twitter    = evita_injection($_POST["twitter"]);
    $instagram  = evita_injection($_POST["instagram"]);
    $youtube    = evita_injection($_POST["youtube"]);
    
    
    $teste = listar("dados_imobiliaria");
    if(mysql_num_rows($teste)==0){
      $s = "INSERT INTO dados_imobiliaria (
      nome, 
      doc,     
      pessoa,     
      telefone, 
      celular,  
      email,    
      estado,   
      id_cidade,   
      bairro,   
      endereco, 
      cep, 
      facebook, 
      twitter, 
      instagram, 
      youtube,
      creci
      ) 
      VALUES (
      '$nome',   
      '$doc',   
      '$pessoa',   
      '$telefone', 
      '$celular',  
      '$email',    
      '$estado',   
      '$id_cidade',   
      '$bairro',   
      '$endereco', 
      '$cep', 
      '$facebook', 
      '$twitter', 
      '$instagram', 
      '$youtube',
      '$creci'
      )";
      
      mysql_query($s);
  
      $descricao_log = "Dados da imobiliária atualizados";
      gravalog($_SESSION["sessao_id_user"], 9, 1, $descricao_log, $s);
    }
    else{
      $s = "UPDATE dados_imobiliaria SET 
      nome = '$nome',     
      doc = '$doc',     
      pessoa = '$pessoa',     
      telefone = '$telefone', 
      celular = '$celular',  
      email = '$email',    
      estado = '$estado',   
      id_cidade = '$id_cidade',   
      bairro = '$bairro',   
      endereco = '$endereco', 
      cep = '$cep',
      facebook = '$facebook',
      twitter = '$twitter',
      instagram = '$instagram',
      youtube = '$youtube',
      creci = '$creci'
      ";
      if($enderecoold != $endereco){
        mysql_query("UPDATE dados_imobiliaria SET latitude = '', longitude = ''");
      }
      
      // echo $s;
      mysql_query($s);
  
      $descricao_log = "Dados da imobiliária atualizados";
      gravalog($_SESSION["sessao_id_user"], 9, 2, $descricao_log, $s);
    }
    
    if($_FILES["file"]['tmp_name']){
      $dir = "../clientes/".DIRETORIO."/assets/img/";
      
      $sl = "SELECT logo FROM dados_imobiliaria";
      $ql = mysql_query($sl);
      $rl = mysql_fetch_assoc($ql);
      $logo_antiga = $rl["logo"];
      
      unlink($dir.$logo_antiga);
      
      $nome = rand(999,99999)."_".$_FILES["file"]['name'];
      if(move_uploaded_file($_FILES["file"]['tmp_name'], $dir.$nome)){
        mysql_query("UPDATE dados_imobiliaria SET logo = '$nome'");
      }else{
        echo alerta("Erro ao mover ao a logo");
      }
    }
    
    if($_FILES["marcadagua"]['tmp_name']){
      $dir = "../clientes/".DIRETORIO."/assets/img/";
      
      $sl = "SELECT marcadagua FROM dados_imobiliaria";
      $ql = mysql_query($sl);
      $rl = mysql_fetch_assoc($ql);
      $logo_antiga = $rl["marcadagua"];
      
      unlink($dir.$logo_antiga);
      
      $nome = rand(999,99999)."_".$_FILES["marcadagua"]['name'];
      if(move_uploaded_file($_FILES["marcadagua"]['tmp_name'], $dir.$nome)){
        mysql_query("UPDATE dados_imobiliaria SET marcadagua = '$nome'");
      }else{
        echo "erro ao enviar a marcadagua";
      }
    }
  }
  
  $dados = listar("dados_imobiliaria");
  $dados = mysql_fetch_assoc($dados);
  
  $descricao_log = "Dados da imobiliária atualizados";
  gravalog($_SESSION["sessao_id_user"], $descricao_log, $s);
?>

<form method="POST" action="" id="form_cadastro" enctype="multipart/form-data">
<div class="col-xs-6">
  <div class="page-content">
    <div class="page-header">
      <h1>
        Dados da Imobiliária
      </h1>
    </div><!-- /.page-header -->

    <div class="row">
      <?php echo $msg; ?>
      <div class="col-xs-12 controle-chosen">
        <br/>
        Nome da Imobiliária:<br/>
        <input type="text" name="nome" placeholder="" size="80" value="<?php echo $dados["nome"]; ?>">
        <br/><br/>
        Creci:<br/>
        <input type="text" name="creci" placeholder="" size="20" value="<?php echo $dados["creci"]; ?>">
        <?php echo toltip("No caso de 2 CRECI, separe os números com ponto e vírgula"); ?>
        <br/><br/>
        Pessoa:<br/>
        <select name="pessoa">
          <option value="J" <?php if($dados["pessoa"] == "J"){echo "selected";}?>>Juridica</option>
          <option value="F" <?php if($dados["pessoa"] == "F"){echo "selected";}?>>Fisica</option>
        </select>
        <br/><br/>
        Documento:<br/>
        <input type="text" name="doc" placeholder="" size="20" value="<?php echo $dados["doc"]; ?>">
        <?php echo toltip("CPNJ ou CPF"); ?>
        <br/><br/>
        Telefone:<br/>
        <input type="text" name="telefone" placeholder="" size="20" value="<?php echo $dados["telefone"]; ?>">
        <?php echo toltip("Se utilizar mais de um número de telefone, separe os números com ponto e vírgula"); ?>
        <br/><br/>
        Celular:<br/>
        <input type="text" name="celular" placeholder="" size="20" value="<?php echo $dados["celular"]; ?>">
        <?php echo toltip("O primeiro número será utilizado como whatsapp (Se utilizar mais de um número de celular, separe os números com ponto e vírgula)"); ?>
        <br/><br/>
        E-mail:<br/>
        <input type="text" name="email" placeholder="" size="70" value="<?php echo $dados["email"]; ?>">
        <?php echo toltip("E-mail que receberá os contatos do site (Se utilizar mais de um e-mail, separe os e-mails com ponto e vírgula)"); ?>
        <br/><br/>
        Estado:<br/>
        <select name="estado">
          <option value="AC" <?php if($dados["estado"] == "AC"){echo "selected";}?>>Acre</option>
          <option value="AL" <?php if($dados["estado"] == "AL"){echo "selected";}?>>Alagoas</option>
          <option value="AP" <?php if($dados["estado"] == "AP"){echo "selected";}?>>Amapá</option>
          <option value="AM" <?php if($dados["estado"] == "AM"){echo "selected";}?>>Amazonas</option>
          <option value="BA" <?php if($dados["estado"] == "BA"){echo "selected";}?>>Bahia</option>
          <option value="CE" <?php if($dados["estado"] == "CE"){echo "selected";}?>>Ceará</option>
          <option value="DF" <?php if($dados["estado"] == "DF"){echo "selected";}?>>Distrito Federal</option>
          <option value="ES" <?php if($dados["estado"] == "ES"){echo "selected";}?>>Espírito Santo</option>
          <option value="GO" <?php if($dados["estado"] == "GO"){echo "selected";}?>>Goiás</option>
          <option value="MA" <?php if($dados["estado"] == "MA"){echo "selected";}?>>Maranhão</option>
          <option value="MT" <?php if($dados["estado"] == "MT"){echo "selected";}?>>Mato Grosso</option>
          <option value="MS" <?php if($dados["estado"] == "MS"){echo "selected";}?>>Mato Grosso do Sul</option>
          <option value="MG" <?php if($dados["estado"] == "MG"){echo "selected";}?>>Minas Gerais</option>
          <option value="PA" <?php if($dados["estado"] == "PA"){echo "selected";}?>>Pará</option>
          <option value="PB" <?php if($dados["estado"] == "PB"){echo "selected";}?>>Paraíba</option>
          <option value="PR" <?php if($dados["estado"] == "PR"){echo "selected";}?>>Paraná</option>
          <option value="PE" <?php if($dados["estado"] == "PE"){echo "selected";}?>>Pernambuco</option>
          <option value="PI" <?php if($dados["estado"] == "PI"){echo "selected";}?>>Piauí</option>
          <option value="RJ" <?php if($dados["estado"] == "RJ"){echo "selected";}?>>Rio de Janeiro</option>
          <option value="RN" <?php if($dados["estado"] == "RN"){echo "selected";}?>>Rio Grande do Norte</option>
          <option value="RS" <?php if($dados["estado"] == "RS"){echo "selected";}?>>Rio Grande do Sul</option>
          <option value="RO" <?php if($dados["estado"] == "RO"){echo "selected";}?>>Rondônia</option>
          <option value="RR" <?php if($dados["estado"] == "RR"){echo "selected";}?>>Roraima</option>
          <option value="SC" <?php if($dados["estado"] == "SC"){echo "selected";}?>>Santa Catarina</option>
          <option value="SP" <?php if($dados["estado"] == "SP"){echo "selected";}?>>São Paulo</option>
          <option value="SE" <?php if($dados["estado"] == "SE"){echo "selected";}?>>Sergipe</option>
          <option value="TO" <?php if($dados["estado"] == "TO"){echo "selected";}?>>Tocantins</option>
        </select>
        <br/><br/>
        Cidade:<br/>
        <?php $cidade_list = listar("cidade"); ?>
        <div style="float:left;">
        <select name="id_cidade" class="form_cadastro_cidade chosen-select" style="min-width:20rem;" onchange="atualiza_bairro()">
          <?php
          while($r = mysql_fetch_assoc($cidade_list)){
            $selected = "";
            if($dados['id_cidade'] == $r["id"]){$selected = "selected";}?>
          <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
          <?php
          }?>
        </select>
        </div>
        <br/><br/>
        Bairro:<br/>
        <input type="text" name="bairro" placeholder="" size="80" value="<?php echo $dados["bairro"]; ?>">
        <br/><br/>
        Endereço:<br/>
        <input type="hidden" name="enderecoold" value="<?php echo $dados["endereco"]; ?>">
        <input type="text" name="endereco" placeholder="" size="80" value="<?php echo $dados["endereco"]; ?>">
        <br/><br/>
        Cep:<br/>
        <input type="text" name="cep" placeholder="" size="15  " value="<?php echo $dados["cep"]; ?>">
        <br/><br/>
        <input type="submit" style="display:none;">
      </div>
    </div>
  </div>
</div>

<div class="col-xs-6">
  <div class="page-content">
    <div class="page-header">
      <h1>
        Logotipo
      </h1>
    </div><!-- /.page-header -->
    
    <div class="col-xs-6">
      <div class="row">
        <?php echo $msg; ?>
        <div class="col-xs-12">
          <div class="widget-box">
            <div class="widget-header">
              <h4>Logo</h4>
            </div>

            <div class="widget-body">
              <div class="widget-main" style="min-height:295px;">
                <input type="file" class="id-input-file-2" name="file" />
                <input type="hidden" name="teste"  value="aa"/>
                <br/>
                Logo atual:<br/><br/>
                <?php 
                  if($dados['logo']){
                    $logo = $dados['logo'];
                  }else{
                    $logo = "logo.png";
                  }
                ?>
                <img src="../clientes/<?php echo DIRETORIO; ?>/assets/img/<?php echo $logo; ?>" width="250">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-xs-6">
      <div class="row">
        <?php echo $msg; ?>
        <div class="col-xs-12">
          <div class="widget-box">
            <div class="widget-header">
              <h4>Marca D'água</h4>
            </div>

            <div class="widget-body">
              <div class="widget-main" style="min-height:295px;">
                  <input type="file" class="id-input-file-2" name="marcadagua" />
                  <input type="hidden" name="teste"  value="aa"/>
                <br/>
                Marca D'água atual:<br/><br/>
                <?php 
                  if($dados['marcadagua']){
                    $marcadagua = $dados['marcadagua'];
                  }else{
                    $marcadagua = "logo.png";
                  }
                ?>
                <img src="../clientes/<?php echo DIRETORIO; ?>/assets/img/<?php echo $marcadagua; ?>" width="250">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="col-xs-6">
  <div class="page-content">
    <div class="page-header">
      <h1>
        Redes Sociais
      </h1>
    </div><!-- /.page-header -->
    
    <div class="row">
      <?php echo $msg; ?>
      <div class="col-xs-12">
          <br/>
          Facebook:<br/>
          <input type="text" name="facebook" placeholder="" size="80" value="<?php echo $dados["facebook"]; ?>">
          <br/><br/>
          Twitter:<br/>
          <input type="text" name="twitter" placeholder="" size="80" value="<?php echo $dados["twitter"]; ?>">
          <br/><br/>
          Instagram:<br/>
          <input type="text" name="instagram" placeholder="" size="80" value="<?php echo $dados["instagram"]; ?>">
          <br/><br/>
          Youtube:<br/>
          <input type="text" name="youtube" placeholder="" size="80" value="<?php echo $dados["youtube"]; ?>">
          <br/><br/>
          <input type="submit" style="display:none;">
      </div>
    </div>
  </div>
</div>
</form>

<div style="float:left;width:100%;padding:0 3rem 3rem 3rem;">
  <button class="btn-lg imob-botao-sucesso" onclick="$('#form_cadastro').submit()">Gravar Alterações</button>
</div>

<script type="text/javascript">
  window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<script type="text/javascript">
  jQuery(function($) {				
    $('.id-input-file-2').ace_file_input({
      no_file:'Clique para selecionar a imagem',
      btn_choose:'Selecionar',
      btn_change:'Alterar',
      droppable:false,
      onchange:null,
      thumbnail:false, //| true | large
      //whitelist:'gif|png|jpg|jpeg'
      //blacklist:'exe|php'
      //onchange:alert(123)
      //
    });
  });
</script>