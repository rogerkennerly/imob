<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<div class="imob_sub_topo cor_layout" id="imob_sub_topo">
	<div class="centralizador">
		<div class="imob_sub_topo_informacoes">
			<ul>
			<?php  
				foreach($dados_telefone as $telefone){?>
					<li>
						<a href="tel:<?php echo $telefone; ?>">
							<i class="fa fa-phone"></i>
							<?php echo $telefone; ?>
						</a>
					</li><?php
				}
				foreach($dados_celular as $celular){
					$celular_novo = str_replace(array('(', ')', '-', ' '), '', $celular);
					$celular_novo = '55'.$celular_novo;?>
					<li>
						<a href="http://api.whatsapp.com/send?phone=<?php echo $celular_novo; ?>" target="_blank" title="Entre em contato pelo Whatsapp">
							<i class="fa fa-whatsapp"></i>
							<?php echo $celular; ?>
						</a>
					</li><?php
				}
				foreach($dados_email as $email){?>
					<li>
						<a href="mailto:<?php echo $email; ?>">
							<i class="fa fa-envelope"></i>
							<?php echo $email; ?>
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