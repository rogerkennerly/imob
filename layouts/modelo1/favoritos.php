<?php if (basename($_SERVER['PHP_SELF']) == basename(__FILE__)) { exit(); } ?>
<section class="imob_favoritos">
	<div class="centralizador">
		<?php if(!include "clientes/".DIRETORIO."/inc/breadcrumbs.php"){include "layouts/$layout/breadcrumbs.php";} ?>
		<?php if(!include "clientes/".DIRETORIO."/inc/resultado_favoritos.php"){include "layouts/$layout/resultado_favoritos.php";} ?>
		<?php if(!include "clientes/".DIRETORIO."/inc/modal.php"){include "layouts/$layout/modal.php";} ?>
	</div>
</section>
