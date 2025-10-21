<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
require_once(__DIR__ . "/../../model/enum/StatusTipo.php"); // para acessar os status
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/css/visualizar_inscritoss.css">

<h3 class="text-center">Inscritos na Oportunidade: <?= $dados['oportunidade']->getTitulo(); ?></h3>

<div class="col-12">
    <div class="container text-center" style="margin-top: 30px;">
        <a href="<?= BASEURL ?>/controller/OportunidadeController.php?action=list"
            class="btn-voltar">
            <i class="bi bi-arrow-left-circle"></i> Voltar
        </a>
    </div>
</div>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Matrícula</th>
            <th>Email</th>
            <th>Curso</th>
            <th>Documento</th>
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
                    <?php
                    $caminhoUploads = __DIR__ . '/../../../uploads/'; // sobe mais um nível
                    $caminhoArquivo = $caminhoUploads . $inscrito->documentosAnexo;

                    if ($inscrito->documentosAnexo && file_exists($caminhoArquivo)): ?>
                        <a href="<?= BASEURL ?>/../uploads/<?= $inscrito->documentosAnexo ?>" target="_blank">Ver documento</a>

                    <?php else: ?>
                        Nenhum
                    <?php endif; ?>

                </td>

                <td>
                    <form action="<?= BASEURL ?>/controller/OportunidadeController.php?action=alterarStatus" method="post">
                        <input type="hidden" name="idInscricao" value="<?= $inscrito->idInscricoes ?>">
                        <input type="hidden" name="idOport" value="<?= $dados['oportunidade']->getId() ?>">

                        <select name="novoStatus" class="form-select form-select-sm" onchange="this.form.submit()">
                            <?php foreach (StatusTipo::getAll() as $status): ?>
                                <option value="<?= $status ?>" <?= $inscrito->status === $status ? 'selected' : '' ?>>
                                    <?= StatusTipo::getLabel($status) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>