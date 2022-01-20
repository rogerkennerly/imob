<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php  
    $s_super_destaque = mysql_query("SELECT * FROM imovel WHERE disponivel = 'S' AND excluido = 'N' AND super_destaque = 'S'");

    if(mysql_num_rows($s_super_destaque) > 0){?>
        <section class="imob_destaques_grande">
            <div class="centralizador">
                <div class="imob_destaques_grande_titulo">
                    <h1>Nossos Lançamentos</h1>
                </div>
                <div class="imob_destaques_grande_imoveis owl-carousel owl_carrousel_destaques_grande owl-theme">
                <?php  
                    while($super_destaque = mysql_fetch_assoc($s_super_destaque)){?>
                        <div class="imob_destaques_grande_imoveis_item">
                            <?php  
                                $title  = retorna_nome('tipo', $super_destaque['id_tipo']);
                                $title .= " para ".retorna_nome('finalidade', $super_destaque['id_finalidade']);
                                $title .= " em ".retorna_nome('cidade', $super_destaque['id_cidade']);

                                $q_foto      = mysql_query("SELECT * FROM foto WHERE id_imovel = ".$super_destaque['id']." LIMIT 0,1");
                                $foto_imovel = mysql_fetch_assoc($q_foto);
                            ?>
                            <div class="imob_destaques_grande_imoveis_item_img">
                                <a href="index.php?pg=imovel&id=<?php echo $super_destaque['id']; ?>" title="<?php echo $title; ?>">
                                    <?php  
                                        if(mysql_num_rows($q_foto) > 0){?>
                                            <img src="fotos/<?php echo $super_destaque['id']; ?>/t1/<?php echo $foto_imovel['nome']; ?>"><?php
                                        }else{?>
                                            <img src="fotos/nenhuma_foto.jpg"><?php
                                        }
                                    ?>

                                    <div class="imob_destaques_grande_imoveis_item_img_infos"> 
                                        <div class="imob_destaques_grande_imoveis_item_img_infos_local">
                                            <h1><?php echo retorna_nome('bairro', $super_destaque['id_bairro']); ?>, <?php echo retorna_nome('cidade', $super_destaque['id_cidade']); ?></h1>
                                            <span><?php echo retorna_nome('tipo', $super_destaque['id_tipo']); ?> | <?php echo retorna_nome('finalidade', $super_destaque['id_finalidade']); ?></span>
                                        </div>
                                        <div class="imob_destaques_grande_imoveis_item_img_infos_preco">
                                            <?php  
                                                if($super_destaque['valor']){?>
                                                     <h1>R$ <?php echo tratar_moeda($super_destaque['valor'], 2); ?></h1><?php
                                                }
                                                else{?>
                                                    <h1>A consultar</h1><?php
                                                }
                                            ?>
                                        </div>
                                        <div class="imob_destaques_grande_imoveis_item_img_infos_ref">
                                          <span><?php echo "Ref. ".$super_destaque['ref']; ?></span>
                                        </div>
                                        <div class="hack"></div>
                                        <div class="imob_destaques_grande_imoveis_item_img_infos_especs">
                                            <ul class="imob_destaques_grande_imoveis_item_img_infos_especs_1">
                                                <?php
                                                  if($super_destaque['quarto']){?>
                                                    <li><span class="tooltip" title="<?php echo $super_destaque['quarto']; ?> quartos"><i class="fa fa-bed"></i> <?php echo $super_destaque['quarto']; ?></span></li><?php
                                                  }
                                                  if($super_destaque['banheiro']){?>
                                                    <li><span class="tooltip" title="<?php echo $super_destaque['banheiro']; ?> banheiros"><i class="fa fa-bath"></i> <?php echo $super_destaque['banheiro']; ?></span></li><?php
                                                  }
                                                  if($super_destaque['suite']){?>
                                                    <li><span class="tooltip" title="<?php echo $super_destaque['suite']; ?> suítes"><i class="fa fa-tint"></i> <?php echo $super_destaque['suite']; ?></span></li><?php
                                                  }
                                                  if($super_destaque['garagem']){?>
                                                    <li><span class="tooltip" title="<?php echo $super_destaque['garagem']; ?> vagas"><i class="fa fa-car"></i> <?php echo $super_destaque['garagem']; ?></span></li><?php
                                                  }
                                                  if($super_destaque['area_construida']){?>
                                                    <li><span class="tooltip" title="<?php echo $super_destaque['area_construida']; ?> m² área construída"><i class="fa fa-home"></i> <?php echo $super_destaque['area_construida']; ?> m²</span></li><?php
                                                  }
                                                  if($super_destaque['terreno']){?>
                                                    <li><span class="tooltip" title="<?php echo $super_destaque['terreno']; ?> m² terreno"><i class="fa fa-expand"></i> <?php echo $super_destaque['terreno']; ?> m² </span></li><?php
                                                  }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div><?php
                    }
                ?>
              </div>
            </div>
        </section>

        <?php
          $num_itens = 0; 
          if($config['lancamentos'] == 0){
            $num_itens = 2;
          }
          else{
            $num_itens = $config['lancamentos'];
          }
        ?>

        <script>
            $('.owl_carrousel_destaques_grande').owlCarousel({  
              items: <?php echo $num_itens; ?>,
              loop: true,
              margin: 30,
              nav: true,
              dots: false,
              responsiveClass:true,
              responsive:{
                  0:{
                      items:1,
                      nav:true
                  },
                  641:{
                      items:2,
                      nav:true
                  },
                  1024:{
                      items:<?php echo $num_itens; ?>,
                      nav:true,
                      loop:true
                  },
                  1320:{
                      items:<?php echo $num_itens; ?>,
                      nav:true,
                      loop:true
                  }
              }
            });
        </script><?php
    }
?>
