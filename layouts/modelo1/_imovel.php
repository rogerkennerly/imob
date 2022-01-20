<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php
  $id_imovel 	= evita_injection($_GET['id']);
	$id_fin   	= evita_injection($_GET['id_fin']);
	$data = date('Y-m-d');
	mysql_query("UPDATE imovel SET visualizacao=visualizacao+1, ultimo_acesso = NOW() WHERE id = '$id_imovel'");

	$q_visualizacoes = mysql_query("SELECT * FROM visualizacao WHERE data = '$data'");

	if(mysql_num_rows($q_visualizacoes) > 0){
		mysql_query("UPDATE visualizacao SET contador=contador+1 WHERE data = '$data'");
	}
	else{	
		mysql_query("INSERT INTO visualizacao (contador, data) VALUES (1, NOW())");
	}

	$s 		= "SELECT imovel.*, imovel_finalidade.id_finalidade, imovel_finalidade.valor as valor_finalidade, imovel_finalidade.iptu, imovel_finalidade.condominio FROM imovel, imovel_finalidade WHERE disponivel = 'S' AND excluido = 'N' AND imovel.id = '$id_imovel' AND imovel.id = imovel_finalidade.id_imovel";

   if($id_fin){
	   $sfin = "SELECT id FROM finalidade WHERE nome = '$id_fin'";
	   $qfin = mysql_query($sfin);
	   $rfin = mysql_fetch_assoc($qfin);
	   $id_fin = $rfin["id"];
	   $s .= " AND imovel_finalidade.id_finalidade = '$id_fin'";
   }
  	$q = mysql_query($s);
	$imovel 	= mysql_fetch_assoc($q);

	if(!@in_array($id_imovel, $_SESSION['ultimos_visitados']) AND mysql_num_rows($q) > 0){ $_SESSION['ultimos_visitados'][] = $id_imovel; }
?>

