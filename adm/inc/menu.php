<?php
  $pg_atual = $_GET["pg"];
  
  $q_permissao = mysql_query("SELECT * FROM permissao WHERE id_usuario = '".$_SESSION["sessao_id_user"]."'");
  $permissao_modulo = array();
  $permissao_modulo_item = array();
  while($r_permissao = mysql_fetch_assoc($q_permissao)){
    $permissao_modulo[] = $r_permissao["id_modulo"];
    $permissao_modulo_item[] = $r_permissao["id_modulo_item"];
  }
?>

<div class="main-container-inner">
  <a class="menu-toggler menu_mobile" id="menu-toggler" href="#">
    <span class="menu-text"></span>
  </a>

  <div class="sidebar sidebar-fixed" id="sidebar">
    <script type="text/javascript">
      // try{ace.settings.check('sidebar' , 'fixed')}catch(e){}//comentada pois aparentemente n�o tem uso
    </script>

    <div class="sidebar-shortcuts" id="sidebar-shortcuts">
      <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
        <button class="btn btn-success" onclick="window.location.replace('index.php')">
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

      <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
        <span class="btn btn-success"></span>

        <span class="btn btn-info"></span>

        <span class="btn btn-warning"></span>

        <span class="btn btn-danger"></span>
      </div>
    </div><!-- #sidebar-shortcuts -->

    <div style="overflow:hidden;">
      <ul class="nav nav-list">
        <?php
        if($_SESSION['WEBMASTER'] == 'webmaster'){?>
          <li>
            <a href="#" class="dropdown-toggle" style="background-color:#000;color:yellow;">
              <div class="container_icon">
                <i class="fas fa-cogs"></i>
              </div>
              <style>
                .container_icon{float:left;width:2rem;text-align:center;margin-right:1rem;}
                .container_icon svg{font-size:1.8rem;}
              </style>
              
              <span class="menu-text"> Config Master </span>

              <b class="arrow icon-angle-down" style="color:yellow;"></b>
            </a>
            <?php
            $active = '';
            if($pg_atual == 'config_master' OR $pg_atual == 'modulos'){$active = "style='display:block;'";}?>
            <ul class="submenu" <?php echo $active; ?>>
              <li <?php if($pg_atual == "config_master"){echo "class='active'";} ?>>
                <a href="?pg=config_master">
                  <span class="menu-text"> Config Master </span>
                </a>
              </li>
              <li <?php if($pg_atual == "modulos"){echo "class='active'";} ?>>
                <a href="?pg=modulos">
                  <span class="menu-text"> Modulos </span>
                </a>
              </li>
            </ul>
          </li>
        <?php
        }?>
        
        <li <?php if($pg_atual == "home" OR !$pg_atual){echo "class='active'";} ?>>
          <a href="index.php">
            <div class="container_icon">
              <i class="fas fa-tachometer-alt"></i>
            </div>
            <span class="menu-text"> Dashboard </span>
          </a>
        </li>
        
        <?php
        //MODULOS BASE DO SISTEMA
        $q_modulo = mysql_query("SELECT * FROM modulo WHERE ativo = 'S' ORDER BY ordem");
        
        while($r_modulo = mysql_fetch_assoc($q_modulo)){
          if(in_array($r_modulo["id"], $permissao_modulo) OR $r_modulo['plugin'] == 'S' OR $_SESSION['WEBMASTER'] == 'webmaster'){
              
            $q_modulo_item = mysql_query("SELECT * FROM modulo_item WHERE id_modulo = '".$r_modulo["id"]."' AND menu = 'S' ORDER BY ordem");
            
            if(mysql_num_rows($q_modulo_item)>0 OR $_SESSION['WEBMASTER'] == 'webmaster'){?>
              <li>
                <a href="#" class="dropdown-toggle">
                  <div class="container_icon">
                    <?php echo $r_modulo["icone"]; ?>
                  </div>
                  <style>
                    .container_icon{float:left;width:2rem;text-align:center;margin-right:1rem;}
                    .container_icon svg{font-size:1.8rem;}
                  </style>
                  
                  <span class="menu-text"> <?php echo $r_modulo["nome"]; ?> </span>

                  <b class="arrow icon-angle-down"></b>
                </a>
                
                <?php 
                  $testepg = mysql_query("SELECT id FROM modulo_item WHERE pg = '$pg_atual' AND id_modulo = '".$r_modulo["id"]."'");
                  $active = "";
                  if(mysql_num_rows($testepg)>0){
                  $active = "style='display:block;'";
                } ?>
                <ul class="submenu" <?php echo $active; ?>>
                  <?php
                  while($r_modulo_item = mysql_fetch_assoc($q_modulo_item)){  
                    if(in_array($r_modulo_item["id"], $permissao_modulo_item) OR $_SESSION['WEBMASTER'] == 'webmaster'){?>
                    
                      <li <?php if($pg_atual == $r_modulo_item["pg"]){echo "class='active'";} ?>>
                        <a href="<?php echo $r_modulo_item["link"]; ?>">
                          <i class="icon-double-angle-right"></i>
                          <?php echo $r_modulo_item["nome"]; ?>
                        </a>
                      </li>
                  <?php
                    }
                  }?>
                </ul>
              </li>
            <?php
            }
          }
        }
        
        //Modulos externos
        $modulos = "SELECT * FROM config";
        $modulos = mysql_query($modulos);
        $modulos = mysql_fetch_assoc($modulos);
        if($modulos['md_boletos'] == 'S' OR $_SESSION['WEBMASTER'] == 'webmaster'){?>
          <li>
            <a href="?modulo=gbol&pg=boletos">
              <div class="container_icon">
                <i class="fas fa-barcode"></i>
              </div>
              <span class="menu-text"> Boletos </span>
            </a>
          </li>
        <?php
        }
        ?>
      </ul><!-- /.nav-list -->
    </div>

    <div class="sidebar-collapse" id="sidebar-collapse">
      <i class="icon-double-angle-left" data-icon1="icon-double-angle-left" data-icon2="icon-double-angle-right"></i>
    </div>

    <script type="text/javascript">
      try{ace.settings.check('sidebar' , 'collapsed')}catch(e){}
    </script>
  </div>

<style>
.sidebar.fixed, .sidebar.sidebar-fixed{ height:calc(100vh - 45px) !important; overflow-y:auto; }
</style>