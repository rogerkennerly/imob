<div class="modal_janela" id="modal_nos_ligamos">
	<div class="modal" id="modal">
		<div class="modal_header">
			<div class="modal_header_titulo">
				<h1>Nós te ligamos</h1>
			</div>
			<div class="modal_header_fechar">
				<a href="javascript:void(0)" title="Fechar" class="fechar" onclick="fecharModal('#modal_nos_ligamos');"><i class="fa fa-close"></i></a>
			</div>
			<div class="hack"></div>
		</div>
		<div class="modal_conteudo" id="modal_conteudo_ligamos">
			<div>
				<div class="modal_form_input">
					<input type="hidden" name="form_nos_ligamos" id="form_nos_ligamos">
					<input type="text" name="nome" class="cor_outline" id="nome_ligamos" placeholder="Nome">
				</div>
				<div class="modal_form_input">
					<input type="tel" name="telefone" class="cor_outline" id="telefone_ligamos" placeholder="Telefone">
				</div>
				<div class="modal_form_textarea">
					<textarea name="mensagem" class="cor_outline" id="mensagem_ligamos"></textarea>
				</div>
				<div class="modal_form_input">
					<button class="cor_botao" onclick="enviarFormModalLigamos('modal_nos_ligamos');">Enviar</button>
				</div>
				<input type="hidden" id="ref_ligamos">
				<input type="hidden" id="email_dest_ligamos" value="<?php echo $dados_email[0]; ?>">
			</div>
		</div>
		<div class="modal_retorno_ligamos">
			Contato enviado! Aguarde nosso retorno.
		</div>
	</div>
</div>

<div class="modal_janela" id="modal_fale_conosco">
	<div class="modal" id="modal">
		<div class="modal_header">
			<div class="modal_header_titulo">
				<h1>Fale conosco</h1>
			</div>
			<div class="modal_header_fechar">
				<a href="javascript:void(0)" title="Fechar" class="fechar" onclick="fecharModal('#modal_fale_conosco');"><i class="fa fa-close"></i></a>
			</div>
			<div class="hack"></div>
		</div>
		<div class="modal_conteudo" id="modal_conteudo_fale_conosco">
			<div>
				<div class="modal_form_input">
					<input type="hidden" name="form_entre_em_contato" class="cor_outline" id="form_entre_em_contato">
					<input type="text" name="nome" class="cor_outline" id="nome_fale_conosco" placeholder="Nome">
				</div>
				<div class="modal_form_input">
					<input type="email" name="email" class="cor_outline" id="email_fale_conosco" placeholder="Email">
				</div>
				<div class="modal_form_input">
					<input type="tel" name="telefone" class="cor_outline" id="telefone_fale_conosco" placeholder="Telefone">
				</div>
				<div class="modal_form_textarea">
					<textarea name="mensagem" class="cor_outline" id="mensagem_fale_conosco"></textarea>
				</div>
				<div class="modal_form_input">
					<button class="cor_botao" onclick="enviarFormModalFaleConosco('modal_fale_conosco');">Enviar</button>
				</div>
				<input type="hidden" id="ref_fale_conosco">
				<input type="hidden" id="email_dest_fale_conosco" value="<?php echo $dados_email[0]; ?>">
			</div>
		</div>
		<div class="modal_retorno_fale_conosco">
			Contato enviado! Aguarde nosso retorno.
		</div>
	</div>
</div>