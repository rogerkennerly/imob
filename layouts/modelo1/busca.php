<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php 
	if($_GET){
		if($_GET['finalidade'])	{ $finalidade 	= evita_injection($_GET['finalidade']); }
		if($_GET['tipo_imovel']){ $tipo 			= $_GET['tipo_imovel']; }
		if($_GET['cidade'])		{ $cidade 		= evita_injection($_GET['cidade']); }
		if($_GET['bairro'])		{ $bairro 		= $_GET['bairro']; }
		if($_GET['valor_min'])	{ $valor_min 	= evita_injection(tratar_moeda($_GET['valor_min'], 1)); }
		if($_GET['valor_max'])	{ $valor_max 	= evita_injection(tratar_moeda($_GET['valor_max'], 1)); }
		if($_GET['quartos'])		{ $quartos 		= evita_injection($_GET['quartos']); }
		if($_GET['suites'])		{ $suites 		= evita_injection($_GET['suites']); }
		if($_GET['banheiros'])	{ $banheiros 	= evita_injection($_GET['banheiros']); }
		if($_GET['vagas'])		{ $vagas 		= evita_injection($_GET['vagas']); }
		if($_GET['referencia'])	{ $referencia 	= evita_injection($_GET['referencia']); }
	}
?>
<section class="imob_busca">
	<?php 
	    if($detectMobile -> isMobile()){ 
	    	if(!include "clientes/".DIRETORIO."/inc/form_pesquisa_horizontal.php"){include "layouts/$layout/form_pesquisa_horizontal.php";}
	   }
	?>
	<div class="centralizador">
		<?php if(!include "clientes/".DIRETORIO."/inc/breadcrumbs.php"){include "layouts/$layout/breadcrumbs.php";} ?>
		<?php if(!include "clientes/".DIRETORIO."/inc/form_pesquisa_vertical.php"){include "layouts/$layout/form_pesquisa_vertical.php";} ?>
		<?php if(!include "clientes/".DIRETORIO."/inc/resultado_busca.php"){include "layouts/$layout/resultado_busca.php";} ?>
		<?php if(!include "clientes/".DIRETORIO."/inc/modal.php"){include "layouts/$layout/modal.php";} ?>
	</div>
</section>
