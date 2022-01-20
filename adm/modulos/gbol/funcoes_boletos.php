<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php // ------ FUNÇÕES PARA BOLETOS ------
$pesos    = array ("2","1","2","1","2","1","2","1","2","1","2","1","2","1","2","1","2","1","2","1","2","1","2","1","2","1","2","1","2","1");
$pesos2   = array ("2","3","4","5","6","7","8","9","2","3","4","5","6","7","8","9","2","3","4","5","6","7","8","9","2","3","4","5","6","7","8","9","2","3","4","5","6","7","8","9","2","3","4","5","6","7","8","9","2","3","4","5","6","7","8","9");
$especi   = "R$";  // espécie
$aceite   = "N";   // aceite  
$mo       = "9";   // moeda
//-------- DADOS ATUAIS PARA UTILIZAR COM O BANCO REAL --------
  //Cedente: Rafael Goulart de Matos
  //$carteira = "57";   // carteira
  //$espdoc   = "DUP";
  //$ag = "0425"; // agencia
  //$cc = "6042744"; // conta corrente // 7 dígitos  
  //$cb = "356"; // aqui eu estou selecionando o banco
  //$cedente = "Crysval Calçados e Acessórios"; // Nome do Cedente
  //$doc_cedente = "03.745.250/0001-49"; // documento do cedente
  //$usobanco = ""; // até agora só o unibano usa isso.

function fatordevencimento($datavenci) {
  // cálculo do fator de vencimento ( 4 posicoes )
  $diabase = 729669; // referente a 07/10/1997
  $fv = 0; $msg = "";
  $vardatavenci = $datavenci[6].$datavenci[7].$datavenci[8].$datavenci[9]."/".$datavenci[3].$datavenci[4]."/".$datavenci[0].$datavenci[1];
  if (strlen($datavenci) != 10) { $msg = "data inválida"; } 
  else
  { require("conexao.php");
  	$result = mysql_query("select TO_DAYS('".$vardatavenci."') as dias");
    $dias = mysql_result($result,0,"dias");
    if ($dias <= $diabase) { $msg = "data de vencimento menor que 07/10/1997"; }
    else { $fv = ($dias - $diabase); }
  }
  return $fv.":".$msg;
}

function modulo10($linha) {
	global $pesos;
	$linha = strrev($linha);
	$soma  = 0;
  for ($i = 0; $i < strlen($linha); $i++)
  { $calc = $linha[$i] * $pesos[$i];
    if ($calc > 9) 
    { settype($calc,"string");
    	$calc = $calc[0] + $calc[1]; 
    }
    $soma = $soma + $calc;    
  }  
  $digitao = (10 - ($soma % 10));  
  if ($digitao == 10) { $digitao = 0; }  
  return $digitao;  
}

function modulo11($linha) {
	global $pesos2; $linha = strrev($linha); $soma = 0;
  for ($i = 0; $i < strlen($linha); $i++)
  { $calc = $linha[$i] * $pesos2[$i];    
    $soma = $soma + $calc;    
  }
  $digitao = (11 - ($soma % 11));
  if ($digitao > 9) { $digitao = 0; }
  return $digitao;
}

function modulo11_033($linha) {
  $linha = strrev($linha);
  $peso  = 2;
  $base  = 7;
  $soma  = 0;
  for ($i = 0; $i < strlen($linha); $i++)
  { $soma += ($linha[$i] * $peso);
    if ($peso < $base) { $peso++; } else { $peso = 2; }
  }
  $resto = ($soma % 11);
  return $resto;
}

function montalinhadigitavel($cod)
{
	$p1 = substr($cod,0,4);
	$p2 = substr($cod,19,5);
	$p3 = modulo10($p1.$p2);
	$p4 = $p1.$p2.$p3;
	$p5 = substr($p4,0,5);
	$p6 = substr($p4,5,5);
	$campo1 = $p5.".".$p6;
	
	$p1 = substr($cod,24,10);
	$p2 = modulo10($p1);
	$p3 = $p1.$p2;
	$p4 = substr($p3,0,5);
	$p5 = substr($p3,5,6);	
	$campo2 = $p4.".".$p5;
	
	$p1 = substr($cod,34,10);
	$p2 = modulo10($p1);
	$p3 = $p1.$p2;
	$p4 = substr($p3,0,5);
	$p5 = substr($p3,5,6);	
	$campo3 = $p4.".".$p5;
	
	$campo4 = substr($cod,4,1);
	$campo5 = substr($cod,5,14);
	return $campo1." ".$campo2." ".$campo3." ".$campo4." ".$campo5;
}

