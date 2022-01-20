<?php
  error_reporting(E_ALL);
  require_once("../../../config.php");
  $notutf8 = true;
  require_once("../../../conexao.php");
  include_once("funcoes.php");
  include_once("funcoes_boletos.php");
    
  $tipo_impressao = "normal";
  $cabecalho      = "";
  $demonstrativo  = "";
  //$codigo = substr($codigo,0,-3);
  // echo "a-".$_GET['codigo'];
  if(!isset($_GET['codigo'])){ $codigo = 0; } else { $codigo = $_GET['codigo']; }
  $codigo = (($codigo / 78999) - 345699);
  settype($codigo,"float");
  $s = "select boletos.*,DATE_FORMAT(datavenci,'%d/%m/%Y') as datavencif,DATE_FORMAT(dataproc,'%d/%m/%Y') as dataprocf from boletos where codigo=$codigo";
  // echo $s;
  $result = mysql_query($s); // and registrado='S' and numremessa > 0 and numretorno > 0
  if (mysql_num_rows($result) > 0)
  { if (mysql_result($result,0,"pago") == "N")
  	{ $datavenci  = mysql_result($result,0,"datavencif");
      $dataproc   = mysql_result($result,0,"dataprocf");
      $datadoc    = $datavenci;
      $nn         = mysql_result($result,0,"numboleto");
      $valor_ori  = mysql_result($result,0,"valor");
      $valor      = number_format(mysql_result($result,0,"valor"),2,'','');
      $fvalor     = "R$ ".number_format(mysql_result($result,0,"valor"),2,',','.');
      $codcliente = mysql_result($result,0,"codcliente");
      $codrevenda = mysql_result($result,0,"codrevenda");
      //$inst1      = mysql_result($result,0,"inst1");
      //$inst2      = mysql_result($result,0,"inst2");
      $inst3      = mysql_result($result,0,"inst3");
      $inst4      = mysql_result($result,0,"inst4");
      //$inst5      = mysql_result($result,0,"inst5");
      //$inst6      = mysql_result($result,0,"inst6");
      //$inst7      = mysql_result($result,0,"inst7");
      //$registrado = mysql_result($result,0,"registrado");
      //$numremessa = mysql_result($result,0,"numremessa");
      //$numretorno = mysql_result($result,0,"numretorno");
      $status     = mysql_result($result,0,"status");
      $juros      = mysql_result($result,0,"juros");
      $multa      = mysql_result($result,0,"multa");
      $val_juros  = ($valor*(1/30))/100; //valor por dia dos juros
      $demonstrativo = "<small>".nl2br(mysql_result($result,0,"descricao"))."</small>\n";
      $result   = mysql_query("select proprietario.* from proprietario where proprietario.id=$codcliente");
      $sacado   = mysql_result($result,0,"nome");
      $endereco = mysql_result($result,0,"endereco");
      $bairro   = mysql_result($result,0,"bairro");  
      $cep      = mysql_result($result,0,"cep");
      $cidade   = mysql_result($result,0,"cidade");
      $estado   = 'SP';
      $doc      = mysql_result($result,0,"cpf");
      $pessoa   = mysql_result($result,0,"pessoa");
      if ($pessoa == "F") { $doc = formatcpf("M",$doc); } else { $doc = formatcnpj("M",$doc); }
      $result   = mysql_query("select * from dados_imobiliaria");
      $inst1    = mysql_result($result,0,'inst1');
      $inst2    = mysql_result($result,0,'inst2');
      $instrucoes = $inst1."<br>".$inst2."<br>".$inst3."<br>".$inst4;//."<br>".$inst5."<br>".$inst6."<br>".$inst7;
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
        /*$multa       = mysql_result($result,0,"multa"); $fmulta = "";
        $juros       = mysql_result($result,0,"juros"); $fjuros = "";
        if ($multa != "") { $fmulta = "Após vencimento cobrar multa de R$ ".number_format(($valor_ori*$multa),2,',','.')."<br>\n"; }
        if ($juros != "") { $fjuros = "Após vencimento cobrar juros de R$ ".number_format(($valor_ori*$juros),2,',','.')." ao dia<br>\n"; }
        if ($fmulta != "" or $fjuros != "") { $instrucoes = $fmulta.$fjuros; } else { $instrucoes = "Não receber Vencido<br>\n"; }
        */
      } else { echo "Erro. Dados para Geração de boleto não localizados"; exit(); }
      
      $s = "select dados_imobiliaria.nome, dados_imobiliaria.endereco, dados_imobiliaria.doc, dados_imobiliaria.pessoa, dados_imobiliaria.bairro, dados_imobiliaria.cep, cidade.nome as cidade from dados_imobiliaria, cidade WHERE dados_imobiliaria.id_cidade = cidade.id";
      $result = mysql_query($s);
      if (mysql_num_rows($result) > 0)
      { $cedente          = mysql_result($result,0,"nome");
        $cedente_endereco = mysql_result($result,0,"endereco");
        $cedente_doc      = mysql_result($result,0,"doc");
        $cedente_pessoa   = mysql_result($result,0,"pessoa");
        $cedente_cidade   = mysql_result($result,0,"cidade");
        $cedente_bairro   = mysql_result($result,0,"bairro");
        $cedente_cep      = mysql_result($result,0,"cep");
        if ($cedente_pessoa == "F") { $cedente_doc = formatcpf("M",$cedente_doc); } else { $cedente_doc = formatcnpj("M",$cedente_doc); }
        if ($cedente_pessoa == "F") { $f_cedente = $cedente . ' - CPF: '. formatcpf("M",$cedente_doc); } else { $f_cedente = $cedente . ' - CNPJ: ' .formatcnpj("M",$cedente_doc); }
        $f_cedente_endereco = $cedente_endereco . ' - ' . $cedente_bairro . ' - ' . $cedente_cidade . ' - ' . $cedente_cep;
      } else { echo "Erro. Cedente não localizado"; exit(); }
      //if ($registrado == 'S' and ($numremessa == 0 or $numretorno == 0)) { echo "Este boleto é com registro, mas não parece estar inserido no sistema bancário"; exit(); }
      if ($status == 1 or $status == 2 or $status == 3 or $status == 5) { echo "Este boleto é com registro, mas não parece estar inserido no sistema bancário"; exit(); }
      require("funcoes_$cb.php");
    } else { $cabecalho = "ESSE BOLETO CONSTA COMO PAGO !"; }
  } else { $cabecalho = "BOLETO NÃO LOCALIZADO"; }
  if ($cabecalho == "")
  {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1" http-equiv="content-type">
  <title>Boleto</title>
  <link href="estilos_boletos.css" rel="stylesheet" type="text/css">
  <script language="javascript"><!--
var w=0;
var h=0;
function resize(largura,altura) {
  if (navigator.appName == 'Netscape') { w=30; h=60; } else { w=30; h=70; }
  window.resizeTo(largura+w , altura+h);
  self.focus();
}
function PrintPage() { if (window.print) window.print(); else alert("O script não conseguiu enviar o documento diretamente para impressão,Pressione Ctrl+P ou selecione Imprimir no menu Arquivo para imprimir esta página."); }
//--></script>
</head>
<body onload="resize(680,600);PrintPage();">

<table width="645" border="0" cellpadding="0" cellspacing="0" style="border:0px;">
<tr>
<td align="left"  style="border:0px;" valign="bottom" width="150">
  <?php 
    $notutf8 = true;
    $s = "SELECT logo_boleto FROM dados_imobiliaria";
    $q = mysql_query($s);
    $r = mysql_fetch_assoc($q);
    $logo_boleto = $r['logo_boleto'];
    if (file_exists("../../../clientes/".DIRETORIO."/assets/img/".$logo_boleto))
    { echo "<img src=/clientes/".DIRETORIO."/assets/img/".$logo_boleto." style='width:100%;max-height:120px;'>"; } else { echo "<img src=trans.gif width=200 height=100>"; }
  ?>
</td>
<!-- <td align="left" style="border:0px;" class="info" valign="bottom"><br><br><br><br><br><br><br><br>HOSPEDARIA - Hospedagem & Sistemas para internet <br> http://www.hospedaria.com.br </td> -->
<td align="right" style="border:0px;" valign="bottom"><span class="info">&nbsp;<br><br><br><br><br><br><br><br><br></span>VIA PAGADOR</td>
</tr>
</table>

<table width="645" border="0" cellpadding="0" cellspacing="0" align="left" style="border:0px;">
<tr><td style="border:0px;">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" align="left">  
   <tr>
    <td colspan="5" valign="top" align="left">Local de Pagamento<br><span class="linha">Pagavél em qualquer banco até o vencimento</span></td>
    <td valign="top" align="left">Vencimento<br><div align="right" class="linha"><?php echo $datavenci; ?>&nbsp;</div></td>
   </tr>
   <tr>
    <td colspan="5" valign="top" align="left">Beneficiário<br><span class="linha"><?php echo $f_cedente,'<br>',$f_cedente_endereco; ?></span></td>
    <td valign="top" align="left">Agência / Código Beneficiário<br><div align="right" class="linha"><?php echo "$ag_cc"; ?>&nbsp;</div></td>
   </tr>
   <tr>
    <td valign="top" align="left">Data Documento<br><div align="center" class="linha"><?php echo $datadoc; ?></div></td>
    <td valign="top" align="left">Número Documento<br><div align="center" class="linha"><?php echo $nn_formatado; ?></div></td>
    <td valign="top" align="left">Espécie Documento<br><div align="center" class="linha"><?php echo $espdoc; ?></div></td>
    <td valign="top" align="left">Aceite<br><div align="center" class="linha"><?php echo $aceite; ?></div></td>
    <td valign="top" align="left">Data Processamento<br><div align="center" class="linha"><?php echo $dataproc; ?></div></td>
    <td valign="top" align="left">Nosso Número<br><div align="right" class="linha"><?php echo $nn_formatado; ?>&nbsp;</div></td>
   </tr>
   <tr>
    <!-- <td valign="top" align="left">Uso Banco<br><div align="center" class="linha"><?php echo $usobanco; ?></div></td> -->
    <td valign="top" align="left" colspan="2">Carteira<br><div align="center" class="linha"><?php echo $carteira; ?></div></td>
    <td valign="top" align="left">Espécie<br><div align="center" class="linha"><?php echo $especie; ?></div></td>
    <td valign="top" align="left">Quantidade<br></td>
    <td valign="top" align="left">Valor<br></td>
    <td valign="top" align="left">Valor do Documento<br><div align="right" class="linha"><?php echo $fvalor; ?>&nbsp;</div></td>
   </tr>
   <tr>
    <td colspan="6" rowspan="1" valign="top" align="left">Pagador<br><span class="linha">
      <?php echo "&nbsp;".str_replace("#","&nbsp;",str_pad($sacado, 108, "#")).$doc."<br>";
            echo "&nbsp;".str_replace("#","&nbsp;",str_pad($endereco, 98, "#")).$bairro."<br>";
            echo "&nbsp;".str_replace("#","&nbsp;",str_pad($cep, 20, "#"));
            echo "&nbsp;".str_replace("#","&nbsp;",str_pad($cidade, 30, "#")).$estado;            
      ?></span>
    </td>
   </tr>
   <tr height="130"><td colspan="6" valign="top" align="left">Demonstrativo<br><span class="linha"><?php echo $demonstrativo; ?></span></td></tr>   
  </table>
</td></tr>
<tr><td align="right" style="border:0px;" class="info">Autenticação Mecânica&nbsp;</td></tr>
<tr><td align="right" style="border:0px;" class="info">&nbsp;<br>&nbsp;<br>&nbsp;<br></td></tr>
<tr><td align="left" style="border:0px;" class="info">------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ Corte Aqui ------------------------</td></tr>

<tr><td align="left" valign="bottom" style="border:0px;" class="linha">
    <img src="bancos/<?php echo $cb; ?>.JPG">  
    <img src="p.gif" width="2" height="25">
    <span style="font-size: 20px; font-weight: bold;"><?php echo $banco_formatado; ?></span>
    <img src="p.gif" width="2" height="25">
    <span style="font-size: 14px;">&nbsp;&nbsp;<?php echo $linhadigi; ?></span>
</td></tr>
<tr><td style="border:0px;">
  <table width="100%" border="1" cellpadding="0" cellspacing="0" align="left">  
   <tr>
    <td colspan="5" valign="top" align="left">Local de Pagamento<br><span class="linha">Pagavél em qualquer banco até o vencimento</span></td>
    <td valign="top" align="left">Vencimento<br><div align="right" class="linha"><?php echo $datavenci; ?>&nbsp;</div></td>
   </tr>
   <tr>
    <td colspan="5" valign="top" align="left">Beneficiário<br><span class="linha"><?php echo $f_cedente,'<br>',$f_cedente_endereco; ?></span></td>
    <td valign="top" align="left">Agência / Código Beneficiário<br><div align="right" class="linha"><?php echo "$ag_cc"; ?>&nbsp;</div></td>
   </tr>
   <tr>
    <td valign="top" align="left">Data Documento<br><div align="center" class="linha"><?php echo $datadoc; ?></div></td>
    <td valign="top" align="left">Número Documento<br><div align="center" class="linha"><?php echo $nn_formatado; ?></div></td>
    <td valign="top" align="left">Espécie Documento<br><div align="center" class="linha"><?php echo $espdoc; ?></div></td>
    <td valign="top" align="left">Aceite<br><div align="center" class="linha"><?php echo $aceite; ?></div></td>
    <td valign="top" align="left">Data Processamento<br><div align="center" class="linha"><?php echo $dataproc; ?></div></td>
    <td valign="top" align="left">Nosso Número<br><div align="right" class="linha"><?php echo $nn_formatado; ?>&nbsp;</div></td>
   </tr>
   <tr>
    <td valign="top" align="left">Uso Banco<br><div align="center" class="linha"><?php echo $usobanco; ?></div></td>
    <td valign="top" align="left">Carteira<br><div align="center" class="linha"><?php echo $carteira; ?></div></td>
    <td valign="top" align="left">Espécie<br><div align="center" class="linha"><?php echo $especi; ?></div></td>
    <td valign="top" align="left">Quantidade<br></td>
    <td valign="top" align="left">Valor<br></td>
    <td valign="top" align="left">Valor do Documento<br><div align="right" class="linha"><?php echo $fvalor; ?>&nbsp;</div></td>
   </tr>
   <tr>
    <td colspan="5" rowspan="4" valign="top" align="left">Instruções ( texto de responsabilidade do beneficiário )<br><span class="linha"><?php echo $instrucoes; ?></span></td>
    <td valign="top" align="left">(+) Outros Acr&eacute;scimos<br>&nbsp;</td>
   </tr>
   <tr><td valign="top" align="left">(-) Descontos / Abatimentos<br>&nbsp;</td></tr>
   <tr><td valign="top" align="left">(+) Mora / Multa<br>&nbsp;</td></tr>
   <tr><td valign="top" align="left">(=) Valor Cobrado<br>&nbsp;</td></tr>
   <tr>
    <td colspan="6" rowspan="1" valign="top" align="left">Pagador<br><span class="linha">
      <?php echo "&nbsp;".str_replace("#","&nbsp;",str_pad($sacado, 108, "#")).$doc."<br>";
            echo "&nbsp;".str_replace("#","&nbsp;",str_pad($endereco, 98, "#")).$bairro."<br>";
            echo "&nbsp;".str_replace("#","&nbsp;",str_pad($cep, 20, "#"));
            echo "&nbsp;".str_replace("#","&nbsp;",str_pad($cidade, 30, "#")).$estado;            
      ?></span>
    </td>
   </tr>  
  </table>
</td></tr>
<tr><td align="right" style="border:0px;" class="info">Autenticação Mecânica / Ficha de Compensação</td></tr>
<tr><td style="border:0px;"><?php echo $codbarras; ?></td></tr>
</table>

</body>
</html>
<?php
  } else
  {
  ?>
 	 <?php readfile("header.html"); ?>
   <body>
   <?php readfile("topo.html"); ?>  
   <table width="980" height="200" border="0" align="center" cellpadding="15" cellspacing="0">
   <tr><td align="center" bgcolor="#F0F0F0"><h4><?php echo $cabecalho; ?></h4></td></tr>
   </table>   
   <?php readfile("rodape.html"); ?>
   </body>
   </html>
   <?php
  }
?>
