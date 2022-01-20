<?php
  include('error_handler.php');
  if ($i == 3) { echo ''; }
  $juros = 1;
  $ValorDocumento = 17.00;
  $total = ($ValorDocumento*($juros/30))/100;
  echo 'total = ',number_format($total*10,2,',','');
?>