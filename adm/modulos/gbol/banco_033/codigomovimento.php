<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
  function codigomovimento($cod) { //informe o código que retorna o movimento
    $t = '';
    switch ($cod) 
    { case '02': $t = 'Entrada Confirmada';                                           break;
      case '03': $t = 'Entrada Rejeitada';                                            break;
      case '04': $t = 'Transferência de Carteira/Entrada';                            break;
      case '05': $t = 'Transferência de Carteira/Baixa';                              break;
      case '06': $t = 'Liquidação';                                                   break;
      case '07': $t = 'Confirmação do Recebimento da Instrução de Desconto';          break;
      case '08': $t = 'Confirmação do Recebimento do Cancelamento do Desconto';       break;
      case '09': $t = 'Baixa';                                                        break;
      case '11': $t = 'Títulos em Carteira (Em Ser)';                                 break;
      case '12': $t = 'Confirmação Recebimento Instrução de Abatimento';              break;
      case '13': $t = 'Confirmação Recebimento Instrução de Cancelamento Abatimento'; break;
      case '14': $t = 'Confirmação Recebimento Instrução Alteração de Vencimento';    break;
      case '15': $t = 'Franco de Pagamento';                                          break;
      case '17': $t = 'Liquidação Após Baixa ou Título Não Registrado';               break;
      case '19': $t = 'Confirmação Recebimento Instrução de Protesto';                break;
      case '20': $t = 'Confirmação Recebimento Instrução de Sustação/Cancelamento de Protesto';break;
      case '23': $t = 'Remessa a Cartório (Aponte em Cartório)';                      break;
      case '24': $t = 'Retirada de Cartório e Manutenção em Carteira';                break;
      case '25': $t = 'Protestado e Baixado (Baixa por Ter Sido Protestado)';         break;
      case '26': $t = 'Instrução Rejeitada';                                          break;
      case '27': $t = 'Confirmação do Pedido de Alteração de Outros Dados';           break;
      case '28': $t = 'Débito de Tarifas/Custas';                                     break;
      case '29': $t = 'Ocorrências do Pagador';                                       break;
      case '30': $t = 'Alteração de Dados Rejeitada';                                 break;
      case '33': $t = 'Confirmação da Alteração dos Dados do Rateio de Crédito';      break;
      case '34': $t = 'Confirmação do Cancelamento dos Dados do Rateio de Crédito';   break;
      case '35': $t = 'Confirmação do Desagendamento do Débito Automático';           break;
      case '36': $t = 'Confirmação de envio de e-mail/SMS';                           break;
      case '37': $t = 'Envio de e-mail/SMS rejeitado';                                break;
      case '38': $t = 'Confirmação de alteração do Prazo Limite de Recebimento (a data deve ser informada no campo 28.3.p)';break;
      case '39': $t = 'Confirmação de Dispensa de Prazo Limite de Recebimento';       break;
      case '40': $t = 'Confirmação da alteração do número do título dado pelo Beneficiário';break;
      case '41': $t = 'Confirmação da alteração do número controle do Participante';  break;
      case '42': $t = 'Confirmação da alteração dos dados do Pagador';                break;
      case '43': $t = 'Confirmação da alteração dos dados do Sacador/Avalista';       break;
      case '44': $t = 'Título pago com cheque devolvido';                             break;
      case '45': $t = 'Título pago com cheque compensado';                            break;
      case '46': $t = 'Instrução para cancelar protesto confirmada';                  break;
      case '47': $t = 'Instrução para protesto para fins falimentares confirmada';    break;
      case '48': $t = 'Confirmação de instrução de transferência de carteira/modalidade de cobrança';break;
      case '49': $t = 'Alteração de contrato de cobrança';                            break;
      case '50': $t = 'Título pago com cheque pendente de liquidação';                break;
      case '51': $t = 'Título DDA reconhecido pelo Pagador';                          break;
      case '52': $t = 'Título DDA não reconhecido pelo Pagador';                      break;
      case '53': $t = 'Título DDA recusado pela CIP';                                 break;
      case 'A4': $t = 'Pagador DDA';                                                  break;
      /*case '54': $t = 'Confirmação da Instrução de Baixa de Título Negativado sem Protesto';break;
      case '55': $t = 'Confirmação de Pedido de Dispensa de Multa';                   break;
      case '56': $t = 'Confirmação do Pedido de Cobrança de Multa';                   break;
      case '57': $t = 'Confirmação do Pedido de Alteração de Cobrança de Juros';      break;
      case '58': $t = 'Confirmação do Pedido de Alteração do Valor/Data de Desconto'; break;
      case '59': $t = 'Confirmação do Pedido de Alteração do Beneficiário do Título'; break;
      case '60': $t = 'Confirmação do Pedido de Dispensa de Juros de Mora';           break;
      case '61': $t = 'Confirmação de Alteração do Valor Nominal do Título';          break;
      case '63': $t = 'Título Sustado Judicialmente';                                 break;*/
      default : $t = $cod;
    }
    return $t;
  }
?>