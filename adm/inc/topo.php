<div class="navbar navbar-default navbar-fixed-top" id="navbar">
			<script type="text/javascript">
				try{ace.settings.check('navbar' , 'fixed')}catch(e){}
			</script>

			<div class="navbar-container" id="navbar-container">
				<div class="navbar-header pull-left">
					<a href="#" class="navbar-brand">
						<small>
							<i class="icon-home"></i>
							Sist Imob
						</small>
					</a><!-- /.brand -->
				</div><!-- /.navbar-header -->

				<div class="navbar-header pull-right" role="navigation">
					<ul class="nav ace-nav topo_mobile">
          
          <?php
          if($_SESSION['WEBMASTER'] == 'webmaster'){?>
          <li style="margin-right:10px;">
            <div class="col-xs-12 controle-chosen corrige-lupa">
              <select class="chosen-select" onchange="redirect_gerenciar_imob('<?php echo $_SERVER['SERVER_NAME'];?>','<?php echo $pg;?>', this.value)" style="min-width:200px;">
								<?php
								foreach($imobiliaria_controle as $imob){?>
									<option value="<?php echo $imob['cliente']; ?>" <?php if($_SESSION['imob_gerenciar'] == $imob['cliente']){echo 'selected';} ?>><?php echo $imob['cliente']; ?> </option>
								<?php
								}
								
								/*?>
							
                <?php if($_SERVER['SERVER_NAME'] != 'imob.hospedaria.com.br'){ ?>
                <option value="sistimob.hospedaria.net.br" <?php if($_SESSION['imob_gerenciar'] == 'sistimob.hospedaria.net.br'){echo 'selected';} ?>>Canavial </option>
                <?php } ?>
                <?php if($_SERVER['SERVER_NAME'] == 'imob.hospedaria.com.br'){ ?>
                <option value="imob.hospedaria.com.br" <?php if($_SESSION['imob_gerenciar'] == 'imob.hospedaria.com.br'){echo 'selected';} ?>>
                  Teste    
                </option>
                <option value="imobiliariabarros.com" <?php if($_SESSION['imob_gerenciar'] == 'imobiliariabarros.com'){echo 'selected';} ?>>
                  Imobiliaria Barros    
                </option>
                <option value="jmimovel.com.br" <?php if($_SESSION['imob_gerenciar'] == 'jmimovel.com.br'){echo 'selected';} ?>>                      Jm Imovel</option>
                <option value="site.casajau.com.br" <?php if($_SESSION['imob_gerenciar'] == 'site.casajau.com.br'){echo 'selected';} ?>>              Site Casa Jau</option>
                <option value="regionalnegocios.com.br" <?php if($_SESSION['imob_gerenciar'] == 'regionalnegocios.com.br'){echo 'selected';} ?>>      Regional Negocios</option>
                <option value="marcosadrianoimoveis.com.br" <?php if($_SESSION['imob_gerenciar'] == 'marcosadrianoimoveis.com.br'){echo 'selected';} ?>>Marcos Adriano Imoveis   </option>
                <option value="epaimobiliaria.com.br" <?php if($_SESSION['imob_gerenciar'] == 'epaimobiliaria.com.br'){echo 'selected';} ?>>          Epa Imobiliaria</option>
                <option value="pedroimoveis.com.br" <?php if($_SESSION['imob_gerenciar'] == 'pedroimoveis.com.br'){echo 'selected';} ?>>          Pedro Im�veis</option>
                <option value="imobiliariaperlati.com.br" <?php if($_SESSION['imob_gerenciar'] == 'imobiliariaperlati.com.br'){echo 'selected';} ?>>          Imobiliaria Perlati</option>
                <?php } */ ?>
              </select>
            </div>
          </li>
          <?php
          }?>

						<li class="light-blue">
							<a data-toggle="dropdown" href="#" class="dropdown-toggle">
                <?php
                $avatar = avatar($_SESSION["sessao_id_user"]);
                if(!$avatar){$avatar = 'admin.png';}?>
								<img class="nav-user-photo" src="assets/avatar/<?php echo $avatar; ?>" alt="Jason's Photo" />
								<span class="user-info">
									<small>Bem vindo,</small>
									<?php echo $_SESSION["sessao_nome"]; ?>
								</span>

								<i class="icon-caret-down"></i>
							</a>

							<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
								<li>
									<a href="index.php?pg=perfil&id=<?php echo $_SESSION["sessao_id_user"]; ?>">
										<i class="icon-user"></i>
										Profile
									</a>
								</li>

								<li class="divider"></li>

								<li>
									<a href="checklogin.php?acao=logout">
										<i class="icon-off"></i>
										Logout
									</a>
								</li>
							</ul>
						</li>
					</ul><!-- /.ace-nav -->
				</div><!-- /.navbar-header -->
			</div><!-- /.container -->
		</div>