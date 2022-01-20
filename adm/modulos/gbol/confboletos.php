<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
  if (!isset($_REQUEST['op']))             { $op             = ''; } else { $op             = $_REQUEST['op'];             }
  if (!isset($_REQUEST['op2']))            { $op2            = ''; } else { $op2            = $_REQUEST['op2'];            }
  if (!isset($_REQUEST['codigo']))         { $codigo         = 0;  } else { $codigo         = $_REQUEST['codigo'];         } settype($codigo,'integer');
  if (!isset($_REQUEST['codrevenda']))     { $codrevenda     = 0;  } else { $codrevenda     = $_REQUEST['codrevenda'];     } settype($codrevenda,'integer');
  if (!isset($_REQUEST['codigobanco']))    { $codigobanco    = 0;  } else { $codigobanco    = $_REQUEST['codigobanco'];    }
  
  if ($op == 'I' or $op == 'S')
  { if (!isset($_POST['ag']))            { $ag             = ''; } else { $ag             = $_POST['ag'];             }
    if (!isset($_POST['digag']))         { $digag          = ''; } else { $digag          = $_POST['digag'];          }
    if (!isset($_POST['cc']))            { $cc             = ''; } else { $cc             = $_POST['cc'];             }
    if (!isset($_POST['cc1']))           { $cc1            = ''; } else { $cc1            = $_POST['cc1'];            }
    if (!isset($_POST['digcc']))         { $digcc          = ''; } else { $digcc          = $_POST['digcc'];          }
    if (!isset($_POST['carteira']))      { $carteira       = ''; } else { $carteira       = $_POST['carteira'];       }
    if (!isset($_POST['convenio']))      { $convenio       = ''; } else { $convenio       = $_POST['convenio'];       }
    if (!isset($_POST['multa']))         { $multa          = ''; } else { $multa          = $_POST['multa'];          }
    if (!isset($_POST['juros']))         { $juros          = ''; } else { $juros          = $_POST['juros'];          }
    //if (!isset($_POST['comregistro']))   {$comregistro     = ''; } else { $comregistro    = $_POST['comregistro'];    }
    if (!isset($_POST['nummin']))        { $nummin         = 0;  } else { $nummin         = $_POST['nummin'];         }
    if (!isset($_POST['nummax']))        { $nummax         = 0;  } else { $nummax         = $_POST['nummax'];         }
    if (!isset($_POST['indice']))        { $indice         = 0;  } else { $indice         = $_POST['indice'];         }
    //if (!isset($_POST['codtransmissao'])){ $codtransmissao = 0;  } else { $codtransmissao = $_POST['codtransmissao']; }
    settype($nummin,'float'); settype($nummax,'float'); settype($indice,'float');
  }
    
  if ($op == "D")
  { mysql_query("delete from confboletos where codigo=$codigo");
    if ( mysql_affected_rows($link) > 0 ) { echo "<h4>Configuração de Boleto Excluída</h4>\n"; } else { echo "<h4>Nada Excluído</h4>\n"; }
    $codigo = 0; $op = "L";
  }
    
  if ($op == "I")
  { $sql  = "insert into confboletos (codrevenda,codigobanco,ag,digag,cc,cc1,digcc,carteira,convenio,multa,juros,nummin,nummax,indice) values ("; //,codtransmissao,comregistro
    $sql .= $codrevenda;
    $sql .= ",'".$codigobanco."'";
    $sql .= ",'".trim($ag)."'";
    $sql .= ",'".trim($digag)."'";
    $sql .= ",'".trim($cc)."'";
    $sql .= ",'".trim($cc1)."'";
    $sql .= ",'".trim($digcc)."'";
    $sql .= ",'".trim($carteira)."'";
    $sql .= ",'".trim($convenio)."'";
    $sql .= ",'".trim($multa)."'";
    $sql .= ",'".trim($juros)."'";
    $sql .= ",".$nummin;
    $sql .= ",".$nummax;
    $sql .= ",".$indice;
    //$sql .= ",'".$codtransmissao."'";
    //$sql .= ",'".$comregistro."'";
    $sql .= ")";
    $result = mysql_query($sql);
    if ( mysql_affected_rows($link) == 1 ) { echo "<h4>Forma de Pagamento Incluída</h4>"; } else { echo "<h4>Nada Incluído</h4>"; }
    $op = "N";    
  }
  
  if ($op == "S")
  { $sql  = "update confboletos set ";
    $sql .= "codrevenda=".$codrevenda;
    $sql .= ",codigobanco='".$codigobanco."'";
    $sql .= ",ag='".trim($ag)."'";
    $sql .= ",digag='".trim($digag)."'";
    $sql .= ",cc='".trim($cc)."'";
    $sql .= ",cc1='".trim($cc1)."'";
    $sql .= ",digcc='".trim($digcc)."'";
    $sql .= ",carteira='".trim($carteira)."'";
    $sql .= ",convenio='".trim($convenio)."'";
    $sql .= ",multa='".trim($multa)."'";
    $sql .= ",juros='".trim($juros)."'";
    //$sql .= ",comregistro='".trim($comregistro)."'";
    $sql .= ",nummin=".($nummin);
    $sql .= ",nummax=".($nummax);
    $sql .= ",indice=".($indice);
    //$sql .= ",codtransmissao='".trim($codtransmissao)."'";
    $sql .= " where codigo=$codigo";
    $result = mysql_query($sql);
    if ( mysql_affected_rows($link) == 1 )
    { echo "<h4>Forma de Pagamento Alterada</h4>"; } else { echo "<h4>Nada Alterado</h4>"; }
    $op = "A";
  }
  
  if (($op == "A" or $op == "T") and $codigo > 0)
  { $result = mysql_query("select * from confboletos where codigo=$codigo");
    if (mysql_num_rows($result) > 0)
    { $codrevenda  = mysql_result($result,0,"codrevenda");
      if ($op == "A") { $codigobanco = mysql_result($result,0,"codigobanco"); }
      $ag             = mysql_result($result,0,'ag');
      $digag          = mysql_result($result,0,'digag');
      $cc             = mysql_result($result,0,'cc');
      $cc1            = mysql_result($result,0,'cc1');
      $digcc          = mysql_result($result,0,'digcc');
      $carteira       = mysql_result($result,0,'carteira');
      $convenio       = mysql_result($result,0,'convenio');
      $multa          = mysql_result($result,0,'multa');
      $juros          = mysql_result($result,0,'juros');
      //$comregistro    = mysql_result($result,0,'comregistro');
      $nummin         = mysql_result($result,0,'nummin');
      $nummax         = mysql_result($result,0,'nummax');
      $indice         = mysql_result($result,0,'indice');
      //$codtransmissao = mysql_result($result,0,'codtransmissao');
    }
  } else
  { if ($op != 'T')
  	{ $codrevenda  = 0;
      $codigobanco = 0;
    }
  	$ag             = '';
    $digag          = '';
    $cc             = '';
    $cc1            = '';
    $digcc          = '';
    $carteira       = '';
    $convenio       = '';
    $multa          = '';
    $juros          = '';
    //$comregistro    = 'N';
    $nummin         = 0; 
    $nummax         = 0; 
    $indice         = 0;
    //$codtransmissao = '';
  }
  
  $op = "N";
  if ($op == "N" or $op == "A" or $op == "T")
  { echo "<form name=form1 id=myform action=base.php method=POST onSubmit=\"return check_formaspagto(document.form1)\">\n";
    echo "<input type=hidden name=pg value=confboletos>\n";
  	if ($codigo > 0)
    { echo "<input type=hidden name=codigo value=$codigo>\n";
      echo "<input type=hidden name=op value=S>\n";
    } else
    { echo "<input type=hidden name=op value=I>\n";
    }
    echo "<table>\n";
    echo "<tr><td align=right><b>Revenda : </b></td>";  
    echo "<td><select name=codrevenda size=1>\n";
    $result = mysql_query("select * from revendas order by revenda"); $linhas = mysql_num_rows($result);
    for ($i = 0; $i < $linhas; $i++)
    { if (mysql_result($result,$i,"codigo") == $codrevenda)
      { echo "<option value=".mysql_result($result,$i,"codigo")." selected>".mysql_result($result,$i,"revenda")."</option>\n"; } else
      { echo "<option value=".mysql_result($result,$i,"codigo")." >".mysql_result($result,$i,"revenda")."</option>\n"; }
    }
    echo "</select></td></tr>\n";
    echo "<tr><td align=right><b>Código do Banco : </b></td>";  
    echo "<td><select name=codigobanco size=1 onChange=\"muda_banco();\">\n";
    if ($codigobanco == "0")   { echo "<option value='0'   selected>Selecione um Banco</option>\n"; } else { echo "<option value='0'  >Selecione um Banco</option>\n"; }
    if ($codigobanco == "001") { echo "<option value='001' selected>Banco do Brasil   </option>\n"; } else { echo "<option value='001'>Banco do Brasil   </option>\n"; }
    if ($codigobanco == "033") { echo "<option value='033' selected>Santander/Banespa </option>\n"; } else { echo "<option value='033'>Santander/Banespa </option>\n"; }
    if ($codigobanco == "104") { echo "<option value='104' selected>Caixa E. Federal  </option>\n"; } else { echo "<option value='104'>Caixa E. Federal  </option>\n"; }
    if ($codigobanco == "151") { echo "<option value='151' selected>Nossa Caixa       </option>\n"; } else { echo "<option value='151'>Nossa Caixa       </option>\n"; }
    if ($codigobanco == "237") { echo "<option value='237' selected>Bradesco          </option>\n"; } else { echo "<option value='237'>Bradesco          </option>\n"; }
    if ($codigobanco == "341") { echo "<option value='341' selected>Itaú              </option>\n"; } else { echo "<option value='341'>Itaú              </option>\n"; }
    if ($codigobanco == "356") { echo "<option value='356' selected>Banco Real        </option>\n"; } else { echo "<option value='356'>Banco Real        </option>\n"; }
    if ($codigobanco == "399") { echo "<option value='399' selected>HSBC              </option>\n"; } else { echo "<option value='399'>HSBC              </option>\n"; }
    if ($codigobanco == "409") { echo "<option value='409' selected>Unibanco          </option>\n"; } else { echo "<option value='409'>Unibanco          </option>\n"; }
    if ($codigobanco == "748") { echo "<option value='748' selected>Crediconai/Bancoob</option>\n"; } else { echo "<option value='748'>Crediconai/Bancoob</option>\n"; }
    echo "</select></td></tr>\n";
    echo "</table>\n";
    if ($codigobanco > 0)
    { switch ($codigobanco)
      { case "001" : include("form_001.php"); break;
        case "033" : include("form_033.php"); break;
        case "104" : include("form_104.php"); break;
        case "151" : include("form_151.php"); break;
        case "237" : include("form_237.php"); break;
        case "341" : include("form_341.php"); break;
        case "356" : include("form_356.php"); break;
        case "399" : include("form_399.php"); break;
        case "409" : include("form_409.php"); break;
        case "748" : include("form_748.php"); break;
      }
    }
    if ($codigobanco > 0)
    { echo "<table>\n";
    	if ($codigo > 0)
      { echo "<tr><td></td><td><input type=submit name=btn1 value='.:: Alterar ::.'>&nbsp;&nbsp;";
        echo "<input type=reset name=btn2 value='Desfazer'></td></tr>\n";
      } else
      { echo "<tr><td></td><td><input type=submit name=btn1 value='.:: Cadastrar ::.'>&nbsp;&nbsp;";
        echo "<input type=reset name=btn2 value='Limpar'></td></tr>\n";
      }
      echo "</table>\n";
    }
    echo "</form>\n";
  }
  
  $op = "L";
  if ($op == "L")
  { $sql = "select confboletos.*,revendas.revenda from confboletos,revendas where confboletos.codrevenda=revendas.codigo order by revendas.revenda";
    $result = mysql_query($sql); $linhas = mysql_num_rows($result);
    if ($linhas > 0)
    { $cor = "";
    	echo "<br>\n";
      echo "<table border=0 cellspacing=2 cellpadding=2>\n";
      echo "<tr bgcolor=$list_cor1 align=center>\n";
      echo "<td><b>del     </b></td>\n";
      echo "<td><b>edit    </b></td>\n";
      echo "<td><b>Revenda </b></td>\n";
      echo "<td><b>CodBanco</b></td>\n";
      echo "<td><b>AG      </b></td>\n";
      echo "<td><b>DigAG   </b></td>\n";
      echo "<td><b>CC      </b></td>\n";
      echo "<td><b>CC1     </b></td>\n";
      echo "<td><b>DigCC   </b></td>\n";
      echo "<td><b>Carteira</b></td>\n";
      //echo "<td><b>Cod.Transmissão</b></td>\n";
      echo "<td><b>Convênio</b></td>\n";
      //echo "<td><b>Com Registro</b></td>\n";
      echo "</tr>\n";    
      for ($i = 0; $i < $linhas; $i++)
      { if ($cor == $list_cor3) { $cor = $list_cor2; } else { $cor = $list_cor3; }
        echo "<tr bgcolor=$cor align=center>\n";
        echo "<td><a href=\"javascript:perguntar('base.php?pg=confboletos&codigo=".mysql_result($result,$i,"codigo")."&op=D','Apagar Configuração ?')\">del</a></td>\n";
        echo "<td><a href='base.php?pg=confboletos&codigo=".mysql_result($result,$i,"codigo")."&op=A'>edit</a></td>\n";
        echo "<td>".mysql_result($result,$i,"revenda")."</td>\n";
        echo "<td>".mysql_result($result,$i,"codigobanco")."</td>\n";
        echo "<td>".mysql_result($result,$i,"ag")."</td>\n";
        echo "<td>".mysql_result($result,$i,"digag")."</td>\n";
        echo "<td>".mysql_result($result,$i,"cc")."</td>\n";
        echo "<td>".mysql_result($result,$i,"cc1")."</td>\n";
        echo "<td>".mysql_result($result,$i,"digcc")."</td>\n";
        echo "<td>".mysql_result($result,$i,"carteira")."</td>\n";
        //echo "<td>".mysql_result($result,$i,"codtransmissao")."</td>\n";
        echo "<td>".mysql_result($result,$i,"convenio")."</td>\n";
        //echo "<td>".mysql_result($result,$i,"comregistro")."</td>\n";
        echo "</tr>\n";    
      }
      echo "</table>";
    }// else { echo $sql; }
  }
?> 
