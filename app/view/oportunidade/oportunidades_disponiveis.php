<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
require_once(__DIR__ . "/../../dao/OportunidadeDAO.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/css/oportunidades_disponiveis.css">

<h2 class="titulo-pagina">Oportunidades Disponíveis</h2>

<div class="text-center mt-5 mb-5">
    <a href="<?= BASEURL ?>/controller/HomeController.php?action=homeAluno" class="btn-voltar">
        <i class="bi bi-arrow-left-circle"></i> Voltar
    </a>
</div>

<div class="cards-container">
    <?php if (count($dados["oportunidades"]) > 0): ?>
        <?php foreach ($dados["oportunidades"] as $op): ?>
            <div class="card-oportunidade">
                <h3><?= htmlspecialchars($op->getTitulo()) ?></h3>

                <p>
                    <strong>Professor Responsável:</strong>
                    <?= htmlspecialchars($op->getProfessor() ? $op->getProfessor()->getNomeCompleto() : "Não definido") ?>
                </p>

                <p>
                    <strong>Início:</strong> <?= htmlspecialchars($op->getDataInicioFormatada()) ?><br>
                    <strong>Fim:</strong> <?= htmlspecialchars($op->getDataFimFormatada()) ?>
                </p>
                <p><strong>Vagas:</strong> <?= htmlspecialchars($op->getVaga()) ?></p>

                <?php
                $dataHoje = new DateTime(); // data atual
                $dataFim = new DateTime($op->getDataFim()); // data final da oportunidade
                ?>

                <?php if ($dataHoje <= $dataFim): ?>
                    <a href="<?= BASEURL ?>/controller/InscricaoController.php?action=view&idOport=<?= $op->getId() ?>" class="btn-inscrever">saiba mais</a>
                <?php else: ?>
                    <div class="btn-inscrever btn-disabled">Prazo de inscrição encerrado!</div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php else: ?>

</div>
<div class="sem-oportunidades">
    <i class="bi bi-info-circle"></i>
    <p>Não há oportunidades no momento.</p>
</div>

<?php endif; ?>
</div>

<?php require_once(__DIR__ . "/../include/footer.php"); ?>