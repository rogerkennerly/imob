<?php if (basename($_SERVER['SCRIPT_NAME']) == basename(__FILE__)) { exit(); } ?>
<?php
  $pg_atual = $_GET["pg"];
  if(!$pg_atual){
    $pg_atual = "Dashboard";
  }
?>

<div class="breadcrumbs" id="breadcrumbs">
  <script type="text/javascript">
    try{ace.settings.check('breadcrumbs' , 'fixed')}catch(e){}
  </script>

  <ul class="breadcrumb">
    <li>
      <i class="icon-home home-icon"></i>
      <a href="#">Home</a>
    </li>
    <li class="active"><?php echo $pg_atual; ?></li>
  </ul><!-- .breadcrumb -->

  <div class="nav-search" id="nav-search">
    <form class="form-search" action="index.php" method="GET">
      <input type="hidden" name="pg" value="imovel">
      <span class="input-icon">
        <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" name="ref"/>
        <i class="icon-search nav-search-icon"></i>
      </span>
    </form>
  </div><!-- #nav-search -->
</div>