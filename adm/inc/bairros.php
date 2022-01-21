<?php if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) { exit(); } ?>
<?php
  $tabela = "bairro";
  $msg = "";
  
  if($_POST["op"] == "alterar"){
    $nome        = evita_injection($_POST["nome"]);
    $nome_antigo = evita_injection($_POST["nome_antigo"]);
    $id_cidade = evita_injection($_POST["id_cidade"]);
    if(isset($nome)){
      $id_registro = evita_injection($_POST["id_registro"]);
      $s = "UPDATE $tabela SET nome = '$nome', id_cidade = '$id_cidade' WHERE id = '".$id_registro."'";
      // echo $s;
      mysql_query($s);
      
      $descricao_log = "Bairro alterado de $nome_antigo para $nome";
      gravalog($_SESSION["sessao_id_user"], 5, 2, $descricao_log, $s);
    }
    $msg = sucesso("Bairro Alterado com sucesso!");
    $cidade_atual = $id_cidade;
  }
  elseif($_POST){
    $nome      = evita_injection($_POST["nome"]);
    $id_cidade = evita_injection($_POST["id_cidade"]);
    if(isset($nome)){
      $teste = mysql_query("SELECT * FROM $tabela WHERE nome = '$nome' AND id_cidade = '$id_cidade'");
      
      if(mysql_num_rows($teste)>0){
        $msg = alerta("Bairro $nome já existe!");
      }else{
        $s = "INSERT INTO $tabela (nome, id_cidade) VALUES ('$nome', '$id_cidade')";
        mysql_query($s);
        $msg = sucesso("Bairro $nome cadastrada com sucesso!");
      
        $descricao_log = "Bairro incluido - $nome";
        gravalog($_SESSION["sessao_id_user"], 5, 1, $descricao_log, $s);
      }
    }
  }
  
  if($_GET["op"] == "excluir"){
    $id_registro = evita_injection($_GET["id_registro"]);
    $s_nome = mysql_query("SELECT * FROM imovel WHERE id_bairro IN (SELECT id FROM bairro WHERE id = '$id_registro')");
    // $s_nome = mysql_query("SELECT nome, id_cidade, id FROM $tabela WHERE id = '$id_registro'");
    $r_nome = mysql_fetch_assoc($s_nome);
    
		if(mysql_num_rows($s_nome)<1){
			$id_registro = evita_injection($_GET["id_registro"]);
			$s = "DELETE FROM $tabela WHERE id = '$id_registro'";
			mysql_query($s);
			$msg = sucesso("Bairro excluido com sucesso!");
			
			$descricao_log = "Bairro excluido - ".$r_nome["nome"]." com id:".$r_nome["id"]." (cidade: ".$r_nome["id_cidade"].")";
			gravalog($_SESSION["sessao_id_user"], 5, 3, $descricao_log, $s);
		}
		else{
			$msg = alerta("O bairro '<strong>".$r_nome["nome"]."</strong>' não pode ser excluido pois existem imóveis atrelados a ele.");
		}
  }
  
  $display_cad = "style='display:none;'";
  $display_cidade = "style='display:block;'";
  if($_GET["op"] == "editar"){
    $id_registro = evita_injection($_GET["id_registro"]);
    $id_cidade   = evita_injection($_GET["id_cidade"]);
    $campo_editar = retorna_campo($tabela, "nome", $id_registro);
    $op = "alterar";
    
    $display_cad = "style='display:block;'";
    $display_cidade = "style='display:none;'";
  }
  
  if($_GET['cidade_atual'] OR $cidade_atual){
    if($_GET['cidade_atual']){$cidade_atual = evita_injection($_GET['cidade_atual']);}

    $s = "SELECT * FROM $tabela WHERE id_cidade = '$cidade_atual' ORDER BY nome";
    $q = mysql_query($s);
  }
?>

