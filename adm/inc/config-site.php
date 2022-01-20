<?php if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) { exit(); } ?>
<?php
  if($_POST){
    $banner           = evita_injection($_POST["banner"]);       if(!$banner) {$banner   = "N";}
    $paginacao        = evita_injection($_POST["paginacao"]);
    $lancamentos      = evita_injection($_POST["lancamentos"]);
    $captcha          = evita_injection($_POST["captcha"]);      if(!$captcha){$captcha  = "N";}
    $key_captcha      = evita_injection($_POST["key_captcha"]);
    $destaques_grande = evita_injection($_POST["destaques_grande"]);       if(!$destaques_grande) {$destaques_grande   = "N";}
  
    $teste = listar("config");
    if(mysql_num_rows($teste)==0){
      $s = "INSERT INTO config (
      banner,     
      paginacao,
      captcha,
      key_captcha,
      destaques_grande
      ) VALUES (
      '$banner',     
      '$paginacao',
      '$captcha',
      '$key_captcha',
      '$destaques_grande'
      )";
    }
    else{
      $s = "UPDATE config SET 
      banner = '$banner',     
      paginacao = '$paginacao',
      captcha = '$captcha',
      key_captcha = '$key_captcha',
      destaques_grande = '$destaques_grande'
      ";
    }
    
    // echo $s;
    mysql_query($s);
    
    $descricao_log = "Configurações do site atualizadas";
    gravalog($_SESSION["sessao_id_user"], 9, 2, $descricao_log, $S);
  }
  
  $dados = listar("config");
  $dados = mysql_fetch_assoc($dados);
?>

<div class="page-content">
  <div class="page-header">
    <h1>
      Configurações Gerais do Site
    </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <?php echo $msg; ?>
    
    <div class="col-xs-12">
      <form method="POST" action="" id="form_cadastro">
        <table class="imob-tabela-20 imob-left">
          <tr>
            <td>Banner:</td>
            <td>
              <?php
              $checked = "";
              if($dados["banner"] == 'S'){$checked = "checked";}?>
              <input name="banner" <?php echo $checked; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S">
              <span class="lbl"></span>
              <?php echo toltip("Exibir banner na pagina inicial"); ?>
            </td>
          </tr>
          <tr>
            <td>Super Destaque:</td>
            <td>
              <?php
              $checked = "";
              if($dados["destaques_grande"] == 'S'){$checked = "checked";}?>
              <input name="destaques_grande" <?php echo $checked; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S">
              <span class="lbl"></span>
              <?php echo toltip("Exibir imóveis em super destaque na pagina inicial"); ?>
            </td>
          </tr>
          <tr>
            <td>Paginação:</td>
            <td>
              <input type="text" name="paginacao" placeholder="" size="5" value="<?php echo $dados["paginacao"]; ?>">
              <?php echo toltip("Número de imóveis por pagina na pagina de resultado da busca"); ?>
            </td>
          </tr>
          <tr>
            <td>Captcha:</td>
            <td>
              <?php
              $checked = "";
              if($dados["captcha"] == 'S'){$checked = "checked";}?>
              <input name="captcha" <?php echo $checked; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S">
              <span class="lbl"></span>
              <?php echo toltip("Acesse a pagina do Google recaptcha e gere uma chave para seu site"); ?>
              <input type="text" name="key_captcha" placeholder="Chave Google Captcha" size="55" value="<?php echo $dados["key_captcha"]; ?>">
            </td>
          </tr>
          <!--tr>  
            <td>Dest. Venda:</td>
            <td><input type="text" name="destaques_grande" placeholder="" size="5" value="<?php echo $dados["destaques_grande"]; ?>"></td>
          </tr>
          <tr>
            <td>Dest. Aluguel:</td>
            <td><input type="text" name="destaques_pequeno" placeholder="" size="5" value="<?php echo $dados["destaques_pequeno"]; ?>"></td>
          </tr-->
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
