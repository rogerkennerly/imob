<?php if (basename($PHP_SELF) == basename(__FILE__)) { exit(); } ?>
<?php if ($_SESSION['g_nivel'] != 1) { readfile("header.html"); echo "<body><h4>Você não tem permissão para acessar essa página</h4></body></htm>\n"; exit(); } ?>
<?php
  if (!isset($op))     { $op = ""; }
  if (!isset($codigo)) { $codigo = 0; }
  
  if ($op == "O")
  { $result = mysql_query("select * from cidades");
    $linhas = mysql_num_rows($result);  
    for ($i=0;$i < $linhas;$i++)
    { $s = "cod".mysql_result($result,$i,"codigo");
      $ordem = $$s;
      if ( strlen($ordem) == 0){ $ordem = 0; }      
      mysql_query ("update cidades set ordem=$ordem where codigo=".mysql_result($result,$i,"codigo"));      
    }
  }
  
  if ($op == "D")
  { $result = mysql_query("select * from cidades where codigo=$codigo");    
    if (mysql_num_rows($result) > 0)
    { $result = mysql_query("select * from revendas where codcidade=$codigo");
      if (mysql_num_rows($result) > 0)
      { echo "<h4>Não é possível apagar está cidade enquanto houver lojas relacionadas</h4>"; } else
      { mysql_query("delete from cidades where codigo=$codigo");
        if ( mysql_affected_rows($link) == 1 ) { echo "<h4>Cidade Apagada</h4>"; } else { echo "<h4>Nada Apagado</h4>"; }
        $codigo = 0; $cidade = "";
      }  
    } else { echo "<h4>Cidade não localizada</h4>"; }   
    $codigo = 0;
  }
  
  if ($op == "I")
  { mysql_query ("insert into cidades (cidade,ordem)values('$cidade',$ordem)");
    if ( mysql_affected_rows($link) == 1 )
    { echo "<h4>Cidade Incluída</h4>"; } else { echo "<h4>Nada Incluído</h4>"; }
    $cidade = ""; $ordem = 0;
  }
  
  if ($op == "S")
  { $s = "update cidades set ";                  
    $s .= "cidade='$cidade',ordem=$ordem";
    $s .= " where codigo=$codigo";   
    mysql_query ($s);        
    if ( mysql_affected_rows($link) == 1 )
    { echo "<h4>Cidade Alterada</h4>";
      $cidade = ""; $ordem = 0;
    } else { echo "<h4>Nada Alterado</h4>"; }  	
    $codigo = 0;
  }
    
  if ($codigo > 0)
  { $result = mysql_query("select * from cidades where codigo=$codigo");
    if (mysql_num_rows($result) > 0)
    { $cidade = mysql_result($result,0,"cidade");
      $ordem = mysql_result($result,0,"ordem");
    }    
  } else
  { $cidade = ""; 
    $ordem = 0;
  }   
  
  echo "<form name=frm1 action=base.php method=POST>\n";
  echo "<input type=hidden name=pg value=cidades>";
  echo "<table BORDER=0 CELLSPACING=2 CELLPADDING=2>\n";
  if ($codigo > 0) 
  { echo "<tr bgcolor=$list_cor1 align=center><td colspan=2><b>Alteração de Cidade</b>\n";
    echo "<input type=hidden name=codigo value=$codigo>";
    echo "<input type=hidden name=op value=S></td></tr>\n";
  } else
  { echo "<tr bgcolor=$list_cor1 align=center><td colspan=2><b>Inclusão de Cidade</b>\n";
    echo "<input type=hidden name=op value=I></td></tr>\n";
  }  
  echo "<tr><td ALIGN=RIGHT><b>Cidade : </b></td>\n";
  echo "<td><input type=text name=cidade size=30 maxlength=40 value='$cidade'></td></tr>\n";
  
  echo "<tr><td ALIGN=RIGHT><b>Ordem : </b></td>\n";
  echo "<td><input type=text name=ordem size=2 maxlength=2 value='$ordem'></td></tr>\n";
  
  if ($codigo > 0)
  { echo "<tr><td></td><td><input type=submit name=btn1 value='.:: Alterar ::.'>&nbsp;&nbsp;";
    echo "<input type=reset name=btn2 value='Desfazer'></td></tr>\n";
  } else
  { echo "<tr><td></td><td><input type=submit name=btn1 value='.:: Cadastrar ::.'>&nbsp;&nbsp;";
    echo "<input type=reset name=btn2 value='Limpar'></td></tr>\n";
  }  
  echo "</form>\n";
      
  $result = mysql_query("select * from cidades order by ordem,cidade");
  $linhas = @mysql_num_rows($result);
  if ($linhas > 0)
  { $cor = "";
  	echo "<form action='base.php' method=POST>\n";
    echo "<input type=hidden name=pg value=cidades>\n";
    echo "<input type=hidden name=op value='O'>\n";
  	echo "<table border=0 cellspacing=2 cellpadding=2>\n";
    echo "<tr bgcolor=$list_cor1 align=center>\n";
    echo "<td><b>del      </b></td>\n";    
    echo "<td><b>edit     </b></td>\n";
    echo "<td><b>Cidade    </b></td>\n";
    echo "<td><b>Ordem    </b></td>\n";    
    echo "</tr>\n";
    for ($i = 0; $i < $linhas; $i++)
    { if ($cor == $list_cor3) { $cor = $list_cor2; } else { $cor = $list_cor3; }
      echo "<tr bgcolor=$cor align=center>\n";      
      echo "<td><a href=\"javascript:perguntar('base.php?pg=cidades&codigo=".mysql_result($result,$i,"codigo")."&op=D','Excluir Cidade ?')\">del</a></td>\n";
      echo "<td><a href='base.php?pg=cidades&codigo=".mysql_result($result,$i,"codigo")."'>edit</a></td>\n";
      echo "<td>".mysql_result($result,$i,"cidade")."</td>\n";
      echo "<td><input type=text name='cod".mysql_result($result,$i,"codigo")."' value='".mysql_result($result,$i,"ordem")."' size=3 maxlength=3></td>\n";
      echo "</tr>\n";    
     }
    echo "</table>\n";
    echo "<input type=submit name=btn4 value='.:: Ordenar ::. 'class=submit></form>\n";
  }
  
?>