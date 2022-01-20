<?php
  $ajuste_include = "../";
  include ("../checklogin.php");
  include_once ("../funcoes.php");
  
  $id_mensagem = evita_injection($_GET["id_mensagem"]);
  $senha     = evita_injection($_GET["senha"]);
  
  $id_user = $_SESSION["sessao_id_user"];
  $st = "SELECT * FROM usuario WHERE id = '$id_user' AND senha = '$senha'";
  $qt = mysql_query($st);
 
  if(mysql_num_rows($qt)>0){
    $s = "DELETE FROM contato WHERE id = '$id_mensagem'";
    if(mysql_query($s)){
      $_SESSION["session_sucesso"] = "Contato $id_mensagem excluído com sucesso!";
      
      $descricao_log = "Contato Excluido - id. $id_mensagem";
      gravalog($_SESSION["sessao_id_user"], $descricao_log, $s.$s_item_log);
    }
    else{
      $_SESSION["session_erro"] = "Erro ao excluir o Imóvel $ref!";
    }
    
  }else{  
    $_SESSION["session_erro"] = "Senha incorreta ou acesso negado!";
  }
  header("Location: ../index.php?pg=listar-contatos");
?>