<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php

function ajustardata($formato,$data)
{ if ($formato == "B")//banco de dados
  { if (strlen($data) == 10)
    { $ano = $data[6].$data[7].$data[8].$data[9];
      $mes = $data[3].$data[4];
      $dia = $data[0].$data[1];	
      return $ano."/".$mes."/".$dia;
    } else { return "NULL"; }
  } 
  if ($formato == "M")//Mostrar ao Usuário
  { if (strlen($data) == 10)
    { $ano = $data[0].$data[1].$data[2].$data[3];
      $mes = $data[5].$data[6];
      $dia = $data[8].$data[9];	
      return $dia."/".$mes."/".$ano;
    } else { return "NULL"; }    
  }
}

function truncar($tamanho,$s)
{ $temp = "";
  $i = 0;
  if (strlen($s) > $tamanho)
  { $temp = substr($s, 0, $tamanho); 
    if ( $s[$tamanho -1] != " " )
    { $i =1;
      while ( ($s[$tamanho -1 +$i] != " ") and ($tamanho -1 +$i < strlen($s)) )
      { $temp .= $s[$tamanho -1 +$i];
        $i++;
      }
    }      
    return $temp . " ...";
  } else { return $s; }
}

function buscaimagem($codigo,$diretorio,$portal,$corborda)
{   $i = 0; $s = "";
    $caminho = $diretorio."/".$codigo."/";
    if ( is_dir($caminho) )
    { $handle=opendir($caminho);
      while (($file = readdir($handle))!==false)
      { if ($file != "." && $file != "..")
        { $ar_fotos[$i] = $file;
        	$i++;
        }      
      }
      closedir($handle);
    }
    if ($i > 0)
    { sort($ar_fotos);
    	$s = "<img src='$diretorio/$codigo/".$ar_fotos[0]."' style=\"border: 1px #C0C0C0 solid\" name=carimage>";
    } else { $s = "<img src='figuras/".$diretorio."_semfoto.jpg' style=\"border: 1px #C0C0C0 solid\" border=0>"; }
    return $s;  
}

function buscaimagens($codigo,$dir1,$dir2,$quanti,$agrupar)
{   $i = 0; $s = "";
    $caminho = $dir1."/".$codigo."/";
    if ( is_dir($caminho) )
    { $handle=opendir($caminho);
      while (($file = readdir($handle))!==false)
      { if ($file != "." && $file != "..")
        { $ar_fotos[$i] = $file;
          $i++;
        }        
      }
      closedir($handle);    
    }
    if ($i > 0)
    { sort($ar_fotos);
      $tot = count($ar_fotos);
      if ($tot > $quanti) { $tot = $quanti; }
      $s = "<tr>";
      for ($i = 0; $i < $tot; $i++)
      { if (($i % $agrupar) == 0 and $i > 0) { $s .= "</tr>\n"; }
      	if (($i % $agrupar) == 0 and $i > 0) { $s .= "<tr><td colspan=$agrupar><img src=figuras/trans.gif width=400 height=5></td></tr>\n<tr>\n"; }
        $s .= "<td align=center valign=middle><a href=# onclick=\"window.document.carimage.src='$dir2/$codigo/".$ar_fotos[$i]."';return false;\">";
        $s .= "<img src='$dir1/$codigo/".$ar_fotos[$i]."' style=\"border: 1px #FFFFFF solid\" alt='Clique na imagem para ampliar'></td>\n";
      }
      $s .= "</tr>\n";
    }
    return $s;
}

function formatcpf($formato,$s)
{  
  if ($formato == "B")//banco de dados
  { $numeros = array ("0","1","2","3","4","5","6","7","8","9");
    $s = str_replace("-","",$s); $s = str_replace(".","",$s);
    $total = strlen($s); $i = 0; $erro = false;
    while ( $i < $total )
    { if ( !in_array($s[$i],$numeros) ) { $erro = true; $i = $total; }
      $i++;
    }
    if ($erro) { $s = 0; }
  }  
  if ($formato == "M")//mostrar ao cliente
  { $s = formatcpf("B",$s);
    $doc = array(); $s = strrev($s);
    $doc[0] = substr($s,0,2); $doc[0] = "-".strrev($doc[0]); $s = substr($s,2);
    $doc[1] = substr($s,0,3); $doc[1] = ".".strrev($doc[1]); $s = substr($s,3);
    $doc[2] = substr($s,0,3); $doc[2] = ".".strrev($doc[2]); $s = substr($s,3);
    $doc[3] = substr($s,0,3); $doc[3] = strrev($doc[3]);
    $s = $doc[3].$doc[2].$doc[1].$doc[0];
  }     
  return $s;  
}

