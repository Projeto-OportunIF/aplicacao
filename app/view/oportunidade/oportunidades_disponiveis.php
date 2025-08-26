<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
require_once(__DIR__ . "/../../dao/OportunidadeDAO.php");
?>



<link rel="stylesheet" href="<?= BASEURL ?>/view/css/oportunidades_disponiveis.css">

<h2 class="titulo-pagina">Oportunidades Disponíveis</h2>

<div class="cards-container">
    <?php if (count($dados["oportunidades"]) > 0): ?>
        <?php foreach ($dados["oportunidades"] as $op): ?>
            <div class="card-oportunidade">
                <h3><?= htmlspecialchars($op->getTitulo()) ?></h3>
                <p><?= nl2br($op->getDescricao()) ?></p>

                <p>
                    <strong>Início:</strong> <?= htmlspecialchars($op->getDataInicioFormatada()) ?><br>
                    <strong>Fim:</strong> <?= htmlspecialchars($op->getDataFimFormatada()) ?>
                </p>
                <p><strong>Vagas:</strong> <?= htmlspecialchars($op->getVaga()) ?></p>

                <a href="<?= BASEURL ?>/controller/InscricaoController.php?action=view&idOport=<?= $op->getId() ?>" class="btn-inscrever">saiba mais</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Não há oportunidades no momento.</p>
    <?php endif; ?>
</div>

<div class="row" style="margin-top: 30px; max-width: 100%; text-align: center">
    <div class="col-12">
        <a class="btn btn-secondary"
            href="<?= BASEURL ?>/controller/HomeController.php?action=homeAluno">Voltar</a>
    </div>
</div>

<?php require_once(__DIR__ . "/../include/footer.php"); ?>