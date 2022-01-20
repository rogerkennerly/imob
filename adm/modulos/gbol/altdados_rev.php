<?php if (basename($PHP_SELF) == basename(__FILE__)) { exit(); } ?>

<div class='page-content'>
  <div class='page-header'>
    <h1>Remessa / Retorno</h1>
  </div>

<?php
  if (!isset($op)) { $op  = ""; }
  $tipo   = "";
  $codigo = $_SESSION["g_codrevenda"];
  ?>
  <script language="JavaScript">
  function mostrapessoa(f){
  	if(f.pessoa[0].checked == true)
  	{ document.getElementById('juridica').style.display="block";
  		document.getElementById('fisica').style.display="none";
  	} else 
  	{ document.getElementById('juridica').style.display="none";
  		document.getElementById('fisica').style.display="block";
  	}
  }
  function check_cad_cliente(f){
  	var s = ""; var s2 = "";
  	if (f.pessoa[0].checked == true) 
  	{ s = trim(f.elements["nome"].value); if (s == "" || s.length < 5) { f.elements["nome"].focus(); alert("Razão Social não parece ser válido !"); return false; }
  		s = trim(f.elements["cnpj" ].value); if(!isCPFCNPJ(s,0)){ alert("CNPJ não parece ser válido!"); f.elements["cnpj"].focus(); return false; }
  	} else 
  	{ s = trim(f.elements["nome"].value); if (s == "" || s.length < 5) { f.elements["nome"].focus(); alert("Nome não parece ser válido !"); return false; }
  	  s = trim(f.elements["cpf" ].value); if(!isCPFCNPJ(s,0)){ alert("CPF não parece ser válido!"); f.elements["cpf"].focus(); return false; }
  	}
  	s = trim(f.elements["endereco"].value); if (s == "" || s.length < 5) { f.elements["endereco"].focus(); alert("Endereço não parece ser válido !"); return false; }
  	s = trim(f.elements["bairro"  ].value); if (s == "" || s.length < 4) { f.elements["bairro"  ].focus(); alert("Bairro não parece ser válido !"  ); return false; }
  	
  	s = trim(f.elements["cep"     ].value); if (!validarcep(s)) { f.elements["cep"].focus(); alert("CEP não parece ser válido !"); return false; }
  	s = trim(f.elements["fone"    ].value); if (s == "" || s.length < 8) { f.elements["fone"].focus(); alert("Telefone não parece ser válido !"); return false; }
  	s = trim(f.elements["email"   ].value); if (!validaremail(s)) { f.elements["email"].focus(); alert("E-mail não parece ser válido !"); return false; }
  }
  </script>
  <?php
  
  if ($op == "S")
  { $alterados = false;
    $erro      = false;
    $result    = mysql_query("select codigo from admin where username='".addslashes(trim($email))."' and codrevenda<>".$_SESSION["g_codrevenda"]);
    if (mysql_num_rows($result) > 0) { echo "<h4>Novo E-mail escolhido já existe.<br>Nada Alterado.</h4>"; $erro = true; }
    if ($pessoa == "F")
    { if (checacpf(formatcpf("B",$cpf)))
      { $mdoc = formatcpf("M",$cpf);
        $bdoc = formatcpf("B",$cpf);
        $nome = $nome;
      } else { echo "<h4>CPF <b>$mdoc</b>&nbsp; Inválido</h4>"; $erro = true; }
    }
  	if ($pessoa == "J") 
  	{ if (checacnpj(formatcnpj("B",$cnpj))) 
  	  { $mdoc = formatcnpj("M",$cnpj);
  	    $bdoc = formatcnpj("B",$cnpj);
      } else { echo "<h4>CNPJ <b>$mdoc</b>&nbsp; Inválido</h4>"; $erro = true; }
  	}
    if (!checaremail($email)) { echo "<h4>O e-mail não parece ser válido</h4>"; $erro = true; }
    if (!$erro)  
    { if (!isset($website)) { $website = ""; }
      if (!isset($msn)    ) { $msn     = ""; }
      if (!isset($skype)  ) { $skype   = ""; }
      settype($nummin,"float"); settype($nummax,"float"); settype($indice,"float");
    	$sql = "update revendas set ";                    
      $sql .= "revenda='".addslashes(trim($revenda))."'";    
      $sql .= ",nome='".addslashes(trim($nome))."'";
      $sql .= ",codcidade=$codcidade";
      $sql .= ",fone='".addslashes(trim($fone))."'";
      $sql .= ",email='$email'";
      $sql .= ",contatos='".addslashes(trim($contatos))."'";
      $sql .= ",website='".addslashes(trim($website))."'";
      $sql .= ",endereco='".addslashes(trim($endereco))."'";
      $sql .= ",bairro='".addslashes(trim($bairro))."'";
      $sql .= ",cep='$cep'";
      $sql .= ",estado='$estado'";
      $sql .= ",pessoa='$pessoa'";
      $sql .= ",doc='$bdoc'";
      $sql .= ",msn='".addslashes(trim($msn))."'";
      $sql .= ",skype='".addslashes(substr(trim($skype),0,40))."'";
      $sql .= ",inst1='".addslashes(substr(trim($inst1),0,40))."'";
      $sql .= ",inst2='".addslashes(substr(trim($inst2),0,40))."'";
      $sql .= ",inst3='".addslashes(substr(trim($inst3),0,40))."'";
      $sql .= ",inst4='".addslashes(substr(trim($inst4),0,40))."'";
      //$sql .= ",inst5='".addslashes(trim($inst5))."'";
      //$sql .= ",inst6='".addslashes(trim($inst6))."'";
      //$sql .= ",inst7='".addslashes(trim($inst7))."'";
      //$sql .= ",registro='$registro'";
      $sql .= ",limpar='$limpar'";
      $sql .= ",inibol=$inibol";
      $sql .= " where codigo=".$_SESSION["g_codrevenda"];
      mysql_query($sql);
      if ( mysql_affected_rows($link) == 1 ) { $alterados = true; }
      mysql_query("update admin set username='".addslashes(trim($email))."',senha='".addslashes(trim($senha))."',nome='".addslashes(trim($revenda))."' where codrevenda=".$_SESSION['g_codrevenda']);
      if ( mysql_affected_rows($link) == 1 ) { $alterados = true; }
      /*$sql  = "update confboletos set ";
      $sql .= "multa='".trim($multa)."'";
      $sql .= ",juros='".trim($juros)."'";
      $sql .= ",nummin=".($nummin);
      $sql .= ",nummax=".($nummax);
      $sql .= ",indice=".($indice);
      $sql .= " where codrevenda=".$_SESSION["g_codrevenda"];
      $result = mysql_query($sql);*/
      //if ( mysql_affected_rows($link) == 1 ) { $alterados = true; }
      include("fn_imagens_revendas.php");
      if ($alterados) { echo sucesso("Dados Alterados"); } else { echo alerta("Nada Alterado"); }
    }  
  }
  
  $result = mysql_query("select * from dados_imobiliaria");
	if (mysql_num_rows($result) > 0)
  { $revenda   = utf8_encode(mysql_result($result,0,'revenda'));
    $nome      = utf8_encode(mysql_result($result,0,'nome'));
    $codcidade = utf8_encode(mysql_result($result,0,'codcidade'));
    $fone      = utf8_encode(mysql_result($result,0,'fone'));
    $email     = utf8_encode(mysql_result($result,0,'email'));
    $contatos  = utf8_encode(mysql_result($result,0,'contatos'));
    $website   = utf8_encode(mysql_result($result,0,'website'));
    $endereco  = utf8_encode(mysql_result($result,0,'endereco'));
    $bairro    = utf8_encode(mysql_result($result,0,'bairro'));
    $cep       = utf8_encode(mysql_result($result,0,'cep'));
    $estado    = utf8_encode(mysql_result($result,0,'estado'));
    $status    = utf8_encode(mysql_result($result,0,'status'));
    $pessoa    = utf8_encode(mysql_result($result,0,'pessoa'));
    $doc       = utf8_encode(mysql_result($result,0,'doc'));
    $msn       = utf8_encode(mysql_result($result,0,'msn'));
    $skype     = utf8_encode(mysql_result($result,0,'skype'));
    $inst1     = utf8_encode(mysql_result($result,0,'inst1'));
    $inst2     = utf8_encode(mysql_result($result,0,'inst2'));
    $inst3     = utf8_encode(mysql_result($result,0,'inst3'));
    $inst4     = utf8_encode(mysql_result($result,0,'inst4'));
    $inst5     = utf8_encode(mysql_result($result,0,'inst5'));
    $inst6     = utf8_encode(mysql_result($result,0,'inst6'));
    $inst7     = utf8_encode(mysql_result($result,0,'inst7'));
    $registro  = utf8_encode(mysql_result($result,0,'registro'));
    $limpar    = utf8_encode(mysql_result($result,0,'limpar'));
    $inibol    = utf8_encode(mysql_result($result,0,'inibol'));
    $nome      = $nome;
    if ($pessoa == "F") 
    { $cpf  = formatcpf("M",$doc);
      $cnpj = "";
    } else 
    { $cnpj = formatcnpj("M",$doc);
      $cpf  = "";
    }
    $diappagto = mysql_result($result,0,"diappagto");
    $datalanc  = mysql_result($result,0,"datalanc");        
    if ($datalanc > 0) { $datalanc = ajustardata("M",$datalanc); }        
    $valor     = "R$ ".number_format(mysql_result($result,0,"valor"),2,',','.');
    $result    = mysql_query("select * from admin where codrevenda=".$_SESSION["g_codrevenda"]);
    $senha     = mysql_result($result,0,"senha");
    /*$result    = mysql_query("select * from confboletos where codrevenda=".$_SESSION["g_codrevenda"]);
    $multa     = mysql_result($result,0,"multa");
    $juros     = mysql_result($result,0,"juros");
    $nummin    = mysql_result($result,0,"nummin");
    $nummax    = mysql_result($result,0,"nummax");
    $indice    = mysql_result($result,0,"indice");*/
  } else { echo alerta("Imobiliária não localizada"); }
  
  
  echo "<form name=frmcadastro action=base.php method=POST enctype=multipart/form-data onSubmit=\"return check_cad_cliente(document.frmcadastro)\">\n";
  echo "<input type=hidden name=pg value=altdados_rev>";
  echo "<input type=hidden name=op value=S>\n";
  echo "<table border=0 cellspacing=2 cellpadding=2>\n";
  if ($pessoa == "F") { $jchecked = ""; $fchecked = "checked"; } else { $jchecked = "checked"; $fchecked = ""; }
  echo "<tr><TD align=right width=120><b>Pessoa Jurídica : </b></TD><TD><INPUT type=radio name=pessoa value=J $jchecked onclick=\"mostrapessoa(document.frmcadastro);\"></TD></TR>\n";
  echo "<tr><TD align=right width=120><b>Pessoa Física   : </b></TD><TD><INPUT type=radio name=pessoa value=F $fchecked onclick=\"mostrapessoa(document.frmcadastro);\"></TD></TR>\n";
  echo "<tr><TD align=right width=120><b>Nome da Loja  : </b></TD><TD><INPUT name=revenda  type=text size=60 value=\"$revenda\"  maxlength=60></TD></TR>\n";
  echo "</table>\n";
  echo "<div id=juridica>\n";
  echo "<table border=0 cellspacing=2 cellpadding=2>\n";
  echo "<tr><TD align=right width=120><b>Razão Social : </b></TD><TD><INPUT name=nome type=text size=60 value=\"$nome\" maxlength=60></TD></TR>\n";
  echo "<tr><TD align=right width=120><b>CNPJ         : </b></TD><TD><INPUT name=cnpj  type=text size=19 value=\"$cnpj\"  maxlength=18 onKeyUp=\"mascara(this,event,'00.000.000/0000-00');return autoTab(this, 18, event);\"></TD></TR>\n";
  echo "</table></div>\n";
  echo "<div id=fisica>\n";
  echo "<table border=0 cellspacing=2 cellpadding=2>\n";
  echo "<tr><TD align=right width=120><b>Nome : </b></TD><TD><INPUT name=nome type=text size=60 value=\"$nome\" maxlength=60></TD></TR>\n";
  echo "<tr><TD align=right width=120><b>CPF  : </b></TD><TD><INPUT name=cpf  type=text size=15 value=\"$cpf\"  maxlength=14 onKeyUp=\"mascara(this,event,'000.000.000-00'); return autoTab(this, 14, event);\"<TD></TR>\n";
  echo "</table></div>\n";
  if ($pessoa == "J")
  { ?><script language="JavaScript">
       document.getElementById('fisica').style.display="none";
   		 document.getElementById('juridica').style.display="block";
   		</script><?php
  } else
  { ?><script language="JavaScript">
       document.getElementById('fisica').style.display="block";
   		 document.getElementById('juridica').style.display="none";
   		</script><?php
  }
  echo "<table border=0 cellspacing=2 cellpadding=2>\n";
  echo "<tr><td ALIGN=RIGHT width=120><b>Endereço : </b></td><td><input type=text name=endereco size=40 maxlength=60 value=\"$endereco\"></td></tr>\n";
  echo "<tr><td ALIGN=RIGHT width=120><b>Bairro :   </b></td><td><input type=text name=bairro   size=30 maxlength=40 value=\"$bairro\"></td></tr>\n";
  echo "<tr><td ALIGN=RIGHT width=120><b>Cep :      </b></td><td><input type=text name=cep      size=10 maxlength=9  value=\"$cep\" onKeyUp=\"mascara(this,event,'00000-000'); return autoTab(this, 9, event);\"></td></tr>\n";
      
  echo "<tr><td ALIGN=RIGHT width=120><b>Cidade : </b></td>";
  echo "<td><select name=codcidade size=1>\n";
  $result = mysql_query("select * from cidades order by ordem,cidade");
  $linhas = mysql_num_rows($result);
  for ($i = 0; $i < $linhas; $i++)
  { if (mysql_result($result,$i,"codigo")==$codcidade)
    { echo "<option value=".mysql_result($result,$i,"codigo")." selected>".mysql_result($result,$i,"cidade")."</option>\n"; } else
    { echo "<option value=".mysql_result($result,$i,"codigo").">".mysql_result($result,$i,"cidade")."</option>\n"; }
  }
  echo "</select></td></tr>\n";
         
  echo "<tr><td ALIGN=RIGHT width=120><b>Estado :   </b></td><td><input type=text name=estado   size=2  maxlength=2   value=\"$estado\" onKeyUp=\"return autoTab(this, 2, event);\"></td></tr>\n";
  echo "<tr><td ALIGN=RIGHT width=120><b>Fone :     </b></td><td><input type=text name=fone     size=40 maxlength=50  value=\"$fone\" onKeyUp=\"mascara(this,event,'(00) 0000-0000');\"></td></tr>\n";
  echo "<tr><td ALIGN=RIGHT width=120><b>E-mail :   </b></td><td><input type=text name=email    size=40 maxlength=80  value=\"$email\"></td></tr>\n";
  //echo "<tr><td ALIGN=RIGHT width=120><b>MSN :      </b></td><td><input type=text name=msn      size=40 maxlength=80  value=\"$msn\"></td></tr>\n";
  //echo "<tr><td ALIGN=RIGHT width=120><b>Skype :    </b></td><td><input type=text name=skype    size=30 maxlength=40  value=\"$skype\"></td></tr>\n";
  echo "<tr><td ALIGN=RIGHT width=120><b>Senha :    </b></td><td><input type=text name=senha    size=20 maxlength=20  value=\"$senha\"></td></tr>\n";
  //echo "<tr><td ALIGN=RIGHT width=120><b>Website :  </b></td><td><input type=text name=website  size=40 maxlength=80  value=\"$website\"></td></tr>\n";
  echo "<tr><td ALIGN=RIGHT width=120><b>Contatos : </b></td><td><input type=text name=contatos size=50 maxlength=255 value=\"$contatos\"></td></tr>\n";
      
  echo "<tr><td ALIGN=RIGHT width=120><b>Logo : </b></td>";
  echo "<td valign=middle>";
  if (file_exists("logos/$codigo.jpg"))
  { echo "<a href=# onclick=\"window.open('logos/$codigo.jpg','','scrollbars=yes,width=250,height=150')\">Ver Logo</a><br>"; }
  echo "<input type=file name=userfile size=40 maxlength=40> 200L x 100H</td></tr>\n";
  /*
  echo "<tr><td align=right><b>Multa  : </b></td><td><input type=text name=multa   size=4  maxlength=4  value=\"$multa\"   > geralmente 0.02 (2%)</td></tr>\n";
  echo "<tr><td align=right><b>Juros  : </b></td><td><input type=text name=juros   size=5  maxlength=5  value=\"$juros\"   > geralmente 0.001 (1% ao mês)</td></tr>\n";
  echo "<tr><td align=right><b>Mínimo : </b></td><td><input type=text name=nummin  size=20 maxlength=20 value=\"$nummin\"  > início da numeração dos boletos</td></tr>\n";
  echo "<tr><td align=right><b>Máximo : </b></td><td><input type=text name=nummax  size=20 maxlength=20 value=\"$nummax\"  > fim da numeração dos boletos</td></tr>\n";
  echo "<tr><td align=right><b>Atual  : </b></td><td><input type=text name=indice  size=20 maxlength=20 value=\"$indice\"  > índice atual (último usado)</td></tr>\n";
  */
  echo "<tr><td ALIGN=RIGHT><b>Instrução 1 : </b></td><td><input type=text name='inst1' size='60' maxlength='40' value=\"$inst1\"> <small>Fixa</small></td></tr>\n";
  echo "<tr><td ALIGN=RIGHT><b>Instrução 2 : </b></td><td><input type=text name='inst2' size='60' maxlength='40' value=\"$inst2\"> <small>Fixa</small></td></tr>\n";
  echo "<tr><td ALIGN=RIGHT><b>Instrução 3 : </b></td><td><input type=text name='inst3' size='60' maxlength='40' value=\"$inst3\"> <small>Pode ser alterada no boleto</small></td></tr>\n";
  echo "<tr><td ALIGN=RIGHT><b>Instrução 4 : </b></td><td><input type=text name='inst4' size='60' maxlength='40' value=\"$inst4\"> <small>Pode ser alterada no boleto</small></td></tr>\n";
  //echo "<tr><td ALIGN=RIGHT><b>Instrução 5 : </b></td><td><input type=text name='inst5' size='60' maxlength='60' value=\"$inst5\"></td></tr>\n";
  //echo "<tr><td ALIGN=RIGHT><b>Instrução 6 : </b></td><td><input type=text name='inst6' size='60' maxlength='60' value=\"$inst6\"></td></tr>\n";
  //echo "<tr><td ALIGN=RIGHT><b>Instrução 7 : </b></td><td><input type=text name='inst7' size='60' maxlength='60' value=\"$inst7\"></td></tr>\n";
      
  /*echo "<tr><td ALIGN=RIGHT width=120><b>Banner : </b></td>";
  echo "<td valign=middle>";
  if (file_exists("../revendas/$codigo/banner.jpg"))
  { echo "<a href=# onclick=\"window.open('../revendas/$codigo/banner.jpg','','scrollbars=yes,width=540,height=420')\">banner</a><br>"; }
  echo "<input type=file name=userfile size=40 maxlength=40></td></tr>\n";*/
  
  /*echo "<tr><td ALIGN=RIGHT><b>Registro : </b></td><td><select name=registro size=1>\n";  
  if ($registro == 'S') { echo "<option value='S' selected>Sim</option>\n"; } else { echo "<option value='S'>Sim</option>\n"; }
  if ($registro == 'N') { echo "<option value='N' selected>Não</option>\n"; } else { echo "<option value='N'>Não</option>\n"; }
  echo "</SELECT></td></tr>\n";*/
  
  echo "<tr><td ALIGN=RIGHT><b>Status Incial Boleto : </b></td><td><select name=inibol size=1>\n";
  foreach ($ar_status as $key => $val)
  { echo "<option value=";
    if ($inibol == $key) { echo "'$key' selected>$val"; } else { echo "'$key'>$val"; }
    echo "</option>\n";
  }
  echo "</SELECT></td></tr>\n";
  
  echo "<tr><td ALIGN=RIGHT><b>Limpar depois de inclusão : </b></td><td><select name=limpar size=1>\n";
  if ($limpar == 'S') { echo "<option value='S' selected>Sim</option>\n"; } else { echo "<option value='S'>Sim</option>\n"; }
  if ($limpar == 'N') { echo "<option value='N' selected>Não</option>\n"; } else { echo "<option value='N'>Não</option>\n"; }
  echo "</SELECT></td></tr>\n";
  
  echo "<tr><td></td><td><input type=submit name=btn1 value='.:: Alterar ::.'>&nbsp;&nbsp;<input type=reset name=btn2 value='Desfazer'></td></tr>\n";
  echo "</table></form>\n";
?>