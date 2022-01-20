function carrinho(codportal,op,codigo,id) {
	var url = "carrinho.php?codigo=" + codigo + "&op=" + op + "&sessao=" + id + "&codportal=" + codportal;
	loadXMLDoc(url);
  if (op == 'I') { alert("Produto Adicionado ao Carrinho de Compras \n\n Para acessar sua lista de produtos clique no Carrinho de Compras \n"); }
	if (op == 'D') { alert("Produto Removido do Carrinho de Compras \n\n Para acessar sua lista de produtos clique no Carrinho de Compras \n"); }
	if (op == 'A') { alert("Quantidade acrescida em uma unidade \n"); }
	if (op == 'R') { alert("Quantidade decrescida em uma unidade \n\n Se o produto desapareceu da lista é porque ele ficou com quantidade 0 \n"); }
	window.location = "/lojasvirtuais/index.php?pg=carrinho";
}

function checar2(codigo)
{ var tmp = produtos.split(":"); 
  var total = tmp.length;
  for (i = 0; i < total; i++)
  { if (codigo == tmp[i]) { window.document.btnimage.src="sis_img/btn_favorito_menos.gif"; }
  }
}

var xml01;

function loadXMLDoc(url)
{ xml01=null;
  if (window.XMLHttpRequest) { xml01 = new XMLHttpRequest(); }
  else if (window.ActiveXObject) { xml01 = new ActiveXObject("Microsoft.XMLHTTP"); }
  if (xml01!=null)
  { xml01.open("GET",url,true);
    xml01.send(null);
  } else { alert("Your browser does not support XMLHTTP."); }
}