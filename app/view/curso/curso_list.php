<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>


<h3 class="text-center">Cursos</h3>

<div class="container">
    <div class="row">
        <div class="col-3">
            <a class="btn btn-success"
                href="<?= BASEURL ?>/controller/CursoController.php?action=create">
                Inserir</a>
        </div>

        <div class="row" style="margin-top: 30px;">
            <div class="col-12">
                <a class="btn btn-secondary"
                    href="<?= BASEURL ?>/controller/HomeController.php?action=home">Voltar</a>
            </div>
        </div>
        <div class="col-9">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-12">
            <table id="tabCursos" class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome do Curso</th>
                        <th>Alterar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>

                    <?php if (!empty($dados['cursos'])): ?>
                        <?php foreach ($dados['cursos'] as $curso): ?>
                            <tr>
                                <td><?= $curso->getId(); ?></td>
                                <td><?= $curso->getNome(); ?></td>
                                <td><a class="btn btn-primary"
                                        href="<?= BASEURL ?>/controller/CursoController.php?action=edit&id=<?= $curso->getId() ?>">
                                        Alterar</a>
                                </td>
                                <td><a class="btn btn-danger"
                                        onclick="return confirm('Confirma a exclusão do curso?');"
                                        href="<?= BASEURL ?>/controller/CursoController.php?action=delete&id=<?= $curso->getId() ?>">
                                        Excluir</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>


                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>