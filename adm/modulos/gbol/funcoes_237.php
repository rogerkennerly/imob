<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php //------------------ BRADESCO ------------------
  $localpag        = "Pagav�l em qualquer banco at� o vencimento";
  $espdoc          = "DS";
  $especie         = "R$";
  $usobanco        = "";
  $cb              = "237";
  $banco_formatado = "237-0";
  //$carteira        = "06"; // 06 sem registro 09 com registro, j� usei a carteira 09 no imoveisjau e n�o era com registro
  
  $fator = explode(":",fatordevencimento($datavenci));
  if ($fator[0] > 0) { $fv = $fator[0]; } else { echo $fator[1]; exit(); }
  $va = str_replace(".","",$valor);
  if (strlen($va) > 10) { echo "valor muito alto, divida o boleto em dois"; exit(); }
  $va = str_pad($va, 10, "0", STR_PAD_LEFT);
  
  $nn = str_pad($nn, 11, "0", STR_PAD_LEFT); // 11 d�gitos para cobran�a sem registro
  //$cc = str_pad($cc, 7 , "0", STR_PAD_LEFT); // 7 d�gitos para a conta do cedente
  
  //$dg0 = modulo10($nn.$ag.$cc); // digit�o de cobran�a
  $dg4 = modulo11($cb.$mo.$fv.$va.$ag.$carteira.$nn.$cc."0"); // digit�o do c�digo de barras
  if ($dg4 == 0) { $dg4 = 1; }
  $cbarras = $cb.$mo.$dg4.$fv.$va.$ag.$carteira.$nn.$cc."0";  
    
  $nn_formatado = $carteira."/".$nn."-".modulo11($carteira.$nn);
  $ag_cc = $ag."-".$digag."/".$cc."-".$digcc;
  
  if ($tipo_impressao == "normal")
  { $codbarras = cod_barras($cbarras);  } //para boleto normal
  else 
  { $codbarras = cod_barras2($cbarras); } //para boleto em pdf
  $linhadigi = montalinhadigitavel($cbarras);
?>