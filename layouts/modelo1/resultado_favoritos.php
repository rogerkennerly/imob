<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php  
	$url 	= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$ordem 	= evita_injection($_GET['ordem']);
	$limite = $config['paginacao'];

	$s = "SELECT imovel.*, imovel_finalidade.id_finalidade, imovel_finalidade.valor FROM imovel, favoritos, imovel_finalidade WHERE imovel.disponivel = 'S' AND imovel.excluido = 'N' AND imovel.id = favoritos.id_imovel AND favoritos.id_cookie = ".$_COOKIE['cookies_imob']." AND imovel.id = imovel_finalidade.id_imovel AND favoritos.id_finalidade = imovel_finalidade.id_finalidade";

	// $s = "SELECT imovel.*, imovel_finalidade.id_finalidade, imovel_finalidade.valor FROM imovel, favoritos, imovel_finalidade WHERE imovel.disponivel = 'S' AND imovel.excluido = 'N' AND imovel.id = favoritos.id_imovel AND favoritos.id_cookie = ".$_COOKIE['cookies_imob'][0]." AND favoritos.id_imovel = imovel_finalidade.id_imovel";

	$ordenacao = " ORDER BY imovel_finalidade.valor DESC";

	if($ordem AND $ordem == 'maior'){
		$ordenacao = " ORDER BY imovel_finalidade.valor DESC";
	}
	if($ordem AND $ordem == 'menor'){
		$ordenacao = " ORDER BY imovel_finalidade.valor ASC";
	}
	if($ordem AND $ordem == 'recente'){
		$ordenacao = " ORDER BY imovel_finalidade.id DESC";
	}

	$q_limite = mysql_query($s);
	$total_imoveis_busca = mysql_num_rows($q_limite);

	$pagina = evita_injection($_GET['pagina']);

	if(!$_GET['pagina']){
		$pagina = 1;
	}

	$limite_pagina = ($pagina-1) * $limite;

	$s .= " $ordenacao LIMIT $limite_pagina,$limite";

	$q = mysql_query($s);