function checacpf($s)
{       $ok = true;
        $c =  substr($s, 0,9);
        $dv = substr($s, 9,2);
        $d1 = 0;
        for ($i = 0; $i < 9; $i++) { $d1 += $c[$i]*(10-$i); }
        if ($d1 == 0) { $ok = false; }
        $d1 = 11 - ($d1 % 11);
        if ($d1 > 9) { $d1 = 0; }
        if ($dv[0] != $d1) { $ok = false; }
        $d1 *= 2;
        for ($i = 0; $i < 9; $i++) { $d1 += $c[$i]*(11-$i); }
        $d1 = 11 - ($d1 % 11);
        if ($d1 > 9) { $d1 = 0; }
        if ($dv[1] != $d1) { $ok = false; }
        return $ok;
}

function formatcnpj($formato,$s)
{  
  if ($formato == "B")//banco de dados
  { $numeros = array ("0","1","2","3","4","5","6","7","8","9");
    $s = str_replace("-","",$s); $s = str_replace(".","",$s); $s = str_replace("/","",$s);
    $total = strlen($s); $i = 0; $erro = false;
    while ( $i < $total )
    { if ( !in_array($s[$i],$numeros) ) { $erro = true; $i = $total; }
      $i++;
    }
    if ($erro) { $s = 0; }
  }  
  if ($formato == "M")//mostrar ao cliente
  { $s = formatcnpj("B",$s);
    $doc = array(); $s = strrev($s);
    $doc[0] = substr($s,0,2); $doc[0] = "-".strrev($doc[0]); $s = substr($s,2);
    $doc[1] = substr($s,0,4); $doc[1] = "/".strrev($doc[1]); $s = substr($s,4);
    $doc[2] = substr($s,0,3); $doc[2] = ".".strrev($doc[2]); $s = substr($s,3);
    $doc[3] = substr($s,0,3); $doc[3] = ".".strrev($doc[3]); $s = substr($s,3);
    $doc[4] = substr($s,0,3); $doc[4] = strrev($doc[4]);
    $s = $doc[4].$doc[3].$doc[2].$doc[1].$doc[0];
  }     
  return $s;  
}

function checacnpj($s) //Testa se o CNPJ é válido
{ 
  $d1 = 0; $d4 = 0; $xx = 1;
  for ($i = 0; $i < (strlen($s)-2);$i++)
  {   //echo substr($s,$i,1)."<br>";
      if ($xx < 5) { $fator = (6 - $xx); } else { $fator = (14 - $xx); }
      $d1 += (substr($s,$i,1) * $fator);
      if ($xx < 6) { $fator = (7 - $xx); } else { $fator = (15 - $xx); }
      $d4 += (substr($s,$i,1) * $fator);
      $xx++;    
  }  
  $resto = ($d1 % 11);
  if ($resto < 2) { $digito1 = 0; } else { $digito1 = (11 - $resto); }
  $d4 += (2 * $digito1);
  $resto = ($d4 % 11);
  if ($resto < 2) { $digito2 = 0; } else { $digito2 = (11 - $resto); }
  $check = $digito1 . $digito2;  
  if ($check != $s[(strlen($s)-2)].$s[(strlen($s)-1)] ) { return false; } else { return true; }
}

function checaremail($email) {
	return true;
}

function newnumboleto($codrevenda)
{ $indice = 0;
  settype($codrevenda,"integer");
  require("conexao.php");
  $result = mysql_query("select * from confboletos where codrevenda=$codrevenda");
  if (mysql_num_rows($result) > 0)
  { $indice = mysql_result($result,0,"indice");
    $min    = mysql_result($result,0,"nummin");
    $max    = mysql_result($result,0,"nummax");
    if ($indice < $min) { $indice = $min; }
    if (($indice+1) >= $max and $max > 0)
    { echo "<h4>O Índice máximo para geração do número do boleto foi atingido</h4>"; exit(); } else
    { $indice++;
      mysql_query("update confboletos set indice=$indice where codrevenda=$codrevenda");
    }
    return $indice;
  } else { echo "<h4>Tabela confboletos não encontrada para esta revenda</h4>"; exit(); }
}

function incmes($formato,$data,$mais,$diaop=0)
{ 
  if ($formato == "B") { $data = ajustardata("M",$data); }
  $dia = $data[0].$data[1];
  $mes = $data[3].$data[4];
  $ano = $data[6].$data[7].$data[8].$data[9];  
  if ($diaop == 0) { $diaop = $dia; }
  if ( (($mes + ($mais))==2 or ($mes + ($mais))==14) and ($dia == 30 or $dia == 29)) { $data = date("d/m/Y",mktime(0,0,0,($mes+($mais)+1),0,$ano)); }
  else { $data = date("d/m/Y",mktime(0,0,0,($mes+($mais)),$diaop,$ano)); }
  if ($formato == "B") { $data = ajustardata("B",$data); }
  return $data;
}

