<div class="page-content">
  <div class="page-header">
    <h1>
      Listar Imóveis
    </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <div class="col-xs-12">
      <div class="col-xs-12 controle-chosen chosen100" style="margin-bottom:4rem;padding:0;">
      <table id="sample-table-1" class="table table-bordered table-noborder table-monocromatic tabela-listagem">
          <tr>
            <td align="center">
              Cidade:<br/>
              <?php
              $cidade = listar("cidade");?>
              <select name="cidade" id="cidade" class="form_cadastro_cidade chosen-select" onchange="atualiza_bairro()" style="width:160px;">
                <option value="0">Todas as cidades</option>
                <?php
                while($r = mysql_fetch_assoc($cidade)){
                  $selected = "";?>
                <option value="<?php echo $r["id"]; ?>"><?php echo $r["nome"]; ?></option>
                <?php
                }?>
              </select>
            </td>
            <td align="center">
              <div class="retorno_cascata_bairro">
              Bairro:<br/>
              <?php
              $bairro = listar("bairro");?>
              <select name="bairro" id="bairro" class="chosen-select" disabled>
                <option value="0">Selecione uma cidade</option>
              </select>
              </div>
            </td>
            <td align="center" colspan="2">
              Endereço:<br/>
              <input type="text" name="endereco" id="endereco" placeholder="" style="width:100%;">
            </td>
            <td align="center" colspan="4">
              Proprietário:<br/>
              <input type="text" name="proprietario" id="proprietario" placeholder="" style="width:100%;">
            </td>
          </tr>
          <tr>
            <td align="center">
              Finalidade:<br/>
              <?php
              $finalidade = listar("finalidade");?>
              <select name="finalidade" id="finalidade" style="width:100%;">
                <option value="0">Todas</option>
                <?php
                while($r = mysql_fetch_assoc($finalidade)){
                  $selected = "";
                  if($finalidade == $r["id"]){$selected = "selected";}?>
                <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
                <?php
                }?>
              </select>
            </td>
            <td align="center">
              Tipo:<br/>
              <?php
              $tipo = listar("tipo");?>
              <select name="tipo" id="tipo" class="chosen-select">
                <option value="0">Todos</option>
                <?php
                while($r = mysql_fetch_assoc($tipo)){
                  $selected = "";
                  // if($tipo == $r["id"]){$selected = "selected";}?>
                <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
                <?php
                }?>
              </select>
            </td>
            <td align="center">
              Disponível:<br/>
              <select name="disponivel" id="disponivel" style="width:100%;">
                <option value="S">Sim</option>
                <option value="N">Não</option>
                <option value="0">Todos</option>
              </select>
            </td>
            <td align="center">
              Valor Minimo:<br/>
              <input type="text" name="valor_min" id="valor_min" placeholder="" size="10" value="<?php echo $valor_min; ?>" style="width:100%;" class="money" data-affixes-stay="true" data-thousands="." data-decimal="," >
            </td>
            <td align="center">
              Valor Máximo:<br/>
              <input type="text" name="valor_max" id="valor_max" placeholder="" size="10" value="<?php echo $valor_max; ?>" style="width:100%;" class="money" data-affixes-stay="true" data-thousands="." data-decimal="," >
            </td>
            <td align="center" width="">
              Referência:<br/>
              <input type="text" name="ref" id="ref" placeholder="" size="10" value="<?php echo $ref; ?>" style="width:100%;">
            </td>
            <td align="center" width="100">
              Paginação:<br/>
              <input name="paginacao" <?php echo $checked; ?> id="paginacao" class="ace ace-switch ace-switch-6" type="checkbox" value="S" checked>
              <span class="lbl"></span>
            </td>
            <td align="center" width="100">
              <button class="btn btn-app btn-info btn-xs" style="height:4.4rem;width:auto;padding:0 2rem;" onclick="filtrar_listagem_imoveis()">
                <i class="fa fa-search" aria-hidden="true"></i> Buscar
              </button>
            </td>
          </tr>
        </table>
      </div>
      <style>
        .chosen100 .chosen-container{width:100% !important;}
      </style>
      <div class="retorno_filtrar_listagem_imoveis">
          <?php
          $sn = "SELECT * FROM imovel WHERE pre_cadastro <> 1 AND disponivel = 'S' ORDER BY id DESC";
          $qn = mysql_query($sn);
          echo "Total de imóveis encontrados: ".mysql_num_rows($qn);
          $sn .= " LIMIT 0,20";
          $imoveis = mysql_query($sn);?>
        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th class="center" width="50">FOTOS</th>
              <th class="center">REF</th>
              <th class="center" width="90">FINALIDADE</th>
              <th class="center">VALOR</th>
              <th class="center">TIPO</th>
              <th class="center">ENDEREÇO</th>
              <th class="center">BAIRRO</th>
              <th class="center">CIDADE</th>
              <th class="center">PROPRIETÁRIO</th>
              <th class="center">ATIVO</th>
              <th class="center">S DESTAQUE</th>
              <th class="center">DESTAQUE</th>
              <th class="center">FINANCIA</th>
              <th colspan="2">OPÇÕES</th>
            </tr>
          </thead>

          <tbody>
            <?php
            while($r = mysql_fetch_assoc($imoveis)){
              $get_finalidades = "SELECT * FROM imovel_finalidade WHERE id_imovel = '".$r['id']."'";
              $get_finalidades = mysql_query($get_finalidades);
              while($r_fin = mysql_fetch_assoc($get_finalidades)){?>
                <tr>
                  <td class="center">
                    <a href="?pg=gerenciar-fotos&id_imovel=<?php echo $r["id"]; ?>&check_marca=checked"><i class="far fa-images" style="font-size:2rem;"></a></i>
                  </td>
                  <td class="center"><?php echo $r["ref"]; ?></td>
                  <td class="center"><?php echo retorna_campo('finalidade','nome',$r_fin['id_finalidade']); ?></td>
                  <td class="center"><?php echo tratar_moeda($r_fin['valor'],2); ?></td>
                  <td class="center"><?php echo retorna_nome("tipo", $r["id_tipo"]); ?></td>
                  <td class="center"><?php echo $r["endereco"]; ?></td>
                  <td class="center"><?php echo retorna_nome("bairro", $r["id_bairro"]); ?></td>
                  <td class="center"><?php echo retorna_nome("cidade", $r["id_cidade"]); ?></td>
                  <td class="center"><?php echo retorna_nome("proprietario", $r["id_proprietario"]); ?></td>
                  <td class="center"><?php echo ativo($r["disponivel"]); ?></td>
                  <td class="center"><?php echo ativo($r["super_destaque"]); ?></td>
                  <td class="center"><?php echo ativo($r["destaque"]); ?></td>
                  <td class="center"><?php echo ativo($r["financia"]); ?></td>
                  <td class="center" width="30">
                    <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                      <a href="?pg=imovel&id_imovel=<?php echo $r["id"]; ?>" style="display:block;width:2.5rem;">
                        <button class="btn btn-xs btn-info" style="width:2.5rem;">
                          <i class="icon-edit bigger-120"></i>
                        </button>
                      </a>
                  </td>
                  <td class="center" width="30">
                      
                      <a href="javascript:void(0)" style="display:block;width:2.5rem;">
                      <button class="btn btn-xs btn-danger" onclick="confirmar_exclusao(<?php echo $r["id"]; ?>)">
                        <i class="icon-trash bigger-120"></i>
                      </button>
                      </a>
                    </div>
                  </td>
                </tr>
                <?php
              }
              if(mysql_num_rows($get_finalidades)<1){//nao tem finalidade?>
                <tr>
                  <td class="center">
                    <a href="?pg=gerenciar-fotos&id_imovel=<?php echo $r["id"]; ?>"><i class="far fa-images" style="font-size:2rem;"></a></i>
                  </td>
                  <td class="center"><?php echo $r["ref"]; ?></td>
                  <td class="center"></td>
                  <td class="center"></td>
                  <td class="center"><?php echo retorna_nome("tipo", $r["id_tipo"]); ?></td>
                  <td class="center"><?php echo $r["endereco"]; ?></td>
                  <td class="center"><?php echo retorna_nome("bairro", $r["id_bairro"]); ?></td>
                  <td class="center"><?php echo retorna_nome("cidade", $r["id_cidade"]); ?></td>
                  <!--td class="center"><?php echo tratar_moeda($r["valor"],2); ?></td-->
                  <td class="center"><?php echo ativo($r["disponivel"]); ?></td>
                  <td class="center"><?php echo ativo($r["super_destaque"]); ?></td>
                  <td class="center"><?php echo ativo($r["destaque"]); ?></td>
                  <td class="center"><?php echo ativo($r["financia"]); ?></td>
                  <td class="center" width="30">
                    <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">
                      <a href="?pg=imovel&id_imovel=<?php echo $r["id"]; ?>" style="display:block;width:2.5rem;">
                        <button class="btn btn-xs btn-info" style="width:2.5rem;">
                          <i class="icon-edit bigger-120"></i>
                        </button>
                      </a>
                  </td>
                  <td class="center" width="30">
                      
                      <a href="javascript:void(0)" style="display:block;width:2.5rem;">
                      <button class="btn btn-xs btn-danger" onclick="confirmar_exclusao(<?php echo $r["id"]; ?>)">
                        <i class="icon-trash bigger-120"></i>
                      </button>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php
              }
            }
            if(mysql_num_rows($imoveis)<1){?>
            <tr><td colspan="15" align="center" style="line-height:50px;">Nenhum imóvel cadastrado</td></tr>
            <?php
            }?>
          </tbody>
        </table>
        
        <?php
        $teste_paginas = mysql_query('SELECT * FROM imovel WHERE pre_cadastro <> 1 AND disponivel = "S"');
        $total_imoveis = mysql_num_rows($teste_paginas);
        $total_paginas = ceil($total_imoveis / 20);
        if($total_paginas > 1){?>
        <div class="container_paginacao_listagem">
          <div class="subcontainer_paginacao_listagem">
            <div class="container_paginacao_listagem_opt ">Primeira</div>
            <div class="container_paginacao_listagem_opt ativo">1</div>
            <div class="container_paginacao_listagem_opt pointer" onclick="filtrar_listagem_imoveis(2)">2</div>
            <div class="container_paginacao_listagem_opt pointer" onclick="filtrar_listagem_imoveis(3)">3</div>
            <div class="container_paginacao_listagem_opt pointer" onclick="filtrar_listagem_imoveis('<?php echo $total_paginas; ?>')">Última</div>
          </div>
        </div>
        <?php
        }?>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>
<script src="assets/js/bootbox.min.js"></script>
<script src="js/jquery.maskMoney.min.js" type="text/javascript"></script>

<script type="text/javascript">
  
  function confirmar_exclusao(id_imovel){
    bootbox.prompt("Digite sua senha para confirmar a exclusão", function(result) {
      if (result === null) {
        
      } else {
        window.location.assign("inc/excluir_imovel.php?id_imovel="+id_imovel+"&senha="+result);
      }
    })
    $(".bootbox-input").attr('type', 'password');
  }

  $(function() {
    $('.money').maskMoney();
  });
</script>