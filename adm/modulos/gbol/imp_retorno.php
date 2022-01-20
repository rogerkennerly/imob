<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<div class='page-content'>
  <div class='page-header'>
    <h1>Remessa / Retorno</h1>
  </div>
  <br>
  <table cellpadding=0 cellspacing=0 border=0>
    <tr><td class=box1tl></td><td class=box1t></td><td class=box1tr></td></tr>
    <tr>
      <td class=box1l></td>
      <td class=box1c> <A href="base.php?pg=gerar_remessa" class=btn_comprar><span><span id=botao_comprar>Gerar Arquivo Remessa</span></span></A> </td>
      <td class=box1r></td>
    </tr>
    <tr><td class="box1bl"></td><td class="box1b"></td><td class="box1br"></td></tr>    
  </table>
  <br><br>
  
  <form name='frmrem' action='?modulo=gbol&pg=retorno' method='POST' enctype='multipart/form-data'>
  <input type=hidden name=pg value=retorno>
  <input type=hidden name=op value=E>
    <table id='sample-table-1' class='table table-bordered table-noborder tabela-listagem' style='width:auto;'>
      <tr><td class=box1tl></td><td class=box1t></td><td class=box1tr></td></tr>
      <tr>
        <td class=box1l></td>
        <td class=box1c><input type='file' name='arq_retorno' style="width:500px;border:1px solid #CCC;padding:3px;"></td>
        <td class=box1r></td>
      </tr>
      <tr>
        <td class=box1l></td>
        <td class=box1c align=center><INPUT TYPE=submit name=btn1 value='.:: IMPORTAR ARQUIVO RETORNO ::.'></td>
        <td class=box1r></td>
      </tr>
      <tr><td class="box1bl"></td><td class="box1b"></td><td class="box1br"></td></tr>    
    </table>
    <br><br>
  </form>  
  
  <table id="sample-table-1" class="table table-striped table-bordered table-hover">
  <tr align=center><TD><B>Últimos Arquivos Remessa</B></TD></TR>
  <?php
    $cor = ''; $cont_linhas = 0;
    $linhas = scandir($dir_remessa);
    if (count($linhas) > 0)
    { foreach ($linhas as $linha_atu)
      { $cont_linhas++;
        if ( $cont_linhas > 60 )
        { unlink($dir_remessa.$linha_atu);
        } else 
        { if( $linha_atu != '.' && $linha_atu != '..' )
          { if ($cor == $list_cor3) { $cor = $list_cor2; } else { $cor = $list_cor3; }
            echo "<tr align=center><td><a href='$dir_remessa".$linha_atu."' download>".$linha_atu."</a></td></tr>\n";
          }
        }
      }
    }
  ?>
  </table>
    
  <br><br>
  <table id="sample-table-1" class="table table-striped table-bordered table-hover">
  <tr bgcolor=<?php echo $list_cor1; ?> align=center><TD><B>Últimos Arquivos Retorno</B></TD></TR>
  <?php
    $cor = ''; $cont_linhas = 0;
    $linhas = scandir($dir_retorno);
    if (count($linhas) > 0)
    { foreach ($linhas as $linha_atu)
      { $cont_linhas++;
        if ( $cont_linhas > 60 )
        { unlink($dir_retorno.$linha_atu);
        } else 
        { if( $linha_atu != '.' && $linha_atu != '..' )
          { if ($cor == $list_cor3) { $cor = $list_cor2; } else { $cor = $list_cor3; }
            echo "<tr align=center><td><a href='$dir_retorno".$linha_atu."' download>".$linha_atu."</a></td></tr>\n";
          }
        }
      }
    }
  ?>
  </table>