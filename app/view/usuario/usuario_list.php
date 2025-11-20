<?php
# Nome do arquivo: usuario/usuario_list.php
# Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>



<?php if (!empty($_SESSION['msgSucesso'])): ?>
  <div class="msg-sucesso">
    ✅ <?= $_SESSION['msgSucesso'] ?>
  </div>
  <?php unset($_SESSION['msgSucesso']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['msgErro'])): ?>
  <div class="msg-erro">
    🚫 <?= $_SESSION['msgErro'] ?>
  </div>
  <?php unset($_SESSION['msgErro']); ?>
<?php endif; ?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/css/usuario_lists.css">



<h3>Usuários no Sistema</h3>



<div class="row mb-3 align-items-center justify-content-center">
    <div class="col-auto">
        <a class="btn btn-secondary"
            href="<?= BASEURL ?>/controller/HomeController.php?action=home">
            Voltar
        </a>
    </div>
    <div class="col-auto ms-2">
        <a class="btn btn-success"
            href="<?= BASEURL ?>/controller/UsuarioController.php?action=create">
            Inserir
        </a>
    </div>
</div>


<div class="user-cards">

    <?php if (!empty($dados['lista'])): ?>

        <?php foreach ($dados['lista'] as $usu): ?>
            <div class="user-card">
                <p><strong>ID:</strong> <?= $usu->getId() ?></p>
                <p><strong>Nome:</strong> <?= $usu->getNomeCompleto() ?></p>
                <p><strong>Email:</strong> <?= $usu->getEmail() ?></p>
                <p><strong>Tipo de Usuário:</strong> <?= $usu->getTipoUsuario() ?></p>
                <p><strong>Curso:</strong>
                    <?= $usu->getCurso() && $usu->getCurso()->getNome()
                        ? $usu->getCurso()->getNome()
                        : "Curso não especificado." ?>
                </p>

                <div class="mt-2">
                    <a class="btn btn-primary btn-sm"
                        href="<?= BASEURL ?>/controller/UsuarioController.php?action=edit&id=<?= $usu->getId() ?>">
                        Alterar
                    </a>
                    <a class="btn btn-danger btn-sm"
                        onclick="return confirm('Confirma a exclusão do usuário?');"
                        href="<?= BASEURL ?>/controller/UsuarioController.php?action=delete&id=<?= $usu->getId() ?>">
                        Excluir
                    </a>
                </div>
            </div>
        <?php endforeach; ?>

    <?php else: ?>
        <div class="sem-usuario">
            <i class="bi bi-info-circle"></i>
            Você ainda não cadastrou nenhum usuário.
        </div>
    <?php endif; ?>
</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>