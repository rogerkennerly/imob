<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php //------------------ BANCO DO BRASIL ------------------  
  $localpag        = "Pagavél em qualquer banco até o vencimento";
  $espdoc          = "R$";
  $especie         = "R$";
  $usobanco        = "";
  $cb              = "001";
  $banco_formatado = "001-9";
    
  $fator = explode(":",fatordevencimento($datavenci));
  if ($fator[0] > 0) { $fv = $fator[0]; } else { echo $fator[1]; exit(); }
  $va = str_replace(".","",$valor);
  if (strlen($va) > 10) { echo "valor muito alto, divida o boleto em dois"; exit(); }
  $va = str_pad($va, 10, "0", STR_PAD_LEFT);
  
  if (strlen($convenio) == 4) { $nn = $convenio . str_pad($nn, 7, "0", STR_PAD_LEFT); }
  if (strlen($convenio) == 6) { $nn = $convenio . str_pad($nn, 5, "0", STR_PAD_LEFT); }
  if (strlen($convenio) == 7) { $nn = $convenio . str_pad($nn, 10,"0", STR_PAD_LEFT); }
  
  if (strlen($convenio) == 7)
  { $dg4 = modulo11($cb.$mo.$fv.$va."000000".$nn.$carteira);
    if ($dg4 == 0) { $dg4 = 1; }
    $cbarras = $cb.$mo.$dg4.$fv.$va."000000".$nn.$carteira;
  } else
  { $dg4 = modulo11($cb.$mo.$fv.$va.$nn.$ag.$cc.$carteira);
    if ($dg4 == 0) { $dg4 = 1; }
    $cbarras = $cb.$mo.$dg4.$fv.$va.$nn.$ag.$cc.$carteira;
  }
  
  if (modulo11($nn) == 10) { $nn_formatado = $nn."X"; } else { $nn_formatado = $nn."-".modulo11($nn); }
  $ag_cc = $ag."-".$digag."/".$cc."-".$digcc;
  
  if ($tipo_impressao == "normal")
  { $codbarras = cod_barras($cbarras);  } //para boleto normal
  else 
  { $codbarras = cod_barras2($cbarras); } //para boleto em pdf
  $linhadigi = montalinhadigitavel($cbarras);
?>