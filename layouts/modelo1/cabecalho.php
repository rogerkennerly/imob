<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php 
   session_start();
   
   if($_GET['layout'] == 'lista'){
      $_SESSION['tipo_layout'] = 'lista';
   }
   else if($_GET['layout'] == 'bloco'){
      $_SESSION['tipo_layout'] = 'bloco';
   }
   
   if(!$_SESSION['tipo_layout']){
      $_SESSION['tipo_layout'] = 'lista';
   }

	$url 	= "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
	$base 	= "http://$_SERVER[HTTP_HOST]/";
?>
<head itemscope itemtype="http://schema.org/WebSite">
	<base href="<?php echo $base; ?>">
	<meta charset="UTF-8">
	<meta http-equiv="Content-Type" 	content="text/html; charset=utf-8"/>
	<meta name="keywords" 			  	content="<?php echo $tags; ?>">
	<meta name="distribution" 			content="Global">
	<meta name="viewport" 				content="width=device-width, initial-scale=1, maximum-scale=1"/>
	<meta name="author" 				   content="Hospedaria Internet - hospedaria.com.br"/>
	<meta name="description" 			content="<?php echo $descricao; ?>"/>
	<meta name="theme-color" 			content="#ffffff"/>

	<title><?php echo $dados['nome']; ?> - Imóveis para <?php echo $finalidades; ?></title>

	<meta property="fb:app_id" 			content="602571720087652">
	<meta property="og:locale" 			content="pt_BR">
	<meta property="og:site_name" 		content="<?php echo $dados['nome']; ?>">
	<meta property="og:url"         	   content="<?php echo $url; ?>">
	<meta property="og:type"         	content="website">
	<meta property="og:title"        	content="<?php echo $og_title; ?>">
	<meta property="og:description"  	content="<?php echo $descricao; ?>">
	<meta property="og:image"        	content="<?php echo $og_image; ?>">
	<meta property="og:image:type" 		content="image/png">

	<!-- ARQUIVOS CSS -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Varela+Round">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="layouts/<?php echo $layout; ?>/assets/js/owl/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="layouts/<?php echo $layout; ?>/assets/js/owl/assets/owl.theme.default.min.css">
	<link rel="stylesheet" href="layouts/<?php echo $layout; ?>/assets/css/fancybox/jquery.fancybox.min.css">
	<link rel="stylesheet" href="layouts/<?php echo $layout; ?>/assets/css/chosen/chosen.min.css">
	<link rel="stylesheet" href="layouts/<?php echo $layout; ?>/assets/css/tooltipster/tooltipster.bundle.min.css">
	<link rel="stylesheet" href="layouts/<?php echo $layout; ?>/assets/css/estilos.css">

	<!-- SCRIPTS -->
	<script src="layouts/<?php echo $layout; ?>/assets/js/jquery-3.2.1.min.js"></script>
	<script src="layouts/<?php echo $layout; ?>/assets/js/owl/owl.carousel.min.js"></script>
	<script src="layouts/<?php echo $layout; ?>/assets/js/mask/jquery.mask.js"></script>	
	<script src="layouts/<?php echo $layout; ?>/assets/js/fancybox/jquery.fancybox.min.js"></script>
	<script src="layouts/<?php echo $layout; ?>/assets/js/chosen/chosen.jquery.min.js"></script>
	<script src="layouts/<?php echo $layout; ?>/assets/js/chosen/chosen.proto.min.js"></script>
	<script src="layouts/<?php echo $layout; ?>/assets/js/tooltipster/tooltipster.bundle.min.js"></script>
	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<script src="layouts/<?php echo $layout; ?>/assets/js/funcoes.js"></script>

	<?php 
		$q_exibe_sobre = mysql_query("SELECT texto FROM sobre_empresa");
		$exibe_sobre 	 = mysql_fetch_assoc($q_exibe_sobre);

		$q_config 	= mysql_query("SELECT * FROM config");
		$config 	= mysql_fetch_assoc($q_config);

		if($config['cor_layout'] == ''){
			$cor_layout = "#0051DE";
		}
		else{
			$cor_layout = $config['cor_layout'];
		}

		if($config['cor_botao'] == ''){
			$cor_botao = "#0051DE";
		}
		else{
			$cor_botao 	= $config['cor_botao'];
		}

		if($config['key_captcha']){
			$sitekey = $config['key_captcha'];
		}
	?>

	<style>
		.cor_layout				{ background-color:<?php echo $cor_layout ?>; }
		.cor_layout_texto		{ color:<?php echo $cor_layout ?>; }
		.cor_botao				{ background-color:<?php echo $cor_botao ?>; }
		.cor_hover:hover		{ background-color:<?php echo $cor_layout ?>; }
		.cor_fonte_hover:hover	{ color:<?php echo $cor_botao ?>; }
		.cor_borda				{ border-color:<?php echo $cor_layout ?> !important; }
		.cor_borda_hover:hover	{ border-color:<?php echo $cor_layout ?>; }
		.cor_outline:focus		{ outline-color:<?php echo $cor_layout ?>;}
		.ativo					{ background-color:<?php echo $cor_layout ?>; border-color:<?php echo $cor_layout ?>; color: #fff; }

      @media only screen and (min-width: 641px) and (max-width: 1023px) {
			.cor_layout_mobile		 { background-color:<?php echo $cor_layout ?>; }
			.cor_layout_mobile_texto { color:<?php echo $cor_layout ?>; }
		}

		@media only screen and (max-width: 640px) {
			.cor_layout_mobile		 { background-color:<?php echo $cor_layout ?>; }
			.cor_layout_mobile_texto { color:<?php echo $cor_layout ?>; }
		}
	</style>
</head>
