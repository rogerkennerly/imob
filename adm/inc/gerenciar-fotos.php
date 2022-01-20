<?php
  $id_imovel = $_GET["id_imovel"];
  $id_foto   = $_GET["id_foto"];
  
  $teste_foto = retorna_campo("foto", "id", $id_foto);
  if($teste_foto){
    if($_GET["op"]=="excluir"){
      $id_foto = $_GET["id_foto"];
      $nome_foto = retorna_campo("foto", "nome", $id_foto);
      
      for($z=0 ; $z<count($foto_diretorios) ; $z++){
        $caminho = "../clientes/".DIRETORIO."/fotos/$id_imovel/".$foto_diretorios[$z]."/";
        unlink($caminho.$nome_foto);
      }
      $sql_i = "DELETE FROM foto WHERE id = '$id_foto'";
      mysql_query($sql_i);
      $alerta_foto = alerta("Foto $nome_foto excluida com sucesso!");
      
      $descricao_log = "Foto Excluida - nome. $nome_foto";
      gravalog($_SESSION["sessao_id_user"], 101, 3, $descricao_log, $sql_i);
    }
  }
?>

<div id="dropzone">
  <form method="post" action="inc/ajax-fotos.php?id_imovel=<?php echo $id_imovel; ?>" class="dropzone" id="form_enviar_fotos" enctype="multipart/form-data">
    <div class="fallback">
      <input name="file[]" type="file" multiple="" />
    </div>
</div><!-- PAGE CONTENT ENDS -->
<br/>
<?php
  $check_marca = "checked";
  if(isset($_GET["check_marca"])){
    $check_marca = $_GET["check_marca"];
  }
  if($check_marca == "checked"){
    $mudado = "";
  }else{
    $mudado = "checked";
  }
?>
<input id="marcadagua" <?php echo $check_marca; ?> class="ace ace-switch ace-switch-6" type="checkbox" value="S" onchange="$(location).attr('href','http://<?php echo $_SERVER['SERVER_NAME']; ?>/adm/index.php?pg=gerenciar-fotos&id_imovel=<?php echo $id_imovel; ?>&check_marca=<?php echo $mudado; ?>');">
<span class="lbl" style="margin-left:2rem;"></span>
<span style="font-size:1.6rem;">Inserir Marca D'água</span>
</form>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
  $( "#sortable" ).sortable();
  $( "#sortable" ).disableSelection();
} );
</script>

<?php
$s = "SELECT * FROM foto WHERE id_imovel = $id_imovel ORDER BY posicao";
$q = mysql_query($s);
?>

<?php echo $alerta_foto; ?>
<div class="fotos_ordenacao">
  <ul id="sortable">
  <div style="font-size:1.5rem;margin-bottom:1rem;">Fotos:</div>
    <?php
    while($r = mysql_fetch_assoc($q)){?>
      <li class="sortable-li ui-state-default" data-id="<?php echo $r["id"]; ?>">
        <div style="height:10.5rem;width:100px;text-align:center;">
          <img src="/clientes/<?php echo DIRETORIO; ?>/fotos/<?php echo $id_imovel ?>/t2/<?php echo $r["nome"]; ?>" style="max-width:100%;max-height:105px;">
        </div>
        <div style="width:100%;float:left;text-align:center;">
          <a href="?pg=gerenciar-fotos&id_imovel=<?php echo $id_imovel; ?>&op=excluir&id_foto=<?php echo $r["id"]; ?>" onclick="return confirm('Deseja excluir a foto?')">
            <i class="fas fa-trash-alt"></i>
          </a>
        </div>
      </li>
    <?php
    }?>
  </ul>
</div>
<button class="btn-lg imob-botao-sucesso imob-botao-fixo-bottom-right" onclick="salvar_ordem_fotos(<?php echo $id_imovel; ?>)">SALVAR FOTOS</button>

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
        acceptedFiles: 'image/*',
        params  : {
            marcadagua : $("#marcadagua").is(':checked')
        },
        
      addRemoveLinks : false,
      dictDefaultMessage :
      '<span class="bigger-150 bolder"><i class="icon-caret-right red"></i> Arraste as fotos</span> para enviar \
      <span class="smaller-80 grey">(ou clique)</span> <br /> \
      <i class="upload-icon icon-cloud-upload blue icon-3x"></i>'
    ,
      dictResponseError: 'Erro ao enviar os arquivos!',
      // success: function(file, response){
        // window.setTimeout('salvar_ordem_fotos(<?php echo $id_imovel; ?>);$(".dz-preview").fadeOut();', 3000);
        // alert(123);
      // },
      init: function() {
        this.on("success", function(file, responseText) {
          //acao apos o envio das imagens
        });
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