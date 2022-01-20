<?php
  include "../../config.php";
  include "../../conexao.php";
  include "../funcoes.php";
  
  $cidade = evita_injection($_GET["cidade"]);
  $s = "SELECT * FROM bairro WHERE id_cidade = '$cidade' ORDER BY nome";
  $q = mysql_query($s);
?>
<select name="bairro" id="bairro" class="chosen-select" style="width:300px;">
  <option value="0">Selecione</option>
<?php  
  while($r = mysql_fetch_assoc($q)){?>
  <option value="<?php echo $r["id"]; ?>"><?php echo $r["nome"]; ?></option>
  <?php
  }
  if(mysql_num_rows($q)<1){?>
    <option value="">Nenhum bairro cadastrado nesta cidade</option>
  <?php
  }
?>
</select>

<script>
	$("#bairro").chosen(); 
</script>
