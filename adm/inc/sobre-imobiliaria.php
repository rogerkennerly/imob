<?php
  $titulo     = evita_injection($_POST["titulo"]);
  $texto      = $_POST["texto"];
  
  if($tipo == "social"){
    
  }
  elseif($tipo == "dados"){
    $teste = listar("sobre_empresa");
    if(mysql_num_rows($teste)==0){
      $s = "INSERT INTO sobre_empresa (
      titulo,     
      texto
      ) 
      VALUES (
      '$titulo',     
       '".mysql_real_escape_string($texto)."'
      )";
    }
    else{
      $s = "UPDATE sobre_empresa SET 
      titulo = '$titulo',     
      texto = '".mysql_real_escape_string($texto)."'
      ";
    }
    // echo $s;
    mysql_query($s);
    
    $descricao_log = "Pagina <strong>Sobre a Imobiliária</strong> atualizada";
    gravalog($_SESSION["sessao_id_user"], 9, 2, $descricao_log, $s);
  }
  
  $dados = listar("sobre_empresa");
  $dados = mysql_fetch_assoc($dados);
?>
<script src="https://cdn.ckeditor.com/ckeditor5/1.0.0-beta.1/classic/ckeditor.js"></script>
<div class="col-xs-12">
<div class="page-content">
  <div class="page-header">
    <h1>
      Sobre a Imobiliária
    </h1>
  </div><!-- /.page-header -->

  <div class="row">
    <?php echo $msg; ?>
    <div class="col-xs-12">
      <form method="POST" action="" id="form_cadastro">
      <input type="hidden" name="tipo" value="dados">
        <br/>
        Titulo:<br/>
        <input type="text" name="titulo" placeholder="" size="80" value="<?php echo $dados["titulo"]; ?>">
        <br/><br/><br/>
        Texto:<br/>
        <textarea name="texto" id="editor"><?php echo $dados["texto"]; ?></textarea>
        <input type="submit" style="display:none;">
      </div>
    </div>
  </div>
</div>

<div style="float:left;width:100%;padding:0 3rem 3rem 3rem;">
  <button class="btn-lg imob-botao-sucesso" onclick="$('#form_cadastro').submit()">Gravar Alterações</button>
</div>

<style>.ck-editor__main .ck-editor__editable{height:500px;}</style>
<script>
    ClassicEditor
        .create( document.querySelector( '#editor' ) )
        .catch( error => {
            console.error( error );
        } );
</script>