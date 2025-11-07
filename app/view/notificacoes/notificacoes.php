<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
require_once(__DIR__ . "/../../dao/OportunidadeDAO.php");



if (isset($_SESSION["usuario_tipo"])) {
    switch ($_SESSION["usuario_tipo"]) {
        case "professor":
            $homePage = BASEURL . "/controller/HomeController.php?action=homeProfessor";
            break;
        case "admin":
            $homePage = BASEURL . "/controller/HomeController.php?action=homeAdmin";
            break;
        case "aluno":
        default:
            $homePage = BASEURL . "/controller/HomeController.php?action=homeAluno";
            break;
    }
}
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/notificacoes.css">

<h2 class="titulo-pagina">TELA DE NOTIFICAÇÕES</h2>

<div class="text-center mt-5 mb-5">
    <a href="<?= $homePage ?>" class="btn-voltar">
        <i class="bi bi-arrow-left-circle"></i> Voltar
    </a>
</div>

<div class="cards-container">
    <?php if (count($dados["notificacoes"]) > 0): ?>
        <?php foreach ($dados["notificacoes"] as $notificacoes): ?>
            <div class="card-oportunidade">
                <h3><?= htmlspecialchars($notificacoes['mensagem']) ?></h3>
                <p><?= $notificacoes['dataEnvio'] ?></p>

                <a href="<?= BASEURL . '/controller/NotificacaoController.php?action=atualizarStatusPorUsuario&id_notificacao=' . $notificacoes['idNotificacoes'] ?>">ler notificacao</a>

            </div>
        <?php endforeach; ?>
    <?php else: ?>
        
        <div class="sem-notificacoes">
    <i class="bi bi-bell-slash"></i>
    <p>Não há notificações no momento.</p>
</div>

    <?php endif; ?>

</div>



<?php require_once(__DIR__ . "/../include/footer.php"); ?>