<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
  if (!isset($_REQUEST['op']))     { $op     = "L"; } else { $op      = $_REQUEST['op'];     }
  if (!isset($_REQUEST['op2']))    { $op2    = "";  } else { $op2     = $_REQUEST['op2'];    }
  if (!isset($_REQUEST['codigo'])) { $codigo = 0;   } else { $codigo  = $_REQUEST['codigo']; } settype($codigo,"integer");
  if (!isset($_REQUEST['busca']))  { $busca  = "";  } else { $busca   = $_REQUEST['busca'];  }
  if ($op == "I" or $op == "S")
  { $fone = ""; $email = ""; $tipo = ""; $contatos = ""; $website = ""; $razao = ""; $datalanc = "";
    $endereco = ""; $bairro = ""; $cep = ""; $estado = ""; $status = ""; $pessoa = ""; $doc = ""; $msn = "";
    $numanun = 0; $numofer = 0; $diapagto = 0; $valor = 0; $skype = ""; $cidade = ""; $descricao = "";
  	$pessoa    = addslashes(trim($_POST['pessoa']));
    $doc       = addslashes(trim($_POST['doc']));
    $endereco  = addslashes(trim($_POST['endereco']));
    $bairro    = addslashes(trim($_POST['bairro']));
    $cidade    = addslashes(trim($_POST['cidade']));
    $cep       = addslashes(trim($_POST['cep']));
    $estado    = addslashes(trim($_POST['estado']));
    //$datalanc  = addslashes(trim($_POST['datalanc']));
    $diappagto = addslashes(trim($_POST['diappagto']));
    $valor     = addslashes(trim($_POST['valor']));
    $razao     = addslashes(trim($_POST['razao']));
    $descricao = addslashes(trim($_POST['descricao']));
    if ($pessoa == "F") { $doc = formatcpf("B",$doc); } else { $doc = formatcnpj("B",$doc); }
  }
  
  
  echo '<div class="page-content">';
  echo '<div class="page-header">';
    echo '<h1>';
      echo 'Listar proprietario';
    echo '</h1>';
  echo '</div>';
  
  echo "<table cellpadding=0 cellspacing=0 border=0>\n";
  echo "<tr><td class=box1tl></td><td class=box1t></td><td class=box1tr></td></tr>\n";
  echo "<tr>\n";
  echo "<td class=box1l></td>\n";
  echo "<td class=box1c>\n";
    echo "<table><tr>";
    echo "<td><form name=frm_proprietario action=?modulo=gbol method=POST>\n";
    echo "<input type=hidden name=pg value=proprietario>\n";
    echo "<input type=hidden name=op value=L>\n";
    echo "<input type=hidden name=modulo value=>\n";
    echo "Buscar <input type=text name=busca size=20 value=\"$busca\">&nbsp;<INPUT TYPE=submit name=btn1 value='Listar proprietario'></form>\n";
    echo "</td></tr></table>\n";
  echo "</td>\n";
  echo "<td class=box1r></td>\n";
  echo "</tr>\n";
  echo "<tr><td class=box1bl></td><td class=box1b></td><td class=box1br></td></tr>\n";
  echo "</table>\n";
  if ($codigo > 0 and $op != "D")
  { echo "<a href=base.php?pg=boletos&codcliente=$codigo&op=N&op2=N>Incluir Boletos</a>\n";
    echo " &nbsp; | &nbsp; <a href=base.php?pg=boletos&buscacodcli=$codigo&op=L>Listar Boletos</a>\n";
    echo "<br>\n";
  }
  echo "<br>\n";
  
  if ($op == "D")
  { $podeapagar = false;
    $result = mysql_query("select * from proprietario where codigo=$codigo");
    $linhas = mysql_num_rows($result);
    if ($linhas > 0)
    { $result = mysql_query("select * from boletos where codcliente=$codigo");
      $linhas = mysql_num_rows($result);
      if ($linhas > 0)
      { if ($apagar == "S") { $podeapagar = true; } else
        { echo "<h4>Deseja mesmo apagar este cliente e todos os seus boletos ?<br>";
          echo "<a href='base.php?pg=proprietario&codigo=$codigo&apagar=S&busca=$busca&op=D'>Sim</a>";
          echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
          echo "<a href='base.php?pg=proprietario&busca=$busca&op=L'>Não</a></h4>";
        }
      } else { $podeapagar = true; }
      if ($podeapagar)
      { mysql_query("delete from boletos where codcliente=$codigo and codrevenda=".$_SESSION['g_codrevenda']); echo "<h4>".mysql_affected_rows($link)." Boletos(s) Apagado(s)</h4>";
        mysql_query("delete from proprietario where codigo=$codigo and codrevenda=".$_SESSION['g_codrevenda']); if (mysql_affected_rows($link) > 0) { echo "<h4>Cliente Apagado</h4>"; }
        $op = "L";
      }
    } else { echo "<h4>Cliente não Localizada</h4>"; }
    $codigo = 0;
    $op = "L";
  }
  
  if ($op == "I")
  { $result = mysql_query("select codigo from proprietario where doc='".$doc."' and codrevenda=".$_SESSION["g_codrevenda"]);
    if (mysql_num_rows($result) > 0)
    { echo "<h4>O documento $doc já está cadastrado</h4>"; } else
    { $sql  = "insert into proprietario (fone,email,contatos,website,endereco,bairro,cidade,cep,estado,pessoa,doc,diappagto,valor,razao,msn,skype,descricao,codrevenda)values(";
      $sql .= "'".$fone."'";
      $sql .= ",'".$email."'";
      $sql .= ",'".$contatos."'";
      $sql .= ",'".$website."'";
      $sql .= ",'".$endereco."'";
      $sql .= ",'".$bairro."'";
      $sql .= ",'".$cidade."'";
      $sql .= ",'".$cep."'";
      $sql .= ",'".$estado."'";
      $sql .= ",'".$pessoa."'";
      $sql .= ",'".$doc."'";
      $sql .= ",".$diappagto;
      $sql .= ",".convertvalor($valor,2);
      $sql .= ",'".$razao."'";
      $sql .= ",'".$msn."'";
      $sql .= ",'".$skype."'";
      $sql .= ",'".$descricao."'";
      $sql .= ",".$_SESSION["g_codrevenda"];
      $sql .= ")";
      mysql_query($sql);
      if ( mysql_affected_rows($link) == 1 )
      { echo "<h4>Cliente Incluído</h4>";
        $codigo = mysql_insert_id($link);
        echo "<a href=base.php?pg=boletos&codcliente=$codigo&op=N&op2=N>Incluir Boletos</a>\n";
        echo " &nbsp; | &nbsp; <a href=base.php?pg=proprietario&codigo=$codigo>Alterar Cliente</a>\n";
        echo "<br><br>\n";
        $codigo = 0; $fone = ""; $email = ""; $tipo = ""; $contatos = ""; $website = ""; $razao = "";
        $endereco = ""; $bairro = ""; $cep = ""; $estado = ""; $status = ""; $pessoa = ""; $doc = ""; $msn = "";
        $numanun = 0; $numofer = 0; $diapagto = 0; $valor = 0; $skype = ""; $cidade = ""; $descricao = "";
      } else { echo "<h4>Nada Incluído</h4>$sql"; }
    }
    $op = "N";
  }
  
  if ($op == "S" and $codigo > 0)
  { $result = mysql_query("select codigo from proprietario where doc='".$doc."' and codigo<>$codigo and codrevenda=".$_SESSION["g_codrevenda"]);
    if (mysql_num_rows($result) > 0)
    { echo "<h4>Novo documento escolhido já existe<br>Nada Alterado.</h4>"; } else
    { $sql = "update proprietario set ";
      $sql .= "fone='$fone'";
      $sql .= ",email='$email'";
      $sql .= ",contatos='".$contatos."'";
      $sql .= ",website='$website'";
      $sql .= ",endereco='".$endereco."'";
      $sql .= ",bairro='".$bairro."'";
      $sql .= ",cidade='".$cidade."'";
      $sql .= ",cep='$cep'";
      $sql .= ",estado='$estado'";
      $sql .= ",pessoa='$pessoa'";
      $sql .= ",doc='$doc'";
      if (strlen($datalanc) == 10){ $sql .= ",datalanc='".ajustardata("B",$datalanc)."'"; } else { $sql .= ",datalanc=NULL"; }
      $sql .= ",diappagto=$diappagto";
      $sql .= ",valor=".convertvalor($valor,2);
      $sql .= ",razao='".$razao."'";
      $sql .= ",msn='".$msn."'";
      $sql .= ",skype='".$skype."'";
      $sql .= ",descricao='".$descricao."'";
      $sql .= " where codigo=$codigo and codrevenda=".$_SESSION["g_codrevenda"];
      mysql_query($sql);
      if (mysql_affected_rows($link) == 1) { echo "<h4>Dados Alterados</h4>"; } else { echo "<h4>Nada Alterado</h4>"; }
    }  
  }
    
  if ($codigo > 0)
  { $result = mysql_query("select * from proprietario where codigo=$codigo and codrevenda=".$_SESSION["g_codrevenda"]);
  	if (mysql_num_rows($result) > 0)
    { $razao     = mysql_result($result,0,"razao");
      $fone      = mysql_result($result,0,"fone");
      $email     = mysql_result($result,0,"email");
      $contatos  = mysql_result($result,0,"contatos");
      $website   = mysql_result($result,0,"website");
      $endereco  = mysql_result($result,0,"endereco");
      $bairro    = mysql_result($result,0,"bairro");
      $cep       = mysql_result($result,0,"cep");
      $estado    = mysql_result($result,0,"estado");
      $pessoa    = mysql_result($result,0,"pessoa");
      $doc       = mysql_result($result,0,"doc");
      if ($pessoa == "F") { $doc = formatcpf("M",$doc); } else { $doc = formatcnpj("M",$doc); }
      $diappagto = mysql_result($result,0,"diappagto");
      $datalanc  = mysql_result($result,0,"datalanc");
      if ($datalanc > 0) { $datalanc = ajustardata("M",$datalanc); }
      $valor     = "R$ ".number_format(mysql_result($result,0,"valor"),2,',','.');
      $msn       = mysql_result($result,0,"msn");
      $skype     = mysql_result($result,0,"skype");
      $cidade    = mysql_result($result,0,"cidade");
      $descricao = mysql_result($result,0,"descricao");
    } else { echo "<h4>Loja não localizada</h4>"; }
  }    
  
  if ($op == "N" or $codigo > 0)
  { echo "<form name=frm1 action=base.php method=POST enctype=multipart/form-data>\n";
    echo "<input type=hidden name=pg value=proprietario>";
    if ($codigo > 0)
    { echo "<input type=hidden name=codigo value=$codigo>";
      echo "<input type=hidden name=op value=S>\n";  
    } else
    { echo "<input type=hidden name=op value=I>\n";
      if ($op2 == "new")
      { $codigo = 0; $fone = ""; $email = ""; $tipo = ""; $contatos = ""; $website = ""; $razao = "";
        $endereco = ""; $bairro = ""; $cep = ""; $estado = ""; $status = ""; $senha = ""; $pessoa = ""; $descricao = "";
        $doc = ""; $numanun = 0; $numofer = 0; $diapagto = 0; $valor = 0; $msn = ""; $skype = ""; $cidade = "";
      }
    }
    
    echo "<table border=0 cellspacing=2 cellpadding=2>\n";
    echo "<tr><td ALIGN=RIGHT><b>Nome/Razão Social : </b></td>";
    echo "<td><input type=text name=razao size=40 maxlength=80 value='$razao'></td></tr>\n";
    
    echo "<tr><td ALIGN=RIGHT><b>Pessoa : </b></td>";
    echo "<td><select name=pessoa size=1>\n";
    if ($pessoa == "J") { echo "<option value=J selected>Jurídica</option>\n"; } else { echo "<option value=J>Jurídica</option>\n"; }
    if ($pessoa == "F") { echo "<option value=F selected>Física</option>\n";   } else { echo "<option value=F>Física</option>\n";   }
    echo "</select></td></tr>\n";
    
    echo "<tr><td ALIGN=RIGHT><font color=red><b>CPF/CNPJ : </b></font></td>";
    echo "<td><input type=text name=doc size=20 maxlength=20 value='$doc'></td></tr>\n";        
    
    echo "<tr><td ALIGN=RIGHT><b>Endereço : </b></td>";
    echo "<td><input type=text name=endereco size=40 maxlength=60 value='$endereco'></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><b>Bairro : </b></td>";
    echo "<td><input type=text name=bairro size=30 maxlength=40 value='$bairro'></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><b>Cep : </b></td>";
    echo "<td><input type=text name=cep size=10 maxlength=10 value='$cep'></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><b>Cidade : </b></td>";
    echo "<td><input type=text name=cidade size=30 maxlength=40 value='$cidade'></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><b>Estado : </b></td>";
    echo "<td><input type=text name=estado size=2 maxlength=2 value='$estado'></td></tr>\n";
    
    /*echo "<tr><td ALIGN=RIGHT><b>Fone : </b></td>";
    echo "<td><input type=text name=fone size=40 maxlength=50 value='$fone'></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><b>E-mail : </font></td>";
    echo "<td><input type=text name=email size=40 maxlength=80 value='$email'></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><b>Msn : </b></td>";
    echo "<td><input type=text name=msn size=40 maxlength=80 value='$msn'></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><b>Skype : </b></td>";
    echo "<td><input type=text name=skype size=30 maxlength=40 value='$skype'></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><b>Website : </b></td>";
    echo "<td><input type=text name=website size=40 maxlength=80 value='$website'></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><b>Contatos : </b></td>";
    echo "<td><input type=text name=contatos size=50 maxlength=255 value='$contatos'></td></tr>\n";*/
       
    echo "<tr><td ALIGN=RIGHT><b>Dia p/ Pagamento : </b></td>";
    echo "<td><select name=diappagto size=1>\n";
    for ($i=1;$i < 32;$i++)
    { if ($diappagto == $i) { echo "<option value=".str_pad($i,2,"0",STR_PAD_LEFT)." selected>".str_pad($i,2,"0",STR_PAD_LEFT)."</option>"; } else { echo "<option value=".str_pad($i,2,"0",STR_PAD_LEFT)." >".str_pad($i,2,"0",STR_PAD_LEFT)."</option>"; }
    }
    /*if ($diappagto == 05) { echo "<option value=05 selected>05</option>\n"; } else { echo "<option value=05>05</option>\n"; }
    if ($diappagto == 10) { echo "<option value=10 selected>10</option>\n"; } else { echo "<option value=10>10</option>\n"; }
    if ($diappagto == 15) { echo "<option value=15 selected>15</option>\n"; } else { echo "<option value=15>15</option>\n"; }
    if ($diappagto == 20) { echo "<option value=20 selected>20</option>\n"; } else { echo "<option value=20>20</option>\n"; }
    if ($diappagto == 25) { echo "<option value=25 selected>25</option>\n"; } else { echo "<option value=25>25</option>\n"; }
    if ($diappagto == 30) { echo "<option value=30 selected>30</option>\n"; } else { echo "<option value=30>30</option>\n"; }*/
    echo "</select></td></tr>\n";
    
    if ($codigo > 0)
    { echo "<tr><td ALIGN=RIGHT><b>Data de Lançamento : </b></td>";
      echo "<td><input type=text name=datalanc size=10 maxlength=10 value='$datalanc'></td></tr>\n";
    }
          
    echo "<tr><td ALIGN=RIGHT><b>Valor : </b></td>";
    echo "<td><input type=text name=valor size=15 maxlength=15 value='$valor'></td></tr>\n";
    
    echo "<tr><td ALIGN=RIGHT><b>Descrição : </b></td>";
    echo "<td><textarea name=descricao rows=6 cols=30 wrap=PHYSICAL>$descricao</textarea></td></tr>\n";
        
    if ($codigo > 0)
    { echo "<tr><td></td><td><input type=submit name=btn1 value='.:: Alterar ::.'>&nbsp;&nbsp;";
      echo "<input type=reset name=btn2 value='Desfazer'></td></tr>\n";
    } else
    { echo "<tr><td></td><td><input type=submit name=btn1 value='.:: Cadastrar ::.'>&nbsp;&nbsp;";
      echo "<input type=reset name=btn2 value='Limpar'></td></tr>\n";
    }  
    echo "</table></form>\n";
  }
  
  if ($op == "L")
  { if ($busca != "")
    { if (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET') { $busca = urldecode($busca); }
      $result = mysql_query("select * from proprietario where codrevenda=".$_SESSION['g_codrevenda']." and razao like '%$busca%' order by razao");
    } else 
    { $result = mysql_query("select * from proprietario where codrevenda=".$_SESSION['g_codrevenda']." order by razao");
    }
    if (!$result) { $linhas = 0; } else { $linhas = mysql_num_rows($result); }
    if ($linhas > 0)
    { $cor = "";
    	echo "<table border=0 cellspacing=2 cellpadding=2>\n";
      echo "<tr bgcolor=$list_cor1 align=center>\n";
      echo "<td><b>excluir  </b></td>\n";    
      echo "<td><b>alterar  </b></td>\n";
      echo "<td><b>boletos  </b></td>\n";
      echo "<td><b>boletos  </b></td>\n";
      echo "<td><b>cliente  </b></td>\n";    
      echo "<td><b>dia      </b></td>\n";
      echo "<td><b>valor    </b></td>\n";
      echo "</tr>\n";
      for ($i = 0; $i < $linhas; $i++)
      { if ($cor == $list_cor3) { $cor = $list_cor2; } else { $cor = $list_cor3; }        
        echo "<tr bgcolor=$cor align=center>\n";      
        echo "<td><a href=\"javascript:perguntar('base.php?pg=proprietario&codigo=".mysql_result($result,$i,"codigo")."&op=D&busca=".urlencode($busca)."','Excluir este Cliente e TODOS os seus Boletos ?')\">excluir</a></td>\n";
        echo "<td><a href='base.php?pg=proprietario&codigo=".mysql_result($result,$i,"codigo")."'>alterar</a></td>\n";
        echo "<td><a href='base.php?pg=boletos&buscacodcli=".mysql_result($result,$i,"codigo")."&op=L'>Listar</a></td>\n";
        echo "<td><a href='base.php?pg=boletos&codcliente=".mysql_result($result,$i,"codigo")."&op=N&op2=N'>Incluir</a></td>\n";
        echo "<td>".mysql_result($result,$i,"razao")."</td>\n";
        echo "<td>".mysql_result($result,$i,"diappagto")."</td>\n";
        echo "<td>"."R$ ".number_format(mysql_result($result,$i,"valor"),2,',','.')."</td>\n";
        echo "</tr>\n";
      }
      echo "<tr bgcolor=$list_cor1><td align=left colspan=12><b>$linhas proprietario</b></td></tr>\n";
      echo "</table>\n";
    } else { echo "<h4>Nenhum registro localizado</h4>\n"; }
  } // fim do $op == "L"
  
?>