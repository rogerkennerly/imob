<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>

   <section class="imob_banner">
      <div class="imob_banner_itens owl-carousel owl_carrousel_banner owl-theme">
         <?php  
            $q = mysql_query("SELECT * FROM banner ORDER BY posicao");

            $path = "clientes/".DIRETORIO."/assets/img/banner";

            while($banner = mysql_fetch_assoc($q)){?>
               <div class="imob_banner_itens_img">
                  <img src="<?php echo $path.'/'.$banner['nome']; ?>">
               </div><?php
            }
         ?>
      </div>
   </section>

<style>
   .imob_banner_itens .owl-dots .owl-dot.active span, .imob_banner_itens .owl-dots .owl-dot:hover span{ background-color: <?php echo $cor_layout ?> !important; }
</style>
