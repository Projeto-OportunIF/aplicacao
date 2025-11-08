<?php require_once(__DIR__ . "/../include/header.php"); ?>
<?php require_once(__DIR__ . "/../include/menu.php"); ?>

<h2 class="titulo-pagina">Inscritos na Oportunidade</h2>

<div class="text-center mb-4">
    <a href="<?= BASEURL ?>/controller/HomeController.php?action=homeProfessor" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle"></i> Voltar
    </a>
</div>

<?php if (count($dados['inscritos']) > 0): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Data da Inscrição</th>
                <th>Documentos</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dados['inscritos'] as $inscrito): ?>
                <tr>
                    <td><?= htmlspecialchars($inscrito['nome'] ?? '') ?></td>
                    <td><?= htmlspecialchars($inscrito['email'] ?? '') ?></td>
                    <td><?= htmlspecialchars($inscrito['documentos'] ?? '') ?></td>
                    <td><?= htmlspecialchars($inscrito['status'] ?? '') ?></td>
                    <td><?= htmlspecialchars($inscrito['feedbackProfessor'] ?? '') ?></td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <div class="alert alert-info text-center">
        Nenhum aluno inscrito nesta oportunidade até o momento.
    </div>
<?php endif; ?>

<?php require_once(__DIR__ . "/../include/footer.php"); ?>