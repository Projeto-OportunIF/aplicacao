<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
require_once(__DIR__ . "/../../dao/OportunidadeDAO.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/css/oportunidades_disponiveis.css">

<h2 class="titulo-pagina">TELA DE NOTIFICACOES</h2>

<div class="text-center mt-5 mb-5">
    <a href="<?= BASEURL ?>/controller/HomeController.php?action=homeAluno" class="btn-voltar">
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
        <p>Não há notificações no momento.</p>
    <?php endif; ?>
</div>

<?php require_once(__DIR__ . "/../include/footer.php"); ?>