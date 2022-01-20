<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php 
	$display = 'display: block;';

	if($detectMobile -> isMobile()){
		if($pg == 'busca' OR $pg == 'favoritos' OR $pg == 'imovel'){
			$display = 'display: none;';
		}
	}
?>
<section class="imob_pesquisa_horizontal" style="<?php echo $display; ?>">
	<div class="centralizador">
		<form action="index.php" method="GET" name="imob_pesquisa_horizontal_form" class="imob_pesquisa_horizontal_form">
			<input type="hidden" name="pg" value="busca">
			<div class="imob_pesquisa_horizontal_form_1">
				<div class="imob_pesquisa_horizontal_form_1_select">
					<select name="finalidade" id="finalidade">
						<option selected disabled>Finalidade</option>
						<option value="todas" <?php if($finalidade == 'todas'){ echo "selected"; } ?>>Todas</option>
						<?php  
							$q = mysql_query("SELECT * FROM finalidade");

							while($fin_array = mysql_fetch_assoc($q)){?>
								<option value="<?php echo $fin_array['id']; ?>" <?php if($finalidade == $fin_array['id']){ echo "selected"; } ?>><?php echo $fin_array['nome']; ?></option><?php
							}
						?>
					</select>
				</div>

				<div class="imob_pesquisa_horizontal_form_1_select imob_pesquisa_horizontal_form_select_ajax imob_pesquisa_form_select_ajax_tipo">
					<?php 
						if($finalidade){ 
							$complemento = "";

							if($finalidade AND $finalidade != 'todas'){
							  	$complemento = "imovel.id_finalidade = '$finalidade' AND";
							}

							$q = mysql_query("SELECT DISTINCT(tipo.id), tipo.* FROM tipo, finalidade, imovel WHERE $complemento tipo.id = imovel.id_tipo");

							if(mysql_num_rows($q) > 0){?>
								<select name="tipo_imovel[]" id="tipo_imovel" data-placeholder="Selecione os tipos" multiple>
									<?php  
										while($tipo_array = mysql_fetch_assoc($q)){?>
											<option value="<?php echo $tipo_array['id']; ?>" <?php if(in_array($tipo_array['id'], $tipo)){ echo "selected"; } ?>><?php echo $tipo_array['nome']; ?></option><?php
										}
									?>
								</select><?php
							}
							else{?>
								<p>Nenhum tipo encontrado</p><?php
							}
						}
						else{?>
							<p>Tipos</p><?php
						}
					?>
				</div>

				<div class="imob_pesquisa_horizontal_form_1_select imob_pesquisa_horizontal_form_select_ajax imob_pesquisa_form_select_ajax_cidade">
					<?php 
						if($tipo){
							$complemento = "";

							if($finalidade AND $finalidade != 'todas'){
							  	$complemento = "imovel.id_finalidade = '$finalidade' AND";
							}

							$tipo_query = "";
							for($i=0; $i<count($tipo); $i++){
								if($tipo_query){
									$tipo_query .= ' OR ';
								}

								$tipo_query .= "imovel.id_tipo = ".$tipo[$i];
							}

							$q = mysql_query("SELECT DISTINCT(cidade.id), cidade.* FROM cidade, tipo, imovel WHERE $complemento ($tipo_query) AND imovel.id_cidade = cidade.id ORDER BY nome ASC");

							if(mysql_num_rows($q) > 0){?>
								<select name="cidade" id="cidade" data-placeholder="Selecione a cidade">
									<?php  
										while($cidade_array = mysql_fetch_assoc($q)){?>
											<option value="<?php echo $cidade_array['id']; ?>" <?php if($cidade == $cidade_array['id']){ echo "selected"; } ?>><?php echo $cidade_array['nome']; ?></option><?php
										}
									?>
								</select><?php
							}
							else{?>
								<p>Nenhuma cidade encontrada</p><?php
							}
						}
						else{?>
							<p>Cidade</p><?php
						}
					?>
				</div>

				<div class="imob_pesquisa_horizontal_form_1_select imob_pesquisa_horizontal_form_select_ajax imob_pesquisa_form_select_ajax_bairros">
					<?php 
						if($cidade){
							$complemento = "";

							if($finalidade AND $finalidade != 'todas'){
							  	$complemento = "imovel.id_finalidade = '$finalidade' AND";
							}

							$q = mysql_query("SELECT DISTINCT(bairro.id), bairro.* FROM bairro, cidade, imovel WHERE bairro.id_cidade = '$cidade' AND $complemento imovel.id_bairro = bairro.id ORDER BY nome ASC");

							if(mysql_num_rows($q) > 0){?>
								<select name="bairro[]" id="bairro" data-placeholder="Selecione os bairros" multiple>
									<?php  
										while($bairro_array = mysql_fetch_assoc($q)){?>
											<option value="<?php echo $bairro_array['id']; ?>" <?php if(in_array($bairro_array['id'], $bairro)){ echo "selected"; } ?>><?php echo $bairro_array['nome']; ?></option><?php
										}
									?>
								</select><?php
							}
							else{?>
								<p>Nenhum bairro encontrado</p><?php
							}
						}
						else{?>
							<p>Bairro</p><?php
						}
					?>
				</div>

				<div class="hack"></div>
			</div>
			<div class="imob_pesquisa_horizontal_form_2">
				<div class="imob_pesquisa_horizontal_form_2_input imob_pesquisa_horizontal_form_2_input_valor_min">
					<input type="text" name="valor_min" id="valor_min" class="cor_outline" placeholder="Valor mín" value="<?php echo $valor_min; ?>">
				</div>

				<div class="imob_pesquisa_horizontal_form_2_input imob_pesquisa_horizontal_form_2_input_valor_max">
					<input type="text" name="valor_max" id="valor_max" class="cor_outline" placeholder="Valor máx" value="<?php echo $valor_max; ?>">
				</div>

				<div class="imob_pesquisa_horizontal_form_2_radio imob_pesquisa_horizontal_form_2_radio_quartos">
					<div class="imob_pesquisa_horizontal_form_2_label">	
						<label>Dormitórios</label>
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_quartos <?php if($quartos == 1){ echo "ativo"; } ?>" style="display: none;">
						<input type="radio" name="quartos" value="" class="quarto_vazio">
						0
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_quartos <?php if($quartos == 1){ echo "ativo"; } ?>">
						<input type="radio" name="quartos" value="1" <?php if($quartos == 1){ echo "checked"; } ?>>
						1
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_quartos <?php if($quartos == 2){ echo "ativo"; } ?>">
						<input type="radio" name="quartos" value="2" <?php if($quartos == 2){ echo "checked"; } ?>>
						2
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_quartos <?php if($quartos == 3){ echo "ativo"; } ?>">
						<input type="radio" name="quartos" value="3" <?php if($quartos == 3){ echo "checked"; } ?>>
						3
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_quartos <?php if($quartos == 4){ echo "ativo"; } ?>">
						<input type="radio" name="quartos" value="4" <?php if($quartos == 4){ echo "checked"; } ?>>
						4+
					</div>
				</div>

				<div class="imob_pesquisa_horizontal_form_2_radio imob_pesquisa_horizontal_form_2_radio_suites">
					<div class="imob_pesquisa_horizontal_form_2_label">	
						<label>Suítes</label>
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_suites <?php if($suites == 1){ echo "ativo"; } ?>" style="display: none;">
						<input type="radio" name="suites" value="" class="suite_vazio">
						0
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_suites <?php if($suites == 1){ echo "ativo"; } ?>">
						<input type="radio" name="suites" value="1" <?php if($suites == 1){ echo "checked"; } ?>>
						1
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_suites <?php if($suites == 2){ echo "ativo"; } ?>">
						<input type="radio" name="suites" value="2" <?php if($suites == 2){ echo "checked"; } ?>>
						2
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_suites <?php if($suites == 3){ echo "ativo"; } ?>">
						<input type="radio" name="suites" value="3" <?php if($suites == 3){ echo "checked"; } ?>>
						3
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_suites <?php if($suites == 4){ echo "ativo"; } ?>">
						<input type="radio" name="suites" value="4" <?php if($suites == 4){ echo "checked"; } ?>>
						4+
					</div>
				</div>

				<div class="imob_pesquisa_horizontal_form_2_radio imob_pesquisa_horizontal_form_2_radio_banheiros">
					<div class="imob_pesquisa_horizontal_form_2_label">	
						<label>Banheiros</label>
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_banheiros <?php if($banheiros == 1){ echo "ativo"; } ?>" style="display: none;">
						<input type="radio" name="banheiros" value="" class="banheiro_vazio">
						0
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_banheiros <?php if($banheiros == 1){ echo "ativo"; } ?>">
						<input type="radio" name="banheiros" value="1" <?php if($banheiros == 1){ echo "checked"; } ?>>
						1
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_banheiros <?php if($banheiros == 2){ echo "ativo"; } ?>">
						<input type="radio" name="banheiros" value="2" <?php if($banheiros == 2){ echo "checked"; } ?>>
						2
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_banheiros <?php if($banheiros == 3){ echo "ativo"; } ?>">
						<input type="radio" name="banheiros" value="3" <?php if($banheiros == 3){ echo "checked"; } ?>>
						3
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_banheiros <?php if($banheiros == 4){ echo "ativo"; } ?>">
						<input type="radio" name="banheiros" value="4" <?php if($banheiros == 4){ echo "checked"; } ?>>
						4+
					</div>
				</div>

				<div class="imob_pesquisa_horizontal_form_2_radio imob_pesquisa_horizontal_form_2_radio_vagas">
					<div class="imob_pesquisa_horizontal_form_2_label">	
						<label>Vagas</label>
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_vagas <?php if($vagas == 1){ echo "ativo"; } ?>" style="display: none;">
						<input type="radio" name="vagas" value="" class="vaga_vazio">
						0
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_vagas <?php if($vagas == 1){ echo "ativo"; } ?>">
						<input type="radio" name="vagas" value="1" <?php if($vagas == 1){ echo "checked"; } ?>>
						1
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_vagas <?php if($vagas == 2){ echo "ativo"; } ?>">
						<input type="radio" name="vagas" value="2" <?php if($vagas == 2){ echo "checked"; } ?>>
						2
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_vagas <?php if($vagas == 3){ echo "ativo"; } ?>">
						<input type="radio" name="vagas" value="3" <?php if($vagas == 3){ echo "checked"; } ?>>
						3
					</div>
					<div class="imob_pesquisa_horizontal_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_vagas <?php if($vagas == 4){ echo "ativo"; } ?>">
						<input type="radio" name="vagas" value="4" <?php if($vagas == 4){ echo "checked"; } ?>>
						4+
					</div>
				</div>

				<div class="imob_pesquisa_horizontal_form_2_input imob_pesquisa_horizontal_form_1_input_referencia">
					<input type="text" name="referencia" id="referencia" class="cor_outline" placeholder="Referência" value="<?php echo $referencia; ?>">
				</div>

				<div class="imob_pesquisa_horizontal_form_2_button">
					<button class="cor_botao" id="imob_pesquisa_horizontal_form_2_button" onclick="$('.imob_pesquisa_horizontal_form').submit();">Buscar</button>
				</div>
				
				<input type="hidden" name="ordem" value="maior">

				<input type="hidden" name="pagina" value="1">

				<div class="hack"></div>
			</div>
		</form>
	</div>
</section>
