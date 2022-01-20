<?php if (basename($PHP_SELF) == basename(__FILE__)) { exit(); } ?>
<?php if ($_SESSION['g_nivel'] != 1) { readfile("header.html"); echo "<body><h4>Você não tem permissão para acessar essa página</h4></body></htm>\n"; exit(); } ?>
    <script language="JavaScript">
    function checkcampos() {
    var erro_string = "";
    var usuario = window.document.frm1.usuario.value;
    if ( usuario.length < 3 ){ erro_string += "Campo usuário não parece ser válido \n"; }
    if (window.document.frm1.senha.value == ""){ erro_string += "Campo senha não pode ser nulo \n"; }
    if (window.document.frm1.senha.value != window.document.frm1.senha2.value){ erro_string += "Senha digitadas são diferentes \n"; }
    if (erro_string == "") { return true; } else { alert(erro_string); return false; }
    }
    </script>
<?php
    if (!isset($op)) { $op = ""; }
    
    if ($op == "S")
    { $usuario = addslashes(trim($usuario));
      $senha = addslashes(trim($senha));
      $result = mysql_query("select * from admin where username='$usuario' and codigo<>".$_SESSION['g_codadmin']);
      if (mysql_num_rows($result) > 0) { echo "<h4>O novo usuário escolhido já existe</h4>"; } else
      { mysql_query("update admin set username='$usuario', senha='$senha' where codigo=".$_SESSION['g_codadmin']);
        if (mysql_affected_rows($link) > 0)
        { echo "<h4>Dados Alterados</h4>\n"; $usuario = ""; $senha = "";
        } else { echo "<h4>Nada Alterado</h4>\n"; }
      }
    }
  
    $result = mysql_query("select * from admin where codigo=".$_SESSION['g_codadmin']);
    if (mysql_num_rows($result) > 0)
    { $usuario = mysql_result($result,0,"username");
      $senha = mysql_result($result,0,"senha");
    }   
        
    echo "<form name=frm1 action=base.php method=POST onSubmit='return checkcampos()'>\n";
    echo "<input type=hidden name=pg value=altdados>\n";
    echo "<input type=hidden name=op value='S'>\n";
    echo "<table>\n";
    echo "<tr><td align=right><B>Usuário : </B></td><td><input type=text name=usuario size=10 maxlength=20 value='$usuario'></td></tr>\n";
    echo "<tr><td align=right><B>Senha : </B></td><td><input type=password name=senha size=10 maxlength=20 value='$senha'></td></tr>\n";
    echo "<tr><td align=right><B>Redigitar a Senha : </B></td><td><input type=password name=senha2 size=10 maxlength=20 value='$senha'></td></tr>\n";
    echo "<tr><td colspan=2 align=center><input type=submit name=btn3 value='Alterar'></td></tr>";
    echo "</table>\n";
    echo "</form>\n";
?> 
