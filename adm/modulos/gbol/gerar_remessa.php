<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
  include("funcoes_boletos.php");
  $result = mysql_query("select * from confboletos where codrevenda=".$_SESSION['g_codrevenda']);
	$rc = mysql_fetch_assoc($result);
	$codrevenda 					 = $rc['codrevenda'];
	$codigobanco 					 = $rc['codigobanco'];
	$agencia_remetente 		 = $rc['ag']; 
	$agencia_dig_remetente = $rc['digag']; 
	$conta_remetente 			 = $rc['cc']; 
	$conta_dig_remetente   = $rc['digcc']; 
  
  if ($_SESSION['g_codrevenda'] == 1105) //Comercial Roda D' Água
  { $codtransmissao        = '000000000000000'; //agencia com 4 digitos + conta corrente com 10 dígitos + dígito da conta corrente
    $numinscricaoempresa   = '000000000000000'; //obrigatoriamente 15 dígitos usar cpf/cnpj só com números
    $conta_remetente       = '000000000';       //diferente da conta corrente do boleto
    $conta_dig_remetente   = '0';               //diferente da conta corrente do boleto
  }
  if ($_SESSION['g_codrevenda'] == 1106) //Imobiliária Barros
  { $codtransmissao        = '000000000000000'; //agencia com 4 digitos + conta corrente com 10 dígitos + dígito da conta corrente
    $numinscricaoempresa   = '000000000000000'; //obrigatoriamente 15 dígitos usar cpf/cnpj só com números
    $conta_remetente       = '000000000';       //diferente da conta corrente do boleto
    $conta_dig_remetente   = '0';               //diferente da conta corrente do boleto
  }
  if ($_SESSION['g_codrevenda'] == 1119) //ELITON FERNANDO MUSSI BARROS
  { $codtransmissao        = '342300006048323'; //agencia com 4 digitos + conta corrente com 10 dígitos + dígito da conta corrente
    $numinscricaoempresa   = '000025390640861'; //obrigatoriamente 15 dígitos usar cpf/cnpj só com números
    $conta_remetente       = '001081421';       //antes estava 604832000 porque era baseado na conta corrente
    $conta_dig_remetente   = '1';               // antes estava 3 porque era baseado na conta corrente
  }
  
  $rev = mysql_query("select * from revendas WHERE CODIGO = ".$_SESSION['g_codrevenda']);
	$reve = mysql_fetch_assoc($rev);
	if($reve['PESSOA'] == 'J'){$tipo_pessoa = 2; }else{$tipo_pessoa = 1;}
	$cpf_cnpj 	= $reve['DOC'];
	$nome_razao = $reve['RAZAO'];
  $mensagem1  = $reve['INST1']; //'APÓS VENCIMENTO MULTA DE 10%';              // (40 caracteres)
  $mensagem2  = $reve['INST2']; //'ESTE BOLETO NÃO QUITA DÉBITOS ANTERIORES';  //APÓS VENCIMENTO JUROS DE 1% AO MÊS (40 caracteres)
  /*
  if (!isset($_GET['pago']))        { $pago        = ""; } else { $pago        = $_GET['pago']; }
  if (!isset($_GET['tipodata']))    { $tipodata    = ""; } else { $tipodata    = $_GET['tipodata']; }
  if (!isset($_GET['nome']))        { $nome        = ""; } else { $nome        = $_GET['nome']; }
  if (!isset($_GET['buscacodcli'])) { $buscacodcli = 0;  } else { $buscacodcli = $_GET['buscacodcli']; settype($buscacodcli,"integer"); }
  if (!isset($_GET['dataini']))     { $dataini     = ""; } else { $dataini     = $_GET['dataini']; }
  if (!isset($_GET['datafin']))     { $datafin     = ""; } else { $datafin     = $_GET['datafin']; }
  if ($dataini != "") { $d = explode("/",$dataini); if (checkdate($d[1],$d[0],$d[2])) { $vdataini = $d[2]."/".$d[1]."/".$d[0]; } else { $vdataini = ""; } } else { $vdataini = ""; }
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
    { $vpago = "and boletos.pago='N'"; $vdata = ""; } 
    else
    { if ($tipodata == ""){ $tipodata = "boletos.datavenci"; }
    	if ($vdataini != "" and $vdatafin != "") { $vdata = "and $tipodata between '$vdataini' and '$vdatafin'"; }
      if (strlen($nome) > 0) { $vnome = "and clientes.razao like '$nome%'"; }
      $vpago = "and boletos.pago='$pago'";
    }
  }
  */
  //$sql = "select boletos.codcliente from boletos,clientes where clientes.codigo=boletos.codcliente and clientes.codrevenda=".$_SESSION['g_codrevenda']." $vdata $vnome $vnumbol $vpago $buscacli order by clientes.razao"; //codcliente
  //$result = mysql_query($sql);
  //if (!$result) { $linhhas = 0; echo "Nenhum boleto localizado para imprimir etiquetas"; exit(); } else { $linhas = mysql_num_rows($result); }
  //echo $sql; exit();
  include('banco_'.$codigobanco.'/remessa.php');
?>