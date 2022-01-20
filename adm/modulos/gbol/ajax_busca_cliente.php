<?php
require_once("../../../config.php");
require_once("../../../conexao.php");
$termo = $_GET['termo'];

$s = "SELECT nome, id FROM proprietario WHERE nome like '%$termo%'";
$q = mysql_query($s);
while($r = mysql_fetch_assoc($q)){?>
  <a href='javascript:void(0)' onclick="$('#codcliente').val('<?php echo $r['id']; ?>');$('#div_busca_cliente').hide()"><?php echo $r['nome'];?></a><br>
  <?php
}
?>