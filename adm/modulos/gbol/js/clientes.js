function FormataCNPJ(Campo, teclapres){
	var tecla = teclapres.keyCode;
	var vr = new String(Campo.value);
	var pesq3 = new RegExp("[^0-9]", "g");
	vr = vr.replace(pesq3,"");
	//vr  = vr.replace(".", "");
	//vr  = vr.replace("/", "");
	//vr  = vr.replace("-", "");
	tam = vr.length + 1 ;	
	if (tecla != 9 && tecla != 8)
	{ if (tam > 2 && tam < 6   ) Campo.value = vr.substr(0,2) + '.' + vr.substr(2, tam);
		if (tam >= 6 && tam < 9  ) Campo.value = vr.substr(0,2) + '.' + vr.substr(2,3) + '.' + vr.substr(5,tam-5);
		if (tam >= 9 && tam < 13 ) Campo.value = vr.substr(0,2) + '.' + vr.substr(2,3) + '.' + vr.substr(5,3) + '/' + vr.substr(8,tam-8);
		if (tam >= 13 && tam < 15) Campo.value = vr.substr(0,2) + '.' + vr.substr(2,3) + '.' + vr.substr(5,3) + '/' + vr.substr(8,4)+ '-' + vr.substr(12,tam-12);
	}
}
function FormataCPF(Campo, teclapres){
	var tecla = teclapres.keyCode;
	var vr = new String(Campo.value);
	//vr  = vr.replace(".", "");
	//vr  = vr.replace("/", "");
	//vr  = vr.replace("-", "");
	var pesq3 = new RegExp("[^0-9]", "g");
	vr = vr.replace(pesq3,"");
	tam = vr.length + 1 ;	
	if (tecla != 9 && tecla != 8)
	{ if (tam > 3 && tam < 7  ) Campo.value = vr.substr(0,3) + '.' + vr.substr(3, tam);
		if (tam >= 7 && tam < 10) Campo.value = vr.substr(0,3) + '.' + vr.substr(3,3) + '.' + vr.substr(6,tam);
		if (tam > 9             ) Campo.value = vr.substr(0,3) + '.' + vr.substr(3,3) + '.' + vr.substr(6,3) + '-' + vr.substr(9,tam);
	}
}

function validarcep(s) {
	var ok = true;
	var numeros    = new Array("0","1","2","3","4","5","6","7","8","9");
	var caracteres = new Array("-");
	var i = 0;
	while (i < s.length)
  { if ((!inarray(s.charAt(i),numeros)) && (!inarray(s.charAt(i),caracteres)))
    { ok = false; i = s.length; }
    i++;
  }
  if (ok)
	{ var parts = s.split("-");
	  if (parts.length == 2) 
	  { var part1 = parts[0];
	    var part2 = parts[1];
	    if (part1.length != 5) { ok = false; }
	    if (part2.length != 3) { ok = false; }
	  }	else { ok = false; }
	}
	return ok;
}

/*
www.moinho.net
Verifica se um número de CPF ou CNPJ é válido
Função  : isCPFCNPJ
Retorno : true se o número for válido
e-mail  : celso.goya@moinho.net
Author  : Desconhecido
Customizado: Celso Goya

Instruções
Se você tiver qualquer dúvida ou sugestão sobre a funcionalidade desta função por favor envie-nos um e-mail
*/
function isEmpty(s){
	var	len = s.length;
	var pos;
	var novo = "";
	for (pos=0; pos<len; pos++)
	{ if (s.substring(pos,(pos+1)) != " ") { novo = novo + s.substring(pos,(pos+1)); }
	}
	if (novo.length > 0) { return false; } else { return true; }
}

function isCPFCNPJ(campo,pType){
   if( isEmpty( campo ) ){return false;}
   var campo_filtrado = "", valor_1 = " ", valor_2 = " ", ch = "";
   var valido = false;
   for (i = 0; i < campo.length; i++)
   {  ch = campo.substring(i, i + 1);
      if (ch >= "0" && ch <= "9"){
         campo_filtrado = campo_filtrado.toString() + ch.toString()
         valor_1 = valor_2;
         valor_2 = ch;
      }
      if ((valor_1 != " ") && (!valido)) valido = !(valor_1 == valor_2);
   }
   if (!valido) { campo_filtrado = "12345678912"; }
   if (campo_filtrado.length < 11){ for (i = 1; i <= (11 - campo_filtrado.length); i++){campo_filtrado = "0" + campo_filtrado;} }
	 if(pType <= 1){ if ( ( campo_filtrado.substring(9,11) == checkCPF( campo_filtrado.substring(0,9) ) ) && ( campo_filtrado.substring(11,12)=="") ){return true;} }
   if((pType == 2) || (pType == 0)){
		if (campo_filtrado.length >= 14){ if ( campo_filtrado.substring(12,14) == checkCNPJ( campo_filtrado.substring(0,12) ) ){ return true;} }
	 }	
	return false;
}

function checkCNPJ(vCNPJ){
   var mControle = "";
   var aTabCNPJ = new Array(5,4,3,2,9,8,7,6,5,4,3,2);
   for (i = 1 ; i <= 2 ; i++){
      mSoma = 0;
      for (j = 0 ; j < vCNPJ.length ; j++)
         mSoma = mSoma + (vCNPJ.substring(j,j+1) * aTabCNPJ[j]);
      if (i == 2 ) mSoma = mSoma + ( 2 * mDigito );
      mDigito = ( mSoma * 10 ) % 11;
      if (mDigito == 10 ) mDigito = 0;
      mControle1 = mControle ;
      mControle = mDigito;
      aTabCNPJ = new Array(6,5,4,3,2,9,8,7,6,5,4,3);
   }
   return( (mControle1 * 10) + mControle );
}

function checkCPF(vCPF){
   var mControle = ""
   var mContIni = 2, mContFim = 10, mDigito = 0;
   for (j = 1 ; j <= 2 ; j++){
      mSoma = 0;
      for (i = mContIni ; i <= mContFim ; i++)
         mSoma = mSoma + (vCPF.substring((i-j-1),(i-j)) * (mContFim + 1 + j - i));
      if (j == 2 ) mSoma = mSoma + ( 2 * mDigito );
      mDigito = ( mSoma * 10 ) % 11;
      if (mDigito == 10) mDigito = 0;
      mControle1 = mControle;
      mControle = mDigito;
      mContIni = 3;
      mContFim = 11;
   }
   return( (mControle1 * 10) + mControle );
}
