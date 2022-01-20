<?php
  error_reporting(0);
  session_start();
  
	if( !mysql_ping($db) ){
		mysql_close($db);
    
    $user_db  = "helpdesksys";
    $pass_db  = "passhelp";
    $database = "helpdesk_system";
    
		$db = mysql_connect($local_db, $user_db, $pass_db) or die('Error connecting to Database!');
		mysql_set_charset('utf8', $db);
		mysql_select_db($database, $db);
	}
  
  if(@$_GET["new"] == 'S'){
    $msg = $_GET["msg"];
    $id_usuario = $_SESSION["sessao_id_user"];
    
    $s = "INSERT INTO chamados (id_sistema, id_usuario, data, hora) VALUES (1, '$id_usuario', '".date("Y-m-d")."', '".date("H:i:s")."')";
    $q = mysql_query($s);
    $id_chamado = mysql_insert_id();
    
    $s = "INSERT INTO chamado_mensagens (id_chamado, data, hora, msg, remetente) VALUES ($id_chamado, '".date("Y-m-d")."', '".date("H:i:s")."', '$msg', 'C')";
    $q = mysql_query($s);
  }
?>

<script>
abrir_chamado('<?php echo $id_chamado; ?>');
</script>