?>
<div class="imob_resultado_favoritos">
	<div class="imob_resultado_favoritos_msg">
		<?php 
			$qtde_imoveis = mysql_num_rows($q);

			if($qtde_imoveis > 1){
				$complemento_nome = "imóveis";
			}
			else{
				$complemento_nome = "imóveis";
			}
		?>
		<h1>Você tem <span><?php echo $total_imoveis_busca; ?> <?php echo $complemento_nome; ?></span> marcado como favorito</h1>
	</div>
	<div class="imob_resultado_favoritos_ordenacao">
		<div class="imob_resultado_favoritos_ordenacao_botoes">
			<?php 
				$url_layout = $url;
				$url_layout_lista = str_replace('bloco', 'lista', $url_layout);
				$url_layout_bloco = str_replace('lista', 'bloco', $url_layout);
			?>
			<div class="imob_resultado_favoritos_ordenacao_botoes_botao cor_hover" id="layout_lista">
				<a href="<?php echo $url_layout_lista; ?>"><i class="fa fa-th-list"></i></a>
			</div>
			<div class="imob_resultado_favoritos_ordenacao_botoes_botao cor_hover" id="layout_bloco">
				<a href="<?php echo $url_layout_bloco; ?>"><i class="fa fa-th"></i></a>
			</div>
		</div>
		<div class="imob_resultado_favoritos_ordenacao_selecao">
			<div class="imob_resultado_favoritos_ordenacao_selecao_label">
				<label>Organizar por: </label>
			</div>
			<div class="imob_resultado_favoritos_ordenacao_selecao_select">
				<select name="ordem" id="ordem" onchange="location.href='<?php echo url_ordenacao($url, $ordem, "'+this.value+'"); ?>'">
					<?php 	
						if(!$ordem){
							$ordem = "maior";
						}
					?>
					<option <?php if($ordem == "maior"){ echo "selected"; } ?> value="maior">Maior valor</option>
					<option <?php if($ordem == "menor"){ echo "selected"; } ?> value="menor">Menor valor</option>
					<option <?php if($ordem == "recente"){ echo "selected"; } ?> value="recente">Mais recente</option>
				</select>
			</div>
		</div>
		<div class="hack"></div>
	</div>
   <?php       
		if($_GET['layout'] == 'lista'){
         $classe_layout = 'imob_resultado_favoritos_lista';
      }
      else if($_GET['layout'] == 'bloco'){
         $classe_layout = 'imob_resultado_favoritos_bloco';
      }
		else{
			$classe_layout = "imob_resultado_favoritos_".$_SESSION['tipo_layout'];
		}
	?>
	<div class="imob_resultado_favoritos_imoveis">
	<?php 
		if(mysql_num_rows($q) > 0){
			while($favorito = mysql_fetch_assoc($q)){?>
			<div class="<?php echo $classe_layout; ?>" id='imob_resultado_layout'><?php
				$title 	= retorna_nome('tipo', $favorito['id_tipo']);
				$title .= " para ".retorna_nome('finalidade', $favorito['id_finalidade']);
				$title .= " em ".retorna_nome('cidade', $favorito['id_cidade']);

				$nome_fin = str_replace(' ', '-', strtolower(retorna_nome('finalidade', $favorito['id_finalidade'])));

				$q_foto = mysql_query("SELECT * FROM foto WHERE id_imovel = ".$favorito['id']." ORDER BY posicao LIMIT 0,3");?>

				<div class="imob_resultado_favoritos_lista_imovel">
					<div class="imob_resultado_favoritos_lista_imovel_fotos owl-carousel owl_carrousel_imovel_fotos owl-theme">
						<?php
							if($favorito['video']){?>
								<a href="/imovel/<?php echo $favorito['id']; ?>/<?php echo $nome_fin; ?>" title="<?php echo $title; ?>">
									<div class="imob_resultado_favoritos_lista_imovel_fotos_img">
										<iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $favorito['video']; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
									</div>
								</a><?php
							}
							while($fotos_imovel = mysql_fetch_assoc($q_foto)){?>
								<a href="/imovel/<?php echo $favorito['id']; ?>/<?php echo $nome_fin; ?>" title="<?php echo $title; ?>">
									<div class="imob_resultado_favoritos_lista_imovel_fotos_img">
										<img src="clientes/<?php echo DIRETORIO; ?>/fotos/<?php echo $favorito['id']; ?>/t1/<?php echo $fotos_imovel['nome'];?>">
									</div>
								</a><?php
							}
							if(mysql_num_rows($q_foto) == 0){?>
								<a href="/imovel/<?php echo $favorito['id']; ?>/<?php echo $nome_fin; ?>" title="<?php echo $title; ?>">
									<div class="imob_resultado_favoritos_lista_imovel_fotos_img">
										<img src="clientes/<?php echo DIRETORIO; ?>/fotos/nenhuma_foto.jpg" id="sem_foto">
									</div>
								</a><?php
							}
						?>
					</div>
					<div class="imob_resultado_favoritos_lista_imovel_informacoes">
						<div class="imob_resultado_favoritos_lista_imovel_informacoes_local">
							<a href="/imovel/<?php echo $favorito['id']; ?>/<?php echo $nome_fin; ?>" title="<?php echo $title; ?>">
								<?php 
									$titulo_imovel = retorna_nome('tipo', $favorito['id_tipo']);
									$titulo_imovel .= " para ".retorna_nome('finalidade', $favorito['id_finalidade']);
									$titulo_imovel .= "<span class='bairro'> no ".retorna_nome('bairro', $favorito['id_bairro'])."</span>";
								?>
								<h1><?php echo $titulo_imovel; ?></h1>
								<span><?php if($favorito['id_bairro']){ echo retorna_nome('bairro', $favorito['id_bairro']).' - '; } ?><?php echo retorna_nome('cidade', $favorito['id_cidade']); ?></span>
							</a>
						</div>
						<div class="imob_resultado_favoritos_lista_imovel_informacoes_favorito" title="Adicionar as favoritos" onclick="favoritar(<?php echo $favorito['id']; ?>, <?php echo $favorito['id_finalidade']; ?>,this);">
							<?php
								$id_imovel 	 = $favorito['id'];
								$id_cookie 	 = $_COOKIE['cookies_imob'];
								$s_favoritos = mysql_query("SELECT * FROM favoritos WHERE id_cookie = '$id_cookie' AND id_imovel = '$id_imovel'");

								$classe = "";
								if(mysql_num_rows($s_favoritos) > 0){
									$classe = "fav";
								}
							?>
							<i class="fa fa-heart <?php echo $classe; ?>"></i>
						</div>
						<div class="hack"></div>
						<div class="imob_resultado_favoritos_lista_imovel_informacoes_especs">
							<ul>
								<?php
		                        	if($favorito['quarto']){?>
		                        		<li><span class="tooltip" title="<?php echo $favorito['quarto']; ?> quartos"><i class="fa fa-bed"></i> <?php echo $favorito['quarto']; ?></span></li><?php
		                       		}
		                       		if($favorito['banheiro']){?>
		                        		<li><span class="tooltip" title="<?php echo $favorito['banheiro']; ?> banheiros"><i class="fa fa-bath"></i> <?php echo $favorito['banheiro']; ?></span></li><?php
		                       		}
		                       		if($favorito['suite']){?>
		                        		<li><span class="tooltip" title="<?php echo $favorito['suite']; ?> suítes"><i class="fa fa-tint"></i> <?php echo $favorito['suite']; ?></span></li><?php
		                       		}
		                       		if($favorito['garagem']){?>
		                        		<li><span class="tooltip" title="<?php echo $favorito['garagem']; ?> vagas"><i class="fa fa-car"></i> <?php echo $favorito['garagem']; ?></span></li><?php
		                       		}
		                       		if($favorito['area_construida']){?>
		                        		<li><span class="tooltip" title="<?php echo $favorito['area_construida']; ?> m² área construída"><i class="fa fa-home"></i> <?php echo $favorito['area_construida']; ?> m²</span></li><?php
		                       		}
		                       		if($favorito['terreno']){?>
		                        		<li><span class="tooltip" title="<?php echo $favorito['terreno']; ?> m² terreno"><i class="fa fa-expand"></i> <?php echo $favorito['terreno']; ?> m² </span></li><?php
		                       		}
		                        ?>
							</ul>
						</div>
						<div class="imob_resultado_favoritos_lista_imovel_informacoes_preco">
							<?php 
								if($favorito['valor'] > 0){?>
									<h1>R$ <?php echo tratar_moeda($favorito['valor'], 2); ?></h1><?php
								}
								else{?>
									<h1>A consultar</h1><?php
								}
							?>
						</div>
						<div class="imob_resultado_favoritos_lista_imovel_informacoes_ref_mobile">
							<span>Ref. <?php echo $favorito['ref']; ?></span>
						</div>
						<div class="imob_resultado_favoritos_lista_imovel_informacoes_contato">
							<div class="imob_resultado_favoritos_lista_imovel_informacoes_contato_ref">
								<span>Ref. <?php echo $favorito['ref']; ?></span>								
							</div>
							<div class="imob_resultado_favoritos_lista_imovel_informacoes_contato_btn">
								<a href="javascript:void(0)" class='btn_padrao cor_botao' title="Nós te ligamos" onclick="abrirModal('#modal_nos_ligamos', '<?php echo $favorito['ref']; ?>');">
									<i class="fa fa-phone"></i> Nós te ligamos
								</a>
								<a href="javascript:void(0)" class='btn_padrao cor_botao' title="Fale conosco" onclick="abrirModal('#modal_fale_conosco', '<?php echo $favorito['ref']; ?>');">
									<i class="fa fa-comment"></i> Fale conosco
								</a>
							</div>
						</div>
					</div>
					<div class="hack"></div>
				</div>
				</div><?php	
			}
		}
		else{?>
			<div class="imob_resultado_favoritos_lista_msg">
				<h1>Você não tem imóveis marcados como favorito <i class="fa fa-frown-o"></i></h1>
			</div><?php
		}
	?>
	</div>
	<div class="hack"></div>
	<div class="imob_resultado_favoritos_paginacao">
		<ul>
			<?php 
				$proxima 	= $pagina+1;
				$anterior 	= $pagina-1;

				$total_paginas = ceil($total_imoveis_busca / $limite);
			?>
			<li class="cor_hover cor_borda_hover">
				<a href="<?php if($pagina == 1){ echo "javascript:void(0)"; }else{ echo url_paginacao($url, $pagina, 1); }  ?>">Primeira</a>
			</li>
			<?php 
				if($pagina > 1){?>
					<li>
						<a href="<?php echo url_paginacao($url, $pagina, $anterior); ?>"><?php echo $anterior; ?></a>
					</li><?php
				}
			?>
			<li class="ativo cor_borda"><a href="javascript:void(0)"><?php echo $pagina; ?></a></li>
			<?php 
				if($pagina < $total_paginas){?>
					<li>
						<a href="<?php echo url_paginacao($url, $pagina, $proxima); ?>"><?php echo $proxima; ?></a>
					</li><?php
				}
			?>
			<li class="cor_hover cor_borda_hover"><a href="<?php if($pagina == $total_paginas){ echo "javascript:void(0)"; }else{ echo url_paginacao($url, $pagina, $total_paginas); }  ?>" title="Última">Última</a></li>
		</ul>
		<div class="hack"></div>
	</div>
</div>
