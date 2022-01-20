<?php
  if($_GET['pg']){
    $pg = evita_injection($_GET['pg']);
  }else{
    $pg = 'home';
  }

  if(!include "clientes/".DIRETORIO."/inc/sub_topo.php"){include "layouts/$layout/sub_topo.php";}
  if(!include "clientes/".DIRETORIO."/inc/topo.php")    {include "layouts/$layout/topo.php";}

  // if($pg != 'home' AND $pg != 'busca' AND $pg != 'imovel' AND $pg != 'favoritos' AND $pg != 'sobre' AND $pg != 'contato'){
  //   if(!include "clientes/".DIRETORIO."/inc/404.php")             {include "inc/404.php";}
  // }
  switch($pg){
    case 'home':
      if(!include "clientes/".DIRETORIO."/inc/form_pesquisa_horizontal.php"){include "layouts/$layout/form_pesquisa_horizontal.php";}
      if($config['banner'] == 'S'){
        if(!include "clientes/".DIRETORIO."/inc/banner.php")    {include "layouts/$layout/banner.php";}
      }
      if($config['destaques_grande'] == 'S'){
        if(!include "clientes/".DIRETORIO."/inc/destaques_grande.php")    {include "layouts/$layout/destaques_grande.php";}
      }
      $tipo_destaque = 1;
      if(!include "clientes/".DIRETORIO."/inc/destaques_pequeno.php")       {include "layouts/$layout/destaques_pequeno.php";}
      $tipo_destaque = 2;
      if(!include "clientes/".DIRETORIO."/inc/destaques_pequeno.php")       {include "layouts/$layout/destaques_pequeno.php";}
      break;

    case 'busca';
      if(!include "clientes/".DIRETORIO."/inc/menu_mobile.php")             {include "layouts/$layout/menu_mobile.php";}
      if(!include "clientes/".DIRETORIO."/inc/busca.php")                   {include "layouts/$layout/busca.php";}
      break;

    case 'imovel';
      if(!include "clientes/".DIRETORIO."/inc/menu_mobile.php")             {include "layouts/$layout/menu_mobile.php";}
      if(!include "clientes/".DIRETORIO."/inc/form_pesquisa_horizontal.php"){include "layouts/$layout/form_pesquisa_horizontal.php";}
      if(!include "clientes/".DIRETORIO."/inc/imovel.php")                  {include "layouts/$layout/imovel.php";}
      $tipo_destaque = 3;
      if(!include "clientes/".DIRETORIO."/inc/destaques_pequeno.php")       {include "layouts/$layout/destaques_pequeno.php";}
      $tipo_destaque = 4;
      if(!include "clientes/".DIRETORIO."/inc/destaques_pequeno.php")       {include "layouts/$layout/destaques_pequeno.php";}
      break;

    case 'favoritos';
      if(!include "clientes/".DIRETORIO."/inc/menu_mobile.php")             {include "layouts/$layout/menu_mobile.php";}
      if(!include "clientes/".DIRETORIO."/inc/form_pesquisa_horizontal.php"){include "layouts/$layout/form_pesquisa_horizontal.php";}
      if(!include "clientes/".DIRETORIO."/inc/favoritos.php")               {include "layouts/$layout/favoritos.php";}
      break;

    case 'sobre';
      if(!include "clientes/".DIRETORIO."/inc/sobre.php")                   {include "layouts/$layout/sobre.php";}
      break;

    case 'contato';
      if(!include "clientes/".DIRETORIO."/inc/contato.php")                 {include "layouts/$layout/contato.php";}
      break;

    case 'cadastrar_imovel';
      if(!include "clientes/".DIRETORIO."/inc/cadastrar_imovel.php")        {include "layouts/$layout/cadastrar_imovel.php";}
      break;

    default;
      if(!include "clientes/".DIRETORIO."/inc/404.php")                     {include "layouts/$layout/404.php";}
      break;
  }

  if(!include "clientes/".DIRETORIO."/inc/rodape.php")                      {include "layouts/$layout/rodape.php";}
?>
