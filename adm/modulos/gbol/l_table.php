<?php require("protecao.php"); ?>
<?php
   settype($codpor,"integer");
   if ($codpor == 0) { exit(); }
   echo "<HTML><BODY><center>";
   echo "<table>";
   $lvar = "select * from $tabela where codrevenda=$codpor order by $clabel";
   $result = mysql_query($lvar);
   $linhas = mysql_num_rows($result);
   for ($i=0;$i < $linhas;$i++)
   { echo "<tr><td><a href=\"javascript:window.opener.document.$form.$campo.value='".mysql_result($result,$i,$cvalue)."';window.close();\">".mysql_result($result,$i,$clabel)."</a></td></tr>\n";
   }
   echo "</table></center></body></HTML>";
?> 