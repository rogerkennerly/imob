<div class="main-content">
  <?php
  @$pg = $_GET["pg"];
  $mailcontato = 'hostmaster@hospedaria.com.br';
  $ar_status = array(
    0 => 'Sem Registro',
    1 => 'Com Registro',
    2 => 'Aguardando Remessa',
    3 => 'Aguardando Retorno',
    4 => 'Retorno OK',
    5 => 'Rejeitado'
  );
  
    include "modulos/gbol/header.html";
    include "modulos/gbol/menu.php";
    include_once("modulos/gbol/funcoes.php");
    switch ($pg)
    { case 'config'            : include('config.php');                  break;
      case 'revendas'          : include('revendas.php');                break;
      case 'altdados'          : include('altdados.php');                break;
      case 'altdados_rev'      : include('dados-imobiliaria.php');       break;
      case 'inc_clientes'      : include('inc/proprietario.php');        break;
      case 'clientes'          : include('inc/listar-proprietario.php'); break;
      case 'principal'         : include('principal.php');               break;
      case 'cidades'           : include('cidades.php');                 break;
      case 'boletos'           : include('boletos.php');                 break;
      case 'impretorno'        : include('imp_retorno.php');             break;
      case 'retorno'           : include('retorno.php');                 break;
      case 'gerador'           : include('gerarboletos.php');            break;
      case 'confboletos'       : include('confboletos.php');             break;
      case 'gerar_remessa'     : include('gerar_remessa.php');           break;
      //default                    : include('principal.php');           break;
    }
  ?>  
</div>