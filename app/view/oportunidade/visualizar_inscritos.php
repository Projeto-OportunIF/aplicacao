<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center">Inscritos na Oportunidade: <?= $dados['oportunidade']->getTitulo(); ?></h3>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Matrícula</th>
            <th>Email</th>
            <th>Documento</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($dados['inscritos'] as $inscrito): ?>
            <tr>
                <td><?= $inscrito->nomeAluno ?></td>
                <td><?= $inscrito->matriculaAluno ?></td>
                <td><?= $inscrito->emailAluno ?></td>
                <td>
                    <?php if ($inscrito->documentosAnexo): ?>
                        <a href="<?= BASEURL ?>/uploads/<?= $inscrito->documentosAnexo ?>" target="_blank">Ver documento</a>
                    <?php else: ?>
                        Nenhum
                    <?php endif; ?>
                </td>
                <td><?= $inscrito->status ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a class="btn btn-secondary" href="<?= BASEURL ?>/controller/OportunidadeController.php?action=list">Voltar</a>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>
