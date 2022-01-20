<?php //require("protecao.php"); ?>
<?php
  require_once("../../../config.php");
  $notutf8 = true;
  require_once("../../../conexao.php");
  include_once("funcoes.php");
  define('FPDF_FONTPATH','class_fpdf/font/');
	require("class_fpdf/fpdf.php");
  
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
      if (strlen($nome) > 0) { $vnome = "and proprietario.nome like '$nome%'"; }
      $vpago = "and boletos.pago='$pago'";
    }
  }
  $sql = "select boletos.codcliente from boletos,proprietario where proprietario.id=boletos.codcliente $vdata $vnome $vnumbol $vpago $buscacli order by proprietario.nome"; //codcliente
  $result = mysql_query($sql);
  //$result = mysql_query("select codcliente from boletos where datavenci between '".ajustardata("B",$dataini)."' and '".ajustardata("B",$datafin)."' and pago='N' and codrevenda=".$_SESSION['g_codrevenda']." order by codcliente");
  if (!$result) { $linhhas = 0; echo "Nenhum boleto localizado para imprimir etiquetas"; exit(); } else { $linhas = mysql_num_rows($result); }
  //echo $sql; exit();
  if ($linhas > 0)
  { $dimensao = array();
    $dimensao[0]=210;
    $dimensao[1]=315;
    $pdf=new FPDF('P','mm',$dimensao);
	  $pdf->SetAuthor('Hospedaria Internet - Rafael');
    $pdf->SetTitle('Impressor de Etiquetas - Gerado com FPDF');
    $pdf->SetFont('Times', '', 12);
    $pdf->AddPage();
    $x = 5;
    $y = 6;
  	for ($k = 0; $k < $linhas; $k++)
    { $codcliente = mysql_result($result,$k,"codcliente");
    	$result2  = mysql_query("select proprietario.* from proprietario where proprietario.id=$codcliente");
      if (mysql_num_rows($result2) > 0)
      { $sacado   = mysql_result($result2,0,"nome");
        $endereco = mysql_result($result2,0,"endereco");
        $bairro   = mysql_result($result2,0,"bairro");  
        $cep      = mysql_result($result2,0,"cep");
        $cidade   = mysql_result($result2,0,"cidade");
        $estado   = mysql_result($result2,0,"estado");
      } else { echo "Erro. Cliente não localizado"; exit(); }
    	$sacado     = firstupper(minuscula(strtolower($sacado)));
      $endereco   = firstupper(minuscula(strtolower($endereco)));
      $cep        = $cep;
      $bairro     = firstupper(minuscula(strtolower($bairro)));
      $cidade     = firstupper(minuscula(strtolower($cidade)));
      $estado     = $estado;
      $pdf->Text($x, $y, $sacado);   $y += 4;
      $pdf->Text($x, $y, $endereco); $y += 4;
      $pdf->Text($x, $y, $bairro);
      $pdf->Text($x+60, $y, $cidade); 
      $pdf->Text($x+105,$y, $estado); 
      $y += 4;
      $pdf->Text($x, $y, $cep); $y += 4;
      $y += 12.5;
      if (($k+1)%11 == 0 and $k > 0 and ($k+1) < $linhas)
      { $pdf->AddPage();
        $y = 6;
      }
    }
    $s = $pdf->Output();
	  //$len = strlen($s);
	  Header("Content-Type: application/pdf");
	  //header("Content-Length: $len");
    print $s;
  }
?>