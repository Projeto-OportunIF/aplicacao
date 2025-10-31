<?php
#Nome do arquivo: view/include/menu.php
#Objetivo: menu da aplicação para ser incluído em outras páginas

include_once(__DIR__ . "/../../model/enum/UsuarioTipo.php");
include_once(__DIR__ . "/../../service/NotificacaoService.php");


// print_r( $_SESSION);
// die;
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$nome = "(Sessão expirada)";
$fotoPerfil = "avatar.png";
$notificacoes = 0;

if (isset($_SESSION[SESSAO_USUARIO_FOTO_PERFIL])) {
    $fotoPerfil = $_SESSION[SESSAO_USUARIO_FOTO_PERFIL];
}

// Caminho real do arquivo de upload
// Caminho real do arquivo de upload
$caminhoLocalUpload = __DIR__ . "/../../../uploads/$fotoPerfil";
$caminhoFotoGenerica = BASEURL . "/view/img/foto_generica_perfil.png";

// Se a foto do usuário existir na pasta uploads, usa ela; caso contrário, usa a genérica
if (file_exists($caminhoLocalUpload)) {
} else {
    $caminhoFoto = $caminhoFotoGenerica;
}


if (isset($_SESSION[SESSAO_USUARIO_NOME])) {
    $nome = $_SESSION[SESSAO_USUARIO_NOME];
}

if (isset($_SESSION[SESSAO_USUARIO_NOTIFICACOES])) {
    $notificacoes = $_SESSION[SESSAO_USUARIO_NOTIFICACOES];
} else {
    NotificacaoService::countNotificacoesByUsuario();
    $notificacoes = $_SESSION[SESSAO_USUARIO_NOTIFICACOES];
}

$homePage = HOME_PAGE_ADMIN;

if ($_SESSION[SESSAO_USUARIO_TIPO] == UsuarioTipo::ALUNO)
    $homePage = HOME_PAGE_ALUNO;
elseif ($_SESSION[SESSAO_USUARIO_TIPO] == UsuarioTipo::PROFESSOR)
    $homePage = HOME_PAGE_PROFESSOR;
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/menu.css">
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

            <li class="nav-item d-flex justify-content-center align-itens-center">
                <i class="bi bi-envelope"></i> <span>( <a href="<?= BASEURL . '/controller/NotificacaoController.php?action=listar' ?>"><?= $notificacoes ?> </a>)</span>
            </li>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle usuario-topo" href="#" id="navbarUsuario"
                    data-bs-toggle="dropdown">

                    <div class="foto-perfil-wrapper">
                        <img class="foto-perfil" src="<?= $caminhoFoto ?>" alt="Foto de perfil">

                    </div>

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