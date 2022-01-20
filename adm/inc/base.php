<?php
  @$pg = $_GET["pg"];
  if(!$pg){$pg = "home"; include "inc/home.php";}
  
  $itens = mysql_query("SELECT * FROM modulo_item WHERE ativo = 'S'");
  while($r = mysql_fetch_assoc($itens)){
    if($pg == $r["pg"]){
      include 'inc/'.$r["pg"].'.php';
    }
  }
?>