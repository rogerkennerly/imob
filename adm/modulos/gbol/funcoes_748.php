<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php //------------------ CAIXA CREDICONAI/BANCOOB ------------------  
  $localpag        = "Pagavél em qualquer banco até o vencimento";
  $espdoc          = "R$";
  $especie         = "R$";
  $banco_formatado = "748-0";  
  $cb = "748";
  $mo = 9;
  //Numero da Conta - Informar com 7 digitos (02-Posto/05-Conta)'
  
  $nn = "1".str_pad($nn, 5, "0", STR_PAD_LEFT);
    
  $fator = explode(":",fatordevencimento($datavenci));
  if ($fator[0] > 0) { $fv = $fator[0]; } else { echo $fator[1]; exit(); }
  $va = str_replace(".","",converttobd($valor));
  if (strlen($va) > 10) { echo "valor muito alto, divida o boleto em dois"; exit(); }
  $va = str_pad($va, 10, "0", STR_PAD_LEFT);
    
  $ag_cc = $ag."/".$cc; 
  $dg_nn = modulo11($ag.$cc.date("y").$nn);
  
  $tmpva = $va; settype($tmpva,"integer");
  if ($tmpva == 0) { $filer = "00"; } else { $filer = "10"; }
  $digito = modulo11("31".$nn.$ag.$cc.$filer);
  $dg4 = modulo11($cb.$mo.$fv.$va."31".$nn.$ag.$cc.$filer.$digito);
  if ($dg4 == 0) { $dg4 = 1; }
  $cbarras = $cb.$mo.$dg4.$fv.$va."31".$nn.$ag.$cc.$filer.$digito;
  
  $nn_formatado = $nn."-".$dg_nn;
  
  if ($tipo_impressao == "normal")
  { $codbarras = cod_barras($cbarras);  } //para boleto normal
  else 
  { $codbarras = cod_barras2($cbarras); } //para boleto em pdf
  $linhadigi = montalinhadigitavel($cbarras);
?>