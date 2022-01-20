<?php

  error_reporting(0);
  include "checklogin.php";
  include_once "funcoes.php";
  require("../config.php");
  include("atualizador.php");
  
  $s_integracao = "SELECT integracao, key_integracao FROM dados_imobiliaria";
  $q_integracao = mysql_query($s_integracao);
  $r_integracao = mysql_fetch_assoc($q_integracao);
?>
<!DOCTYPE html>
<html lang="pt-BR">
  <?php
  include "inc/cabecalho.php";?>
	<body class="navbar-fixed">
    
    <?php
      include "inc/topo.php";?>
    
    <div class="main-container" id="main-container" >
      <script type="text/javascript">
        try{ace.settings.check('main-container' , 'fixed')}catch(e){}
      </script>
      
      <?php
        if(isset($_GET['modulo'])){ $modulo = $_GET['modulo']; }else{ $modulo = ''; }
        if($modulo){
          include "modulos/gbol/base.php";
        }
        else{
          include "base.php";
        }
        ?>
    </div><!-- /.main-container-inner -->
    
		<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>
		<script src="assets/js/typeahead-bs2.min.js"></script>
		<script src="assets/js/jquery-ui-1.10.3.custom.min.js"></script>
		<script src="assets/js/jquery.slimscroll.min.js"></script>
    <script src="assets/js/chosen.jquery.min.js?data=06-02-2020"></script>
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>
    
		<script type="text/javascript">
			jQuery(function($) {
        $(".chosen-select").chosen(); 
        $('#chosen-multiple-style').on('click', function(e){
          var target = $(e.target).find('input[type=radio]');
          var which = parseInt(target.val());
          if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
           else $('#form-field-select-4').removeClass('tag-input-style');
        });
  
      var $tooltip = $("<div class='tooltip top in'><div class='tooltip-inner'></div></div>").hide().appendTo('body');
    
				$('#recent-box [data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('.tab-content')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			
			
				$('.dialogs,.comments').slimScroll({
					height: '300px'
			  });
				
				var agent = navigator.userAgent.toLowerCase();
				if("ontouchstart" in document && /applewebkit/.test(agent) && /android/.test(agent))
				  $('#tasks').on('touchstart', function(e){
					var li = $(e.target).closest('#tasks li');
					if(li.length == 0)return;
					var label = li.find('label.inline').get(0);
					if(label == e.target || $.contains(label, e.target)) e.stopImmediatePropagation() ;
				});
			
				$('#tasks').sortable({
            opacity:0.8,
            revert:true,
            forceHelperSize:true,
            placeholder: 'draggable-placeholder',
            forcePlaceholderSize:true,
            tolerance:'pointer',
            stop: function( event, ui ) {//just for Chrome!!!! so that dropdowns on items don't appear below other items after being moved
              $(ui.item).css('z-index', 'auto');
            }
				});
				$('#tasks').disableSelection();
				$('#tasks input:checkbox').removeAttr('checked').on('click', function(){
					if(this.checked) $(this).closest('li').addClass('selected');
					else $(this).closest('li').removeClass('selected');
				});
				
        // $('.input-mask-date').mask('99/99/9999');
			})
		</script>
    
    <?php //include "helpdesk.php"; ?>
	</body>
</html>
