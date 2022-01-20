<?php
  if($_POST){
    $ids        = $_POST["portais_ids"];
    $chaves     = $_POST["chaves"];
    $disponivel = $_POST["disponivel"];
    
    for($x = 0 ; $x < count($ids) ; $x++){
      if($disponivel[$x] == 'S'){
        $sql_geral = "UPDATE portais SET chave = '".$chaves[$x]."', ativo = 'S' WHERE id = '".$ids[$x]."'";
        mysql_query($sql_geral);
        
        $s_nome = "SELECT nome FROM portais WHERE id = '".$ids[$x]."'";
        $q_nome = mysql_query($s_nome);
        $r_nome = mysql_fetch_assoc($q_nome);
        $nome    = $r_nome["nome"];
            
        $descricao_log = "Web Service Portais atualizado - $nome";
        gravalog($_SESSION["sessao_id_user"], 11, 2, $descricao_log, $sql_geral);
      }else{
        $sql_geral = "UPDATE portais SET chave = '', ativo = 'N' WHERE id = '".$ids[$x]."'";
        mysql_query($sql_geral);
        
        $s_nome = "SELECT nome FROM portais WHERE id = '".$ids[$x]."'";
        $q_nome = mysql_query($s_nome);
        $r_nome = mysql_fetch_assoc($q_nome);
        $nome    = $r_nome["nome"];
            
        $descricao_log = "Web Service Portais atualizado - $nome";
        gravalog($_SESSION["sessao_id_user"], 11, 2, $descricao_log, $sql_geral);
      }
    }
  }
?>

<div class="page-content">
  <div class="page-header">
    <h1>
      Gerenciar Portais
    <?php
    if($op == "editar"){?>
    <a href="?pg=gerenciar-fotos&id_imovel=<?php echo $id_imovel; ?>">
      <button class="btn-primary" style="float:right;margin-top:-9px;border:0;padding:1rem;">GERENCIAR FOTOS</button>
    </a>
    <?php
    }?>
    </h1>
  </div><!-- /.page-header -->
  <button class="btn-lg imob-botao-sucesso imob-botao-fixo-bottom-right" onclick="$('#form_portais').submit()">GRAVAR ALTERAÇÕES</button>

  <div class="row">
    <div class="col-xs-12 controle-chosen">
      <?php
      $portais = mysql_query("SELECT * FROM portais");
      ?>
      <form method="POST" action="" id="form_portais">
        <table class="imob-left" style="width:100%;">
          <?php
          while($r = mysql_fetch_assoc($portais)){?>
          <tr>
            <td width="100"><?php echo $r["nome"]; ?>:</td>
            <td width="60">
              <?php
              $checked = "";
              if($r["ativo"] == 'S'){$checked = "checked";}?>
              <input name="disponivel[]" <?php echo $checked; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S" onchange="$('.url_<?php echo $r["id"]; ?>').fadeToggle()">
              <span class="lbl"></span>
            </td>
            <td>
              <?php
                $display = "none";
              if($r["ativo"] == 'S'){
                $display = "block";
                $chave = $r["chave"];
              }else{
                $chave = md5(date("Y-m-d H:i:s").$r["id"]);
              }?>
              <div style="display:<?php echo $display; ?>;" class="url_<?php echo $r["id"]; ?>">
                Url:
                <?php
                $end_site = "http://" . $dominio."/";
                $url = $end_site = "http://" . $_SERVER['HTTP_HOST']."/webservice/".$r["arquivo"]."?chave=";
                $url .= $chave;?>
                <input type="text" style="width:90%;" value="<?php echo $url; ?>">
                <input type="hidden" name="chaves[]" value="<?php echo $chave; ?>">
                <input type="hidden" name="portais_ids[]" value="<?php echo $r["id"]; ?>">
              </div>
            </td>
          </tr>
          <?php
          }?>
        </table>
      </form>
    </div>
  </div>
</div>