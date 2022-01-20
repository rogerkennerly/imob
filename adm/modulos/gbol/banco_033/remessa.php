<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
  //Remessa Santander CNAB 240
	$nome_banco = "BANCO SANTANDER";
		
  //$sql = "select boletos.*,clientes.razao,DATE_FORMAT(boletos.datavenci,'%d/%m/%Y') as datavencif,DATE_FORMAT(boletos.dataproc,'%d/%m/%Y') as dataprocf from boletos,clientes where clientes.codigo=boletos.codcliente and clientes.codrevenda=".$_SESSION['g_codrevenda']." AND boletos.registrado='S' AND boletos.numremessa='0' $vdata $vnome $vnumbol $vpago $buscacli order by boletos.codcliente";
  //$sql = "select boletos.*,clientes.razao,DATE_FORMAT(boletos.datavenci,'%d/%m/%Y') as datavencif,DATE_FORMAT(boletos.dataproc,'%d/%m/%Y') as dataprocf from boletos,clientes where clientes.codigo=boletos.codcliente and clientes.codrevenda=".$_SESSION['g_codrevenda']." AND boletos.registrado='S' AND boletos.numremessa=1 AND boletos.pago='N' order by boletos.codcliente";
  $sql = "select boletos.*,clientes.razao,DATE_FORMAT(boletos.datavenci,'%d/%m/%Y') as datavencif,DATE_FORMAT(boletos.dataproc,'%d/%m/%Y') as dataprocf from boletos,clientes where clientes.codigo=boletos.codcliente and clientes.codrevenda=".$_SESSION['g_codrevenda']." AND boletos.status=2 AND boletos.pago='N' order by boletos.codcliente";
  $qbol   = mysql_query($sql);
	$linhas = mysql_num_rows($qbol);
  if( $linhas == 0 ) { exit('Não há boloetos pendentes para gerar remessa'); }
    
  /*$sel_num_remessa  = mysql_query("SELECT DISTINCT numremessa FROM boletos ORDER BY numremessa DESC LIMIT 0,1");
  $res_num_remessa  = mysql_fetch_assoc($sel_num_remessa);
  $controle_remessa = $res_num_remessa['numremessa']+1;
  if ($controle_remessa < 3) { $controle_remessa = 5; }*/
  $controle_remessa = date('Ymd_His');
	$num_remessa  = '1';
	$var_linha    = '';
  //$mensagem1 = 'APÓS VENCIMENTO MULTA DE 10%'; //$qbol['numboleto']
  //$mensagem2 = 'APÓS VENCIMENTO JUROS DE 1% AO MÊS';
  //$mensagem3 = 'CONCEDER DESCONTO DE R$ 50,00';
  //$mensagem4 = 'SE PAGO ATÉ 10/06/2017';
  
  //$data_desconto  = '10062017'; //date('dmY', strtotime($qbol['datavenci']));
  //$valor_desconto =  '5000'; //number_format(50,2,'',''); // 50,00 de desconto
	
   // ----------------------------------------- Header do Arquivo ----------------------------------------- //
   $var_linha .=  str_pad($codigobanco, 3, " ") .                                         						// 001 a 003 - Código do banco na compensação
                  "0000" .                                                              							// 004 a 007 - Lote de Serviço
                  "0" .                                                                 							// 008 a 008 - Tipo de registro
                  str_pad("", 8) .                       																							// 009 a 016 - Reservado
                  $tipo_pessoa .                                                                 			// 017 a 017 - Tipo de inscrição da empresa - 1=CPF 2=CNPJ
                  str_pad($numinscricaoempresa, 15, 0, STR_PAD_LEFT) .  															// 018 a 032 - Nº de inscrição da empresa - 15char
                  // str_pad($agencia_remetente, 4, 0) .       			//4  char					  								// 033 a 047 - Código de transmissão - Dados da conta
                  // str_pad($conta_remetente, 10, 0) .							//10 char           							  
                  // str_pad($conta_dig_remetente, 1, 0) .					//1  char 
                  $codtransmissao .       	  											//15 char					  							// 033 a 047 - Código de transmissão       							  
                  str_pad('', 25) .                      																							// 048 a 072 - Reservado
                  str_pad(substr($nome_razao,0, 29), 30, " ") .                                				// 073 a 102 - Nome da Empresa
                  str_pad($nome_banco, 30, " ") .       																							// 103 a 132 - Nome do Banco
                  str_pad('', 10) .                      																							// 133 a 142 - Reservado
                  "1" .                                                                 							// 143 a 143 - Código da Remessa
                  date("dmY") .                                   									  								// 144 a 151 - Data da geração do arquivo
                  str_pad('', 6) .                       																							// 152 a 157 - Reservado
                  str_pad($num_remessa, 6, 0, STR_PAD_LEFT) .                                       	// 158 a 163 - Nº Sequencial do arquivo
                  "040" .                                                               							// 164 a 166 - Nº da versão do layout do arquivo
                  str_pad('', 74)."\r\n";                                                 						// 167 a 240 - Reservado
	
	//if(strlen($var_linha) != 240){
	//	echo strlen($var_linha)."\r\n";
	//	echo $var_linha."<hr>";
	//}
									
   // ----------------------------------------- Header do Lote ----------------------------------------- //
   $var_linha .=  str_pad($codigobanco, 3, "") .                                    									// 001 a 003 - Código do Banco
									"0001" .                                                              							// 004 a 007 - Número do lote remessa
									"1"  .                                                                							// 008 a 008 - Tipo de registro
									"R" .                                                                 							// 009 a 009 - Tipo de Operacao - R = Remessa
									"01" .                                                                							// 010 a 011 - Tipo de servico
									"  " .                                                                							// 012 a 013 - Reservado
									"030" .                                                               							// 014 a 016 - Versão layout
									" " .                                                                 							// 017 a 017 - Reservado
									"2" .                                                                 							// 018 a 018 - Tipo de inscrição da empresa
									str_pad($numinscricaoempresa, 15, 0) . 																							// 019 a 033 - Nº da inscrição da empresa
									str_pad('', 20) .                      																							// 034 a 053 - Reservado
									// str_pad($agencia_remetente, 4, 0) .       				//4  char					  							// 054 a 068 - Código de transmissão
									// str_pad($conta_remetente, 10, 0) .								//10 char           							
									// str_pad($conta_dig_remetente, 1, 0) .						//1  char           							
                  $codtransmissao .       												//15 char					  	  						// 033 a 047 - Código de transmissão     
									str_pad('', 5) .                       																							// 069 a 073 - Reservado
									str_pad($nome_razao, 30, " ") .                                         						// 074 a 103 - Nome do cedente
									str_pad($mensagem1, 40, ' ') .                                											// 104 a 143 - Mensagem 1
									str_pad($mensagem2, 40, ' ') .                                											// 144 a 183 - Mensagem 2
									str_pad($num_remessa, 8, 0, STR_PAD_LEFT) .                         			    			// 184 a 191 - Número remessa/retorno
									date("dmY") .                                   									  								// 192 a 199 - Data da gravação remessa/retorno
									str_pad('', 41)."\r\n";                      																				// 200 a 240 - Reservado
	 

   // ----------------------------------------- Detalhes ----------------------------------------- //
	$var_valor_lote = 0;
  $x=0;
	while($rbol = mysql_fetch_assoc($qbol)){
    $nosso_numero 	    = $rbol['numboleto'];
		$data_vencimento    = date('dmY', strtotime($rbol['datavenci']));
    $data_processamento = date('dmY', strtotime($rbol['dataproc']));
    $data_desconto      = date('dmY', strtotime($rbol['DATADESCONTO']));
    $data_juros_multa   = $data_vencimento;
		$valor_boleto 	    = number_format($rbol['valor'],2,'','');
    $valor_desconto	    = number_format($rbol['VALORDESCONTO'],2,'','');
		$cod_cliente 		    = $rbol['codcliente'];
    $multa              = number_format($rbol['multa'],0,'',''); //tirando casas decimais caso tenha
    $juros              = number_format($rbol['juros'],0,'',''); //tirando casas decimais caso tenha
    //$juros = 1;  //valores usados nos testes
    //$multa = 10; //valores usados nos testes 
    //settype($multa,'integer'); //é gravado em formato texto no banco de dados
    //settype($juros,'integer'); //é gravado em formato texto no banco de dados
		    
		$scliente = "SELECT * FROM clientes WHERE CODIGO = '$cod_cliente'";
		$qcliente = mysql_query($scliente);
		$rcliente = mysql_fetch_assoc($qcliente);
		if($rcliente["PESSOA"] == "F") { $tipo_inscricao = 1; } else { $tipo_inscricao = 2; }
		
    $documento 	 		= preg_replace('/[^0-9]/', '', $rcliente['DOC']);
    $nome_sacado 		= substr(limpacaracteres(removeacentos($rcliente['RAZAO'])), 0, 39);
    $end_sacado  		= substr(limpacaracteres(removeacentos($rcliente['ENDERECO'])), 0, 39);
    $bairro_sacado  = substr(limpacaracteres(removeacentos($rcliente['BAIRRO'])), 0, 14);
    $cep_sacado  		= str_pad(preg_replace('/[^0-9]/', '', $rcliente['CEP']), 8, 0);
    $cidade_sacado  = substr(limpacaracteres(removeacentos($rcliente['CIDADE'])), 0, 14);
    $estado_sacado  = limpacaracteres(removeacentos($rcliente['ESTADO']));
    if (strlen(trim($bairro_sacado)) < 2) { $bairro_sacado = 'Centro'; }
		 
		//--- Segmento P ---
    $x++;
		$var_linha .= str_pad($codigobanco, 3, "") .                                                    	// 001 a 003 - Código do banco na compensação
									"0001" .                                                                            // 004 a 007 - Número do lote remessa
								  "3" .                                                                               // 008 a 008 - Tipo de registro
									str_pad($x, 5, 0, STR_PAD_LEFT) .                                                		// 009 a 013 - Nº Sequencial do registro de lote
									"P" .                                                                               // 014 a 014 - Cód. Segmento do registro detalhe
									" " .                                                                          			// 015 a 015 - Reservado
									"01" .                                                                              // 016 a 017 - Código de movimento remessa = entrada de titulos
									str_pad($agencia_remetente, 4, 0) .       		//4 char					  									// 018 a 021 - Agência do Cedente
									str_pad($agencia_dig_remetente, 1, 0) . 			//1 char						  								// 022 a 022 - Digito da agencia do cedente
									str_pad($conta_remetente, 9, 0) .							//9 char          										// 023 a 031 - Número da conta corrente
									str_pad($conta_dig_remetente, 1, 0) . 				//1 char           										// 032 a 032 - Digito verificador da conta
									str_pad($conta_remetente, 9, 0) .							//9 char          										// 033 a 041 - Conta Cobrança
									str_pad($conta_dig_remetente, 1, 0) .	  			//1 char           										// 042 a 042 - Digito da conta cobrança
									"  " .                                                                    					// 043 a 044 - Uso exclusivo do banco
									str_pad($nosso_numero, 12, 0, STR_PAD_LEFT) .	//12 char                           	// 045 a 057 - Identificação do titulo no banco
                  modulo11($nosso_numero) .                     //1 char dígito de verificação do nosso número
									"5" .                                                                               // 058 a 058 - Cobrança simples sem registro e eletronica com registro
									"1" .                                                                               // 059 a 059 - Forma de cadastramento (1 = cobrança registrada) (2 =cobrança sem registro)
									"1" .                                                                               // 060 a 060 - Tipo de documento (1= Tradicional) (2= Escritural)
									" " .                                                                          			// 061 a 061 - Reservado
									" " .                                                                          			// 062 a 062 - Reservado
                  str_pad($nosso_numero, 15, " ") .							//15 char                           	// 063 a 077 - Numero do documento
                  $data_vencimento . 																																	// 078 a 085 - Data de Vencimento
                  str_pad($valor_boleto, 15, 0, STR_PAD_LEFT) . 																			// 085 a 100 - Valor nominal do titulo
                  "0000" .                                                                            // 101 a 104 - Agência encarregada da cobrança
                  "0" .                                                                               // 105 a 105 - Digito da Agência do cedente
                  " " .                                                                               // 106 a 106 - Reservado
                  "04" .                                                                              // 107 a 108 - Especie de titulo // 04 = DS  |  DS = Duplicata de serviço 
                  "N" .                                                                               // 109 a 109 - Identificação do titulo (A = Aceito) (N = Não aceito)
                  $data_processamento;									                                             	// 110 a 117 - Data da emissão do titulo
									
									if($juros > 0){
									  $var_linha .= '2' .                                                               // 118 a 118 - Código de Juros de Mora. 2 = Taxa Mensal (Calculada por dia)
									  $data_juros_multa . 																															// 119 a 126 - Data do Juros de Mora
                    //str_pad(str_pad($juros,5,'0',STR_PAD_RIGHT), 15, '0', STR_PAD_LEFT);              // 127 a 141 - Juros de Mora por dia taxa
                    str_pad($juros.'00000', 15, '0', STR_PAD_LEFT);              // 127 a 141 - Juros de Mora por dia taxa
									} else
                  { $var_linha .= '3'.																																// 118 a 118 - Código de Juros de Mora. 3 = Isento
                          '00000000' .																																// 119 a 126 - Data do Juros de Mora
                          '000000000000000';																													// 127 a 141 - Juros de Mora por dia taxa
                  }

    $var_linha .= "0" .                                  																							// 142 a 142 - Código do desconto 1
                  str_pad('', 8, 0). //$data_vencimento . //str_pad('', 8, 0) .                    		// 143 a 150 - Data do Desconto 1
                  str_pad('', 15, 0). //str_pad('500', 15, 0, STR_PAD_LEFT).       										// 151 a 165 - Valor percentual a ser concedido
                  str_pad('', 15, 0).                    																							// 166 a 180 - Valor iof recolhido
                  str_pad('', 15, 0).                       																					// 181 a 195 - Valor abatimento
                  str_pad('', 25).                   																									// 196 a 220 - Identificação do titulo na empresa - Uso Beneficiário (Opcional)
									//$var_linha .= "1" .  . 							                                              // 221 a 221 - Código para protesto. (1 = Protestar dias corridos; 3 = Utilizar perfil cedente)
									"3" . "00" .                           																						  // 221 a 223 - Número de dias para protesto
                  "3" .                                  																							// 224 a 224 - Código para Baixa/Devolução
									"0" .                                  																							// 225 a 225 - Reservado
									"00" .                                 																							// 226 a 227 - Número de dias para baixa/devolução
									"00" .                                 																							// 228 a 229 - Código da Moeda. 0 = "Real"
									str_pad('', 11)."\r\n"; 																														// 230 a 240 - Reservado
									
									
		//--- Segmento Q ---
    $x++;
		$var_linha .= "033" .                                                                    					// 001 a 003 - Código do banco
								  "0001" .                                                                   					// 004 a 007 - Número do lote na remessa
								  "3" .                                                                      					// 008 a 008 - Tipo de Registro
								  str_pad($x, 5, 0, STR_PAD_LEFT) .          																					// 009 a 013 - Nº Sequencial
								  "Q" .                                                                      					// 014 a 014 - Código segmento do registro detalhe
								  " " .                                                                      					// 015 a 015 - Reservado
								  "01" .                                                                     					// 016 a 017 - Código de movimento de remessa
								  $tipo_inscricao .               													//1  char        					// 018 a 018 - Tipo de inscrição do sacado
								  str_pad($documento, 15, '0', STR_PAD_LEFT) .							//15 char			  					// 019 a 033 - Número de inscrição do sacado
								  str_pad($nome_sacado, 40, ' ') .													//40 char         				// 034 a 073 - Nome Sacado
								  str_pad($end_sacado, 40, ' ') .														//40 char			  					// 074 a 113 - Endereço Sacado
								  str_pad(substr($bairro_sacado, 0, 15), 15, ' ') .					//15 char									// 114 a 128 - Bairro Sacado   -   15 char
								  str_pad(str_replace('-', '', $cep_sacado), 8, ' ') .			//8  char        					// 129 a 136 - Cep Sacado + Sufixo CEP
								  str_pad($cidade_sacado, 15, ' ') .												//15 char		    					// 137 a 151 - Cidade do Sacado
								  str_pad($estado_sacado, 2, ' ') .													//2  char        					// 152 a 153 - Unidade da federação do sacado
								  "0" .                                                                      					// 154 a 154 - Tipo de Inscrição
								  str_pad('', 15, 0) .                                                       					// 155 a 169 - Nº de inscrição Sacador/Avalista
								  str_pad('', 40) .                                                       						// 170 a 209 - Nome do sacador avalista
								  "000" .                                                                    					// 210 a 212 - Identificador carne
								  "000" .                                                                    					// 213 a 215 - Sequencial da Parcela
								  "000" .                                                                    					// 216 a 218 - Quantidade total de parcelas
								  "000" .                                                                    					// 219 a 221 - Númeo do plano
								  str_pad('', 19)."\r\n";                            																	// 222 a 240 - Reservado
									
		//$var_valor_lote += $valor_boleto;
  	////mysql_query("UPDATE boletos SET numremessa='".$num_remessa."' WHERE codigo='".$rbol["codigo"]."'");
    //mysql_query("UPDATE boletos SET numremessa=1 WHERE codigo='".$rbol["codigo"]."'");
      
    //--- Segmento R ---
    $x++;
		$var_linha .= '033' .                                                          					// 03N - 001 a 003 - Código do banco
								  '0001' .                                                         					// 04N - 004 a 007 - Número do lote na remessa
								  '3' .                                                            					// 01N - 008 a 008 - Tipo de Registro
								  str_pad($x, 5, '0', STR_PAD_LEFT) .          															// 05N - 009 a 013 - Nº seqüencial do registro de lote
								  'R' .                                                            					// 01A - 014 a 014 - Código segmento do registro detalhe
								  ' ' .                                                            					// 01A - 015 a 015 - Reservado
								  '01' ;                                                           					// 02N - 016 a 017 - Código de movimento de remessa
                  if ($valor_desconto != '0' and $valor_desconto != '') {
                    $var_linha .= '1'  .                          													// 01N - 018 a 018 - Código do desconto 0=isento 1=fixo até data informada
								    str_pad($data_desconto, 8, '0', STR_PAD_LEFT) .				 	  	  					// 08N - 019 a 026 - Data do desconto 2
								    str_pad($valor_desconto, 15, '0', STR_PAD_LEFT);  			        				// 15N - 027 a 041 - Valor/Percentual a ser concedido
                  } else {
                    $var_linha .= '0'  .             												       					// 01N - 018 a 018 - Código do desconto 0=isento 1=fixo até data informada
								    str_pad('', 8, '0', STR_PAD_LEFT) .					 	  	             					// 08N - 019 a 026 - Data do desconto 2
								    str_pad('', 15, '0', STR_PAD_LEFT); 					                   				// 15N - 027 a 041 - Valor/Percentual a ser concedido
                  }
								  $var_linha .= str_pad('', 24, ' '); 		      						  	  					// 24A - 042 a 065 - Reservado (uso Banco)
                  if ($multa > 0)
                  { $var_linha .= '2' .			                                            		// 01N - 066 a 066 - Código da multa 1-fixo 2-percentual
								    str_pad($data_juros_multa, 8, '0', STR_PAD_LEFT) .			          			// 08N - 067 a 074 - Data da multa 
								    str_pad(number_format($multa,2,'',''), 15, '0', STR_PAD_LEFT);			    // 15N - 075 a 089 - Valor/Percentual a ser aplicado 
                  } else
                  { $var_linha .= '2' .			                                            		// 01N - 066 a 066 - Código da multa 1-fixo 2-percentual
								    str_pad('', 8, '0', STR_PAD_LEFT) .			          					            // 08N - 067 a 074 - Data da multa 
								    str_pad('0', 15, '0', STR_PAD_LEFT);			     			      					    // 15N - 075 a 089 - Valor/Percentual a ser aplicado 
                  }
								  $var_linha .= str_pad('', 10, ' ') .											       					// 10A - 090 a 099 - Reservado (uso Banco)
								  str_pad($rbol['INST3'], 40, ' ') .                                   					// 40A - 100 a 139 - Mensagem 3
								  str_pad($rbol['INST4'], 40, ' ') .                                   					// 40A - 140 a 179 - Mensagem 4 
								  str_pad('', 61, ' ') . "\r\n";                                 						// 61A - 180 a 240 - Reservado
								  
		//----------------
    $var_valor_lote += $valor_boleto;
  	mysql_query("UPDATE boletos SET status=3, controleremessa='$controle_remessa' WHERE codigo=".$rbol["codigo"]);
    //mysql_query("UPDATE boletos SET numremessa=2 WHERE codigo='".$rbol["codigo"]."'");
      
	}

	// ----------------------------------------- Trailer ----------------------------------------- //
	// Trailer do LOTE
  $x += 2; //adiciono as duas linhas do header
	$var_linha .= "033" .                                																							// 001 a 003 - Código do banco na compensação
								"0001" .                               																							// 004 a 007 - Número do lote remessa
								"5" .                                  																							// 008 a 008 - Tipo de registro
								str_pad(' ',9) .                    																								// 009 a 017 - Reservado
								str_pad($x, 6, 0, STR_PAD_LEFT) .     																							// 018 a 023 - Quantidade de registros do lote
								str_pad('', 217)."\r\n";                   																					// 024 a 240 - Brancos

	// Trailler DO ARQUIVO
  $x += 2; //adiciono as duas linhas do trailer
	$var_linha .= "033" .                                																							// 001 a 003 - Código do banco
								"9999" .                               																							// 004 a 007 - Número do lote na remessa
								"9" .                                  																							// 008 a 008 - Tipo de registro
								str_pad('', 9) .                     																								// 009 a 017 - Reservado
								"000001" .                             																							// 018 a 023 - Quantidade de lotes DO arquivo
								str_pad($x, 6, 0, STR_PAD_LEFT) . 											 														// 024 a 029 - Quantidade de registros do arquivo
								str_pad('',211);                    	 																							// 030 a 240 - Reservado

  $arquivo = "remessa_" . $controle_remessa . ".rem";
	$fp = fopen($dir_remessa.$arquivo, "w");
	$escreve = fwrite($fp, $var_linha); 
	
  echo "<BR><BR><a href='$dir_remessa$arquivo' download>Baixar Remessa remessa_$controle_remessa</a><br><br>Esta remessa contém $linhas boletos";
  //--------- DUMP ( NÃO REMOVER AS LINHAS ABAIXO ) -------------
  //echo '<BR><BR><BR><BR>DUMP:<BR><p style="font-size:10px"><pre>------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------'."\n";
  //echo $var_linha."\n";
  //echo '------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------'."\n".'</pre></p>';
?>