<?php
  if($_GET['modulo'] == 'gbol'){mysql_set_charset('utf8', $link);}
  $tabela = "cliente";
  $msg = "";

  if($_GET["op"] == "excluir"){
    $id_registro = evita_injection($_GET["id_cliente"]);
		$steste = "SELECT id FROM cliente WHERE id = '$id_registro' AND id_corretor = '".$_SESSION["sessao_id_user"]."'";
		$qteste = mysql_query($steste);
		if(mysql_num_rows($qteste)>0){
			mysql_query("DELETE FROM $tabela WHERE id = '$id_registro'");
			echo $msg = sucesso("Cliente excluido com sucesso!");
		}
		else{
			echo $msg = alerta("Cliente não encontrado.");
		}
  }
  
  if($_GET["op"] == "editar"){
    $id_registro = evita_injection($_GET["id_registro"]);
    $campo_editar = retorna_campo($tabela, "nome", $id_registro);
    $op = "alterar";
  }

  $nome_pesquisar     = evita_injection($_POST["nome_pesquisar"]);
  $rg_pesquisar       = evita_injection($_POST["rg_pesquisar"]);
  $cpf_pesquisar      = evita_injection($_POST["cpf_pesquisar"]);
  $telefone_pesquisar = evita_injection($_POST["telefone_pesquisar"]);
  $celular_pesquisar  = evita_injection($_POST["celular_pesquisar"]);
  $email_pesquisar    = evita_injection($_POST["email_pesquisar"]);
  $cidade_pesquisar   = evita_injection($_POST["cidade_pesquisar"]);
  $bairro_pesquisar   = evita_injection($_POST["bairro_pesquisar"]);
  $cep_pesquisar      = evita_injection($_POST["cep_pesquisar"]);
  $endereco_pesquisar = evita_injection($_POST["endereco_pesquisar"]);
  
  $s = "SELECT * FROM $tabela WHERE id > 0";
  
  $controle_and = 0;
  
  $config = listar("config");
  $config = mysql_fetch_assoc($config);
  if($nome_pesquisar OR $rg_pesquisar OR $cpf_pesquisar OR $telefone_pesquisar OR $celular_pesquisar OR $email_pesquisar OR $cidade_pesquisar OR $bairro_pesquisar OR $cep_pesquisar OR $endereco_pesquisar OR ($config['restricao_proprietarios'] == 'S' AND $_SESSION["sessao_tipo_user"] == 1)){
    $controle_and = 1;
  }
  if($nome_pesquisar){
    if($controle_and){$s .= " AND ";}
    $s .= "nome like '%$nome_pesquisar%'";
    $controle_and = 1;
  }
  if($rg_pesquisar){
    if($controle_and){$s .= " AND ";}
    $s .= "rg like '%$rg_pesquisar%'";
    $controle_and = 1;
  }
  if($cpf_pesquisar){
    if($controle_and){$s .= " AND ";}
    $s .= "cpf like '%$cpf_pesquisar%'";
    $controle_and = 1;
  }
  if($telefone_pesquisar){
    if($controle_and){$s .= " AND ";}
    $s .= "telefone like '%$telefone_pesquisar%'";
    $controle_and = 1;
  }
  if($celular_pesquisar){
    if($controle_and){$s .= " AND ";}
    $s .= "celular like '%$celular_pesquisar%'";
    $controle_and = 1;
  }
  if($email_pesquisar){
    if($controle_and){$s .= " AND ";}
    $s .= "email like '%$email_pesquisar%'";
    $controle_and = 1;
  }
  if($cidade_pesquisar){
    if($controle_and){$s .= " AND ";}
    $s .= "cidade like '%$cidade_pesquisar%'";
    $controle_and = 1;
  }
  if($bairro_pesquisar){
    if($controle_and){$s .= " AND ";}
    $s .= "bairro like '%$bairro_pesquisar%'";
    $controle_and = 1;
  }
  if($cep_pesquisar){
    if($controle_and){$s .= " AND ";}
    $s .= "cep like '%$cep_pesquisar%'";
    $controle_and = 1;
  }
  if($endereco_pesquisar){
    if($controle_and){$s .= " AND ";}
    $s .= "endereco like '%$endereco_pesquisar%'";
    $controle_and = 1;
  }
	
	if($_SESSION["sessao_tipo_user"] == 1){
		$s .= " AND id_corretor = '".$_SESSION["sessao_id_user"]."'";
	}
	
  $s .= " ORDER BY nome";
  // echo $s;
  $q = mysql_query($s);
  
  if($_GET["ok"] == 1){
    echo sucesso("Cliente <strong>".$_GET["nome"]."</strong> incluido com sucesso!");
  }
?>

