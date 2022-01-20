 <?php
  if($_POST["id_imovel"]){$id_imovel = evita_injection($_POST["id_imovel"]);}elseif($_GET["id_imovel"]){$id_imovel = evita_injection($_GET["id_imovel"]);}
  
  
  
  //CARREGA INFORMAÇÕES
  $imovel = listar_unico("imovel", $id_imovel);
  $ref             = $imovel["ref"];
  $id_proprietario = $imovel["id_proprietario"];
  $id_corretor     = $imovel["id_corretor"];
  // $finalidade      = $imovel["id_finalidade"];
  $tipo            = $imovel["id_tipo"];
  $valor           = $imovel["valor"]; // VALOR E FINALIDADE FORAM COMENTADOS POIS ESTAO SENDO FEITOS DE OUTRA FORMA - MULTIPLAS FINALIDADES E SEUS VALORES
  $cidade          = $imovel["id_cidade"];
  $bairro          = $imovel["id_bairro"];
  $endereco        = $imovel["endereco"];
  $cep             = $imovel["cep"];
  $detalhes        = $imovel["detalhes"];
  $obs             = $imovel["obs"];
  $disponivel      = $imovel["disponivel"];    
  $super_destaque  = $imovel["super_destaque"];
  $destaque        = $imovel["destaque"];      
  $financia        = $imovel["financia"];      
  $quarto          = $imovel["quarto"];
  $suite           = $imovel["suite"];
  $banheiro        = $imovel["banheiro"];
  $garagem         = $imovel["garagem"];
  $sala            = $imovel["sala"];
  $terreno         = $imovel["terreno"];
  $area_construida = $imovel["area_construida"];
  $video           = $imovel["video"];
  $item            = item_listar($id_imovel);
  $finalidade      = finalidade_listar($id_imovel);
  $ultima_ref = '';
	
	$config = listar("config");//pega as configs do sistema - criado pra ver se a restrição de proprietarios está ativa
	$config = mysql_fetch_assoc($config);
?>

