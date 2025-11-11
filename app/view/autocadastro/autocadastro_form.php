<?php
require_once(__DIR__ . "/../include/header.php");
?>

<!-- Link para CSS externo -->
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/autocadastro.css">

<div class="container">
    <div class="left-panel">
        <span>Seja bem-vindo ao</span>
        <div class="logo">
            <img src="<?= BASEURL ?>/view/img/logo.png">
        </div>
        <h5>
            Plataforma destinada à divulgação de oportunidades de estágios e projetos para os alunos do IFPR.
        </h5>
    </div>

    <div class="form-wrapper">
        <h3>
            <?php if ($dados['id'] == 0) echo "Cadastro";
            else echo "Alterar"; ?>
        </h3>

        <form id="frmUsuario" method="POST" action="<?= BASEURL ?>/controller/AutoCadastroController.php?action=save">
            <div class="mb-3">
                <label class="form-label" for="txtNomeCompleto">Nome Completo:</label>
                <input class="form-control" type="text" id="txtNomeCompleto" name="nomeCompleto"
                    maxlength="70" placeholder="Informe o nome completo"
                    value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getNomeCompleto() : ''); ?>" />

                <?php if (isset($dados['erros']['nome'])): ?>
                    <span class="form_error_message"><?= $dados['erros']['nome'] ?></span>
                <?php endif; ?>


            </div>

            <div class="mb-3">
                <label class="form-label" for="txtemail">Email:</label>
                <input class="form-control" type="text" id="txtemail" name="email"
                    maxlength="70" placeholder="Informe o e-mail"
                    value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEmail() : ''); ?>" />

                <?php if (isset($dados['erros']['email'])): ?>
                    <span class="form_error_message"><?= $dados['erros']['email'] ?></span>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label" for="txtmatricula">Número Matrícula :</label>
                <input class="form-control" type="text" id="txtmatricula" name="matricula"
                    maxlength="70" placeholder="Informe a Matrícula"
                    value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getMatricula() : ''); ?>" />

                <?php if (isset($dados['erros']['matricula'])): ?>
                    <span class="form_error_message"><?= $dados['erros']['matricula'] ?></span>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label" for="txtcpf">CPF:</label>
                <input class="form-control" type="text" id="txtcpf" name="cpf"
                    maxlength="14" placeholder="000.000.000-00"
                    value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getCpf() : ''); ?>" />


                <?php if (isset($dados['erros']['cpf'])): ?>
                    <span class="form_error_message"><?= $dados['erros']['cpf'] ?></span>
                <?php endif; ?>

            </div>

            <div class="mb-3">
                <label class="form-label" for="selCurso">Curso:</label>
                <select class="form-select" name="curso" id="selCurso">
                    <option value="">Selecione a qual curso você faz parte</option>
                    <?php foreach ($dados['cursos'] as $curso): ?>
                        <?php
                        // Verifica se há curso selecionado previamente
                        $cursoSelecionado = '';

                        // Se veio do POST (por exemplo, após erro de validação)
                        if (isset($_POST['curso']) && $_POST['curso'] == $curso->getId()) {
                            $cursoSelecionado = 'selected';
                        }

                        // Se veio do banco (por exemplo, ao editar oportunidade)
                        elseif (isset($dados['oportunidadeCursos'])) {
                            foreach ($dados['oportunidadeCursos'] as $oc) {
                                if ($oc->getIdCurso() == $curso->getId()) {
                                    $cursoSelecionado = 'selected';
                                    break;
                                }
                            }
                        }
                        ?>
                        <option value="<?= $curso->getId() ?>" <?= $cursoSelecionado ?>>
                            <?= $curso->getNome() ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <?php if (isset($dados['erros']['curso'])): ?>
                    <span class="form_error_message"><?= $dados['erros']['curso'] ?></span>
                <?php endif; ?>
            </div>


            <div class="mb-3 position-relative">
                <label class="form-label" for="txtSenha">Crie uma senha:</label>
                <input class="form-control" type="password" id="txtSenha" name="senha"
                    maxlength="90" placeholder="A senha deve ser forte"
                    value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getSenha() : ''); ?>" />
                <span class="toggle-password" data-target="txtSenha" style="position:absolute; right:2px; top:23px; cursor:pointer;font-size: 20px;">👁️</span>

                <?php if (isset($dados['erros']['senha'])): ?>
                    <span class="form_error_message"><?= $dados['erros']['senha'] ?></span>
                <?php endif; ?>
            </div>

            <div class="mb-3 position-relative">
                <label class="form-label" for="txtconf_senha">Confirme a senha:</label>
                <input class="form-control" type="password" id="txtconf_senha" name="conf_senha"
                    maxlength="15" placeholder="Informe a confirmação da senha"
                    value="<?php echo isset($dados['confSenha']) ? $dados['confSenha'] : ''; ?>" />
                <span class="toggle-password" data-target="txtconf_senha" style="position:absolute;  right:2px; top:23px; cursor:pointer;font-size: 20px;">👁️</span>

                <?php if (isset($dados['erros']['confsenha'])): ?>
                    <span class="form_error_message"><?= $dados['erros']['confsenha'] ?></span>
                <?php endif; ?>

            </div>

            <input type="hidden" id="hddId" name="id" value="<?= $dados['id']; ?>" />

            <div class="text-center mt-5 d-flex justify-content-evenly">

                <a class="btn btn-secondary" href="<?= BASEURL ?>/controller/LoginController.php?action=login">Voltar</a>

                <button type="submit" class="btn btn-success">Criar</button>
            </div>
        </form>

        <!--
        <div class="text-center">
            <a class="btn btn-secondary" href="<?= BASEURL ?>/controller/LoginController.php?action=login">Voltar</a>
        </div>
        -->

    </div>
</div>

<!-- Script para máscara de CPF -->
<script>
    const cpfInput = document.getElementById('txtcpf');

    cpfInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length > 11) value = value.slice(0, 11);

        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d)/, '$1.$2');
        value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');

        e.target.value = value;
    });

    // Permite colar e já formatar corretamente
    cpfInput.addEventListener('paste', function(e) {
        e.preventDefault();
        let pastedData = (e.clipboardData || window.clipboardData).getData('text');
        pastedData = pastedData.replace(/\D/g, '');
        e.target.value = pastedData.slice(0, 11);
        cpfInput.dispatchEvent(new Event('input'));
    });

    // Toggle olho da senha
    document.addEventListener("DOMContentLoaded", function() {
        const togglePassword = document.querySelectorAll(".toggle-password");
        togglePassword.forEach(function(eye) {
            const targetId = eye.getAttribute("data-target");
            const input = document.getElementById(targetId);

            eye.addEventListener("click", function() {
                input.type = (input.type === "password") ? "text" : "password";
            });
        });
    });
</script>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>