<div class="page-content">
  <div class="page-header">
    <h1>
      Cliente
    </h1>
  </div><!-- /.page-header -->

  <div class="row">      
    <div class="col-xs-12">
    <div class="col-xs-12 controle-chosen" style="margin-bottom:4rem;padding:0;">
      <form method="POST" action="" id="form_pesquisa_proprietario"> 
        <table id="sample-table-1" class="table table-bordered table-noborder table-monocromatic tabela-listagem-12">
            <tr>
              <td width="265">
                Nome:<br/>
                <input type="text" name="nome_pesquisar" style="width:100%;" value="<?php echo $_POST["nome_pesquisar"];?>">
              </td>
              <td>
                RG:<br/>
                <input type="text" name="rg_pesquisar" style="width:100%;"  style="width:100%;" value="<?php echo $_POST["rg_pesquisar"];?>">
              </td>
              <!--td>
                CPF:<br/>
                <input type="text" name="cpf_pesquisar"  style="width:100%;" value="<?php echo $_POST["cpf_pesquisar"];?>">
              </td-->
              <td>
                Telefone:<br/>
                <input type="text" name="telefone_pesquisar"  style="width:100%;" value="<?php echo $_POST["telefone_pesquisar"];?>">
              </td>
              <td>
                Celular:<br/>
                <input type="text" name="celular_pesquisar"  style="width:100%;" value="<?php echo $_POST["celular_pesquisar"];?>">
              </td>
              <td width="255">
                E-mail:<br/>
                <input type="text" name="email_pesquisar"  style="width:100%;" value="<?php echo $_POST["email_pesquisar"];?>">
              </td>
            </tr>
            <tr>
              <td width="260">
                Cidade:<br/>
                <input type="text" name="cidade_pesquisar"  style="width:100%;" value="<?php echo $_POST["cidade_pesquisar"];?>">
              </td>
              <td width="260">
                Bairro:<br/>
                <input type="text" name="bairro_pesquisar"  style="width:100%;" value="<?php echo $_POST["bairro_pesquisar"];?>">
              </td>
              <!--td width="260">
                CEP:<br/>
                <input type="text" name="cep_pesquisar"  style="width:100%;" value="<?php echo $_POST["cep_pesquisar"];?>">
              </td-->
              <td colspan="2">
                Endereço:<br/>
                <input type="text" name="endereco_pesquisar"  style="width:100%;" value="<?php echo $_POST["endereco_pesquisar"];?>">
              </td>
              <td align="center" width="400">
                <button class="btn btn-app btn-info btn-xs" style="height:4.4rem;width:auto;padding:0 2rem;" onclick="$('#form_pesquisa_proprietario').submit()">
                  <i class="fa fa-search" aria-hidden="true"></i> Buscar
                </button>
              </td>
            </tr>
        </table>
        <input type="submit" style="display:none;">
      </form>
      </div>
      
      
      <table id="sample-table-1" class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th>NOME</th>
            <th class="center">RG</th>
            <!--th class="center">CPF</th-->
            <th class="center">TELEFONE</th>
            <th class="center">CELULAR</th>
            <th class="center">E-MAIL</th>
            <th class="center">CIDADE</th>
            <th class="center">BAIRRO</th>
            <th class="center">ENDEREÇO</th>
            <th class="center">PREFERENCIAS</th>
            <th class="center">EDITAR PREFERENCIAS</th>
            <th class="center">IMÓVEIS DE INTERESSE</th>
            <th class="center" colspan="2">OPÇÕES</th>
          </tr>
        </thead>
        <tbody>
          <?php
					$_SESSION['refs'] = array();
          while($r = mysql_fetch_assoc($q)){
						$sp = "SELECT * FROM cliente_preferencia WHERE id_cliente  = '".$r['id']."'";
						$qp = mysql_query($sp);
						$rp = mysql_fetch_assoc($qp);
						
						$total_imo = 0;
						$preferencias_cadastradas = 0;
						if(mysql_num_rows($qp)>0){
							$preferencias_cadastradas = 1;
							
							$si = "SELECT ref FROM imovel WHERE disponivel = 'S'";
							
							if($rp['cidades']){
								$si .= " AND id_cidade = '".$rp['cidades']."'";
							}
							
							if($rp['bairros'] AND $rp['bairros'] != "-0"){
								$si .= " AND (";
								$bairros = explode("-", $rp['bairros']);
								$bairros = array_filter($bairros);
								sort($bairros);
								for($x=0;$x<count($bairros);$x++){
									$si .=" id_bairro = '".$bairros[$x]."'";
									if($x < count($bairros) - 1){ $si .= " OR "; }
								}
								$si .= ")";
							}
							
							if($rp['tipos']){
								$si .= " AND (";
								$tipos = explode("-", $rp['tipos']);
								$tipos = array_filter($tipos);
								sort($tipos);
								for($x=0;$x<count($tipos);$x++){
									$si .=" id_tipo = '".$tipos[$x]."'";
									if($x < count($tipos) - 1){ $si .= " OR "; }
								}
								$si .= ")";
							}
							
							if($rp['quartos']){
								$si .= " AND quarto >= '".$rp['quartos']."'";
							}
							
							if($rp['suites']){
								$si .= " AND suite >= '".$rp['suites']."'";
							}
							
							if($rp['banheiros']){
								$si .= " AND banheiro >= '".$rp['banheiros']."'";
							}
							
							if($rp['garagem']){
								$si .= " AND garagem >= '".$rp['garagem']."'";
							}
							
							// if($rp['area_total']){
								// $si .= " AND terreno >= '".$rp['area_total']."'";
							// }
							
							// if($rp['area_util']){
								// $si .= " AND area_construida >= '".$rp['area_util']."'";
							// }
							
							if($rp['itens']){
								$itens = explode("-", $rp['itens']);
								$itens = array_filter($itens);
								sort($itens);
								for($x=0;$x<count($itens);$x++){
									$si .=" AND id IN ( SELECT id_imovel FROM imovel_item WHERE id_item = '".$itens[$x]."')";
								}
							}
							
							if($rp['finalidades']){
								$finalidades = explode("-", $rp['finalidades']);
								$finalidades = array_filter($finalidades);
								sort($finalidades);
								$valmax = ''; $valmin = '';
								if($rp['valor_max']){
									$valmax = "AND valor <= '".$rp['valor_max']."'";
								}
								if($rp['valor_min']){
									$valmin = "AND valor >= '".$rp['valor_min']."'";
								}
								for($x=0;$x<count($finalidades);$x++){
									$si .=" AND id IN ( SELECT id_imovel FROM imovel_finalidade WHERE id_finalidade = '".$finalidades[$x]."' $valmax $valmin)";
								}
							}
							// echo $si;
							$qi = mysql_query($si);
							$total_imo = mysql_num_rows($qi);
						}
						
						$id_clientex = $r['id'];
						while($ri = mysql_fetch_assoc($qi)){
							$_SESSION['refs'][$id_clientex][] = $ri['ref'];
						}
						// var_dump($_SESSION['refs'][$id_clientex]);
						
						// echo $id_clientex." = ".$si."<br>";
					?>
          <tr>
            <td><?php echo $r["nome"]; ?></td>
            <td class="center"><?php echo $r["rg"]; ?></td>
            <!--td class="center"><?php echo $r["cpf"]; ?></td-->
            <td class="center"><?php echo $r["telefone"]; ?></td>
            <td class="center"><?php echo $r["celular"]; ?></td>
            <td class="center"><?php echo $r["email"]; ?></td>
            <td class="center"><?php echo $r["cidade"]; ?></td>
            <td class="center"><?php echo $r["bairro"]; ?></td>
            <td class="center"><?php echo $r["endereco"]; ?></td>
            <td class="center"><?php if($preferencias_cadastradas == 1){ echo '<i class="fas fa-check-square" style="color:#4fb34f;font-size:2rem;"></i>'; }else{ echo '<i class="fas fa-window-close" style="color:red;font-size:2rem;"></i>'; } ?></td>
            <td class="center">
              <a href="<?php echo '?pg=preferencias-cliente&id_cliente='.$r["id"]; ?>">EDITAR PREFERENCIAS</a>
            </td>
            <td class="center">
              <a href="?pg=listar-imoveis&op=list_cliente&id_cliente=<?php echo $r['id']; ?>"><?php echo $total_imo; ?> IMÓVEIS</a>
            </td>
            <td class="center">
              <?php
              $link = '?pg=incluir-cliente&op=editar&id_cliente='.$r["id"];
              if($_GET['modulo'] == 'gbol'){$link = '?modulo=gbol&pg=inc_clientes&op=editar&id_cliente='.$r["id"];}
              ?>
              <a href="<?php echo $link; ?>"><i class="fas fa-edit" style="font-size:1.8rem;color:#666;"></i></a>
            </td>
            <td class="center">
              <a href="?pg=listar-cliente&op=excluir&id_cliente=<?php echo $r["id"] ?>" onclick="return confirm('Deseja excluir o proprietário?')"><i class="fas fa-trash-alt"  style="font-size:1.8rem;margin-left:1rem;color:#666;"></i></a>
            </td>
          </tr>
          <?php
          }
          if(mysql_num_rows($q)<1){?>
            <tr>
              <td colspan="10" align="center">Nenhum registro encontrado!</td>
            </tr>
          <?php
          }?>
        </tbody>
      </table>
    </div>
  </div>
</div>