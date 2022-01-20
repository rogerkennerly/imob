<?php
  $tabela = "log";

  $usuario_pesquisar  = evita_injection($_GET["usuario_pesquisar"]);
  $data_inicial       = evita_injection($_GET["data_inicial"]);
  $controle_data_ini  = ""; if(!$data_inicial){$controle_data_ini = date("Y-m-d")."T00:00";}else{$controle_data_ini = $data_inicial;}
  $data_final         = evita_injection($_GET["data_final"]);
  $controle_data_fim  = ""; if(!$data_inicial){$controle_data_fim = date("Y-m-d")."T23:59";}else{$controle_data_fim = $data_final;}
  $modulo_pesquisar   = evita_injection($_GET["modulo_pesquisar"]);
  $recurso_pesquisar  = evita_injection($_GET["recurso_pesquisar"]);
  
  $s = "SELECT * FROM $tabela";
  
  $controle_and = 0;
  
  if($usuario_pesquisar OR $controle_data_ini OR $controle_data_fim){
    $s.= " WHERE ";
  }
  if($usuario_pesquisar){
    if($controle_and){$s .= " AND ";}
    $s .= "id_usuario = '$usuario_pesquisar'";
    $controle_and = 1;
  }
  if($controle_data_ini){
    if($controle_and){$s .= " AND ";}
    $s .= "data >= '$controle_data_ini'";
    $controle_and = 1;
  }
  if($controle_data_fim){
    if($controle_and){$s .= " AND ";}
    $s .= "data <= '$controle_data_fim'";
    $controle_and = 1;
  }
  if($modulo_pesquisar){
    if($controle_and){$s .= " AND ";}
    $s .= "id_modulo = '$modulo_pesquisar'";
    $controle_and = 1;
  }
  if($recurso_pesquisar){
    if($controle_and){$s .= " AND ";}
    $s .= "id_recurso = '$recurso_pesquisar'";
    $controle_and = 1;
  }
  $s .= " ORDER BY id DESC";
  // echo $s;
  $q = mysql_query($s);
  
  if($_GET["ok"] == 1){
    echo sucesso("Proprietário <strong>".$_GET["nome"]."</strong> incluido com sucesso!");
  }
?>

