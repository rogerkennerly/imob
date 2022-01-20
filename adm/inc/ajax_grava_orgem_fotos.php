<?php
  include "../../config.php";
  include "../../conexao.php";
  include "../funcoes.php";

  $fotos = $_GET["fotos"];
  $id_imovel = $_GET["id_imovel"];
  
  $fotos = explode(",", $fotos);
  
  $x = 0;
  foreach($fotos as $foto){
    // mysql_query("UPDATE foto SET posicao = $x WHERE id = '".$foto."' AND id_imovel = '$id_imovel'");
    mysql_query("UPDATE foto SET posicao = $x WHERE id = '".$foto."'");
    $x++;
  }
?>
     
<?php echo sucesso('Fotos ordenadas com sucesso!'); ?>

<?php
$s = "SELECT * FROM foto WHERE id_imovel = $id_imovel ORDER BY posicao";
$q = mysql_query($s);
?>
<ul id="sortable">
  <div style="font-size:1.5rem;margin-bottom:1rem;">Fotos:</div>
  <?php
  while($r = mysql_fetch_assoc($q)){?>
    <li class="sortable-li ui-state-default" data-id="<?php echo $r["id"]; ?>">
        <div style="height:10.5rem;width:100px;text-align:center;">
          <img src="/clientes/<?php echo DIRETORIO; ?>/fotos/<?php echo $id_imovel ?>/t2/<?php echo $r["nome"]; ?>" style="max-width:100%;max-height:105px;">
        </div>
        <div style="width:100%;float:left;text-align:center;">
          <a href="?pg=gerenciar-fotos&id_imovel=<?php echo $id_imovel; ?>&op=excluir&id_foto=<?php echo $r["id"]; ?>" onclick="return confirm('Deseja excluir a foto?')">
            <i class="fas fa-trash-alt"></i>
          </a>
        </div>
    </li>
  <?php
  }?>
</ul>

<script>
$( "#sortable" ).sortable();
$( "#sortable" ).disableSelection();
$(".dz-preview").fadeOut()
</script>