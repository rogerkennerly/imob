<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php //------------------ BANCO DO ITAU ------------------
  $localpag        = "Pagavél em qualquer banco até o vencimento";
  $espdoc          = "R$";
  $especie         = "R$";
  $usobanco        = "";
  $cb              = "341";
  $banco_formatado = "341";
  $carteira        = "175";
  
  $fator = explode(":",fatordevencimento($datavenci));
  if ($fator[0] > 0) { $fv = $fator[0]; } else { echo $fator[1]; exit(); }
  $va = str_replace(".","",$valor);
  if (strlen($va) > 10) { echo "valor muito alto, divida o boleto em dois"; exit(); }
  $va = str_pad($va, 10, "0", STR_PAD_LEFT);
      
  $nn = str_pad($nn, 8, "0", STR_PAD_LEFT);
    
  $dg_nn = Modulo10($ag.$cc.$carteira.$nn);
  $dg_ac = Modulo10($ag.$cc); //dígito agência conta
    
  $dg4 = modulo11($cb.$mo.$fv.$va.$carteira.$nn.$dg_nn.$ag.$cc.$dg_ac."000");
  if ($dg4 == 0) { $dg4 = 1; }
  $cbarras = $cb.$mo.$dg4.$fv.$va.$carteira.$nn.$dg_nn.$ag.$cc.$dg_ac."000";  
  
  $nn_formatado = $carteira."/".$nn."-".$dg_nn;
  $ag_cc = $ag."-".$digag."/".$cc."-".$digcc;
  
  if ($tipo_impressao == "normal")
  { $codbarras = cod_barras($cbarras);  } //para boleto normal
  else 
  { $codbarras = cod_barras2($cbarras); } //para boleto em pdf
  $linhadigi = montalinhadigitavel($cbarras);
?>