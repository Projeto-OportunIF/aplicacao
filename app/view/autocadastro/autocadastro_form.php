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
                <label class="form-label" for="txtNomeCompleto">Nome:</label>
                <input class="form-control" type="text" id="txtNomeCompleto" name="nomeCompleto"
                    maxlength="70" placeholder="Informe o nome"
                    value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getNomeCompleto() : ''); ?>" />
            </div>

            <div class="mb-3">
                <label class="form-label" for="txtemail">Email:</label>
                <input class="form-control" type="text" id="txtemail" name="email"
                    maxlength="70" placeholder="Informe o e-mail"
                    value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEmail() : ''); ?>" />
            </div>

            <div class="mb-3">
                <label class="form-label" for="seltipoUsuario">Tipo de Usuário:</label>
                <select class="form-select" name="tipoUsuario" id="seltipoUsuario" required>
                    <option value="" disabled selected>Selecione o seu tipo de usuário</option>
                    <option value="Aluno">Aluno</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" for="txtmatricula">Número Matrícula :</label>
                <input class="form-control" type="text" id="txtmatricula" name="matricula"
                    maxlength="70" placeholder="Informe a Matrícula"
                    value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getMatricula() : ''); ?>" />
            </div>

            <div class="mb-3">
                <label class="form-label" for="txtcpf">CPF:</label>
                <input class="form-control" type="text" id="txtcpf" name="cpf"
                    maxlength="14" placeholder="000.000.000-00"
                    value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getCpf() : ''); ?>" />
            </div>

            <div class="mb-3">
                <label class="form-label" for="selCurso">Curso:</label>
                <select class="form-select" name="curso" id="selCurso">
                    <option value="">Selecione a qual curso você faz parte</option>
                    <?php foreach ($dados["cursos"] as $curso): ?>
                        <option value="<?= $curso->getId() ?>"
                            <?php
                            if (
                                isset($dados["usuario"]) &&
                                $dados["usuario"]->getCurso() != NULL &&
                                $dados["usuario"]->getCurso()->getId() == $curso->getId()
                            )
                                echo "selected";
                            ?>>
                            <?= $curso->getNome() ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label" for="txtSenha">Crie uma senha:</label>
                <input class="form-control" type="password" id="txtSenha" name="senha"
                    maxlength="90" placeholder="Informe a senha"
                    value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getSenha() : ''); ?>" />
            </div>

            <div class="mb-3">
                <label class="form-label" for="txtconf_senha">Confirme a senha:</label>
                <input class="form-control" type="password" id="txtconf_senha" name="conf_senha"
                    maxlength="15" placeholder="Informe a confirmação da senha"
                    value="<?php echo isset($dados['confSenha']) ? $dados['confSenha'] : ''; ?>" />
            </div>

            <input type="hidden" id="hddId" name="id" value="<?= $dados['id']; ?>" />

            <div class="text-center">
                <button type="submit" class="btn btn-success">Criar</button>
            </div>
        </form>

        <div class="mt-3">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>

        <div class="text-center">
            <a class="btn btn-secondary" href="<?= BASEURL ?>/controller/LoginController.php?action=login">Voltar</a>
        </div>
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
</script>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>