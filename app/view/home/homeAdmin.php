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
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/homeAdmin.css">

<h2 class="titulo">Adicionar ao Sistema</h2>

<div class="container-botoes">
    <a href="<?= BASEURL ?>/controller/UsuarioController.php?action=list" class="botao-opcao">
        <div class="texto-botao">USUÁRIOS</div>
        <div class="botao-quadrado">
            <img src="<?= BASEURL ?>/view/img/add_usuario.png" alt="Adicionar">
        </div>
    </a>

    <a href="<?= BASEURL ?>/controller/CursoController.php?action=list" class="botao-opcao">
        <div class="texto-botao">CURSOS</div>
        <div class="botao-quadrado">
            <img src="<?= BASEURL ?>/view/img/add_curso.png" alt="Visualizar">
        </div>
    </a>
</div>

<?php require_once(__DIR__ . "/../include/footer.php"); ?>