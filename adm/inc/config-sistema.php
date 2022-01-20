<?php if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) { exit(); } ?>
<?php
  if($_POST){
    $restricao_proprietarios = evita_injection($_POST["restricao_proprietarios"]); if(!$restricao_proprietarios){$restricao_proprietarios = "N";}
  
    $teste = listar("config");
    if(mysql_num_rows($teste)==0){
      $s = "INSERT INTO config (
      restricao_proprietarios
      ) VALUES (
      '$restricao_proprietarios'
      )";
    }
    else{
      $s = "UPDATE config SET 
      restricao_proprietarios = '$restricao_proprietarios'
      ";
    }
    
    // echo $s;
    mysql_query($s);
    
    $descricao_log = "Configurações do sistema atualizadas";
    gravalog($_SESSION["sessao_id_user"], 9, 2, $descricao_log, $s);
  }
  
  $dados = listar("config");
  $dados = mysql_fetch_assoc($dados);
?>

<div class="page-content">
  <div class="page-header">
    <h1>
      Configurações Gerais do Sistema
    </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <?php echo $msg; ?>
    
    <div class="col-xs-12">
      <form method="POST" action="" id="form_cadastro">
				<input type="hidden" name="controle" value="1">
        <table class="imob-tabela-20 imob-left">
          <tr>
            <td>Restrição de Proprietários:</td>
            <td>
              <?php
              $checked = "";
              if($dados["restricao_proprietarios"] == 'S'){$checked = "checked";}?>
              <input name="restricao_proprietarios" <?php echo $checked; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S">
              <span class="lbl"></span>
              <?php echo toltip("A restrição de proprietários impede que um corretor veja dados de qualquer proprietário de imóveis que não foram captados por ele mesmo."); ?>
            </td>
          </tr>
          <tr>
            <td colspan="2"><br/><button class="btn btn-primary" onclick="$('#form_cadastro').submit()">Gravar</button></td>
          </tr>
        </table>
        <input type="submit" style="display:none;">
      </form>
      </div>
    </div>
  </div>
</div>
