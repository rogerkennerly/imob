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
  
  $id_chamado = $_GET["id_chamado"];
  
  $s = "SELECT * FROM chamados WHERE id = '$id_chamado'";
  $q = mysql_query($s);
  $chamado = mysql_fetch_assoc($q);
?>

<div style="float:left;width:100%;padding:1rem;line-height:3.3rem;background-color: #f2f2f2;border-bottom: 1px solid #e6e6e6;box-shadow: 0px 0px 5px -3px;">
  <i class="fas fa-angle-left" style="font-size: 3rem;vertical-align: middle;color: #9e9999;margin-right: 1rem;cursor:pointer;"></i>
  <img src="http://www.hospedaria.com.br/ticket/img/avatars/tello.jpg" width="35" class="helpdesk-avatar-chat">
  <span style="font-weight:bold;font-size:1.4rem;margin-left:1rem;">Lucas Tello</span>
  <div style="float:right;">Disponível<div style="width:1rem;height:1rem;border-radius:100%;background-color:green;float:right;margin-top:1.2rem;margin-left:0.5rem;"></div></div>
</div>

<div class="helpdesk-chat-fullbox">
  <?php
  $s = "SELECT * FROM chamado_mensagens WHERE id_chamado = '$id_chamado'";
  $q = mysql_query($s);
  while($mensagens = mysql_fetch_assoc($q)){
    
    if($mensagens["remetente"] == 'C'){?>
    <div class="helpdesk-cliente-box-msg">
      <div class="helpdesk-cliente-msg">
        <?php echo $mensagens["msg"]; ?>
        <div class="helpdesk-cliente-time"><?php echo $mensagens["hora"]; ?></div>
      </div>
    </div>
    <?php
    }
    elseif($mensagens["remetente"] == 'S'){?>
    <div class="helpdesk-suporte-box-msg">
      <div class="helpdesk-suporte-msg">
        <?php echo $mensagens["msg"]; ?>
        <div class="helpdesk-suport-time"><?php echo $mensagens["hora"]; ?></div>
      </div>
    </div>
  <?php
    }
  }?>
</div>

<textarea class="helpdesk-text-area" placeholder="Digite uma mensagem"></textarea>
<button class="helpdesk-enviar-chat"><i class="fas fa-angle-double-right"></i></button>
