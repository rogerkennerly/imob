<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
  $cor                = $list_cor3;
  $titulo             = array();
  $titulos_outros     = array();
  $titulos_aceitos    = array();
  $titulos_recusados  = array();
  $titulos_liquidados = array();
  $userfile           = 'arq_retorno';
  
  if( isset($_FILES[$userfile]) )
  { if (is_uploaded_file($_FILES[$userfile]['tmp_name']))
    { 
      $arquivo      = $_FILES[$userfile]['tmp_name'];
      $arquivo_name	= $_FILES[$userfile]['name'];
      $arquivo_type	= $_FILES[$userfile]['type'];
      $nome_retorno = date('Ymd_His').'.ret';      
      if (is_file($arquivo)) 
      { move_uploaded_file($arquivo, $dir_retorno.$nome_retorno);
        $a1[] = 'AQUIVO RECEBIO';
        echo erro_aviso($a1,'aviso');
      }
      
      $result      = mysql_query("select * from confboletos where codrevenda=".$_SESSION['g_codrevenda']);
      $rc          = mysql_fetch_assoc($result);
      $codigobanco = $rc['codigobanco'];
      
      include('banco_'.$codigobanco.'/retorno.php');
      
      $a2[] = count($titulo).' Títulos Localizados';
      echo erro_aviso($a2,'aviso');
    }
  }
    

  //---------------- Títulos RECUSADOS ---------------
  if (count($titulos_recusados) > 0)
  { echo "<font color='#990000'><h1>Títulos Recusados</h1>\n";
    echo "<table border=0 cellspacing=2 cellpadding=2 width=100%>\n";
    echo "<tr bgcolor=$list_cor1 align=center>\n";
      echo "<TD><B>Número</B></TD>\n";
      echo "<TD><B>Cliente</B></TD>\n";
      echo "<TD><B>Valor</B></TD>\n";
      echo "<TD><B>Movimento</B></TD>\n";
      echo "<TD><B>Motivos da Recusa</B></TD>\n";
    echo "</TR>\n";
    foreach($titulos_recusados as $titulo_atu)
    { $upd_bol = mysql_query("UPDATE boletos SET numremessa='1', motivorejeicao='".$titulo_atu['descr_ocorrencia']."' WHERE numboleto='".$titulo_atu['nosso_numero']."' AND codrevenda='".$_SESSION['g_codrevenda']."'");
      $sel_bol = mysql_query("SELECT * FROM boletos WHERE numboleto='".$titulo_atu['nosso_numero']."' AND codrevenda='".$_SESSION['g_codrevenda']."'");
      if (mysql_num_rows($sel_bol) > 0)
      { $res_bol        = mysql_fetch_assoc($sel_bol);
        $sel_cliente    = mysql_query("SELECT RAZAO FROM clientes WHERE CODIGO='".$res_bol['codcliente']."'");
        $res_cliente    = mysql_fetch_assoc($sel_cliente);
        $nome_cliente   = $res_cliente['RAZAO'];
      } else { $nome_cliente   = '[Boleto não localizado no sistema]'; }
      if ($cor == $list_cor3) { $cor = $list_cor2; } else { $cor = $list_cor3; }
      echo "<tr bgcolor=$cor align=center>\n";
        echo "<TD>",$titulo_atu['nosso_numero'],"</TD>\n";
        echo "<TD>$nome_cliente</TD>\n";
        echo "<TD>R$ ",number_format($res_bol['valor'],2),"</TD>\n";
        echo "<TD>",$titulo_atu['descr_movimento'],"</TD>\n";
        echo "<TD>",$titulo_atu['descr_ocorrencia'],"</TD>\n";
      echo "</TR>\n";
    }
    echo '</table></font>',"\n";
  }

  //---------------- Títulos ACEITOS ---------------
  if (count($titulos_aceitos) > 0)
  { echo "<font color='#009900'><h1>Títulos Aceitos</h1>\n";
    echo "<table border=0 cellspacing=2 cellpadding=2 width=100%>\n";
    echo "<tr bgcolor=$list_cor1 align=center>\n";
      echo "<TD><B>Número</B></TD>\n";
      echo "<TD><B>Cliente</B></TD>\n";
      echo "<TD><B>Valor</B></TD>\n";
      echo "<TD><B>Tarifa</B></TD>\n";
      echo "<TD><B>Movimento</B></TD>\n";
    echo "</TR>\n";
    foreach($titulos_aceitos as $titulo_atu)
    { $upd_bol = mysql_query("UPDATE boletos SET numremessa=3, numretorno=1, motivorejeicao='".$titulo_atu['nota']."' WHERE numboleto='".$titulo_atu['nosso_numero']."' AND codrevenda='".$_SESSION['g_codrevenda']."'");
      $result  = mysql_query("SELECT * FROM boletos WHERE numboleto='".$titulo_atu['nosso_numero']."' AND codrevenda='".$_SESSION['g_codrevenda']."'");
      if (mysql_num_rows($result) > 0)
      { $codcliente   = mysql_result($result,0,'codcliente');
        $valor        = mysql_result($result,0,'valor');
        $result       = mysql_query("SELECT RAZAO FROM clientes WHERE CODIGO=".$codcliente);
        $nome_cliente = mysql_result($result,0,'razao');
        $localizado   = '';
      } else 
      { $valor        = $titulo_atu['valor_creditos'];
        $nome_cliente = $titulo_atu['pagador_nome'];
        $localizado   = 'Não localizado<br>Dados do Arquivo<br>';
      }
      if ($cor == $list_cor3) { $cor = $list_cor2; } else { $cor = $list_cor3; }
      echo "<tr bgcolor=$cor align=center>\n";
        echo "<TD>",$localizado,$titulo_atu['nosso_numero'],"</TD>\n";
        echo "<TD>",$nome_cliente,"</TD>\n";
        echo "<TD>R$ ",number_format($valor,2),"</TD>\n";
        echo "<TD>R$ ",number_format($titulo_atu['valor_tarifa'],2),"</TD>\n";
        //echo "<TD>",$titulo_atu['descr_movimento'],"</TD>\n";
        echo "<TD>",$titulo_atu['nota'],"</TD>\n";
      echo "</TR>\n";
    }
    echo '</table></font>',"\n";
  }
  
  //---------------- Títulos LIQUIDADOS ---------------
  if (count($titulos_liquidados) > 0)
  { $valor_pago = 0;
    $valor_titu = 0;
    echo "<br>\n";
    echo "<form name=frm1 action=base.php method=POST>\n";
    echo "<input type=hidden name=pg       value=boletos>";
    echo "<input type=hidden name=op       value='L'>\n";
    echo "<input type=hidden name=pago     value=''>\n";
    echo "<input type=hidden name=dataini  value=''>\n";
    echo "<input type=hidden name=datafin  value=''>\n";
    echo "<input type=hidden name=order    value=''>\n";
    echo "<input type=hidden name=tipodata value=''>\n";
    echo "<input type=hidden name=nome     value=''>\n";
    echo "<input type=hidden name=numbol   value=''>\n";
    echo "<input type=hidden name=rotinapagou value='S'>\n";
    echo "<input type=submit name=btn3 value='Marcar como Pagos'>\n";
      
    echo "<table border=0 cellspacing=2 cellpadding=2 width=100%>\n";
    echo "<tr bgcolor=$list_cor1 align=center>\n";
    echo "<TD><B>Pago     </B></TD>\n";
    echo "<TD><B>Numero   </B></TD>\n";
    echo "<TD><B>DataVenci</B></TD>\n";
    echo "<TD><B>DataPagto</B></TD>\n";
    echo "<TD><B>Nome     </B></TD>\n";
    echo "<TD><B>Valor cadastrado   </B></TD>\n";
    echo "<TD><B>Valor Pago  </B></TD>\n";
    echo "</TR>\n";
    foreach($titulos_liquidados as $titulo_atu)
    {
      $sql = "select boletos.*,clientes.razao from boletos,clientes where clientes.codigo=boletos.codcliente and clientes.codrevenda=".$_SESSION['g_codrevenda']." AND boletos.numboleto='".$titulo_atu['nosso_numero']."'";
      $result = mysql_query($sql); 
      if ( mysql_num_rows($result) > 0 )
      { $cor = '';
        if ($cor == $list_cor3) { $cor = $list_cor2; } else { $cor = $list_cor3; }
        $i = 0;
        echo "<tr bgcolor=$cor align=center>\n";
        $varcodigo = ((mysql_result($result,$i,"codigo") + 345699) * 78999);
        if (mysql_result($result,$i,"pago") != "S") { echo "<TD align=center><INPUT type=checkbox name='P".mysql_result($result,$i,"codigo")."' value='S' checked></TD>\n"; } else { echo "<TD align=center>".mysql_result($result,$i,"pago")."</TD>\n"; }
        echo "<TD align=center>".$titulo_atu['nosso_numero']."</TD>\n";

        echo "<TD align=center>".ajustardata("M",mysql_result($result,$i,"datavenci"))."</TD>\n";
        echo "<TD align=center>".$titulo_atu['data_ocorrencia'][1]."</TD>\n";
        echo "<TD align=center><A href='base.php?pg=clientes&codigo=".mysql_result($result,$i,"codcliente")."&op=A'>".mysql_result($result,$i,"razao")."</A></TD>\n";
        echo "<TD align=center>R$ ".number_format(mysql_result($result,$i,"valor"),2,',','.')."</TD>\n";
        
        if ( $titulo_atu['valor_pago'] != number_format(mysql_result($result,$i,"valor"),2,',','.') )
        { echo "<TD align=center style='color:#990000'><strong>R$ ".$titulo_atu['valor_pago']."</strong></TD>\n";
        } else
        { echo "<TD align=center>R$ ".$titulo_atu['valor_pago']."</TD>\n";
        }
        echo "</tr>\n";
        $valor_titu += mysql_result($result,$i,"valor");        
        $valor_pago += convertvalor($titulo_atu['valor_pago']);        
      
      } else 
      { // Para títulos não localizados no BD
        $cor = "";
        if ($cor == $list_cor3) { $cor = $list_cor2; } else { $cor = $list_cor3; }
        echo "<tr bgcolor=$cor align=center>\n";
        echo "<TD align=center>---</TD>\n";
        echo "<TD align=center>".$titulo_atu['nosso_numero']."</TD>\n";

        echo "<TD align=center>---</TD>\n";
        echo "<TD align=center>".$titulo_atu['data_ocorrencia'][1]."</TD>\n";
        echo "<TD align=center>TITULO NAO LOCALIZADO NO SISTEMA<br>",$titulo_atu['pagador_nome'],"</TD>\n";
        echo "<TD align=center>R$ ---</TD>\n";
        echo "<TD align=center style='color:#990000'><strong>R$ ".number_format($titulo_atu['valor_pago'],2,',','.')."</strong></TD>\n";
        echo "</tr>\n";
        $valor_pago += $titulo_atu['valor_pago'];        
      }
    }
    echo "<tr bgcolor=$list_cor1 align=center><td><b>".count($titulos_liquidados)."</b></td><td colspan=4 align=left><b>TOTAIS</b></td><td><b>R$ ".number_format($valor_titu,2,',','.')."</b></td><td><b>R$&nbsp;".number_format($valor_pago,2,',','.')."</b></td></tr>\n";
    echo "</form>\n";
    echo "</table>\n";
  } 
?>