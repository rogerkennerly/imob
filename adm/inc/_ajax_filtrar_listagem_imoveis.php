<?php
  include "../../config.php";
  include "../../conexao.php";
  include "../funcoes.php";
  
  $proprietario  = evita_injection($_GET["proprietario"]);
  $endereco      = evita_injection($_GET["endereco"]);
  $id_bairro     = evita_injection($_GET["id_bairro"]);
  $id_cidade     = evita_injection($_GET["id_cidade"]);
  $id_finalidade = evita_injection($_GET["id_finalidade"]);
  $id_tipo       = evita_injection($_GET["id_tipo"]);
  $disponivel    = evita_injection($_GET["disponivel"]);
  $valor_min     = evita_injection(tratar_moeda($_GET["valor_min"],1));
  $valor_max     = evita_injection(tratar_moeda($_GET["valor_max"],1));
  $ref           = evita_injection($_GET["ref"]);
  $paginacao     = evita_injection($_GET["paginacao"]);
  $pagina        = evita_injection($_GET["pagina"]);

  
  $s = "SELECT * FROM imovel WHERE pre_cadastro <> 1";
  if($ref){
    $s .= " AND ref = '$ref'";
  }else{
    if($proprietario){
      $s .= " AND id_proprietario IN (SELECT id FROM proprietario WHERE nome like '%$proprietario%')";
      $controle_and = 1;
    }
    if($endereco){
      $s .= " AND endereco like '%$endereco%'";
      $controle_and = 1;
    }
    if($id_bairro > 0){
      $s .= " AND id_bairro = '$id_bairro'";
      $controle_and = 1;
    }
    if($id_cidade > 0){
      $s .= " AND id_cidade = '$id_cidade'";
      $controle_and = 1;
    }
    if($id_finalidade > 0){
      $s .= " AND id IN (SELECT id_imovel FROM imovel_finalidade WHERE id_finalidade = '$id_finalidade')";
      $controle_and = 1;
    }
    if($valor_min > 0){
      $s .= " AND id IN (SELECT id_imovel FROM imovel_finalidade WHERE valor >= '$valor_min')";
      $controle_and = 1;
    }
    if($valor_max > 0){
      $s .= " AND id IN (SELECT id_imovel FROM imovel_finalidade WHERE valor <= '$valor_max')";
      $controle_and = 1;
    }
    if($id_tipo > 0){
      $s .= " AND id_tipo = '$id_tipo'";
      $controle_and = 1;
    }
    if($disponivel == 'S' OR $disponivel == 'N'){
      $s .= " AND disponivel = '$disponivel'";
      $controle_and = 1;
    }
  }
  $s .= " ORDER BY id DESC";
  // echo $s;
  
  $total = mysql_query($s);
  
  if($paginacao == 'S'){
    $num_imoveis_pagina = 20;
    if($pagina AND $pagina>0){
      $limite = ($pagina-1)*$num_imoveis_pagina;
    }
    else{
      $limite = 0;
    }
    $teste_paginas = $s;
    
    $s .= " LIMIT $limite,$num_imoveis_pagina";
  }

  // echo $s;
  
  $imoveis = mysql_query($s);
  echo "Total de imóveis encontrados: ".mysql_num_rows($total);
?>

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
      if($valor_min){$get_finalidades .= " AND valor >= '$valor_min'";}
      if($valor_max){$get_finalidades .= " AND valor <= '$valor_max'";}
      $get_finalidades = mysql_query($get_finalidades);
      while($r_fin = mysql_fetch_assoc($get_finalidades)){?>
        <tr>
          <td class="center">
            <a href="?pg=gerenciar-fotos&id_imovel=<?php echo $r["id"]; ?>"><i class="far fa-images" style="font-size:2rem;"></a></i>
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
          <td class="center"><?php echo retorna_nome("proprietario", $r["id_proprietario"]); ?></td>
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
      <tr><td colspan="15" align="center" style="line-height:50px;">Nenhum imóvel encontrado com os termos pesquisados</td></tr>
    <?php
    }?>
  </tbody>
</table>


<?php
  if($paginacao == 'S'){
    $teste_paginas = mysql_query($teste_paginas);
    $total_imoveis = mysql_num_rows($teste_paginas);
    $total_paginas = ceil($total_imoveis / $num_imoveis_pagina);

    if(!$pagina OR $pagina<1){$pagina = 1;}

    if($total_paginas > 1){
    ?>
      <div class="container_paginacao_listagem">
        <div class="subcontainer_paginacao_listagem">
          <?php    
          $primeira = '';
          $pointer  = '';
          if($pagina>1){$primeira = 'onclick="filtrar_listagem_imoveis(1)"'; $pointer = 'pointer';}?>
          <div class="container_paginacao_listagem_opt <?php echo $pointer; ?>" <?php echo $primeira; ?>>Primeira</div>
          
          <?php
          $n1 = $pagina-1;
          if($n1>0){
            $primeira = '';
            $pointer  = '';
            if($pagina>1){$primeira = 'onclick="filtrar_listagem_imoveis('.$n1.')"'; $pointer = 'pointer';}?>
            <div class="container_paginacao_listagem_opt <?php echo $pointer; ?>" <?php echo $primeira; ?>><?php echo $n1; ?></div>
          <?php
          }?>
          
          <div class="container_paginacao_listagem_opt pointer ativo" onclick="filtrar_listagem_imoveis(2)"><?php echo $pagina; ?></div>
          
          <?php
          $n2 = $pagina+1;
          if($n2<=$total_paginas){
            $primeira = '';
            $pointer  = '';
            if($pagina<$total_paginas){$primeira = 'onclick="filtrar_listagem_imoveis('.$n2.')"'; $pointer = 'pointer';}?>
            <div class="container_paginacao_listagem_opt pointer <?php echo $pointer; ?>" <?php echo $primeira; ?>><?php echo $n2; ?></div>
          <?php
          }?>
          
          <div class="container_paginacao_listagem_opt pointer" onclick="filtrar_listagem_imoveis('<?php echo $total_paginas; ?>')">Última</div>
        </div>
      </div>
    <?php
    }
  }
?>