<div class="main-content">

<?php
  require "inc/breadcrumb.php";
  
  if($pg == "layout"){
    include "inc/layout_menu.php";
  }
  else{
    include "inc/menu.php";
  }
  
  if($_SESSION["session_sucesso"]){echo sucesso($_SESSION["session_sucesso"]);unset($_SESSION["session_sucesso"]);}
  if($_SESSION["session_erro"])   {echo alerta($_SESSION["session_erro"]);    unset($_SESSION["session_erro"]);   }
  
  @$pg = $_GET["pg"];
  if(!$pg){$pg = "home"; include "inc/home.php";}
  
  if($_SESSION['WEBMASTER'] == 'webmaster'){
    $itens = mysql_query("SELECT * FROM modulo_item WHERE ativo = 'S'");
  }
  else{
    $itens = mysql_query("SELECT * FROM modulo_item WHERE ativo = 'S' AND id IN (SELECT id_modulo_item FROM permissao WHERE id_usuario = '".$_SESSION["sessao_id_user"]."')");
  }
  
  while($r = mysql_fetch_assoc($itens)){
    if($pg == $r["pg"]){
      include 'inc/'.$r["pg"].'.php';
    }
  }
  
  if($pg == 'config_master' AND $_SESSION['WEBMASTER'] == 'webmaster'){
    include 'inc/config_master.php';
  }
  if($pg == 'modulos' AND $_SESSION['WEBMASTER'] == 'webmaster'){
    include 'inc/modulos.php';
  }
?>

</div><!-- /.main-container-inner -->