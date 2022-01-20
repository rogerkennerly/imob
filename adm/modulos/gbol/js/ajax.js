var xmlhttp;
var destino;
var selecionado;

function buscar(tb,dest,rel,sel)
{ destino = dest;
  selecionado = sel;  
  var url = "";    
  url = "buscar.php?tb="+ tb + "&rel=" + rel;  
  loadXML(url);
}

function loadXML(url)
{ xmlhttp=null  
  if (window.XMLHttpRequest) { xmlhttp=new XMLHttpRequest() }
  else if (window.ActiveXObject) { xmlhttp=new ActiveXObject("Microsoft.XMLHTTP") }
  if (xmlhttp!=null)
  { xmlhttp.onreadystatechange=state_Change
    xmlhttp.open("GET",url,true)
    xmlhttp.send(null)
  } else { alert("Your browser does not support XMLHTTP.") }
}

function state_Change()
{ if (xmlhttp.readyState==4) // if xmlhttp shows "loaded"
  { if (xmlhttp.status==200) // if "OK"
    { monta();    
    } else { alert("Problem retrieving XML data:" + xmlhttp.statusText) }
  } else if (xmlhttp.readyState==1) { destino.options[0] = new Option("carregando ...","0"); }
}

function monta()
{ var response = xmlhttp.responseXML.documentElement;
  sel = 0;
  x=response.getElementsByTagName("registro");
  for (i=0;i<x.length;i++)
  { xx=x[i].getElementsByTagName("label");
    xy=x[i].getElementsByTagName("codigo");
    destino.options[i] = new Option(xx[0].firstChild.data,xy[0].firstChild.data);
    if (xy[0].firstChild.data == selecionado) { sel = i; }
  }
  destino.options[sel].selected=true;      
}

function zerar(temp,tabela)
{ for (m=temp.options.length;m>=0;m--) { temp.options[m]=null; }
  temp.options[0] = new Option(tabela,'0');
}