<?php if (basename($PHP_SELF) == basename(__FILE__)) { exit(); } ?>
<?php if ($_SESSION['g_nivel'] != 2) { readfile("header.html"); echo "<body><h4>Você não tem permissão para acessar essa página</h4></body></htm>\n"; exit(); } ?>
<?php
  if (!isset($data)) { $data = ""; }
  if ($data != "")
  { 
    $novos = 0; $relancados = 0;
    $dia = $data[0].$data[1];
    $mes = $data[3].$data[4];
    $ano = $data[6].$data[7].$data[8].$data[9];
    if ($dia == 28 or $dia == 29) { $dia = 30; $diaop = 30; } else { $diaop = 0; }
    $passado   = ajustardata("B",incmes("M",$data,-1,$diaop));
    $datavenci = ajustardata("B",$data);
    
    $result = mysql_query("select * from revendas where codigo=".$_SESSION['g_codrevenda']);
    $inst1 = mysql_result($result,0,"inst1");
    $inst2 = mysql_result($result,0,"inst2");
    $inst3 = mysql_result($result,0,"inst3");
    $inst4 = mysql_result($result,0,"inst4");
    $inst5 = mysql_result($result,0,"inst5");
    $inst6 = mysql_result($result,0,"inst6");
    $inst7 = mysql_result($result,0,"inst7");
    
    $result = mysql_query("select * from confboletos where codrevenda=".$_SESSION['g_codrevenda']);
    $multa  = mysql_result($result,0,"multa"); 
    $juros  = mysql_result($result,0,"juros");
    $registrado  = mysql_result($result,0,"registrado");
    
    //---------- atualizando o aviso ---------------
    /*$aviso  = "Vencimento original ".ajustardata("M",$passado)."<br>\n";
    $aviso .= "O pagamento deste é necessário para que os produtos continuem a ser exibidos no site.<br>\n";
    $aviso .= "O bloqueio ocorre 5 dias após o vencimento.<br>\n";
    $aviso .= "Desconsiderar este boleto caso já tenha sido pago.<br>\n";
    $s = "update boletos set aviso='$aviso' where boletos.pago='N' and boletos.aviso='' and boletos.datavenci='$passado'";
    mysql_query($s);*/
    //---------- atualizando data de vencimento ---------------
    /*$s = "update boletos set datavenci='$datavenci' where boletos.pago='N' and boletos.datavenci='$passado'";
    mysql_query($s);
    $relancados = mysql_affected_rows($link);*/
    //-------------- Gerando Boletos -------------------
    $result = mysql_query("select clientes.* from clientes where clientes.valor>0 and clientes.diappagto=$dia and ((clientes.datalanc<='$datavenci')or(clientes.datalanc is NULL)) and clientes.codrevenda=".$_SESSION['g_codrevenda']);
    $linhas = mysql_num_rows($result);
    for ($i = 0;$i < $linhas; $i++)
    { 
    	$valor     = mysql_result($result,$i,"valor" );
      $codigo    = mysql_result($result,$i,"codigo");
      $numboleto = newnumboleto($_SESSION['g_codrevenda']);
      $datalanc  = incmes("B",$datavenci,1);
      $descricao = mysql_result($result,$i,"descricao");
      $var1 = ""; $var2 = "";
      if ($inst1 != "") { $var1 = $inst1; }
      if ($inst2 != "") { $var2 = $inst2; }
      if ($multa != "" and $var1 == "") { $var1 = "Após vencimento cobrar multa de R$ ".number_format(($valor*$multa),2,',','.')."<br>\n"; }
      if ($juros != "" and $var2 == "") { $var2 = "Após vencimento cobrar juros de R$ ".number_format(($valor*$juros),2,',','.')." ao dia<br>\n"; }
      //if ($fmulta != "" or $fjuros != "") { $instrucoes = $fmulta.$fjuros; } else { $instrucoes = "Não receber Vencido<br>\n"; }
    
      $s  = "insert into boletos (";
      $s .= "numboleto,valor,pago,registrado,codcliente,dataproc,datavenci,descricao,codrevenda,inst1,inst2,inst3,inst4,inst5,inst6,inst7";
      $s .= ") values (";
      $s .= "$numboleto,".$valor.",'N','".$registrado."',$codigo,CURDATE(),'$datavenci','$descricao',".$_SESSION['g_codrevenda'];
      $s .= ",'$var1','$var2','$inst3','$inst4','$inst5','$inst6','$inst7'";
      $s .= ")";
      mysql_query($s);
      if (mysql_affected_rows($link) > 0)
      { mysql_query("update clientes set datalanc='$datalanc' where codigo=$codigo and codrevenda=".$_SESSION['g_codrevenda']); $novos++; } else { echo $s."<br>"; }
    }
    echo "<h4>Boletos Gerados = $novos</h4>\n";
    //echo "<h4>Boletos Relançados = $relancados</h4>\n";
  } else
  { 
    echo "<table cellpadding=0 cellspacing=0 border=0>\n";
    echo "<tr><td class=box1tl></td><td class=box1t></td><td class=box1tr></td></tr>\n";
    echo "<tr>\n";
    echo "<td class=box1l></td>\n";
    echo "<td class=box1c>\n";
      echo "<table><tr>";
      //echo "<td width=150><A href=base.php?pg=boletos&op=N&op2=N class=btn_comprar><span><span id=botao_comprar>Incluir Boletos</span></span></A></td>\n";
      echo "<td><form name=frm6 action='base.php' method=POST>\n";
      echo "<input type=hidden name=pg value=gerador>\n";
      echo "Data de Vencimento <input type=text name=data size=10 value='10/".date("m")."/".date("Y")."'>\n";
      echo "<INPUT TYPE=submit name=btn2 value='.:: Gerar Boletos ::.'></form>\n";
      echo "</td></tr></table>\n";
    echo "</td>\n";
    echo "<td class=box1r></td>\n";
    echo "</tr>\n";
    echo "<tr><td class=box1bl></td><td class=box1b></td><td class=box1br></td></tr>\n";
    echo "</table>\n";
  }
?>         