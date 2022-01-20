<?php
  $tabela = "item";
  $msg = "";
  if($_POST["op"] == "alterar"){
    $nome = $_POST["nome"];
    $nome_antigo = $_POST["nome_antigo"];
    if(isset($nome)){
      $s = "UPDATE $tabela SET nome = '$nome' WHERE id = '".$_POST["id_registro"]."'";
      mysql_query($s);
      
      $descricao_log = "Item alterado de <strong>$nome_antigo</strong> para <strong>$nome</strong>";
      gravalog($_SESSION["sessao_id_user"], 6, 2, $descricao_log, $s);
    }
    $msg = sucesso("Item Alterado com sucesso!");
  }
  elseif($_POST){
    $nome = $_POST["nome"];
    if(isset($nome)){
      $teste = mysql_query("SELECT * FROM $tabela WHERE nome = '$nome'");
      
      if(mysql_num_rows($teste)>0){
        $msg = alerta("Item $nome já existe!");
      }else{
        $s = "INSERT INTO $tabela (nome) VALUES ('$nome')";
        mysql_query($s);
        $msg = sucesso("Item $nome cadastrado com sucesso!");
      
        $descricao_log = "Item Inserido - $nome";
        gravalog($_SESSION["sessao_id_user"], 6, 1, $descricao_log, $s);
      }
    }
  }
  
  if($_GET["op"] == "excluir"){
    $s_nome = mysql_query("SELECT nome FROM $tabela WHERE id = '$id_registro'");
    $r_nome = mysql_fetch_assoc($s_nome);
    
    $id_registro = $_GET["id_registro"];
    $s = "DELETE FROM $tabela WHERE id = '$id_registro'";
    mysql_query($s);
    $msg = sucesso("Item excluido com sucesso!");
    
    $descricao_log = "Item excluido - ".$r_nome["nome"];
    gravalog($_SESSION["sessao_id_user"], 6, 3, $descricao_log, $s);
  }
  
  if($_GET["op"] == "editar"){
    $id_registro = $_GET["id_registro"];
    $campo_editar = retorna_campo($tabela, "nome", $id_registro);
    $op = "alterar";
  }

  $s = "SELECT * FROM $tabela ORDER BY nome";
  $q = mysql_query($s);
?>

<div class="page-content">
  <div class="page-header">
    <h1>
      Itens
    </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <?php echo $msg; ?>
    <div style="width:36rem;padding-left:1rem;">
      <div class="widget-box" style="margin-bottom:50px;">
        <div class="widget-header widget-header-flat">
          <h4 class="smaller">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Novo Item
          </h4>
        </div>
        <div class="widget-body">
          <div class="widget-main">
            <form method="POST" action="index.php?pg=itens" id="form_cadastro">
              <input type="hidden" name="op" value="<?php echo $op; ?>">
              <input type="hidden" name="nome_antigo" value="<?php echo $campo_editar; ?>">
              <input type="hidden" name="id_registro" value="<?php echo $id_registro; ?>">
              <br/>
              Nome:<br/>
              <input type="text" name="nome" placeholder="" style="width:100%;" value="<?php echo $campo_editar; ?>">
              <br/><br/>
              <input type="submit" style="display:none;">
              <button class="btn btn-primary" style="width:100%;" onclick="$('#form_cadastro').submit()">Cadastrar</button>
            </form>
          </div>
        </div>
      </div>
      
      <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="center">NOME</th>
            <th class="center" width="80">AÇÔES</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while($r = mysql_fetch_assoc($q)){?>
          <tr>
            <td class="center"><?php echo $r["nome"]; ?></td>
            <td class="center">
              <a href="index.php?pg=itens&op=editar&id_registro=<?php echo $r["id"]; ?>" style="display:block;float:left;width:2.5rem;margin-right:1rem;">
                <button class="btn btn-xs btn-info" style="margin-right:10px;width:2.5rem;">
                  <i class="icon-edit bigger-120"></i>
                </button>
              </a>
              
              <a href="index.php?pg=itens&op=excluir&id_registro=<?php echo $r["id"]; ?>"onclick="return confirm('Deseja excluir o registro?')" style="display:block;float:left;width:2.5rem;">
              <button class="btn btn-xs btn-danger">
                <i class="icon-trash bigger-120"></i>
              </button>
              </a>
            </td>
          </tr>
          <?php
          }?>
        </tbody>
      </table>
    </div>
  </div>
</div>