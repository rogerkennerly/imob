<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
  $cor                = $list_cor3;
  $titulo             = array();
  $titulos_aceitos    = array();
  $titulos_recusados  = array();
  $titulos_liquidados = array();
  $titulos_outros     = array();
  $userfile           = 'arq_retorno';
  
  if( isset($_FILES[$userfile]) )
  { if (is_uploaded_file($_FILES[$userfile]['tmp_name']))
    { 
      $arquivo      = $_FILES[$userfile]['tmp_name'];
      $arquivo_name	= $_FILES[$userfile]['name'];
      $arquivo_type	= $_FILES[$userfile]['type'];
      $nome_retorno = date('Ymd_His').'.ret';  
      $dir_retorno  = 'modulos/gbol/retorno/';
      if (is_file($arquivo)) 
      { move_uploaded_file($arquivo, $dir_retorno.$nome_retorno);
        $a1[] = 'AQUIVO RECEBIDO';
        echo erro_aviso($a1,'aviso');
      }
      
      $result      = mysql_query("select * from confboletos");
      $rc          = mysql_fetch_assoc($result);
      $codigobanco = $rc['codigobanco'];
      
      include('banco_'.$codigobanco.'/retorno.php');
      
      $a2[] = count($titulo).' Títulos Localizados';
      echo erro_aviso($a2,'aviso');
    }
  }
  
  //---------------- Buscano no sistema pelos títulos retornados e exibindo as informações do arquivo de retorno ---------------
  if (count($titulo) > 0)
  { $total_pago = 0;
    $total_titu = 0;
    $cor = '';
    echo "<br>\n";
    echo "<form name=frm1 action=modulo=gbol&pg=boletos method=POST>\n";
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
    echo "<TD align=center><B>Status       </B></TD>\n";
    echo "<TD align=center><B>Pago         </B></TD>\n";
    echo "<TD align=center><B>Numero       </B></TD>\n";
    echo "<TD align=center><B>DataVenci    </B></TD>\n";
    echo "<TD align=center><B>DataOcor.    </B></TD>\n";
    echo "<TD align=center><B>Nome         </B></TD>\n";
    echo "<TD align=center><B>Valor Sistema</B></TD>\n";
    echo "<TD align=center><B>Valor Retorno</B></TD>\n";
    echo "<TD align=center><B>Valor Tarifa </B></TD>\n";
    echo "<TD align=center><B>Info Retorno </B></TD>\n";
    echo "</TR>\n";
    for ($t = 0; $t < count($titulo); $t++)
    { $ar_nota      = array();
      $imprimir     = '';
      $ar_nota[]    = codigomovimento($titulo[$t]['cod_movimento']);
      $tempnota     = str_split($titulo[$t]['cod_ocorrencia'], 2);
      $situacao     = $titulo[$t]['situacao'];
      $nn           = $titulo[$t]['nosso_numero'];
      $valor_tarifa = 'R$ '.number_format($titulo[$t]['valor_tarifa'],2,',','.');
      //$total_pago  += convertvalor($titulo[$t]['valor_pago']);
      if ($situacao == 'Recusado') 
      { foreach($tempnota as $cod_ocorrencia)
        { if (rejeicoes($cod_ocorrencia) != '' and !in_array(rejeicoes($cod_ocorrencia),$ar_nota) ) { $ar_nota[] = rejeicoes($cod_ocorrencia); }
        }
        $valor_retorno = 'R$ '.number_format($titulo[$t]['valor_nominal'],2,',','.');
      }
      /*if ($situacao == 'Liquidado') 
      { foreach($tempnota as $cod_ocorrencia)
        { $ar_nota[] = codigoocorrencia($cod_ocorrencia);
        }
        $valor_retorno = 'R$ '.number_format($titulo[$t]['valor_pago'],2,',','.');
      }*/
      if ($situacao == 'Liquidado' or $situacao == 'Aceito' or $situacao == 'Outro') 
      { foreach($tempnota as $cod_ocorrencia)
        { if (codigoocorrencia($cod_ocorrencia) != '' and !in_array(codigoocorrencia($cod_ocorrencia),$ar_nota) ) { $ar_nota[] = codigoocorrencia($cod_ocorrencia); }
        }
        if ($situacao == 'Liquidado')
        { $valor_retorno = 'R$ '.number_format($titulo[$t]['valor_pago'],2,',','.');
        } else
        { $valor_retorno = 'R$ '.number_format($titulo[$t]['valor_nominal'],2,',','.');
        }
      }
      $nota   = implode('<br><br>',$ar_nota);
      $sql    = "select boletos.*,proprietario.nome as razao from boletos,proprietario where proprietario.id=boletos.codcliente AND boletos.numboleto='$nn'";
      $result = mysql_query($sql);
      if ( mysql_num_rows($result) > 0 )
      { $varcodigo = ((mysql_result($result,0,'codigo') + 345699) * 78999);
        if (mysql_result($result,0,'pago') == 'N' and $situacao == 'Liquidado') 
        { $pago = "<INPUT type=checkbox name='P".mysql_result($result,0,'codigo')."' value='S' checked>"; 
        } else 
        { $pago = mysql_result($result,0,'pago'); 
        }
        $datavenci     = ajustardata('M',mysql_result($result,0,'datavenci'));
        $datapagto     = viewdata($titulo[$t]['data_ocorrencia']);
        $cliente       = "<A href='base.php?pg=clientes&codigo=".mysql_result($result,0,'codcliente')."&op=A'>".mysql_result($result,0,'razao')."</A>";
        $valor_sistema = 'R$ '.number_format(mysql_result($result,0,'valor'),2,',','.');
        if ($valor_sistema != $valor_retorno) { $valor_retorno = '<color="#990000"><strong>'.$valor_retorno.'</strong></color>'; }
        if ($situacao == 'Aceito')
        { $res  = mysql_query("UPDATE boletos SET status=4 WHERE codigo=".mysql_result($result,0,'codigo')); 
          $nota = ''; // Não é necessário inserir informação uma vez que sempre é Entrada Confirmada
          $imprimir = "<br><A href=\"/adm/modulos/gbol/vbol.php?codigo=$varcodigo\" target=_blank>imprimir</A>";
        }
        if ($situacao == 'Recusado')
        { $res = mysql_query("UPDATE boletos SET status=5,retorno='$nota' WHERE codigo=".mysql_result($result,0,'codigo')); 
        }
      } else 
      { $pago      = ''; 
        $datavenci = viewdata($titulo[$t]['data_vencto']);
        $datapagto = viewdata($titulo[$t]['data_ocorrencia']);
        $cliente   = $titulo[$t]['pagador_nome'];
        $valor_sistema = '';
        $situacao .= '<br>BOLETO NÃO LOCALIZADO';
      }
      if ($cor == $list_cor3) { $cor = $list_cor2; } else { $cor = $list_cor3; }
      echo "<tr bgcolor=$cor align=center>\n";
      echo "<TD align=center>$situacao $imprimir</TD>\n";
      echo "<TD align=center>$pago         </TD>\n";
      echo "<TD align=center>$nn           </TD>\n";
      echo "<TD align=center>$datavenci    </TD>\n";
      echo "<TD align=center>$datapagto    </TD>\n";
      echo "<TD align=center>$cliente      </TD>\n";
      echo "<TD align=center>$valor_sistema</TD>\n";
      echo "<TD align=center>$valor_retorno</TD>\n";
      echo "<TD align=center>$valor_tarifa </TD>\n";
      echo "<TD align=center>$nota         </TD>\n";
      echo "</tr>\n";
    }
    //echo "<tr bgcolor=$list_cor1 align=center><td><b>".count($titulos_liquidados)."</b></td><td colspan=4 align=left><b>TOTAIS</b></td><td><b>R$&nbsp;".number_format($valor_pago,2,',','.')."</b></td></tr>\n";
    echo "</form>\n";
    echo "</table>\n";
  } 
?>