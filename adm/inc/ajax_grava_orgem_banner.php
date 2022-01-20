<?php
  include "../../config.php";
  include "../../conexao.php";
  include "../funcoes.php";

  $fotos = $_GET["fotos"];
  
  $fotos = explode(",", $fotos);
  
  $x = 0;
  foreach($fotos as $foto){
    // mysql_query("UPDATE foto SET posicao = $x WHERE id = '".$foto."' AND id_imovel = '$id_imovel'");
    mysql_query("UPDATE banner SET posicao = $x WHERE id = '".$foto."'");
    $x++;
  }
?>
     
<?php echo sucesso('Fotos ordenadas com sucesso!'); ?>

<?php
$s = "SELECT * FROM banner ORDER BY posicao";
$q = mysql_query($s);
?>
<ul id="sortable">
  <?php
  while($r = mysql_fetch_assoc($q)){?>
    <li class="sortable-li ui-state-default" data-id="<?php echo $r["id"]; ?>">
        <div style="height:10.5rem;width:12rem;text-align:center;margin-bottom:0.5rem;">
          <img src="/clientes/<?php echo DIRETORIO; ?>/assets/img/banner/<?php echo $r["nome"]; ?>" style="max-height:10.5rem;max-width:100%;">
        </div>
        <div style="width:100%;float:left;text-align:center;">
          <a href="?pg=banner&op=excluir&id_foto=<?php echo $r["id"]; ?>" onclick="return confirm('Deseja excluir a foto?')">
            <i class="far fa-trash-alt"></i>
          </a>
        </div>
    </li>
  <?php
  }?>
</ul>

<script>
$( "#sortable" ).sortable();
$( "#sortable" ).disableSelection();
</script>