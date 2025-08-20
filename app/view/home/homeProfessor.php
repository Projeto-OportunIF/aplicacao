<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<style>
    body {
        background-color: #d4f4c1; /* verde claro */
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .titulo {
        text-align: center;
        color: #d6425c; /* vermelho */
        font-size: 28px;
        font-weight: bold;
        margin-top: 30px;
    }

    .container-botoes {
        display: flex;
        justify-content: center;
        gap: 60px;
        margin-top: 50px;
    }

    .botao-opcao {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-decoration: none;
        color: #d6425c;
        font-weight: bold;
    }

    .botao-quadrado {
        width: 150px;
        height: 150px;
        background-color: #d6425c;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 20px;
        transition: transform 0.2s ease;
    }

    .botao-quadrado:hover {
        transform: scale(1.05);
    }

    .botao-quadrado img {
        width: 60px;
        height: 60px;
    }

    .texto-botao {
        margin-bottom: 8px;
        font-size: 14px;
    }
</style>

<h2 class="titulo">Central de Oportunidades</h2>

<div class="container-botoes">
    <a href="<?= BASEURL ?>/controller/OportunidadeController.php?action=create" class="botao-opcao">
        <div class="texto-botao">ADICIONAR</div>
        <div class="botao-quadrado">
            <img src="<?= BASEURL ?>/view/img/add-icon.png" alt="Adicionar">
        </div>
    </a>

    <a href="<?= BASEURL ?>/controller/OportunidadeController.php?action=list" class="botao-opcao">
        <div class="texto-botao">VIZUALIZAR</div>
        <div class="botao-quadrado">
            <img src="<?= BASEURL ?>/view/img/search-icon.png" alt="Visualizar">
        </div>
    </a>
</div>

<?php require_once(__DIR__ . "/../include/footer.php"); ?>
