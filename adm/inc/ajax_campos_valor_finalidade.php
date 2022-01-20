<?php
  require "../../config.php";
  require "../../conexao.php";
  require "../funcoes.php";
  
  if($_GET["ids_finalidade"] > 0){
    $id_imovel = $_GET["id_imovel"];
    $ids_finalidade = explode(",", $_GET["ids_finalidade"]);
    
    for($x=0; $x<count($ids_finalidade); $x++){
      $valor_finalidade = "";
      $stest = "SELECT valor, iptu, condominio FROM imovel_finalidade WHERE id_imovel = '$id_imovel' AND id_finalidade = '".$ids_finalidade[$x]."'";
      $qtest = mysql_query($stest);
      $rtest = mysql_fetch_assoc($qtest);
      $valor_finalidade      = tratar_moeda($rtest["valor"],2);
      $iptu_finalidade       = tratar_moeda($rtest["iptu"],2);
      $condominio_finalidade = tratar_moeda($rtest["condominio"],2);
      
      $s = "SELECT nome FROM finalidade WHERE id = '".$ids_finalidade[$x]."'";
      $q = mysql_query($s);
      $r = mysql_fetch_assoc($q);
      $nome_finalidade = $r["nome"];?>
      <div style="width:100%;float:left;margin-bottom:1rem;" id="linha_finalidade_'+valor+'">
        <div style="float:left;margin-right:1rem;">
          Valor <?php echo $nome_finalidade; ?>:
          <br/>
          <input type="text" name="valor_<?php echo $ids_finalidade[$x]; ?>" placeholder="" size="15" class="money" data-affixes-stay="true" data-thousands="." data-decimal="," value="<?php echo $valor_finalidade; ?>">
        </div>
        
        <div style="float:left;margin-right:1rem;">
          IPTU <?php echo $nome_finalidade; ?>:
          <br/>
          <input type="text" name="iptu_<?php echo $ids_finalidade[$x]; ?>" placeholder="" size="15" class="money" data-affixes-stay="true" data-thousands="." data-decimal="," value="<?php echo $iptu_finalidade; ?>">
        </div>
        
        <div style="float:left;margin-right:1rem;">
          Condominio <?php echo $nome_finalidade; ?>:
          <br/>
          <input type="text" name="condominio_<?php echo $ids_finalidade[$x]; ?>" placeholder="" size="15" class="money" data-affixes-stay="true" data-thousands="." data-decimal="," value="<?php echo $condominio_finalidade; ?>">
        </div>
      </div>
    <?php
    }
  }
?>

<script>
  $('.money').maskMoney();
</script>