<?php
  session_start();
  include "../../config.php";
  include "../../conexao.php";
  include "../funcoes.php";
  include "funcoes_gdlib.php";
  $raiz = "../../clientes/".DIRETORIO."/";
  
  $dados_imobiliaria = mysql_query('SELECT marcadagua FROM dados_imobiliaria');
  $dados_imobiliaria = mysql_fetch_assoc($dados_imobiliaria);
  $foto_marca_dagua = "../../clientes/".DIRETORIO."/assets/img/".$dados_imobiliaria['marcadagua'];
  
  //falta incluir o cabeçalho aqui  
  
  $id_imovel  = $_GET["id_imovel"]; 
  $marcadagua = $_REQUEST["marcadagua"]; 
  
  $pos = 0;
  if (isset($_FILES["file"])){
    $caminho_original = $raiz.$foto_caminho;
    if(!is_dir($caminho_original)){ mkdir($caminho_original,0777);}
    $caminho_imovel = $caminho_original.$id_imovel."/";
    if(!is_dir($caminho_imovel)){ mkdir($caminho_imovel,0777);}
    
    for($z=0 ; $z<count($foto_diretorios) ; $z++){
      $diretorio = $caminho_imovel.$foto_diretorios[$z];
      if (!is_dir($diretorio)) { mkdir($diretorio,0777); chmod($diretorio,0777); }
    }
    
    $total = count($_FILES["file"]['name']);
    for($x=0 ; $x<$total ; $x++){
      $cname = rand(0, 10000000000);
      
      $teste = explode(".",$_FILES["file"]['name'][$x]);
      
      $contador = count($teste);
      
      $nome = $cname.".".$teste[$contador-1];
			$nome = str_replace(".jfif", ".jpg", $nome);
      
      if(move_uploaded_file($_FILES["file"]['tmp_name'][$x], $caminho_imovel.$foto_diretorios[0].$nome)){
        echo "ok";
      }else{
        echo "erro";
      }
      
      $diretorio_original = $caminho_imovel.$foto_diretorios[0];
      for($z=0 ; $z<count($foto_diretorios) ; $z++){
        $diretorio = $caminho_imovel.$foto_diretorios[$z];
        
        //pulo a foto [0] pois é a foto com tamanho original. Esta foto é gravada acima no move_uploaded_file
        if($z>0){ 
          gera_thumb($diretorio_original.$nome, $diretorio.$nome, $foto_tamanhos[$z], 0, 0, 0); 
          $diretorio_original = $caminho_imovel.$foto_diretorios[1];
        }
        if($z == 1 AND $marcadagua == "true"){
          coloca_logo($diretorio.$nome, $raiz.$foto_marca_dagua);
        }
      }
      
      $last_pos = mysql_query("SELECT posicao FROM foto WHERE id_imovel = '$id_imovel' ORDER BY posicao DESC LIMIT 0,1");
      $last_pos = mysql_fetch_assoc($last_pos);
      $pos = $last_pos["posicao"]+1;
      
      $data = date("Y-m-d H:i:s");
      $sql_i = "INSERT INTO foto (id_imovel, nome, data, posicao) VALUES ('$id_imovel', '$nome', '$data', '$pos')";
      $query_insert = mysql_query($sql_i);
      $pos++;
      
      $descricao_log = "Foto Incluida - nome. $nome";
      gravalog($_SESSION["sessao_id_user"], 101, 1, $descricao_log, $sql_i);
    }
  }
?>

<script>
console.log('abc');
$(".dz-preview").fadeOut()
</script>