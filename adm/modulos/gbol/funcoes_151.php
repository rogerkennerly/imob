<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php //------------------ NOSSA CAIXA (ESTADUAL) ------------------
  $localpag        = "Pagavél em qualquer banco até o vencimento";
  $espdoc          = "R$";
  $especie         = "R$";
  $usobanco        = "";
  $cb              = "151";
  $banco_formatado = "151-1";  
  $ag_cc = $ag.".".$cc.".".$digcc;
  
  $fator = explode(":",fatordevencimento($datavenci));
  if ($fator[0] > 0) { $fv = $fator[0]; } else { echo $fator[1]; exit(); }
  $va = str_replace(".","",$valor);
  if (strlen($va) > 10) { echo "valor muito alto, divida o boleto em dois"; exit(); }
  $va = str_pad($va, 10, "0", STR_PAD_LEFT);
  
  $nn = str_pad($nn, 9 , "0", STR_PAD_LEFT);   
    
  $dg_nn  = calc_dv_nosso_numero($ag.substr($cc,0,2)."0".substr($cc,2,6).$digcc.$nn);  
  $alivre = $nn . $ag . substr($cc,1,7) . $cb;            
  $d1 = modulo10($alivre);
  
  do {
  	$recalc = false;
  	$resto  = "";
  	$base   = 7;
  	$linha  = strrev($alivre.$d1);
  	$peso   = 2;
  	$soma   = 0;  	
  	for ($i = 0; $i < strlen($linha); $i++)
  	{ $calc = ($linha[$i] * $peso);
  	  $soma = $soma + $calc;
  	  if ($peso < $base) { $peso++; } else { $peso = 2; }
  	}  	
  	$resto = ($soma % 11);
  	if ($resto == 0) { $d2 = 0; } else { $d2 = (11 - $resto); }
  	
  	switch ($resto) {
  		case 0 : $d2 = 0; break;
      case 1 : $recalc = true;
               if ($d1 == 9) { $d1 = 0; } else { $d1 = ($d1 + 1); }
               break;
    }  	
  } while( $recalc );
  
  $alivre = $alivre.$d1.$d2;
   
  if ($carteira == "06") 
  { $dg4 = modulo11($cb.$mo.$fv.$va.$alivre);
    if ($dg4 == 0) { $dg4 = 1; }
    $cbarras = $cb.$mo.$dg4.$fv.$va.$alivre;  
  }
  
  $nn_formatado = $nn.".".$dg_nn;  
  
  if ($tipo_impressao == "normal")
  { $codbarras = cod_barras($cbarras);  } //para boleto normal
  else 
  { $codbarras = cod_barras2($cbarras); } //para boleto em pdf
  $linhadigi = montalinhadigitavel($cbarras);
?>
<?php
function calc_dv_nosso_numero ($linha) {  
	$pesos = array ("3","1","9","7","3","1","9","7","3","1","9","7","3","1","3","1","9","7","3","1","9","7","3");	
	$soma = 0;
  for ($i = 0; $i < strlen($linha); $i++)
  { $calc = $linha[$i] * $pesos[$i];    
    $soma = $soma + $calc;    
  }  
  $digitao = ($soma % 10);  
  if ($digitao != 0) { $digitao = (10 - $digitao); }  
  return $digitao;
}  
?>