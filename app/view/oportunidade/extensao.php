<?php

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
require_once(__DIR__ . "/../../dao/OportunidadeDAO.php");

$dao = new OportunidadeDAO();
$oportunidades = $dao->listByTipo("Extensão"); // Ajuste conforme está salvo no seu BD

?>

<h2>Oportunidades de Projeto de Extensão</h2>

<?php if (count($oportunidades) > 0): ?>
    <ul>
        <?php foreach ($oportunidades as $op): ?>
            <li>
                <strong><?= htmlspecialchars($op->getTitulo()) ?></strong><br>
                <?= nl2br(htmlspecialchars($op->getDescricao())) ?><br>
                Início: <?= htmlspecialchars($op->getDataInicio()) ?> - Fim: <?= htmlspecialchars($op->getDataFim()) ?><br>
                <?php if ($op->getDocumentoAnexo()): ?>
                    <a href="<?= BASEURL ?>/uploads/<?= htmlspecialchars($op->getDocumentoAnexo()) ?>" target="_blank">Documento</a>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Não há oportunidades de projeto de extensão no momento.</p>
<?php endif; ?>


<?php  
require_once(__DIR__ . "/../include/footer.php");
?>
