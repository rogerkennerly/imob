<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php if ($_SESSION['g_nivel'] != 1) { readfile("header.html"); echo "<body><h4>Você não tem permissão para acessar essa página</h4></body></htm>\n"; exit(); } ?>
<?php
  if (!isset($_REQUEST['op']))     { $op     = "L"; } else { $op      = $_REQUEST['op'];     }
  if (!isset($_REQUEST['op2']))    { $op2    = "";  } else { $op2     = $_REQUEST['op2'];    }
  if (!isset($_REQUEST['codigo'])) { $codigo = 0;   } else { $codigo  = $_REQUEST['codigo']; } settype($codigo,"integer");
  if (!isset($_REQUEST['busca']))  { $busca  = "";  } else { $busca   = $_REQUEST['busca'];  }
  if (!isset($_GET['apagar']))     { $apagar = "";  } else { $apagar  = $_GET['apagar'];     }
  
  if ($op == "I" or $op == "S")
  { if (!isset($_POST['pessoa']))         { $pessoa          = "F"; } else { $pessoa          = $_POST['pessoa'];          }
    if (!isset($_POST['doc']))            { $doc             = "";  } else { $doc             = $_POST['doc'];             }
    if (!isset($_POST['email']))          { $email           = "";  } else { $email           = $_POST['email'];           }
    if (!isset($_POST['revenda']))        { $revenda         = "";  } else { $revenda         = $_POST['revenda'];         }
    if (!isset($_POST['razao']))          { $razao           = "";  } else { $razao           = $_POST['razao'];           }
    if (!isset($_POST['endereco']))       { $endereco        = "";  } else { $endereco        = $_POST['endereco'];        }
    if (!isset($_POST['bairro']))         { $bairro          = "";  } else { $bairro          = $_POST['bairro'];          }
    if (!isset($_POST['cep']))            { $cep             = "";  } else { $cep             = $_POST['cep'];             }
    if (!isset($_POST['fone']))           { $fone            = "";  } else { $fone            = $_POST['fone'];            }
    if (!isset($_POST['estado']))         { $estado          = "";  } else { $estado          = $_POST['estado'];          }
    if (!isset($_POST['senha']))          { $senha           = "";  } else { $senha           = $_POST['senha'];           }
    if (!isset($_POST['contatos']))       { $contatos        = "";  } else { $contatos        = $_POST['contatos'];        }
    if (!isset($_POST['codcidade']))      { $codcidade       = "";  } else { $codcidade       = $_POST['codcidade'];       }
  }
  echo "<a href=base.php?pg=revendas&op=N&op2=new>Incluir Revenda</a>\n";
  
  if ($op == "D")
  { $podeapagar = false;
    $result = mysql_query("select * from revendas where codigo=$codigo");        
    $linhas = mysql_num_rows($result);
    if ($linhas > 0)
    { $result = mysql_query("select * from clientes where codrevenda=$codigo");
      $linhas = mysql_num_rows($result);
      if ($linhas > 0)
      { if ($apagar == "S") { $podeapagar = true; } else
        { echo "<h4>Deseja mesmo apagar esta revenda e todo seu conteúdo relacionado ?<br>";
          echo "<a href='base.php?pg=revendas&codigo=$codigo&apagar=S&busca=$busca&op=D'>Sim</a>";
          echo "&nbsp;&nbsp;|&nbsp;&nbsp;";
          echo "<a href='base.php?pg=revendas&busca=$busca&op=L'>Não</a></h4>";
        }
      } else { $podeapagar = true; }
      if ($podeapagar)
      { mysql_query("delete from clientes where codrevenda=$codigo"); echo "<h4>".mysql_affected_rows($link)." Clientes(s) Apagado(s)</h4>";
        mysql_query("delete from boletos where codrevenda=$codigo"); echo "<h4>".mysql_affected_rows($link)." Boletos(s) Apagado(s)</h4>";
        mysql_query("delete from revendas where codigo=$codigo"); if (mysql_affected_rows($link) > 0) { echo "<h4>Revenda apagada</h4>"; }
        mysql_query("delete from admin where codrevenda=$codigo");
        mysql_query("delete from indices where codrevenda=$codigo");
        $op = "L";
      }
    } else { echo "<h4>Revenda não Localizada</h4>"; }
    $codigo = 0;
    $op = "L";
  }
  
  if ($op == "I")
  { if ($pessoa == "F") { $doc = formatcpf("B",$doc); } else { $doc = formatcnpj("B",$doc); }
    if (strlen(trim($email)) > 7)
    { if (strlen(trim($senha)) > 3)
      { $result = mysql_query("select codigo from admin where username='".addslashes(trim($email))."'");
        if (mysql_num_rows($result) > 0)
        { echo "<h4>O username escolhido já existe</h4>"; } else
        { $sql  = "insert into revendas (revenda,codcidade,fone,email,endereco,bairro,cep,estado,pessoa,doc,razao,contatos)values(";
          $sql .= "'".addslashes(trim($revenda))."'";
          $sql .= ",".$codcidade;
          $sql .= ",'".addslashes(trim($fone))."'";
          $sql .= ",'".addslashes(trim($email))."'";
          $sql .= ",'".addslashes(trim($endereco))."'";
          $sql .= ",'".addslashes(trim($bairro))."'";
          $sql .= ",'".addslashes(trim($cep))."'";
          $sql .= ",'".$estado."'";
          $sql .= ",'".$pessoa."'";
          $sql .= ",'".$doc."'";
          $sql .= ",'".addslashes(trim($razao))."'";
          $sql .= ",'".addslashes(trim($contatos))."'";
          $sql .= ")";
          mysql_query ($sql);
          if ( mysql_affected_rows($link) == 1 )
          { echo "<h4>Revenda Incluída. Não esqueça de configurar o boleto</h4>";
            $codigo = mysql_insert_id($link);
            mysql_query("insert into admin (username,senha,nivel,nome,codrevenda)values('".addslashes(trim($email))."','".addslashes(trim($senha))."',2,'".addslashes(trim($revenda))."',$codigo)");
            echo " &nbsp; | &nbsp; <a href=base.php?pg=revendas&codigo=$codigo>Alterar Revenda</a>\n";
            echo "<br><br>\n";
            include("fn_imagens_revendas.php");
            $codigo = 0; $revenda = ""; $fone = ""; $email = ""; $razao = "";
            $endereco = ""; $bairro = ""; $cep = ""; $estado = ""; $pessoa = ""; $doc = "";
            $senha = ""; $contatos = "";
          } else { echo "<h4>Nada Incluído</h4>$sql"; }
        }
      } else { echo "<h4>Senha deve ter no mínimo 4 caracteres</h4>"; }
    } else { echo "<h4>E-mail não parece ser válido</h4>"; }
    $op = "N";
  }
  
  if ($op == "S" and $codigo > 0)
  { $alterados = false;
    $result    = mysql_query("select codigo from admin where username='".addslashes(trim($email))."' and codrevenda<>$codigo");
    if (mysql_num_rows($result) > 0)
    { echo "<h4>Novo E-mail escolhido já existe<br>Nada Alterado.</h4>"; } else
    { if ($pessoa == "F") { $doc = formatcpf("B",$doc); } else { $doc = formatcnpj("B",$doc); }
      $sql = "update revendas set ";
      $sql .= "revenda='".addslashes(trim($revenda))."'";
      $sql .= ",razao='".addslashes(trim($razao))."'";
      $sql .= ",codcidade=$codcidade";
      $sql .= ",fone='$fone'";
      $sql .= ",email='$email'";
      $sql .= ",endereco='".addslashes(trim($endereco))."'";
      $sql .= ",bairro='".addslashes(trim($bairro))."'";
      $sql .= ",cep='$cep'";
      $sql .= ",estado='$estado'";
      $sql .= ",pessoa='$pessoa'";
      $sql .= ",doc='$doc'";
      $sql .= ",contatos='".addslashes(trim($contatos))."'";
      $sql .= " where codigo=$codigo";   
      mysql_query($sql);
      if ( mysql_affected_rows($link) == 1 ) { $alterados = true; }
      mysql_query("update admin set username='".addslashes(trim($email))."',senha='".addslashes(trim($senha))."',nome='".addslashes(trim($revenda))."' where codrevenda=$codigo");
      if ( mysql_affected_rows($link) == 1 ) { $alterados = true; }
      include("fn_imagens_revendas.php");
      if ($alterados) { echo "<h4>Dados Alterados</h4>"; } else { echo "<h4>Nada Alterado</h4>"; }
    }  
  }
    
  if ($codigo > 0)
  { $result = mysql_query("select * from revendas where codigo=$codigo");
  	if (mysql_num_rows($result) > 0)
    { $revenda   = mysql_result($result,0,"revenda");
      $razao     = mysql_result($result,0,"razao");
      $codcidade = mysql_result($result,0,"codcidade");
      $fone      = mysql_result($result,0,"fone");
      $email     = mysql_result($result,0,"email");
      $endereco  = mysql_result($result,0,"endereco");
      $bairro    = mysql_result($result,0,"bairro");
      $cep       = mysql_result($result,0,"cep");
      $estado    = mysql_result($result,0,"estado");
      $pessoa    = mysql_result($result,0,"pessoa");
      $doc       = mysql_result($result,0,"doc");
      $contatos  = mysql_result($result,0,"contatos");
      if ($pessoa == "F") { $doc = formatcpf("M",$doc); } else { $doc = formatcnpj("M",$doc); }
      $result    = mysql_query("select * from admin where codrevenda=$codigo");
      $senha     = mysql_result($result,0,"senha");
    } else { echo "<h4>Revenda não localizada</h4>"; }
  }    
  
  if ($op == "N" or $codigo > 0)
  { echo "<form name=frm1 action=base.php method=POST enctype=multipart/form-data>\n";
    echo "<input type=hidden name=pg value=revendas>";
    if ($codigo > 0)
    { echo "<input type=hidden name=codigo value=$codigo>";
      echo "<input type=hidden name=op value=S>\n";  
    } else
    { echo "<input type=hidden name=op value=I>\n";
      if ($op2 == "new")
      { $codigo = 0; $revenda = ""; $fone = ""; $email = ""; $razao = "";
        $endereco = ""; $bairro = ""; $cep = ""; $estado = ""; $senha = ""; $pessoa = "";
        $doc = ""; $senha = ""; $contatos = "";
      }
    }
    
    echo "<table border=0 cellspacing=2 cellpadding=2>\n";
    echo "<tr><td ALIGN=RIGHT><font color=red><b>Revenda : </b></font></td>";
    echo "<td><input type=text name=revenda size=40 maxlength=60 value=\"$revenda\"></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><b>Razão Social : </b></td>";
    echo "<td><input type=text name=razao size=40 maxlength=80 value=\"$razao\"></td></tr>\n";
    
    echo "<tr><td ALIGN=RIGHT><b>Pessoa : </b></td>";
    echo "<td><select name=pessoa size=1>\n";
    if ($pessoa == "J") { echo "<option value=J selected>Jurídica</option>\n"; } else { echo "<option value=J>Jurídica</option>\n"; }
    if ($pessoa == "F") { echo "<option value=F selected>Física</option>\n";   } else { echo "<option value=F>Física</option>\n";   }
    echo "</select></td></tr>\n";
    
    echo "<tr><td ALIGN=RIGHT><font color=red><b>CPF/CNPJ : </b></font></td>";
    echo "<td><input type=text name=doc size=20 maxlength=20 value='$doc'></td></tr>\n";        
    
    echo "<tr><td ALIGN=RIGHT><b>Endereço : </b></td>";
    echo "<td><input type=text name=endereco size=40 maxlength=60 value=\"$endereco\"></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><b>Bairro : </b></td>";
    echo "<td><input type=text name=bairro size=30 maxlength=40 value=\"$bairro\"></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><b>Cep : </b></td>";
    echo "<td><input type=text name=cep size=10 maxlength=10 value='$cep'></td></tr>\n";
        
    echo "<tr><td ALIGN=RIGHT><b>Cidade : </b></td>";
    echo "<td><select name=codcidade size=1>\n";
    $result = mysql_query("select * from cidades order by ordem,cidade");
    $linhas = mysql_num_rows($result);
    for ($i = 0; $i < $linhas; $i++)
    { if (mysql_result($result,$i,"codigo")==$codcidade)
      { echo "<option value=".mysql_result($result,$i,"codigo")." selected>".mysql_result($result,$i,"cidade")."</option>\n"; } else
      { echo "<option value=".mysql_result($result,$i,"codigo").">".mysql_result($result,$i,"cidade")."</option>\n"; }
    }
    echo "</select></td></tr>\n";
           
    echo "<tr><td ALIGN=RIGHT><b>Estado : </b></td>";
    echo "<td><input type=text name=estado size=2 maxlength=2 value='$estado'></td></tr>\n";
    
    echo "<tr><td ALIGN=RIGHT><b>Fone : </b></td>";
    echo "<td><input type=text name=fone size=40 maxlength=50 value='$fone'></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><font color=red><b>E-mail : </b></font></td>";
    echo "<td><input type=text name=email size=40 maxlength=80 value='$email'></td></tr>\n";
    echo "<tr><td ALIGN=RIGHT><font color=red><b>Senha : </b></font></td>";
    echo "<td><input type=text name=senha size=20 maxlength=20 value='$senha'></td></tr>\n";
    
    echo "<tr><td ALIGN=RIGHT><b>Contatos : </b></td>";
    echo "<td><input type=text name=contatos size=50 maxlength=255 value=\"$contatos\"></td></tr>\n";
    
    echo "<tr><td ALIGN=RIGHT width=120><b>Logo : </b></td>";
    echo "<td valign=middle>";
    if (file_exists("logos/$codigo.jpg"))
    { echo "<a href=# onclick=\"window.open('logos/$codigo.jpg','','scrollbars=yes,width=250,height=150')\">Ver Logo</a><br>"; }
    echo "<input type=file name=userfile size=40 maxlength=40> 200L x 100H em jpg</td></tr>\n";
            
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
    { $busca = urldecode($busca); 
      $result = mysql_query("select * from revendas where revenda like '$busca%' order by revenda");
    } else 
    { $result = mysql_query("select revendas.*,admin.senha from revendas,admin where revendas.codigo=admin.codrevenda order by revendas.revenda");
    }
    $linhas = mysql_num_rows($result);
    if ($linhas > 0)
    { $cor = "";
    	echo "<table border=0 cellspacing=2 cellpadding=2>\n";
      echo "<tr bgcolor=$list_cor1 align=center>\n";
      echo "<td><b>del      </b></td>\n";    
      echo "<td><b>edit     </b></td>\n";
      echo "<td><b>revenda  </b></td>\n";    
      echo "<td><b>fone     </b></td>\n";
      echo "<td><b>email    </b></td>\n";
      echo "<td><b>senha    </b></td>\n";
      echo "</tr>\n";
      for ($i = 0; $i < $linhas; $i++)
      { if ($cor == $list_cor3) { $cor = $list_cor2; } else { $cor = $list_cor3; }        
        echo "<tr bgcolor=$cor align=center>\n";      
        echo "<td><a href=\"javascript:perguntar('base.php?pg=revendas&codigo=".mysql_result($result,$i,"codigo")."&op=D&busca=".urlencode($busca)."','Excluir Revenda ?')\">del</a></td>\n";
        echo "<td><a href='base.php?pg=revendas&codigo=".mysql_result($result,$i,"codigo")."'>edit</a></td>\n";
        echo "<td>".mysql_result($result,$i,"revenda")."</td>\n";
        echo "<td>".mysql_result($result,$i,"fone")."</td>\n";
        echo "<td>".mysql_result($result,$i,"email")."</td>\n";
        echo "<td>".mysql_result($result,$i,"senha")."</td>\n";
        echo "</tr>\n";
      }
      echo "<tr bgcolor=$list_cor1><td align=left colspan=12><b>$linhas Revendas</b></td></tr>\n";
      echo "</table>\n";
    } else { echo "<h4>Nenhum registro localizado</h4>\n"; }
  } // fim do $op == "L"
  
?>