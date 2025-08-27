<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
require_once(__DIR__ . "/../../model/enum/StatusTipo.php"); // para acessar os status
?>

<h3 class="text-center">Inscritos na Oportunidade: <?= $dados['oportunidade']->getTitulo(); ?></h3>

<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Matrícula</th>
            <th>Email</th>
            <th>Curso</th> <!-- nova coluna -->
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
                <td><?= $inscrito->cursoAluno ?></td>

                <td>
                    <?php if ($inscrito->documentosAnexo): ?>
                        <a href="<?= BASEURL ?>/uploads/<?= $inscrito->documentosAnexo ?>" target="_blank">Ver documento</a>
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



            <?php endforeach; ?>
    </tbody>
</table>

<a class="btn btn-secondary" href="<?= BASEURL ?>/controller/OportunidadeController.php?action=list">Voltar</a>



<?php
require_once(__DIR__ . "/../include/footer.php");
?>