<?php if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) { exit(); } ?>
<?php
  if($_POST){
    $scripts = $_POST["scripts"];
  
    $s = "UPDATE config SET 
    scripts = '".mysql_real_escape_string("$scripts")."'";
    
    // echo $s;
    mysql_query($s);
    
    $descricao_log = "Scripts atualizados";
    gravalog($_SESSION["sessao_id_user"], 9, 2, $descricao_log, $s);
  }
  
  $dados = listar("config");
  $dados = mysql_fetch_assoc($dados);
?>

<div class="page-content">
  <div class="page-header">
    <h1>
      Scripts
    </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <?php echo $msg; ?>
    
    <div class="col-xs-12">
      <form method="POST" action="" id="form_cadastro">
        <textarea style="height:60rem;width:90rem;" name="scripts"><?php echo $dados["scripts"]; ?></textarea>
        <br/>
        <br/>
        <button class="btn btn-primary" onclick="$('#form_cadastro').submit()">Gravar</button>
        <input type="submit" style="display:none;">
      </form>
      </div>
    </div>
  </div>
</div>