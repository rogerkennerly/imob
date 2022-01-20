<?php
	if( !mysql_ping($db) ){
		mysql_close($db);
    
    $user_db  = "helpdesksys";
    $pass_db  = "passhelp";
    $database = "helpdesk_system";
    
		$db = mysql_connect($local_db, $user_db, $pass_db) or die('Error connecting to Database!');
		mysql_set_charset('utf8', $db);
		mysql_select_db($database, $db);
	}
  
  $s = "SELECT * FROM chamados";
  $q = mysql_query($s);
?>

<div class="helpdesk-box-top" onmouseover="$('#sp-nm').toggle();" onmouseout="$('#sp-nm').hide();" onclick="$('#helpdesk').fadeToggle()">
  <span id="sp-nm" class="helpdesk-subt">SUPORTE</span>
  <i class="far fa-comment" style="font-size:2.6rem;color:#666;color:#FFF;margin-top:1.2rem;float:right;"></i>
</div>  

<div id="helpdesk">
  <div class="tit-helpdesk">
    Suporte
    <div class="tit-helpdesk-close" onclick="$('#helpdesk').fadeToggle()">
      <i class="fas fa-times"></i>
    </div>
  </div>

  <div class="helpdesk-workarea">
    <div class="helpdesk-atendimentos">
      <?php
      while($chamado = mysql_fetch_assoc($q)){
        $id_chamado = $chamado["id"];
        $ss = "SELECT * FROM chamado_mensagens WHERE id_chamado = '$id_chamado' ORDER BY id DESC LIMIT 0,1";
        $qs = mysql_query($ss);
        $r = mysql_fetch_assoc($qs);
        ?>
        <div class="atendimento-helpdesk" onclick="abrir_chamado('id_chamado')">
          <img src="http://www.hospedaria.com.br/ticket/img/avatars/tello.jpg" width="55" class="helpdesk-avatar">
          <div class="helpdesk-nome">
            Lucas Tello
          </div>
          <div class="helpdesk-resumo">
            <?php echo $r["msg"]; ?>
          </div>
          <div class="helpdesk-time-alert">09:23</div>
        </div>
        <div class="helpdesk-separador"></div>
      <?php
      }?>
    </div>
    
    <textarea class="helpdesk-enviar" placeholder="Fale conosco" onkeyup="helpdesk_prevent();"></textarea>
    <div class="helpdesk-botao-enviar" onclick="helpdesk_new()">enviar</div>
  </div>
</div>

<script>
function abrir_chamado(id_chamado){
  $(".helpdesk-workarea").html('<div style="width:100%;text-align:center;line-height:459px;"><img src="assets/img/carregando.gif" width="100"></div>');
  alert(id_chamado);
  $.ajax({
    url: "inc/helpdesk_carrega_chamado.php?id_chamado="+id_chamado,
    cache: false,
    success: function(html){
      $(".helpdesk-workarea").html(html);
    },
  });
}

function helpdesk_prevent(){
  if(event.keyCode == '13'){
    var msg = $(".helpdesk-enviar").val();
    msg = msg.replace(/^\s+/,"");
    if(msg){
      helpdesk_new();
    }
  }
}

function helpdesk_new(){
  var msg = $(".helpdesk-enviar").val();
  msg = msg.replace(/^\s+/,"");
  if(!msg){
    alert("digite uma mensagem");
  }
  else{
    $.ajax({
      url: "inc/helpdesk_grava_chamado.php?new=S&msg="+msg,
      cache: false,
      success: function(html){
        $(".helpdesk-workarea").html(html);
      },
    });
  }
}
</script>