<?php
# Arquivo: perfilEdit.php
# Objetivo: Formulário de edição de perfil do usuário logado

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");

$usuario = $dados["usuario"];
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/perfilEdits.css">

<div class="page-container">
    <div class="form-card">
        <h2 class="form-title text-center titulo-editar">Editar Perfil</h2>

        <form action="<?php echo BASEURL . '/controller/PerfilController.php?action=save&edicaoPerfil=1'; ?>"
            method="POST" enctype="multipart/form-data" class="edit-form mt-4">

            <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>">

            <div class="mb-3">
                <label for="nomeCompleto" class="form-label">Nome completo</label>
                <input type="text" class="form-control" id="nomeCompleto" name="nomeCompleto"
                    value="<?php echo htmlspecialchars($usuario->getNomeCompleto() ?? ''); ?>">

                <?php if (isset($dados['erros']['nome'])): ?>
                    <span class="form_error_message"><?= $dados['erros']['nome'] ?></span>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?php echo htmlspecialchars($usuario->getEmail() ?? ''); ?>">

                <?php if (isset($dados['erros']['email'])): ?>
                    <span class="form_error_message"><?= $dados['erros']['email'] ?></span>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="cpf" disabled="true"
                    value="<?php echo htmlspecialchars($usuario->getCpf() ?? ''); ?>">
            </div>

            <?php if (strtolower($usuario->getTipoUsuario()) === 'aluno') { ?>
            <div class="mb-3">
                <label for="matricula" class="form-label">Matrícula</label>
                <input type="text" class="form-control" id="matricula" disabled="true"
                    value="<?php echo htmlspecialchars($usuario->getMatricula() ?? ''); ?>">
            </div>
            <?php } ?>

            <div class="mb-3">
                <label for="tipoUsuario" class="form-label">Tipo de Usuário</label>
                <input type="text" class="form-control" id="tipoUsuario" disabled="true"
                    value="<?php echo htmlspecialchars($usuario->getTipoUsuario()); ?>">
            </div>

            <?php if (strtolower($usuario->getTipoUsuario()) === 'aluno') { ?>
                <div class="mb-3">
                    <label for="curso" class="form-label">Curso</label>
                    <input type="text" class="form-control" id="curso"
                        value="<?php echo htmlspecialchars($usuario->getCurso() ? $usuario->getCurso()->getNome() : ''); ?>"
                        disabled="true">
                </div>
            <?php } ?>

            <div class="mb-3">
                <label for="senhaNova" class="form-label">Nova senha</label>
                <input type="password" class="form-control" id="senhaNova" name="senhaNova"
                    placeholder="Digite uma nova senha">

                <?php if (isset($dados['erros']['senha'])): ?>
                    <span class="form_error_message"><?= $dados['erros']['senha'] ?></span>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="confSenhaNova" class="form-label">Confirmação nova senha</label>
                <input type="password" class="form-control" id="confSenhaNova" name="confSenhaNova"
                    placeholder="Digite uma nova senha">

                <?php if (isset($dados['erros']['confsenha'])): ?>
                    <span class="form_error_message"><?= $dados['erros']['confsenha'] ?></span>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <?php if (!empty($usuario->getFotoPerfil())): ?>
                    <p class="mt-2">Foto atual:</p>
                    <img 
                        src="<?= BASEURL_ARQUIVOS . "/" . $usuario->getFotoPerfil(); ?>"
                        alt="Foto de perfil" class="foto-redonda">
                <?php endif; ?>
            </div>

            <!-- Botões -->
            <div class="text-center d-flex  gap-3">
                <a href="<?php echo BASEURL . '/controller/PerfilController.php?action=view'; ?>" class="btn btn-voltar">Voltar</a>
                <button type="submit" class="btn btn-pink btn-salvar">Salvar Alterações</button>
            </div>

        </form>
    </div>
</div>



<?php
require_once(__DIR__ . "/../include/footer.php");
?>