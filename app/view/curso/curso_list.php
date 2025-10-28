<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/css/curso_list.css">

<h3>Cursos</h3>

<div class="container table-container">
    <div class="row mb-3 align-items-center justify-content-center">
        <div class="col-auto">
            <a class="btn btn-secondary"
                href="<?= BASEURL ?>/controller/HomeController.php?action=home">
                Voltar
            </a>
        </div>
        <div class="col-auto ms-2">
            <a class="btn btn-success"
                href="<?= BASEURL ?>/controller/CursoController.php?action=create">
                Inserir
            </a>
        </div>
    </div>

    <div class="user-cards">
        <?php if (!empty($dados['cursos'])): ?>
            <?php foreach ($dados['cursos'] as $curso): ?>
                <div class="user-card">
                    <p><strong>ID:</strong> <?= $curso->getId(); ?></p>
                    <p><strong>Nome do Curso:</strong> <?= $curso->getNome(); ?></p>
                    <div class="d-flex mt-3">
                        <a class="btn btn-primary me-2"
                            href="<?= BASEURL ?>/controller/CursoController.php?action=edit&id=<?= $curso->getId() ?>">
                            Alterar
                        </a>
                        <a class="btn btn-danger"
                            onclick="return confirm('Confirma a exclusão do curso?');"
                            href="<?= BASEURL ?>/controller/CursoController.php?action=delete&id=<?= $curso->getId() ?>">
                            Excluir
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center mt-4" style="color:#c63f57; font-weight:bold;">Nenhum curso cadastrado.</p>
        <?php endif; ?>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>