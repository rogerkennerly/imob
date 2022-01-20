 <?php  
	$botao = "SALVAR PREFERENCIAS";
  $agora = date("Y-m-d H:i:s");
	
	$id_cliente = evita_injection($_GET['id_cliente']);
	$nome_cliente = retorna_nome('cliente', $id_cliente);
	
	$steste = "SELECT id FROM cliente WHERE id = '$id_cliente' AND id_corretor = '".$_SESSION["sessao_id_user"]."'";
	$qteste = mysql_query($steste);
	if(mysql_num_rows($qteste)<1){
		echo alerta("Cliente não encontrado!");exit;
	}
	
	$qs = mysql_query("SELECT id FROM cliente_preferencia WHERE id_cliente = '$id_cliente'");
	if(mysql_num_rows($qs)<1){
		$op = "incluir";
	}
	else{
		$op = "editar";
	}
	$post = 0;
	
  if($_POST){
    $cidade          = evita_injection($_POST["cidade"]);
		
    $bairros         = $_POST["bairro"];
		$bairro = "";
		for($x=0;$x<count($bairros);$x++){
			$bairro .= "-".$bairros[$x];
		}
		
    $tipos           = $_POST["tipo"];
		$tipo = "";
		for($x=0;$x<count($tipos);$x++){
			$tipo .= "-".$tipos[$x];
		}
		
    $finalidades     = $_POST["finalidade"];
		$finalidade = "";
		for($x=0;$x<count($finalidades);$x++){
			$finalidade .= "-".$finalidades[$x];
		}
		
    $valor_min       = evita_injection(tratar_moeda($_POST["valor_min"],1));
    $valor_max       = evita_injection(tratar_moeda($_POST["valor_max"],1));
    $quarto      	   = evita_injection($_POST["quarto"]);
    $suite      	   = evita_injection($_POST["suite"]);
    $banheiro      	 = evita_injection($_POST["banheiro"]);
    $garagem      	 = evita_injection($_POST["garagem"]);
    // $area_util       = evita_injection($_POST["area_util"]);
    // $area_construida = evita_injection($_POST["area_construida"]);
		
    $items           = $_POST["item"];
		$item = "";
		foreach($items as $t){
			$item .= "-".$t;
		}
		$post = 1;
  }
  
  
  if($op == "incluir" AND $post){
		
    $s = "INSERT INTO cliente_preferencia (
		id_cliente,
		cidades,
		bairros,
		tipos,
		finalidades,
		valor_max,
		valor_min,
		quartos,
		suites,
		banheiros,
		garagem,
		itens,
		data
		) VALUES (
		'$id_cliente',
		'$cidade',
		'$bairro',
		'$tipo',
		'$finalidade',
		'$valor_max',
		'$valor_min',
		'$quarto',
		'$suite',
		'$banheiro',
		'$garagem',
		'$item',
		NOW()
		)";
		// echo $s;
		mysql_query($s);
    echo sucesso("Preferências cadastradas!");
  }
	
	
  if($op == "editar" AND $post){
    
		$s = "UPDATE cliente_preferencia SET 
		cidades = '$cidade',
		bairros = '$bairro',
		tipos = '$tipo',
		finalidades = '$finalidade',
		valor_max = '$valor_max',
		valor_min = '$valor_min',
		quartos = '$quarto',
		suites = '$suite',
		banheiros = '$banheiro',
		garagem = '$garagem',
		itens = '$item'
		WHERE id_cliente = '$id_cliente'";
		// echo $s;
		if(mysql_query($s)){
			echo sucesso("Preferencias gravadas com sucesso!");
		}else{
			echo alerta("Erro ao gravar as preferencias");
			// echo alerta($s);
		}
  }
		
		$s = "SELECT * FROM cliente_preferencia WHERE id_cliente = '$id_cliente'";
		$q = mysql_query($s);
		$cliente = mysql_fetch_assoc($q);
		
		$bairrosx = explode("-", $cliente['bairros']);
		$bairrosx = array_filter($bairrosx);
		// echo "<pre>";var_dump($bairrosx);echo "</pre>";
		
		$tiposx = explode("-", $cliente['tipos']);
		$tiposx = array_filter($tiposx);
		
		$finalidadesx = explode("-", $cliente['finalidades']);
		$finalidadesx = array_filter($finalidadesx);
		
		$itensx = explode("-", $cliente['itens']);
		$itensx = array_filter($itensx);
?>

