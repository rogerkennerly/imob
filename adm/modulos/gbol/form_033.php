<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
    echo "<table>\n";
    echo "<tr><td align=center colspan=2><b>Santander/Banespa n�o t� certo isso ainda</td></tr>\n";
    echo "<tr><td align=right><b>AG       : </b></td><td><input type=text name=ag       size=4  maxlength=4  value=\"$ag\"      ></td></tr>\n";
    //echo "<tr><td align=right><b>Dig.AG   : </b></td><td><input type=text name=digag    size=1  maxlength=1  value=\"$digag\"   ></td></tr>\n";
    echo "<tr><td align=right><b>CC       : </b></td><td><input type=text name=cc       size=6  maxlength=6  value=\"$cc\"      > Ex. 13000115 usar 000115</td></tr>\n";
    echo "<tr><td align=right><b>Dig.CC   : </b></td><td><input type=text name=digcc    size=1  maxlength=1  value=\"$digcc\"   ></td></tr>\n";
    echo "<tr><td align=right><b>Carteira : </b></td><td><input type=text name=carteira size=3  maxlength=3  value=\"$carteira\"> COB, 101(com registro), 102</td></tr>\n";
    echo "<tr><td align=right><b>Multa    : </b></td><td><input type=text name=multa    size=4  maxlength=4  value=\"$multa\"   > geralmente 0.02 (2%)</td></tr>\n";
    echo "<tr><td align=right><b>Juros    : </b></td><td><input type=text name=juros    size=5  maxlength=5  value=\"$juros\"   > geralmente 0.001 (3% ao m�s)</td></tr>\n";
    //echo "<tr><td align=right><b>Com  Registro:</b></td><td><select name=comregistro>";
    //echo "  <option value='S' "; if( $comregistro=='S' ){ echo 'selected'; } echo ">SIM</option>";
    //echo "  <option value='N' "; if( $comregistro=='N' ){ echo 'selected'; } echo ">N�O</option>";
    //echo "</select></td></tr>\n";
    //echo "<tr><td align=right><b>Cod.Transmiss�o : </b></td><td><input type=text name=codtransmissao size=30 maxlength=30 value=\"$codtransmissao\"></td></tr>\n";
    echo "<tr><td align=right><b>M�nimo          : </b></td><td><input type=text name=nummin         size=20 maxlength=20 value=\"$nummin\"        > in�cio da numera��o dos boletos</td></tr>\n";
    echo "<tr><td align=right><b>M�ximo          : </b></td><td><input type=text name=nummax         size=20 maxlength=20 value=\"$nummax\"        > fim da numera��o dos boletos</td></tr>\n";
    echo "<tr><td align=right><b>Atual           : </b></td><td><input type=text name=indice         size=20 maxlength=20 value=\"$indice\"        > �ndice atual (�ltimo usado)</td></tr>\n";
    echo "</table>\n";
?>
<script language="JavaScript">
  function check_formaspagto(f){
    var s = "";
    var a = new Array(4,6,7);
    s = trim(f.elements["ag"      ].value); if (s.length != 4) { alert("Ag�ncia deve ter 4 caracteres"               ); return false; }
    //s = trim(f.elements["digag"   ].value); if (s.length != 1) { alert("D�gito da Ag�ncia deve ter 1 caracter"       ); return false; }
    s = trim(f.elements["cc"      ].value); if (s.length != 6) { alert("Conta Corrente deve ter 6 caracteres"        ); return false; }
    s = trim(f.elements["digcc"   ].value); if (s.length != 1) { alert("D�gito da Conta Corrente deve ter 1 caracter"); return false; }
    s = trim(f.elements["carteira"].value); if (s.length != 3) { alert("Carteira deve ter 3 caracteres"              ); return false; }
    //s = trim(f.elements["convenio"].value); if (!inarray(s.length,a)) { alert("Convenio deve ter 4,6,7 caracteres"   ); return false; }
  }
</script>