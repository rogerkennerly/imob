<?php if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) { exit(); } ?>
<?php
  if($_GET['layout']){
		
		$layout_ativo = $_GET['layout'];
		
		$s = "UPDATE config SET layout = '$layout_ativo'";
    
    // echo $s;
    mysql_query($s);
    
    $descricao_log = "Layout alterado para $layout_ativo";
    gravalog($_SESSION["sessao_id_user"], 9, 2, $descricao_log, $s);
  }
  
  $dados = listar("config");
  $dados = mysql_fetch_assoc($dados);
?>

<div class="page-content">
  <div class="page-header">
    <h1>
      Layouts
    </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <?php echo $msg; ?>
    
    <div class="col-xs-12">
      <form method="POST" action="" id="form_cadastro">
				<div style="display:flex;justify-content:space-between;">
				
					<div style="width:calc(50% - 1rem);">
						<?php
						$borda_ativa = "";
						if($dados['layout'] == modelo1){$borda_ativa = "style='border:1px solid red;'";}?>
						<div class="widget-box" <?php echo $borda_ativa; ?>>
							<div class="widget-header">
								<h4>
									Modelo 1
									<?php
									if($dados['layout'] == modelo1){echo " - <b>[ATIVO]</b>";}?>
								</h4>
							</div>

							<div class="widget-body">
								<!--iframe src="<?php echo $_SERVER['SERVER_NAME']."?layout_choice_awards=modelo1"; ?>"-->
								<img src="assets/img/modelo1.JPG" style="width:100%;">
							</div>
						</div>
						<a href="<?php echo $_SERVER['SERVER_NAME']."?layout_choice_awards=modelo1";?>" target="_blank">
							<div class="btn btn-danger" style="background-color:green;">Testar Modelo 1</div>
						</a>
						<a href="?pg=layouts&layout=modelo1">
							<div class="btn btn-primary" style="background-color:green;">Ativar Modelo 1</div>
						</a>
					</div>
					
					<div style="width:calc(50% - 1rem);">
						<?php
						$borda_ativa = "";
						if($dados['layout'] == modelo2){$borda_ativa = "style='border:1px solid red;'";}?>
						<div class="widget-box" <?php echo $borda_ativa; ?>>
							<div class="widget-header">
								<h4>
									Modelo 2
									<?php
									if($dados['layout'] == modelo2){echo " - <b>[ATIVO]</b>";}?>
								</h4>
							</div>

							<div class="widget-body">
								<!--iframe src="<?php echo $_SERVER['SERVER_NAME']."?layout_choice_awards=modelo1"; ?>"-->
								<img src="assets/img/modelo2.JPG" style="width:100%;">
							</div>
						</div>
						<a href="<?php echo $_SERVER['SERVER_NAME']."?layout_choice_awards=modelo2";?>" target="_blank">
							<div class="btn btn-danger" style="background-color:green;">Testar Modelo 2</div>
						</a>
						<a href="?pg=layouts&layout=modelo2">
							<div class="btn btn-primary" style="background-color:green;">Ativar Modelo 2</div>
						</a>
					</div>
					
				</div>
      </form>
      </div>
    </div>
  </div>
</div>
