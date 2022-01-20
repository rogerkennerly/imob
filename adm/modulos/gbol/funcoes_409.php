<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php //------------------ UNIBANCO ------------------
  $localpag        = "Pagav�l em qualquer banco at� o vencimento";
  $especie         = "R$";
  $espdoc          = "DS";  // esp�cie de documento // DM ( duplicata ), DS ( duplicata de servi�o ), REC ( recidob ), NP ( nota promiss�ria ), CL ( letra de c�mbio ), OUT ( outros ).
  $usobanco        = "CVT 7744-5";
  $cb              = "409";
  $banco_formatado = "409-0";
  $carteira        = "20";
  
  $fator = explode(":",fatordevencimento($datavenci));
  if ($fator[0] > 0) { $fv = $fator[0]; } else { echo $fator[1]; exit(); }
  $va = str_replace(".","",$valor);
  if (strlen($va) > 10) { echo "valor muito alto, divida o boleto em dois"; exit(); }
  $va = str_pad($va, 10, "0", STR_PAD_LEFT);
    
  $dg_nn = modulo11($nn);
  $nn    = str_pad($nn.$dg_nn, 15, "0", STR_PAD_LEFT);  
      
  $dg4 = modulo11($cb.$mo.$fv.$va."5".$cc."00".$nn); // digit�o do c�digo de barras
  if ($dg4 == 0) { $dg4 = 1; }
  $cbarras = $cb.$mo.$dg4.$fv.$va."5".$cc."00".$nn;
  
  $nn_formatado = $nn."/".$dg_nn;
  $ag_cc = $ag." ".$cc1;  
  
  if ($tipo_impressao == "normal")
  { $codbarras = cod_barras($cbarras);  } //para boleto normal
  else 
  { $codbarras = cod_barras2($cbarras); } //para boleto em pdf
  $linhadigi = montalinhadigitavel($cbarras);
?>
<?php
/*
Achei isso na documenta��o do banco. Resolv� colocar aqui, porque uso a mesma fun��o para os dois casos.
Observa��o 1:	Defini��o para c�lculo do D�gito Verificador do C�DIGO DE BARRAS:
Se o D�gito Verificador do c�digo de barras for igual a �0�, �1� ou �10�,
ser� assumido o valor �1�.

Observa��o 2:	Defini��o para c�lculo do D�gito Verificador do NOSSO N�MERO/REF�RENCIA:
Se o d�gito do  �Nosso N�mero / Refer�ncia do Cliente�, for igual a �0� ou �10�, 
ser� assumido o valor �0�.
*/
?>