<?php if (basename($PHP_SELF) == basename(__FILE__)) { exit(); } ?>
<?php if ($_SESSION['g_nivel'] != 1) { readfile("header.html"); echo "<body><h4>Voc� n�o tem permiss�o para acessar essa p�gina</h4></body></htm>\n"; exit(); } ?>
        
        <div id="menu_config">
          <ul>
            <li><a href="base.php?pg=cidades">Cidades</a></li>
          </ul>
        </div>