function esquerda($entra,$comp){ return substr($entra,0,$comp); }
function direita($entra,$comp){ return substr($entra,strlen($entra)-$comp,$comp); }

function cod_barras($valor){
	// Gerador de Código de Barras - Cortesia Luciano Lima Silva 09/01/2003
	// netdinamica@netdinamica.com.br
	// Site: www.netdinamica.com.br
	$ret = "";	
  $fino = 1 ;
  $largo = 3 ;
  $altura = 50 ;

  $barcodes[0] = "00110" ;
  $barcodes[1] = "10001" ;
  $barcodes[2] = "01001" ;
  $barcodes[3] = "11000" ;
  $barcodes[4] = "00101" ;
  $barcodes[5] = "10100" ;
  $barcodes[6] = "01100" ;
  $barcodes[7] = "00011" ;
  $barcodes[8] = "10010" ;
  $barcodes[9] = "01010" ;
 for($f1 = 9; $f1 >= 0; $f1--){ 
    for($f2 = 9; $f2 >= 0; $f2--){  
      $f = ($f1 * 10) + $f2 ;
      $texto = "" ;
      for($i = 1; $i < 6; $i++){ $texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1); }
      $barcodes[$f] = $texto;
      //echo "$f=$texto<br>";
    }
  }
  $ret .= "<img src=p.gif width=$fino height=$altura border=0>";
  $ret .= "<img src=b.gif width=$fino height=$altura border=0>";
  $ret .= "<img src=p.gif width=$fino height=$altura border=0>";
  $ret .= "<img src=b.gif width=$fino height=$altura border=0>";
  $ret .= "<img ";
  $texto = $valor ;
  if(bcmod(strlen($texto),2) <> 0){ $texto = "0" . $texto; }
  while (strlen($texto) > 0) {
    $i = round(esquerda($texto,2));
    $texto = direita($texto,strlen($texto)-2);
    $f = $barcodes[$i];
    for($i=1;$i<11;$i+=2){
      if (substr($f,($i-1),1) == "0") { $f1 = $fino ; }else{ $f1 = $largo ; }
      $ret .= "src=p.gif width=$f1 height=$altura border=0>";
      $ret .= "<img ";
      if (substr($f,$i,1) == "0") { $f2 = $fino ; }else{ $f2 = $largo ; }
      $ret .= "src=b.gif width=$f2 height=$altura border=0>";
      $ret .= "<img ";
    }
  }
  $ret .= "src=p.gif width=$largo height=$altura border=0>";
  $ret .= "<img src=b.gif width=$fino height=$altura border=0>";
  $ret .= "<img src=p.gif width=1 height=$altura border=0>";
  return $ret;
}

function cod_barras2($valor){
	unset($ret);
  $fino = 1 ;
  $largo = 3 ;
  $barcodes[0] = "00110" ;
  $barcodes[1] = "10001" ;
  $barcodes[2] = "01001" ;
  $barcodes[3] = "11000" ;
  $barcodes[4] = "00101" ;
  $barcodes[5] = "10100" ;
  $barcodes[6] = "01100" ;
  $barcodes[7] = "00011" ;
  $barcodes[8] = "10010" ;
  $barcodes[9] = "01010" ;
  for($f1 = 9; $f1 >= 0; $f1--)
  { for($f2 = 9; $f2 >= 0; $f2--){  
      $f = ($f1 * 10) + $f2 ;
      $texto = "" ;
      for($i = 1; $i < 6; $i++){ $texto .=  substr($barcodes[$f1],($i-1),1) . substr($barcodes[$f2],($i-1),1); }
      $barcodes[$f] = $texto;    
    }
  }
  $ret["p"][0] = $fino;
  $ret["b"][0] = $fino;
  $ret["p"][1] = $fino;
  $ret["b"][1] = $fino;
  $j = 2;
  $texto = $valor ;
  if(bcmod(strlen($texto),2) <> 0){ $texto = "0" . $texto; }
  while (strlen($texto) > 0)
  { $i = round(esquerda($texto,2));
    $texto = direita($texto,strlen($texto)-2);
    $f = $barcodes[$i];
    for($i = 1; $i < 11; $i+=2)
    { if (substr($f,($i-1),1) == "0") { $f1 = $fino ; }else{ $f1 = $largo ; }
      $ret["p"][$j] = $f1;
      if (substr($f,$i,1) == "0") { $f2 = $fino ; }else{ $f2 = $largo ; }
      $ret["b"][$j] = $f2;
      $j++;
    }
  }
  $ret["p"][$j] = $largo;
  $ret["b"][$j] = $fino;
  $j++;
  $ret["p"][$j] = $fino;
  return $ret;
}
?>