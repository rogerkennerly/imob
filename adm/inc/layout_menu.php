<?php

  if($_POST){
    $cor_layout = $_POST["cor_layout"];
    $cor_botao = $_POST["cor_botao"];
    
    $s = "UPDATE config SET cor_layout = '$cor_layout', cor_botao = '$cor_botao'";
    mysql_query($s);
    
    // echo $s;
    
    $descricao_log = "Cores do site alteradas";
    gravalog($_SESSION["sessao_id_user"], 9, 2, $descricao_log, $s);
  }
  
?>
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
          <i class="icon-beaker"></i>
          <span class="menu-text"> Cor </span>
          
            <b class="arrow icon-angle-down"></b>
        </a>
        
        <?php 
          $active = "";
          $active = "style='display:block;'";
          
          $cores = mysql_query("SELECT * FROM config");
          $cores = mysql_fetch_assoc($cores);
          $cor_layout = $cores["cor_layout"];
          $cor_botao  = $cores["cor_botao"];
        ?>
        <ul class="submenucolor" style="background-color:#FFF;margin-left:0;">
          <li <?php if($pg_atual == $r_modulo_item["pg"]){echo "class='active'";} ?>>
            <div class="bootstrap-colorpicker" style="padding:2rem 0.5rem;border-top:1px solid #e5e5e5;">
              <form method="POST" action="">
                Cor Layout:<br/>
                <input id="colorpicker1" type="color" value="<?php echo $cor_layout;?>" class="input-small color_layout" onchange="alteraCor(this, 'layout');$('#corlayout_input').val(this.value)" style="height:25px;padding:0;width:80px;float:left;">
                <input type="text" name="cor_layout" size="8" style="height:25px;" value="<?php echo $cor_botao;?>" onkeyup="$('.color_layout').val(this.value);alteraCor(this, 'layout')" id="corlayout_input">
                <br/><br/>
                <div style="width:100%;border-top:1px dotted #ccc;"></div>
                <br/>
                Cor Botões:<br/>
                <input id="colorpicker1" type="color" value="<?php echo $cor_botao;?>" class="input-small color_botao" onchange="alteraCor(this, 'botao');$('#corbotao_input').val(this.value)" style="height:25px;padding:0;width:80px;float:left;">
                <input type="text" name="cor_botao" size="8" style="height:25px;" value="<?php echo $cor_botao;?>" onkeyup="$('.color_botao').val(this.value);alteraCor(this, 'botao')" id="corbotao_input">
                <br/><br/>
                <div style="width:100%;border-top:1px dotted #ccc;"></div>
                <br/>
                <input type="submit" value="Salvar">
              </form>
            </div>
          </li>
        </ul>
      </li>
    </ul><!-- /.nav-list -->

    <div class="sidebar-collapse" id="sidebar-collapse">
      <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
    </div>

    <script type="text/javascript">
      try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
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