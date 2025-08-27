<?php
#Nome do arquivo: view/include/menu.php
#Objetivo: menu da aplicação para ser incluído em outras páginas

include_once(__DIR__ . "/../../model/enum/UsuarioTipo.php");


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$nome = "(Sessão expirada)";
if (isset($_SESSION[SESSAO_USUARIO_NOME]))
    $nome = $_SESSION[SESSAO_USUARIO_NOME];

$homePage = HOME_PAGE_ADMIN;
if ($_SESSION[SESSAO_USUARIO_TIPO] == UsuarioTipo::ALUNO)
    $homePage = HOME_PAGE_ALUNO;
elseif ($_SESSION[SESSAO_USUARIO_TIPO] == UsuarioTipo::PROFESSOR)
    $homePage = HOME_PAGE_PROFESSOR;
?>
<nav class="navbar navbar-expand-md px-3 mb-3" style="background-color: #c23956">


    <a class="navbar-brand" href="<?= $homePage ?>">
        <img src="<?= BASEURL ?>/view/img/logo.png">
    </a>

    <button class="navbar-toggler" type="button"
        data-bs-toggle="collapse" data-bs-target="#navSite">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navSite">


        <ul class="navbar-nav ms-auto mr-3">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle usuario-topo" href="#" id="navbarUsuario"
                    data-bs-toggle="dropdown">

                    <img src="<?= BASEURL_ARQUIVOS . "/$fotoPerfil" ?>" alt="Foto de perfil">

                    <span><?= $nome ?></span>
                </a>

                <div class="dropdown-menu">
                    <a class="dropdown-item"
                        href="<?= BASEURL . '/controller/PerfilController.php?action=view' ?>">Perfil</a>
                    <a class="dropdown-item" href="<?= LOGOUT_PAGE ?>">Sair</a>
                </div>

            </li>
        </ul>
    </div>
</nav>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }


    .navbar {
        height: 70px;
        /* altura fixa da navbar */
    }

    .navbar-brand img {
        max-height: 180px;
        /* a imagem não passa da altura da navbar */
        max-width: 180px;
        /* mas não fica maior que 200px largura */
        width: auto;
        /* largura automática para manter proporção */
        height: auto;
        /* altura automática para manter proporção */
    }
</style>