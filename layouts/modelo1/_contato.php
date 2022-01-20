<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
	$q 			= mysql_query("SELECT * FROM dados_imobiliaria");
	$dados 	= mysql_fetch_assoc($q);

	if($_POST){
		$nome 			= evita_injection($_POST['nome']);
		$email 			= evita_injection($_POST['email']);
		$telefone 	= evita_injection($_POST['telefone']);
		$mensagem 	= evita_injection($_POST['mensagem']);
		$ip 				= get_client_ip();

		if(empty($nome) OR empty($email) OR empty($telefone) OR empty($mensagem)){?>
			<script>
				alert('Preencha todos os campos');
			</script><?php
		}
		else{
			$txt .= "Nome: ".utf8_decode($nome)."\n";
			$txt .= "E-mail: ".$email."\n";
			$txt .= "Telefone: ".$telefone."\n";
			$txt .= "Mensagem: ".utf8_decode($mensagem)."\n";
      
      $email_remetente = 'site@'.CLIENTE;
			
			$headers 	= "MIME-Version: 1.1\r\n";
			$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
			$headers .= "From: ".$email_remetente."\r\n"; // remetente
			$headers .= "Reply-To: $email\r\n"; // return-path
			// $headers .= "Return-Path: $email\r\n"; // return-path


			for($i=0; $i<count($dados_email); $i++){
				$envio = mail($dados_email[$i], utf8_decode("Formulário de contato do site"), $txt, $headers);
			}

			$q = "INSERT INTO contato (nome, email, telefone, mensagem, tipo, data, ip) VALUES ('$nome', '$email', '$telefone', '$mensagem', '2', NOW(), '$ip')";
			$q_contato = mysql_query($q);

			if($envio AND $q_contato == 1){
				$descricao = "Mensagem enviado pela página contato.";?>

				<script>
					alert('Contato enviado! Aguarde nosso retorno.');
				</script><?php
			}
			else{?>
				<script>
					alert('Não foi possível entrar em contato no momento, tente novamente.');
				</script><?php
			}
		}
	}
