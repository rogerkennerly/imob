<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
  if ($_SERVER['SERVER_NAME'] == "10.10.10.171" or $_SERVER['SERVER_NAME'] == "localhost") { $host = "http://".$_SERVER['SERVER_NAME']."/gbol"; } else { $host = "http://".$_SERVER['SERVER_NAME']; }
  
  if (!isset($_REQUEST['op'])){ $op = ""; } else { $op = $_REQUEST['op']; }
  if (!isset($_REQUEST['rotinapagou'])){ $rotinapagou = ""; } else { $rotinapagou = $_REQUEST['rotinapagou']; }
  if (!isset($_REQUEST['nome']))       { $nome        = ""; } else { $nome        = $_REQUEST['nome'];        }
  if (!isset($_REQUEST['numbol']))     { $numbol      = 0;  } else { $numbol      = $_REQUEST['numbol'];      }
  if (!isset($_REQUEST['tipodata']))   { $tipodata    = ""; } else { $tipodata    = $_REQUEST['tipodata'];    }
  if (!isset($_REQUEST['pago']))       { $pago        = ""; } else { $pago        = $_REQUEST['pago'];        }
  if (!isset($_REQUEST['buscacodcli'])){ $buscacodcli = 0;  } else { $buscacodcli = $_REQUEST['buscacodcli']; }
  if (!isset($_REQUEST['dataini']))    { $dataini     = ""; } else { $dataini     = $_REQUEST['dataini'];     }
  if (!isset($_REQUEST['datafin']))    { $datafin     = ""; } else { $datafin     = $_REQUEST['datafin'];     }
  if (!isset($_REQUEST['order']))      { $order       = ""; } else { $order       = $_REQUEST['order'];       }
  if (!isset($_REQUEST['statusbusca'])){ $statusbusca = 0;  } else { $statusbusca = $_REQUEST['statusbusca']; }
  if (!isset($_REQUEST['dataini']))    { $tdataini = "01/".date("m")."/".date("Y"); } else { $tdataini = $_REQUEST['dataini']; }
  if (!isset($_REQUEST['datafin']))    { $tdatafin = date("d/m/Y",mktime(0,0,0,(date("m")+1),0,date("Y"))); } else { $tdatafin = $_REQUEST['datafin']; }
  if ($_SERVER['REQUEST_METHOD'] == "GET") { $nome = urldecode($nome); }
  
  if ($op == "I" or $op == "S")
  { $datevenci = ""; $valor = 0; $codcliente = 0; $descricao = "";
  	if (isset($_POST['f_pago'])) { $f_pago = $_POST['f_pago']; } else { $f_pago = ''; }
  	//if (isset($_POST['inst1']))  { $inst1  = substr(trim($_POST['inst1']),0,40);  } else { $inst1  = ''; }
    //if (isset($_POST['inst2']))  { $inst2  = substr(trim($_POST['inst2']),0,40);  } else { $inst2  = ''; }
    if (isset($_POST['inst3']))  { $inst3  = substr(trim($_POST['inst3']),0,40);  } else { $inst3  = ''; }
    if (isset($_POST['inst4']))  { $inst4  = substr(trim($_POST['inst4']),0,40);  } else { $inst4  = ''; }
    //if (isset($_POST['inst5']))  { $inst5  = $_POST['inst5'];  } else { $inst5  = ''; }
    //if (isset($_POST['inst6']))  { $inst6  = $_POST['inst6'];  } else { $inst6  = ''; }
    //if (isset($_POST['inst7']))  { $inst7  = $_POST['inst7'];  } else { $inst7  = ''; }
    if (isset($_POST['multa']))         { $multa         = $_POST['multa'];         } else { $multa         = 0;  }
    if (isset($_POST['juros']))         { $juros         = $_POST['juros'];         } else { $juros         = 0;  }
    if (isset($_POST['numboleto']))     { $numboleto     = $_POST['numboleto'];     } else { $numboleto     = 0;  }
    if (isset($_POST['datadesconto']))  { $datadesconto  = $_POST['datadesconto'];  } else { $datadesconto  = ''; }
    if (isset($_POST['valordesconto'])) { $valordesconto = $_POST['valordesconto']; } else { $valordesconto = 0;  }
    if (isset($_POST['status']))        { $status        = $_POST['status'];        } else { $status        = 0;  }
    $codcliente = $_POST['codcliente'];
    $datavenci  = $_POST['datavenci'];
    $valor      = $_POST['valor'];
    $descricao  = addslashes(trim($_POST['descricao']));
    settype($numboleto,'integer');
    settype($codcliente,"integer");
    settype($multa,'integer');
    settype($juros,'integer');
    $multa = number_format($multa,0,'',''); //tirando casas decimais caso tenha
    $juros = number_format($juros,0,'',''); //tirando casas decimais caso tenha
  	if (strlen($datavenci) == 10) 
  	{ $d = explode("/",$datavenci);
  	  if (checkdate($d[1],$d[0],$d[2])) 
  	  { $vdatavenci = date("Y/m/d",mktime(0,0,0,$d[1],$d[0],$d[2]));
        $vvalor = convertvalor($valor,2);
      } else { $op = "N"; echo "<h4>Data de vencimento inválida</h4>"; }
  	} else { $op = "N"; echo "<h4>Data de vencimento inválida</h4>"; }
    if (strlen($datadesconto) != '') 
  	{ $d = explode("/",$datadesconto);
  	  if (checkdate($d[1],$d[0],$d[2])) 
  	  { $vdatadesconto  = "'".date("Y/m/d",mktime(0,0,0,$d[1],$d[0],$d[2]))."'";
        $vvalordesconto = convertvalor($valordesconto,2);
      } else { echo "<h4>Data desconto inválida</h4>"; $vvalordesconto = 0; $vdatadesconto = 'NULL'; }
  	} else { $vvalordesconto = 0; $vdatadesconto = 'null'; }
    
  }
  ?>
  
