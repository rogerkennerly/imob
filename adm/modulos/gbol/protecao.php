<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
  //error_reporting(E_ALL);
  //if($_SERVER['REMOTE_ADDR']=="201.90.88.157") { ini_set('display_errors','On'); } else { ini_set('display_errors','Off'); }
  require('error_handler.php');
?>
<?php
  $controlarip = "S";
  $sessao      = "admfinanceiro";
  $errologin   = "";
  $autorizado  = false;
  $maxloginerror = 5;
  
  if (isset($_GET['sair']))           { $sair       = $_GET['sair'];           } else { $sair       = ""; }
  if (isset($_POST['login']))         { $login      = $_POST['login'];         } else { $login      = ""; }
  if (isset($_REQUEST['pg']))         { $pg         = $_REQUEST['pg'];         } else { $pg         = ""; }
  if (isset($_REQUEST['op']))         { $op         = $_REQUEST['op'];         } else { $op         = ""; }
  if (isset($_REQUEST['op2']))        { $op2        = $_REQUEST['op2'];        } else { $op2        = ""; }
  if (isset($_REQUEST['codigo']))     { $codigo     = $_REQUEST['codigo'];     } else { $codigo     = 0;  }
  if (isset($_REQUEST['codcliente'])) { $codcliente = $_REQUEST['codcliente']; } else { $codcliente = 0;  }
  if (isset($_REQUEST['busca']))      { $busca      = $_REQUEST['busca'];      } else { $busca      = ""; }
  if ($_SERVER['REQUEST_METHOD'] == "GET") { $busca  = urldecode($busca); }
  settype($codigo,"integer");
  settype($codcliente,"integer");
  
  require_once("conexao.php");
  include_once("funcoes.php");
  
  if ($sair == "S")
  { session_name($sessao); session_start();
  	//session_unregister("g_codadmin","g_codrevenda","g_nivel","g_nomeadm");
  	unset($_SESSION["g_codadmin"]);  unset($g_codadmin);
  	unset($_SESSION["g_codrevenda"]);unset($g_codrevenda);
  	unset($_SESSION["g_nivel"]);     unset($g_nivel);
  	unset($_SESSION["g_nomeadm"]);   unset($g_nomeadm);
    session_destroy();
  }
  
  if ($login == "S")
  { $errologin = login(trim($_POST["txtusername"]),trim($_POST["txtsenha"]),$sessao);
    if ($errologin == "") { $autorizado = true; $pg = "principal"; }
    $login = "";
  } else
  { if ($sair != "S")
    { if (checar($sessao)) { $autorizado = true; }
    } else { $errologin = "Você Desconectou !"; include("login.php"); exit(); }
  }
  
  //mysql_query("insert into log_admin (acao,portal,data,hora,ip)values('L',".$_SESSION["g_codigo"].",CURDATE(),CURTIME(),'".$GLOBALS["REMOTE_ADDR"]."')");
  
  if (!$autorizado)
  { if ($pg == "principal")
    { $errologin = "Faça o Login para acessar essa área do site"; }
    else
    { if ($controlarip == "S") { $errologin .= checkip("B",$maxloginerror); }
      session_name($sessao); session_start();
  	  unset($_SESSION["g_codadmin"]);  unset($g_codadmin);
  	  unset($_SESSION["g_codrevenda"]);unset($g_codrevenda);
  	  unset($_SESSION["g_nivel"]);     unset($g_nivel);
  	  unset($_SESSION["g_nomeadm"]);   unset($g_nomeadm);
      session_destroy();
    }
    include("login.php");
    exit();
  }
?>
<?php
  function login ($lusername,$old_pw,$sessao)
  {  $errologin = "Erro na Verificação";
     require("conexao.php");
     if ($lusername != "" and $old_pw != "")
     { if ( strpos($lusername,"'") === false and strpos($old_pw,"'") === false)
       { $lusername = addslashes($lusername);
         $result = mysql_query("select * from admin where username='$lusername'");
         if (mysql_num_rows($result) > 0)
         { if (mysql_result($result,0,"senha") == $old_pw)
           { if (mysql_result($result,0,"nivel") > 0)
             { session_name($sessao); session_start();
               //session_register("g_codadmin","g_codrevenda","g_nivel","g_nomeadm");
               $_SESSION["g_codadmin"]   = mysql_result($result,0,"codigo");
               $_SESSION["g_codrevenda"] = mysql_result($result,0,"codrevenda");
               $_SESSION["g_nivel"]      = mysql_result($result,0,"nivel");
               $_SESSION["g_nomeadm"]    = mysql_result($result,0,"nome");
               $errologin = "";
             } else { $errologin = "Usuário bloqueado.<br>"; }
           } else { $errologin = "Senha incorreta.<br>"; }
         } else { $errologin = "Usuário $lusername não localizado.<br>"; }
       } else { $errologin = "Possível tentativa de invasão<br>"; }
     } else { $errologin = "Usuário ou senha são nulos<br>"; }
     return $errologin;
  }
  
  function checar($sessao)
  { require("conexao.php");
    session_name($sessao); session_start();
    $codigo = 0;
    if (isset($_SESSION["g_codadmin"])) { $codigo = $_SESSION["g_codadmin"]; }
    $result = mysql_query("select * from admin where codigo=".$codigo);
    if (mysql_num_rows($result) > 0) { return true; }
    else
    { session_name($sessao);
  	  unset($_SESSION["g_codadmin"]);   unset($g_codadmin);
  	  unset($_SESSION["g_codrevenda"]); unset($g_codrevenda);
  	  unset($_SESSION["g_nivel"]);      unset($g_nivel);
  	  unset($_SESSION["g_nomeadm"]);    unset($g_nomeadm);
      session_destroy();
      return false;
    }
  }
  
  function checkip($op = "",$maxloginerror)
  { require("conexao.php");
    mysql_query("delete from ip_deny where data < CURDATE()");
    $count = 0;
    $ip = $_SERVER["REMOTE_ADDR"];
    if ($op == "")
    { $result = mysql_query("select * from ip_deny where ip='$ip'");
      $count = mysql_num_rows($result);
      if ( $count > $maxloginerror ) { return "IP bloqueado por 24 horas"; }
    }
    if ($op == "B")
    { mysql_query("insert into ip_deny (ip,data) values ('$ip',CURDATE())");
      $result = mysql_query("select * from ip_deny where ip='$ip'");
      $linhas = mysql_num_rows($result);
      if ($linhas > $maxloginerror) { return "Você não poderá se logar no site, pois seu IP foi bloqueado por 24 horas"; } else
      { if (($maxloginerror - $linhas) == 0)
        { return "Acesso inválido registrado, você não pode errar mais !"; }
        elseif (($maxloginerror - $linhas) == 1)
        { return "Acesso inválido registrado, você só pode errar mais 1 vez !"; } else
        { return "Acesso inválido registrado, você só pode errar mais ".($maxloginerror - $linhas)." vezes !"; }
      }
    }  
  }
?>