?>
<section class="imob_contato">
	<div class="centralizador">
		<div class="imob_contato_titulo">
			<h1>Entre em contato</h1>
		</div>
		<div class="imob_contato_formulario">
			<form action="" method="POST" id="imob_contato_formulario_form" class="imob_contato_formulario_form">
				<div class="imob_contato_formulario_form_input">
					<input type="text" name="nome" id="nome" class="cor_outline" placeholder="Nome">
				</div>
				<div class="imob_contato_formulario_form_input">
					<input type="email" name="email" id="email" class="cor_outline" placeholder="Email">
				</div>
				<div class="imob_contato_formulario_form_input">
					<input type="tel" name="telefone" id="telefone" class="cor_outline" placeholder="Telefone">
				</div>
				<div class="imob_contato_formulario_form_textarea">
					<textarea name="mensagem" id="mensagem" class="cor_outline" placeholder="Digite sua mensagem"></textarea>
				</div>
				<?php
					if($config['captcha'] == 'S' AND $config['key_captcha']){?>
						<!-- RECAPTCHA -->
						<div class="imob_contato_formulario_form_button">
							<button class="g-recaptcha cor_botao" data-sitekey="<?php echo $sitekey; ?>" data-callback="$('#imob_contato_formulario_form').submit();" onclick="$('#imob_contato_formulario_form').submit();"> Contato</button>
						</div>
						<!-- /RECAPTCHA --><?php
					}
					else{?>
						<div class="imob_contato_formulario_form_button">
							<button class="cor_botao" onclick="$('#imob_contato_formulario_form').submit();"> Contato</button>
						</div><?php
					}
				?>
			</form>
		</div>
		<div class="imob_contato_informacoes">
			<?php  
				if($dados['email']){?>
					<div class="imob_contato_informacoes_item">
						<i class="fa fa-envelope"></i>
						<span>
							 <?php 
								echo $dados_email[0];
								if($dados_email[1]){ echo ' / '.$dados_email[1]; }
							?>
						</span>
					</div><?php
				}
				if($dados['telefone']){?>
					<div class="imob_contato_informacoes_item">
						<i class="fa fa-phone"></i>
						<span> <?php echo $dados['telefone']; ?></span>
					</div><?php
				}
				if($dados['celular']){?>
					<div class="imob_contato_informacoes_item">
						<i class="fa fa-whatsapp"></i>
						<span> <?php echo $dados['celular']; ?></span>
					</div><?php
				}
				if($dados['endereco']){?>
					<div class="imob_contato_informacoes_item">
						<i class="fa fa-map-marker"></i>
						<span> <?php echo $dados['endereco']. '  ' .$dados['bairro']. ' - ' .$dados['cidade']. '/' .$dados['estado']; ?></span>
					</div><?php
				}
			?>
			<?php
				$key = "AIzaSyAXKL6xIfNJxMinJ7OFSXyCttAgsp8x-6w";
				$latitude 	= $dados['latitude'];
				$longitude 	= $dados['longitude'];

				if($latitude == '' OR $longitude == ''){
					$endereco = $dados['endereco']." ".$dados['bairro']." - ".$dados['cidade'].", ".$dados['estado'];
					$endereco = str_replace(" ", "+", $endereco);

					$lat_lng = "https://maps.googleapis.com/maps/api/geocode/json?address=". $endereco ."&key=AIzaSyD_43IUCJkF6kr-QqQz7ws6F2zEv1kjW8A";
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $lat_lng);
   				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   				$geoloc = json_decode(curl_exec($ch), true);

   				$latitude 	= $geoloc[results][0][geometry][location][lat];
					$longitude 	= $geoloc[results][0][geometry][location][lng];


					mysql_query("UPDATE dados_imobiliaria SET latitude = '$latitude', longitude = '$longitude'");
				}

				if($dados['latitude'] != '' AND $dados['longitude'] != ''){?>
					<div class="imob_contato_informacoes_mapa">
						<div id="mapa"></div>
					</div><?php
				}
			?>

			<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $key; ?>&callback=initMap"></script>
			<script>
				function initMap() {
					var latLng = {lat: <?php echo $dados['latitude']; ?>, lng: <?php echo $dados['longitude']; ?>};
					var mapa = new google.maps.Map(document.getElementById('mapa'), {
						zoom: 15,
						center: latLng,
						styles: [
						  {
						    "elementType": "geometry",
						    "stylers": [
						      {
						        "color": "#f5f5f5"
						      }
						    ]
						  },
						  {
						    "elementType": "labels.icon",
						    "stylers": [
						      {
						        "visibility": "off"
						      }
						    ]
						  },
						  {
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#616161"
						      }
						    ]
						  },
						  {
						    "elementType": "labels.text.stroke",
						    "stylers": [
						      {
						        "color": "#f5f5f5"
						      }
						    ]
						  },
						  {
						    "featureType": "administrative.land_parcel",
						    "elementType": "labels",
						    "stylers": [
						      {
						        "visibility": "off"
						      }
						    ]
						  },
						  {
						    "featureType": "administrative.land_parcel",
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#bdbdbd"
						      }
						    ]
						  },
						  {
						    "featureType": "poi",
						    "elementType": "geometry",
						    "stylers": [
						      {
						        "color": "#eeeeee"
						      }
						    ]
						  },
						  {
						    "featureType": "poi",
						    "elementType": "labels.text",
						    "stylers": [
						      {
						        "visibility": "off"
						      }
						    ]
						  },
						  {
						    "featureType": "poi",
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#757575"
						      }
						    ]
						  },
						  {
						    "featureType": "poi.park",
						    "elementType": "geometry",
						    "stylers": [
						      {
						        "color": "#e5e5e5"
						      }
						    ]
						  },
						  {
						    "featureType": "poi.park",
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#9e9e9e"
						      }
						    ]
						  },
						  {
						    "featureType": "road",
						    "elementType": "geometry",
						    "stylers": [
						      {
						        "color": "#ffffff"
						      }
						    ]
						  },
						  {
						    "featureType": "road.arterial",
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#757575"
						      }
						    ]
						  },
						  {
						    "featureType": "road.highway",
						    "elementType": "geometry",
						    "stylers": [
						      {
						        "color": "#dadada"
						      }
						    ]
						  },
						  {
						    "featureType": "road.highway",
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#616161"
						      }
						    ]
						  },
						  {
						    "featureType": "road.local",
						    "elementType": "labels",
						    "stylers": [
						      {
						        "visibility": "off"
						      }
						    ]
						  },
						  {
						    "featureType": "road.local",
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#9e9e9e"
						      }
						    ]
						  },
						  {
						    "featureType": "transit.line",
						    "elementType": "geometry",
						    "stylers": [
						      {
						        "color": "#e5e5e5"
						      }
						    ]
						  },
						  {
						    "featureType": "transit.station",
						    "elementType": "geometry",
						    "stylers": [
						      {
						        "color": "#eeeeee"
						      }
						    ]
						  },
						  {
						    "featureType": "water",
						    "elementType": "geometry",
						    "stylers": [
						      {
						        "color": "#c9c9c9"
						      }
						    ]
						  },
						  {
						    "featureType": "water",
						    "elementType": "labels.text.fill",
						    "stylers": [
						      {
						        "color": "#9e9e9e"
						      }
						    ]
						  }
						]
					});
					var marker = new google.maps.Marker({
						position: latLng,
						map: mapa
					});
				}
		    </script>
		</div>
		<div class="hack"></div>
	</div>
</section>
