<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php //------------------ BANCO HSBC ------------------
  $localpag        = "Pagavél em qualquer banco até o vencimento";
  $espdoc          = "R$";
  $especie         = "R$";
  $usobanco        = "";
  $cb              = "399";
  $banco_formatado = "399";
  $carteira        = "CNR";
  //Dígitos  Conta = 7 Ag = 4 Nosso Número = 13
  
  $fator = explode(":",fatordevencimento($datavenci));
  if ($fator[0] > 0) { $fv = $fator[0]; } else { echo $fator[1]; exit(); }
  $va = str_replace(".","",$valor);
  if (strlen($va) > 10) { echo "valor muito alto, divida o boleto em dois"; exit(); }
  $va = str_pad($va, 10, "0", STR_PAD_LEFT);
      
  $nn = str_pad($nn, 13, "0", STR_PAD_LEFT);
  
  $dg_nn1 = modulo11($nn);
  $data = explode("/",$datavenci);
  $datavencimento = $data[0].$data[1].substr($data[2],2,2); //ADataVencimento := FormatDateTime('ddmmyy',ATitulo.DataVencimento);
  $dg_nn = modulo11((($nn.$dg_nn1."4")+($cc+$datavencimento))); //ADigitoNossoNumero := Modulo11(FloatToStr(StrToFloat(ANossoNumero + ADigitoNossoNumero1 + '4') + StrToFloat(ACodigoCedente) + StrToFloat(ADataVencimento)));
  $dg_nn = $dg_nn1."4".$dg_nn; //ADigitoNossoNumero := ADigitoNossoNumero1 + '4' + ADigitoNossoNumero;
    
  $data   = explode("/",$datavenci);
  $sql    = "select ( TO_DAYS('".$data[2]."-".$data[1]."-".$data[0]."') - TO_DAYS('".($data[2]-1)."-12-31') ) as dias";
  $result = mysql_query($sql);
  $dias   = mysql_result($result,0,"dias");
  $ano    = substr($data[2],3,1);
  $dataju = str_pad($dias,3,"0",STR_PAD_LEFT).$ano;
  
  $livre = $cc.$nn.$dataju."2"; //Result := ACodigoCedente + ANossoNumero + ADataVencimentoJuliano + '2';
  $dg4 = modulo11($cb.$mo.$fv.$va.$livre);
  if ($dg4 == 0) { $dg4 = 1; }
  $cbarras = $cb.$mo.$dg4.$fv.$va.$livre;  
  
  $nn_formatado = $nn."-".$dg_nn;
  $ag_cc = $ag."/".$cc;
  
  if ($tipo_impressao == "normal")
  { $codbarras = cod_barras($cbarras);  } //para boleto normal
  else 
  { $codbarras = cod_barras2($cbarras); } //para boleto em pdf
  $linhadigi = montalinhadigitavel($cbarras);
?>