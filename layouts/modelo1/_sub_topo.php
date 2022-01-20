<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<div class="imob_sub_topo cor_layout" id="imob_sub_topo">
	<div class="centralizador">
		<div class="imob_sub_topo_informacoes">
			<ul>
			<?php  
				if($dados['telefone']){?>
					<li>
						<i class="fa fa-phone"></i>
						<?php echo $dados['telefone']; ?>
					</li><?php
				}
				if($dados['celular']){
					$celular = str_replace(array('(', ')', '-', ' '), '', $dados['celular']);
					$celular = '55'.$celular;?>
					<li>
						<a href="http://api.whatsapp.com/send?phone=<?php echo $celular; ?>" target="_blank" title="Entre em contato pelo Whatsapp">
							<i class="fa fa-whatsapp"></i>
							<?php echo $dados['celular']; ?>
						</a>
					</li><?php
				}
				if($dados['email']){?>
					<li>
						<a href="mailto:<?php echo $dados_email[0]; if($dados_email[1]){ echo ';'.$dados_email[1]; } ?>">
							<i class="fa fa-envelope"></i>
							<?php 
								echo $dados_email[0];
								if($dados_email[1]){ echo ' / '.$dados_email[1]; }
							?>
						</a>
					</li><?php
				}
				if($dados['creci']){?>
					<li>
						<i class="fa fa-home"></i>
						CRECI 
						<?php 
							echo $dados_creci[0];
							if($dados_creci[1]){ echo ' / '.$dados_creci[1]; }
						?>
					</li><?php
				}
			?>
			</ul>
		</div>
	</div>
</div>