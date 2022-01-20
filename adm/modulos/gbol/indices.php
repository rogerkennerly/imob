<?php if (basename($PHP_SELF) == basename(__FILE__)) { exit(); } ?>
<?php if ($_SESSION['g_nivel'] != 1) { readfile("header.html"); echo "<body><h4>Você não tem permissão para acessar essa página</h4></body></htm>\n"; exit(); } ?>
<?php
  if (!isset($op))     { $op = ""; }
  if (!isset($codigo)) { $codigo = 0; }
    
  if ($op == "S")
  { settype($nummin,"integer");
    settype($nummax,"integer");
    settype($indice,"integer");
  	$result = mysql_query("select * from indices where codigo=$codigo");
    if (mysql_num_rows($result) > 0)
    { $sql  = "update indices set nummin=$nummin,nummax=$nummax,indice=$indice";
      $sql .= " where codigo=$codigo";
      mysql_query($sql);
      if ( mysql_affected_rows($link) == 1 ) { echo "<h4>Alterado com Sucesso</h4>"; } else { echo "<h4>Nada Alterado</h4>"; }
    } else { echo "<h4>Registro não encontrado</h4>"; }
  }
    
  if ($codigo > 0)
  { $result = mysql_query("select * from indices where codigo=$codigo");
    if (mysql_num_rows($result) > 0)
    { $nummin = mysql_result($result,0,"nummin");
      $nummax = mysql_result($result,0,"nummax");
      $indice = mysql_result($result,0,"indice");
    }
    echo "<form name=frm1 action=base.php method=POST>\n";
    echo "<input type=hidden name=pg value=indices>";
    echo "<table BORDER=0 CELLSPACING=2 CELLPADDING=2>\n";
    echo "<tr bgcolor=$list_cor1 align=center><td colspan=2><b>Alteração</b>\n";
    echo "<input type=hidden name=codigo value=$codigo>";
    echo "<input type=hidden name=op value=S></td></tr>\n";
    
    echo "<tr><td ALIGN=RIGHT><b>Mínimo : </b></td>\n";
    echo "<td><input type=text name=nummin size=7 maxlength=7 value='$nummin'></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><b>Máximo : </b></td>\n";
    echo "<td><input type=text name=nummax size=7 maxlength=7 value='$nummax'></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><b>Atual : </b></td>\n";
    echo "<td><input type=text name=indice size=7 maxlength=7 value='$indice'></td></tr>\n";
    
    echo "<tr><td></td><td><input type=submit name=btn1 value='.:: Alterar ::.'>&nbsp;&nbsp;";
    echo "<input type=reset name=btn2 value='Desfazer'></td></tr>\n";
    echo "</form>\n";
  }
      
  $result = mysql_query("select indices.*,revendas.revenda from indices,revendas where indices.codrevenda=revendas.codigo order by revendas.revenda");
  $linhas = mysql_num_rows($result);
  if ($linhas > 0)
  { $cor = "";
  	echo "<table border=0 cellspacing=2 cellpadding=2>\n";
    echo "<tr bgcolor=$list_cor1 align=center>\n";
    echo "<td><b>Edit     </b></td>\n";
    echo "<td><b>Mínimo   </b></td>\n";
    echo "<td><b>Máximo   </b></td>\n";
    echo "<td><b>Atual    </b></td>\n";
    echo "<td><b>Revenda  </b></td>\n";
    echo "</tr>\n";
    for ($i = 0; $i < $linhas; $i++)
    { if ($cor == $list_cor3) { $cor = $list_cor2; } else { $cor = $list_cor3; }
      echo "<tr bgcolor=$cor align=center>\n";
      echo "<td><a href='base.php?pg=indices&codigo=".mysql_result($result,$i,"codigo")."'>edit</a></td>\n";
      echo "<td>".mysql_result($result,$i,"nummin")."</td>\n";
      echo "<td>".mysql_result($result,$i,"nummax")."</td>\n";
      echo "<td>".mysql_result($result,$i,"indice")."</td>\n";
      echo "<td>".mysql_result($result,$i,"revenda")."</td>\n";
      echo "</tr>\n";    
     }
    echo "</table>\n";
  }
  
?>