<div class="page-content">
  <div class="page-header">
    <h1>
      Bairros
    </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <?php echo $msg; ?>
    <div style="width:55rem;padding-left:1rem;">
      <div class="widget-box" style="margin-bottom:50px;">
        <div class="widget-header widget-header-flat" style="cursor:pointer;" onclick="$('#cad_bairro').toggle()">
          <h4 class="smaller">
            <?php
            if($_GET['op'] == 'editar'){echo "Editar Bairro";}
            else{echo '<i class="fa fa-plus" aria-hidden="true"></i> Cadastrar Novo Bairro';}?>
          </h4>
        </div>
        <div class="widget-body" id="cad_bairro" <?php echo $display_cad; ?>>
          <div class="widget-main">
            <form method="POST" action="index.php?pg=bairros" id="form_cadastro">
              <input type="hidden" name="op" value="<?php echo $op; ?>">
              <input type="hidden" name="nome_antigo" value="<?php echo $campo_editar; ?>">
              <input type="hidden" name="id_registro" value="<?php echo $id_registro; ?>">
              <br/>
              Cidade:<br/>
              <?php
              $cidade = listar("cidade");?>
              <select name="id_cidade" class="form_cadastro_cidade" onchange="atualiza_bairro()" style="width:100%;">
                <?php
                while($r = mysql_fetch_assoc($cidade)){
                  $selected = "";
                  if($id_cidade == $r["id"]){$selected = "selected";}?>
                <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
                <?php
                }?>
              </select>
              <br/><br/>
              Nome:<br/>
              <input type="text" name="nome" placeholder="" style="width:100%;" value="<?php echo $campo_editar; ?>">
              <br/><br/>
              <input type="submit" style="display:none;">
              <button class="btn btn-primary" style="width:100%;" onclick="$('#form_cadastro').submit()">Cadastrar</button>
            </form>
          </div>
        </div>
      </div>

      
      <div class="widget-box" style="margin-bottom:50px;">
        <div class="widget-header widget-header-flat" style="cursor:pointer;" onclick="$('#cidade_bairro').toggle()">
          <h4 class="smaller">
            Cidade
          </h4>
        </div>
        <div class="widget-body" id="cidade_bairro" <?php echo $display_cidade; ?>>
          <div class="widget-main">
            <form method="GET" action="index.php?pg=bairros" id="form_cidade_atual">
              <input type="hidden" name="pg" value="bairros">
              Cidade:<br/>
              <?php
              $cidade = listar("cidade");?>
              <select name="cidade_atual" class="form_cadastro_cidade" style="width:100%;">
                <option>Selecione uma cidade</option>
                <?php
                while($r = mysql_fetch_assoc($cidade)){
                  $selected = "";
                  if($cidade_atual == $r["id"]){$selected = "selected";}?>
                <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
                <?php
                }?>
              </select>
              <br/><br/>
              <input type="submit" style="display:none;">
              <button class="btn btn-primary" style="width:100%;" onclick="$('#form_cidade_atual').submit()">Listar bairros</button>
            </form>
          </div>
        </div>
      </div>
      

      <?php
      if($cidade_atual){?>
      <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="center">Bairro</th>
            <th class="center">Cidade</th>
            <th class="center" width="80">AÇÔES</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while($r = mysql_fetch_assoc($q)){?>
          <tr>
            <td class="center"><?php echo $r["nome"]; ?></td>
            <td class="center"><?php echo retorna_campo("cidade","nome",$r["id_cidade"]); ?></td>
            <td class="center">
              <a href="index.php?pg=bairros&op=editar&id_registro=<?php echo $r["id"]; ?>&id_cidade=<?php echo $r["id_cidade"]; ?>" style="display:block;float:left;width:2.5rem;margin-right:1rem;">
                <button class="btn btn-xs btn-info" style="margin-right:10px;width:2.5rem;">
                  <i class="icon-edit bigger-120"></i>
                </button>
              </a>
              
              <a href="index.php?pg=bairros&op=excluir&id_registro=<?php echo $r["id"]; ?>&cidade_atual=<?php echo $cidade_atual; ?>"onclick="return confirm('Deseja excluir o registro?')" style="display:block;float:left;width:2.5rem;">
              <button class="btn btn-xs btn-danger">
                <i class="icon-trash bigger-120"></i>
              </button>
              </a>
            </td>
          </tr>
          <?php
          }
          if(mysql_num_rows($q)<1){?>
            <tr>
              <td colspan="3">Nenhum bairro encontrado</td>
            </tr>
          <?php
          }?>
        </tbody>
      </table>
      <?php
      }?>
    </div>
  </div>
</div>