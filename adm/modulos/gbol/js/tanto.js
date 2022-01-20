function muda_estilo(atual, status){ // Muda class dos campos (atual=campo, status=tipo da mudan�a (0 - Normal, 1 - aceso, 2 - erro, 3 - Invis�vel)
	//alert(atual);
	if(status==0){
		document.getElementById(atual).className = 'campo_normal';
	}
	if(status==1){
		document.getElementById(atual).className = 'campo_aceso';		
	}
}

function valida_telefone(campo, event, classerro, classnormal){
	var pesq1 = new RegExp("^[0-9 ()-]*$"); // Caracteres permitidos
	var pesq3 = new RegExp("[^0-9 ()-]", "g"); // Caracteres proibidos

	if (!document.getElementById(campo).value.match(pesq1)) { // Verifica se encontrou algo proibido
			 pos_alert_form(campo, '<b>Caracter n�o permitido.</b><BR>Utilize apenas n�meros neste campo. <br>Formato: (00) 0000-0000'); // chama fun��o para mostrar bal�o no campo
		 document.getElementById(campo).value = document.getElementById(campo).value.replace(pesq3,"");
		 muda_estilo(campo, classerro); // Muda campo para classe de erro
	} else { // Se tudo estiver OK
		var keyCode = event.keyCode ? event.keyCode : event.which ? event.which : event.charCode; // Pega ultima telca apertada
		if(keyCode!='16' && keyCode!='9'){ // se n�o for o Shift, remove o balao
			rem_alert_form();
		 	muda_estilo(campo, classnormal); // Muda campo para classe aceso
		}
		if(keyCode=='13'){
			document.getElementById(campo).blur();
		}
		formataCampo(campo, '(00) 0000-0000', event);		
	}
}
