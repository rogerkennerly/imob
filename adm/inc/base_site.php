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
    case 'home': 
      if(!include "../clientes/".DIRETORIO."/inc/form_pesquisa_horizontal.php"){include "../inc/form_pesquisa_horizontal.php";}
      if(!include "../clientes/".DIRETORIO."/inc/banner.php")                  {include "../inc/banner.php";}
      if(!include "../clientes/".DIRETORIO."/inc/destaques_grande.php")        {include "../inc/destaques_grande.php";}
      $tipo_destaque = 1;
      if(!include "../clientes/".DIRETORIO."/inc/destaques_pequeno.php")       {include "../inc/destaques_pequeno.php";}
      $tipo_destaque = 2;
      if(!include "../clientes/".DIRETORIO."/inc/destaques_pequeno.php")       {include "../inc/destaques_pequeno.php";}
      break;

    case 'busca';
      if(!include "../clientes/".DIRETORIO."/inc/menu_mobile.php")             {include "../inc/menu_mobile.php";}
      if(!include "../clientes/".DIRETORIO."/inc/busca.php")                   {include "../inc/busca.php";}
      break;

    case 'imovel';
      if(!include "../clientes/".DIRETORIO."/inc/menu_mobile.php")             {include "../inc/menu_mobile.php";}
      if(!include "../clientes/".DIRETORIO."/inc/form_pesquisa_horizontal.php"){include "../inc/form_pesquisa_horizontal.php";}
      if(!include "../clientes/".DIRETORIO."/inc/imovel.php")                  {include "../inc/imovel.php";}
      $tipo_destaque = 3;
      if(!include "../clientes/".DIRETORIO."/inc/destaques_pequeno.php")       {include "../inc/destaques_pequeno.php";}
      $tipo_destaque = 4;
      if(!include "../clientes/".DIRETORIO."/inc/destaques_pequeno.php")       {include "../inc/destaques_pequeno.php";}
      break;

    case 'favoritos';
      if(!include "../clientes/".DIRETORIO."/inc/menu_mobile.php")             {include "../inc/menu_mobile.php";}
      if(!include "../clientes/".DIRETORIO."/inc/form_pesquisa_horizontal.php"){include "../inc/form_pesquisa_horizontal.php";}
      if(!include "../clientes/".DIRETORIO."/inc/favoritos.php")               {include "../inc/favoritos.php";}
      break;
    
    case 'sobre';
      if(!include "../clientes/".DIRETORIO."/inc/sobre.php")                   {include "../inc/sobre.php";}
      break;

    case 'contato';
      if(!include "../clientes/".DIRETORIO."/inc/contato.php")                 {include "../inc/contato.php";}
      break;
  }
  
  if(!include "../clientes/".DIRETORIO."/inc/rodape.php"){include "../inc/rodape.php";}
?>