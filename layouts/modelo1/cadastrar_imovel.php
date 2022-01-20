<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
   $agora = date('Y-m-d H:i:s');
   if($_POST){
      $finalidade = evita_injection($_POST['finalidade']);
      $tipo       = evita_injection($_POST['tipo']);
      $cidade     = evita_injection($_POST['cidade']);
      $bairro     = evita_injection($_POST['bairro']);
      $cep        = evita_injection($_POST['cep']);
      $endereco   = evita_injection($_POST['endereco']);
      $maisinfo   = evita_injection($_POST['maisinfo']);
      $nome       = evita_injection($_POST['nome']);
      $email      = evita_injection($_POST['email']);
      $telefone   = evita_injection($_POST['telefone']);
      $outrasinfo = evita_injection($_POST['outrasinfo']);

      $s_nome_proprietario = "SELECT nome FROM proprietario WHERE nome = '$nome'";
      $q_nome_proprietario = mysql_query($s_nome_proprietario);
      if(mysql_num_rows($q_nome_proprietario) < 1){
         $i_proprietario = "INSERT INTO proprietario (
         nome, 
         rg, 
         cpf, 
         data_nascimento, 
         telefone, 
         celular, 
         email, 
         cidade, 
         bairro, 
         cep, 
         endereco, 
         detalhes, 
         data_cadastro
         ) VALUES (
         '$nome',
         '',
         '',
         '',
         '$telefone',
         '',
         '$email',
         '',
         '',
         '',
         '',
         '',
         NOW()
         )";

         $q_proprietario = mysql_query($i_proprietario);

         if($q_proprietario){
            $s_id_proprietario = "SELECT id FROM proprietario WHERE nome = '$nome'";
            $q_id_proprietario = mysql_query($s_id_proprietario);
            $r_id_proprietario = mysql_fetch_assoc($q_id_proprietario);
            $proprietario      = $r_id_proprietario['id'];
         }
         else{
            $proprietario      = '';
         }

         $i_cadastro_imovel = "INSERT INTO imovel (
         ref,
         id_proprietario,
         id_corretor,
         id_tipo,
         id_cidade,
         id_bairro,
         endereco,
         cep,
         detalhes,
         disponivel,
         super_destaque,
         destaque,
         financia,
         quarto,
         suite,
         banheiro,
         garagem,
         sala,
         terreno,
         area_construida,
         video,
         data_cadastro,
         pre_cadastro
         ) VALUES (
         '',
         '$proprietario',
         '',
         '$tipo',
         '$cidade',
         '$bairro',
         '$endereco',
         '$cep',
         '',
         'N',
         'N',
         'N',
         'N',
         '',
         '',
         '',
         '',
         '',
         '',
         '',
         '',
         '$agora',
         '1'
         )";

         $q_cadastro_imovel = mysql_query($i_cadastro_imovel);
         $id_imovel = mysql_insert_id();

         $i_imovel_finalidade = "INSERT INTO imovel_finalidade (id_imovel, id_finalidade, valor, iptu, condominio) VALUES ('$id_imovel', '$finalidade', '0.00', '0.00', '0.00')";
         $q_imovel_finalidade = mysql_query($i_imovel_finalidade);

         if($q_cadastro_imovel){?>
            <script>
               alert('Imóvel cadastrado e enviado para aprovação.');
            </script><?php
         }
         else{?>
            <script>
               alert('Não foi possível cadastar o imóvel. Tente novamente.');
            </script><?php
         }
      }
      else{?>
         <script>
            alert('Já existe um proprietário com o nome <?php echo $nome; ?>');
         </script><?php
      }
   }
