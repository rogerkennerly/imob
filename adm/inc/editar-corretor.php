<?php
  $id_usuario = $_GET["id"];
  if($_POST){
    $nome            = evita_injection($_POST["nome"]);
    $data_nascimento = evita_injection(tratar_data($_POST["data_nascimento"],1));
    $tipo            = 1; //corretor
    $detalhes        = evita_injection($_POST["detalhes"]);
    $ativo           = evita_injection($_POST["ativo"]);    if(!$ativo){$ativo     = "N";}
    $usuario         = evita_injection($_POST["usuario"]);
    $senha           = evita_injection($_POST["senha"]);
    $confirma_senha  = evita_injection($_POST["confirma_senha"]);
    $hoje = date("Y-m-d");
    
    
    $s = "UPDATE usuario SET 
    nome = '$nome',
    data_nascimento = '$data_nascimento',
    tipo = '$tipo',
    detalhes = '$detalhes',
    ativo = '$ativo',
    usuario = '$usuario'
    WHERE id = '$id_usuario'
    ";  
    if($q = mysql_query($s)){
      echo sucesso("Informações alteradas com sucesso!");
      
      $descricao_log = "Usuário alterado - $nome ($usuario)";
      gravalog($_SESSION["sessao_id_user"], 10, 2, $descricao_log, $s);
    }else{
      echo alerta("Erro ao gravar as alterações.");
    }
    
    if($_FILES["file"]['name']){
      $caminho_avatar = "assets/avatar/";
      
      $cname = rand(0, 10000000);
      $nome_avatar = $cname."_".$_FILES["file"]['name'];
     
      if(move_uploaded_file($_FILES["file"]['tmp_name'], $caminho_avatar.$nome_avatar)){
        // echo "ok";
        $s_avatar = "UPDATE usuario SET avatar = '$nome_avatar' WHERE id = '$id_usuario'";
        mysql_query($s_avatar);
      }else{
        // echo "erro";
      }
    }

    mysql_query("DELETE FROM permissao WHERE id_usuario = '$id_usuario'");
    $s_modulo_item = "SELECT DISTINCT modulo_item.id, modulo.id as id_modulo FROM modulo_item, modulo WHERE modulo.ativo = 'S' AND modulo_item.ativo = 'S' AND modulo_item.id_modulo = modulo.id";
    $q_modulo_item = mysql_query($s_modulo_item);
    $s_permissao_tudo = "";
    while($r_modulo_item = mysql_fetch_assoc($q_modulo_item)){
      $id_modulo_item = $r_modulo_item["id"];
      $id_modulo      = $r_modulo_item["id_modulo"];
      
      if($_POST["item$id_modulo_item"] == 'S'){
        $s_permissao = "INSERT INTO permissao (id_usuario, id_modulo, id_modulo_item) VALUES ('$id_usuario', '$id_modulo', '$id_modulo_item')";
        mysql_query($s_permissao);
        $s_permissao_tudo .= $s_permissao_tudo;
      }
    } 
    
    $sql_geral = $s." | ".$s_avatar." | ".$s_permissao_tudo;
    $descricao_log = "Usuário alterado - $nome ($usuario)";
    gravalog($_SESSION["sessao_id_user"], $descricao_log, $sql_geral);
  }
  
  $s = "SELECT * FROM usuario WHERE id = '$id_usuario'";
  $q = mysql_query($s);
  $r = mysql_fetch_assoc($q);
?>

