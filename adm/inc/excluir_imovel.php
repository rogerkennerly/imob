<?php
  $ajuste_include = "../";
  include ("../checklogin.php");
  include_once ("../funcoes.php");
  
  $id_imovel = evita_injection($_GET["id_imovel"]);
  $senha     = evita_injection($_GET["senha"]);
  
  $id_user = $_SESSION["sessao_id_user"];
  $st = "SELECT * FROM usuario WHERE id = '$id_user' AND senha = '$senha'";
  $qt = mysql_query($st);
 
  if(mysql_num_rows($qt)>0){
    $ref = retorna_campo("imovel", "ref", $id_imovel);
    
    mysql_query("DELETE FROM imove_item WHERE id_imovel = '$id_imovel'");
    
    mysql_query("DELETE FROM imovel_finalidade WHERE id_imovel = '$id_imovel'");
   
    deltree("../../clientes/".DIRETORIO."/fotos/$id_imovel/");
   
    mysql_query("DELETE FROM foto WHERE id_imovel = '$id_imovel'");
    
    if(mysql_query("DELETE FROM imovel WHERE id = '$id_imovel'")){
      $_SESSION["session_sucesso"] = "Imóvel $ref excluído com sucesso!";
      
      $descricao_log = "Imóvel ref. $ref Excluido.";
      gravalog($_SESSION["sessao_id_user"], 1, 3, $descricao_log, $s.$s_item_log);
      
      /////////////////////////////////////////////////////////////////////////////////////////
      //   INTEGRAÇÃO PORTAIS CASA  ||  INTEGRAÇÃO PORTAIS CASA  || INTEGRAÇÃO PORTAIS CASA  //
      /////////////////////////////////////////////////////////////////////////////////////////
      if($r_integracao["integracao"] == "casajau"){
        $xml["key"] = $r_integracao["key_integracao"];
        $xml["imoveis"]["imovel"]["referencia"]     = $ref;
        $xml["imoveis"]["imovel"]["status"]         = "N";
        
        $xml = json_encode($xml);	
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,"https://www.casajau.com.br/integracao_site/index.php");
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "json=".$xml);

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $server_output = curl_exec ($ch);
      }
      /////////////////////////////////////////////////////////////////////////////////////////
      //   INTEGRAÇÃO PORTAIS CASA  ||  INTEGRAÇÃO PORTAIS CASA  || INTEGRAÇÃO PORTAIS CASA  //
      /////////////////////////////////////////////////////////////////////////////////////////
    }
    else{
      $_SESSION["session_erro"] = "Erro ao excluir o Imóvel $ref!";
    }
    
  }else{  
    $_SESSION["session_erro"] = "Senha incorreta ou acesso negado!";
  }
  header("Location: ../index.php?pg=listar-imoveis");
?>