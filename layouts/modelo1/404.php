<div class="erro404">
  <div class="centralizador">
    <div class="erro_img">
      <img src="layouts/<?php echo $layout; ?>/assets/img/404.jpg" alt="Erro 404 - Página não encontrada">
    </div>
    <div class="voltar">
      <a href="./"><i class="fa fa-arrow-left"></i> Voltar ao site</a>
    </div>
  </div>
</div>
<style>
  *{ margin: 0; padding: 0; box-sizing: border-box; }
  .erro404{ width: 100%; padding: 6rem 0; }
  .erro_img{ width: 100%; display: flex; flex-direction: row; flex-wrap: nowrap; justify-content: center; margin-bottom: 5rem; }
  .erro_img img{ max-width: 100%; max-height: 100%; }
  .voltar{ width: 100%; text-align: center; }
  .voltar a{ text-decoration: none; text-align: center; font-size: 2rem; }
  .voltar a i{ margin-right: 1rem; font-size: 2rem; }

  @media only screen and (min-width: 641px) and (max-width: 1023px) {

  }
  @media only screen and (max-width: 640px) {
    .erro_img{ display: block; }
  }
</style>
