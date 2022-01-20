<?php if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) { exit(); } ?>
<?php
  if($_SESSION['WEBMASTER'] != 'webmaster'){
    exit;
  }

  if($_POST){
    //tabela config
    $banner      = evita_injection($_POST["banner"]);       if(!$banner) {$banner   = "N";}
    $paginacao   = evita_injection($_POST["paginacao"]);
    $layout      = evita_injection($_POST["layout"]);
    $md_gbol     = evita_injection($_POST["md_gbol"]);
    $captcha     = evita_injection($_POST["captcha"]);      if(!$captcha){$captcha  = "N";}
    $key_captcha = evita_injection($_POST["key_captcha"]);
    $teste = listar("config");
    if(mysql_num_rows($teste)==0){
      $s = "UPDATE INTO config (
      banner,     
      paginacao,
      layout,
      md_gbol,
      captcha,
      key_captcha
      ) VALUES (
      '$banner',     
      '$paginacao',
      '$layout',
      '$md_gbol',
      '$captcha',
      '$key_captcha''
      )";
    }
    else{
      $s = "UPDATE config SET 
      banner = '$banner',     
      paginacao = '$paginacao',
      layout = '$layout',
      md_gbol = '$md_gbol',
      captcha = '$captcha',
      key_captcha = '$key_captcha'
      ";
    }
    mysql_query($s);
    
    //tabela confboletos
    $codigobanco    = evita_injection($_POST["codigobanco"]);
    $ag             = evita_injection($_POST["ag"]);
    $digag          = evita_injection($_POST["digag"]);
    $cc             = evita_injection($_POST["cc"]);
    $digcc          = evita_injection($_POST["digcc"]);
    $carteira       = evita_injection($_POST["carteira"]);
    $convenio       = evita_injection($_POST["convenio"]);
    $multa          = evita_injection($_POST["multa"]);
    $juros          = evita_injection($_POST["juros"]);
    $nummin         = evita_injection($_POST["nummin"]);
    $nummax         = evita_injection($_POST["nummax"]);
    $indice         = evita_injection($_POST["indice"]);
    $codtransmissao = evita_injection($_POST["codtransmissao"]);
    $teste = listar("confboletos");
    if(mysql_num_rows($teste)==0){
      $s = "UPDATE INTO confboletos (
      codigobanco,     
      ag,
      digag,
      cc,
      digcc,
      carteira,
      convenio,
      multa,
      juros,
      nummin,
      nummax,
      indice,
      codtransmissao
      ) VALUES (
      '$codigobanco',     
      '$ag',
      '$digag',
      '$cc',
      '$digcc',
      '$carteira'',
      '$convenio'',
      '$multa'',
      '$juros'',
      '$nummin'',
      '$nummax'',
      '$indice'',
      '$codtransmissao''
      )";
    }
    else{
      $s = "UPDATE confboletos SET 
      codigobanco = '$codigobanco',     
      ag = '$ag',
      digag = '$digag',
      cc = '$cc',
      digcc = '$digcc',
      carteira = '$carteira',
      convenio = '$convenio',
      multa = '$multa',
      juros = '$juros',
      nummin = '$nummin',
      nummax = '$nummax',
      indice = '$indice',
      codtransmissao = '$codtransmissao'
      ";
    }
    mysql_query($s);
    
    //tabela dados_imobiliaria
    $inst1 = evita_injection($_POST["inst1"]);
    $inst2 = evita_injection($_POST["inst2"]);
    $inst3 = evita_injection($_POST["inst3"]);
    $inst4 = evita_injection($_POST["inst4"]);
    $teste = listar("dados_imobiliaria");
    if(mysql_num_rows($teste)==0){
      $s = "UPDATE INTO dados_imobiliaria (
      inst1,     
      inst2,
      inst3,
      inst4
      ) VALUES (
      '$inst1',     
      '$inst2',
      '$inst3',
      '$inst4'
      )";
    }
    else{
      $s = "UPDATE dados_imobiliaria SET 
      inst1 = '$inst1',     
      inst2 = '$inst2',
      inst3 = '$inst3',
      inst4 = '$inst4'
      ";
    }
    mysql_query($s);
  }
  
  $dados = listar("config");
  $dados = mysql_fetch_assoc($dados);
?>

