<?php
  if($_GET['modulo'] == 'gbol'){mysql_set_charset('utf8', $link);}
  if($_POST["op"] == "incluir"){
    $id_corretor     = evita_injection($_POST["id_corretor"]);
    $nome            = evita_injection($_POST["nome"]);
    $rg              = evita_injection($_POST["rg"]);
    $cpf             = evita_injection($_POST["cpf"]);
    $data_nascimento = evita_injection(tratar_data($_POST["data_nascimento"],1));
    $telefone        = evita_injection($_POST["telefone"]);
    $celular         = evita_injection($_POST["celular"]);
    $email           = evita_injection($_POST["email"]);
    $cidade          = evita_injection($_POST["cidade"]);
    $bairro          = evita_injection($_POST["bairro"]);
    $cep             = evita_injection($_POST["cep"]);
    $endereco        = evita_injection($_POST["endereco"]);
    $detalhes        = evita_injection($_POST["detalhes"]);
    $hoje = date("Y-m-d");
    
    if($nome AND $cpf){
      $teste_nome = mysql_query("SELECT nome from cliente WHERE cpf = '$cpf'");
      if(mysql_num_rows($teste_nome)<1){
        $s = "INSERT INTO cliente ( 
        id_corretor,
        nome,
        rg,
        cpf,
        data_nascimento,
        telefone,
        celular,
        email,
        cidade,
        bairro,
        cep,
        endereco,
        detalhes,
        data_cadastro
        ) VALUES (
        '$id_corretor',
        '$nome',
        '$rg',
        '$cpf',
        '$data_nascimento',
        '$telefone',
        '$celular',
        '$email',
        '$cidade',
        '$bairro', 
        '$cep', 
        '$endereco', 
        '$detalhes', 
        NOW() 
        )";  
        $q = mysql_query($s);
        
        $descricao_log = "Cliente incluido - $nome";
        gravalog($_SESSION["sessao_id_user"], 12, 1, $descricao_log, $s);
          
        $redirect = 'index.php?pg=listar-cliente&ok=1&nome='.$nome;
        if($_GET['modulo'] == 'gbol'){$redirect = 'index.php?modulo=gbol&pg=clientes';}
        echo "<script>location.href='$redirect';</script>";
      }
      else{
        echo alerta('J?? existe um cliente com o CPF "'.$cpf.'"');
      }
    }  
    else{
      echo alerta('Os campos "Nome" e "CPF" s??o obrigat??rios!');
    }
  }
  elseif($_POST["op"] == "editar"){
    $id_corretor     = evita_injection($_POST["id_corretor"]);
    $nome            = evita_injection($_POST["nome"]);
    $rg              = evita_injection($_POST["rg"]);
    $cpf             = evita_injection($_POST["cpf"]);
    $data_nascimento = evita_injection(tratar_data($_POST["data_nascimento"],1));
    $telefone        = evita_injection($_POST["telefone"]);
    $celular         = evita_injection($_POST["celular"]);
    $email           = evita_injection($_POST["email"]);
    $cidade          = evita_injection($_POST["cidade"]);
    $bairro          = evita_injection($_POST["bairro"]);
    $cep             = evita_injection($_POST["cep"]);
    $endereco        = evita_injection($_POST["endereco"]);
    $detalhes        = evita_injection($_POST["detalhes"]);
    $id_cliente 		 = evita_injection($_POST["id_cliente"]);
    
    $s = "UPDATE cliente SET 
    id_corretor = '$id_corretor',
    nome = '$nome',
    rg = '$rg',
    cpf = '$cpf',
    data_nascimento = '$data_nascimento',
    telefone = '$telefone',
    celular = '$celular',
    email = '$email',
    cidade = '$cidade',
    bairro = '$bairro',
    cep = '$cep',
    endereco = '$endereco',
    detalhes = '$detalhes' 
    WHERE id = '$id_cliente'
    ";
    $q = mysql_query($s);
    
    $descricao_log = "Cliente alterado";
    gravalog($_SESSION["sessao_id_user"], 12, 2, $descricao_log, $s);
  }
  
  $op = "incluir";
  
  if($_GET["op"] == "editar"){
    $op = $_GET["op"];
    $id_cliente = $_GET["id_cliente"];
    
    $s = "SELECT * FROM cliente WHERE id = '$id_cliente'";
		
		$config = listar("config");
		$config = mysql_fetch_assoc($config);
		if($config['restricao_clientes'] == 'S' AND $_SESSION["sessao_tipo_user"] == 1){
			$s .= " AND id_corretor = '".$_SESSION["sessao_id_user"]."'";
		}
		// echo $s;
    $q = mysql_query($s);
		if(mysql_num_rows($q)<1){
			echo alerta("Cliente n??o encontrado!");exit;
		}
    $r_proprietario = mysql_fetch_assoc($q);
  }
  elseif($_GET["op"] == "excluir"){
    $id_cliente = $_GET["id_cliente"];
    
    $s = "SELECT * FROM cliente WHERE id = '$id_cliente'";
    $q = mysql_query($s);
    $r_proprietarioz = mysql_fetch_assoc($q);
    $nome_excluido = $r_proprietarioz["nome"];
    
    $s = "DELETE FROM cliente WHERE id = '$id_proprietario'";
    $q = mysql_query($s);
    
    $descricao_log = "Cliente excluido [$id_proprietario] $nome_excluido";
    gravalog($_SESSION["sessao_id_user"], 12, 3, $descricao_log, $s);
      
    echo "<script>location.href='index.php?pg=listar-cliente';</script>";
  }
