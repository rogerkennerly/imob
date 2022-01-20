//******************************************************************************
// @name:        util.correios.calculo.js
// @purpose:     interface para efetuar os cálculos de frete nos correios.
//               Para que ele funcione você precisa criar uma regra em seu
//               servidor para reescrever as urls vindas de determinado
//               endereço. No meu caso, que uso apache, minha regra ficou assim:
//               - Utilizando mod_rewrite:
//                  RewriteEngine On
//                  RewriteCond %{REQUEST_URI} ^(/correios/*)
//                  RewriteRule ^/correios/(.*) http://www.correios.com.br/$1  [NE,L,P]
//               - Ou utilizando mod_proxy:
//                  ProxyRequests On
//                  ProxyVia On
//                  ProxyPass /correios/ http://www.correios.com.br/
//
// @example:     Para utilizar este módulo, faça da seguinte maneira:
//                 function callback(dados) {
//                     alert('O valor total é R$' + dados['preco_postal']);                    
//                 }
//                 Correios.calcular(callback, null, '33030-645', '30535-630', peso=5);
//
// @author:      Ruhan Bidart - ruhanbidart __at__ gmail __dot__ com
// @created:     08/09/2008
// @version:     0.1
//******************************************************************************
var Correios = {
    // Propriedades:
    // nao se esqueca de reescreve-la no seu server, senao ocasiona
    // um erro de permissao    
    url : 'http://localhost/correios/encomendas/precos/calculo.cfm',    
    _retorno: null,
    callback: function() { alert('Voce nao implementou uma funcao de callback');},
    
    // Funções:
    get_dados : function(dados) {    
        var handler = new XMLHandler();
        var xmlreq = new XMLClient(Correios.url);    
        // parametros
        for(var key in dados) {
            // nao insere aqueles que sao null
            if(dados[key] != null) xmlreq.addParam(key, dados[key]);        
        }
      handler.onError = function (e) {
          throw('Ocorreu um erro ao tentar chamar a url ' + Correios.url + ' com os parametros que voce informou. Mensagem original: '+ e)
      }
      handler.onProgress = function () {}
      handler.onInit = function () {}
      handler.onLoad = function (xml) {            
          var parser = new XMLParser();
          var xmlobj = parser.parseString(xml);
          var rootnd = xmlobj.documentElement;
          // verificando se ocorreu algum erro nos correios          
            var erro = rootnd.getElementsByTagName('erro')[0];          
            if(erro && erro.getElementsByTagName('codigo')[0].firstChild.nodeValue != '0') {        
                throw('Ocorreu um erro nos correios. ' + erro.getElementsByTagName('descricao')[0].firstChild.nodeValue);
            }                      
            // caso nao tenha ocorrido nenhum erro, monta o dicionario de retorno
            Correios.callback(Correios.xml_to_dict(rootnd.getElementsByTagName('dados_postais')[0]));
      }
      xmlreq.query(handler);
    },    
    
    xml_to_dict: function(elementos) {
        var dic = {};
        for(var i=0; i<elementos.childNodes.length; i++) {
            var el = elementos.childNodes[i];
            if(el.nodeType == 1) dic[el.tagName] = el.firstChild.nodeValue;
        }
        return dic;                
    },
    
    calcular : function(callback, servico, cep_origem, cep_destino, peso,
                        mao_propria, valor_declarado, aviso_recebimento) {        
      // Parâmetros:
      //  callback: funcao que sera chamada depois de terminar de executar
      //            o calculo.
      //    servico: Código do tipo de entrega que será calculada
      //                O valores possíveis são:
      //                - 40010 (SEDEX)        
      //                - 40010 (SEDEX)
      //                - 40290 (SEDEX Hoje)
      //                - 40215 (SEDEX 10)
      //                - 40045 (SEDEX a Cobrar)
      //                - 81019 (e-SEDEX)
      //                - 44105 (MALOTE)      
      //                Valor padrão é: 40010       
      //    cep_origem: Cep de Origem no formato XXXXX-XXX
      //    cep_destino: Cep de Destino no formato XXXXX-XXX
      //    peso: Peso da remessa limite de 30, menor 0.3
      //    mao_propria: Serviço de Mão Própria(S/N)
      //             Valor padrão é: N
      //    valor_declarado: Serviço de seguro com valor declarado
      //    aviso_recebimento: Serviço de Aviso de Recebimento(S/N)
      //             Valor padrão é: N
        //       
        // Retorno:
       // Dicionario com os dados retornados pelo correio. Eles
       // estarão na forma (em uma pesquisa feita de um frete de BH para RJ - Interior):
      //   {'servico': 40010,
      //    'servico_nome': SEDEX,
      //    'uf_origem': 'MG',
      //    'local_origem': 'Capital',
      //    'cep_origem': '33030645',
      //    'uf_destino': 'RJ',
      //    'local_destino': 'Interior',
      //    'cep_destino': '25770970',
      //    'peso': 10,
      //    'mao_propria': 0,
      //    'aviso_recebimento': 0,
      //    'valor_declarado': 0,
      //    'tarifa_valor_declarado': 0,
      //    'preco_postal': 73.7 }
      // ** E serão retornados como parametro para a funcao de callback.
      Correios.callback = callback;      
        if(!servico) servico = 40010;
        if(!peso || peso < 0.3) peso = null;
        if(peso > 30) throw('A mercadoria não pode pesar mais do que 30 Kg');
        if(!mao_propria) mao_propria = null;
        if(!valor_declarado) valor_declarado = null;
        if(!aviso_recebimento) aviso_recebimento = null;
        var dados = {'servico': servico,
                     'cepOrigem': cep_origem,
                     'cepDestino': cep_destino,
                     'peso': peso,
                     'maoPropria': mao_propria,
                     'valorDeclarado': valor_declarado,
                     'avisoRecebimento': aviso_recebimento,
                     'resposta': 'Xml'}        
        return Correios.get_dados(dados);
    }
}

