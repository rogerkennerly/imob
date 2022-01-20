<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
	$url 	= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$ordem 	= evita_injection($_GET['ordem']);
	$limite = $config['paginacao'];

	$s = "SELECT imovel.*, imovel_finalidade.id_finalidade, imovel_finalidade.valor FROM imovel, imovel_finalidade WHERE imovel.disponivel = 'S' AND imovel.excluido = 'N'";

	if($referencia){
		$s .= " AND ref = '$referencia'";
		$tipo_query = "";
		$qtesteref = mysql_query($s);
		if(mysql_num_rows($qtesteref)<1){
			$s .= " AND ref like %'$referencia'%";
		}
	}
	else{
		if(($finalidade AND $finalidade != 'todas') OR $tipo OR $cidade OR $bairro OR $quartos OR $suites OR $banheiros OR $vagas OR $valor_min OR $valor_max){
			$s .= " AND ";
		}
		$tipo_query = "";
		if($finalidade AND $finalidade != 'todas'){
			$s_nome_fin = mysql_query("SELECT * FROM finalidade WHERE id = '$finalidade'");
			$nome_fin = mysql_fetch_assoc($s_nome_fin);
			$nome_finalidade = str_replace(' ', '', strtoupper($nome_fin['nome']));

			if($nome_finalidade == 'VENDA/ALUGUEL'){
				$tipo_query .= "(imovel_finalidade.id_finalidade = 1 OR id_finalidade = 2)";
			}
			else{
				$tipo_query .= "imovel_finalidade.id_finalidade = '$finalidade'";
			}
		}
		if($tipo){
			if($tipo_query){
				$tipo_query .= " AND ";
			}

			$controle = 0;
			for($i=0; $i<count($tipo); $i++){
				if($i == 0){ $tipo_query .= "("; }

				if($controle){
					$tipo_query .= " OR ";
				}

				$tipo_query .= "id_tipo = '".$tipo[$i]."'";
				$controle = 1;
				if($i+1 == count($tipo)){ $tipo_query .= ")"; }
			}
		}
		if($cidade){
			if($tipo_query){
				$tipo_query .= " AND ";
			}
			$tipo_query .= "id_cidade = '$cidade'";
		}
		if($bairro){
			if($tipo_query){
				$tipo_query .= " AND ";
			}

			$controle = 0;
			for($i=0; $i<count($bairro); $i++){
				if($i == 0){ $tipo_query .= "("; }

				if($controle){
					$tipo_query .= " OR ";
				}

				$tipo_query .= "id_bairro = '".$bairro[$i]."'";
				$controle = 1;
				if($i+1 == count($bairro)){ $tipo_query .= ")"; }
			}
		}
		if($valor_min){
			if($tipo_query){
				$tipo_query .= " AND ";
			}
			$tipo_query .= "imovel_finalidade.valor >= '$valor_min'";
		}
		if($valor_max){
			if($tipo_query){
				$tipo_query .= " AND ";
			}
			$tipo_query .= "imovel_finalidade.valor <= '$valor_max'";
		}
		if($quartos){
			if($tipo_query){
				$tipo_query .= " AND ";
			}

			$controle = "=";
			if($quartos == 4){
				$controle = ">=";
			}

			$tipo_query .= "quarto $controle '$quartos'";
		}
		if($suites){
			if($tipo_query){
				$tipo_query .= " AND ";
			}

			$controle = "=";
			if($suites == 4){
				$controle = ">=";
			}

			$tipo_query .= "suite $controle '$suites'";
		}
		if($banheiros){
			if($tipo_query){
				$tipo_query .= " AND ";
			}

			$controle = "=";
			if($banheiros == 4){
				$controle = ">=";
			}

			$tipo_query .= "banheiro $controle '$banheiros'";
		}
		if($vagas){
			if($tipo_query){
				$tipo_query .= " AND ";
			}

			$controle = "=";
			if($vagas == 4){
				$controle = ">=";
			}

			$tipo_query .= "garagem $controle '$vagas'";
		}
	}

	$s .= $tipo_query;
	$s .= " AND imovel.id = imovel_finalidade.id_imovel";

	$ordenacao = " ORDER BY imovel_finalidade.valor DESC";

	if($ordem AND $ordem == 'maior'){
		$ordenacao = " ORDER BY imovel_finalidade.valor DESC";
	}
	if($ordem AND $ordem == 'menor'){
		$ordenacao = " ORDER BY imovel_finalidade.valor ASC";
	}
	if($ordem AND $ordem == 'recente'){
		$ordenacao = " ORDER BY id DESC";
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
<div class="imob_resultado_busca">
	<div class="imob_resultado_busca_msg">
		<?php 
			$qtde_imoveis = mysql_num_rows($q);

			if($qtde_imoveis > 1){
				$complemento_nome = "imóveis";
			}
			else{
				$complemento_nome = "imóvel";	
			}
		?>
		<h1>Encontramos <span><?php echo $total_imoveis_busca; ?> <?php echo $complemento_nome; ?></span> para você</h1>
	</div>
	<div class="imob_resultado_busca_ordenacao">
		<div class="imob_resultado_busca_ordenacao_botoes">
			<?php 
				$url_layout = $url;
				$url_layout = str_replace('&layout=lista', '', $url_layout);
				$url_layout = str_replace('&layout=bloco', '', $url_layout);
			?>
			<div class="imob_resultado_busca_ordenacao_botoes_botao cor_hover" id="layout_lista">
				<a href="<?php echo $url_layout; ?>&layout=lista"><i class="fa fa-th-list"></i></a>
			</div>
			<div class="imob_resultado_busca_ordenacao_botoes_botao cor_hover" id="layout_bloco">
				<a href="<?php echo $url_layout; ?>&layout=bloco"><i class="fa fa-th"></i></a>
			</div>
		</div>
		<div class="imob_resultado_busca_ordenacao_selecao">
			<div class="imob_resultado_busca_ordenacao_selecao_label">
				<label>Organizar por: </label>
			</div>
			<div class="imob_resultado_busca_ordenacao_selecao_select">
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
		if($_GET['layout'] == 'bloco'){
			$classe_layout = 'imob_resultado_busca_bloco';
		}
		else{
			$classe_layout = 'imob_resultado_busca_lista';
		}
	?>
	<div class="imob_resultado_busca_imoveis">
	<?php 
		if(mysql_num_rows($q) > 0){
			while($imovel = mysql_fetch_assoc($q)){?>
			<div class="<?php echo $classe_layout; ?>" id='imob_resultado_layout'><?php
				$title = retorna_nome('tipo', $imovel['id_tipo']);
				$title .= " para ".retorna_nome('finalidade', $imovel['id_finalidade']);
				$title .= " em ".retorna_nome('cidade', $imovel['id_cidade']);

				$nome_fin = str_replace(' ', '-', strtolower(retorna_nome('finalidade', $imovel['id_finalidade'])));

				$q_foto = mysql_query("SELECT * FROM foto WHERE id_imovel = ".$imovel['id']." ORDER BY posicao LIMIT 0,3");?>

				<div class="imob_resultado_busca_lista_imovel">
					<div class="imob_resultado_busca_lista_imovel_fotos owl-carousel owl_carrousel_imovel_fotos owl-theme">
						<?php
							if($imovel['video']){?>
								<a href="/imovel/<?php echo $imovel['id']; ?>/<?php echo $nome_fin; ?>" title="<?php echo $title; ?>">
									<div class="imob_resultado_busca_lista_imovel_fotos_img">
										<iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $imovel['video']; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
									</div>
								</a><?php
							}
							while($fotos_imovel = mysql_fetch_assoc($q_foto)){?>
								<a href="/imovel/<?php echo $imovel['id']; ?>/<?php echo $nome_fin; ?>" title="<?php echo $title; ?>">
									<div class="imob_resultado_busca_lista_imovel_fotos_img">
										<img src="clientes/<?php echo DIRETORIO; ?>/fotos/<?php echo $imovel['id']; ?>/t1/<?php echo $fotos_imovel['nome'];?>">
									</div>
								</a><?php
							}
							if(mysql_num_rows($q_foto) == 0){?>
								<a href="/imovel/<?php echo $imovel['id']; ?>/<?php echo $nome_fin; ?>" title="<?php echo $title; ?>">
									<div class="imob_resultado_busca_lista_imovel_fotos_img">
										<img src="clientes/<?php echo DIRETORIO; ?>/fotos/nenhuma_foto.jpg" id="sem_foto">
									</div>
								</a><?php
							}
						?>
					</div>
					<div class="imob_resultado_busca_lista_imovel_informacoes">
						<div class="imob_resultado_busca_lista_imovel_informacoes_local">
							<a href="/imovel/<?php echo $imovel['id']; ?>/<?php echo $nome_fin; ?>" title="<?php echo $title; ?>">
								<?php 
									$titulo_imovel 	= retorna_nome('tipo', $imovel['id_tipo']);
									$titulo_imovel .= " para ".retorna_nome('finalidade', $imovel['id_finalidade']);
									$titulo_imovel .= "<span class='bairro'> no ".retorna_nome('bairro', $imovel['id_bairro'])."</span>";
								?>
								<h1><?php echo $titulo_imovel; ?></h1>
								<span><?php if($imovel['id_bairro']){ echo retorna_nome('bairro', $imovel['id_bairro']).' - '; } ?><?php echo retorna_nome('cidade', $imovel['id_cidade']); ?></span>
							</a>
						</div>
						<div class="imob_resultado_busca_lista_imovel_informacoes_favorito" title="Adicionar as favoritos" onclick="favoritar(<?php echo $imovel['id']; ?>, <?php echo $imovel['id_finalidade']; ?>,this);">
							<?php
								$id_imovel 	= $imovel['id'];
								$id_cookie 	= $_COOKIE['cookies_imob'][0];
								$s_favoritos = mysql_query("SELECT * FROM favoritos WHERE id_cookie = '$id_cookie' AND id_imovel = '$id_imovel' AND id_finalidade = ".$imovel['id_finalidade']);

								$classe = "";
								if(mysql_num_rows($s_favoritos) > 0){
									$classe = "fav";
								}
							?>
								<i class="fa fa-heart <?php echo $classe; ?>"></i>
						</div>
						<div class="hack"></div>
						<div class="imob_resultado_busca_lista_imovel_informacoes_especs">
							<ul>
		                        <?php
		                        	if($imovel['quarto']){?>
		                        		<li><span class="tooltip" title="<?php echo $imovel['quarto']; ?> quartos"><i class="fa fa-bed"></i> <?php echo $imovel['quarto']; ?></span></li><?php
		                       		}
		                       		if($imovel['banheiro']){?>
		                        		<li><span class="tooltip" title="<?php echo $imovel['banheiro']; ?> banheiros"><i class="fa fa-bath"></i> <?php echo $imovel['banheiro']; ?></span></li><?php
		                       		}
		                       		if($imovel['suite']){?>
		                        		<li><span class="tooltip" title="<?php echo $imovel['suite']; ?> suítes"><i class="fa fa-tint"></i> <?php echo $imovel['suite']; ?></span></li><?php
		                       		}
		                       		if($imovel['garagem']){?>
		                        		<li><span class="tooltip" title="<?php echo $imovel['garagem']; ?> vagas"><i class="fa fa-car"></i> <?php echo $imovel['garagem']; ?></span></li><?php
		                       		}
		                       		if($imovel['area_construida']){?>
		                        		<li><span class="tooltip" title="<?php echo $imovel['area_construida']; ?> m² área construída"><i class="fa fa-home"></i> <?php echo $imovel['area_construida']; ?> m²</span></li><?php
		                       		}
		                       		if($imovel['terreno']){?>
		                        		<li><span class="tooltip" title="<?php echo $imovel['terreno']; ?> m² terreno"><i class="fa fa-expand"></i> <?php echo $imovel['terreno']; ?> m² </span></li><?php
		                       		}
		                        ?>
							</ul>
						</div>
						<div class="imob_resultado_busca_lista_imovel_informacoes_preco">
							<?php  
								if($imovel['valor'] > 0){?>
									<h1>R$ <?php echo tratar_moeda($imovel['valor'], 2); ?></h1><?php
								}
								else{?>
									<h1>A consultar</h1><?php
								}
							?>
						</div>
						<div class="imob_resultado_busca_lista_imovel_informacoes_ref_mobile">
							<span>Ref. <?php echo $imovel['ref']; ?></span>
						</div>
						<div class="imob_resultado_busca_lista_imovel_informacoes_contato">
							<div class="imob_resultado_busca_lista_imovel_informacoes_contato_ref">
								<span>Ref. <?php echo $imovel['ref']; ?></span>								
							</div>
							<div class="imob_resultado_busca_lista_imovel_informacoes_contato_btn">
								<a href="javascript:void(0)" class='btn_padrao cor_botao' title="Nós te ligamos" onclick="abrirModal('#modal_nos_ligamos', '<?php echo $imovel['ref']; ?>');">
									<i class="fa fa-phone"></i> Nós te ligamos
								</a>
								<a href="javascript:void(0)" class='btn_padrao cor_botao' title="Fale conosco" onclick="abrirModal('#modal_fale_conosco', '<?php echo $imovel['ref']; ?>');">
									<i class="fa fa-comment"></i> Fale conosco
								</a>
							</div>
						</div>
					</div>
				</div>
				</div><?php	
			}
		}
		else{?>
			<div class="imob_resultado_busca_lista_msg">
				<h1>Nenhum imóvel encontrado com os termos pesquisados <i class="fa fa-frown-o"></i></h1>
			</div><?php
		}
	?>
	</div>
	<div class="hack"></div>
	<div class="imob_resultado_busca_paginacao">
		<ul>
			<?php 
				$anterior 	= $pagina-1;
				$proxima 	= $pagina+1;

				$total_paginas = ceil($total_imoveis_busca / $limite);
			?>
			<li class="cor_hover cor_borda_hover">
				<a href="<?php if($pagina == 1){ echo "javascript:void(0)"; }else{ echo url_paginacao($url, $pagina, 1); }  ?>">Primeira</a>
			</li>
			<?php 
				if($pagina > 1){?>
					<li class="cor_hover cor_borda_hover">
						<a href="<?php echo url_paginacao($url, $pagina, $anterior); ?>"><?php echo $anterior; ?></a>
					</li><?php
				}
			?>
			<li class="ativo cor_borda"><a href="javascript:void(0)"><?php echo $pagina; ?></a></li>
			<?php 
				if($pagina < $total_paginas){?>
					<li class="cor_hover cor_borda_hover">
						<a href="<?php echo url_paginacao($url, $pagina, $proxima); ?>"><?php echo $proxima; ?></a>
					</li><?php
				}
			?>
			<li class="cor_hover cor_borda_hover"><a href="<?php if($pagina == $total_paginas){ echo "javascript:void(0)"; }else{ echo url_paginacao($url, $pagina, $total_paginas); }  ?>" title="Última">Última</a></li>
		</ul>
	</div>
</div>
<div class="hack"></div>