<div class="page-content">
  <div class="page-header header-mobile">
    <h1>
      Preferencias do cliente
    </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <div class="col-xs-12 controle-chosen">
      <form method="POST" action="">
        <input type="hidden" name="op" value="<?php echo $op; ?>">
        <input type="hidden" name="id_imovel" value="<?php echo $id_imovel; ?>">
        <div class="imob-50 imob-left imob-padding-20" style="margin-top:-2rem;">
          
          
          Cliente: <b><?php echo $nome_cliente; ?></b>
					
					<br/><br/>
          
          Cidade:<br/>
          <?php
          $cidade_list = listar("cidade");?>
          <div class="input_padrao" style="float:left;">
            <select name="cidade" class="form_cadastro_cidade chosen-select input_padrao" style="min-width:20rem;" onchange="atualiza_bairro()">
              <?php
              while($r = mysql_fetch_assoc($cidade_list)){
                $selected = "";
                if($cliente['cidades'] == $r["id"]){$selected = "selected";}?>
              <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
              <?php
              }?>
            </select>
          </div>
          
          <br/><br/>
          
          Bairro:<br/>
          <?php
          if(!$cidade){$cidade = 1;}
          $bairro_list = mysql_query("SELECT * FROM bairro WHERE id_cidade = '".$cliente['cidades']."' ORDER BY nome");?>
          <div class="retorno_cascata_bairro input_padrao" style="">
            <select name="bairro[]" class="chosen-select input_padrao" style="min-width:25rem;" multiple data-placeholder="Selecione os bairros">
              <?php
              while($r = mysql_fetch_assoc($bairro_list)){
                $selected = "";
                if(in_array($r["id"], $bairrosx)){$selected = "selected";}?>
              <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
              <?php
              }?>
            </select>
          </div>
					
					<br/>
          
          Tipos:<br/>
          <?php
          $tipo_list = listar("tipo");?>
          <div class="input_padrao" style="float:left;">
            <select name="tipo[]" class="chosen-select input_padrao" style="min-width:20rem;" multiple data-placeholder="Selecione os tipos">
              <?php
              while($r = mysql_fetch_assoc($tipo_list)){
                $selected = "";
                if(in_array($r["id"], $tiposx)){$selected = "selected";}?>
              <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
              <?php
              }?>
            </select>
          </div>
          
          <br/><br/>
          
          <div style="float:left;width:100%;padding:1rem 0;">
          Finalidade:<br/>
            <?php
            if($_POST["id_imovel"]){$id_imovel = evita_injection($_POST["id_imovel"]);}elseif($_GET["id_imovel"]){$id_imovel = evita_injection($_GET["id_imovel"]);}
            $finalidade_list = listar("finalidade");?>
            <div style="float:left;width:100%;">
              <div class="input_padrao" style="float:left;margin-bottom:1rem;">
                <select name="finalidade[]" id="select_finalidade" class="chosen-select select_finalidades" style="min-width:30rem;height:3rem;" data-placeholder="Selecione as finalidades" onchange="controle_valor_finalidade($(this).val(), '<?php echo $id_imovel; ?>')" multiple>
                  <?php
                  while($r = mysql_fetch_assoc($finalidade_list)){
                    $selected = "";
                    if(in_array($r["id"], $finalidadesx)){$selected = "selected";}?>
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
            
            <br/><br/>
            
						<div class="input_padrao sem_ml sem_mr" style="float:left;margin-right:1rem;">
							Valor mínimo:
							<br />
							<input type="text" class="input_padrao" name="valor_min" placeholder="" size="15" class="money" data-affixes-stay="true" data-thousands="." data-decimal="," value="<?php echo tratar_moeda($cliente["valor_min"],2); ?>">
						</div>
            
						<div class="input_padrao sem_ml sem_mr" style="float:left;margin-right:1rem;">
							Valor máximo:
							<br />
							<input type="text" class="input_padrao" name="valor_max" placeholder="" size="15" class="money" data-affixes-stay="true" data-thousands="." data-decimal="," value="<?php echo tratar_moeda($cliente["valor_max"],2); ?>">
						</div>
        
          </div>
					
          <br/><br/>
          
          <div class="imob-100 imob-left">
            <table class="imob-tabela-20 imob-left">
              <tr>
                <td>Quartos:</td>
                <td>
                  <input type="text" name="quarto" placeholder="" size="5" value="<?php echo $cliente['quartos']; ?>">
                </td>
              </tr>
              <tr>
                <td>Suites:</td>
                <td>
                  <input type="text" name="suite" placeholder="" size="5" value="<?php echo $cliente['suites']; ?>">
                </td>
              </tr>
              <tr>
                <td>Banheiros:</td>
                <td>
                  <input type="text" name="banheiro" placeholder="" size="5" value="<?php echo $cliente['banheiros']; ?>">
                </td>
              </tr>
              <tr>
                <td>Garagem:</td>
                <td>
                  <input type="text" name="garagem" placeholder="" size="5" value="<?php echo $cliente['garagem']; ?>">
                </td>
              </tr>
              <!--tr>
                <td>Terreno:</td>
                <td>
                  <input type="text" name="area_util" placeholder="" size="5" value="<?php echo $cliente['area_total']; ?>"> m²
                </td>
              </tr>
              <tr>
                <td>Área Construida:</td>
                <td>
                  <input type="text" name="area_construida" placeholder="" size="5" value="<?php echo $cliente['area_util']; ?>"> m²
                </td>
              </tr-->
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
                      if(in_array($r["id"], $itensx)){$checked = "checked";}?>
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
        <div style="float:left;width:100%;padding-left:2rem;">
        <button class="btn-lg imob-botao-sucesso"><?php echo $botao; ?></button>
      </div>
    </form>
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

<style>
.chosen-container-multi .chosen-choices{ height:3rem !important; line-height:2.8rem; min-width:50rem; }
</style>