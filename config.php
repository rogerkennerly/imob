<?php 
  session_start();
  if(isset($_GET['imob_gerenciar'])){$_SESSION['imob_gerenciar'] = $_GET['imob_gerenciar'];}
  if(!isset($_SESSION['imob_gerenciar'])){$_SESSION['imob_gerenciar'] = $_SERVER['SERVER_NAME'];}
  
  // $imobiliaria_controle[0]['cliente']   = 'sistimob.hospedaria.net.br';
  // $imobiliaria_controle[0]['diretorio'] = 'default';
  // $imobiliaria_controle[0]['userdb']    = 'rootsites';
  // $imobiliaria_controle[0]['passdb']    = 'docinho';
  // $imobiliaria_controle[0]['basedb']    = 'sistimob';  
	
  $imobiliaria_controle[0]['cliente']   = 'localhost';
  $imobiliaria_controle[0]['diretorio'] = 'default';
  $imobiliaria_controle[0]['userdb']    = 'root';
  $imobiliaria_controle[0]['passdb']    = '';
  $imobiliaria_controle[0]['basedb']    = 'sistimob';
  
  $imobiliaria_controle[1]['cliente']   = 'imob.hospedaria.com.br';
  $imobiliaria_controle[1]['diretorio'] = 'teste';
  $imobiliaria_controle[1]['userdb']    = 'sistimobteste01';
  $imobiliaria_controle[1]['passdb']    = 'sistimobpass02';
  $imobiliaria_controle[1]['basedb']    = 'sistimobteste';  
	
  $imobiliaria_controle[2]['cliente']   = 'imobdev.hospedaria.net';
  $imobiliaria_controle[2]['diretorio'] = 'teste';
  $imobiliaria_controle[2]['userdb']    = 'imobhspusr';
  $imobiliaria_controle[2]['passdb']    = 'KFjj12f01G05';
  $imobiliaria_controle[2]['basedb']    = 'imobdev_hospedaria_com_br_1';  
  
  $imobiliaria_controle[3]['cliente']   = 'jmimovel.com.br';
  $imobiliaria_controle[3]['diretorio'] = 'jmimovel';
  $imobiliaria_controle[3]['userdb']    = 'jmusr361';
  $imobiliaria_controle[3]['passdb']    = 'jmp02ss59k';
  $imobiliaria_controle[3]['basedb']    = 'jmimovel_com_br_1';
  
  $imobiliaria_controle[4]['cliente']   = 'site.casajau.com.br';
  $imobiliaria_controle[4]['diretorio'] = 'casajau';
  $imobiliaria_controle[4]['userdb']    = 'sitecasauser';
  $imobiliaria_controle[4]['passdb']    = 'sitecasapass';
  $imobiliaria_controle[4]['basedb']    = 'site_casajau_com_br_1';
  
  $imobiliaria_controle[5]['cliente']   = 'marcosadrianoimoveis.com.br';
  $imobiliaria_controle[5]['diretorio'] = 'marcosadrianoimoveis';
  $imobiliaria_controle[5]['userdb']    = 'marcosadriano001';
  $imobiliaria_controle[5]['passdb']    = 'marcosadriano002';
  $imobiliaria_controle[5]['basedb']    = 'marcosadrianoimoveis_com_br_1';
  
  $imobiliaria_controle[6]['cliente']   = 'epaimobiliaria.com.br';
  $imobiliaria_controle[6]['diretorio'] = 'epaimobiliaria';
  $imobiliaria_controle[6]['userdb']    = 'usrep22';
  $imobiliaria_controle[6]['passdb']    = 'ps031eim8';
  $imobiliaria_controle[6]['basedb']    = 'sistimob_epa';
  
  $imobiliaria_controle[7]['cliente']   = 'imobiliariabarros.com';
  $imobiliaria_controle[7]['diretorio'] = 'imobiliariabarros';
  $imobiliaria_controle[7]['userdb']    = 'usr3barros1';
  $imobiliaria_controle[7]['passdb']    = 'B4r1DFkk31Ju';
  $imobiliaria_controle[7]['basedb']    = 'imobiliariabarros_com_1';
  
  $imobiliaria_controle[8]['cliente']   = 'pedroimoveis.com.br';
  $imobiliaria_controle[8]['diretorio'] = 'pedroimoveis';
  $imobiliaria_controle[8]['userdb']    = 'pdrus231';
  $imobiliaria_controle[8]['passdb']    = '3p11Rds810';
  $imobiliaria_controle[8]['basedb']    = 'pedroimoveis_com_br_1';
  
  $imobiliaria_controle[9]['cliente']   = 'imobiliariaperlati.com.br';
  $imobiliaria_controle[9]['diretorio'] = 'imobiliariaperlati';
  $imobiliaria_controle[9]['userdb']    = 'imobperlati';
  $imobiliaria_controle[9]['passdb']    = '83Jbd2jk';
  $imobiliaria_controle[9]['basedb']    = 'imobiliariaperlati_sistimob';
  
  $imobiliaria_controle[10]['cliente']   = 'imobiliariagustavo.com.br';
  $imobiliaria_controle[10]['diretorio'] = 'imobiliariagustavo';
  $imobiliaria_controle[10]['userdb']    = 'imbgust';
  $imobiliaria_controle[10]['passdb']    = '9113Dssa2jU';	
  $imobiliaria_controle[10]['basedb']    = 'imobiliariagustavo_com_br_1';
  
  $imobiliaria_controle[11]['cliente']   = 'imobiliariaspaco.com.br';
  $imobiliaria_controle[11]['diretorio'] = 'imobiliariaespaco';
  $imobiliaria_controle[11]['userdb']    = 'imbesp13154';
  $imobiliaria_controle[11]['passdb']    = 'dag02Ld2';
  $imobiliaria_controle[11]['basedb']    = 'imobiliariaespaco_com_br_sistimob';
  
  // $imobiliaria_controle[12]['cliente']   = 'claudiomorgado.com.br';
  // $imobiliaria_controle[12]['diretorio'] = 'claudiomorgado.com.br';
  // $imobiliaria_controle[12]['userdb']    = 'cl23mgd2';
  // $imobiliaria_controle[12]['passdb']    = 'dagKKs85lnu';
  // $imobiliaria_controle[12]['basedb']    = 'claudiomorgado_com_br_1';
  
  $imobiliaria_controle[13]['cliente']   = 'valdenicorretoradeimoveis.com.br';
  $imobiliaria_controle[13]['diretorio'] = 'valdenicorretoradeimoveis.com.br';
  $imobiliaria_controle[13]['userdb']    = 'vct49sn6';
  $imobiliaria_controle[13]['passdb']    = 'd0La72hgn';
  $imobiliaria_controle[13]['basedb']    = 'valdenicorretoradeimoveis_com_br_1';
  
  $imobiliaria_controle[14]['cliente']   = 'imobiliariaellojau.com.br';
  $imobiliaria_controle[14]['diretorio'] = 'valdenicorretoradeimoveis.com.br';
  $imobiliaria_controle[14]['userdb']    = 'vct49sn6';
  $imobiliaria_controle[14]['passdb']    = 'd0La72hgn';
  $imobiliaria_controle[14]['basedb']    = 'valdenicorretoradeimoveis_com_br_1';
	
  $imobiliaria_controle[15]['cliente']   = 'dinamicaimobiliaria.com';
  $imobiliaria_controle[15]['diretorio'] = 'dinamicaimobiliaria';
  $imobiliaria_controle[15]['userdb']    = 'dn72us6r';
  $imobiliaria_controle[15]['passdb']    = 'Fas220hq48';
  $imobiliaria_controle[15]['basedb']    = 'dinamicaimobiliaria_com_1';
	
  $imobiliaria_controle[16]['cliente']   = 'gagimoveisjau.com.br';
  $imobiliaria_controle[16]['diretorio'] = 'gagimoveisjau.com.br';
  $imobiliaria_controle[16]['userdb']    = 'uf31sfm1';
  $imobiliaria_controle[16]['passdb']    = 'D2fk2ll108Fs';
  $imobiliaria_controle[16]['basedb']    = 'gagimoveisjau_com_br_1';
	
  $imobiliaria_controle[17]['cliente']   = 'gomesimoveisjau.com.br';
  $imobiliaria_controle[17]['diretorio'] = 'gomesimoveisjau.com.br';
  $imobiliaria_controle[17]['userdb']    = 'rodrgus291r';
  $imobiliaria_controle[17]['passdb']    = '92Kfs251Gee1';
  $imobiliaria_controle[17]['basedb']    = 'rodriguesimoveisjau_com_br_1';
	
  $imobiliaria_controle[18]['cliente']   = 'urbe.tietenegocios.com.br';
  $imobiliaria_controle[18]['diretorio'] = 'urbe.tietenegocios.com.br';
  $imobiliaria_controle[18]['userdb']    = 'urb201ah';
  $imobiliaria_controle[18]['passdb']    = 'h91Ls22nb8';
  $imobiliaria_controle[18]['basedb']    = 'urbe_tietenegocios_com_br_1';
	
  $imobiliaria_controle[19]['cliente']   = 'corretorguilhermeperlati.com.br';
  $imobiliaria_controle[19]['diretorio'] = 'corretorguilhermeperlati.com.br';
  $imobiliaria_controle[19]['userdb']    = 'cgrusprlt';
  $imobiliaria_controle[19]['passdb']    = 'Kvc915a01l51Gq';
  $imobiliaria_controle[19]['basedb']    = 'corretorguilhermeperlati_com_br_1';
	
  
  if(@$_SESSION['WEBMASTER'] == 'webmaster'){
    foreach($imobiliaria_controle as $imob_control){
      if($_SESSION['imob_gerenciar'] == $imob_control['cliente']){
        define('DIRETORIO', $imob_control['diretorio']);
        $userdb = $imob_control['userdb'];
        $passdb = $imob_control['passdb'];
        $basedb = $imob_control['basedb'];
      }
    }
  }
  else{
    // echo $_SERVER['SERVER_NAME']."<br>";
    foreach($imobiliaria_controle as $imob_control){
      // echo $_SERVER['SERVER_NAME']." - ".$imob_control['cliente']."<br>";
      if(($_SERVER['SERVER_NAME'] == $imob_control['cliente']) OR ($_SERVER['SERVER_NAME'] == 'www.'.$imob_control['cliente'])){
        define('DIRETORIO', $imob_control['diretorio']);
        $userdb = $imob_control['userdb'];
        $passdb = $imob_control['passdb'];
        $basedb = $imob_control['basedb'];
				// echo "<br>Cliente: ".$imob_control['diretorio'];
				break;
      }
    }
  }

  $foto_caminho = "fotos/";
  
  
  $foto_tamanhos[] = "1300"; //tamanho original da foto
  $foto_tamanhos[] = "1300"; //tamanho original da foto
  $foto_tamanhos[] = "470";
  $foto_tamanhos[] = "310";
  
  
  $foto_diretorios[] = "original/"; //caminho da foto original
  $foto_diretorios[] = "t1/"; //caminho da foto original
  $foto_diretorios[] = "t2/";
  $foto_diretorios[] = "t3/";
?>