<?php
# Nome do arquivo: oportunidadeList.php
# Objetivo: interface para listagem das oportunidades do sistema
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<!-- Link para CSS externo -->
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/oportunidade_list.css">

<h3 class="text-center">Oportunidades Inseridas</h3>

<div class="container text-center" style="margin-top: 30px;">
    <a href="<?= BASEURL ?>/controller/HomeController.php?action=homeProfessor" class="btn-voltar">
        <i class="bi bi-arrow-left-circle"></i> Voltar
    </a>
</div>

<?php if (!empty($dados['lista'])): ?>
    <div class="cards-container">
        <?php foreach ($dados['lista'] as $op): ?>
            <div class="card-oportunidade">
                <h3><?= htmlspecialchars($op->getTitulo()); ?></h3>

                <p><strong>Professor Responsável:</strong> <?= htmlspecialchars($op->getProfessorResponsavel()); ?></p>
                <p><strong>Tipo:</strong> <?= htmlspecialchars($op->getTipoOportunidade()); ?></p>
                <p><strong>Vagas:</strong> <?= htmlspecialchars($op->getVaga()); ?></p>
                <p><strong>Cursos:</strong>
                    <?php
                    $nomesCursos = array_map(fn($c) => $c->getNome(), $op->getCursos() ?? []);
                    echo htmlspecialchars(implode(", ", $nomesCursos));
                    ?>
                </p>

                <?php if (!empty($op->getDocumentoEdital())): ?>
                    <?php $doc = basename($op->getDocumentoEdital()); ?>

                    <p>
                        <strong>Documento Edital:</strong><br>
                        <a href="<?= BASEURL ?>/../uploads/<?= htmlspecialchars($doc) ?>"
                            target="_blank"
                            class="link-doc">
                            <i class="bi bi-file-earmark-text"></i>
                            Edital da sua oportunidade
                        </a>
                    </p>
                <?php endif; ?>


                <div class="acoes">
                    <a class="btn btn-primary"
                        href="<?= BASEURL ?>/controller/OportunidadeController.php?action=edit&id=<?= $op->getId() ?>">Alterar</a>
                    <a class="btn btn-danger"
                        onclick="return confirm('Confirma a exclusão da oportunidade?');"
                        href="<?= BASEURL ?>/controller/OportunidadeController.php?action=delete&id=<?= $op->getId() ?>">Excluir</a>

                    <?php if ($op->getTipoOportunidade() !== 'ESTAGIO'): ?>
                        <a class="btn btn-info"
                            href="<?= BASEURL ?>/controller/OportunidadeController.php?action=visualizarInscritos&idOport=<?= $op->getId() ?>">Inscritos</a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <div class="sem-oportunidades-professor">
        <i class="bi bi-briefcase"></i>
        <p>Você não inseriu nenhuma oportunidade no momento.</p>
    </div>
<?php endif; ?>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>