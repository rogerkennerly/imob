<?php readfile("header.html"); ?>
<body>
<?php readfile("topo.html"); ?>
<?php
  if (!isset($errologin)) { $errologin = ''; }
?>
      <table width="980" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF"><tr><td style="padding:8px;">
        <br>
        <table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr><td height="18" valign="top"><b>ÁREA ADMINISTRATIVA</b></td></tr>
          <tr><td>
              <form name="senha" action="base.php" method="POST">
              <input type="hidden" name="login" value="S">
              <table width="400" border="0" cellspacing="0" cellpadding="0">
                <tr><td><b>Todas as tentativas de login s&atilde;o registradas</b></td></tr>
                <tr><td>&nbsp;</td></tr>
                <tr><td align="center"><?php if ($errologin != "") { echo "<h4>$errologin</h4>"; } ?></td></tr>
                <tr><td>&nbsp;</td></tr>               
                <tr><td>
                    <table width="300" border="0" align="center" cellpadding="0" cellspacing="6">
                      <tr><td width="180" align=right><b>Usu&aacute;rio: </b></td>
                          <td width="180" align=left><input size="40" name="txtusername" maxlength="80" type="text"></td>
                      </tr>
                      <tr><td width="180" align=right><b>Senha: </b></td>
                          <td width="180" align=left><input type="password" name="txtsenha" maxlength="20" size="20"></td>
                      </tr> 
                      <tr><td>&nbsp;</td></tr>                   
                      <tr><td colspan=2 align=center><input type="submit" name="Submit" value="Logar"></td></tr>
                    </table>
                </td></tr>
                <tr><td>&nbsp;</td></tr>                
              </table>
              </form>
          </td></tr>
        </table>
      </td></tr></table>
<?php readfile("rodape.html"); ?>