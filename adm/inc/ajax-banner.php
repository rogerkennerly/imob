<?php
session_start();
  include "../../config.php";
  include "../../conexao.php";
  include "../funcoes.php";
  include "funcoes_gdlib.php";
  
  //falta incluir o cabeçalho aqui  
  
  $tamanho = "";
  $dir = "../../clientes/".DIRETORIO."/assets/img/banner/";
  
  $pos = 0;
  if (isset($_FILES["file"])){
    if(!is_dir($dir)){ mkdir($dir,0777); chmod($dir,0777);}
    
    $total = count($_FILES["file"]['name']);
    for($x=0 ; $x<$total ; $x++){
      $cname = rand(0, 10000000);
      $nome = $cname."_".$_FILES["file"]['name'][$x];
      
      if(move_uploaded_file($_FILES["file"]['tmp_name'][$x], $dir.$nome)){
        echo "ok";
      }else{
        echo "erro";
      }
      
      $last_pos = mysql_query("SELECT posicao FROM banner ORDER BY posicao DESC LIMIT 0,1");
      $last_pos = mysql_fetch_assoc($last_pos);
      $pos = $last_pos["posicao"]+1;
      
      $data = date("Y-m-d H:i:s");
      $sql_i = "INSERT INTO banner (nome, posicao) VALUES ('$nome', '$pos')";
      $query_insert = mysql_query($sql_i);
      $pos++;
      
      $descricao_log = "Banner Incluido - nome. $nome";
      gravalog($_SESSION["sessao_id_user"], 8, 1, $descricao_log, $s);
    }
  }
?>