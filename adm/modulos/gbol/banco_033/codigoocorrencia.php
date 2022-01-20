<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
  function codigoocorrencia($cod) {
    $s = '';
    switch ( $cod )
    { case '01': $s = 'Por Saldo';                      break;
      case '02': $s = 'Por Conta';                      break;
      case '03': $s = 'No Pr�prio Banco';               break;
      case '04': $s = 'Compensa��o Eletr�nica';         break;
      case '05': $s = 'Compensa��o Convencional';       break;
      case '06': $s = 'Por Meio Eletr�nico';            break;
      case '07': $s = 'Ap�s Feriado Local';             break;
      case '08': $s = 'Em Cart�rio';                    break;
      case '09': $s = 'Baixa Comandada Banco';                     break;
      case '10': $s = 'Baixa Comandada Cliente Arquivo';           break;
      case '11': $s = 'Baixa Comandada Cliente Online';            break;
      case '12': $s = 'Baixa Decurso Prazo - Cliente';             break;
      case '13': $s = 'Baixa Decurso Prazo - Banco';               break;
      case '14': $s = 'Ocor. Protestado';                                break;
      case '15': $s = 'Ocor. T�tulo Exclu�do';                           break;
      case '30': $s = 'Ocor. Liquida��o no Guich� de Caixa em Cheque';   break;
      case '31': $s = 'Ocor. Liquida��o em banco correspondente';        break;
      case '32': $s = 'Ocor. Liquida��o Terminal de Auto-Atendimento';   break;
      case '33': $s = 'Ocor. Liquida��o na Internet (Home banking)';     break;
      case '34': $s = 'Ocor. Liquidado Office Banking';                  break;
      case '35': $s = 'Ocor. Liquidado Correspondente em Dinheiro';      break;
      case '36': $s = 'Ocor. Liquidado Correspondente em Cheque';        break;
      case '37': $s = 'Ocor. Liquidado por meio de Central de Atendimento (Telefone)';break;
    }
    return $s;
  }
?>