<?php 
	if(mysql_num_rows($q) > 0){?>
		<section class="imob_imovel">
			<div class="centralizador">
				<?php if(!include "clientes/".DIRETORIO."/inc/breadcrumbs.php")    {include "layouts/$layout/breadcrumbs.php";} ?>
			</div>
			<div class="imob_imovel_ficha">
				<div class="centralizador">
					<div class="imob_imovel_ficha_titulo">
						<?php 
							$titulo_imovel 	= retorna_nome('tipo', $imovel['id_tipo']);
							$titulo_imovel .= " para ".retorna_nome('finalidade', $imovel['id_finalidade']);
							$titulo_imovel .= " no bairro ".retorna_nome('bairro', $imovel['id_bairro']);
							$titulo_imovel .= " em ".retorna_nome('cidade', $imovel['id_cidade']);
						?>
						<h1><?php echo $titulo_imovel; ?></h1>
					</div>
				</div>
				<div class="imob_imovel_ficha_fotos owl-carousel owl_carrousel_imovel_ficha_fotos owl-theme">
					<?php 
						$q_foto = mysql_query("SELECT * FROM foto WHERE id_imovel = ".$imovel['id']." ORDER BY posicao");

						if($imovel['video']){?>
							<div class="imob_imovel_ficha_fotos_img">
								<iframe width="100%" height="100%" src="https://www.youtube.com/embed/<?php echo $imovel['video']; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
							</div><?php
						}

						$qtde_fotos = 0;
						$num_items 	= 0;
						while($fotos_imovel = mysql_fetch_assoc($q_foto)){
							$qtde_fotos++;?>

							<div class="imob_imovel_ficha_fotos_img">
								<a data-fancybox="gallery" href="/clientes/<?php echo DIRETORIO; ?>/fotos/<?php echo $imovel['id']; ?>/t1/<?php echo $fotos_imovel['nome']; ?>">
									<img src="/clientes/<?php echo DIRETORIO; ?>/fotos/<?php echo $imovel['id']; ?>/t2/<?php echo $fotos_imovel['nome']; ?>" alt="Foto do imóvel">
								</a>
							</div><?php
						}
						for($x=0; $x<(4-$qtde_fotos); $x++){
							if(mysql_num_rows($q_foto) != 0){?>
								<div class="imob_imovel_ficha_fotos_img">
									<a data-fancybox="gallery" href="/clientes/<?php echo DIRETORIO; ?>/fotos/foto_padrao.png">
										<img src="/clientes/<?php echo DIRETORIO; ?>/fotos/foto_padrao.png" alt="Nenhuma foto cadastrada">
									</a>
								</div><?php
							}
						}
						if(mysql_num_rows($q_foto) == 0){
							for($i=0; $i<4; $i++){
								$qtde_fotos++;?>
								<div class="imob_imovel_ficha_fotos_img">
									<a data-fancybox="gallery" href="/clientes/<?php echo DIRETORIO; ?>/fotos/nenhuma_foto.jpg">
										<img src="/clientes/<?php echo DIRETORIO; ?>/fotos/nenhuma_foto.jpg" alt="Nenhuma foto cadastrada">
									</a>
								</div><?php
							}
						}

						if($qtde_fotos >= 4){
							$num_items = 4;
						}
						else{
							$num_items = $qtde_fotos;
						}
					?>
				</div>
				<script>
					$('.owl_carrousel_imovel_ficha_fotos').owlCarousel({
					  items: 4,
					  margin: 10,
				      nav: false,
				      dots: false,
				      responsiveClass:true,
				      responsive:{
				          0:{
				              items:1,
				              nav:true
				          },
				          641:{
				              items:2,
				              nav:true
				          },
				          1024:{
				              items:4,
				              nav:true,
				              loop:false
				          },
				          1320:{
				              items:4,
				              nav:true,
				              loop:false
				          }
				      }
					});
				</script>
				<div class="imob_imovel_ficha_1">
					<div class="centralizador">
						<ul class="imob_imovel_ficha_1_especs">
							<?php
								if($imovel['ref']){?>
									<li>Ref. <?php echo $imovel['ref']; ?></li><?php
								}
								if($imovel['valor_finalidade'] > 0){?>
									<li>Valor: R$ <?php echo tratar_moeda($imovel['valor_finalidade'], 2); ?></li><?php
								}else{?>
									<li>Valor: A consultar</li><?php
								}
								if($imovel['area_construida']){?>
									<li><i class="fa fa-home"></i> <?php echo $imovel['area_construida']; ?> m² Construido</li><?php
								}
								if($imovel['terreno']){?>
									<li><i class="fa fa-expand"></i> <?php echo $imovel['terreno']; ?> m² Total</li><?php
								}
							?>
						</ul>
						<div class="imob_imovel_ficha_1_favorito" title="Adicionar as favoritos" onclick="favoritar(<?php echo $imovel['id']; ?>, <?php echo $imovel['id_finalidade']; ?>,this);">
							<?php
								$id_imovel 	= $imovel['id'];
								$id_cookie 	= $_COOKIE['cookies_imob'];
								$s_favoritos = mysql_query("SELECT * FROM favoritos WHERE id_cookie = '$id_cookie' AND id_imovel = '$id_imovel' AND id_finalidade = ".$imovel['id_finalidade']);

								$classe = "";
								if(mysql_num_rows($s_favoritos) > 0){
									$classe = "fav";
								}
							?>
							<p>Favorito </p>
							<i class="fa fa-heart <?php echo $classe; ?>"></i>
						</div>
						<ul class="imob_imovel_ficha_1_compartilhar">
							<p>Compartilhar </p>
							<li>
								<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode($url); ?>&amp;src=sdkpreparse" data-href="<?php echo urlencode($url); ?>" title="Compartilhar no facebook" target="_blank">
									<i class="fa fa-facebook"></i>
								</a>
							</li>
							<li>
								<a href="http://api.whatsapp.com/send?text=<?php echo $titulo_imovel; ?> <?php echo urlencode($url); ?>" title="Compartilhar no whatsapp" data-action="share/whatsapp/share" target="_blank">
									<i class="fa fa-whatsapp"></i>
								</a>
							</li>
						</ul>
						<div class="hack"></div>
					</div>
				</div>
				<div class="imob_imovel_ficha_2">
					<div class="centralizador">
						<div class="imob_imovel_ficha_2_especs">
							<ul>
								<?php  
									if($imovel['quarto']){?>
										<li><i class="fa fa-bed"></i> <?php echo $imovel['quarto']; ?> <?php if($imovel['quarto'] > 1){ echo 'Quartos'; }else{ echo 'Quarto'; } ?> </li><?php
									}
									if($imovel['banheiro']){?>
										<li><i class="fa fa-bath"></i> <?php echo $imovel['banheiro']; ?> <?php if($imovel['banheiro'] > 1){ echo 'Banheiros'; }else{ echo 'Banheiro'; } ?> </li><?php
									}
									if($imovel['suite']){?>
										<li><i class="fa fa-tint"></i> <?php echo $imovel['suite']; ?> <?php if($imovel['suite'] > 1){ echo 'Suítes'; }else{ echo 'Suíte'; } ?> </li><?php
									}
									if($imovel['garagem']){?>
										<li><i class="fa fa-car"></i> <?php echo $imovel['garagem']; ?> <?php if($imovel['garagem'] > 1){ echo 'Vagas'; }else{ echo 'Vaga'; } ?> </li><?php
									}
								?>
							</ul>
						</div>

						<!-- DIV IPTU / CONDOMÍNIO -->
						<div class="imob_imovel_ficha_2_iptu" style="padding-bottom: 4rem; font-size: 1.9rem;">
							<?php 
								if($imovel['iptu'] AND $imovel['iptu'] != 0){?>
									<p style="display: block; margin-bottom: 1rem;">
										Valor do IPTU: R$ <?php echo tratar_moeda($imovel['iptu'], 2); ?>
									</p><?php
								}
								if($imovel['condominio'] AND $imovel['condominio'] != 0){?>
									<p style="display: block; margin-top: 1rem;">
										Valor do condomínio: R$ <?php echo tratar_moeda($imovel['condominio'], 2); ?>
									</p><?php
								}
							?>
						</div>
						<!-- FIM -->

						<?php 
							if($imovel['financia'] == 'S'){?>
								<div class="imob_imovel_ficha_2_finan" style="padding-bottom: 4rem; font-size: 1.9rem; color: #c40000;">
									<span><i class="fa fa-check"></i> Aceita Financiamento</span>
								</div><?php
							}
						?>
						<div class="imob_imovel_ficha_2_descricao">
							<div class="imob_imovel_ficha_2_descricao_titulo">
								<h1>Descrição</h1>
							</div>
							<?php  
								if($imovel['detalhes']){?>
									<div class="imob_imovel_ficha_2_descricao_desc">
										<p><?php echo nl2br($imovel['detalhes']); ?></p>
									</div><?php
								}else{?>
									<div class="imob_imovel_ficha_2_descricao_desc">
										<p><?php echo $titulo_imovel; ?></p>
									</div><?php
								}

								$q_items = mysql_query("SELECT imovel_item.*, item.* FROM imovel_item, item WHERE imovel_item.id_item = item.id AND imovel_item.id_imovel = ".$imovel['id']."");

								if(mysql_num_rows($q_items) > 0){?>
									<div class="imob_imovel_ficha_2_descricao_infra">
										<h1>Infraestrutura</h1>
									</div>
									<ul class="imob_imovel_ficha_2_descricao_infra_lista">
										<?php  
											while($imovel_items = mysql_fetch_assoc($q_items)){?>
												<li><i class="fa fa-check"></i> <?php echo $imovel_items['nome']; ?></li><?php
											}
										?>
									</ul><?php
								}
							?>
						</div>
						<div class="imob_imovel_ficha_2_proposta">
							<?php  
								if($_POST){
									$nome 		= evita_injection($_POST['nome']);
									$email 		= evita_injection($_POST['email']);
									$telefone 	= evita_injection($_POST['telefone']);
									$mensagem 	= evita_injection($_POST['mensagem']);
									$ip 			= get_client_ip();

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
										
										$headers = "MIME-Version: 1.1\r\n";
										$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
										$headers .= "From: ".$dados_email[0]."\r\n"; // remetente
										$headers .= "Return-Path: $email\r\n"; // return-path

										for($i=0; $i<count($dados_email); $i++){
											$envio = mail($dados_email[$i], utf8_decode("Nova proposta recebida do imóvel ref. ".$imovel['ref']), $txt, $headers);
										}

										$q = "INSERT INTO contato (nome, email, telefone, mensagem, tipo, data, ip) VALUES ('$nome', '$email', '$telefone', '$mensagem', '1', NOW(), '$ip')";
										$q_proposta = mysql_query($q);

										if($envio AND $q_proposta == 1){
											$descricao = "Mensagem enviado pela página do imóvel ref ". $imovel['ref'];?>
											<script>
												alert('Contato enviado! Aguarde nosso retorno.');
											</script><?php
										}
									}
								}
							?>
							<div class="imob_imovel_ficha_2_proposta_titulo">
								<h1>Proposta</h1>
							</div>
							<form action="" method="POST" class="imob_imovel_ficha_2_proposta_form" id="imob_form_proposta">
								<div class="imob_imovel_ficha_2_proposta_form_input">
									<input type="text" name="nome" id="nome" class="cor_outline" placeholder="Nome">
								</div>
								<div class="imob_imovel_ficha_2_proposta_form_input">
									<input type="email" name="email" id="email" class="cor_outline" placeholder="Email">
								</div>
								<div class="imob_imovel_ficha_2_proposta_form_input">
									<input type="tel" name="telefone" id="telefone" class="cor_outline" placeholder="Telefone">
								</div>
								<div class="imob_imovel_ficha_2_proposta_form_textarea">
									<textarea name="mensagem" id="mensagem" class="cor_outline" placeholder="Digite sua mensagem">Estou interessado(a) no imóvel Ref. <?php echo $imovel['ref']; ?> e gostaria de mais detalhes.</textarea>
								</div>
								<?php
									if($config['captcha'] == 'S' AND $config['key_captcha']){?>
										<!-- RECAPTCHA -->
										<div class="imob_imovel_ficha_2_proposta_form_button">
											<button class="g-recaptcha cor_botao" data-sitekey="<?php echo $sitekey; ?>" data-callback="$('#imob_form_proposta').submit();" onclick="$('#imob_form_proposta').submit();"><i class="fa fa-envelope"></i>&nbsp; Enviar</button>
										</div>
										<!-- /RECAPTCHA --><?php
									}
									else{?>
										<div class="imob_contato_formulario_form_button">
											<button class="cor_botao" onclick="$('#imob_form_proposta').submit();"><i class="fa fa-envelope"></i>&nbsp; Enviar</button>
										</div><?php
									}
								?>
							</div>
						</div>
					</div>
				</div>
				<div class="hack"></div>

				<?php
					$key = "AIzaSyAXKL6xIfNJxMinJ7OFSXyCttAgsp8x-6w";
					$q_bairros	= mysql_query("SELECT latitude, longitude FROM bairro WHERE id = ".$imovel['id_bairro']."");
					$bairro 	= mysql_fetch_assoc($q_bairros);
					$latitude 	= $bairro['latitude'];
					$longitude 	= $bairro['longitude'];

					if($latitude == '' OR $longitude == ''){
						$endereco = retorna_nome('bairro', $imovel['id_bairro']).", ".retorna_nome('cidade', $imovel['id_cidade'])." - SP";
						$endereco = str_replace(" ", "+", $endereco);

						$lat_lng = "https://maps.googleapis.com/maps/api/geocode/json?address=". $endereco ."&key=AIzaSyD_43IUCJkF6kr-QqQz7ws6F2zEv1kjW8A";
						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $lat_lng);
		   			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		   			$geoloc = json_decode(curl_exec($ch), true);

		   			$latitude 	= $geoloc[results][0][geometry][location][lat];
						$longitude 	= $geoloc[results][0][geometry][location][lng];

						mysql_query("UPDATE bairro SET latitude = '$latitude', longitude = '$longitude' WHERE id = ".$imovel['id_bairro']."");
					}?>

					<div class="imob_imovel_ficha_mapa">
						<div class="centralizador">
							<div class="imob_imovel_ficha_mapa_titulo">
								<h1>Localização aproximada do imóvel</h1>
							</div>
						</div>
						<?php 
							if(!$latitude){?>
								<div class="imob_imovel_ficha_mapa_indisponivel">
									<h1>Localização indisponível</h1>
									<img src="clientes/<?php echo DIRETORIO; ?>/fotos/nenhum_mapa.jpg" alt="Localização indisponível">
								</div><?php
							}
							else{?>
								<div id="mapa"></div><?php
							}
						?>
					</div><?php
				?>

				<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $key; ?>&callback=initMap"></script>
				<script>
					function initMap() {
						var latLng = {lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?>};
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
		</section>

		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = 'https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.11&appId=602571720087652';
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script><?php
	}
	else{
		if(!include "clientes/".DIRETORIO."/inc/indisponivel.php"){include "layouts/$layout/indisponivel.php";}
	}	
?>
