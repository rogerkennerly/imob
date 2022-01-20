<?php
  $tabela = "contato";
  $msg = "";
  
  if($_GET["op"] == "excluir"){
    $id_registro = $_GET["id_registro"];
    mysql_query("DELETE FROM $tabela WHERE id = '$id_registro'");
    $msg = sucesso("Usuaário excluido com sucesso!");
  }
  
  if($_GET["op"] == "editar"){
    $id_registro = $_GET["id_registro"];
    $campo_editar = retorna_campo($tabela, "nome", $id_registro);
    $op = "alterar";
  }

  $s = "SELECT * FROM $tabela ORDER BY id DESC";
  $q = mysql_query($s);
?>

<div class="page-content">
  <div class="page-header">
    <h1>
      Contatos
    </h1>
  </div><!-- /.page-header -->

  <div class="row">      
    <div class="col-xs-12">
      <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th>NOME</th>
            <th class="center">TELEFONE</th>
            <th>E-MAIL</th>
            <th>MENSAGEM</th>
            <th class="center">DATA</th>
            <th class="center" width="80">AÇÔES</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while($r = mysql_fetch_assoc($q)){
            $date = explode(" ",$r["data"]);
            $data = tratar_data($date[0],2);
            $hora = $date[1];?>
          <tr>
            <td><?php echo $r["nome"]; ?></td>
            <td class="center"><?php echo $r["telefone"]; ?></td>
            <td><?php echo $r["email"]; ?></td>
            <td><?php echo $r["mensagem"]; ?></td>
            <td class="center"><?php echo $data." ".$hora; ?></td>
            <td class="center">              
              <a href="javascript:void(0)"onclick="confirmar_exclusao(<?php echo $r["id"]; ?>)" style="display:block;margin:0 auto;width:2.5rem;">
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
<script type="text/javascript">
  window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>
<script src="assets/js/bootbox.min.js"></script>

<script type="text/javascript">
  function confirmar_exclusao(id_mensagem){
    bootbox.prompt("Digite sua senha para confirmar a exclusão", function(result) {
      if (result === null) {
        
      } else {
        window.location.assign("inc/excluir_contato.php?id_mensagem="+id_mensagem+"&senha="+result);
      }
    })
    $(".bootbox-input").attr('type', 'password');
  }
</script>