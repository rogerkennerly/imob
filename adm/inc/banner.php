<?php if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) { exit(); } ?>
<?php
  $id_foto = evita_injection($_GET["id_foto"]);
  
  $teste_foto = retorna_campo("banner", "id", $id_foto);
  if($teste_foto){
    if($_GET["op"]=="excluir"){
      $s = "SELECT * FROM banner WHERE id = '$id_foto'";
      $q = mysql_query($s);
      $banner = mysql_fetch_assoc($q);
      $id_banner = $banner["id"];
      $nome_foto = $banner["nome"];
      
      unlink("../clientes/".DIRETORIO."/assets/img/banner/".$nome_foto);
      unlink("../clientes/".DIRETORIO."/assets/img/banner/".$nome_foto);
      unlink("../clientes/".DIRETORIO."/assets/img/banner/".$nome_foto);
      $s = "DELETE FROM banner WHERE id = '$id_foto'";
      mysql_query($s);
      $alerta_foto = sucesso("Banner $nome_foto excluida com sucesso!");
      
      $descricao_log = "Banner Excluido - id. $id_banner | nome. $nome_foto";
      gravalog($_SESSION["sessao_id_user"], 8, 3, $descricao_log, $s);
    }
  }
?>

<div id="dropzone">
  <form action="inc/ajax-banner.php?id_imovel=<?php echo $id_imovel; ?>" class="dropzone" id="form_enviar_fotos" enctype="multipart/form-data">
    <div class="fallback">
      <input name="file[]" type="file" multiple="" />
    </div>
  </form>
</div><!-- PAGE CONTENT ENDS -->


<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
  $( "#sortable" ).sortable();
  $( "#sortable" ).disableSelection();
} );
</script>

<?php
$s = "SELECT * FROM banner ORDER BY posicao";
$q = mysql_query($s);
?>

<br/><br/>

<?php echo $alerta_foto; ?>
<div class="fotos_ordenacao">
<h3 style="margin-left:3rem;">Ordenação das fotos</h3>
  <ul id="sortable">
    <?php
    while($r = mysql_fetch_assoc($q)){?>
      <li class="sortable-li ui-state-default" data-id="<?php echo $r["id"]; ?>">
        <div style="height:10.5rem;width:12rem;text-align:center;margin-bottom:0.5rem;">
          <img src="/clientes/<?php echo DIRETORIO; ?>/assets/img/banner/<?php echo $r["nome"]; ?>" style="max-height:10.5rem;max-width:100%;">
        </div>
        <div style="width:100%;float:left;text-align:center;">
          <a href="?pg=banner&op=excluir&id_foto=<?php echo $r["id"]; ?>" onclick="return confirm('Deseja excluir a foto?')">
            <i class="far fa-trash-alt"></i>
          </a>
        </div>
      </li>
    <?php
    }?>
  </ul>
</div>

<div style="float:left;width:100%;padding:3rem;">
  <button class="btn-lg imob-botao-sucesso" onclick="salvar_ordem_banner(<?php echo $id_imovel; ?>)">SALVAR ORDENAÇÃO</button>
</div>

<style>
#sortable{
  margin-top:5rem;
}

#sortable li {
    margin: 0 3px 3px 3px;
    padding: 0.4em;
    font-size: 1.4em;
    border: 1px solid #c5c5c5;
    background: #f6f6f6;
    font-weight: normal;
    color: #454545;
    -ms-touch-action: none;
    touch-action: none;
    list-style:none;
    float:left;
}

.ui-sortable-placeholder{
  width:11.6rem;
}
</style>


<script type="text/javascript">
  window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
</script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/jquery.nestable.min.js"></script>

<script type="text/javascript">
  jQuery(function($){
    try {
      $(".dropzone").dropzone({
        paramName: "file[]", // The name that will be used to transfer the file
        maxFilesize: 10.5, // MB
      
      addRemoveLinks : true,
      dictDefaultMessage :
      '<span class="bigger-150 bolder"><i class="icon-caret-right red"></i> Arraste as fotos</span> para enviar \
      <span class="smaller-80 grey">(ou clique)</span> <br /> \
      <i class="upload-icon icon-cloud-upload blue icon-3x"></i>'
    ,
      dictResponseError: 'Erro ao enviar os arquivos!',
      success: function(file, response){
        window.setTimeout('salvar_ordem_banner(<?php echo $id_imovel; ?>);$(".dz-preview").fadeOut();', 1000);
      },
      
      //change the previewTemplate to use Bootstrap progress bars
      previewTemplate: "<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-details\">\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n    <div class=\"dz-size\" data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class=\"progress progress-small progress-striped active\"><div class=\"progress-bar progress-bar-success\" data-dz-uploadprogress></div></div>\n  <div class=\"dz-success-mark\"><span></span></div>\n  <div class=\"dz-error-mark\"><span></span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>"
      });
    } catch(e) {
      alert('Dropzone.js does not support older browsers!');
    }
  });
</script>
<script src="assets/js/dropzone.min.js"></script> 

<style>
.dropzone.dz-started .dz-message{
  opacity:1 !important;
}
</style>