?>
<section class="imob_cadastrar_imovel">
   <div class="centralizador">
      <div class="imob_cadastrar_imovel_titulo">
         <h1>Cadastre seu Imóvel</h1>
      </div>
      <div class="imob_cadastrar_imovel_form">
         <form action="" method="POST"" id="imob_form_cadastrar_imovel">
            <div class="imob_form_cadastrar_imovel_aviso">
               <span>Campos com (*) são de preenchimento obrigatório</span>
            </div>
            <div class="imob_form_cadastrar_imovel_dados_1">
               <h2>Dados do Imóvel</h2>
               <div class="imob_form_cadastrar_imovel_bloco" id="bloco_quero">
                  <div class="imob_form_cadastrar_imovel_label">
                     <label>Finalidade *</label>
                  </div>
                  <div class="imob_form_cadastrar_imovel_select">
                     <select name="finalidade" id="finalidade" class="cor_outline" required>
                        <option selected disabled>Selecione</option>
                        <?php
                           $s_finalidades = 'SELECT * FROM finalidade';
                           $q_finalidades = mysql_query($s_finalidades);

                           while($finalidade = mysql_fetch_assoc($q_finalidades)){?>
                              <option value="<?php echo $finalidade['id']; ?>"><?php echo $finalidade['nome']; ?></option><?php
                           }
                        ?>
                     </select>
                  </div>
               </div>
               <div class="imob_form_cadastrar_imovel_bloco" id="bloco_tipo">
                  <div class="imob_form_cadastrar_imovel_label">
                     <label>Tipo *</label>
                  </div>
                  <div class="imob_form_cadastrar_imovel_select">
                     <select name="tipo" id="tipo" class="cor_outline" required>
                        <option selected disabled>Selecione</option>
                        <?php
                           $s_tipos = 'SELECT * FROM tipo';
                           $q_tipos = mysql_query($s_tipos);

                           while($tipo = mysql_fetch_assoc($q_tipos)){?>
                              <option value="<?php echo $tipo['id']; ?>"><?php echo $tipo['nome']; ?></option><?php
                           }
                        ?>
                     </select>
                  </div>
               </div>
               <div class="imob_form_cadastrar_imovel_bloco" id="bloco_cidade">
                  <div class="imob_form_cadastrar_imovel_label">
                     <label>Cidade *</label>
                  </div>
                  <div class="imob_form_cadastrar_imovel_select">
                     <select name="cidade" id="cidade" class="cor_outline" required onchange="getBairros(this.value);">
                        <option selected disabled>Selecione</option>
                        <?php
                           $s_cidades = 'SELECT * FROM cidade';
                           $q_cidades = mysql_query($s_cidades);

                           while($cidade = mysql_fetch_assoc($q_cidades)){?>
                              <option value="<?php echo $cidade['id']; ?>"><?php echo $cidade['nome']; ?></option><?php
                           }
                        ?>
                     </select>
                  </div>
               </div>
               <div class="imob_form_cadastrar_imovel_bloco" id="bloco_bairro">
                  <div class="imob_form_cadastrar_imovel_label">
                     <label>Bairro *</label>
                  </div>
                  <div class="imob_form_cadastrar_imovel_select retorno_bairros">
                     <h1>Selecione</h1>
                  </div>
               </div>
               <div class="imob_form_cadastrar_imovel_bloco" id="bloco_endereco">
                  <div class="imob_form_cadastrar_imovel_label">
                     <label>Endereço *</label>
                  </div>
                  <div class="imob_form_cadastrar_imovel_input">
                     <input type="text" name="endereco" id="endereco" class="cor_outline" required>
                  </div>
               </div>
               <div class="imob_form_cadastrar_imovel_bloco" id="bloco_cep">
                  <div class="imob_form_cadastrar_imovel_label">
                     <label>Cep *</label>
                  </div>
                  <div class="imob_form_cadastrar_imovel_input">
                     <input type="text" name="cep" id="cep" class="cor_outline" required>
                  </div>
               </div>
               <div class="hack"></div>
               <div class="imob_form_cadastrar_imovel_bloco" id="bloco_maisinfo">
                  <div class="imob_form_cadastrar_imovel_label">
                     <label>Mais Informações</label>
                  </div>
                  <div class="imob_form_cadastrar_imovel_textarea">
                     <textarea name="maisinfo" id="maisinfo" class="cor_outline"></textarea>
                  </div>
               </div>
            </div>

            <div class="imob_form_cadastrar_imovel_dados_2">
               <h2>Dados do Proprietário</h2>
               <div class="imob_form_cadastrar_imovel_bloco" id="bloco_nome">
                  <div class="imob_form_cadastrar_imovel_label">
                     <label>Nome *</label>
                  </div>
                  <div class="imob_form_cadastrar_imovel_input">
                     <input type="text" name="nome" id="nome" class="cor_outline" required>
                  </div>
               </div>
               <div class="imob_form_cadastrar_imovel_bloco" id="bloco_email">
                  <div class="imob_form_cadastrar_imovel_label">
                     <label>E-mail *</label>
                  </div>
                  <div class="imob_form_cadastrar_imovel_input">
                     <input type="text" name="email" id="email" class="cor_outline" required>
                  </div>
               </div>
               <div class="imob_form_cadastrar_imovel_bloco" id="bloco_telefone">
                  <div class="imob_form_cadastrar_imovel_label">
                     <label>Telefone *</label>
                  </div>
                  <div class="imob_form_cadastrar_imovel_input">
                     <input type="text" name="telefone" id="telefone" class="cor_outline" required>
                  </div>
               </div>
               <div class="hack"></div>
               <div class="imob_form_cadastrar_imovel_bloco" id="bloco_outrasinfop">
                  <div class="imob_form_cadastrar_imovel_label">
                     <label>Outras Informações</label>
                  </div>
                  <div class="imob_form_cadastrar_imovel_textarea">
                     <textarea name="outrasinfo" id="outrasinfo" class="cor_outline"></textarea>
                  </div>
               </div>
               <div class="hack"></div>
               <div class="imob_form_cadastrar_imovel_bloco" id="bloco_botao">
                  <div class="imob_form_cadastrar_imovel_button">
                     <button class="cor_botao" onclick="$('#imob_form_cadastrar_imovel').submit();">Cadastrar Imóvel</button>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
</section>
