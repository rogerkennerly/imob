<?php
  include "../config.php";
  include "../conexao.php";
  
  $s = "SELECT * FROM imovel WHERE disponivel = 'S'";
  $q = mysql_query($s);
  while($r = mysql_fetch_assoc($q)){
    $st = "SELECT * FROM tipo WHERE id = '".$r['id_tipo']."'";
    $qt = mysql_query($st);
    if(mysql_num_rows($qt)<1){
      echo "Ref: ".$r['ref']."<br>";
    }
  }
?>