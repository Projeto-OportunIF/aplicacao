<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>


<?php if (!empty($_SESSION['msgErro'])): ?>
  <div class="msg-erro">
    🚫 <?= $_SESSION['msgErro'] ?>
  </div>
  <?php unset($_SESSION['msgErro']); ?>
<?php endif; ?>

<!-- Link para CSS externo -->
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/homeProfessors.css">

<h2 class="titulo">Central de Oportunidades</h2>

<div class="container-botoes">
    <a href="<?= BASEURL ?>/controller/OportunidadeController.php?action=create" class="botao-opcao">
        <div class="texto-botao">ADICIONAR</div>
        <div class="botao-quadrado">
            <img src="<?= BASEURL ?>/view/img/add_oportunidade.png" alt="Adicionar">
        </div>
    </a>

    <a href="<?= BASEURL ?>/controller/OportunidadeController.php?action=list" class="botao-opcao">
        <div class="texto-botao">VISUALIZAR</div>
        <div class="botao-quadrado">
            <img src="<?= BASEURL ?>/view/img/visualizar_oportunidade.png" alt="Visualizar">
        </div>
    </a>
</div>

<?php require_once(__DIR__ . "/../include/footer.php"); ?>