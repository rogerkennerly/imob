<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
  error_reporting(E_ALL | E_STRICT);
  ini_set('date.timezone' , 'America/Sao_Paulo');
  
  if ($_SERVER['SERVER_NAME'] == 'gbol.hospedaria.net.br' or $_SERVER['SERVER_NAME'] == 'localhost')
  { 
    ini_set('display_errors', 'On');
  } else
  { define('LOGERROS', 'error_handler.txt');
    ini_set('log_errors'    , 'On');
    ini_set('display_errors', 'Off');
    $olderror = set_error_handler('error_handler',E_ALL | E_STRICT); //logo tudo ( tudo + e_stric
    
    function error_handler($eNum, $eMsg, $file, $line, $eVars)
  	{ $errortype = array(
  				E_ERROR 			      => 'ERROR',
  				E_WARNING			      => 'WARNING',
  				E_PARSE				      => 'PARSING ERROR',
  				E_NOTICE			      => 'RUNTIME NOTICE',
  				E_CORE_ERROR		    => 'CORE ERROR',
  				E_CORE_WARNING      => 'CORE WARNING',
          E_COMPILE_ERROR     => 'COMPILE ERROR',
          E_COMPILE_WARNING   => 'COMPILE WARNING',
          E_USER_ERROR        => 'USER_ERROR',
          E_USER_WARNING      => 'USER WARNING',
          E_USER_NOTICE       => 'USER NOTICE',
          E_STRICT            => 'RUNTIME NOTICE',
          E_RECOVERABLE_ERROR	=> 'CATCHABLE FATAL ERROR'
  		);
  		$e  = "**********************************************************\n";
  		$e .=  $errortype[$eNum] . "(".$eNum.")" . " - " . date("Y-m-d H:i:s (T)") . "\n";
  		$e .= "ARQUIVO: " . $file . "(Linha " . $line .")\n";
  		$e .= $eMsg . "\n";
  		$e .= "\n"; // pra pular linha porque o error_log não pula linha automaticamente
  		error_log($e, 3, LOGERROS);// 3=gravar em arquivo ( dá pra mandar por email usando 1
  	}
  }
?>