<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php  
  ini_set("memory_limit","250M");
  function gera_thumb($original,$miniatura,$largura,$altura, $larg_maxima, $altu_maxima) //FUNCAO USANDO APENAS A GDLIB 
	{		
		$system = explode('.',basename($original));
    while ($system[0] == "") { array_shift($system); }
		if (preg_match('/jpg|jpeg|JPG|JPEG/',$system[1])){ $img_origi = imagecreatefromjpeg($original); } // Verifica o tipo da imagem
		if (preg_match('/png|PNG/',$system[1]))          { $img_origi = imagecreatefrompng($original);  } // Verifica o tipo da imagem
		if (preg_match('/gif|GIF/',$system[1]))          { $img_origi = imagecreatefromgif($original);  } // Verifica o tipo da imagem
		
		$larg_original = imageSX($img_origi); // Pega as dimensões da imagem original
		$altu_original = imageSY($img_origi); // Pega as dimensões da imagem original 
		
		if($largura!=0){ // Calcula a largura proporcional
			$altura = round(($altu_original/$larg_original)*$largura);
			if($altura>$altu_maxima && $altu_maxima>0) { $altura = $altu_maxima; }
		}			
		if($altura!=0){ // Calcula a altura proporcional
			$largura = round(($larg_original/$altu_original)*$altura);
			if($largura>$larg_maxima && $larg_maxima>0) { $largura = $larg_maxima; }
		}			
    
		$dst_img = ImageCreateTrueColor($largura,$altura); // Cria a nova imagem com o novo tamanho
		imagecopyresampled($dst_img, $img_origi, 0, 0, 0, 0, $largura, $altura, $larg_original, $altu_original); // Copia a imagem redimensionada
    
 		if (preg_match("/png|PNG/", $system[1]))          { imagepng($dst_img, $miniatura);  } // Gera a imagem de destino conforme a origem
 		if (preg_match("/jpg|jpeg|JPG|JPEG/", $system[1])){ imagejpeg($dst_img, $miniatura); }
 		if (preg_match("/gif|GIF/", $system[1]))          { imagegif($dst_img, $miniatura);  }
		imagedestroy($dst_img); 
		imagedestroy($img_origi);
	}
  
  
	function coloca_logo($original, $logo)
	{
		$system = explode('.',basename($original));
		if (preg_match('/jpg|jpeg|JPG|JPEG/',$system[1])){ $img_origi = @imagecreatefromjpeg($original); if (!$img_origi) { $system[1] = 'gif'; } } // Verifica o tipo da imagem
		if (preg_match('/gif|GIF/',$system[1]))          { $img_origi = @imagecreatefromgif($original);  if (!$img_origi) { $system[1] = 'png'; } } // Verifica o tipo da imagem
		if (preg_match('/png|PNG/',$system[1]))          { $img_origi = imagecreatefrompng($original);   } // Verifica o tipo da imagem
		
		$tam_origi = getimagesize($original);
		$tam_logo	 = getimagesize($logo);
		
		$logo = imagecreatefrompng($logo);
		imagecopyresampled($img_origi, $logo, $tam_origi[0]-($tam_logo[0]+5), $tam_origi[1]-($tam_logo[1]+5), 0, 0, $tam_logo[0] , $tam_logo[1], $tam_logo[0], $tam_logo[1]);		
		 		
 		if (preg_match("/jpg|jpeg|JPG|JPEG/", $system[1])){ imagejpeg($img_origi, $original); }
 		if (preg_match("/gif|GIF/", $system[1]))          { imagegif($img_origi, $original);  }
 		if (preg_match("/png|PNG/", $system[1]))          { imagepng($img_origi, $original);  } // Gera a imagem de destino conforme a origem
		imagedestroy($logo);
		imagedestroy($img_origi);
	}
?>