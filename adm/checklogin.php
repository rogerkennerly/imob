<?php
  define('MAXLOGINERROR', 5);
  session_start();
  session_name("sistimob");
  @include("$ajuste_include../config.php");
  @include("$ajuste_include../conexao.php");
  include_once("funcoes.php");    
  
  // require('../fn/error_handler.php');
	
  //= ' or '1'='1
  $erromsg = ''; $autorizado = false; $cabecalho = '';
  if (!isset($_REQUEST['acao'])) { $acao    = 'verif'; } else { $acao    = $_REQUEST['acao']; }
  if (!isset($_POST['usuario'])) { $usuario = '';      } else { $usuario = $_POST['usuario']; }
  if (!isset($_POST['senha']))   { $senha   = '';      } else { $senha   = $_POST['senha'];   }
  if (!isset($_GET['auth']))     { $auth    = '';      } else { $auth    = $_GET['auth'];     }
    
    
  if($_SESSION['WEBMASTER'] == 'webmaster' AND !isset($_SESSION["sessao_usuario"])){
    $_SESSION["sessao_usuario"] = 'Webmaster';
    $_SESSION["sessao_senha"]   = '';
    $_SESSION["sessao_avatar"]  = '';
    $_SESSION["sessao_nome"]    = 'Webmaster';
    $_SESSION["sessao_id_user"] = '';
    $_SESSION["tplg"]           = "adm";
    $autorizado = true;
    header("Location: index.php");exit;
  }
  
  if ($acao == "login"){     
    $erromsg = checkip('L'); 
    if ($erromsg != "") { $acao = "logout"; }
    
    if ($erromsg == ""){
      if (strpos($usuario,"'") > 0 or strpos($senha,"'") > 0){
        $acao = "errologingrave";
      }
      else{
        if($usuario == '' AND $senha == ''){
          $_SESSION['msg_erro_login'] = "Preencha todos os campos.";
          header("Location: login.php");
        }
        else{
          $ip    = $_SERVER["REMOTE_ADDR"];
          $result = mysql_query("select * from ip_deny where ip='$ip'");
          $count = mysql_num_rows($result);
          if($count > MAXLOGINERROR){
            $_SESSION['msg_erro_login'] = "IP bloqueado por 24 horas";
            header("Location: login.php");
            exit;
          }
          
          $q_radmin = "select * from usuario where usuario='$usuario' and senha='$senha' and usuario<>' '";
          $radmin = mysql_query($q_radmin);
          if (mysql_num_rows($radmin) > 0){
            $r = mysql_fetch_assoc($radmin);
            
            $ativo = $r['ativo'];
            
            if($ativo == 'S'){
              $_SESSION["sessao_usuario"] = $r["usuario"];
              $_SESSION["sessao_senha"]   = $r["senha"];
              $_SESSION["sessao_avatar"]  = $r["avatar"];
              $_SESSION["sessao_nome"]    = $r["nome"];
              $_SESSION["sessao_id_user"] = $r["id"];
              $_SESSION["sessao_tipo_user"] = $r["tipo"];
              $_SESSION["tplg"]           = "adm";
              
              mysql_query("UPDATE usuario SET ultimo_login = NOW() WHERE id = '".$r["id"]."'");
              
              $autorizado = true;
              $descricao_log = "Login efetuado.";
              gravalog($r["id"], 100, 0, $descricao_log, $q_radmin);
              header("Location: index.php");
            }
            else{
              $descricao_log = "Tentativa de login de usuário inativado.";
              gravalog($r["id"], 100, 0, $descricao_log, $q_radmin);
              
              $acao = "usuario_inativado";
            }
          } 
          else{
            $descricao_log = "Tentativa de login falha de login.";
            gravalog($r["id"], 100, 0, $descricao_log, $q_radmin);
            
            $acao = "errologin"; 
          }
        }
      }  
    }    
  } 
  
  if ($acao == "verif"){
    $msg = checkip('L'); if ($erromsg != "") { $acao = "logout"; }
    
    $tplg = $_SESSION["tplg"];
    if ($erromsg == ""){
      if(!$tplg){
        $acao = "errologin";
      }
      $tplg = $_SESSION["tplg"];
      if (strpos($_SESSION["sessao_usuario"],"'") > 0 or strpos($_SESSION["sessao_senha"],"'") > 0){
        $acao = "errologingrave"; 
      }
      else{
        $radmin = mysql_query("select * from usuario where usuario='".$_SESSION["sessao_usuario"]."' and senha='".$_SESSION["sessao_senha"]."' and id=".$_SESSION["sessao_id_user"]." and usuario<>' '");
        $linhas = mysql_num_rows($radmin);
        if ($linhas > 0){
          $autorizado = true; 
        } 
        else{
          if($_SESSION["WEBMASTER"] == 'webmaster'){
            $autorizado = true;
          }
          else{
            header("Location: login.php");exit;
          }
        }
      }  
    }    
  } 
  
  if ($acao == "logout"){
    if ($erromsg == ""){ 
      $erromsg = "Desconectado";
    } // isso acontece quando a pessoa clica em logout
    session_name("sistimob");
    session_destroy();

    $descricao_log = "Logout.";
    gravalog($_SESSION["sessao_id_user"], 100, 0, $descricao_log, '');
          
    header("Location: login.php");
  }  
  
  if ($acao == "errologin" AND !$autorizado){
    $erromsg = checkip("B");
    $_SESSION['msg_erro_login'] = $erromsg;
    header("Location: login.php");
  }
  elseif($acao == "usuario_inativado"){
    $_SESSION['msg_erro_login'] = "Usuário inativo. Entre em contato com o administrador.";
    header("Location: login.php");
  }
  
  
  
  function checkip($op){
    $count = 0;  
    $data  = date("Y/m/d");
    mysql_query("delete from ip_deny where data<'$data'");  
    
    $ip    = $_SERVER["REMOTE_ADDR"];
    if($op == ""){
      $result = mysql_query("select * from ip_deny where ip='$ip'");
      $count = mysql_num_rows($result);  
      if($count > MAXLOGINERROR){ 
        return "IP bloqueado por 24 horas"; 
      }
    }
    if($op == "B"){
      mysql_query("insert into ip_deny (ip,data) values ('$ip','$data')");
      $result = mysql_query("select * from ip_deny where ip='$ip'");
      $linhas = mysql_num_rows($result);
      for($i = 0; $i < $linhas; $i++){ 
        $count++; 
      }   
      if($count > MAXLOGINERROR){
        return "IP bloqueado por 24 horas"; 
      }
      else{
        return "Usuário ou senha inválido."; 
      }    
    }
    if ($op == "T"){
      for($i = 0; $i <= MAXLOGINERROR; $i++){
        mysql_query("insert into ip_deny (ip,data) values ('$ip','$data')"); 
      }
      return "IP bloqueado por 24 horas";
    }
  }
?>