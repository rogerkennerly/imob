function salvar_ordem_fotos(id_imovel){
  var fotos = [];
  var contador = 0;
  $("#sortable li").each(function() {
     fotos[contador] = $(this).attr('data-id');
     contador = contador + 1;
  });
  
  $.ajax({
    url: "inc/ajax_grava_orgem_fotos.php?fotos="+fotos+"&id_imovel="+id_imovel,
    cache: false,
    success: function(html){
      $(".fotos_ordenacao").html(html);
    },
  });
}

function salvar_ordem_banner(){
  var fotos = [];
  var contador = 0;
  $("#sortable li").each(function() {
     fotos[contador] = $(this).attr('data-id');
     contador = contador + 1;
  });
  
  $.ajax({
    url: "inc/ajax_grava_orgem_banner.php?fotos="+fotos,
    cache: false,
    success: function(html){
      $(".fotos_ordenacao").html(html);
    },
  });
}

function atualiza_bairro(){
  var cidade = $(".form_cadastro_cidade").val();
  console.log(cidade);
  $.ajax({
    url: "inc/cascata_bairro.php?cidade="+cidade,
    cache: false,
    success: function(html){
      $(".retorno_cascata_bairro").html(html);
    },
  });
}

function filtrar_listagem_imoveis(pagina){
  var proprietario = $("#proprietario").val();
  var endereco = $("#endereco").val();
  var id_bairro = $("#bairro").val();
  var id_cidade = $("#cidade").val();
  var id_finalidade = $("#finalidade").val();
  var id_tipo = $("#tipo").val();
  var disponivel = $("#disponivel").val();
  var ref = $("#ref").val();
  var valor_min = $("#valor_min").val();
  var valor_max = $("#valor_max").val();
  var ref = $("#ref").val();

  if($("#paginacao").is(":checked")){
    var paginacao = 'S';
  }
  else{
    var paginacao = 'N';
  }
  
  
  $(".retorno_filtrar_listagem_imoveis").html('<center><img src="assets/img/loading2.gif" style="margin-top:5rem;margin-bottom:5rem;"></center>');
  
  setTimeout(function(){ 
    $.ajax({
      url: "inc/ajax_filtrar_listagem_imoveis.php?proprietario="+proprietario+"&endereco="+endereco+"&id_bairro="+id_bairro+"&id_cidade="+id_cidade+"&id_finalidade="+id_finalidade+"&id_tipo="+id_tipo+"&disponivel="+disponivel+"&ref="+ref+"&valor_min="+valor_min+"&valor_max="+valor_max+"&paginacao="+paginacao+"&pagina="+pagina,
      cache: false,
      success: function(html){
        $(".retorno_filtrar_listagem_imoveis").html(html);
      },
    });
  }, 1000);
}

function controle_valor_finalidade(ids_finalidade, id_imovel){
  $(".valor_disabled").hide();
  
  $(".campos_valores").html("");;
  
  $.ajax({
    url: "inc/ajax_campos_valor_finalidade.php?ids_finalidade="+ids_finalidade+"&id_imovel="+id_imovel,
    cache: false,
    success: function(html){
      $(".campos_valores").html(html);
    },
  });
}


function redirect_gerenciar_imob(url, pg, imob){
  console.log(url);
  console.log(imob);
  window.location.href = 'http://'+url+'/adm?pg='+pg+'&imob_gerenciar='+imob;
}