function convertvalor($valor,$decimal=2){
   $numeros = array ("0","1","2","3","4","5","6","7","8","9",",",".");
   settype($valor,"string"); $tmp = ""; $i = 0; $dezena = "";
   While ($i < strlen($valor) )
   { if (in_array($valor[$i],$numeros)) { $tmp .= $valor[$i]; }
     $i++; 
   }
   $tmp    = str_replace(",",".",$tmp);
   $pedas  = explode(".",$tmp);
   //$dezena = array_pop($pedas); // pega o último elemento e remove ele do array
   if (count($pedas) > 1) { $dezena = array_pop($pedas); } // pega o último elemento e remove ele do array
   $tmp    = implode("", $pedas);
   if (strlen($dezena) <= $decimal) { $tmp .= ".".$dezena; } else { $tmp .= $dezena.".00"; }
   if ($tmp == ".") { $tmp = 0; }
   return $tmp;
}

function geramenu($codgrupo,$recuo,$select)
{ require("conexao.php");
  $resp = "";
  settype($codgrupo,"integer"); settype($select,"integer");
  if ($select == 0) { $selected = "selected"; } else { $selected = ""; }	
  $sql = "select * from grupos where codgrupo=$codgrupo order by grupo";
  $result = mysql_query($sql); $linhas = mysql_num_rows($result);
  for ($i = 0; $i < $linhas; $i++)
  { if ($select == mysql_result($result,$i,"codigo")) { $selected = "selected"; } else { $selected = ""; }
    $resp .= "<OPTION value='".mysql_result($result,$i,"codigo")."' $selected>$recuo".mysql_result($result,$i,"grupo")."</OPTION>\n";    
    $resp .= geramenu(mysql_result($result,$i,"codigo"),"<b>&rsaquo;</b>&nbsp;".$recuo,$select,$difer);
  }
  return $resp;
}

function makepath($codgrupo,$lang,$codfabr)
{ require("conexao.php");
  include_once("funcoes.php");
  $resp = "";
  settype($codgrupo,"integer");
  $sql = "select codigo,codgrupo,LOWER(grupo$lang) as grupo from grupos where codigo=$codgrupo";
  $result = mysql_query($sql); $linhas = mysql_num_rows($result);
  if ($linhas > 0)
  { $codgrupo = mysql_result($result,0,"codgrupo");
    $codigo   = mysql_result($result,0,"codigo");
    $grupo    = firstupper(mysql_result($result,0,"grupo"));
    $resp     = " >> <a href=listar.php?codgrupo=$codigo&codfabr=$codfabr class=subgrupo>$grupo</a>";
    if ($codgrupo != 21) { $resp = makepath($codgrupo,$lang,$codfabr).$resp; }
  }    
  return $resp;
}

function minuscula($linha)
{ $letras  = array ("Á","É","Í","Ó","Ú","Ã","Õ","Ê","Ü","À","Ô","Ç","Â","º","ª","À");
  $letras2 = array ("á","é","í","ó","ú","ã","õ","ê","ü","à","ô","ç","â","o","a","à");
  $maxletras = count($letras);
  $s = "";
  $achou = false;
  $total = strlen($linha);
  for ($i = 0;$i < $total;$i++)
  { $j = 0;
    While (!$achou and $j < $maxletras)
    { if ($linha[$i] == $letras[$j])
      { $s .= $letras2[$j];
        $achou = true;
      }
      $j++;
    }
    if (!$achou) { $s .= $linha[$i]; }
    $achou = false;
  }
  return $s;
}

function firstupper($linha)
{ $letras  = array ("A","Á","Ã","À","Â","B","C","Ç","D","E","É","Ê","F","G","H","I","Í","J","K","L","M","N","O","Ó","Õ","Ô","P","Q","R","S","T","U","Ú","Ü","V","W","X","Y","Z","1","2","3","4","5","6","7","8","9");
  $letras2 = array ("a","á","ã","à","â","b","c","ç","d","e","é","ê","f","g","h","i","í","j","k","l","m","n","o","ó","õ","ô","p","q","r","s","t","u","ú","ü","v","w","x","y","z","1","2","3","4","5","6","7","8","9");
  $maxletras = count($letras);
  if (strlen($linha) > 0) { $s = $letras[array_search($linha[0],$letras2,false)].substr($linha,1,(strlen($linha)-1)); } else { $s = ""; }
  return $s;
}

