<?php
  include "../../conexao.php";
  include "../funcoes.php";

  unlink("../../fotos/a/1.txt");
  deltree("../../fotos/a/");
?>
