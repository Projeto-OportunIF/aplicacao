<?php
# Arquivo: perfilEdit.php
# Objetivo: Formulário de edição de perfil do usuário logado

ini_set('display_errors', 1);
error_reporting(E_ALL);

# Carrega cabeçalho e menu
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");

# DAOs necessários
require_once(__DIR__ . "/../../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../../dao/CursoDAO.php");

# Inicia a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

# Pega o ID do usuário logado
$idUsuario = $_SESSION['usuarioLogadoId'] ?? null;
if (!$idUsuario) {
    header("Location: " . BASEURL . "/controller/LoginController.php?action=login");
    exit;
}

# Instancia os DAOs
$usuarioDAO = new UsuarioDAO();
$cursoDAO = new CursoDAO();

# Busca informações do usuário
$usuario = $usuarioDAO->findById($idUsuario);

# Lista todos os cursos
$cursos = $cursoDAO->list();
?>

<div class="page-container">
    <div class="form-card">
        <h2 class="form-title text-center">Editar Perfil</h2> <!-- Centraliza o título -->

        <!-- Formulário envia para salvarEdicaoPerfil -->
        <form action="<?php echo BASEURL . '/controller/PerfilController.php?action=save'; ?>"
            method="POST" enctype="multipart/form-data" class="edit-form">

            <!-- Campo oculto com ID -->
            <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>">

            <!-- Nome -->
            <div class="mb-3">
                <label for="nomeCompleto" class="form-label">Nome completo</label>
                <input type="text" class="form-control" id="nomeCompleto" name="nomeCompleto"
                    value="<?php echo htmlspecialchars($usuario->getNomeCompleto() ?? ''); ?>" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email"
                    value="<?php echo htmlspecialchars($usuario->getEmail() ?? ''); ?>" required>
            </div>

            <!-- CPF -->
            <div class="mb-3">
                <label for="cpf" class="form-label">CPF</label>
                <input type="text" class="form-control" id="cpf" name="cpf"
                    value="<?php echo htmlspecialchars($usuario->getCpf() ?? ''); ?>" required>
            </div>

            <!-- Matrícula -->
            <div class="mb-3">
                <label for="matricula" class="form-label">Matrícula</label>
                <input type="text" class="form-control" id="matricula" name="matricula"
                    value="<?php echo htmlspecialchars($usuario->getMatricula() ?? ''); ?>" required>
            </div>

            <!-- Tipo de usuário (somente leitura) -->
            <div class="mb-3">
                <label for="tipoUsuario" class="form-label">Tipo de Usuário</label>
                <input type="text" class="form-control" id="tipoUsuario"
                    value="<?php echo htmlspecialchars($usuario->getTipoUsuario()); ?>" readonly>
                <input type="hidden" name="tipoUsuario" value="<?php echo htmlspecialchars($usuario->getTipoUsuario()); ?>">
            </div>

            <!-- Curso (somente leitura) -->
            <div class="mb-3">
                <label for="curso" class="form-label">Curso</label>
                <input type="text" class="form-control" id="curso"
                    value="<?php echo htmlspecialchars($usuario->getCurso()->getNome()); ?>" readonly>
                <input type="hidden" name="curso_id" value="<?php echo $usuario->getCurso()->getId(); ?>">
            </div>

            <!-- Senha do perfil -->
            <div class="mb-3">
                <label for="Senha" class="form-label">Senha</label>
                <input type="text" class="form-control" id="Senha"
                    value="<?php echo htmlspecialchars($usuario->getSenha()); ?>" readonly>
                <input type="hidden" name="Senha" value="<?php echo $usuario->getSenha(); ?>">
            </div>

            <!-- Foto de Perfil -->
            <div class="mb-3">
                <label for="foto" class="form-label">Foto de Perfil</label>
                <input type="file" class="form-control" id="foto" name="foto">
                <?php if (!empty($usuario->getFotoPerfil())): ?>
                    <p class="mt-2">Foto atual:</p>

                    <img class="foto-perfil" src="<?= BASEURL_ARQUIVOS . "/" . $usuario->getFotoPerfil(); ?>" alt="Foto de perfil" alt="Foto de perfil" width="120" class="rounded">

                <?php endif; ?>
            </div>

            <!-- Botão Salvar -->
            <div class="text-center">
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
        background-color: #d9426b;
    }
</style>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>