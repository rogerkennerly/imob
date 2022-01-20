<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<section class="imob_pesquisa_vertical">
	<form action="" method="GET" name="imob_pesquisa_vertical_form" class="imob_pesquisa_vertical_form">
		<input type="hidden" name="pg" value="busca">
		<div class="imob_pesquisa_vertical_form_1 cor_layout">
			<div class="imob_pesquisa_vertical_form_1_select">
				<select name="finalidade" id="finalidade">
					<option <?php if(!$finalidade OR $finalidade == 'todas'){ echo "selected"; } ?> value="todas">Todas</option>
						<?php  
							$q = mysql_query("SELECT * FROM finalidade");

							while($fin_array = mysql_fetch_assoc($q)){?>
								<?php 
									$selected = "";
									if($finalidade == $fin_array['id']){
										$selected = "selected";
									}
								?>
								<option value="<?php echo $fin_array['id']; ?>" <?php echo $selected; ?>><?php echo $fin_array['nome']; ?></option><?php
							}
						?>
					</select>
			</div>
			<script>
				$("#finalidade").change(function(event){ 
				    var finalidade = $(this).val();

				    $.ajax({
				      url: "../ajax/ajax_form_tipo_imovel.php?finalidade="+finalidade,
				      cache: false,
				      success: function(html){
				        $(".imob_pesquisa_form_select_ajax_tipo").html(html);
				      },
				    });
				 });
			</script>
		</div>
		<div class="imob_pesquisa_vertical_form_2">
			<div class="imob_pesquisa_vertical_form_2_select imob_pesquisa_vertical_form_select_ajax imob_pesquisa_form_select_ajax_tipo">
				<?php 
					$complemento = "";

          if($finalidade AND $finalidade != 'todas'){
             $complemento = "AND id IN (SELECT id_imovel FROM imovel_finalidade WHERE id_finalidade = '$finalidade')";
          }
       
          $q = mysql_query("SELECT DISTINCT(id),nome FROM tipo WHERE id IN (SELECT id_tipo FROM imovel WHERE disponivel = 'S' $complemento)");

					if(mysql_num_rows($q) > 0){?>
						<select name="tipo_imovel[]" id="tipo_imovel" data-placeholder="Tipos" multiple>
							<?php  
								while($tipo_array = mysql_fetch_assoc($q)){?>
									<?php 
										$selected = "";
										if(in_array($tipo_array['id'], $tipo)){
											$selected = "selected";
										}
									?>

									<option value="<?php echo $tipo_array['id']; ?>" <?php echo $selected; ?>><?php echo $tipo_array['nome']; ?></option><?php
								}
							?>
						</select><?php
					}
					else{?>
						<p>Nenhum tipo encontrado</p><?php
					}
				 ?>
			</div>
			<script>
				$("#tipo_imovel").chosen();


				$("#tipo_imovel").chosen().change(function(event){
					var tipo_imovel = $(this).val();
					var finalidade = $("#finalidade").val();

					$.ajax({
						url: "../ajax/ajax_form_cidades.php?tipo_imovel="+tipo_imovel+"&finalidade="+finalidade,
						cache: false,
						success: function(html){
							$(".imob_pesquisa_form_select_ajax_cidade").html(html);
						}
					});
				});
			</script>

			<div class="imob_pesquisa_vertical_form_2_select imob_pesquisa_vertical_form_select_ajax imob_pesquisa_form_select_ajax_cidade">
				<?php 
					$complemento = "";

					if($finalidade AND $finalidade != 'todas'){
                  // $complemento = "imovel_finalidade.id_finalidade = '$finalidade' AND imovel_finalidade.id_imovel = imovel.id AND";
                  $complemento = " AND id IN (SELECT id_imovel FROM imovel_finalidade WHERE id_finalidade = '$finalidade')";
                     }

                     if($tipo){
                        $complemento .= " AND (";
                        $indice = 0;
                        foreach($tipo as $tipo_id){
                        $indice++;
                        $complemento .= " id_tipo = '$tipo_id'";
                        if(count($tipo) < $indice){
                           $complemento .= " OR ";
                        }
                     }
                  $complemento .= ")";
               }

               $q = mysql_query("SELECT DISTINCT(id), nome FROM cidade WHERE id IN (SELECT id_cidade FROM imovel WHERE disponivel = 'S' $complemento) ORDER BY nome ASC");

					if(@mysql_num_rows($q) > 0){?>
						<select name="cidade" id="cidade" data-placeholder="Selecione a cidade">
							<option selected disabled>Selecione a cidade</option>
							<?php 
								while($cidade_array = mysql_fetch_assoc($q)){?>
									<?php 
										$selected = "";
										if($cidade == $cidade_array['id']){
											$selected = "selected";
										}
									?>
									<option value="<?php echo $cidade_array['id']; ?>" <?php echo $selected; ?>><?php echo $cidade_array['nome']; ?></option><?php
								}
							?>
						</select><?php
					}
					else{
						if(count($tipo_imovel == 1)){?>
							<p>Cidade</p><?php
						}
					}
				?>
			</div>
			<script>
				$("#cidade").chosen().change(function(event){
					var cidade = $(this).val();
					var finalidade = $("#finalidade").val();
					var tipo_imovel = $("#tipo_imovel").val();

					$.ajax({
						url: "../ajax/ajax_form_bairros.php?cidade="+cidade+"&finalidade="+finalidade+"&tipo_imovel="+tipo_imovel,
						cache: false,
						success: function(html){
							$(".imob_pesquisa_form_select_ajax_bairros").html(html);
						},
					});
				});
			</script>

			<div class="imob_pesquisa_vertical_form_2_select imob_pesquisa_vertical_form_select_ajax imob_pesquisa_form_select_ajax_bairros">
				<?php 
               if($cidade){
                  $complemento = "";
                  if($finalidade AND $finalidade != 'todas'){
                     $complemento = " AND id IN (SELECT id_imovel FROM imovel_finalidade WHERE id_finalidade = '$finalidade')";
                  }
                  if($tipo){
                    $complemento .= " AND (";
                    $indice = 0;
                    foreach($tipo as $tipo_id){
                       $indice++;
                       $complemento .= " id_tipo = '$tipo_id'";
                       if(count($tipo) < $indice){
                          $complemento .= " OR ";
                       }
                    }
                    $complemento .= ")";
                  
                    if($cidade){
                     $complemento .= " AND id_cidade = '$cidade'";
                      $complemento_cidade = " AND id_cidade = '$cidade'";
                    }
                  }

                  $qb = mysql_query("SELECT DISTINCT(id), nome FROM bairro WHERE id IN (SELECT id_bairro FROM imovel WHERE disponivel = 'S' $complemento) $complemento_cidade ORDER BY nome ASC");
               }

					if(mysql_num_rows($qb) > 0){?>
						<select name="bairro[]" id="bairro" data-placeholder="Bairros" multiple>
							<?php 
								while($bairro_array = mysql_fetch_assoc($qb)){?>
									<?php 
										$selected = "";
										if(in_array($bairro_array['id'], $bairro)){
											$selected = "selected";
										}
									?>

									<option value="<?php echo $bairro_array['id']; ?>" <?php echo $selected; ?>><?php echo $bairro_array['nome']; ?></option><?php
								}
							?>
						</select><?php
					}
					else{?>
						<p>Bairros</p><?php
					}
				?>
				<script>
					$("#bairro").chosen(); 
				</script>
			</div>

			<div class="imob_pesquisa_vertical_form_2_radio">
				<div class="imob_pesquisa_vertical_form_2_label">	
					<label>Dormitórios</label>
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_quartos <?php if($quartos == 1){ echo "ativo"; } ?>" style="display: none;">
					<input type="radio" name="quartos" value="" class="quarto_vazio">
					0
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_quartos <?php if($quartos == 1){ echo "ativo"; } ?>">
					<input type="radio" name="quartos" value="1" <?php if($quartos == 1){ echo "checked"; } ?>>
					1
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_quartos <?php if($quartos == 2){ echo "ativo"; } ?>">
					<input type="radio" name="quartos" value="2" <?php if($quartos == 2){ echo "checked"; } ?>>
					2
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_quartos <?php if($quartos == 3){ echo "ativo"; } ?>">
					<input type="radio" name="quartos" value="3" <?php if($quartos == 3){ echo "checked"; } ?>>
					3
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_quartos <?php if($quartos == 4){ echo "ativo"; } ?>">
					<input type="radio" name="quartos" value="4" <?php if($quartos == 4){ echo "checked"; } ?>>
					4+
				</div>
			</div>

			<div class="imob_pesquisa_vertical_form_2_radio">
				<div class="imob_pesquisa_vertical_form_2_label">	
					<label>Suítes</label>
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_suites <?php if($suites == 1){ echo "ativo"; } ?>" style="display: none;">
					<input type="radio" name="suites" value="" class="suite_vazio">
					0
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_suites <?php if($suites == 1){ echo "ativo"; } ?>">
					<input type="radio" name="suites" value="1" <?php if($suites == 1){ echo "checked"; } ?>>
					1
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_suites <?php if($suites == 2){ echo "ativo"; } ?>">
					<input type="radio" name="suites" value="2" <?php if($suites == 2){ echo "checked"; } ?>>
					2
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_suites <?php if($suites == 3){ echo "ativo"; } ?>">
					<input type="radio" name="suites" value="3" <?php if($suites == 3){ echo "checked"; } ?>>
					3
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_suites <?php if($suites == 4){ echo "ativo"; } ?>">
					<input type="radio" name="suites" value="4" <?php if($suites == 4){ echo "checked"; } ?>>
					4+
				</div>
			</div>

			<div class="imob_pesquisa_vertical_form_2_radio">
				<div class="imob_pesquisa_vertical_form_2_label">	
					<label>Banheiros</label>
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_banheiros <?php if($banheiros == 1){ echo "ativo"; } ?>" style="display: none;">
					<input type="radio" name="banheiros" value="" class="banheiro_vazio">
					0
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_banheiros <?php if($banheiros == 1){ echo "ativo"; } ?>">
					<input type="radio" name="banheiros" value="1" <?php if($banheiros == 1){ echo "checked"; } ?>>
					1
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_banheiros <?php if($banheiros == 2){ echo "ativo"; } ?>">
					<input type="radio" name="banheiros" value="2" <?php if($banheiros == 2){ echo "checked"; } ?>>
					2
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_banheiros <?php if($banheiros == 3){ echo "ativo"; } ?>">
					<input type="radio" name="banheiros" value="3" <?php if($banheiros == 3){ echo "checked"; } ?>>
					3
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_banheiros <?php if($banheiros == 4){ echo "ativo"; } ?>">
					<input type="radio" name="banheiros" value="4" <?php if($banheiros == 4){ echo "checked"; } ?>>
					4+
				</div>
			</div>

			<div class="imob_pesquisa_vertical_form_2_radio">
				<div class="imob_pesquisa_vertical_form_2_label">	
					<label>Vagas</label>
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_vagas <?php if($vagas == 1){ echo "ativo"; } ?>" style="display: none;">
					<input type="radio" name="vagas" value="" class="vaga_vazio">
					0
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_vagas <?php if($vagas == 1){ echo "ativo"; } ?>">
					<input type="radio" name="vagas" value="1" <?php if($vagas == 1){ echo "checked"; } ?>>
					1
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_vagas <?php if($vagas == 2){ echo "ativo"; } ?>">
					<input type="radio" name="vagas" value="2" <?php if($vagas == 2){ echo "checked"; } ?>>
					2
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_vagas <?php if($vagas == 3){ echo "ativo"; } ?>">
					<input type="radio" name="vagas" value="3" <?php if($vagas == 3){ echo "checked"; } ?>>
					3
				</div>
				<div class="imob_pesquisa_vertical_form_2_radio_input cor_hover cor_borda_hover imob_pesquisa_form_radio_input_vagas <?php if($vagas == 4){ echo "ativo"; } ?>">
					<input type="radio" name="vagas" value="4" <?php if($vagas == 4){ echo "checked"; } ?>>
					4+
				</div>
			</div>

			<div class="hack"></div>

			<div class="imob_pesquisa_vertical_form_2_input_grupo">
				<div class="imob_pesquisa_vertical_form_2_label">	
					<label>Valor - R$</label>
				</div>
				<div class="imob_pesquisa_vertical_form_2_input">
					<input type="text" name="valor_min" id="valor_min" class="cor_outline" placeholder="Valor mín" value="<?php echo $valor_min; ?>">
				</div>
				<div class="imob_pesquisa_vertical_form_2_input_span">
					<span>até</span>
				</div>
				<div class="imob_pesquisa_vertical_form_2_input">
					<input type="text" name="valor_max" id="valor_max" class="cor_outline" placeholder="Valor máx" value="<?php echo $valor_max; ?>">
				</div>
			</div>

			<div class="imob_pesquisa_vertical_form_2_input" id="codigo_imovel">
				<input type="text" name="referencia" id="referencia" class="cor_outline" placeholder="Referência" value="<?php echo $referencia; ?>">
			</div>
			
			<input type="hidden" name="ordem" value="maior">

			<input type="hidden" name="pagina" value="1">

			<div class="imob_pesquisa_vertical_form_2_button">
				<button class="cor_botao" onclick="$('#form-contato').submit();">Buscar</button>
			</div>
		</div>
	</form>
</section>