<div class="page-content">
  <div class="page-header">
    <h1>
      Editar usuário
    </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <div class="col-xs-12">
      <form method="POST" action="" enctype="multipart/form-data" id="form_cadastro">
        <input type="hidden" name="op" value="<?php echo $op; ?>">
        <input type="hidden" name="id_imovel" value="<?php echo $id_imovel; ?>">
        <div class="imob-50 imob-left imob-padding-20">
          Nome:<br/>
          <input type="text" name="nome" placeholder="" size="50" value="<?php echo $r["nome"]; ?>">
          
          <br/><br/>
          
          Data de Nascimento:<br/>
          <input type="text" class="input-mask-date" name="data_nascimento" placeholder="" size="10" value="<?php echo tratar_data($r["data_nascimento"],2); ?>">
          
          <br/><br/>
          
          Foto / Avatar
          <br/>
					<input type="file" name="file" id="id-input-file-2" /> 
          
          <br/><br/>
          
          Detalhes:<br/>
          <textarea name="detalhes" size="50" class="imob-100 imob-height-250"><?php echo $r["detalhes"]; ?></textarea>
        </div>
        
        <div class="imob-50 imob-right imob-border-left imob-padding-20">
          <div class="imob-33 imob-left imob-margin-top-20" style="margin-bottom:1.5rem;margin-top:-1rem;">
            <table>
              <tr>
                <td>Ativo:</td>
                <td>
                  <input name="ativo" class="ace ace-switch ace-switch-6" type="checkbox" value="S" <?php if($r["ativo"] == 'S'){echo "checked";}?>>
                  <span class="lbl"></span>
                </td>
              </tr>
            </table>
          </div>
            
          <br/><br/>
        
          Usuário:<br/>
          <input type="text" name="usuario" placeholder="" size="40" value="<?php echo $r["usuario"]; ?>">
          
          <br/><br/>
          
          Preencha os campos de senha apenas se quiser alterar a senha atual:<br/><br/>
          Nova Senha:<br/>
          <input type="text" name="senha" placeholder="" size="15" value="">
          
          <br/><br/>
          
          Confirmar Senha:<br/>
          <input type="text" name="confirma_senha" placeholder="" size="15" value="">
            
          <br/><br/>
          
          <?php
          $modulo_item = mysql_query("SELECT * FROM permissao WHERE id_usuario = '$id_usuario'");
          while($r_mod_item = mysql_fetch_assoc($modulo_item)){
            $array_item[] = $r_mod_item["id_modulo_item"];
          }
          ?>
          
            <div class="imob-100 imob-left imob-margin-top-20">
              <fieldset>
              <legend>
                Permissões:
                <?php echo toltip("Selecione quais operações o usuário poderá fazer"); ?>
              </legend>
              
              <div style="font-size:1.2rem;margin-top:-1rem;margin-bottom:1rem;color:blue;float:left;width:100%;">
                <span id="marcar" style="cursor:pointer;" onclick="$('.checkbox_permissoes').prop('checked', true);$('#marcar').hide();$('#desmarcar').show()">MARCAR TODOS</span>
                <span id="desmarcar" style="cursor:pointer;display:none;" onclick="$('.checkbox_permissoes').prop('checked', false);$('#desmarcar').hide();$('#marcar').show()">DESMARCAR TODOS</span>
              </div>
              
              <div class="imob-33 imob-left">
                <?php
                $modulos = mysql_query("SELECT * FROM modulo WHERE ativo = 'S'");;
                ?>
                <table class="imob-100 imob-left">
                  <?php
                  $contador = 0;
                  while($r_modulos = mysql_fetch_assoc($modulos)){
                    $contador++;
                  ?>
                  <tr>
                      <td>
                        <span style="font-size:1.6rem;font-weight:bold;"><?php echo $r_modulos["nome"];?></span>
                      </td>
                  </tr>
                    <?php
                    $modulo_item = mysql_query("SELECT * FROM modulo_item WHERE id_modulo = '".$r_modulos["id"]."'");
                    while($r_modulo_item = mysql_fetch_assoc($modulo_item)){
                      $checked = "";
                      if(in_array($r_modulo_item["id"],$array_item)){
                        $checked = "checked";
                      }?>
                    <tr>
                        <td>
                          <label>
                            <input name="item<?php echo $r_modulo_item["id"]; ?>" type="checkbox" class="ace checkbox_permissoes" value="S" <?php echo $checked; ?>>
                            <span class="lbl"> <?php echo $r_modulo_item["nome"]; ?></span>
                          </label>
                        </td>
                    </tr>
                    <?php
                    }?>
                    <tr>
                      <td>&nbsp;</td>
                    </tr>
                  <?php  
                    if($contador % 4 == 0){?>
                      </table>
                      </div>
                      <div class="imob-33 imob-left">
                      <table class="imob-100 imob-left">
                    <?php
                    }
                  } 
                  ?>
                </table>
              </div>
              </fieldset>
            </div>
          </div>
        </div>
      </div>
      <input type="submit" style="display:none;">
    </form>
  </div>
<div style="float:left;width:100%;padding:0 3rem 3rem 3rem;">
  <button class="btn-lg imob-botao-sucesso" onclick="$('#form_cadastro').submit()">Gravar Alterações</button>
</div>
</div><!-- /.page-content -->

<script type="text/javascript">
  window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<script>
  jQuery(function($){
    $('.input-mask-date').mask('99/99/9999');
  });
</script>

		<script src="assets/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="assets/js/chosen.jquery.min.js"></script>
		<script src="assets/js/jquery.autosize.min.js"></script>
		<script src="assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
		<script src="assets/js/jquery.maskedinput.min.js"></script>
		<script src="assets/js/bootstrap-tag.min.js"></script>
		<script src="assets/js/ace-elements.min.js"></script>

		<!-- inline scripts related to this page -->

		<script type="text/javascript">
			jQuery(function($) {
				$('#id-input-file-1 , #id-input-file-2').ace_file_input({
					no_file:'Clique para enviar a imagem',
					btn_choose:'Procurar',
					btn_change:'Alterar',
					droppable:false,
					onchange:null,
					thumbnail:false //| true | large
					//whitelist:'gif|png|jpg|jpeg'
					//blacklist:'exe|php'
					//onchange:''
					//
				});
			
			});
		</script>