<?php
$titulo = 'Boletos';
if($op == 'N'){
  $titulo = 'Incluir Boleto';
}
?>  
  
<div class='page-content'>
  <div class='page-header'>
    <h1><?php echo $titulo; ?></h1>
  </div>
  
  <?php
  //não exibe os formulários de busca se for a pagina de inclusão de boleto
  if($op != 'N' AND $op != 'A' AND $op != 'S'){?>
  <form name=frm6 action='?modulo=gbol&pg=boletos' method=POST>
    <input type=hidden name=pg value=boletos>
    <input type=hidden name=op value=L>
    <table id='sample-table-1' class='table table-bordered table-noborder table-monocromatic tabela-listagem-6'>
      <tr>
        <td> 
          Nome:<br/>
          <input type=text name=nome size=50 value="<?php echo $nome;?>">
        </td> 
        <td>
          Data Inicial:<br/>
          <input type=text name=dataini size=20 value='<?php echo $tdataini;?>'>
        </td>
        <td>
          Data Final:<br/>
          <input type=text name=datafin size=20 value='<?php echo $tdatafin;?>'>
        </td>     
        <td>   
          Data Vencimento:<br/>
          <select name=tipodata style="width:200px;">
            <?php
            if($tipodata == "boletos.datavenci"){ echo "<option value='boletos.datavenci' selected>Data de Vencimento</option>";}
            else{ echo "<option value='boletos.datavenci'>Data de Vencimento</option>";}
            if($tipodata == "boletos.datapagto"){ echo "<option value='boletos.datapagto' selected>Data de Pagamento</option>";}
            else{ echo "<option value='boletos.datapagto'>Data de Pagamento</option>";}
            ?>
          </select>
        </td>     
        <td>
          Situação:<br/>
          <select name=pago style="width:200px;">
            <?php
            if($pago == "N"){ echo "<option value='N' selected>Não Pagos</option>\n";}else{ echo "<option value='N'>Não Pagos</option>\n"; }
            if($pago == "S"){ echo "<option value='S' selected>Pagos</option>\n";    }else{ echo "<option value='S'>Pagos</option>\n";     }
            ?>
          </select>    
        </td> 
        <td> 
          Número:<br/>
          <input type=text name=numbol size=14 value="<?php echo $numbol;?>">
        </td> 
        <td>
          <br/>
          <INPUT TYPE=submit name=btn1 value='.:: Buscar Boletos ::.'>
        </td>
      </tr>
    </table>
  </form>
  
  <table id='sample-table-1' class='table table-bordered table-monocromatic tabela-listagem-6'>
    <tr>
      <td align=center>
        <a href="?modulo=gbol&pg=boletos&op=N&op2=N" class=btn_comprar>
          <span id=botao_comprar>Incluir Boletos
        </a>
      </td>
      <?php $bg = '';$color = '';if($pago == 'T' AND !$statusbusca){$bg = "style='background-color:#62a8d1;'";$color = "style='color:#FFF;'";} ?>
      <td align=center <?php echo $bg; ?>>
        <a href="?modulo=gbol&pg=boletos&op=L&pago=T" <?php echo $color; ?>>
          Listar Todos Boletos Não Pagos
        </a>
      </td>
      <?php $bg = '';$color = '';if($pago == 'T' AND $statusbusca == 2){$bg = "style='background-color:#62a8d1;'";$color = "style='color:#FFF;'";} ?>
      <td align=center <?php echo $bg; ?>>
        <A href="?modulo=gbol&pg=boletos&op=L&statusbusca=2&pago=T" <?php echo $color; ?>>Aguardando Remessa</A>
      </td>
      <?php $bg = '';$color = '';if($pago == 'T' AND $statusbusca == 3){$bg = "style='background-color:#62a8d1;'";$color = "style='color:#FFF;'";} ?>
      <td align=center <?php echo $bg; ?>>
        <A href="?modulo=gbol&pg=boletos&op=L&statusbusca=3&pago=T" <?php echo $color; ?>>Aguardando Retorno</A>
      </td>
      <?php $bg = '';$color = '';if($pago == 'T' AND $statusbusca == 5){$bg = "style='background-color:#62a8d1;'";$color = "style='color:#FFF;'";} ?>
      <td align=center <?php echo $bg; ?>>
        <A href="?modulo=gbol&pg=boletos&op=L&statusbusca=5&pago=T" <?php echo $color; ?>>Erro Remessa</A>
      </td>
    </tr>
  </table>
  <?php
  }?>
  
  
  <?php
  if ($rotinapagou == "S")
  { $pagos    = 0;
    $remessas = 0;
    $result = mysql_query("select * from boletos where pago='N'");
    $linhas = mysql_num_rows($result);
    for ($i = 0;$i < $linhas; $i++)
    { $tmp = "P".mysql_result($result,$i,"codigo");
      if (isset($$tmp)) { $tmp2 = "S"; } else { $tmp2 = ""; }
      if ($tmp2 == "S")
      { mysql_query("update boletos set pago='S',datapagto=CURDATE() where codigo=".mysql_result($result,$i,"codigo"));
        $pagos++;
      }
      
      $tmp = "R".mysql_result($result,$i,"codigo");
      if (isset($$tmp)) { $tmp2 = "S"; } else { $tmp2 = ""; }
      if ($tmp2 == "S")
      { mysql_query("update boletos set status=2 where codigo=".mysql_result($result,$i,"codigo"));
        $remessas++;
      }
    }
    echo "<h4>$pagos boletos pagos<br>$remessas boletos selecionados para remessa</h4>\n"; $op = "L";
  }
  
  if ($op == "D")
  { mysql_query("delete from boletos where codigo=$codigo");
    if ( mysql_affected_rows($link) > 0 ) { echo sucesso("Boletos Excluído."); } else { echo alerta("Nada Excluído."); }
    $codigo = 0; $op = "L";
  }
  
  if ($op == "I")
  { if ($codcliente > 0)
    { if ($numboleto == 0) { $numboleto = newnumboleto($_SESSION['g_codrevenda']); }
      $sql  = "insert into boletos (";
      $sql .= "codcliente,numboleto,valor,pago,dataproc,datavenci,descricao,codrevenda,inst3,inst4,multa,juros,datadesconto,valordesconto,status"; //,inst1,inst2,inst5,inst6,inst7,
      $sql .= ") values (";
      $sql .= $codcliente.",".$numboleto.",".$vvalor.",'N',CURDATE(),'$vdatavenci','".addslashes(trim($descricao))."',''";
      $sql .= ",'$inst3','$inst4','$multa','$juros',$vdatadesconto,$vvalordesconto,$status";
      //$sql .= ",'$inst1','$inst2','$inst3','$inst4','$inst5','$inst6','$inst7','$multa','$juros'";
      $sql .= ")";
      mysql_query($sql);
      if (mysql_affected_rows($link) > 0) 
      { $varcodigo = ((mysql_insert_id($link) + 345699) * 78999);
      	echo sucesso("Boleto Incluído");
        if ($status == 0 or $status == 4)
        { echo "<A href='/adm/modulos/gbol/vbol.php?codigo=$varcodigo' target=_blank>imprimir</A>";
        }
        echo "</h4>\n";
        $op2 = "N";
      } else { echo alerta("Nada Incluído - $sql"); }
    } else { echo alerta("Código de Cliente Inválido"); }
    $op = "N";
  }
  
  if ($op == "S")
  { if ($codcliente > 0)
    { $sql  = "update boletos set";
      $sql .= " codcliente=$codcliente";
      $sql .= ",valor=$vvalor";
      $sql .= ",datavenci='$vdatavenci'";
      $sql .= ",descricao='".addslashes(trim($descricao))."'";
      //$sql .= ",inst1='$inst1'";
      //$sql .= ",inst2='$inst2'";
      $sql .= ",inst3='$inst3'";
      $sql .= ",inst4='$inst4'";
      //$sql .= ",inst5='$inst5'";
      //$sql .= ",inst6='$inst6'";
      //$sql .= ",inst7='$inst7'";
      $sql .= ",multa='$multa'";
      $sql .= ",juros='$juros'";
      $sql .= ",datadesconto=$vdatadesconto";
      $sql .= ",valordesconto=$vvalordesconto";
      $sql .= ",status=$status";
      $sql .= " where codigo=$codigo ";
      mysql_query($sql);
      if (mysql_affected_rows($link) > 0) 
      { $varcodigo = (($codigo + 345699) * 78999);
        echo sucesso("Boleto Alterado");
        if ($status == 0)
        { echo "<A href=\"/adm/modulos/gbol/vbol.php?codigo=$varcodigo\" target=_blank>imprimir</A>";
        }
        echo "</h4>\n"; $op = "A"; 
      } else { echo alerta("Nada Alterado"); $op = "A"; }
    } else { echo "<h4>Código de Cliente Inválido</h4>"; }
  }
  
  if ($op == "A" and $codigo > 0)
  { $result = mysql_query("select * from boletos where codigo=$codigo ");
    if (mysql_num_rows($result) > 0)
    { $numboleto  = mysql_result($result,0,'numboleto');
      $codcliente = mysql_result($result,0,'codcliente');
      $valor      = 'R$ '.number_format(mysql_result($result,0,'valor'),2,',','.');
      $f_pago     = mysql_result($result,0,'pago');
      $descricao  = mysql_result($result,0,'descricao');
      $dataproc   = ajustardata('M',mysql_result($result,0,'dataproc'));
      $datavenci  = ajustardata('M',mysql_result($result,0,'datavenci'));
      $datapagto     = ajustardata('M',mysql_result($result,0,'datapagto'));
      //$inst1       = mysql_result($result,0,'inst1');
      //$inst2       = mysql_result($result,0,'inst2');
      $inst3         = mysql_result($result,0,'inst3');
      $inst4         = mysql_result($result,0,'inst4');
      //$inst5       = mysql_result($result,0,'inst5');
      //$inst6       = mysql_result($result,0,'inst6');
      //$inst7       = mysql_result($result,0,'inst7');
      $multa         = mysql_result($result,0,'multa');
      $juros         = mysql_result($result,0,'juros');
      $datadesconto  = viewdata(mysql_result($result,0,'datadesconto'));
      $valordesconto = 'R$ '.number_format(mysql_result($result,0,'valordesconto'),2,',','.');
      $status        = mysql_result($result,0,'status');
      $result   = mysql_query("select * from revendas where codigo=".$_SESSION['g_codrevenda']);
      $inst1    = mysql_result($result,0,'inst1');
      $inst2    = mysql_result($result,0,'inst2');
    } else { echo "<h4>Boleto não localizado</h4>\n"; }
  }
  
  if ($op == "N" or $op == "A")
  { echo "<form name=boletos action=?modulo=gbol&pg=boletos& method=POST>\n";
    echo "<input type=hidden name=pg value=boletos>";
    if ($codigo > 0)
    { echo "<input type=hidden name=codigo value=$codigo>";
      echo "<input type=hidden name=op value=S>\n";
      echo "<input type=hidden name=pago        value='$pago'>\n";
      echo "<input type=hidden name=dataini     value='$dataini'>\n";
      echo "<input type=hidden name=datafin     value='$datafin'>\n";
      echo "<input type=hidden name=order       value='$order'>\n";
      echo "<input type=hidden name=tipodata    value='$tipodata'>\n";
      echo "<input type=hidden name=nome        value='$nome'>\n";
      echo "<input type=hidden name=numbol      value='$numbol'>\n";
      echo "<input type=hidden name=statusbusca value='$statusbusca'>\n";
    } else
    { echo "<input type=hidden name=op value=I>\n";
      if ($op2 == "N"){
        mysql_set_charset('utf8', $link);
        $result   = mysql_query("select * from dados_imobiliaria");
        $registro = mysql_result($result,0,'registro');
        $limpar   = mysql_result($result,0,'limpar');
        $inst1    = mysql_result($result,0,'inst1');
        $inst2    = mysql_result($result,0,'inst2');
        $status   = mysql_result($result,0,'inibol');
        //if (!isset($inst1)) { $inst1 = mysql_result($result,0,'inst1'); }
        //if (!isset($inst2)) { $inst2 = mysql_result($result,0,'inst2'); }
        //if (!isset($inst3)) { $inst3 = mysql_result($result,0,'inst3'); }
        //if (!isset($inst4)) { $inst4 = mysql_result($result,0,'inst4'); }
        //if (!isset($inst5)) { $inst5 = mysql_result($result,0,'inst5'); }
        //if (!isset($inst6)) { $inst6 = mysql_result($result,0,'inst6'); }
        //if (!isset($inst7)) { $inst7 = mysql_result($result,0,'inst7'); }
        if ($limpar == 'S') { $inst3  = mysql_result($result,0,'inst3'); } else { if (!isset($inst3)) { $inst3 = mysql_result($result,0,'inst3'); } }
        if ($limpar == 'S') { $inst4  = mysql_result($result,0,'inst4'); } else { if (!isset($inst4)) { $inst4 = mysql_result($result,0,'inst4'); } }
        if ($limpar == 'S') { $status = mysql_result($result,0,'inibol'); }
        $result = mysql_query("select * from confboletos");
        //$multa  = mysql_result($result,0,'multa');
        //$juros  = mysql_result($result,0,'juros');
        if ($limpar == 'S') { $multa = mysql_result($result,0,'multa'); } else { if (!isset($multa)) { $multa = mysql_result($result,0,'multa'); } }
        if ($limpar == 'S') { $juros = mysql_result($result,0,'juros'); } else { if (!isset($juros)) { $juros = mysql_result($result,0,'juros'); } }
        //if (!isset($codcliente)) { $codcliente = 0; }
        //$valor = 0; $descricao = ""; $datavenci = date("d/m/Y"); $numboleto = 0;
        $numboleto = 0;
        if ($limpar == 'S')
        { $codcliente = 0; $valor = 0; $descricao = ''; $datavenci = date('d/m/Y'); $datadesconto = ''; $valordesconto = 0;
        } else
        { if (!isset($numboleto))     { $numboleto     = 0;  }
          if (!isset($valor))         { $valor         = 0;  }
          if (!isset($descricao))     { $descricao     = ''; }
          if (!isset($datavenci))     { $datavenci     = date('d/m/Y'); }
          if (!isset($datadesconto))  { $datadesconto  = ''; }
          if (!isset($valordesconto)) { $valordesconto = 0;  }
        }
      }
    }
  ?>
    <table class="form-boletos">
      <?php
      if ($codigo > 0){
        echo "<tr><td><b>NumBoleto:</b>$numboleto</td></tr>\n";
        echo "<tr><td><b>Pago: </b>$f_pago</td></tr>\n";
        echo "<tr><td><b>Data Pagamento: </b>$datapagto</td></tr>\n";
        echo "<tr><td><b>Data Processamento: </b>$dataproc</td></tr>\n";
      }?>
      <tr>
        <td>
          <b>Codigo do Cliente:</b><br/>
          <input type=text name='codcliente' id='codcliente' size='15' maxlength='8' value="<?php echo $codcliente;?>">
          <a href=# onClick="$('#div_busca_cliente').toggle();">
            Procurar
          </a>
          <div id="div_busca_cliente" style="background-color:#FFF;position:absolute;width:300px;height:200px;border:1px solid #CCC;padding:3px;display:none;">
            <div style="width:100%;border:1px solid #CCC;">
              <input type="text" id="busca_cliente" style="width:calc(100% - 20px);border:none;margin-right:-1px;" onkeyup="filtra_clientes(this.value)">
              <i class="fas fa-search"></i>
            </div>
            <div id="retorno_busca_cliente" style="padding-top:5px;overflow:auto;height:165px;">
              <?php
              $s = "SELECT nome, id FROM proprietario";
              $q = mysql_query($s);
              while($r = mysql_fetch_assoc($q)){?>
                <a href='javascript:void(0)' onclick="$('#codcliente').val('<?php echo $r['id']; ?>');$('#div_busca_cliente').hide()"><?php echo $r['nome'];?></a><br>
                <?php
              }
              ?>
            </div>
          </div>
        </td>
      </tr>
      <?php
      if($codigo == 0){
        echo "<tr><td><b>Nosso Número: </b><br/><input type=text name='numboleto' size='15' maxlength='15' value=\"$numboleto\"></td></tr>\n"; 
      }
      ?>
      <tr>
        <td>
          <b>Valor:</b><br/>
          <input type=text name='valor' size='10' maxlength='12' value="<?php echo $valor;?>">
        </td>
      </tr>
      <tr>
        <td>
          <b>Data Vencimento:</b><br/>
          <input type=text name='datavenci' size='10' maxlength='10' value="<?php echo $datavenci;?>">
        </td>
      </tr>
      <tr>
        <td>
          <b>Detalhes:</b><br/>
          <textarea name=descricao rows=6 cols=70 wrap=PHYSICAL><?php echo $descricao;?></textarea>
        </td>
      </tr>
      <tr>
        <td>
          <b>Multa:</b><br/>
          <input type=text name='multa' size='10'  maxlength='4'  value="<?php echo $multa;?>">
        </td>
      </tr>
      <tr>
        <td>
          <b>Juros:</b><br/>
          <input type=text name='juros' size='10'  maxlength='5'  value="<?php echo $juros;?>">
        </td>
      </tr>
      <tr>
        <td>
          <b>Instrução Geral 1:</b> <?php echo $inst1;?><br/>
          
        </td>
      </tr>
      <tr>
        <td>
          <b>Instrução Geral 2:</b> <?php echo $inst2;?><br/>
          
        </td>
      </tr>
      <tr>
        <td>
          <b>Instrução 1 : </b><br/>
          <input type=text name='inst1' size='60' maxlength='60' value="<?php echo $inst3;?>">
        </td>
      </tr>
      <tr>
        <td>
          <b>Instrução 2 : </b><br/>
          <input type=text name='inst2' size='60' maxlength='60' value="<?php echo $inst4;?>">
        </td>
      </tr>
      <tr>
      <?php
      //echo "<tr><td ALIGN=RIGHT><b>Com Registro : </b></td><td>";
      //echo "<select name=registrado size=1>";
      //if ($registrado == 'S') { echo "<option value='S' selected>Sim</option>\n"; } else { echo "<option value='S'>Sim</option>\n"; }
      //if ($registrado == 'N') { echo "<option value='N' selected>Não</option>\n"; } else { echo "<option value='N'>Não</option>\n"; }
      //echo "</SELECT></td></tr>\n";
      echo "<tr><td><b>Status : </b><br/><select name=status size=1>\n";
      foreach ($ar_status as $key => $val)
      { echo "<option value=";
        if ($status == $key) { echo "'$key' selected>$val"; } else { echo "'$key'>$val"; }
        echo "</option>\n";
      }
      echo "</select>";
      echo "</td></tr>\n";
      ?>
      <tr>
        <td>
          <b>Data Desconto:  </b><br/>
          <input type=text name='datadesconto'  size='10' maxlength='10' value="<?php echo $datadesconto;?>">
          <small>Conceder desconto de R$ x,xx se pago até esta data</small>
        </td>
      </tr>
      <tr>
        <td>
          <b>Valor Desconto: </b><br/>
          <input type=text name='valordesconto' size='10'  maxlength='12' value="<?php echo $valordesconto;?>">
          <small>Conceder desconto deste valor se pago até data acima</small>
        </td>
      </tr>
      <?php
      if($codigo > 0){?>
        <tr>
          <td><input type=submit name=btn1 value='.:: Alterar ::.'>&nbsp;&nbsp;<input type=reset name=btn2 value='Desfazer'></td>
        </tr>
      <?php
      }else{?>
        <tr>
          <td><input type=submit name=btn1 value='.:: Cadastrar ::.'>&nbsp;&nbsp;<input type=reset name=btn2 value='Limpar'></td>
        </tr>
      <?php
      }?>
    </table>
    </form>
  <?php
  }
  
  
        
  //-------------------------------- Listando ----------------------------------
  if ($op == "L")
  { if ($dataini != "") { $d = explode("/",$dataini); if (checkdate($d[1],$d[0],$d[2])) { $vdataini = $d[2]."/".$d[1]."/".$d[0]; } else { $vdataini = ""; } } else { $vdataini = ""; }
    if ($datafin != "") { $d = explode("/",$datafin); if (checkdate($d[1],$d[0],$d[2])) { $vdatafin = $d[2]."/".$d[1]."/".$d[0]; } else { $vdatafin = ""; } } else { $vdatafin = ""; }
    $vdata    = "";
    $vnome    = "";
    $vpago    = "";
    $vnumbol  = "";
    $buscacli = "";
    settype($numbol,"float");
  	
  	if ($numbol > 0)
    { $vnumbol = "and boletos.numboleto=$numbol";
    } 
    elseif ($buscacodcli > 0) { $buscacli = "and boletos.codcliente=$buscacodcli"; }
    else
    { if ($pago == "T")
      { $vpago = "and boletos.pago='N'";
        $vdata = '';
        if ($statusbusca != '0') { $vdata = "and boletos.status=$statusbusca"; }
      } 
      else
      { if ($tipodata == ""){ $tipodata = "boletos.datavenci"; }
      	if ($vdataini != "" and $vdatafin != "") { $vdata = "and $tipodata between '$vdataini' and '$vdatafin'"; }
        if (strlen($nome) > 0) { $vnome = "and proprietario.nome like '$nome%'"; }
        $vpago = "and boletos.pago='$pago'";
      }
    }
    if ($order == "" ) { $order  = "P"; }
    if ($order == "R") { $vorder = "order by proprietario.nome,boletos.datavenci"; }
    if ($order == "N") { $vorder = "order by boletos.numboleto"; }
    if ($order == "P") { $vorder = "order by boletos.datavenci"; }
    if ($order == "O") { $vorder = "order by proprietario.nome"; }
    if ($order == "V") { $vorder = "order by boletos.valor"; }
    
    $sql = "select boletos.*,proprietario.nome from boletos,proprietario where proprietario.id=boletos.codcliente $vdata $vnome $vnumbol $vpago $buscacli $vorder";
    $result = mysql_query($sql); 
    if (mysql_num_rows($result) > 0){ 
    	$valor = 0;
      $cor = "";?>
    	<form name=frm1 action=?modulo=gbol&pg=boletos method=POST>
        <input type=hidden name=op       value='L'>
        <input type=hidden name=pago     value='$pago'>
        <input type=hidden name=dataini  value='$dataini'>
        <input type=hidden name=datafin  value='$datafin'>
        <input type=hidden name=order    value='$order'>
        <input type=hidden name=tipodata value='$tipodata'>
        <input type=hidden name=nome     value='$nome'>
        <input type=hidden name=numbol   value='$numbol'>
        <input type=hidden name=rotinapagou value='S'>
        <input type=submit name=btn3 value='Marcar como Pagos/Remessa'>
              
        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
          <tr align=center>
            <TD><B>Pago     </B></TD>
            <TD><B>Numero   </B></TD>
            <TD><B>Imprimir<br>Remessa</B></TD>
            <TD><B>DataVenci</B></TD>
            <TD><B>DataPagto</B></TD>
            <TD><B>Nome     </B></TD>
            <TD><B>Valor    </B></TD>
            <TD><B>Alterar  </B></TD>
            <TD><B>Excluir  </B></TD>
          </TR>
      
        <?php
        while($linhas = mysql_fetch_assoc($result)){?>
          <tr align=center>
            <?php
            $varcodigo = (($linhas["codigo"] + 345699) * 78999);
            if($linhas["pago"] == "N"){
              echo "<TD align=center><INPUT type=checkbox class=checkbox name='P".$linhas["codigo"]."' value='S'></TD>";
            } 
            else{
              echo "<TD align=center>".$linhas["pago"]."</TD>";
            }
            
            echo "<TD align=center>".$linhas["numboleto"]."</TD>";
            $mais = '';
            if($linhas['retorno'] != ''){ //informações sobre o retorno
              $mais = "<a href=\"javascript:mostrar('".str_replace('<br>','\n',$linhas['retorno'])."')\">?</a>";
            }
            
            if($linhas['status'] == 0 or $linhas['status'] == 4){ //sem registro ou retorno OK
              echo "<TD align=center><A href=\"".$host."/adm/modulos/gbol/vbol.php?codigo=$varcodigo\" target=_blank>imprimir</A>&nbsp;&nbsp;$mais</TD>\n";
            }
            elseif( $linhas['status'] == 1){ //com registro mas não marcado para remessa
              echo "<TD align=center><INPUT type=checkbox name='R".$linhas["codigo"]."' value='S'>&nbsp;&nbsp;$mais</TD>\n";
            }
            elseif($linhas['status'] == 3){ //com registro mas não marcado para remessa
              echo "<TD align=center>REM: <a href='",$dir_remessa,"remessa_".$linhas['controleremessa'].".rem' download>".$linhas['controleremessa']."</a></TD>\n";
            }
            else{
              echo "<TD align=center>",$ar_status[$linhas['status']],"&nbsp;&nbsp;$mais</TD>\n";
            }
            
        echo "<TD align=center>".ajustardata("M",$linhas["datavenci"])."</TD>\n";
        if ($pago == "S") { echo "<TD align=center>".ajustardata("M",$linhas["datapagto"])."</TD>\n"; }else{ echo "<td>-</td>"; }
        echo "<TD align=center><A href='?modulo=gbol&pg=inc_clientes&op=editar&id_proprietario=".$linhas["codcliente"]."'>".$linhas["nome"]."</A></TD>\n";
        echo "<TD align=center>R$ ".number_format($linhas["valor"],2,',','.')."</TD>\n";
        echo "<TD align=center><A href='?modulo=gbol&pg=boletos&codigo=".$linhas["codigo"]."&op=A&dataini=$dataini&datafin=$datafin&pago=$pago&nome=".urlencode($nome)."&tipodata=$tipodata&order=$order&numbol=$numbol&statusbusca=$statusbusca'>alterar</A></TD>\n";
        echo "<td align=center><a href=\"?modulo=gbol&pg=boletos&codigo=".$linhas["codigo"]."&op=D&dataini=$dataini&datafin=$datafin&pago=$pago&nome=".urlencode($nome)."&tipodata=$tipodata&order=$order&numbol=$numbol&statusbusca=$statusbusca\" onclick='return confirm(\"Excluir Boleto?\")'>excluir</a></td>\n";
        echo "</tr>\n";
        $valor += $linhas["valor"];
      } // end do for
      
      
      echo "<tr align=left><td colspan=9><b>$linhas Boletos</b> &nbsp;&nbsp;&nbsp; <b>Valor dos boletos = R$ ".number_format($valor,2,',','.')."</b></td></tr>\n";
      echo "<tr align=left><td colspan=9>";
      echo "<b>PAGO : </b><a href=# onclick=\"checkForm(true); return false\">Marcar Todos</a> &nbsp;&nbsp; <a href=# onclick=\"checkForm('frm1', 'P', false); return false\">Desmarcar Todos</a> &nbsp;&nbsp;|&nbsp;&nbsp; ";  
      echo "<b>REMESSA : </b><a href=# onclick=\"checkForm(false); return false\">Marcar Todos</a> &nbsp;&nbsp; <a href=# onclick=\"checkForm('frm1', 'R', false); return false\">Desmarcar Todos</a>";
      echo "</td></tr>\n";
      echo "</form>\n";
      echo "<tr align=left><td colspan=9>\n";
      echo "<form name=frmlistar action=?modulo=gbol&pg=boletos method=POST>\n";
      echo "<input type=hidden name=pg       value='boletos'>\n";
      echo "<input type=hidden name=op       value='L'>\n";
      echo "<input type=hidden name=pago     value='$pago'>\n";
      echo "<input type=hidden name=dataini  value='$dataini'>\n";
      echo "<input type=hidden name=datafin  value='$datafin'>\n";
      echo "<input type=hidden name=tipodata value='$tipodata'>\n";
      echo "<input type=hidden name=nome     value='$nome'>\n";
      echo "<input type=hidden name=numbol   value='$numbol'>\n";
      echo "Ordernar Por: <select name=order size=1 onChange=\"ir(document.frmlistar);\">\n";
      //if ($order == "P") { echo "<option value='P' selected>Ordenação Padrão</option>\n";   } else { echo "<option value='P'>Ordenação Padrão</option>\n";   }
      if ($order == "R") { echo "<option value='R' selected>Nome do Sacado</option>\n";     } else { echo "<option value='R'>Nome do Sacado</option>\n";     }
      if ($order == "N") { echo "<option value='N' selected>Número do Documento</option>\n";} else { echo "<option value='N'>Número do Documento</option>\n";}
      if ($order == "P") { echo "<option value='P' selected>Data de Vencimento</option>\n"; } else { echo "<option value='P'>Data de Vencimento</option>\n"; }
      if ($order == "O") { echo "<option value='O' selected>Nome do Sacado</option>\n";     } else { echo "<option value='O'>Nome do Sacado</option>\n";     }
      if ($order == "V") { echo "<option value='V' selected>Valor do Documento</option>\n"; } else { echo "<option value='V'>Valor do Documento</option>\n"; }
      echo "</select>\n";
      echo "</form>\n";
      echo "</td></tr>\n";
      echo "<tr align=left><td colspan=9>\n";
      //echo "<a href=imp_boletos.php?dataini=$dataini&datafin=$datafin&codrevenda=".$_SESSION['g_codrevenda']." target=_blank>Imprimir boletos em lote</a> &nbsp;&nbsp;&nbsp; ";
      //echo "<a href=imp_etiquetas.php?dataini=$dataini&datafin=$datafin&codrevenda=".$_SESSION['g_codrevenda']." target=_blank>Imprimir etiquetas em lote</a>";
      echo "<a href=/adm/modulos/gbol/imp_boletos.php?dataini=$dataini&datafin=$datafin&pago=$pago&nome=".urlencode($nome)."&tipodata=$tipodata&order=$order&numbol=$numbol' target=_blank>Imprimir boletos em lote</a> &nbsp;&nbsp;&nbsp; ";
      echo "<a href=/adm/modulos/gbol/imp_etiquetas.php?dataini=$dataini&datafin=$datafin&pago=$pago&nome=".urlencode($nome)."&tipodata=$tipodata&order=$order&numbol=$numbol' target=_blank>Imprimir etiquetas em lote</a> &nbsp;&nbsp;&nbsp; ";
      //echo "<a href=base.php?pg=gerar_remessa&dataini=$dataini&datafin=$datafin&pago=$pago&nome=".urlencode($nome)."&tipodata=$tipodata&order=$order&numbol=$numbol&codrevenda=".$_SESSION['g_codrevenda']."' target=_blank>Gerar arquivo remessa</a>";
      echo "</td></tr>\n";
      echo "</table>\n";
    } else { echo alerta("Nenhum boleto localizado"); }
  }
  
  echo "</div>";
?>

<style>
.form-boletos tr td{ padding-bottom:10px; }
</style>

<script type="text/javascript">
function checkForm(op){
  if(op == true){
    $('.checkbox').each(function(){
        this.checked = true;
    });
  }
  else{
     $('.checkbox').each(function(){
        this.checked = false;
    });
  }
}

function filtra_clientes(termo){
  $.ajax({
    url: "modulos/gbol/ajax_busca_cliente.php?termo="+termo,
    cache: false,
    success: function(html){
      $("#retorno_busca_cliente").html(html);
    },
  });
}
</script>