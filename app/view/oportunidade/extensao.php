<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
require_once(__DIR__ . "/../../dao/OportunidadeDAO.php");

$dao = new OportunidadeDAO();
$oportunidades = $dao->listByTipo(OportunidadeTipo::PROJETOEXTENSAO);
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/oportunidades_disponiveis.css"> <!-- Pode usar o mesmo CSS -->

<h2 class="titulo-pagina">Oportunidades de Projeto de Extensão</h2>

<div class="cards-container">
<?php if (count($oportunidades) > 0): ?>
    <?php foreach ($oportunidades as $op): ?>
        <div class="card-oportunidade">
            <h3><?= htmlspecialchars($op->getTitulo()) ?></h3>
            <p><?= nl2br(htmlspecialchars($op->getDescricao())) ?></p>
            
            <p>
                <strong>Início:</strong> <?= htmlspecialchars($op->getDataInicio()) ?><br>
                <strong>Fim:</strong> <?= htmlspecialchars($op->getDataFim()) ?>
            </p>

          
            <p><strong>Vagas:</strong> <?= htmlspecialchars($op->getVaga()) ?></p>

            <?php if ($op->getDocumentoAnexo()): ?>
                <a class="botao-doc" href="<?= BASEURL ?>/uploads/<?= htmlspecialchars($op->getDocumentoAnexo()) ?>" target="_blank">Ver Documento</a>
            <?php endif; ?>

            <button class="btn-inscrever">Inscrever</button>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Não há oportunidades de projeto de extensão no momento.</p>
<?php endif; ?>
</div>

<?php require_once(__DIR__ . "/../include/footer.php"); ?>
