<div class="main-container-inner">
  <a class="menu-toggler" id="menu-toggler" href="#">
    <span class="menu-text"></span>
  </a>

  <div class="sidebar sidebar-fixed" id="sidebar">
    <script type="text/javascript">
      try{ace.settings.check('sidebar' , 'fixed')}catch(e){}
    </script>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
      <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
        <button class="btn btn-success" onclick="window.location.replace('index.php?pg=')">
          <i class="icon-signal"></i>
        </button>

        <button class="btn btn-info" onclick="window.location.replace('index.php?pg=dados-imobiliaria')">
          <i class="icon-pencil"></i>
        </button>

        <button class="btn btn-warning" onclick="window.location.replace('index.php?pg=usuarios')">
          <i class="icon-group"></i>
        </button>

        <button class="btn btn-danger" onclick="window.location.replace('index.php?pg=config-site')">
          <i class="icon-cogs"></i>
        </button>
      </div>
    </div><!-- #sidebar-shortcuts -->

    <ul class="nav nav-list">
      <li>
        <a href="index.php">
          <i class="fa fa-chevron-left" aria-hidden="true"></i> &nbsp;
          <span class="menu-text"> Voltar </span>
        </a>
      </li>
      
      <li class="">
        <a href="#" class="dropdown-toggle" onclick="$('.submenucolor').slideToggle()">
          <i class="fas fa-users"></i>
          <span class="menu-text"> Clientes </span>
          
            <b class="arrow icon-angle-down"></b>
        </a>
        <?php
				if (!isset($_REQUEST['op'])){ $op = ""; } else { $op = $_REQUEST['op']; }
        $active = '';
        if($pg == 'clientes' OR $pg == 'inc_clientes'){
          $active = "style='display:block;'";
        }?>
        <ul class="submenu" <?php echo $active; ?>>            
          <li <?php if($pg == 'inc_clientes'){echo "class='active'";} ?>>
            <a href="?modulo=gbol&pg=inc_clientes&op=N">
              <i class="icon-double-angle-right"></i>
              Incluir Cliente
            </a>
          </li>   
          <li <?php if($pg == 'clientes' AND ($op == 'L' OR !isset($op))){echo "class='active'";} ?>>
            <a href="?modulo=gbol&pg=clientes">
              <i class="icon-double-angle-right"></i>
              Listar Clientes
            </a>
          </li>
        </ul>
      </li>
      <li class="">
        <a href="#" class="dropdown-toggle" onclick="$('.submenucolor').slideToggle()">
          <i class="fas fa-barcode"></i>
          <span class="menu-text"> Boletos </span>
          
            <b class="arrow icon-angle-down"></b>
        </a>
        <?php
        $active = '';
        if($pg == 'boletos'){
          $active = "style='display:block;'";
        }?>
        <ul class="submenu" <?php echo $active; ?>>            
          <li <?php if($pg == 'boletos' AND $op == 'N'){echo "class='active'";} ?>>
            <a href="?modulo=gbol&pg=boletos&op=N&op2=N">
              <i class="icon-double-angle-right"></i>
              Incluir Boleto
            </a>
          </li>   
          <li <?php if($pg == 'boletos' AND ($op == 'L' OR $op == 'D' OR !$op)){echo "class='active'";} ?>>
            <a href="?modulo=gbol&pg=boletos">
              <i class="icon-double-angle-right"></i>
              Listar Boletos
            </a>
          </li>
        </ul>
      </li>
      <li <?php if($pg == 'impretorno'){echo "class='active'";} ?>>
        <a href="?modulo=gbol&pg=impretorno" class="dropdown-toggle">
          <i class="fas fa-retweet"></i>
          <span class="menu-text"> Remessa/Retorno </span>
        </a>
      </li>
      <li <?php if($pg == 'altdados_rev'){echo "class='active'";} ?>>
        <a href="?modulo=gbol&pg=altdados_rev" class="dropdown-toggle">
          <i class="fas fa-clipboard-list"></i>
          <span class="menu-text"> Meus dados </span>
        </a>
      </li>
    </ul><!-- /.nav-list -->

    <div class="sidebar-collapse" id="sidebar-collapse">
      <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
    </div>

    <script type="text/javascript">
      try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
  </div>
</div>
  
  

		<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<script src="assets/js/bootstrap.min.js"></script>
    
    
<script>
function alteraCor(elemento, tipo){
  var cor = elemento.value;
  if(tipo == "layout"){
    window.parent.iframeTeste.$(".cor_layout").css("background-color", cor);
    window.parent.iframeTeste.$(".cor_borda").attr('style', 'border-color:'+cor+' !important');
    window.parent.iframeTeste.$(".ativo").css("background-color", cor);
    window.parent.iframeTeste.$(".cor_outline").css("outline-color", cor);
    window.parent.iframeTeste.$(".cor_hover").hover(
      function(){//mouse in
        var hoverOriginal = $(this).css("background-color");
        $(this).attr("data-cor", hoverOriginal);
				$(this).css("background-color", cor);
			},
      function(hoverOriginal){//mouse out
        var hoverOriginal = $(this).attr("data-cor");
				$(this).css("background-color", hoverOriginal);
			}
    );
    window.parent.iframeTeste.$(".cor_borda_hover").hover(
      function(){//mouse in
        var hoverOriginal = $(this).css("border-color");
        $(this).attr("data-cor-borda", hoverOriginal);
				$(this).css("border-color", cor);
			},
      function(hoverOriginal){//mouse out
        var hoverOriginal = $(this).attr("data-cor-borda");
				$(this).css("border-color", hoverOriginal);
			}
    );
  }
  if(tipo == "botao"){
    window.parent.iframeTeste.$(".cor_botao").css("background-color", cor);
  }
}
</script>