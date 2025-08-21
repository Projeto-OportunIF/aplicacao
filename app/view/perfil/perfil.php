<?php
# Carrega o cabeçalho do sistema
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<!-- CONTEÚDO DO PERFIL DO USUÁRIO -->
<div class="perfil-container">
    <h3 class="text-center">Perfil</h3>

    <div class="perfil-info">
        <div><span class="info-label">NOME:</span> <?= $dados['usuario']->getNomeCompleto() ?></div>
        <div><span class="info-label">EMAIL:</span> <?= $dados['usuario']->getEmail() ?></div>
        <div><span class="info-label">TIPO DE USUÁRIO:</span> <?= $dados['usuario']->getTipoUsuario() ?></div>
        <div><span class="info-label">NÚMERO MATRÍCULA:</span> <?= $dados['usuario']->getMatricula() ?></div>
        <div><span class="info-label">CURSO:</span> <?php echo ($dados['usuario']->getCurso() && $dados['usuario']->getCurso()->getNome() ?
                                                        $dados['usuario']->getCurso()->getNome() : "Curso não informado") ?></div>
        <div><span class="info-label">CPF:</span> <?= $dados['usuario']->getCpf() ?></div>

        <form id="frmUsuario" method="POST"
            action="<?= BASEURL ?>/controller/PerfilController.php?action=save"
            enctype="multipart/form-data">

            <input type="hidden" name="fotoAnterior" value="<?= $dados['usuario']->getFotoPerfil() ?>">


            <div class="foto-upload-container">
                <label for="txtFoto">
                    <img src="https://img.icons8.com/ios-glyphs/30/ffffff/plus.png" />
                    <div>escolher foto de perfil.</div>
                </label>
                <input type="file" id="txtFoto" name="foto" onchange="document.getElementById('frmUsuario').submit();">
            </div>

                    <!-- Botão Voltar -->
            <div class="botao-voltar-container">
                <a href="<?= $homePage ?>" class="botao-voltar">← Voltar</a>
            </div>


            
        </form>
    </div>
</div>

<style>
    body {
        background-color: #b7cd8c;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    footer {
        display: none !important;
    }

    .top-bar {
        background-color: #d9426b;
        color: white;
        display: flex;
        padding: 10px 25px;
        justify-content: space-between;
        align-items: center;
        border-bottom: 20px solid #b7cd8c;
        height: 80px;
    }

    .logo img {
        height: 200px;
        object-fit: contain;
    }

    .top-icons {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .menu-icon {
        background-color: #b7cd8c;
        border-radius: 60%;
        padding: 10px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .botao-voltar-container {
        margin-top: 30px;
    }

    .botao-voltar {
        display: inline-block;
        background-color: #b7cd8c;
        color: white;
        padding: 10px 25px;
        text-decoration: none;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .botao-voltar:hover {
        background-color: #b73658;
    }

    .usuario-topo {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #fcd0d0;
        font-weight: bold;
    }

    .usuario-topo img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid white;
    }

    .perfil-container {
        background-color: #e6f1d7;
        width: 60%;
        margin: 40px auto;
        padding: 30px;
        border-radius: 15px;
    }

    h3.text-center {
        color: #d9426b;
        font-size: 28px;
        font-weight: bold;
        text-align: center;
    }

    .perfil-info {
        margin-top: 20px;
    }

    .perfil-info .info-label {
        font-weight: bold;
        display: inline-block;
        margin-bottom: 5px;
        color: #000;
    }

    .foto-upload-container {
        background-color: #d9426b;
        color: white;
        border-radius: 20px;
        padding: 30px;
        text-align: center;
        width: 150px;
        margin-top: 20px;
    }

    .foto-upload-container input[type="file"] {
        display: none;
    }

    .foto-upload-container label {
        cursor: pointer;
    }

    .mensagem-sucesso {
        margin-top: 10px;
        color: green;
        font-size: 14px;
    }

    .sidebar {
        height: 100%;
        width: 0;
        position: fixed;
        z-index: 1000;
        top: 0;
        left: 0;
        background-color: #e8aebcff;
        overflow-x: hidden;
        transition: 0.3s;
        padding-top: 60px;
    }

    .sidebar a {
        padding: 10px 30px;
        text-decoration: none;
        font-size: 22px;
        color: white;
        display: block;
        transition: 0.2s;
    }

    .sidebar a:hover {
        background-color: #b7cd8c;
        color: #d9426b;
    }

    .closebtn {
        position: absolute;
        top: 15px;
        right: 25px;
        font-size: 36px;
        text-decoration: none;
        color: white;
    }
</style>

<script>
    function toggleSidebar() {
        var sidebar = document.getElementById("sidebar");
        sidebar.style.width = (sidebar.style.width === "250px") ? "0" : "250px";
    }
</script>

<?php

require_once(__DIR__ . "/../include/footer.php");
?>