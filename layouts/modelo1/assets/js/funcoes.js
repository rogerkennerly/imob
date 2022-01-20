$(document).ready(function(){
  /* Tooltipster */
  $('.tooltip').tooltipster();

  /* Jquery Mask Inputs */
  $('#valor_min').mask('000.000.000.000.000,00', {reverse: true});
  $('#valor_max').mask('000.000.000.000.000,00', {reverse: true});
  $('#cep').mask('00000-000');

  /* Altera o tipo da masca de acordo com o tipo de número (telefone ou celular com nove digitos) */
  var mudarMascara = function (val) { 
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00000';
  },
  spOptions = {
    onKeyPress: function(val, e, field, options) {
      field.mask(mudarMascara.apply({}, arguments), options);
    }
  };
  $('#telefone').mask(mudarMascara, spOptions);
  $('#telefone_ligamos').mask(mudarMascara, spOptions);
  $('#telefone_fale_conosco').mask(mudarMascara, spOptions);

  /* Carousel Banner */
  $('.owl_carrousel_banner').owlCarousel({
      items: 1,
      autoplay: true,
      autoplayTimeout: 5000,
      autoplaySpeed: 1000,
      autoHeight:true,
      loop: true
  });

  /* Carousel Fotos Imóveis Busca */
  $('.owl_carrousel_imovel_fotos').owlCarousel({
      items: 1,
      nav: true,
      dots: false
  });

  /* Galeria Fancybox */
  $("[data-fancybox]").fancybox({
    toolbar: true,
    buttons : [
      'slideShow',
      'thumbs',
      'close',
    ]
  });
   
  /* Inserir icone nos botões next e prev do Carousel */
  $('.owl-prev').html('<i class="fa fa-chevron-left"></i>');
  $('.owl-next').html('<i class="fa fa-chevron-right"></i>');

  var breakpoint = $(document).width();
   if(breakpoint >= 1024){
    /* Exibir informações do imóvel Destaques Grande */
     $('.imob_destaques_grande_imoveis_item_img').hover(function() {
       $(this).find('.imob_destaques_grande_imoveis_item_img_infos_especs').stop(true, true).delay(50).slideDown('fast');
     }, function() {
       $(this).find('.imob_destaques_grande_imoveis_item_img_infos_especs').stop(true, true).delay(50).slideUp('fast');
     });

    /* Exibir informações do imóvel Destaques Pequeno */
     $('.imob_destaques_pequeno_imoveis_item_img').hover(function() {
         $(this).find('.imob_destaques_pequeno_imoveis_item_img_infos_especs').stop(true, true).delay(50).slideDown('fast');
       }, function() {
         $(this).find('.imob_destaques_pequeno_imoveis_item_img_infos_especs').stop(true, true).delay(50).slideUp('fast');
     });
   }

  /* Exibir contato Whatsapp */
  $('.imob_whatsapp_contato').on('mouseover', function(){
  	$(this).css('margin-right', '0').css('transition', '.5s');
  });

  $('.imob_whatsapp_contato').on('mouseleave', function(){
   	$(this).css('margin-right', '-16.1rem').css('transition', '.5s');
  });
  
  /* Ajax select finalidade */
  $("#finalidade").change(function(event){ 
    var finalidade = $(this).val();

    $.ajax({
      url: "../ajax/ajax_form_tipo_imovel.php?finalidade="+finalidade,
      cache: false,
      success: function(html){
        $(".imob_pesquisa_form_select_ajax_tipo").html(html);
      },
    });

    $.ajax({
        url: "../ajax/ajax_form_cidades.php?finalidade="+finalidade,
        cache: false,
        success: function(html){
          $(".imob_pesquisa_form_select_ajax_cidade").html(html);
        },
    });

    $.ajax({
      url: "../ajax/ajax_form_bairros.php?finalidade="+finalidade,
      cache: false,
      success: function(html){
        $(".imob_pesquisa_form_select_ajax_bairros").html(html);
      },
    });
  });

  /* Checar Radio Button */
  $('.imob_pesquisa_form_radio_input_quartos').click(function() {
    var checar = false;
    if(!$(this).children('input').is(':checked')){
      var checar = true;
    }
    else{
      $('.quarto_vazio').prop('checked', true);
    }

    $('.imob_pesquisa_form_radio_input_quartos').removeClass('ativo');
    $('.imob_pesquisa_form_radio_input_quartos').children('input').removeAttr('checked');
    
    if(checar == true){
      $(this).addClass('ativo');
      $(this).children('input').prop('checked', true);
    }
  });

  $('.imob_pesquisa_form_radio_input_suites').click(function() {
    var checar = false;
    if(!$(this).children('input').is(':checked')){
      var checar = true;
    }
    else{
      $('.suite_vazio').prop('checked', true);
    }

    $('.imob_pesquisa_form_radio_input_suites').removeClass('ativo');
    $('.imob_pesquisa_form_radio_input_suites').children('input').removeAttr('checked');
    
    if(checar == true){
      $(this).addClass('ativo');
      $(this).children('input').prop('checked', true);
    }
  });

  $('.imob_pesquisa_form_radio_input_banheiros').click(function() {
    var checar = false;
    if(!$(this).children('input').is(':checked')){
      var checar = true;
    }
    else{
      $('.banheiro_vazio').prop('checked', true);
    }

    $('.imob_pesquisa_form_radio_input_banheiros').removeClass('ativo');
    $('.imob_pesquisa_form_radio_input_banheiros').children('input').removeAttr('checked');
    
    if(checar == true){
      $(this).addClass('ativo');
      $(this).children('input').prop('checked', true);
    }
  });

  $('.imob_pesquisa_form_radio_input_vagas').click(function() {
    var checar = false;
    if(!$(this).children('input').is(':checked')){
      var checar = true;
    }
    else{
      $('.vaga_vazio').prop('checked', true);
    }

    $('.imob_pesquisa_form_radio_input_vagas').removeClass('ativo');
    $('.imob_pesquisa_form_radio_input_vagas').children('input').removeAttr('checked');
    
    if(checar == true){
      $(this).addClass('ativo');
      $(this).children('input').prop('checked', true);
    }
  });
});

