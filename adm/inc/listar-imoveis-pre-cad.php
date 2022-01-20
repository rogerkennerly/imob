<div class="page-content">
  <div class="page-header">
    <h1>
      Listar Imóveis
    </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <div class="col-xs-12">
      <!-- <div class="col-xs-12 controle-chosen chosen100" style="margin-bottom:4rem;padding:0;">

      </div> -->
      <!-- <style>
        .chosen100 .chosen-container{width:100% !important;}
      </style> -->
      
      <div class="retorno_filtrar_listagem_imoveis">
        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
          <thead>
            <tr>
              <th class="center">FOTOS</th>
              <th class="center">REF</th>
              <th class="center">FINALIDADES</th>
              <th class="center">TIPO</th>
              <th class="center">ENDEREÇO</th>
              <th class="center">BAIRRO</th>
              <th class="center">CIDADE</th>
              <!--th class="center">VALOR</th> O VALOR NÃO É EXIBIDO PORQUE O IMOVEL PODE TER MAIS DE UMA FINALIDADE E CADA FINALIDADE TEM UM VALOR -->
              <th class="center">ATIVO</th>
              <th class="center">S DESTAQUE</th>
              <th class="center">DESTAQUE</th>
              <th class="center">FINANCIA</th>
              <th colspan="2">OPÇÕES</th>
            </tr>
          </thead>

          <?php
          $imoveis = mysql_query("SELECT * FROM imovel WHERE pre_cadastro = 1 ORDER BY id DESC");?>
          <tbody>
            <?php
            while($r = mysql_fetch_assoc($imoveis)){?>
            <tr>
              <td class="center">
                <a href="?pg=gerenciar-fotos&id_imovel=<?php echo $r["id"]; ?>&check_marca=checked"><i class="far fa-images" style="font-size:2rem;"></a></i>
              </td>
              <td class="center"><?php echo $r["ref"]; ?></td>
              <td class="center"><?php echo finalidade_listar_unico($r["id"]); ?></td>
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
            if(mysql_num_rows($imoveis)<1){?>
            <tr><td colspan="15" align="center" style="line-height:50px;">Nenhum imóvel cadastrado</td></tr>
            <?php
            }?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>
<script src="assets/js/bootbox.min.js"></script>

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
</script>