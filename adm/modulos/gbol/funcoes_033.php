<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php //------------------ BANCO BANESPA/SANTANDER ------------------
  $localpag        = 'Pagavél em qualquer banco até o vencimento';
  $espdoc          = 'DM';
  $especie         = 'REAL';
  $usobanco        = '';
  $cb              = '033';
  $banco_formatado = '033-7';
  //$digag = str_pad($digag, 1, '0', STR_PAD_LEFT);
  
  $fator = explode(":",fatordevencimento($datavenci));
  if ($fator[0] > 0) { $fv = $fator[0]; } else { echo $fator[1]; exit(); }
  $va = str_replace(".","",$valor);
  if (strlen($va) > 10) { echo "valor muito alto, divida o boleto em dois"; exit(); }
  $va = str_pad($va, 10, "0", STR_PAD_LEFT);

  if ($carteira == 'COB')
  { $ag    = str_pad($ag   , 4, '0', STR_PAD_LEFT);
  	$cc    = str_pad($cc   , 7, '0', STR_PAD_LEFT);
  	$digcc = str_pad($digcc, 1, '0', STR_PAD_LEFT);
  	$nn    = str_pad($nn   , 7, '0', STR_PAD_LEFT);
  	$livre = substr($ag,1,3) . $cc .  $digcc . $nn . '00033'; // só usa os 3 últimos dígitos da agência
    $d1    = modulo10($livre);
    do
    { $recalc = false;
      $resto  = modulo11_033($livre.$d1);
      switch ($resto)
      { case 0 : $d2 = 0;
        case 1 : if ($d1 == 9) { $d1 = 0; }
                 if ($d1 <  9) { $d1++;   }
                 $recalc = true;
        default: $d2 = (11 - $resto);
      }
    } while($recalc);
    $livre = $livre.$d1.$d2;
    $ag_cc = $ag."/".$cc."-".$digcc;
    $dg_nn = modulo11($nn);
    $nn_formatado = $nn."-".$dg_nn;
    //no manual do digito do nosso numero é um calculo totalmente diferente, mas deixei igual o da consir
  }
    
  /*if ($carteira == '101' or $carteira == '102') // esse está igual ao da hospedaria que tá pra lá de testado
  { //$nn    = str_pad($numdoc, 12, '0', STR_PAD_LEFT); // esse seria o correto
    //$dg_nn = modulo11($nn); // esse seria o correto, porém na francesa do banco a porra do dígito verificar do nosso número, muda o nosso número
    $cc    = str_pad($cc   , 6, '0', STR_PAD_LEFT); //coloquei esta linha por segurança
    $digag = str_pad($digag, 1, '0', STR_PAD_LEFT); //coloquei esta linha por segurança
    $digcc = str_pad($digcc, 1, '0', STR_PAD_LEFT); //coloquei esta linha por segurança
    $nn    = str_pad($nn, 13, '0', STR_PAD_LEFT);
    $dg_nn = substr($nn,12,1);
    $nn    = substr($nn,0,12);
    $livre = '9'.str_pad($cc.$digcc, 7, '0', STR_PAD_LEFT).$nn.$dg_nn.'0'.$carteira;
    $ag_cc = $ag.' / '.$cc.$digcc;
    //$ag_cc = $ag.'-'.$digag.' / '.$cc.$digcc;
    //$nn_formatado = $nn.' '.$dg_nn; // esse é o certo, mas da forma abaixo fica melhor
    $nn_formatado = $nn.$dg_nn;
  }*/
  if ($carteira == '101' or $carteira == '102')
  { $cc    = str_pad($cc   , 6 , '0', STR_PAD_LEFT);
    $nn    = str_pad($nn   , 12, '0', STR_PAD_LEFT);
    $digcc = str_pad($digcc, 1 , '0', STR_PAD_LEFT);
    $dg_nn = modulo11($nn);
    $livre = '9'.$cc.$digcc.$nn.$dg_nn.'0'.$carteira;
    $nn_formatado = $nn.'-'.$dg_nn;
    $ag_cc = $ag.'/'.$cc.'-'.$digcc;
    if ($carteira == '101') { $carteira = 'COBRANCA SIMPLES - RCR'; } else {  $carteira = 'COBRANCA SIMPLES - CSR'; }
  }
  
  $dg4 = modulo11($cb.$mo.$fv.$va.$livre);
	if ($dg4 == 0) { $dg4 = 1; }
  $cbarras = $cb.$mo.$dg4.$fv.$va.$livre;
  
  if ($tipo_impressao == "normal")
  { $codbarras = cod_barras($cbarras);  } //para boleto normal
  else 
  { $codbarras = cod_barras2($cbarras); } //para boleto em pdf
  $linhadigi = montalinhadigitavel($cbarras);
?>