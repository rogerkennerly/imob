<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php //------------------ UNIBANCO ------------------
  $localpag        = "Pagavél em qualquer banco até o vencimento";
  $especie         = "R$";
  $espdoc          = "DS";  // espécie de documento // DM ( duplicata ), DS ( duplicata de serviço ), REC ( recidob ), NP ( nota promissória ), CL ( letra de câmbio ), OUT ( outros ).
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
      
  $dg4 = modulo11($cb.$mo.$fv.$va."5".$cc."00".$nn); // digitão do código de barras
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
Achei isso na documentação do banco. Resolví colocar aqui, porque uso a mesma função para os dois casos.
Observação 1:	Definição para cálculo do Dígito Verificador do CÓDIGO DE BARRAS:
Se o Dígito Verificador do código de barras for igual a ‘0’, ‘1’ ou ‘10’,
será assumido o valor ‘1’.

Observação 2:	Definição para cálculo do Dígito Verificador do NOSSO NÚMERO/REFÊRENCIA:
Se o dígito do  “Nosso Número / Referência do Cliente”, for igual a ‘0’ ou ‘10’, 
será assumido o valor ‘0’.
*/
?>