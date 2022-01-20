function abrir(link) { window.open (link, "", "width=600,height=450,resizable,scrollbars,screenX=0,screenY=0,top=0,left=0"); }

function trim(s)  { return s.replace(/^\s+|\s+$/g,""); }
function ltrim(s) { return s.replace(/^\s+/,""); }
function rtrim(s) { return s.replace(/\s+$/,""); }

function ir(form) { form.submit(); }

function inarray(s,a)
{ var achou = false;
  var i = 0;
	while (i < a.length)
  { if (a[i] == s) { achou = true; i = a.length; }
    i++;
  }
  return achou;  
}

function valida(campo,tecla){
  //48 a 57 = 0 a 9 e 96 a 105 = 0 a 9 no teclado numérico
  //8=backspace, 16=shift, 35=end, 36=home, 37,38,39,40=setas(esq,cima,dir,baixo), 127=delete
  var r = new Array(8,16,35,36,37,38,39,40,127);
  if (!inarray(tecla.keyCode,r))
  { var vr = new String(campo.value);
    var pesq = new RegExp("[^0-9]", "g");
	  campo.value = vr.replace(pesq,"");
	  return true;
  } else { return false; }
}

function mascara(campo, tecla, m) { // m = mascara 
  if (valida(campo,tecla))
  { var novo = "";
    var j    = 0;
    var r    = new Array(".","-","/",":","(",")"," ");
    var vr   = new String(campo.value);
    var pesq = new RegExp("[^0-9]", "g");
	  vr       = vr.replace(pesq,"");	  
	  tam      = vr.length;
	  for(i = 0; i < tam; i++)
    { if (inarray(m.charAt(i),r))
      { novo += m.charAt(i);
        tam++;
      } else
      { novo += vr.charAt(j);
        j++;
        if (j == vr.length) { tam = i; }
      }
    } 
	  campo.value = novo;
	}
}

function validaremail(s) {
	var ok = true;
	var minusculas = new Array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");
	var maiusculas = new Array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
	var numeros    = new Array("0","1","2","3","4","5","6","7","8","9");
	var caracteres = new Array(".","-","_","@");
	var i = 0;
	while (i < s.length)
  { if ((!inarray(s.charAt(i),minusculas)) && (!inarray(s.charAt(i),maiusculas)) && (!inarray(s.charAt(i),numeros)) && (!inarray(s.charAt(i),caracteres)))
    { ok = false; i = s.length; }
    i++;
  }
  if (ok)
	{ if (inarray(s[0],caracteres)) { ok = false; }
	  var parts = s.split("@");
	  if (parts.length == 2) 
	  { var part1 = parts[0];
	    var part2 = parts[1];
	    if (part1.length < 3) { ok = false; }
	    if (part2.length < 5) { ok = false; }
	    if (part2.indexOf(".") < 1) { ok = false; }
	  }	else { ok = false; }
	}
	return ok;
}

function autoTab(input,len, e) {
  var isNN = (navigator.appName.indexOf("Netscape")!=-1);
	var keyCode = (isNN) ? e.which : e.keyCode;
	var filter = (isNN) ? [0,8,9] : [0,8,9,16,17,18,37,38,39,40,46];
	if(input.value.length >= len && !containsElement(filter,keyCode)) {
		input.value = input.value.slice(0, len);
		input.form[(getIndex(input)+1) % input.form.length].focus();
	}

	function containsElement(arr, ele) {
		var found = false, index = 0;
		while(!found && index < arr.length)
		if(arr[index] == ele)
		found = true;
		else
		index++;
		return found;
	}

	function getIndex(input) {
		var index = -1, i = 0, found = false;
		while (i < input.form.length && index == -1)
		if (input.form[i] == input)index = i;
		else i++;
		return index;
	}
	return true;
}