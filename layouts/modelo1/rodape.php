<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<div class="cor_layout" style="width: 100%; height: 1rem;"></div>
<footer class="imob_rodape" id="imob_rodape">
	<div class="centralizador">
		<div class="imob_rodape_opcoes">
			<div class="imob_rodape_opcoes_item">
				<div class="imob_rodape_opcoes_item_tipos">
					<?php
						$s = "SELECT * FROM imovel_finalidade WHERE id_finalidade = 1";
						$q = mysql_query($s);

						if(mysql_num_rows($q) > 0){?>
							<a href="index.php?pg=busca&finalidade=1&ordem=maior&pagina=1" class='btn_padrao cor_botao cor_borda_hover cor_fonte_hover' id="btn_comprar" title="Comprar um imóvel">Comprar</a><?php
						}
					?>
					<?php
						$s = "SELECT * FROM imovel_finalidade WHERE id_finalidade = 2";
						$q = mysql_query($s);

						if(mysql_num_rows($q) > 0){?>
							<a href="index.php?pg=busca&finalidade=2&ordem=maior&pagina=1" class='btn_padrao cor_botao cor_borda_hover cor_fonte_hover' id="btn_alugar" title="Alugar um imóvel">Alugar</a><?php
						}
					?>
				</div>
			</div>
			<?php
				if($exibe_sobre['texto']){?>
					<div class="imob_rodape_opcoes_item">
						<div class="imob_rodape_opcoes_item_titulo">
							<h1>A Imobiliária</h1>
						</div>
						<div class="imob_rodape_opcoes_item_empresa">
							<ul>
								<li><a href="sobre" title="Link para a página sobre">Sobre a empresa</a></li>
							</ul>
						</div>
					</div><?php
				}
			?>
			<div class="imob_rodape_opcoes_item">
				<div class="imob_rodape_opcoes_item_titulo">
					<h1>Atendimento</h1>
				</div>
				<div class="imob_rodape_opcoes_item_atendimento">
					<ul>
						<li><a href="contato" title="Link para a página fale conosco">Fale conosco</a></li>
					</ul>
				</div>
			</div>
			<div class="imob_rodape_opcoes_item">
			<?php
				if($dados['facebook'] OR $dados['twitter'] OR $dados['instagram'] OR $dados['youtube']){?>
				<div class="imob_rodape_opcoes_item_titulo">
					<h1>Redes Sociais</h1>
				</div>
					<div class="imob_rodape_opcoes_item_redes">
						<ul>
							<?php  
								if($dados['facebook']){
									$facebook = str_replace(array('http://', 'https://'), '', $dados['facebook'])?>
									<li><a href="http://<?php echo $facebook; ?>" target="_blank" title="Link para o Facebook"><i class="fa fa-facebook"></i></a></li><?php
								}
								if($dados['twitter']){
									$twitter = str_replace(array('http://', 'https://'), '', $dados['twitter'])?>
									<li><a href="http://<?php echo $twitter; ?>" target="_blank" title="Link para o Twitter"><i class="fa fa-twitter"></i></a></li><?php
								}
								if($dados['instagram']){
									$instagram = str_replace(array('http://', 'https://'), '', $dados['instagram'])?>
									<li><a href="http://<?php echo $instagram; ?>" target="_blank" title="Link para o Instagram"><i class="fa fa-instagram"></i></a></li><?php
								}
								if($dados['youtube']){
									$youtube = str_replace(array('http://', 'https://'), '', $dados['youtube'])?>
									<li><a href="http://<?php echo $youtube; ?>" target="_blank" title="Link para o Youtube"><i class="fa fa-youtube"></i></a></li><?php
								}
							?>
						</ul>
					</div><?php
				}
				?>
			</div>
			<div class="hack"></div>
		</div>
	</div>
	<div class="imob_assinatura cor_layout" id="imob_assinatura">
		<div class="centralizador">
			<div class="imob_assinatura_texto">
				<p>&copy; <?php echo date('Y'); ?> <?php echo $dados['nome']; ?> - Todos os direitos reservadoss</p>
        <br/>
        <a href="http://hospedaria.com.br" target="_blank"><img src="layouts/<?php echo $layout; ?>/assets/img/assinatura_hospedaria.png" width="100" style="margin-top:10px;"></a>
			</div>
		</div>
	</div>
	<?php 
		if($dados['celular']){
			$celular = str_replace(array('(', ')', '-', ' '), '', $dados_celular[0]);
			$celular = '55'.$celular;?> 

			<div class="imob_whatsapp_contato">
				<a href="http://api.whatsapp.com/send?phone=<?php echo $celular; ?>" target="_blank" title="Entre em contato pelo Whatsapp">
					<img src="layouts/<?php echo $layout; ?>/assets/img/whats_contato.png" alt="Contato pelo Whatsapp">
				</a>
			</div><?php
		}

		echo $config['scripts'];
	?>
</footer>