<div class="page-content">
  <div class="page-header">
    <h1>
      Relatório de Logs
    </h1>
  </div><!-- /.page-header -->

  <div class="row">      
    <div class="col-xs-12">
    <div class="col-xs-12 controle-chosen" style="margin-bottom:4rem;padding:0;">
      <form method="GET" action="" id="form_pesquisa_proprietario"> 
        <input type="hidden" name="pg" value="logs">
        <table id="sample-table-1" class="table table-bordered table-noborder tabela-listagem-3" style="background-color:#f1f1f1;">
            <tr>
              <td width="265">
                Usuário:<br/>
                <?php
                $usuario = listar("usuario");?>
                <select name="usuario_pesquisar" class="chosen-select" style="width:30rem;">
                  <option value="">Selecione um usuário</option>
                  <?php
                  while($r = mysql_fetch_assoc($usuario)){
                  $selected = "";
                  if($usuario_pesquisar == $r["id"]){$selected = "selected";}?>
                  <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
                  <?php
                  }?>
                </select>
              </td>
              <td>
                Data inicial:<br/>
                <input type="datetime-local" name="data_inicial" style="width:100%;" value="<?php echo $controle_data_ini;?>">
              </td>
              <td>
                Data final:<br/>
                <input type="datetime-local" name="data_final" style="width:100%;" value="<?php echo $controle_data_fim;?>">
              </td>
            </tr>
            <tr>
              <td>
                Modulo:<br/>
                <?php
                $modulo = mysql_query("SELECT * FROM modulo WHERE log = 'S'");?>
                <select name="modulo_pesquisar" class="chosen-select" style="width:30rem;">
                  <option value="">Selecione um modulo</option>
                  <?php
                  while($r = mysql_fetch_assoc($modulo)){
                  $selected = "";
                  if($modulo_pesquisar == $r["id"]){$selected = "selected";}?>
                  <option value="<?php echo $r["id"]; ?>" <?php echo $selected; ?>><?php echo $r["nome"]; ?></option>
                  <?php
                  }?>
                </select>
              </td>
              <td>
                Operação:<br/>
                <?php
                $modulo = mysql_query("SELECT * FROM modulo_item WHERE log = 'S'");?>
                <select name="recurso_pesquisar" class="chosen-select" style="width:30rem;">
                  <option value="">Selecione um recurso</option>
                  <option value="1" <?php if($recurso_pesquisar == 1){echo "selected";} ?>>Incluir</option>
                  <option value="2" <?php if($recurso_pesquisar == 2){echo "selected";} ?>>Editar</option>
                  <option value="3" <?php if($recurso_pesquisar == 3){echo "selected";} ?>>Excluir</option>
                </select>
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
            <th>USUÁRIO</th>
            <th>MODULO</th>
            <th>OPERAÇÃO</th>
            <th>DESCRIÇÃO</th>
            <th class="center">DATA</th>
            <th class="center" width="50">DET</th>
          </tr>
        </thead>
        <tbody>
          <?php
          while($r = mysql_fetch_assoc($q)){
          $data = explode(" ", $r["data"]);?>
          <tr>
            <td><?php echo usuario($r["id_usuario"]); ?></td>
            <td><?php echo modulo($r["id_modulo"]); ?></td>
            <td><?php echo recurso($r["id_recurso"]); ?></td>
            <td><?php echo $r["descricao"]; ?></td>
            <td class="center"><?php echo tratar_data($data[0],2)." as ".$data[1]; ?></td>
            <td class="center"><i class="fas fa-chevron-down" style="cursor:pointer;" onclick="$('#det<?php echo $r["id"]; ?>').toggle()"></i></td>
          </tr>
          <tr id="det<?php echo $r["id"]; ?>" style="display:none;">
            <td colspan="6">
              <?php
                $info = "";
                $det = $r["query"];
                // echo $det."<hr>";
                if($r["id_recurso"] == 0){ //Login
                  $det = explode("where ", $det);
                  $det = explode(" and ", $det[1]);
                  $info[] = $det[0];
                  $info[] = $det[1];
                  $info[] = $r["ip"];
                  $info = str_replace("'", "",$info);
                  $info = str_replace("=", ": ",$info);
                }
                elseif($r["id_recurso"] == 1){ // INSERT
                  $dets = explode("(", $det);
                  $det = explode(")", $dets[1]);
                  $campos = $det[0];
                  $campos = explode(",", $campos);
                  $dets = $dets[2];
                  $valores = explode(")", $dets);
                  $valores = str_replace("',", ";", $valores[0]);
                  $valores = str_replace("'", "", $valores);
                  $valores = explode(";", $valores);
                  for($x=0; $x<count($campos); $x++){
                    $campos[$x]  = trim($campos[$x]);
                    $valores[$x] = trim($valores[$x]);
                    if($campos[$x] == "id_proprietario"){$campos[$x] = "proprietario";$valores[$x] = retorna_nome("proprietario", $valores[$x]);}
                    if($campos[$x] == "id_corretor")    {$campos[$x] = "corretor";    $valores[$x] = retorna_nome("usuario", $valores[$x]);}
                    if($campos[$x] == "id_finalidade")  {$campos[$x] = "finalidade";  $valores[$x] = retorna_nome("finalidade", $valores[$x]);}
                    if($campos[$x] == "id_tipo")        {$campos[$x] = "tipo";        $valores[$x] = retorna_nome("tipo", $valores[$x]);}
                    if($campos[$x] == "id_cidade")      {$campos[$x] = "cidade";      $valores[$x] = retorna_nome("cidade", $valores[$x]);}
                    if($campos[$x] == "id_bairro")      {$campos[$x] = "bairro";      $valores[$x] = retorna_nome("bairro", $valores[$x]);}
                    if($campos[$x] == "valor")          {$valores[$x]= tratar_moeda($valores[$x],2);}
                    if($campos[$x] == "video")          {$valores[$x]= "https://www.youtube.com/watch?v=".$valores[$x];}
                    if($campos[$x] == "data_cadastro")  {$valores[$x]= explode(" ", $valores[$x]); $valores[$x] = tratar_data($data[0],2)." as ".$data[1];}
                    $info[] = $campos[$x].": ".$valores[$x];
                  }
                }
                elseif($r["id_recurso"] == 2){ // UPDATE
                  $det = explode("SET ", $det);
                  $det = explode(" WHERE", $det[1]);
                  $det = str_replace("',", ";", $det[0]);
                  $det = str_replace("'", "", $det);
                  $info = explode(";", $det);
                }
                elseif($r["id_recurso"] == 3){
                  $info[] = "N/a";
                }
                
                for($x=0; $x<count($info); $x++){
                  echo $info[$x]."<br/>";
                }
              ?>
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

<?php
function usuario($id){
  $s = "SELECT nome FROM usuario WHERE id = '$id'";
  $q = mysql_query($s);
  $r = mysql_fetch_assoc($q);
  return $r["nome"];
}
function modulo($id){
  $s = "SELECT nome FROM modulo WHERE id = '$id'";
  $q = mysql_query($s);
  $r = mysql_fetch_assoc($q);
  return $r["nome"];
}
function recurso($id){
  if($id == 1){
    return "Incluir";
  }
  elseif($id == 2){
    return "Editar";
  }
  elseif($id == 3){
    return "Excluir";
  }
}
?>