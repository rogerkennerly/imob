<?php
  $tabela = "usuario";
  $msg = "";
  if($_POST["op"] == "alterar"){
    $nome = $_POST["nome"];
    if(isset($nome)){
      mysql_query("UPDATE $tabela SET nome = '$nome' WHERE id = '".$_POST["id_registro"]."'");
    }
    $msg = sucesso("Corretor Alterado com sucesso!");
  }
  elseif($_POST){
    $nome = $_POST["nome"];
    if(isset($nome)){
      $teste = mysql_query("SELECT * FROM $tabela WHERE nome = '$nome'");
      
      if(mysql_num_rows($teste)>0){
        $msg = alerta("Corretor $nome já existe!");
      }else{
        mysql_query("INSERT INTO $tabela (nome) VALUES ('$nome')");
        $msg = sucesso("Corretor $nome cadastrado com sucesso!");
      }
    }
  }
  
  if($_GET["op"] == "excluir"){
    $id_registro = $_GET["id_registro"];
    
    $s_nome = "SELECT nome, usuario FROM $tabela WHERE id = '$id_registro'";
    $q_nome = mysql_query($s_nome);
    $r_nome = mysql_fetch_assoc($q_nome);
    $nome    = $r_nome["nome"];
    $usuario = $r_nome["usuario"];
    
    $sql_geral = "DELETE FROM $tabela WHERE id = '$id_registro'";
    mysql_query($sql_geral);
    $msg = sucesso("Corretor excluido com sucesso!");
    
    $descricao_log = "Corretor excluido - $nome ($usuario)";
    gravalog($_SESSION["sessao_id_user"], 10, 3, $descricao_log, $sql_geral);
  }
  
  if($_GET["op"] == "editar"){
    $id_registro = $_GET["id_registro"];
    $campo_editar = retorna_campo($tabela, "nome", $id_registro);
    $op = "alterar";
  }

  $s = "SELECT * FROM $tabela WHERE tipo = 1";
  $q = mysql_query($s);
?>

<div class="page-content">
  <div class="page-header">
    <h1>
      Corretores
    </h1>
  </div><!-- /.page-header -->

  <div class="row">      
    <div class="col-xs-8">
      <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="center" width="60">FICHA</th>
            <th class="center" width="60">AVATAR</th>
            <th>USUÁRIO</th>
            <th>NOME</th>
            <th class="center">TIPO</th>
            <th class="center">ÚLTIMO LOGIN</th>
            <th class="center" width="80">AÇÔES</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while($r = mysql_fetch_assoc($q)){?>
          <tr>
            <td class="center" style="vertical-align:middle;">
              <a href="index.php?pg=perfil&id=<?php echo $r["id"]; ?>">
                <i class="fas fa-user-circle" style="font-size:2rem;"></i>
              </a>
            </td>
            <td class="center"><img src="assets/avatar/<?php echo $r["avatar"]; ?>" width="40"></td>
            <td><?php echo $r["usuario"]; ?></td>
            <td><?php echo $r["nome"]; ?></td>
            <td class="center"><?php echo usuario_tipo($r["tipo"]); ?></td>
            <td class="center"><?php echo $r["ultimo_login"]; ?></td>
            <td class="center">
              <a href="index.php?pg=editar-corretor&id=<?php echo $r["id"]; ?>" style="display:block;float:left;width:2.5rem;margin-right:1rem;">
                <button class="btn btn-xs btn-info" style="margin-right:10px;width:2.5rem;">
                  <i class="icon-edit bigger-120"></i>
                </button>
              </a>
              
              <a href="index.php?pg=corretores&op=excluir&id_registro=<?php echo $r["id"]; ?>"onclick="return confirm('Deseja excluir o registro?')" style="display:block;float:left;width:2.5rem;">
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