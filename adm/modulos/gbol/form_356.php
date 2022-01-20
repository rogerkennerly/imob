<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
    echo "<table>\n";
    echo "<tr><td align=center colspan=2><b>Banco Real</td></tr>\n";
    echo "<tr><td align=right><b>AG       : </b></td><td><input type=text name=ag       size=4  maxlength=4  value=\"$ag\"      ></td></tr>\n";
    echo "<tr><td align=right><b>CC       : </b></td><td><input type=text name=cc       size=8  maxlength=8  value=\"$cc\"      ></td></tr>\n";
    echo "<tr><td align=right><b>Carteira : </b></td><td><input type=text name=carteira size=3  maxlength=3  value=\"$carteira\"> <small>24 ou 57</small></td></tr>\n";
    echo "<tr><td align=right><b>Multa    : </b></td><td><input type=text name=multa    size=4  maxlength=4  value=\"$multa\"   > geralmente 0.02 (2%)</td></tr>\n";
    echo "<tr><td align=right><b>Juros    : </b></td><td><input type=text name=juros    size=5  maxlength=5  value=\"$juros\"   > geralmente 0.001 (3% ao mês)</td></tr>\n";
    echo "<tr><td align=right><b>Mínimo   : </b></td><td><input type=text name=nummin   size=20 maxlength=20 value=\"$nummin\"  > início da numeração dos boletos</td></tr>\n";
    echo "<tr><td align=right><b>Máximo   : </b></td><td><input type=text name=nummax   size=20 maxlength=20 value=\"$nummax\"  > fim da numeração dos boletos</td></tr>\n";
    echo "<tr><td align=right><b>Atual    : </b></td><td><input type=text name=indice   size=20 maxlength=20 value=\"$indice\"  > índice atual (último usado)</td></tr>\n";
    echo "</table>\n";
?>
<script language="JavaScript">
  function check_formaspagto(f){
    var s = "";
    s = trim(f.elements["ag"      ].value); if (s.length != 4) { alert("Agência deve ter 4 caracteres" ); return false; }
    s = trim(f.elements["carteira"].value); if (s.length != 2) { alert("Carteira deve ter 2 caracteres"); return false; }
    if (f.elements["carteira"].value == "24")
    { s = trim(f.elements["cc"].value); if (s.length != 6) { alert("Conta Corrente deve ter 6 caracteres para carteira 24"); return false; }
    }
    if (f.elements["carteira"].value == "57")
    { s = trim(f.elements["cc"].value); if (s.length != 7) { alert("Conta Corrente deve ter 7 caracteres para carteira 57"); return false; }
    }
  }
</script> 