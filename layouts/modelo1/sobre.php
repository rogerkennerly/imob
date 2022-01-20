<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<section class="imob_sobre">
	<div class="centralizador">
		<?php 
			$q_sobre = mysql_query("SELECT * FROM sobre_empresa");
			$sobre 	 = mysql_fetch_assoc($q_sobre);
		?>
		<div class="imob_sobre_titulo">
			<h1><?php echo $sobre['titulo']; ?></h1>
		</div>
		<div class="imob_sobre_texto"><?php echo $sobre['texto']; ?></div>
	</div>
</section>

<style>
	.imob_sobre_texto p{ font-size: 1.5rem; margin: 1rem 0;  }
	.imob_sobre_texto h1, h2, h3, h4{ margin: 2rem 0 1rem 0; }
	.imob_sobre_texto h2{ font-size: 2.6rem; }
	.imob_sobre_texto h3{ font-size: 2.2rem; }
	.imob_sobre_texto h4{ font-size: 1.8rem; }
</style>