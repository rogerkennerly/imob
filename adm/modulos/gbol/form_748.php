<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
    echo "<table>\n";
    echo "<tr><td align=center colspan=2><b>Crediconai/Bancoob n?o t? certo isso ainda</td></tr>\n";
    echo "<tr><td align=right><b>AG       : </b></td><td><input type=text name=ag       size=4  maxlength=4  value=\"$ag\"      ></td></tr>\n";
    echo "<tr><td align=right><b>Dig.AG   : </b></td><td><input type=text name=digag    size=1  maxlength=1  value=\"$digag\"   ></td></tr>\n";
    echo "<tr><td align=right><b>CC       : </b></td><td><input type=text name=cc       size=8  maxlength=8  value=\"$cc\"      ></td></tr>\n";
    echo "<tr><td align=right><b>Dig.CC   : </b></td><td><input type=text name=digcc    size=1  maxlength=1  value=\"$digcc\"   ></td></tr>\n";
    echo "<tr><td align=right><b>Carteira : </b></td><td><input type=text name=carteira size=3  maxlength=3  value=\"$carteira\"></td></tr>\n";
    echo "<tr><td align=right><b>Conv?nio : </b></td><td><input type=text name=convenio size=7  maxlength=7  value=\"$convenio\"></td></tr>\n";
    echo "<tr><td align=right><b>Multa    : </b></td><td><input type=text name=multa    size=4  maxlength=4  value=\"$multa\"   > geralmente 0.02 (2%)</td></tr>\n";
    echo "<tr><td align=right><b>Juros    : </b></td><td><input type=text name=juros    size=5  maxlength=5  value=\"$juros\"   > geralmente 0.001 (3% ao m?s)</td></tr>\n";
    echo "<tr><td align=right><b>M?nimo   : </b></td><td><input type=text name=nummin   size=20 maxlength=20 value=\"$nummin\"  > in?cio da numera??o dos boletos</td></tr>\n";
    echo "<tr><td align=right><b>M?ximo   : </b></td><td><input type=text name=nummax   size=20 maxlength=20 value=\"$nummax\"  > fim da numera??o dos boletos</td></tr>\n";
    echo "<tr><td align=right><b>Atual    : </b></td><td><input type=text name=indice   size=20 maxlength=20 value=\"$indice\"  > ?ndice atual (?ltimo usado)</td></tr>\n";
    echo "</table>\n";
?>
<script language="JavaScript">
  function check_formaspagto(f){
    var s = "";
    var a = new Array(4,6,7);
    s = trim(f.elements["ag_001"      ].value); if (s.length != 4) { alert("Ag?ncia deve ter 4 caracteres"               ); return false; }
    s = trim(f.elements["digag_001"   ].value); if (s.length != 1) { alert("D?gito da Ag?ncia deve ter 1 caracter"       ); return false; }
    s = trim(f.elements["cc_001"      ].value); if (s.length != 8) { alert("Conta Corrente deve ter 8 caracteres"        ); return false; }
    s = trim(f.elements["digcc_001"   ].value); if (s.length != 1) { alert("D?gito da Conta Corrente deve ter 1 caracter"); return false; }
    s = trim(f.elements["carteira_001"].value); if (s.length != 2) { alert("Carteira deve ter 2 caracteres"              ); return false; }
    s = trim(f.elements["convenio_001"].value); if (!inarray(s.length,a)) { alert("Convenio deve ter 4,6,7 caracteres"   ); return false; }
  }
</script>