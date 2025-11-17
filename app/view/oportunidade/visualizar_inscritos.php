<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
require_once(__DIR__ . "/../../model/enum/StatusTipo.php"); // para acessar os status
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/css/visualizar_inscritoss.css">

<h3 class="text-center">Inscritos na Oportunidade: <?= htmlspecialchars($dados['oportunidade']->getTitulo()); ?></h3>

<div class="col-12">
    <div class="container text-center" style="margin-top: 30px;">
        <a href="<?= BASEURL ?>/controller/OportunidadeController.php?action=list" class="btn-voltar">
            <i class="bi bi-arrow-left-circle"></i> Voltar
        </a>
    </div>
</div>

<?php if (empty($dados['inscritos'])): ?>

     <div class="sem-oportunidades-professor">
            <i class="bi bi-info-circle"></i>
        <p>Você ainda não tem nenhum inscrito no momento.</p>
    </div>

<?php else: ?>

<table class="table table-striped table-bordered mt-4">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Matrícula</th>
            <th>Email</th>
            <th>Curso</th>
            <th>Documentos</th>
            <th>Status</th>
        </tr>
    </thead>

    <tbody>
        <?php foreach ($dados['inscritos'] as $inscrito): ?>
            <tr>
                <td><?= htmlspecialchars($inscrito->nomeAluno) ?></td>
                <td><?= htmlspecialchars($inscrito->matriculaAluno) ?></td>
                <td><?= htmlspecialchars($inscrito->emailAluno) ?></td>
                <td><?= htmlspecialchars($inscrito->cursoAluno) ?></td>

                <td>
                    <?php if ($inscrito->documentosAnexo): ?>
                        <?php foreach (explode(',', $inscrito->documentosAnexo) as $doc): ?>
                             <a href="<?= BASEURL ?>/../uploads/<?= trim($doc) ?>" target="_blank" class="link-doc">
                                <i class="bi bi-file-earmark-text"></i> <?= htmlspecialchars(trim($doc)) ?>
                            </a><br>
                        <?php endforeach; ?>
                    <?php else: ?>
                        Nenhum
                    <?php endif; ?>
                </td>

                <td>
                    <form action="<?= BASEURL ?>/controller/OportunidadeController.php?action=alterarStatus" method="post">
                        <input type="hidden" name="idInscricao" value="<?= $inscrito->idInscricoes ?>">
                        <input type="hidden" name="idOport" value="<?= $dados['oportunidade']->getId() ?>">

                        <select name="novoStatus" class="form-select form-select-sm mb-2">
                            <?php foreach (StatusTipo::getAll() as $status): ?>
                                <option value="<?= $status ?>" <?= $inscrito->status === $status ? 'selected' : '' ?>>
                                    <?= StatusTipo::getLabel($status) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>

                        <textarea name="feedbackProfessor" class="form-control form-control-sm mb-2"
                            placeholder="Escreva um feedback (opcional)"><?= htmlspecialchars($inscrito->feedbackProfessor ?? '') ?></textarea>

                        <button type="submit" class="btn-salvar">Salvar</button>

                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php endif; ?>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>
