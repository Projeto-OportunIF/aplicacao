<?php
# Carrega o cabeçalho do sistema
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");


$homeEditar = HOME_PAGE_EDITAR;
$homePage = HOME_PAGE_ADMIN;
if ($_SESSION[SESSAO_USUARIO_TIPO] == UsuarioTipo::ALUNO)
    $homePage = HOME_PAGE_ALUNO;
elseif ($_SESSION[SESSAO_USUARIO_TIPO] == UsuarioTipo::PROFESSOR)
    $homePage = HOME_PAGE_PROFESSOR;
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/perfil.css">

        <div class="perfil-container">
            <h3 class="text-center">Perfil</h3>

            <div class="perfil-info">
            <div><span class="info-label">NOME COMPLETO:</span> <?= $dados['usuario']->getNomeCompleto() ?></div>
            <div><span class="info-label">EMAIL:</span> <?= $dados['usuario']->getEmail() ?></div>
            <div><span class="info-label">TIPO DE USUÁRIO:</span> <?= $dados['usuario']->getTipoUsuario() ?></div>
            <?php if ($dados['usuario']->getTipoUsuario() === 'ALUNO') { ?>
                <div><span class="info-label">NÚMERO MATRÍCULA:</span> <?= $dados['usuario']->getMatricula() ?></div>
                <div><span class="info-label">CURSO:</span> 
                    <?php 
                    echo ($dados['usuario']->getCurso() && $dados['usuario']->getCurso()->getNome()
                        ? $dados['usuario']->getCurso()->getNome()
                        : "Curso não informado");
                    ?>
                </div>
            <?php } ?>
            <div><span class="info-label">CPF:</span> <?= $dados['usuario']->getCpf() ?></div>

        </div>

           

        <form id="frmUsuario" method="POST"
            action="<?= BASEURL ?>/controller/PerfilController.php?action=save"
            enctype="multipart/form-data">

            <input type="hidden" name="fotoAnterior" value="<?= $dados['usuario']->getFotoPerfil() ?>">


            <div class="foto-upload-container">
                <label for="txtFoto">
                    <img src="https://img.icons8.com/ios-glyphs/30/ffffff/plus.png" />
                    <div>escolher foto de perfil.</div>
                </label>

                <input type="file" id="txtFoto" name="fotoPerfil" 
                    accept=".png, .jpg, .jpeg" 
                    onchange="document.getElementById('frmUsuario').submit();">

                <?php if (!empty($_SESSION['erro_foto'])): ?>
                    <div class="erro-validacao">
                        <i class="bi bi-exclamation-triangle"></i>
                        <p><?= htmlspecialchars($_SESSION['erro_foto'], ENT_QUOTES, 'UTF-8'); ?></p>
                    </div>
                    <?php unset($_SESSION['erro_foto']); ?>
                <?php endif; ?>
            </div>

          <div class="botoes-container">
    <a href="<?= $homePage ?>" class="botao-voltar">Voltar</a>

    <a href="<?php echo BASEURL . '/controller/PerfilController.php?action=editarPerfil'; ?>" 
       class="botao-editar">
       Editar dados pessoais
    </a>
</div>

             

        </form>
    </div>
</div>

<script>
    function toggleSidebar() {
        var sidebar = document.getElementById("sidebar");
        sidebar.style.width = (sidebar.style.width === "250px") ? "0" : "250px";
    }
</script>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>