function removeacentos($linha){ 
	$letras  = array("Á","Ã","À","Â","Ç","É","Ê","Í","Ó","Õ","Ô","Ú","Ü","á","ã","à","â","ç","é","ê","í","ó","õ","ô","ú","ü","ª","º");
  $letras2 = array("A","A","A","A","C","E","E","I","O","O","O","U","U","a","a","a","a","c","e","e","i","o","o","o","u","u","" ,"");
  return str_replace($letras,$letras2,$linha);
}

function limpacaracteres($linha)
{ $letras = array ('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z','a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z',' ','/',',','.','-',';');
  settype($linha,'string');
  $tmp = '';
  $i   = 0;
  $tam = strlen($linha);
  While ($i < $tam)
  { if (in_array($linha[$i],$letras)) { $tmp .= $linha[$i]; } else { $tmp .= ' '; }
    $i++;
  }
  return $tmp;
}

//-----------------------------------------------------------------------------------------------------------------------------------
function erro_aviso($ar,$tipo) {
//$str = <<<'EOD' nowdoc nao faz parse, porem so esta disponivel no php 5.3
//$str = <<<EOD heredoc
$img = '';
$txt = '';
if (count($ar) > 0) { $txt = implode('<br>',$ar); }
if ($tipo == 'aviso') { $img = "modulos/gbol/figuras/icon_aviso.png"; }
if ($tipo == 'erro' ) { $img = "modulos/gbol/figuras/icon_erro.png"; }
$str = <<<EOD
<br><table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:none;">
 <tr>
   <td>
     <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding:0px; border:none;" ><!-- bgcolor="#f3f8fe" colocar esse backgroud ajuda no debug -->
        <tr>
          <td align="center">
            <table align="center" border="0" cellpadding="0" cellspacing="0" style="min-width:550px">
             <tr>
               <td>
                 <table style="background-color: rgb(255, 255, 255); border: 1px solid rgb(199, 226, 252); width:100%; padding: 8px 12px;">
                   <tr>
                     <td width="100"><img src="$img" style="height:50px"></td>
                     <td align="left" style="font-family: arial; font-size: 16px; font-weight: bold; color: rgb(9, 91, 166);">$txt</td>
                   </tr>
                 </table>
               </td>
             </tr>
           </table>
         </td>
       </tr>
     </table>
   </td>
 </tr>
</table>
EOD;
return $str;
}

//-----------------------------------------------------------------------------------------------------------------------------------
function databd($d)//$d pode estar em qualquer formato, retorna data em formato BD
{	$dia = '';
  $mes = '';
  $ano = '';
  $d   = str_replace('-','/',$d);
	if (substr_count($d,'/') == 2)
  { $p = explode('/',$d);
    if (strlen($p[0]) == 4)
    { $dia = str_pad($p[2], 2 , '0', STR_PAD_LEFT);
      $mes = str_pad($p[1], 2 , '0', STR_PAD_LEFT);
      $ano = $p[0];
    }
    elseif (strlen($p[2]) == 4)
    { $dia = str_pad($p[0], 2 , '0', STR_PAD_LEFT);
      $mes = str_pad($p[1], 2 , '0', STR_PAD_LEFT);
      $ano = $p[2];
    }
  }
  $ar = array();
  if ($ano != '') { $ar[] = $ano; }
  if ($mes != '') { $ar[] = $mes; }
  if ($dia != '') { $ar[] = $dia; }
  return implode('-',$ar);
}

//-----------------------------------------------------------------------------------------------------------------------------------
function viewdata($data)//$d pode estar em qualquer formato, retorna data em formato brasileiro dd/mm/yyyy
{	$dia = '';
  $mes = '';
  $ano = '';
  $d   = str_replace('-','/',$data);
	if (substr_count($d,'/') == 2)
  { $p = explode('/',$d);
    if (strlen($p[0]) == 4)
    { $dia = str_pad($p[2], 2 , '0', STR_PAD_LEFT);
      $mes = str_pad($p[1], 2 , '0', STR_PAD_LEFT);
      $ano = $p[0];
    }
    elseif (strlen($p[2]) == 4)
    { $dia = str_pad($p[0], 2 , '0', STR_PAD_LEFT);
      $mes = str_pad($p[1], 2 , '0', STR_PAD_LEFT);
      $ano = $p[2];
    }
  }
  $ar = array();
  if ($dia != '') { $ar[] = $dia; }
  if ($mes != '') { $ar[] = $mes; }
  if ($ano != '') { $ar[] = $ano; }
  return implode('/',$ar);
}

?>