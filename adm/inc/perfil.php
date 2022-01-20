<?php
  $id_usuario = $_GET["id"];
  $q = mysql_query("SELECT * FROM usuario WHERE id = '$id_usuario'");
  $usuario = mysql_fetch_assoc($q);
?>

<div class="page-content">
  <div class="page-header">
    <h1>
      Perfil
      <a href="index.php?pg=editar-usuario&id=<?php echo $id_usuario; ?>">
        <i class="fas fa-edit" style="float:right;line-height:3rem;"></i>
      </a>
    </h1>
  </div><!-- /.page-header -->
  <div class="row">
    <div class="col-xs-12">
      <!-- PAGE CONTENT BEGINS -->


        <div id="user-profile-1" class="user-profile row">
          <div class="col-xs-12 col-sm-3 center">
            <div>
              <span class="profile-picture">
                <img id="avatar" class="editable img-responsive" alt="Alex's Avatar" width="250" src="assets/avatar/<?php echo $usuario["avatar"]; ?>" />
              </span>

              <div class="space-4"></div>

              <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                <div class="inline position-relative">
                  <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                    &nbsp;
                    <span class="white"><?php echo $usuario["nome"]; ?></span>
                  </a>
                </div>
              </div>
            </div>

            <div class="space-6"></div>

            <div class="profile-contact-info">
              <div class="space-6"></div>

              <div class="profile-social-links center">
                <a href="#" class="tooltip-info" title="" data-original-title="Visit my Facebook">
                  <i class="middle icon-facebook-sign icon-2x blue"></i>
                </a>

                <a href="#" class="tooltip-info" title="" data-original-title="Visit my Twitter">
                  <i class="middle icon-twitter-sign icon-2x light-blue"></i>
                </a>

                <a href="#" class="tooltip-error" title="" data-original-title="Visit my Pinterest">
                  <i class="middle icon-pinterest-sign icon-2x red"></i>
                </a>
              </div>
            </div>

            <div class="hr hr12 dotted"></div>

            <div class="clearfix">
              <div class="grid2">
                <?php
                $q_captados = mysql_query("SELECT id FROM imovel WHERE id_corretor = '$id_usuario'");
                $num_imoveis = mysql_num_rows($q_captados);?>
                <span class="bigger-175 blue"><?php echo $num_imoveis; ?></span>

                <br />
                Imóveis Captados
              </div>
              
              <?php
                $s_atividades = "SELECT * FROM log WHERE id_usuario = '$id_usuario' ORDER BY id DESC";
                $q_atividades = mysql_query($s_atividades);
              ?>

              <div class="grid2">
                <span class="bigger-175 blue"><?php echo mysql_num_rows($q_atividades); ?></span>

                <br />
                Atividades
              </div>
            </div>

            <div class="hr hr16 dotted"></div>
          </div>

          <div class="col-xs-12 col-sm-9">

            <div class="space-12"></div>

            <div class="profile-user-info profile-user-info-striped">
              <div class="profile-info-row">
                <div class="profile-info-name"> Usuário </div>

                <div class="profile-info-value">
                  <span class="editable" id="username"><?php echo $usuario["usuario"]; ?></span>
                </div>
              </div>

              <div class="profile-info-row">
                <div class="profile-info-name"> Tipo Usuário   </div>

                <div class="profile-info-value">
                  <span class="editable" id="country"><?php echo usuario_tipo($usuario["tipo"]); ?></span>
                </div>
              </div>

              <div class="profile-info-row">
                <div class="profile-info-name"> Idade </div>

                <div class="profile-info-value">
                  <span class="editable" id="age"><?php echo idade($usuario["data_nascimento"]); ?></span>
                </div>
              </div>

              <div class="profile-info-row">
                <div class="profile-info-name"> Cadastrado em </div>

                <div class="profile-info-value">
                  <span class="editable" id="signup"><?php echo tratar_data_hora($usuario["data_cadastro"]); ?></span>
                </div>
              </div>

              <div class="profile-info-row">
                <div class="profile-info-name"> Último Login </div>

                <div class="profile-info-value">
                  <span class="editable" id="login"><?php echo tratar_data_hora($usuario["ultimo_login"]); ?></span>
                </div>
              </div>

              <div class="profile-info-row">
                <div class="profile-info-name"> Sobre </div>

                <div class="profile-info-value">
                  <span class="editable" id="about"><?php echo $usuario["detalhes"]."&nbsp;"; ?></span>
                </div>
              </div>
            </div>

            <div class="space-20"></div>

            <div class="widget-box transparent">
              <div class="widget-header widget-header-small">
                <h4 class="blue smaller">
                  <i class="icon-rss orange"></i>
                  Atividades Recentes
                </h4>

                <!--div class="widget-toolbar action-buttons">
                  <a href="#" data-action="reload">
                    <i class="icon-refresh blue"></i>
                  </a>

                  &nbsp;
                  <a href="#" class="pink">
                    <i class="icon-trash"></i>
                  </a>
                </div-->
              </div>
              
              <style>
              #profile-feed-1{height:auto !important;max-height:250px !important;}
              </style>

              <div class="widget-body">
                <div class="widget-main padding-8">
                  <div id="profile-feed-1" style="height:auto;min-height:250px;">
                    <?php 
                    while($r = mysql_fetch_assoc($q_atividades)){
                      $usuario = mysql_query("SELECT * FROM usuario WHERE id = '".$r["id_usuario"]."'");
                      $usuario = mysql_fetch_assoc($usuario);?>
                    <div class="profile-activity clearfix">
                      <div>
                        <img class="pull-left" alt="Alex Doe's avatar" src="assets/avatar/<?php echo $usuario["avatar"]; ?>" />
                        <a class="user" href="#"> <?php echo $usuario["nome"]; ?> </a>
                        <?php echo $r["descricao"]; ?>
                        <!--a href="#">Take a look</a-->

                        <div class="time">
                          <i class="icon-time bigger-110"></i>
                          <?php echo $r["data"]; ?>
                        </div>
                      </div>

                      <!--div class="tools action-buttons">
                        <a href="#" class="blue">
                          <i class="icon-pencil bigger-125"></i>
                        </a>

                        <a href="#" class="red">
                          <i class="icon-remove bigger-125"></i>
                        </a>
                      </div-->
                    </div>
                    <?php
                    }?>
                  </div>
                </div>
              </div>
            </div>

            <div class="hr hr2 hr-double"></div>

            <div class="space-6"></div>

            <!--div class="center">
              <a href="#" class="btn btn-sm btn-primary">
                <i class="icon-rss bigger-150 middle"></i>
                <span class="bigger-110">View more activities</span>

                <i class="icon-on-right icon-arrow-right"></i>
              </a>
            </div-->
          </div>
        </div>
      </div>
  </div>
