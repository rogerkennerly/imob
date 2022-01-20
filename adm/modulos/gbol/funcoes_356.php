<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php //------------------ BANCO REAL ------------------
  $localpag        = "Pagavél em qualquer banco até o vencimento";
  $especie         = "R$";
  $espdoc          = "DUP";
  $usobanco        = "";
  $cb              = "356";
  $banco_formatado = "356-5";
  $carteira        = "57";
  
  $fator = explode(":",fatordevencimento($datavenci));
  if ($fator[0] > 0) { $fv = $fator[0]; } else { echo $fator[1]; exit(); }
  $va = str_replace(".","",$valor);
  if (strlen($va) > 10) { echo "valor muito alto, divida o boleto em dois"; exit(); }
  $va = str_pad($va, 10, "0", STR_PAD_LEFT);
  
  $numdoc = $nn;
  $nn = str_pad($nn, 13, "0", STR_PAD_LEFT); // 13 dígitos para cobrança sem registro
  
  $dg0 = modulo10($nn.$ag.$cc); // digitão de cobrança
  $dg4 = modulo11($cb.$mo.$fv.$va.$ag.$cc.$dg0.$nn); // digitão do código de barras
  if ($dg4 == 0) { $dg4 = 1; }
  $cbarras = $cb.$mo.$dg4.$fv.$va.$ag.$cc.$dg0.$nn;
  
  $nn_formatado = $numdoc;
  $ag_cc = $ag."/".$cc."/".$dg0;
  
  if ($tipo_impressao == "normal")
  { $codbarras = cod_barras($cbarras);  } //para boleto normal
  else 
  { $codbarras = cod_barras2($cbarras); } //para boleto em pdf
  $linhadigi = montalinhadigitavel($cbarras);
?>