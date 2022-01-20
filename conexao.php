<?php 
if(basename($_SERVER['PHP_SELF']) == basename(__FILE__)){exit();}

ini_set('date.timezone' , 'America/Sao_Paulo');

$link = mysql_connect('localhost', $userdb, $passdb) or die ('Erro ao conectar com o banco de dados, Tente novamente mais tarde!'.mysql_error());
if(!isset($notutf8)){$notutf8 = false;}
$modulo = '';if(isset($_GET['modulo'])){$modulo = $_GET['modulo'];}
if($notutf8 == false AND $modulo != 'gbol'){
  mysql_set_charset('utf8', $link);
}

$db = mysql_select_db($basedb, $link);

$smodelo = "SELECT layout FROM config";
$qmodelo = mysql_query($smodelo);
$rmodelo = mysql_fetch_assoc($qmodelo);
$layout  = $rmodelo["layout"];

if($_GET['layout_choice_awards']){
	$layout = $_GET['layout_choice_awards'];
}
?>