<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php //------------------ CAIXA ECONOMICA FEDERAL ------------------  
  $localpag        = "Pagavél em qualquer banco até o vencimento";
  $espdoc          = "R$";
  $especie         = "R$";
  $usobanco        = "";
  $cb              = "104";
  $banco_formatado = "104-0";  
  
  $fator = explode(":",fatordevencimento($datavenci));
  if ($fator[0] > 0) { $fv = $fator[0]; } else { echo $fator[1]; exit(); }
  $va = str_replace(".","",$valor);
  if (strlen($va) > 10) { echo "valor muito alto, divida o boleto em dois"; exit(); }
  $va = str_pad($va, 10, "0", STR_PAD_LEFT);
  
  if ($carteira == "014") { $nn = "8".str_pad($nn, 14, "0", STR_PAD_LEFT); $ag_cc = $ag."-".substr($cc,0,3).".".substr($cc,3,8)."-".$digcc; }
  if ($carteira == "013") { $nn = "8".str_pad($nn, 9 , "0", STR_PAD_LEFT); $ag_cc = $ag."-".substr($cc,0,3).".".substr($cc,3,8)."-".$digcc; }
  if ($carteira == "012") { $nn = "9".str_pad($nn, 17, "0", STR_PAD_LEFT); $ag_cc = $ag."/".substr($cc,0,6)."-".$digcc; }
  if ($carteira == "24" ) { $ag_cc = $ag."/".str_pad($cc,6,"0",STR_PAD_LEFT)."-".$digcc; }
    
  if ($carteira == "014") 
  { $nn014 = substr($nn,1,14);
  	$dg4 = modulo11($cb.$mo.$fv.$va.substr($cc,6,5).$ag."87".$nn014);
    if ($dg4 == 0) { $dg4 = 1; }
    $cbarras = $cb.$mo.$dg4.$fv.$va.substr($cc,6,5).$ag."87".$nn014;
    $nn_formatado = $nn."-".modulo11($nn);
  }
  if ($carteira == "013") 
  { $dg4 = modulo11($cb.$mo.$fv.$va.$nn.$ag.$cc);
  	if ($dg4 == 0) { $dg4 = 1; }
    $cbarras = $cb.$mo.$dg4.$fv.$va.$nn.$ag.$cc;
    $nn_formatado = $nn."-".modulo11($nn);
  }
  if ($carteira == "012") 
  { $dg4 = modulo11($cb.$mo.$fv.$va."1".$cc.$nn);
  	if ($dg4 == 0) { $dg4 = 1; }
    $cbarras = $cb.$mo.$dg4.$fv.$va."1".$cc.$nn;
    $nn_formatado = $nn."-".modulo11($nn);
  }
  if ($carteira == "24") 
  { $nn24 = str_pad($nn, 15, "0", STR_PAD_LEFT);
    $livre = $cc.$digcc.substr($nn24,0,3)."2".substr($nn24,3,3)."4".substr($nn24,6,9);
  	$diglivre = modulo11($livre);
  	$dg4 = modulo11($cb.$mo.$fv.$va.$livre.$diglivre);
  	if ($dg4 == 0) { $dg4 = 1; }
    $cbarras = $cb.$mo.$dg4.$fv.$va.$livre.$diglivre;
    $nn_formatado = $carteira."/".$nn24."-".modulo11($carteira.$nn24);
  }
  
  if ($tipo_impressao == "normal")
  { $codbarras = cod_barras($cbarras);  } //para boleto normal
  else 
  { $codbarras = cod_barras2($cbarras); } //para boleto em pdf
  $linhadigi = montalinhadigitavel($cbarras);
?>