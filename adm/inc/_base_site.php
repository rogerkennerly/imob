<?php if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) { exit(); } ?>
<?php
  error_reporting(E_ALL ^ E_NOTICE);

  if($_GET['pg']){
    $pg = $_GET['pg'];
  }else{
    $pg = 'home';
  }
  
  if(!include "../clientes/".DIRETORIO."/inc/sub_topo.php"){include "../inc/sub_topo.php";}
  if(!include "../clientes/".DIRETORIO."/inc/topo.php")    {include "../inc/topo.php";}
  
  switch($pg){      
    case 'busca';
      include "../inc/busca.php";
      break;

    case 'imovel';
      include "../inc/form_pesquisa_horizontal.php";
      include '../inc/imovel.php';
      $tipo_destaque = 3;
      include "../inc/destaques_pequeno.php";
      $tipo_destaque = 4;
      include "../inc/destaques_pequeno.php";
      break;

    case 'favoritos';
      include "../inc/form_pesquisa_horizontal.php";
      include "../inc/favoritos.php";
      break;
    
    case 'sobre';
      include "../inc/sobre.php";
      break;

    case 'contato';
      include "../inc/contato.php";
      break;
      
    default:
      include "../inc/form_pesquisa_horizontal.php";
      include "../inc/banner.php";
      include "../inc/destaques_grande.php";
      $tipo_destaque = 1;
      include "../inc/destaques_pequeno.php";
      $tipo_destaque = 2;
      include "../inc/destaques_pequeno.php";
      break;
  }
  
  include "../inc/rodape.php";
?>