/********************************************************************************
* Biblioteca para trabalhar com Ajax.
* Obs.: Se você precisa de um script de tamanho menor, implemente novamente o  
* post feito em Ajax para formatar um código lightweight.
* ** O código abaixo não foi feito por mim.
********************************************************************************/
var aXmlIds = ["MSXML2.XMLHTTP.5.0", "MSXML2.XMLHTTP.4.0", "MSXML2.XMLHTTP.3.0", "MSXML2.XMLHTTP", "MICROSOFT.XMLHTTP.1.0", "MICROSOFT.XMLHTTP.1", "MICROSOFT.XMLHTTP"];
function XMLClient(sUrl, bdoAsync)
{
    this.sUrl = sUrl;
    this.oHandler = null;
    this.oXMLRequest = null;
    this.sParams = '';
    if (bdoAsync == undefined) bdoAsync = true;
    this.bdoAsync = bdoAsync;
    this.sClosureNode = "";
}
XMLClient.prototype.query = function(oHandler)
{
    this.oHandler = oHandler;
    if (window.XMLHttpRequest)
    {
        if (!this.oXMLRequest)
            this.oXMLRequest = new XMLHttpRequest();
    }
    else if (window.ActiveXObject)
    {
        for (var i = 0; i < aXmlIds.length; i++)
        {
            try
            {
                this.oXMLRequest = new ActiveXObject(aXmlIds[i]);
                break;
            } catch(e) { }
        }
    }
    else
    {
        if (!this.oIframe)
        {
            var oIframe = document.createElement("IFRAME");
            oIframe.setAttribute("id", "xmlhttpFrame");
            oIframe.setAttribute("name", "xmlhttpFrame");
            oIframe.style.visibility = "hidden";
            oIframe.style.position = "absolute"
            oIframe.style.top = "0px";
            oIframe.style.left = "0px";
            document.body.appendChild(oIframe);
            this.oIframe = document.getElementById("xmlhttpFrame");
        }

        this.oIframe.setAttribute("src", this.sUrl + "?" + this.sParams);
        window.clearInterval(this.iTimeout);
        this.bJustCalled = true;
        var oSelf = this;
        this.iTimeout = window.setInterval(function() {oSelf.processReqChange(oSelf);}, 500);
    }

    if (this.oXMLRequest)
    {
        var oSelf = this;
        if(this.bdoAsync){ this.oXMLRequest.onreadystatechange = function () {oSelf.processReqChange()}; }
        this.oXMLRequest.open("POST", this.sUrl, this.bdoAsync);
        this.oXMLRequest.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        this.oXMLRequest.send(this.sParams);
        if (!this.bdoAsync)
            return this.oXMLRequest.responseText;
    }
}
XMLClient.prototype.setAsync = function (bdoAsync)
{
    this.bdoAsync = bdoAsync;
}
XMLClient.prototype.setClosureNode = function(sNodeName)
{
    this.sClosureNode = sNodeName;
}
XMLClient.prototype.processIFrame = function()
{
    var oLoadedData = null;
    if (document.frames["xmlhttpFrame"] != null)
    {
        var sDoc = document.frames["xmlhttpFrame"].document.body.innerHTML;
        if ((sDoc.indexOf("/" + this.sClosureNode) != -1) || (sDoc.indexOf(this.sClosureNode + "/") != -1))
        {
            oLoadedData = document.frames["xmlhttpFrame"].document;
            this.iReadyState = 4;
            window.clearInterval(this.iTimeout);
        }
        return oLoadedData;
    }

}
XMLClient.prototype.processReqChange = function ()
{
    if (this.oIframe != null)
    {
        if (this.bJustCalled)
        {
            this.bJustCalled = false;
            this.iReadyState = 1;
        }
        else
        {
            oLoadedData = this.processIFrame();
            if (oLoadedData == null)
            {
                return;
            }
        }
    }

    if (this.oXMLRequest != null)
    {
        this.iReadyState = this.oXMLRequest.readyState;
    }

    switch (this.iReadyState)
    {
            case 1:
                this.oHandler.onInit();
                break;

            case 2:
                if (window.XMLHttpRequest)
                {
                    if (this.oXMLRequest.status != 200)
                    {
                        this.oHandler.onError(this.oXMLRequest.status,
                                              this.oXMLRequest.statusText);
                        this.oXMLRequest.abort();
                    }
                }
                else if (this.oIframe != null)
                {
                    this.oHandler.onError(-1, oLoadedData);
                }
                break;

            case 3:
                var contentLength = 0;
                if (window.XMLHttpRequest)
                {
                                                            try
                    {
                        contentLength = this.oXMLRequest.getResponseHeader("Content-Length");
                    }
                    catch(ex)
                    {
                    }
                    if (this.oIframe != null)
                    {
                        this.oHandler.onProgress(oLoadedData.length);
                    }
                    this.oHandler.onProgress(this.oXMLRequest.responseText.length);
                }
                break;

            case 4:
                if (this.oIframe != null)
                {
                    this.oHandler.onLoad(oLoadedData);
                }
                else
                {
                    this.oHandler.onLoad(this.oXMLRequest.responseText);
                }
                break;
    }
}


