<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
	$exibir_destaque = 1;
	if($tipo_destaque == 1){
		$titulo = "Destaques de Venda";

		$s_destaque = mysql_query("SELECT imovel.*, imovel_finalidade.id_finalidade, imovel_finalidade.valor as valor_finalidade FROM imovel, imovel_finalidade WHERE disponivel = 'S' AND excluido = 'N' AND imovel_finalidade.id_finalidade = 1 AND destaque = 'S' AND imovel.id = imovel_finalidade.id_imovel");

		if(mysql_num_rows($s_destaque) < 1){ $exibir_destaque = 0; }
	}
	if($tipo_destaque == 2){
		$titulo = "Destaques de Aluguel";

		$s_destaque = mysql_query("SELECT imovel.*, imovel_finalidade.id_finalidade, imovel_finalidade.valor as valor_finalidade FROM imovel, imovel_finalidade WHERE disponivel = 'S' AND excluido = 'N' AND imovel_finalidade.id_finalidade = 2 AND destaque = 'S' AND imovel.id = imovel_finalidade.id_imovel");

		if(mysql_num_rows($s_destaque) < 1){ $exibir_destaque = 0; }
	}
	if($tipo_destaque == 3){
		$titulo = "Imóveis Relacionados";

		$valor_min = $imovel['valor_finalidade'] - ($imovel['valor_finalidade'] * 10 / 100);
		$valor_max = $imovel['valor_finalidade'] + ($imovel['valor_finalidade'] * 10 / 100);

		$s_destaque = mysql_query("SELECT imovel.*, imovel_finalidade.id_finalidade, imovel_finalidade.valor as valor_finalidade FROM imovel, imovel_finalidade WHERE disponivel = 'S' AND excluido = 'N' AND imovel.id <> ".$imovel['id']." AND imovel.id_cidade = ".$imovel['id_cidade']." AND imovel_finalidade.valor >= '$valor_min' AND imovel_finalidade.valor <= '$valor_max' AND imovel.id = imovel_finalidade.id_imovel");

		if(mysql_num_rows($s_destaque) < 1){ $exibir_destaque = 0; }
	}
	if($tipo_destaque == 4){
		$titulo = "Últimos imóveis visitados";
		
		$exibir_destaque = 0;
		$q_complemento = "";
		for($i=0; $i<count($_SESSION['ultimos_visitados']); $i++){
			if($imovel['id'] != $_SESSION['ultimos_visitados'][$i]){
				if($exibir_destaque > 0){ $q_complemento .= " OR "; }

				$q_complemento .= " id = ".$_SESSION['ultimos_visitados'][$i];

				$exibir_destaque++;
			}
		}

		$s_destaque	= mysql_query("SELECT imovel.*, imovel_finalidade.id_finalidade, imovel_finalidade.valor as valor_finalidade FROM imovel, imovel_finalidade WHERE disponivel = 'S' AND excluido = 'N' AND imovel.id <> '".$imovel['id']."' AND ($q_complemento) AND imovel.id = imovel_finalidade.id_imovel");
	}
  
	if($exibir_destaque){?>
		<section class="imob_destaques_pequeno">
			<div class="centralizador">
				<div class="imob_destaques_pequeno_titulo">
					<h1><?php echo $titulo; ?></h1>
				</div>
				<div class="imob_destaques_pequeno_imoveis owl-carousel owl_carrousel_destaques_pequeno owl-theme">
				<?php 
					while($destaque = mysql_fetch_assoc($s_destaque)){?>
						<div class="imob_destaques_pequeno_imoveis_item">
							<?php  
			                    $title  = retorna_nome('tipo', $destaque['id_tipo']);
			                    $title .= " para ".retorna_nome('finalidade', $destaque['id_finalidade']);
			                    $title .= " em ".retorna_nome('cidade', $destaque['id_cidade']);

			                    $nome_fin = str_replace(' ', '-', strtolower(retorna_nome('finalidade', $destaque['id_finalidade'])));

			                    $q_foto      = mysql_query("SELECT * FROM foto WHERE id_imovel = ".$destaque['id']." ORDER BY posicao LIMIT 0,1");
			                    $foto_imovel = mysql_fetch_assoc($q_foto);
			                ?>							
							<a href="/imovel/<?php echo $destaque['id']; ?>/<?php echo $nome_fin; ?>">
								<div class="imob_destaques_pequeno_imoveis_item_img">
									<?php
										if($destaque['video']){?>
											<iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $destaque['video']; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe><?php
										}
										else{  
				                            if(mysql_num_rows($q_foto) > 0){?>
				                                <img src="clientes/<?php echo DIRETORIO; ?>/fotos/<?php echo $destaque['id']; ?>/t2/<?php echo $foto_imovel['nome']; ?>"><?php
				                            }else{?>
				                                <img src="clientes/<?php echo DIRETORIO; ?>/fotos/nenhuma_foto.jpg"><?php
				                            }
				                        }
			                        ?>	
								</div>
								<div class="imob_destaques_pequeno_imoveis_item_infos">
									<div class="imob_destaques_pequeno_imoveis_item_infos_local">
										<h1><?php echo retorna_nome('bairro', $destaque['id_bairro']); ?></h1>
			                            <span><?php echo retorna_nome('tipo', $destaque['id_tipo']); ?> | <?php echo retorna_nome('finalidade', $destaque['id_finalidade']); ?> - <?php echo retorna_nome('cidade', $destaque['id_cidade']); ?></span>
									</div>
									<div class="imob_destaques_pequeno_imoveis_item_infos_especs">
										<ul class="imob_destaques_pequeno_imoveis_item_infos_especs_lista_1">
											<?php
							                    if($destaque['quarto']){?>
							                    	<li><span class="tooltip" title="<?php echo $destaque['quarto']; ?> quartos"><i class="fa fa-bed"></i> <?php echo $destaque['quarto']; ?></span></li><?php
							                    }
							                    if($destaque['banheiro']){?>
							                    	<li><span class="tooltip" title="<?php echo $destaque['banheiro']; ?> banheiros"><i class="fa fa-bath"></i> <?php echo $destaque['banheiro']; ?></span></li><?php
							                    }
							                    if($destaque['suite']){?>
							                    	<li><span class="tooltip" title="<?php echo $destaque['suite']; ?> suítes"><i class="fa fa-tint"></i> <?php echo $destaque['suite']; ?></span></li><?php
							                    }
							                    if($destaque['garagem']){?>
							                    	<li><span class="tooltip" title="<?php echo $destaque['garagem']; ?> vagas"><i class="fa fa-car"></i> <?php echo $destaque['garagem']; ?></span></li><?php
							                    }
							                ?>
										</ul>
										<ul class="imob_destaques_pequeno_imoveis_item_infos_especs_lista_2">
											<?php  
												if($destaque['area_construida']){?>
							                    	<li><span class="tooltip" title="<?php echo $destaque['area_construida']; ?> m² área construída"><i class="fa fa-home"></i> <?php echo $destaque['area_construida']; ?> m²</span></li><?php
							                    }
							                    if($destaque['terreno']){?>
							                    	<li><span class="tooltip" title="<?php echo $destaque['terreno']; ?> m² terreno"><i class="fa fa-expand"></i> <?php echo $destaque['terreno']; ?> m²</span></li><?php
							                    }
											?>
										</ul>
									</div>
									<div class="imob_destaques_pequeno_imoveis_item_infos_preco">
										<?php  
											if($destaque['valor_finalidade']){?>
												<h1>R$ <?php echo tratar_moeda($destaque['valor_finalidade'], 2); ?></h1><?php
											}
											else{?>
												<h1>A consultar</h1><?php
											}
										?>
									</div>
									<div class="imob_destaques_pequeno_imoveis_item_infos_ref">
	                                    <span><?php echo "Ref. ".$destaque['ref']; ?></span>
	                                </div>
								</div>
							</a>
						</div><?php
					}
				?>
				</div>
			</div>
		</section>
		
		<script>
			$('.owl_carrousel_destaques_pequeno').owlCarousel({
			  items: 3,
			  margin: 20,
		      nav: false,
		      dots: false,
		      responsiveClass:true,
		      responsive:{
		          0:{
		              items:1,
		              nav:true
		          },
		          641:{
		              items:2,
		              nav:true
		          },
		          1024:{
		              items: 3,
		              nav:true,
		    
		          },
		          1320:{
		              items: 3,
		              nav:true,
		    
		          }
		      }
			});
		</script><?php
	}
?>
