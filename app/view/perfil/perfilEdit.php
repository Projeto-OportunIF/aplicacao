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

# Lista de tipos de usuário
$tiposUsuario = ["Aluno", "Professor", "Administrador"];

# Lista todos os cursos
$cursos = $cursoDAO->list();
?>

<div class="page-container">
    <div class="form-card">
        <h2 class="form-title">Editar Perfil</h2>
        <form action="<?php echo BASEURL . '/controller/UsuarioController.php?action=atualizar'; ?>" method="POST" enctype="multipart/form-data">
            
            <!-- Campo oculto com ID -->
            <input type="hidden" name="id" value="<?php echo $usuario->getId(); ?>">

            <!-- Nome -->
            <div class="mb-3">
                <label for="nome" class="form-label">Nome completo</label>
                <input type="text" class="form-control" id="nome" name="nome" 
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

            <!-- Tipo de usuário -->
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo de Usuário</label>
                <select class="form-select" id="tipo" name="tipo" required>
                    <?php foreach ($tiposUsuario as $tipo): ?>
                        <option value="<?php echo $tipo; ?>" 
                            <?php echo ($usuario->getTipoUsuario() === $tipo) ? 'selected' : ''; ?>>
                            <?php echo $tipo; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Curso -->
            <div class="mb-3">
                <label for="curso" class="form-label">Curso</label>
                <select class="form-select" id="curso" name="curso_id">
                    <option value="">-- Selecione --</option>
                    <?php foreach ($cursos as $curso): ?>
                        <option value="<?php echo $curso['id']; ?>" 
                            <?php echo ($usuario->getCurso()->getId() == $curso['id']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($curso['nome']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Foto de Perfil -->
            <div class="mb-3">
                <label for="foto" class="form-label">Foto de Perfil</label>
                <input type="file" class="form-control" id="foto" name="foto">
                <?php if (!empty($usuario->getFotoPerfil())): ?>
                    <p class="mt-2">Foto atual:</p>
                    <img src="<?php echo BASEURL . '/uploads/' . $usuario->getFotoPerfil(); ?>" 
                         alt="Foto de perfil" width="120" class="rounded">
                <?php endif; ?>
            </div>

            <!-- Botão -->
            <div class="btn-submit">
                <button type="submit" class="btn-submit">Salvar Alterações</button>
            </div>
        </form>
    </div>
</div>

<!-- CSS -->
<style>
    body {
    background-color: #a9cba5;
    font-family: Arial, sans-serif;
}

/* Container da página */
.page-container {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 40px 20px;
}

/* Card do formulário */
.form-card {
    background: #e3f0d9;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    width: 100%;
    max-width: 600px;
}

/* Título */
.form-title {
    text-align: center;
    font-size: 26px;
    font-weight: bold;
    color: #b92b4c;
    margin-bottom: 25px;
}

/* Labels */
.form-label {
    font-weight: bold;
    color: #333;
    margin-bottom: 5px;
    display: block;
}

/* Inputs e selects (sobrescreve bootstrap levemente) */
.form-control, 
.form-select {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #999;
    margin-bottom: 15px;
    font-size: 15px;
    background-color: #fff;
}

.form-control:focus, 
.form-select:focus {
    border-color: #b92b4c;
    outline: none;
    box-shadow: 0 0 5px rgba(185,43,76,0.5);
}

/* =====================
   BOTÃO DE SALVAR
===================== */
.btn-submit {
    background-color: #b92b4c !important;
    color: #fff !important;
    border: none !important;
    padding: 12px 25px !important;
    border-radius: 25px !important;
    font-size: 16px !important;
    font-weight: bold !important;
    cursor: pointer !important;
    transition: 0.3s;
    display: block !important;
    margin: 20px auto 0 auto !important;
    text-align: center !important;
}

.btn-submit:hover {
    background-color: #9d2340 !important;
}

/* Centraliza a div do botão */
.button-container {
    text-align: center;
}

/* Foto de perfil arredondada */
img.rounded {
    border-radius: 10px;
    margin-top: 10px;
    border: 2px solid #ccc;
}
    
</style>

<?php
 require_once(__DIR__ . "/../include/footer.php");
?>