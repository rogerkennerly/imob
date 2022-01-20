<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<header class="imob_topo">
	<div class="centralizador">
		<div class="imob_topo_logo">
			<a href="./" title="<?php echo $dados['nome']; ?>">
				<img src="clientes/<?php echo DIRETORIO; ?>/assets/img/<?php echo $dados['logo']; ?>" alt="Logotipo <?php echo $dados['nome']; ?>">
			</a>
		</div>
		<div class="imob_topo_abre_menu_mobile">
			<span  onclick='$(".imob_topo_menu").slideToggle();'>
				<i class="fa fa-bars cor_layout_mobile_texto"></i>
			</span>
		</div>
		<nav class="imob_topo_menu cor_layout_mobile">
			<ul>
				<li>
					<a href="./" class="cor_fonte_hover" title="Link para página inicial">Home</a>
				</li>
				<?php
					if($exibe_sobre['texto']){?>
						<li>
							<a href="sobre" class="cor_fonte_hover" title="Link para página sobre">Sobre</a>
						</li><?php
					}
				?>
        <li>
					<a href="cadastrar-imovel" class="cor_fonte_hover" title="Link para página de cadastro de imóvel">Cadastrar Imóvel</a>
				</li>
				<li>
					<a href="favoritos/maior/<?php echo $_SESSION['tipo_layout']; ?>/1" class="cor_fonte_hover" title="Link para página de favoritos">Favoritos</a>
         </li>
				<li>
					<a href="contato" class="cor_fonte_hover" title="Link para página de contato">Contato</a>
				</li>
			</ul>
		</nav>
		<div class="hack"></div>
	</div>
</header>