XMLClient.prototype.addParam = function (paramName, paramValue)
{
    if (this.sParams.length > 0)
    {
        this.sParams = this.sParams + "&";
    }
    this.sParams= this.sParams + paramName + "=" + escape(paramValue);
}


XMLClient.prototype.clearParameters = function ()
{
    this.sParams = "";
}


XMLClient.prototype.getReadyState = function ()
{
        return this.iReadyState;
}


XMLClient.prototype.abort = function ()
{
    try
    {
        if (this.oXMLRequest)
        {
            this.oXMLRequest.abort();
        }
        else
        {
            this.oIframe.setAttribute("src", "");
        }
    }
    catch(e)
    {
    }
}


function XMLHandler ()
{
}

XMLHandler.onInit = function ()
{
}


XMLHandler.onError = function (status, statusText)
{
}


XMLHandler.onProgress = function (dataLength)
{
}


XMLHandler.onLoad = function (responseText)
{
}


function XMLParser ()
{
        try
    {
        this.parser = new DOMParser();
    }
    catch (e)
    {
        this.parser = new ActiveXObject('Microsoft.XMLDOM');
    }
}


XMLParser.prototype.parseString = function (xmlText)
{
    try
    {
        XMLDocument = this.parser.parseFromString(xmlText, "text/xml");
    }
    catch (e)
    {
        this.parser.async = 'false';
        this.parser.loadXML(xmlText);
        XMLDocument = this.parser;
    }

    return XMLDocument;
} 