function favoritar(id_imovel, id_finalidade, elemento){
  if($(elemento).children('i').hasClass('fav')){
    $(elemento).children('i').removeClass('fav');
  }
  else{
    $(elemento).children('i').addClass('fav');
  }

  $.ajax({
    url: "../ajax/ajax_favoritar.php?id_imovel="+id_imovel+"&id_finalidade="+id_finalidade,
    cache: false,
    success: function(html){
      
    },
  });
}

function abrirModal(elemento, ref){
  $('#modal_conteudo_ligamos').css('display', 'block');
  $('#modal_conteudo_fale_conosco').css('display', 'block');
  $('.modal_retorno_fale_conosco').css('display', 'none');
  $('.modal_retorno_ligamos').css('display', 'none');
  $(elemento).fadeToggle();
  $('#mensagem_ligamos').val('Estou interessado(a) no imóvel Ref. '+ref+' e gostaria de mais informações.');
  $('#mensagem_fale_conosco').val('Estou interessado(a) no imóvel Ref. '+ref+' e gostaria de mais informações.');
  $('#ref_ligamos').val(ref);
  $('#ref_fale_conosco').val(ref);
}

function fecharModal(elemento){
  $(elemento).fadeToggle();
}

function trocarLayout(id){
  if(id == 'layout_lista'){
    $('#imob_resultado_layout').removeClass('imob_resultado_bloco').addClass('imob_resultado_lista');
  }
  else{
    $('#imob_resultado_layout').removeClass('imob_resultado_lista').addClass('imob_resultado_bloco');
  }

  var tamanho = $('.imob_resultado_busca_lista_imovel_fotos').width();

  $('.owl-item').css('width', tamanho);
  $('.owl-stage').css('width', tamanho*3);
  $('.imob_resultado_busca_lista_imovel_fotos_img').css('width', tamanho);
}

function enviarFormModalLigamos(elemento){
  var nome        = $('#nome_ligamos').val();
  var telefone    = $('#telefone_ligamos').val();
  var mensagem    = $('#mensagem_ligamos').val();
  var ref         = $('#ref_ligamos').val();
  var email_dest  = $('#email_dest_ligamos').val();

  if(!nome || !telefone || !mensagem){
    alert('Preencha todos os campos');
  }
  else{
    $.ajax({
      url: "../ajax/ajax_form_modal.php?nome="+nome+"&telefone="+telefone+"&mensagem="+mensagem+"&ref="+ref+"&email_dest="+email_dest+"&form="+elemento,
      cache: false,
      success: function(html){
        $('#modal_conteudo_ligamos').toggle();
        $('.modal_retorno_ligamos').toggle();
      }
    });
  }
}

function enviarFormModalFaleConosco(elemento){
  var nome        = $('#nome_fale_conosco').val();
  var email       = $('#email_fale_conosco').val();
  var telefone    = $('#telefone_fale_conosco').val();
  var mensagem    = $('#mensagem_fale_conosco').val();
  var ref         = $('#ref_fale_conosco').val();
  var email_dest  = $('#email_dest_fale_conosco').val();

  if(!nome || !email || !telefone || !mensagem){
    alert('Preencha todos os campos');
  }
  else{
    $.ajax({
      url: "../ajax/ajax_form_modal.php?nome="+nome+"&email="+email+"&telefone="+telefone+"&mensagem="+mensagem+"&ref="+ref+"&email_dest="+email_dest+"&form="+elemento,
      cache: false,
      success: function(html){
        $('#modal_conteudo_fale_conosco').toggle();
        $('.modal_retorno_fale_conosco').toggle();
      }
    });
  }
}

function getBairros(cidade){
   $.ajax({
      url: "../ajax/ajax_get_bairros.php?cidade="+cidade,
      cache: false,
      success: function(html){
        $(".retorno_bairros").html(html);
      },
   });
}