<div class="page-content">
  <div class="page-header header-mobile">
    <h1>
      Ver Dados Imóvel
    <?php
    if($op == "editar"){?>
    <a href="?pg=gerenciar-fotos&id_imovel=<?php echo $id_imovel; ?>">
      <button class="btn-primary btn_mobile" style="float:right;margin-top:-9px;border:0;padding:1rem;">GERENCIAR FOTOS</button>
    </a>
    <?php
    }?>
    </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <div class="col-xs-12 controle-chosen">
        <input type="hidden" name="op" value="<?php echo $op; ?>">
        <input type="hidden" name="id_imovel" value="<?php echo $id_imovel; ?>">
        <div class="imob-50 imob-left imob-padding-20" style="margin-top:-2rem;">
          Referência:<br/>
          <input type="text" name="ref" class="input_padrao" placeholder="" size="10" value="<?php echo $ref; ?>">
          <?php if($ultima_ref){echo 'Última referencia cadastrada: <strong>'.$ultima_ref.'</strong>';} ?>
          
         
          <?php
					$mostrar_proprietarios = 1;
					if($config['restricao_proprietarios'] == 'S' AND $_SESSION["sessao_tipo_user"] == 1){
						if($id_corretor != $_SESSION['sessao_id_user']){
							$mostrar_proprietarios = 0;
						}
					}
					if($mostrar_proprietarios == 1){?>
          
          <br/><br/>
          
          Proprietário:<br/>
          <?php
          $proprietario = mysql_query("SELECT * FROM proprietario");?>
          <div style="font-size:2.5rem;margin-top:-0.5rem;">
            <select name="id_proprietario" class="chosen-select input_padrao" style="min-width:30rem;max-width:60rem;float:left;" disabled>
              <option value="">Selecione o Proprietário</option>
              <?php
              while($r = mysql_fetch_assoc($proprietario)){
                $selected = "";
                if($id_proprietario == $r["id"]){$selected = "selected";}?>
              <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
              <?php
              }
              if(mysql_num_rows($proprietario)<1){?>
                <option value="">Nenhum Proprietário cadastrado</option>
              <?php
              }?>
            </select>
            
            <?php
            if($op == 'editar'){
              $d_prop = listar_unico('proprietario', $id_proprietario);
              $prop_telefones = $d_prop['telefone']." | ".$d_prop['celular'];?>
              <span class='nav-list'>
                <span class='badge badge-transparent tooltip-sucess' title='<?php echo $prop_telefones; ?>' style="color:#000;font-size:2rem;">
                  <i class="icon-phone bigger-130" style="vertical-align:middle;"></i>
                </span>
              </span>
            <?php
            }?>
          </div>
					<?php
					}else{ echo "<br/>"; }?>
          
          <br/>
          
          Corretor:<br/>
          <?php
          $corretor = mysql_query("SELECT * FROM usuario WHERE tipo = 1");?>
          <select name="id_corretor" class="chosen-select input_padrao" style="min-width:20rem;" disabled>
            <option value="">Selecione o Corretor</option>
            <?php
            while($r = mysql_fetch_assoc($corretor)){
              $selected = "";
              if($id_corretor == $r["id"]){$selected = "selected";}?>
            <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
            <?php
            }
            if(mysql_num_rows($corretor)<1){?>
              <option value="">Nenhum Corretor cadastrado</option>
            <?php
            }?>
          </select>
          
          <br/><br/>
          
          Tipo:<br/>
          <?php
          $tipo_list = listar("tipo");?>
          <div class="input_padrao" style="float:left;">
            <select name="tipo" class="chosen-select input_padrao" style="min-width:20rem;" disabled>
              <?php
              while($r = mysql_fetch_assoc($tipo_list)){
                $selected = "";
                if($tipo == $r["id"]){$selected = "selected";}?>
              <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
              <?php
              }?>
            </select>
          </div>
          
          <br/><br/>
          
          <div style="float:left;width:100%;margin-top:2rem;padding:1rem 0;">
          Finalidade:<br/>
          <div style="float:left;width:100%;margin-bottom:2rem;margin-top:0.3rem;">
            <?php
            if($_POST["id_imovel"]){$id_imovel = evita_injection($_POST["id_imovel"]);}elseif($_GET["id_imovel"]){$id_imovel = evita_injection($_GET["id_imovel"]);}
            $finalidade_list = listar("finalidade");?>
            <div style="float:left;width:100%;">
              <div class="input_padrao" style="float:left;margin-bottom:1rem;">
                <select name="finalidade[]" id="select_finalidade" multiple class="chosen-select select_finalidades" style="min-width:30rem;height:3rem;" data-placeholder="Selecione a finalidade" onchange="controle_valor_finalidade($(this).val(), '<?php echo $id_imovel; ?>')" disabled>
                  <?php
                  while($r = mysql_fetch_assoc($finalidade_list)){
                    $selected = "";
                    if(in_array($r["id"], $finalidade)){$selected = "selected";}?>
                  <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
                  <?php
                  }?>
                </select>
              </div>
              <?php
                $display_add = "none";
                if($add_fin_name){$display_add = "block";}
              ?>
            </div>
            <style>.chosen-container-multi .chosen-choices{height:6rem !important;}</style>
            
            <br/><br/>
            
            <div class="campos_valores">
              <?php
              $sfin = "SELECT * FROM imovel_finalidade WHERE id_imovel = '$id_imovel' ORDER BY id_finalidade";
              $qfin = mysql_query($sfin);
              if(mysql_num_rows($qfin)>0){
                while($rfin = mysql_fetch_assoc($qfin)){
                  $s2 = "SELECT nome FROM finalidade WHERE id = '".$rfin["id_finalidade"]."'";
                  $q2 = mysql_query($s2);
                  $r2 = mysql_fetch_assoc($q2);
                  $nome_finalidade = $r2["nome"];?>
                  <div style="width:100%;float:left;margin-bottom:1rem;">
                    <div class="input_padrao sem_ml sem_mr" style="float:left;margin-right:1rem;">
                      Valor <?php echo $nome_finalidade; ?>:
                      <br />
                      <input type="text" class="input_padrao" name="valor_<?php echo $rfin["id_finalidade"]; ?>" placeholder="" size="15" class="money" data-affixes-stay="true" data-thousands="." data-decimal="," value="<?php echo tratar_moeda($rfin["valor"],2); ?>">
                    </div>
        
                    <div class="input_padrao sem_ml sem_mr" style="float:left;margin-right:1rem;">
                      IPTU <?php echo $nome_finalidade; ?>:
                      <br/>
                      <input type="text" class="input_padrao" name="iptu_<?php echo $rfin["id_finalidade"]; ?>" placeholder="" size="15" class="money" data-affixes-stay="true" data-thousands="." data-decimal="," value="<?php echo tratar_moeda($rfin["iptu"],2); ?>">
                    </div>
        
                    <div class="input_padrao sem_ml sem_mr" style="float:left;margin-right:1rem;">
                      Condominio <?php echo $nome_finalidade; ?>:
                      <br/>
                      <input type="text" class="input_padrao" name="condominio_<?php echo $rfin["id_finalidade"]; ?>" placeholder="" size="15" class="money" data-affixes-stay="true" data-thousands="." data-decimal="," value="<?php echo tratar_moeda($rfin["condominio"],2); ?>">
                    </div>
                  </div>
                <?php  
                }
              }
              else{?>
              <div class="valor_disabled">
                <div style="float:left;margin-right:1rem;">
                  Valor:<br/>
                  <input type="text" name="valor" placeholder="" size="15" class="money" data-affixes-stay="true" data-thousands="." data-decimal="," disabled>
                    <?php echo toltip("Selecione uma finalidade para liberar o campo valor"); ?>
                </div>
              </div>
              <?php
              }?>
            </div>
          </div>
          </div>
          
          <br/>
          
          Cidade:<br/>
          <?php
          $cidade_list = listar("cidade");?>
          <div class="input_padrao" style="float:left;">
            <select name="cidade" class="form_cadastro_cidade chosen-select input_padrao" style="min-width:20rem;" onchange="atualiza_bairro()" disabled>
              <?php
              while($r = mysql_fetch_assoc($cidade_list)){
                $selected = "";
                if($cidade == $r["id"]){$selected = "selected";}?>
              <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
              <?php
              }?>
            </select>
          </div>
          
          <br/><br/>
          
          Bairro:<br/>
          <?php
          if(!$cidade){$cidade = 1;}
          $bairro_list = mysql_query("SELECT * FROM bairro WHERE id_cidade = '$cidade' ORDER BY nome");?>
          <div class="retorno_cascata_bairro input_padrao" style="float:left;">
            <select name="bairro" class="chosen-select input_padrao" style="min-width:25rem;" disabled>
              <?php
              while($r = mysql_fetch_assoc($bairro_list)){
                $selected = "";
                if($bairro == $r["id"]){$selected = "selected";}?>
              <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
              <?php
              }?>
            </select>
          </div>
          
          <br/><br/>
          
          Cep:<br/>
          <input type="text" name="cep" placeholder="" size="10" value="<?php echo $cep; ?>">
          <?php echo toltip("Essa informação não será exibida no site."); ?>
          
          <br/><br/>
          
          Endereço:<br/>
          <input type="text" name="endereco" placeholder="" size="50" value="<?php echo $endereco; ?>">
          <?php echo toltip("Essa informação não será exibida no site."); ?>
          
          <br/><br/>
          
          Detalhes:<br/>
          <textarea name="detalhes" size="50" class="imob-100" style="height:150px;"><?php echo $detalhes; ?></textarea>
          
          <br/><br/>
          
          Observações:<br/>
          <textarea name="obs" size="50" class="imob-100" style="height:150px;"><?php echo $obs; ?></textarea>
        </div>
        
        <div class="imob-50 imob-right imob-border-left imob-padding-20 sem_borda">
          <div class="imob-100 imob-left">
            <table class="imob-tabela-20 imob-left">
              <tr>
                <td>Disponível:</td>
                <td>
                  <?php
                  $checked = "";
                  if($disponivel == 'S'){$checked = "checked";}?>
                  <input name="disponivel" <?php echo $checked; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S">
                  <span class="lbl"></span>
                  <?php echo toltip("Apenas imóveis disponíveis são exibidos no site."); ?>
                </td>
              </tr>
              <tr>
                <td>Super Destaque:</td>
                <td>
                  <?php
                  $checked = "";
                  if($super_destaque == 'S'){$checked = "checked";}?>
                  <input name="super_destaque" <?php echo $checked; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S">
                  <span class="lbl"></span>
                  <?php echo toltip('Exibido na aba "Nossos Lançamentos"'); ?>
                </td>
              </tr>
              <tr>
                <td>Destaque:</td>
                <td>
                  <?php
                  $checked = "";
                  if($destaque == 'S'){$checked = "checked";}?>
                  <input name="destaque" <?php echo $checked; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S">
                  <span class="lbl"></span>
                  <?php echo toltip('Exibido na aba Destaques na HOME'); ?>
                </td>
              </tr>
              <tr>
                <td>Financia:</td>
                <td>
                  <?php
                  $checked = "";
                  if($financia == 'S'){$checked = "checked";}?>
                  <input name="financia" <?php echo $checked; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S">
                  <span class="lbl"></span>
                  <?php echo toltip('Imóvel possui financiamento?'); ?>
                </td>
              </tr>
            </table>
          </div>
          
          <br/><br/>
          
          <div class="imob-100 imob-left imob-margin-top-20">
            <table class="imob-tabela-20 imob-left">
              <tr>
                <td>Quartos:</td>
                <td>
                  <input type="text" name="quarto" placeholder="" size="5" value="<?php echo $quarto; ?>">
                </td>
              </tr>
              <tr>
                <td>Suites:</td>
                <td>
                  <input type="text" name="suite" placeholder="" size="5" value="<?php echo $suite; ?>">
                </td>
              </tr>
              <tr>
                <td>Banheiros:</td>
                <td>
                  <input type="text" name="banheiro" placeholder="" size="5" value="<?php echo $banheiro; ?>">
                </td>
              </tr>
              <tr>
                <td>Garagem:</td>
                <td>
                  <input type="text" name="garagem" placeholder="" size="5" value="<?php echo $garagem; ?>">
                  <?php echo toltip("Garagem Coberta"); ?>
                </td>
              </tr>
              <tr>
                <td>Salas:</td>
                <td>
                  <input type="text" name="sala" placeholder="" size="5" value="<?php echo $sala; ?>">
                </td>
              </tr>
              <tr>
                <td>Terreno:</td>
                <td>
                  <input type="text" name="terreno" placeholder="" size="5" value="<?php echo $terreno; ?>"> m²
                </td>
              </tr>
              <tr>
                <td>Área Construida:</td>
                <td>
                  <input type="text" name="area_construida" placeholder="" size="5" value="<?php echo $area_construida; ?>"> m²
                </td>
              </tr>
              <tr>
                <td>Video Youtube:</td>
                <td>
                  <input type="text" name="video" placeholder="Ex: https://www.youtube.com/watch?v=HMUDVMiITOU" size="50" value="<?php if($video){echo "https://www.youtube.com/watch?v=".$video;} ?>">
                </td>
              </tr>
            </table>
            
            <div class="imob-100 imob-left imob-margin-top-20">
              <fieldset>
              <legend>Itens:</legend>
                <table class="imob-100">
                  <tr>
                    <?php
                    $itens = listar("item");
                    $cont = 0;
                    while($r = mysql_fetch_assoc($itens)){
                      $checked = "";
                      if(in_array($r["id"], $item)){$checked = "checked";}?>
                      <td class="imob-33">
                        <label>
                          <input name="item[]" type="checkbox" class="ace" value="<?php echo $r["id"]; ?>" <?php echo $checked; ?>>
                          <span class="lbl"> <?php echo $r["nome"]; ?></span>
                        </label>
                      </td>
                    <?php
                      $cont++;
                      if($cont % 3 == 0){
                        echo "</tr><tr>";
                      }
                    }?>
                  </tr>
                </table>
              </fieldset>
            </div>
          </div>
        </div>
  </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery.maskMoney.min.js" type="text/javascript"></script>

<script>
  //chosen plugin inside a modal will have a zero width because the select element is originally hidden
  //and its width cannot be determined.
  //so we set the width after modal is show
  $('#modal-form').on('shown.bs.modal', function () {
    $(this).find('.chosen-container').each(function(){
      $(this).find('a:first-child').css('width' , '210px');
      $(this).find('.chosen-drop').css('width' , '210px');
      $(this).find('.chosen-search input').css('width' , '200px');
    });
  })
  /**
  //or you can activate the chosen plugin after modal is shown
  //this way select element becomes visible with dimensions and chosen works as expected
  $('#modal-form').on('shown', function () {
    $(this).find('.modal-chosen').chosen();
  })
  */


  $(function() {
    $('.money').maskMoney();
  })
</script>

  