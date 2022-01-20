<?php   
  error_reporting(E_ALL ^ E_NOTICE);
  error_reporting(1); 
	require "config.php";
	require "conexao.php";
  // include "atualizador.php"; //atualiza o banco de dados se necessário (troca de versão)
	include "adm/funcoes.php";
	include "layouts/$layout/assets/lib/mobile/Mobile_Detect.php";
	$detectMobile = new Mobile_Detect;

	$codigo_cookie = mktime(date('H'), date('i'), date('s'), date('d'), date('m'), date('Y'));
	$tempo_expiracao = time()+3600*24*30*12*1; //O ultimo numero é a quantidade de anos
	if(@!$_COOKIE['cookies_imob']){
		setcookie('cookies_imob' , $codigo_cookie, $tempo_expiracao);
	}

	$q_dados 	= mysql_query("SELECT * FROM dados_imobiliaria");
	$dados 		= mysql_fetch_assoc($q_dados);

	$dados_email = explode(';', $dados['email']);
	$dados_creci = explode(';', $dados['creci']);
	$dados_telefone = explode(';', $dados['telefone']);
	$dados_celular = explode(';', $dados['celular']);


	// Utilizados na descricao (mudar depois)
	$creci = $dados_creci[0];
	if($dados_creci[1]){
		$creci .= '/'.$dados_creci[1];
	}

	$descricao = $dados['nome'].' - CRECI: '.$creci.' | Endereço: '.$dados['endereco'].' | Telefone:'; 
	foreach($dados_telefone as $telefone){
		$comp_telefone .= ' '.$telefone;
	}
	$descricao .= $comp_telefone;

	$descricao .= ' | Whatsapp:';
	foreach($dados_celular as $celular){
		$comp_celular .= ' '.$celular;
	}
	$descricao .= $comp_celular;


	// CONFIGURAÇÕES DE COMPARTILHAMENTO //
	if($_GET['pg'] == 'imovel'){
		$id_imovel = evita_injection($_GET['id']);

		$s_imovel = "SELECT imovel.*, imovel_finalidade.id_finalidade, imovel_finalidade.valor as valor_finalidade, imovel_finalidade.iptu, imovel_finalidade.condominio FROM imovel, imovel_finalidade WHERE disponivel = 'S' AND excluido = 'N' AND imovel.id = '$id_imovel' AND imovel.id = imovel_finalidade.id_imovel";
		$q_imovel = mysql_query($s_imovel);
		$imovel   = mysql_fetch_assoc($q_imovel);

		if(mysql_num_rows($q_imovel) > 0){
			$og_title  = retorna_nome('tipo', $imovel['id_tipo']);
			$og_title .= " para ".retorna_nome('finalidade', $imovel['id_finalidade']);
			$og_title .= " no bairro ".retorna_nome('bairro', $imovel['id_bairro']);
			$og_title .= " em ".retorna_nome('cidade', $imovel['id_cidade']);

			$s_foto = "SELECT * FROM foto WHERE id_imovel = ".$imovel['id']." ORDER BY posicao LIMIT 1";
			$q_foto = mysql_query($s_foto);
			$foto 	= mysql_fetch_assoc($q_foto);

			if(mysql_num_rows($q_foto) > 0){
				$og_image = "http://".$_SERVER['HTTP_HOST']."/clientes/".DIRETORIO."/fotos/".$imovel['id']."/t1/".$foto['nome']."";
			}
			else{
				$og_image = "http://".$_SERVER['HTTP_HOST']."/clientes/".DIRETORIO."/fotos/nenhuma_foto.jpg";
			}
		}
	}

	if(!$og_image){
		$og_image = "http://".$_SERVER['HTTP_HOST']."/clientes/".DIRETORIO."/assets/img/".$dados['logo'];
	}
	if(!$og_title){
		$og_title = $dados['nome'];
	}
	// FIM CONFIGURAÇÃO DE COMPARTILHAMENTO //

	// CONFIG METATAG KEYWORDS //
	$s_fin = 'SELECT nome FROM finalidade';
	$q_fin = mysql_query($s_fin);

	$s_tipo = 'SELECT nome FROM tipo';
	$q_tipo = mysql_query($s_tipo);

	$tags = '';
	$finalidades = '';

	while($fin = mysql_fetch_assoc($q_fin)){
		$tags .= $fin['nome'].', ';
		$finalidades .= $fin['nome'].', ';
	}
	while($tipo = mysql_fetch_assoc($q_tipo)){
		$tags .= $tipo['nome'].', ';
	}

	$size_tag = strlen($tags);
	$tags = substr($tags, 0, $size_tag-2);
	$tags = strtolower($tags);

	$size_fin = strlen($finalidades);
	$finalidades = substr($finalidades, 0, $size_fin-2);
	$finalidades = ucwords($finalidades);
	// FIM CONFIG METATAG KEYWORDS //
?>
<!DOCTYPE html>
<html lang="pt-BR" xml:lang="pt-BR">
  <?php if(!include "clientes/".DIRETORIO."/inc/cabecalho.php"){include "layouts/$layout/cabecalho.php";}?>
  <body>
    <?php include "layouts/$layout/base.php"; ?>
  </body>
</html>
