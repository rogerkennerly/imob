<?php //require("protecao.php"); ?>
<?php
  require_once("../../../config.php");
  $notutf8 = true;
  require_once("../../../conexao.php");
  include_once("funcoes.php");
  define('FPDF_FONTPATH','class_fpdf/font/');
	require("class_fpdf/fpdf.php");
  include("funcoes_boletos.php");
  $tipo_impressao = "pdf";
  
  $result = mysql_query("select * from confboletos");
  if (mysql_num_rows($result) > 0)
  { $cb          = mysql_result($result,0,"codigobanco");
    $ag          = mysql_result($result,0,"ag");
    $digag       = mysql_result($result,0,"digag");
    $cc          = mysql_result($result,0,"cc");
    $cc1         = mysql_result($result,0,"cc1");
    $digcc       = mysql_result($result,0,"digcc");
    $carteira    = mysql_result($result,0,"carteira");
    $convenio    = mysql_result($result,0,"convenio");
    $multa       = mysql_result($result,0,"multa");
    $juros       = mysql_result($result,0,"juros");
  } else { echo "Erro. Dados para Geração de boleto não localizados"; exit(); }
  $result = mysql_query("select nome from dados_imobiliaria");
  if (mysql_num_rows($result) > 0)
  { $cedente = mysql_result($result,0,"nome");
  } else { echo "Erro. Cedente não localizado"; exit(); }
  
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
      if (strlen($nome) > 0) { $vnome = "and clientes.nome like '$nome%'"; }
      $vpago = "and boletos.pago='$pago'";
    }
  }
  $sql = "select boletos.*,proprietario.nome,DATE_FORMAT(boletos.datavenci,'%d/%m/%Y') as datavencif,DATE_FORMAT(boletos.dataproc,'%d/%m/%Y') as dataprocf from boletos,proprietario where proprietario.id=boletos.codcliente $vdata $vnome $vnumbol $vpago $buscacli order by boletos.codcliente";
  $result = mysql_query($sql);
  $linhas = mysql_num_rows($result);
  if ($linhas > 0)
  { $pdf=new FPDF('P','mm','A4');
	  $pdf->SetMargins(15,10);
	  $pdf->SetAuthor('Digital Masters Studio');
    $pdf->SetTitle('Documento gerado com FPDF');
  	for ($k = 0; $k < $linhas; $k++)
    { if ((mysql_result($result,$k,'registrado') == 'S' and mysql_result($result,$k,'numremessa') > 0 and mysql_result($result,$k,'numretorno') > 0) or (mysql_result($result,$k,'registrado') == 'N'))
      { $codigo     = mysql_result($result,$k,"codigo");
        $datavenci  = mysql_result($result,$k,"datavencif");
        $dataproc   = mysql_result($result,$k,"dataprocf");
        $datadoc    = $datavenci;
        $nn         = mysql_result($result,$k,"numboleto");
        $valor_ori  = mysql_result($result,$k,"valor");
        $valor      = number_format(mysql_result($result,$k,"valor"),2,'','');
        $fvalor     = "R$ ".number_format(mysql_result($result,$k,"valor"),2,',','.');
        $codcliente = mysql_result($result,$k,"codcliente");
        $codrevenda = mysql_result($result,$k,"codrevenda");
        $inst1      = mysql_result($result,$k,"inst1");
        $inst2      = mysql_result($result,$k,"inst2");
        $inst3      = mysql_result($result,$k,"inst3");
        $inst4      = mysql_result($result,$k,"inst4");
        $inst5      = mysql_result($result,$k,"inst5");
        $inst6      = mysql_result($result,$k,"inst6");
        $inst7      = mysql_result($result,$k,"inst7");
        $instrucoes = $inst1."<br>".$inst2."<br>".$inst3."<br>".$inst4."<br>".$inst5."<br>".$inst6."<br>".$inst7;
        $demonstrativo = nl2br(mysql_result($result,$k,"descricao"));
        $demonstrativo = str_replace("<br>", "#", $demonstrativo);
        $demonstrativo = str_replace("<br />", "#", $demonstrativo);
        $result2  = mysql_query("select proprietario.* from proprietario where proprietario.id=$codcliente");
        if (mysql_num_rows($result2) > 0)
        { $sacado   = mysql_result($result2,0,"nome");
          $endereco = mysql_result($result2,0,"endereco");
          $bairro   = mysql_result($result2,0,"bairro");  
          $cep      = mysql_result($result2,0,"cep");
          $cidade   = mysql_result($result2,0,"cidade");
          $estado   = mysql_result($result2,0,"estado");
          $cpf      = mysql_result($result2,0,"cpf");
          $pessoa   = mysql_result($result2,0,"pessoa");
          $doc = formatcpf("M",$cpf);
          // if ($pessoa == "F") { $doc = formatcpf("M",$doc); } else { $doc = formatcnpj("M",$doc); }
        } else { echo "Erro. Cliente não localizado"; exit(); }
        //$inst1 = ""; $inst2 = ""; $inst3 = ""; $inst4 = ""; $inst5 = ""; $inst6 = ""; $inst7 = "";
        //if ($multa != "") { $inst1 = "Após vencimento cobrar multa de R$ ".number_format(($valor_ori*$multa),2,',','.'); }
        //if ($juros != "") { $inst2 = "Após vencimento cobrar juros de R$ ".number_format(($valor_ori*$juros),2,',','.')." ao dia"; }
        //if ($inst1 == "" and $inst2 == "") { $inst1 = "Não receber Vencido<br>\n"; }
        $linha1 = $sacado  ."         ".$doc;
        $linha2 = $endereco."         ".$bairro;
        $linha3 = $cep     ."         ".$cidade."         ".$estado;
        include("funcoes_$cb.php");
        // $imagem = "logos/".$_SESSION['g_codrevenda'].".jpg";
        
        $dados = mysql_query("SELECT logo_boleto FROM dados_imobiliaria");
        $dados = mysql_fetch_assoc($dados);
        if($dados['logo_boleto']){
          $logo = $dados['logo_boleto'];
        }else{
          $logo = "logo.png";
        }
        $imagem = "../../../clientes/".DIRETORIO."/assets/img/$logo";
        $tamanho = getimagesize($imagem);
        // echo "<pre>";var_dump($tamanho);echo "</pre>";
        // echo $tamanho[0] / 6;
        
        $pdf->AddPage();
        $pdf->SetAutoPageBreak('auto', 1);
        //$pdf->Image('logos/'.$_SESSION['g_codrevenda'].'.jpg',15,10,39);
        $pdf->Image($imagem,15, 10, 'auto', 19, 'JPG');//parametros: 1. imagem - 2. posicao X - 3. posicao Y - 4. width - 5. height - 6. formato
        $pdf->Image("bancos/$cb.JPG",15, 145, 33);
        $pdf->Rect(60,145,".35","8","F");
        $pdf->SetFont('Times', 'B', 18);
        $pdf->Rect(77,145,".28","8","F");
        $pdf->SetXY(60, 150 ); $pdf->Write(0.1,$banco_formatado);
        
        $pdf->SetFont('Times', 'B', 8);
        $pdf->SetXY(170, 28 ); $pdf->Write(0.1,'Recibo do Pagador');
        $pdf->SetFont('Times', '', 6);
        $pdf->SetXY(14 , 31 ); $pdf->Write(0.1,'Beneficiário');
        $pdf->SetXY(104, 31 ); $pdf->Write(0.1,'Agência / Código Beneficiário');
        $pdf->SetXY(134, 31 ); $pdf->Write(0.1,'Data Documento');
        $pdf->SetXY(164, 31 ); $pdf->Write(0.1,'Data de Vencimento');
        $pdf->SetXY(14 , 38 ); $pdf->Write(0.1,'Pagador');
        $pdf->SetXY(104, 38 ); $pdf->Write(0.1,'Data Emissão');
        $pdf->SetXY(134, 38 ); $pdf->Write(0.1,'Nosso Número');
        $pdf->SetXY(164, 38 ); $pdf->Write(0.1,'Valor Documento');
        $pdf->SetXY(14 , 45 ); $pdf->Write(0.1,'Demonstrativo');
        $pdf->SetXY(170, 125); $pdf->Write(0.1,'Autenticação Mecânica');
        $pdf->SetXY(14 , 140); $pdf->Write(0.1,'-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------Corte-Aqui------------------------------------------------------------');    
       
        $pdf->SetXY(14 , 155); $pdf->Write(0.1,'Local de Pagamento');    
        $pdf->SetXY(154, 155); $pdf->Write(0.1,'Data de Vencimento');
        $pdf->SetXY(14 , 162); $pdf->Write(0.1,'Beneficiário');
        $pdf->SetXY(154, 162); $pdf->Write(0.1,'Agência / Código');
        
        $pdf->SetXY(14 , 169); $pdf->Write(0.1,'Data Documento');
        $pdf->SetXY(46 , 169); $pdf->Write(0.1,'Número Documento');
        $pdf->SetXY(78 , 169); $pdf->Write(0.1,'Espécie Documento');
        $pdf->SetXY(104, 169); $pdf->Write(0.1,'Aceite');
        $pdf->SetXY(122, 169); $pdf->Write(0.1,'Data Processamento');
        $pdf->SetXY(154, 169); $pdf->Write(0.1,'Nosso Número');
        $pdf->SetXY(14 , 176); $pdf->Write(0.1,'Uso Banco');
        $pdf->SetXY(46 , 176); $pdf->Write(0.1,'Carteira');
        $pdf->SetXY(78 , 176); $pdf->Write(0.1,'Espécie');
        $pdf->SetXY(104, 176); $pdf->Write(0.1,'Quantidade');
        $pdf->SetXY(122, 176); $pdf->Write(0.1,'Valor');
        $pdf->SetXY(154, 176); $pdf->Write(0.1,'Valor Documento');
        
        $pdf->SetXY(14 , 183); $pdf->Write(0.1,'Instruções');
        $pdf->SetXY(154, 183); $pdf->Write(0.1,'(+) Outros Acréscimos');
        $pdf->SetXY(154, 190); $pdf->Write(0.1,'(+) Mora / Multa');
        $pdf->SetXY(154, 197); $pdf->Write(0.1,'(-) Descontos / Abatimentos');
        $pdf->SetXY(154, 204); $pdf->Write(0.1,'(-) Outras Deduções');
        $pdf->SetXY(154, 211); $pdf->Write(0.1,'(=) Valor Cobrado');
        $pdf->SetXY(14 , 218); $pdf->Write(0.1,'Pagador');
        
        $pdf->SetFont('Times', '', 10);
        $demo = explode("#",wordwrap($demonstrativo,120,"#",1));
        $y = 48; $tot = count($demo);
        for ($i = 0; $i < $tot; $i++)
        { $pdf->SetXY(15 , $y); $pdf->Write(0.1,$demo[$i]); $y += 4;
        }      
        
        $y = 186;
        $pdf->SetFont('Times', '', 10);
        $pdf->SetXY(15 , $y); $pdf->Write(0.1,$inst1); $y += 4;
        $pdf->SetXY(15 , $y); $pdf->Write(0.1,$inst2); $y += 4;
        $pdf->SetXY(15 , $y); $pdf->Write(0.1,$inst3); $y += 4;
        $pdf->SetXY(15 , $y); $pdf->Write(0.1,$inst4); $y += 4;
        $pdf->SetXY(15 , $y); $pdf->Write(0.1,$inst5); $y += 4;
        $pdf->SetXY(15 , $y); $pdf->Write(0.1,$inst6); $y += 4;
        $pdf->SetXY(15 , $y); $pdf->Write(0.1,$inst7); $y += 4;      
        $y += 4; $y += 4;
        $pdf->SetXY(15 , $y); $pdf->Write(0.1,$linha1); $y += 4;
        $pdf->SetXY(15 , $y); $pdf->Write(0.1,$linha2); $y += 4;
        $pdf->SetXY(15 , $y); $pdf->Write(0.1,$linha3); $y += 4;
        
        $pdf->SetFont('Times', '', 12);
        $pdf->SetXY(85 , 151); $pdf->Write(0.1,$linhadigi);
        
        $pdf->SetXY(15, 30);
        $pdf->SetFont('Times', '', 10);
        $pdf->Cell(90, 7, $cedente , 1, 0, 'L');
        $pdf->Cell(30, 7, $ag_cc , 1, 0, 'C');
        $pdf->Cell(30, 7, $datadoc , 1, 0, 'C');
        $pdf->Cell(30, 7, $datavenci , 1, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(90, 7, $sacado , 1, 0, 'L');
        $pdf->Cell(30, 7, $dataproc , 1, 0, 'C');
        $pdf->Cell(30, 7, $nn , 1, 0, 'C');
        $pdf->Cell(30, 7, $fvalor , 1, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(180, 80, '' , 1, 0, 'L');
        $pdf->Ln();
        
        $pdf->Cell(180, 30, '' , 0, 0, 'L'); //espaço entre os comprovantes
        $pdf->Ln();
        
        $pdf->Cell(140, 7, 'Até o vencimento pagável em qualquer banco do sistema de compensação' , 1, 0, 'L');
        $pdf->Cell(40 , 7, $datavenci , 1, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(140, 7, $cedente , 1, 0, 'L');
        $pdf->Cell(40 , 7, $ag_cc , 1, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(32 , 7, $datadoc , 1, 0, 'C');
        $pdf->Cell(32 , 7, $nn , 1, 0, 'C');
        $pdf->Cell(26 , 7, $espdoc , 1, 0, 'C');
        $pdf->Cell(18 , 7, $aceite , 1, 0, 'C');
        $pdf->Cell(32 , 7, $dataproc , 1, 0, 'C');
        $pdf->Cell(40 , 7, $nn_formatado , 1, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(32 , 7, '' , 1, 0, 'L');
        $pdf->Cell(32 , 7, $carteira , 1, 0, 'C');
        $pdf->Cell(26 , 7, $especi , 1, 0, 'C');
        $pdf->Cell(18 , 7, '' , 1, 0, 'L');
        $pdf->Cell(32 , 7, '' , 1, 0, 'L');
        $pdf->Cell(40 , 7, $fvalor , 1, 0, 'C');
        $pdf->Ln();
        $pdf->Cell(140,35, '' , 1, 0, 'L');
        $pdf->Cell(40 , 7, '' , 1, 0, 'L');
        $pdf->SetXY(155, 189); $pdf->Cell(40 , 7, '' , 1, 0, 'L');
        $pdf->SetXY(155, 196); $pdf->Cell(40 , 7, '' , 1, 0, 'L');
        $pdf->SetXY(155, 203); $pdf->Cell(40 , 7, '' , 1, 0, 'L');
        $pdf->SetXY(155, 210); $pdf->Cell(40 , 7, '' , 1, 0, 'L');
        $pdf->Ln();  
        $pdf->Cell(180, 20, '' , 1, 0, 'L');	// célula do sacado
        $x = 15;
        $y = 240;
        $w = 0.277;
        $h = 14;
        $ret = $codbarras;
        $tot = count($ret["b"]);
        for ($i = 0; $i < $tot; $i++)
        { //$this->Rect($x+$i*$w,$y,$w,$h,'F');
          $L = $ret["p"][$i] * $w;
          $pdf->Rect($x,$y,$L,$h,"F");
          $x += $L + ($ret["b"][$i] * $w);
        }
        $pdf->Rect($x,$y,($w*$ret["p"][$i]),$h,"F");
      }
    }
    $s = $pdf->Output();
	  //$len = strlen($s);
	  Header("Content-Type: application/pdf");
	  //header("Content-Length: $len");
    print $s;
  }
?>