</div>
    
		<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<script type="text/javascript">
			jQuery(function($) {
							//another option is using modals
				$('#avatar2').on('click', function(){          
					form.on('submit', function(){
						if(!file.data('ace_input_files')) return false;
						
						file.ace_file_input('disable');
						form.find('button').attr('disabled', 'disabled');
						form.find('.modal-body').append("<div class='center'><i class='icon-spinner icon-spin bigger-150 orange'></i></div>");
						
						var deferred = new $.Deferred;
						working = true;
						deferred.done(function() {
							form.find('button').removeAttr('disabled');
							form.find('input[type=file]').ace_file_input('enable');
							form.find('.modal-body > :last-child').remove();
							
							modal.modal("hide");
			
							var thumb = file.next().find('img').data('thumb');
							if(thumb) $('#avatar2').get(0).src = thumb;
			
							working = false;
						});
						
						
						setTimeout(function(){
							deferred.resolve();
						} , parseInt(Math.random() * 800 + 800));
			
						return false;
					});
							
				});
			
				
			
				//////////////////////////////
				$('#profile-feed-1').slimScroll({
				height: '250px',
				alwaysVisible : true
				});
			
				$('.profile-social-links > a').tooltip();
			
				$('.easy-pie-chart.percentage').each(function(){
				var barColor = $(this).data('color') || '#555';
				var trackColor = '#E2E2E2';
				var size = parseInt($(this).data('size')) || 72;
				$(this).easyPieChart({
					barColor: barColor,
					trackColor: trackColor,
					scaleColor: false,
					lineCap: 'butt',
					lineWidth: parseInt(size/10),
					animate:false,
					size: size
				}).css('color', barColor);
				});
			  
			});
		</script>
    