?>

<div class="page-content">
  <div class="page-header">
    <h1>
      <?php 
      if($modulo == 'gbol'){
        if($op == 'editar'){
          echo "Editar Cliente";
        }else{
          echo "Incluir Cliente";
        }
      }else{ 
        if($op == 'editar'){
          echo "Editar Cliente";
        }else{
          echo "Incluir Cliente";
        }
      }?>
    </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <div class="col-xs-12">
      <form method="POST" action="" enctype="multipart/form-data">
        <input type="hidden" name="op" value="<?php echo $op; ?>">
        <input type="hidden" name="id_cliente" value="<?php echo $id_cliente; ?>">
        <div class="imob-50 imob-left imob-padding-20">
          Corretor:<br/>
					<?php
					$s = "SELECT * FROM usuario WHERE tipo = 1";
					$q = mysql_query($s);?>
          <select name="id_corretor">
						<?php
						while($r = mysql_fetch_assoc($q)){?>
							<option value="<?php echo $r['id']; ?>"><?php echo $r['nome']; ?></option>
						<?php
						}?>
          </select>
          
          <br/><br/>
					
          Nome:<br/>
          <input type="text" name="nome" placeholder="" size="60" value="<?php echo $r_proprietario["nome"]; ?>" required>
          
          <br/><br/>
          
          RG:<br/>
          <input type="text" name="rg" placeholder="" size="15" value="<?php echo $r_proprietario["rg"]; ?>">
          
          <br/><br/>
          
          CPF:<br/>
          <input type="text" name="cpf" class="cpf" placeholder="" size="15" value="<?php echo $r_proprietario["cpf"]; ?>" required>
          
          <br/><br/>
          
          Data de Nascimento:<br/>
          <input type="text" class="input-mask-date" name="data_nascimento" placeholder="" size="10" value="<?php echo tratar_data($r_proprietario["data_nascimento"],2); ?>">
          
          <br/><br/>
          
          Telefone:<br/>
          <input type="text" class="telefone" name="telefone" placeholder="" size="15" value="<?php echo $r_proprietario["telefone"]; ?>">
          
          <br/><br/>
          
          Celular:<br/>
          <input type="text" class="celular" name="celular" placeholder="" size="15" value="<?php echo $r_proprietario["celular"]; ?>">
          
          <br/><br/>
          
          E-mail:<br/>
          <input type="text" name="email" placeholder="" size="50" value="<?php echo $r_proprietario["email"]; ?>">
          
          <br/><br/>
          
          Cidade:<br/>
          <input type="text" name="cidade" placeholder="" size="50" value="<?php echo $r_proprietario["cidade"]; ?>">
          
          <br/><br/>
          
          Bairro:<br/>
          <input type="text" name="bairro" placeholder="" size="50" value="<?php echo $r_proprietario["bairro"]; ?>">
          
          <br/><br/>
          
          Cep:<br/>
          <input type="text" name="cep" placeholder="" size="10" value="<?php echo $r_proprietario["cep"]; ?>">
          
          <br/><br/>
          
          Endere??o:<br/>
          <input type="text" name="endereco" placeholder="" size="80" value="<?php echo $r_proprietario["endereco"]; ?>">
          
          <br/><br/>
          
          Detalhes:<br/>
          <textarea name="detalhes" size="50" class="imob-100" style="height:150px;"><?php echo $r_proprietario["detalhes"]; ?></textarea>
          
        </div>
        
        <!--div class="imob-50 imob-right imob-border-left imob-padding-20">
          <div class="imob-33 imob-left imob-margin-top-20" style="margin-bottom:1.5rem;margin-top:-1rem;">
            <table>
              <tr>
                <td>Ativo:</td>
                <td>
                  <input name="ativo" checked class="ace ace-switch ace-switch-6" type="checkbox" value="S">
                  <span class="lbl"></span>
                </td>
              </tr>
            </table>
          </div>
            
          <br/><br/>
        
          Usu??rio:<br/>
          <input type="text" name="usuario" placeholder="" size="40" value="<?php echo $imovel["ref"]; ?>">
          
          <br/><br/>
          
          Senha:<br/>
          <input type="text" name="senha" placeholder="" size="15" value="<?php echo $imovel["ref"]; ?>">
          
          <br/><br/>
          
          Confirmar Senha:<br/>
          <input type="text" name="confirma_senha" placeholder="" size="15" value="<?php echo $imovel["ref"]; ?>">
            
          <br/><br/>
          
            <div class="imob-100 imob-left imob-margin-top-20">
              <fieldset>
              <legend>
                Permiss??es:
                <?php echo toltip("Selecione quais opera????es o usu??rio poder?? fazer"); ?>
              </legend>
              <div class="imob-33 imob-left">
                <?php
                $modulos = mysql_query("SELECT * FROM modulo WHERE ativo = 'S'");;
                ?>
                <table class="imob-100 imob-left">
                  <?php
                  $contador = 0;
                  while($r_proprietario_modulos = mysql_fetch_assoc($modulos)){
                    $contador++;
                  ?>
                  <tr>
                      <td>
                        <span style="font-size:1.6rem;font-weight:bold;"><?php echo $r_proprietario_modulos["nome"];?></span>
                      </td>
                  </tr>
                    <?php
                    $modulo_item = mysql_query("SELECT * FROM modulo_item WHERE id_modulo = '".$r_proprietario_modulos["id"]."'");
                    while($r_proprietario_modulo_item = mysql_fetch_assoc($modulo_item)){?>
                    <tr>
                        <td>
                          <label>
                            <input name="item<?php echo $r_proprietario_modulo_item["id"]; ?>" type="checkbox" class="ace" value="S" <?php echo $checked; ?>>
                            <span class="lbl"> <?php echo $r_proprietario_modulo_item["nome"]; ?></span>
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
          </div-->
        </div>
        <div style="float:100%;width:100%;padding:0 3rem;">
        <button class="btn-lg imob-botao-sucesso">GRAVAR</button>
      </div>
    </form>
  </div>
</div><!-- /.page-content -->

<script type="text/javascript">
  window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>

<script>
  jQuery(function($){
    $('.input-mask-date').mask('99/99/9999');
    $('.telefone').mask('(99) 9999-9999');
    $('.celular').mask('(99) 9 9999-9999');
    $('.cpf').mask('999.999.999-99');
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