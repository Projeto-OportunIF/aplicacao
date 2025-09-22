<?php
# Nome do arquivo: usuario/usuario_list.php
# Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/usuariolist.css">

<h3>Usuários</h3>

<div class="container table-container">
    <div class="row mb-3 align-items-center">
        <div class="col-auto">
            <a class="btn btn-success"
               href="<?= BASEURL ?>/controller/UsuarioController.php?action=create">
               Inserir Usuário
            </a>
        </div>
        <div class="col-auto ms-2">
            <a class="btn btn-secondary"
               href="<?= BASEURL ?>/controller/HomeController.php?action=home">
               Voltar
            </a>
        </div>
    </div>

    <?php require_once(__DIR__ . "/../include/msg.php"); ?>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Tipo de Usuário</th>
                            <th>Curso</th>
                            <th>Alterar</th>
                            <th>Excluir</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dados['lista'] as $usu): ?>
                            <tr>
                                <td><?= $usu->getId() ?></td>
                                <td><?= $usu->getNomeCompleto() ?></td>
                                <td><?= $usu->getEmail() ?></td>
                                <td><?= $usu->getTipoUsuario() ?></td>
                                <td>
                                    <?= $usu->getCurso() && $usu->getCurso()->getNome()
                                        ? $usu->getCurso()->getNome()
                                        : "Curso não especificado." ?>
                                </td>
                                <td>
                                    <a class="btn btn-primary btn-sm"
                                        href="<?= BASEURL ?>/controller/UsuarioController.php?action=edit&id=<?= $usu->getId() ?>">
                                        Alterar
                                    </a>
                                </td>
                                <td>
                                    <a class="btn btn-danger btn-sm"
                                        onclick="return confirm('Confirma a exclusão do usuário?');"
                                        href="<?= BASEURL ?>/controller/UsuarioController.php?action=delete&id=<?= $usu->getId() ?>">
                                        Excluir
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>

                </table>

            </div>
        </div>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>