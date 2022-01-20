<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
  // **************************************************
  // **   LAYOUT  ARQUIVO DE RETORNO - BOLETO        **
  // **           PADRÃO CNAB 240                    **
  // **           BANCO SANTANDER                    **
  // **************************************************
  //error_reporting(E_ERROR);
  include('banco_033/codigomovimento.php');
  include('banco_033/rejeicoes40A.php');
  include('banco_033/codigoocorrencia.php');
    
  //LEITURA DO ARQUIVO 
  $conteudo_arquivo = file($dir_retorno.$nome_retorno);
  
  //Faz a leitura Linha a Linha - Padrão do Banco
  foreach ($conteudo_arquivo as $linha)
  {
    $tipo_registro = substr($linha,7,1);
    if ( $tipo_registro=='0' ) { } // echo "Funções de tratamento do Header do arquivo\n";
    if ( $tipo_registro=='1' ) { } // echo "Funções de tratamento do Header do Lote\n";
    if ( $tipo_registro=='5' ) { } // echo "Funções de tratamento do Trailer do Lote\n";
    if ( $tipo_registro=='9' ) { } // echo "Funções de tratamento do Trailer do Arquivo\n";
    if ( $tipo_registro=='3' )     // echo "Registro de detalhe\n";
    {       
      $tipo_segmento = substr($linha, 13, 1);
      
      if ( $tipo_segmento == 'T' ) // echo "Tratamento do segmento T\n";
      {
        $titulo[]['identificacao']                            = substr($linha,  40, 12);
        $id_titulo                                            = count($titulo)-1;
        $titulo[$id_titulo]['nosso_numero']                   = (int) substr($linha,  40, 13);
        $titulo[$id_titulo]['carteira']                       = substr($linha,  53,  1);
        $titulo[$id_titulo]['num_documento']                  = substr($linha,  54, 15);
        $titulo[$id_titulo]['data_vencto'][0]                 = substr($linha,  69,  8);
        $titulo[$id_titulo]['data_vencto'][1]                 = substr($linha,  69,  2).'/'.substr($linha,  71,  2).'/'.substr($linha, 73,  4);
        $titulo[$id_titulo]['valor_nominal']                  = number_format(substr($linha,  77, 13).'.'.substr($linha,  90, 2),2,'.','');
        $titulo[$id_titulo]['identificacao_empresa']          = substr($linha, 100, 25);
        $titulo[$id_titulo]['pagador_nome']                   = substr($linha, 143, 40);
        $titulo[$id_titulo]['valor_tarifa']                   = number_format(substr($linha, 193, 13).'.'.substr($linha, 206, 2),2,'.','');
        $titulo[$id_titulo]['cod_ocorrencia']                 = substr($linha, 208, 10);
        if ( $titulo[$id_titulo]['carteira'] == '2' ) { $titulo[$id_titulo]['nosso_numero'] = substr($titulo[$id_titulo]['nosso_numero'],0,-1); }
        /*
        echo 'identificacao_empresa=',$titulo[$id_titulo]['identificacao_empresa'],'<br>';
        echo 'carteira=',$titulo[$id_titulo]['carteira'],'<br>';
        echo 'nosso_numero=',$titulo[$id_titulo]['nosso_numero'],'<br>';
        { $titulo[$id_titulo]['nosso_numero'] = (int) substr($linha,  40, 13);
        } elseif( $titulo[$id_titulo]['carteira'] == '2' ) 
        { $titulo[$id_titulo]['nosso_numero'] = (int) substr($linha,  40, 12);
        }*/
      }
        
      if( $tipo_segmento == 'U' )  // echo "Tratamento do segmento U\n";
      {       
        $titulo[$id_titulo]['cod_movimento']                  = substr($linha,  15,  2);
        $titulo[$id_titulo]['valor_juros']                    = number_format(substr($linha,  17, 13).'.'.substr($linha,  30, 2),2,'.','');
        $titulo[$id_titulo]['valor_desconto']                 = number_format(substr($linha,  32, 13).'.'.substr($linha,  45, 2),2,'.','');
        $titulo[$id_titulo]['valor_abatimento']               = number_format(substr($linha,  47, 13).'.'.substr($linha,  60, 2),2,'.','');
        $titulo[$id_titulo]['valor_iof']                      = number_format(substr($linha,  62, 13).'.'.substr($linha,  75, 2),2,'.','');
        $titulo[$id_titulo]['valor_pago']                     = number_format(substr($linha,  77, 13).'.'.substr($linha,  90, 2),2,'.',''); //Valor para confrontar no sistema
        $titulo[$id_titulo]['valor_liquido']                  = number_format(substr($linha,  92, 13).'.'.substr($linha, 105, 2),2,'.',''); //Valor que vai para conta
        $titulo[$id_titulo]['valor_despesas']                 = number_format(substr($linha, 107, 13).'.'.substr($linha, 120, 2),2,'.',''); 
        $titulo[$id_titulo]['valor_creditos']                 = number_format(substr($linha, 122, 13).'.'.substr($linha, 135, 2),2,'.','');
        $titulo[$id_titulo]['data_ocorrencia'][0]             = substr($linha, 137,  8);
        $titulo[$id_titulo]['data_ocorrencia'][1]             = substr($linha, 137,  2).'/'.substr($linha, 139,  2).'/'.substr($linha, 141,  4);
        $titulo[$id_titulo]['data_credito'][0]                = substr($linha, 145,  8);
        $titulo[$id_titulo]['data_credito'][1]                = substr($linha, 145,  2).'/'.substr($linha, 147,  2).'/'.substr($linha, 149,  4);
        /*        
        if ( $titulo[$id_titulo]['cod_movimento']=='03' || $titulo[$id_titulo]['cod_movimento']=='26' || $titulo[$id_titulo]['cod_movimento']=='30' )
        { $titulo[$id_titulo]['nota'] = rejeicoes($titulo[$id_titulo]['cod_ocorrencia']);
          $titulos_recusados[] = $titulo[$id_titulo];
        }
        elseif ( $titulo[$id_titulo]['cod_movimento']=='06' || $titulo[$id_titulo]['cod_movimento']=='09' || $titulo[$id_titulo]['cod_movimento']=='17' )
        { $titulo[$id_titulo]['nota'] = codigoocorrencia($titulo[$id_titulo]['cod_ocorrencia']);
          if ( $titulo[$id_titulo]['cod_movimento']=='06' || $titulo[$id_titulo]['cod_movimento']=='17' ) { $titulos_liquidados[] = $titulo[$id_titulo]; }
        }
        else
        { $titulo[$id_titulo]['nota'] = codigomovimento($titulo[$id_titulo]['cod_ocorrencia']);
          if ( $titulo[$id_titulo]['cod_movimento']=='02' ) { $titulos_aceitos[] = $titulo[$id_titulo]; }
        }
        echo 'nota=',$titulo[$id_titulo]['nota'],'<br>';
        */        
      }
      
      $titulo[$id_titulo]['descr_movimento']  = '';
      $titulo[$id_titulo]['descr_ocorrencia'] = '';
      $titulo[$id_titulo]['nota']             = '';
    }
  }
  
  for ($t = 0; $t < count($titulo); $t++)
  { 
    $titulo[$t]['descr_movimento'] = codigomovimento($titulo[$t]['cod_movimento']);
    $temp_rejeicao = str_split($titulo[$t]['cod_ocorrencia'], 2);
    
    if( $titulo[$t]['cod_movimento']=='03' || $titulo[$t]['cod_movimento']=='26' || $titulo[$t]['cod_movimento']=='30' )
    { foreach($temp_rejeicao as $cod_ocorrencia)
      { $titulo[$t]['nota'] .= rejeicoes($cod_ocorrencia);  //informe o código que retorna a ocorrencia
      }
      $titulos_recusados[]  = $titulo[$t];
    }
    elseif ( $titulo[$t]['cod_movimento']=='06' || $titulo[$t]['cod_movimento']=='09' || $titulo[$t]['cod_movimento']=='17' )
    { foreach($temp_rejeicao as $cod_ocorrencia)
      { $titulo[$t]['nota'] .= codigoocorrencia($cod_ocorrencia);
      }
      if ( $titulo[$t]['cod_movimento']=='06' || $titulo[$t]['cod_movimento']=='17' ) { $titulos_liquidados[] = $titulo[$t]; }
    }
    else
    { foreach($temp_rejeicao as $cod_ocorrencia)
      { $titulo[$t]['nota'] .= codigomovimento($cod_ocorrencia);
      }
      if ( $titulo[$t]['cod_movimento']=='02' ) { $titulos_aceitos[] = $titulo[$t]; }
    }
    //if( $titulo[$t]['cod_movimento']=='06' || $titulo[$t]['cod_movimento']=='17' ) { $titulos_liquidados[] = $titulo[$t]; }
    //if( $titulo[$t]['cod_movimento']=='02' )                                       { $titulos_aceitos[]    = $titulo[$t]; }
    //if( $titulo[$t]['cod_movimento']=='03' )                                       { $titulos_recusados[]  = $titulo[$t]; }
    echo 'nosso numero=',$titulo[$t]['nosso_numero'],' | nota=',$titulo[$t]['nota'],'<br>';
  }
  
  //Tratamentos e descrições dos códigos informados no retorno de cada título
  /*for ($t = 0; $t < count($titulo); $t++)
  { 
    $titulo[$t]['descr_movimento'] = codigomovimento($titulo[$t]['cod_movimento']);
    $temp_rejeicao = str_split($titulo[$t]['cod_ocorrencia'], 2);
    
    if( $titulo[$t]['cod_movimento']=='02' || $titulo[$t]['cod_movimento']=='03' || $titulo[$t]['cod_movimento']=='26' || $titulo[$t]['cod_movimento']=='30' )
    { foreach($temp_rejeicao as $cod_ocorrencia)
      { $titulo[$t]['descr_ocorrencia'] .= codigomovimento($cod_ocorrencia);  //informe o código que retorna a ocorrencia
      }
    }
    if( $titulo[$t]['cod_movimento']=='06' || $titulo[$t]['cod_movimento']=='09' || $titulo[$t]['cod_movimento']=='17' )
    { foreach($temp_rejeicao as $cod_ocorrencia)
      { $titulo[$t]['descr_ocorrencia'] .= codigoocorrencia($cod_ocorrencia);
      }
    }
    if( $titulo[$t]['cod_movimento']=='06' || $titulo[$t]['cod_movimento']=='17' ) { $titulos_liquidados[] = $titulo[$t]; }
    if( $titulo[$t]['cod_movimento']=='02' )                                       { $titulos_aceitos[]    = $titulo[$t]; }
    if( $titulo[$t]['cod_movimento']=='03' )                                       { $titulos_recusados[]  = $titulo[$t]; }
  }*/
  
  // DEBUG *** DEBUG *** DEBUG *** DEBUG *** DEBUG *** DEBUG *** DEBUG *** DEBUG *** DEBUG *** DEBUG *** DEBUG *** DEBUG
  // print_r($titulo); echo "\n\n\n";
  // print_r($conteudo_arquivo); exit();
?>