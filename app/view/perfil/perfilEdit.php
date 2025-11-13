<?php
# Arquivo: perfilEdit.php
# Objetivo: Formulário de edição de perfil do usuário logado

# Carrega cabeçalho e menu
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");

# Busca informações do usuário
$usuario = $dados["usuario"];
?>

<div class="page-container">
    <div class="form-card">
        <h2 class="form-title text-center">Editar Perfil</h2> <!-- Centraliza o título -->

        <!-- Formulário envia para salvarEdicaoPerfil -->
        <form action="<?php echo BASEURL . '/controller/PerfilController.php?action=save&edicaoPerfil=1'; ?>"
            method="POST" enctype="multipart/form-data" class="edit-form mt-4">

            <!-- Campo oculto com ID -->
            <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>">

            <!-- Nome -->
            <div class="mb-3">
                <label for="nomeCompleto" class="form-label">Nome completo</label>
                <input type="text" class="form-control" id="nomeCompleto" name="nomeCompleto"
                    value="<?php echo htmlspecialchars($usuario->getNomeCompleto() ?? ''); ?>" >

                <?php if (isset($dados['erros']['nome'])): ?>
                    <span class="form_error_message"><?= $dados['erros']['nome'] ?></span>
                <?php endif; ?>    
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?php echo htmlspecialchars($usuario->getEmail() ?? ''); ?>" >

                <?php if (isset($dados['erros']['email'])): ?>
                    <span class="form_error_message"><?= $dados['erros']['email'] ?></span>
                <?php endif; ?>
            </div>

            <!-- CPF -->
            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf" disabled="true"
                    value="<?php echo htmlspecialchars($usuario->getCpf() ?? ''); ?>">
            </div>

            <!-- Matrícula -->
            <?php if (strtolower($usuario->getTipoUsuario()) === 'aluno') { ?>
            <div class="mb-3">
                <label for="matricula" class="form-label">Matrícula</label>
                <input type="text" class="form-control" id="matricula" name="matricula"
                    value="<?php echo htmlspecialchars($usuario->getMatricula() ?? ''); ?>" disabled="true">
            </div>
            <?php } ?>

            <!-- Tipo de usuário (somente leitura) -->
            <div class="mb-3">
                <label for="tipoUsuario" class="form-label">Tipo de Usuário</label>
                <input type="text" class="form-control" id="tipoUsuario"
                    value="<?php echo htmlspecialchars($usuario->getTipoUsuario()); ?>" disabled="true">
            </div>

            <!-- Curso (somente leitura) -->
            <?php if (strtolower($usuario->getTipoUsuario()) === 'aluno') { ?>
                <div class="mb-3">
                    <label for="curso" class="form-label">Curso</label>
                    <input type="text" class="form-control" id="curso"
                        value="<?php echo htmlspecialchars($usuario->getCurso() ? $usuario->getCurso()->getNome() : ''); ?>" 
                        disabled="true">
                </div>
            <?php } ?>

            <!-- Senha do perfil -->
            <div class="mb-3">
                <label for="senhaNova" class="form-label">Nova senha</label>
                <input type="password" class="form-control" id="senhaNova" name="senhaNova"
                    placeholder="Digite uma nova senha" autocomplete="new-password">

                <?php if (isset($dados['erros']['senha'])): ?>
                    <span class="form_error_message"><?= $dados['erros']['senha'] ?></span>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label for="confSenhaNova" class="form-label">Confirmação nova senha</label>
                <input type="password" class="form-control" id="confSenhaNova" name="confSenhaNova"
                    placeholder="Digite uma nova senha" autocomplete="new-password">

                <?php if (isset($dados['erros']['confsenha'])): ?>
                    <span class="form_error_message"><?= $dados['erros']['confsenha'] ?></span>
                <?php endif; ?>
            </div>

            <!-- Foto de Perfil -->
            <div class="mb-3">
                <?php if (!empty($usuario->getFotoPerfil())): ?>
                    <p class="mt-2">Foto atual:</p>
                    <img class="foto-perfil" src="<?= BASEURL_ARQUIVOS . "/" . $usuario->getFotoPerfil(); ?>"
                        alt="Foto de perfil" width="120" class="rounded">
                <?php endif; ?>
            </div>


            <!-- Botões -->
            <div class="text-center d-flex justify-content-center gap-3">
                <!-- Botão Voltar -->
                <a href="<?php echo BASEURL . '/controller/PerfilController.php?action=view'; ?>" class="btn btn-secondary">Voltar</a>
                
                <!-- Botão Salvar -->
                <button type="submit" class="btn btn-pink">Salvar Alterações</button>
            </div>

            

        </form>
    </div>
</div>

<style>
    body {
        background-color: #b7cd8c;
        margin: 0;
        padding: 0;
    }

    .page-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: calc(100vh - 60px);
    }

    .form-card {
        width: 100%;
        max-width: 500px;
        padding: 30px;
        background: #e6f1d7;
        border-radius: 15px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-pink {
        background-color: #d9426b;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        transition: background 0.3s;
    }

    .btn-pink:hover {
        background-color: #c9385f;
    }

    .btn-secondary {
        background-color: #7b8d5b;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        transition: background 0.3s;
        text-decoration: none;
        display: inline-block;
    }


    .btn-secondary:hover {
        background-color: #7b8d5b;
        color: #fff;
    }

    .alert ul {
        margin: 0;
        padding-left: 20px;
    }

    .form_error_message {
        color: #cf3b4aff;
        font-style: italic;
    }

    .d-flex {
        display: flex;
    }

    .gap-3 {
        gap: 15px;
    }
</style>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>