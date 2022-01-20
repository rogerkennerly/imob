<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
  function codigomovimento($cod) { //informe o c�digo que retorna o movimento
    $t = '';
    switch ($cod) 
    { case '02': $t = 'Entrada Confirmada';                                           break;
      case '03': $t = 'Entrada Rejeitada';                                            break;
      case '04': $t = 'Transfer�ncia de Carteira/Entrada';                            break;
      case '05': $t = 'Transfer�ncia de Carteira/Baixa';                              break;
      case '06': $t = 'Liquida��o';                                                   break;
      case '07': $t = 'Confirma��o do Recebimento da Instru��o de Desconto';          break;
      case '08': $t = 'Confirma��o do Recebimento do Cancelamento do Desconto';       break;
      case '09': $t = 'Baixa';                                                        break;
      case '11': $t = 'T�tulos em Carteira (Em Ser)';                                 break;
      case '12': $t = 'Confirma��o Recebimento Instru��o de Abatimento';              break;
      case '13': $t = 'Confirma��o Recebimento Instru��o de Cancelamento Abatimento'; break;
      case '14': $t = 'Confirma��o Recebimento Instru��o Altera��o de Vencimento';    break;
      case '15': $t = 'Franco de Pagamento';                                          break;
      case '17': $t = 'Liquida��o Ap�s Baixa ou T�tulo N�o Registrado';               break;
      case '19': $t = 'Confirma��o Recebimento Instru��o de Protesto';                break;
      case '20': $t = 'Confirma��o Recebimento Instru��o de Susta��o/Cancelamento de Protesto';break;
      case '23': $t = 'Remessa a Cart�rio (Aponte em Cart�rio)';                      break;
      case '24': $t = 'Retirada de Cart�rio e Manuten��o em Carteira';                break;
      case '25': $t = 'Protestado e Baixado (Baixa por Ter Sido Protestado)';         break;
      case '26': $t = 'Instru��o Rejeitada';                                          break;
      case '27': $t = 'Confirma��o do Pedido de Altera��o de Outros Dados';           break;
      case '28': $t = 'D�bito de Tarifas/Custas';                                     break;
      case '29': $t = 'Ocorr�ncias do Pagador';                                       break;
      case '30': $t = 'Altera��o de Dados Rejeitada';                                 break;
      case '33': $t = 'Confirma��o da Altera��o dos Dados do Rateio de Cr�dito';      break;
      case '34': $t = 'Confirma��o do Cancelamento dos Dados do Rateio de Cr�dito';   break;
      case '35': $t = 'Confirma��o do Desagendamento do D�bito Autom�tico';           break;
      case '36': $t = 'Confirma��o de envio de e-mail/SMS';                           break;
      case '37': $t = 'Envio de e-mail/SMS rejeitado';                                break;
      case '38': $t = 'Confirma��o de altera��o do Prazo Limite de Recebimento (a data deve ser informada no campo 28.3.p)';break;
      case '39': $t = 'Confirma��o de Dispensa de Prazo Limite de Recebimento';       break;
      case '40': $t = 'Confirma��o da altera��o do n�mero do t�tulo dado pelo Benefici�rio';break;
      case '41': $t = 'Confirma��o da altera��o do n�mero controle do Participante';  break;
      case '42': $t = 'Confirma��o da altera��o dos dados do Pagador';                break;
      case '43': $t = 'Confirma��o da altera��o dos dados do Sacador/Avalista';       break;
      case '44': $t = 'T�tulo pago com cheque devolvido';                             break;
      case '45': $t = 'T�tulo pago com cheque compensado';                            break;
      case '46': $t = 'Instru��o para cancelar protesto confirmada';                  break;
      case '47': $t = 'Instru��o para protesto para fins falimentares confirmada';    break;
      case '48': $t = 'Confirma��o de instru��o de transfer�ncia de carteira/modalidade de cobran�a';break;
      case '49': $t = 'Altera��o de contrato de cobran�a';                            break;
      case '50': $t = 'T�tulo pago com cheque pendente de liquida��o';                break;
      case '51': $t = 'T�tulo DDA reconhecido pelo Pagador';                          break;
      case '52': $t = 'T�tulo DDA n�o reconhecido pelo Pagador';                      break;
      case '53': $t = 'T�tulo DDA recusado pela CIP';                                 break;
      case 'A4': $t = 'Pagador DDA';                                                  break;
      /*case '54': $t = 'Confirma��o da Instru��o de Baixa de T�tulo Negativado sem Protesto';break;
      case '55': $t = 'Confirma��o de Pedido de Dispensa de Multa';                   break;
      case '56': $t = 'Confirma��o do Pedido de Cobran�a de Multa';                   break;
      case '57': $t = 'Confirma��o do Pedido de Altera��o de Cobran�a de Juros';      break;
      case '58': $t = 'Confirma��o do Pedido de Altera��o do Valor/Data de Desconto'; break;
      case '59': $t = 'Confirma��o do Pedido de Altera��o do Benefici�rio do T�tulo'; break;
      case '60': $t = 'Confirma��o do Pedido de Dispensa de Juros de Mora';           break;
      case '61': $t = 'Confirma��o de Altera��o do Valor Nominal do T�tulo';          break;
      case '63': $t = 'T�tulo Sustado Judicialmente';                                 break;*/
      default : $t = $cod;
    }
    return $t;
  }
?>