<div class="page-content">
  <div class="page-header">
    <h1>
      Configurações Restritas
    </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <?php echo $msg; ?>
    
    <div class="col-xs-12">
    
      <form method="POST" action="">
      <fieldset>
        <legend>Configurações do Site:</legend>
        
        <?php
          $path = "../layouts/";
          $diretorio = dir($path);
           
          $layouts = array();
          while($arquivo = $diretorio -> read()){
            if($arquivo != '.' AND $arquivo != '..'){
              $layouts[] = $arquivo;
            }
          }
          $diretorio -> close();
        ?>
        
        <table class="imob-tabela-20 imob-left tableleft20">
          <tr>
            <td style="height:50px;" colspan="2"><br/>Banner:
              <?php
              $checked = "";
              if($dados["banner"] == 'S'){$checked = "checked";}?>
              <input name="banner" <?php echo $checked; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S">
              <span class="lbl"></span>
            </td>
            <td>
              Paginação<br/>
              <input type="text" name="paginacao" size="10" value="<?php echo $dados['paginacao']; ?>">
            </td>
            <td>
              Layout<br/>
              <div class="controle-chosen ">
                <select name="layout" class="chosen-select" style="min-width:100px;">
                  <?php
                  sort($layouts);
                  foreach($layouts as $layout){?>
                    <option value="<?php echo $layout; ?>" <?php if($dados['layout'] == $layout){echo "selected";} ?>><?php echo $layout ?></option>
                  <?php
                  }?>
                </select>
              </div>
            </td>
          </tr>
        </table>
      </fieldset>
      <br/><br/><br/>
      <fieldset>
        <legend>Modulos:</legend>
        
        <table class="imob-tabela-20 imob-left tableleft20">
          <tr>
            <td style="height:50px;" colspan="2"><br/>Gbol:
              <?php
              $confboletos = "SELECT * FROM confboletos";
              $confboletos = mysql_query($confboletos);
              $confboletos = mysql_fetch_assoc($confboletos);
              
              $dados_config = "SELECT * FROM dados_imobiliaria";
              $dados_config = mysql_query($dados_config);
              $dados_config = mysql_fetch_assoc($dados_config);?>
              <?php
              $checked = "";
              $display = "style='display:none;'";
              if($dados["md_gbol"] == 'S'){$checked = "checked";$display = "";}?>
              <input name="md_gbol" <?php echo $checked; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S" onclick="$('.opt_gbol').toggle()">
              <span class="lbl"></span>
            </td>
          </tr>
          <tr class="opt_gbol" <?php echo $display; ?>>
            <td>
              Cod Banco<br/>
              <input type="text" name="codigobanco" size="10" value="<?php echo $confboletos['codigobanco']; ?>">
            </td>
            <td>
              Agencia<br/>
              <input type="text" name="ag" size="10" value="<?php echo $confboletos['ag']; ?>">
            </td>
            <td>
              Dig Agencia<br/>
              <input type="text" name="digag" size="10" value="<?php echo $confboletos['digag']; ?>">
            </td>
            <td>
              C. Corrente<br/>
              <input type="text" name="cc" size="10" value="<?php echo $confboletos['cc']; ?>">
            </td>
            <td>
              Dig C/C<br/>
              <input type="text" name="digcc" size="10" value="<?php echo $confboletos['digcc']; ?>">
            </td>
            <td>
              Carteira<br/>
              <input type="text" name="carteira" size="10" value="<?php echo $confboletos['carteira']; ?>">
            </td>
            <td>
              Convenio<br/>
              <input type="text" name="convenio" size="10" value="<?php echo $confboletos['convenio']; ?>">
            </td>
            <td>
              Multa<br/>
              <input type="text" name="multa" size="10" value="<?php echo $confboletos['multa']; ?>">
            </td>
            <td>
              Juros<br/>
              <input type="text" name="juros" size="10" value="<?php echo $confboletos['juros']; ?>">
            </td>
            <td>
              Num Min<br/>
              <input type="text" name="nummin" size="10" value="<?php echo $confboletos['nummin']; ?>">
            </td>
            <td>
              Num Max<br/>
              <input type="text" name="nummax" size="10" value="<?php echo $confboletos['nummax']; ?>">
            </td>
            <td>
              Indice<br/>
              <input type="text" name="indice" size="10" value="<?php echo $confboletos['indice']; ?>">
            </td>
            <td>
              Cod Transmissão<br/>
              <input type="text" name="codtransmissao" size="12" value="<?php echo $confboletos['codtransmissao']; ?>">
            </td>
          </tr>
          <tr class="opt_gbol" <?php echo $display; ?>>
            <td colspan="10">
              Instrução 1: <input type="text" name="inst1" size="100" value="<?php echo $dados_config['inst1']; ?>">
            </td>
          </tr>
          <tr class="opt_gbol" <?php echo $display; ?>>
            <td colspan="10">
              Instrução 2: <input type="text" name="inst2" size="100" value="<?php echo $dados_config['inst2']; ?>">
            </td>
          </tr>
          <tr class="opt_gbol" <?php echo $display; ?>>
            <td colspan="10">
              Instrução 3: <input type="text" name="inst3" size="100" value="<?php echo $dados_config['inst3']; ?>">
            </td>
          </tr>
          <tr class="opt_gbol" <?php echo $display; ?>>
            <td colspan="10">
              Instrução 4: <input type="text" name="inst4" size="100" value="<?php echo $dados_config['inst4']; ?>">
            </td>
          </tr>
        </table>
      </fieldset>
      <br/><br/><br/>
    
      <button class="btn btn-primary" onclick="$('#form_cadastro').submit()">Gravar</button>
        </table>
        <input type="submit" style="display:none;">
      </form>
      </div>
    </div>
  </div>
</div>
