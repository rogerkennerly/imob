<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<?php        
    if (!isset($op))     { $op = ""; }
    if (!isset($codigo)) { $codigo = 0; }
  
    if ($op == "D")
    { $arquivo = "logos/$codigo.jpg";
      if (file_exists($arquivo)) { @unlink($arquivo); }
    }
         
    $userfile = "userfile";
    if (isset($_FILES[$userfile]))
    { if (is_uploaded_file($_FILES[$userfile]['tmp_name']))
      { if (file_exists("logos/$codigo.jpg")) { @unlink("logos/$codigo.jpg"); }
        $ext = strtolower(substr($_FILES[$userfile]['name'],-4,4));
        if ($ext != ".jpg") { echo "<h4>Somente logos tipo .jpg são permitidos</h4>"; } else
        { move_uploaded_file($_FILES[$userfile]['tmp_name'], "logos/$codigo.jpg");
          chmod("logos/$codigo.jpg", 0777);
          echo "<h4>Logo Recebido</h4>";
          $alterados = true;
        }
      }
    }
?>  