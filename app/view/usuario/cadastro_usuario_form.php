<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/cadastro_usuario_form.css">

<div class="container">
    <!-- Coluna esquerda com imagem -->
    <div class="banner">
        <img src="<?= BASEURL ?>/view/img/cadastro_usuario.png" alt="Cadastro de usuários">
    </div>
    <div class="formulario">
        <h3 class="titulo-form">
            <?php if ($dados['id'] == 0) echo "Inserir";
            else echo "Alterar"; ?> Usuário
        </h3>

        <div class="row" style="margin-top: 10px;">
            <div class="col-12">
                <a class="btn-voltar" href="<?= BASEURL ?>/controller/UsuarioController.php?action=list">Voltar</a>
            </div>
        </div>

        <div class="col-6">
            <form id="frmUsuario" method="POST" action="<?= BASEURL ?>/controller/UsuarioController.php?action=save">
                <div class="mb-3">
                    <label class="form-label" for="txtNomeCompleto">Nome Completo:</label>
                    <input class="form-control" type="text" id="txtNomeCompleto" name="nomeCompleto"
                        maxlength="70" placeholder="Informe o nome"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getNomeCompleto() : ''); ?>" />

                    <?php if (isset($dados['erros']['nome'])): ?>
                        <span class="form_error_message"><?= $dados['erros']['nome'] ?></span>
                    <?php endif; ?>

                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtCpf">CPF:</label>
                    <input class="form-control" type="text" id="txtcpf" name="cpf"
                        maxlength="14" placeholder="000.000.000-00"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getCpf() : ''); ?>" />

                    <?php if (isset($dados['erros']['cpf'])): ?>
                        <span class="form_error_message"><?= $dados['erros']['cpf'] ?></span>
                    <?php endif; ?>

                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtmatricula">Matrícula ou SIAPE:</label>
                    <input class="form-control" type="text" id="txtmatricula" name="matricula"
                        maxlength="70" placeholder="Informe a Matricula"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getMatricula() : ''); ?>" />

                    <?php if (isset($dados['erros']['matricula'])): ?>
                        <span class="form_error_message"><?= $dados['erros']['matricula'] ?></span>
                    <?php endif; ?>

                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtemail">E-mail:</label>
                    <input class="form-control" type="text" id="txtemail" name="email"
                        maxlength="70" placeholder="Informe o e-mail"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEmail() : ''); ?>" />

                    <?php if (isset($dados['erros']['email'])): ?>
                        <span class="form_error_message"><?= $dados['erros']['email'] ?></span>
                    <?php endif; ?>

                </div>

                 <div class="mb-3">
                    <label class="form-label" for="seltipoUsuario">Tipo de usuário:</label>
                    <select class="form-select" name="tipoUsuario" id="seltipoUsuario">
                        <option value="">Selecione o usuario</option>
                        <?php foreach ($dados["tipoUsuario"] as $tipoUsuario): ?>
                            <option value="<?= $tipoUsuario ?>"
                                <?php
                                if (isset($dados["usuario"]) && $dados["usuario"]->getTipoUsuario() == $tipoUsuario)
                                    echo "selected";
                                ?>>
                                <?= $tipoUsuario ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <?php if (isset($dados['erros']['tipousu'])): ?>
                        <span class="form_error_message"><?= $dados['erros']['tipousu'] ?></span>
                    <?php endif; ?>

                </div>

                <div class="mb-3">
                    <label class="form-label" for="selCurso">Curso (somente para alunos):</label>
                    <select class="form-select" name="curso" id="selCurso">
                        <option value="">Selecione o curso</option>
                        <?php foreach ($dados["cursos"] as $curso): ?>
                            <option value="<?= $curso->getId() ?>"
                                <?php
                                if (isset($dados["usuario"]) && $dados["usuario"]->getCurso() != NULL && $dados["usuario"]->getCurso()->getId() == $curso->getId())
                                    echo "selected";
                                ?>>
                                <?= $curso->getNome() ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <?php if (isset($dados['erros']['curso'])): ?>
                        <span class="form_error_message"><?= $dados['erros']['curso'] ?></span>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <?php if (isset($dados['resetarSenha']) && $dados['resetarSenha']): ?>
                        <!-- Edição com reset de senha -->
                        <label class="form-label">Senha (resetada para padrão)</label>
                        <input class="form-control" type="text" name="senha"
                            value="<?= isset($dados['senhaPadrao']) ? $dados['senhaPadrao'] : '' ?>" readonly>
                    <?php else: ?>
                        <?php if (isset($dados["usuario"]) && $dados["usuario"]->getId() > 0): ?>
                            <!-- Edição sem reset -->
                            <label class="form-label">Senha</label>
                            <input class="form-control" type="text" name="senha"
                                value="<?= isset($dados['senhaPadrao']) ? $dados['senhaPadrao'] : '' ?>" readonly>
                        <?php else: ?>
                            <!-- Cadastro de novo usuário -->
                            <label class="form-label">Senha</label>
                            <input class="form-control" type="text" value="<?= $dados['senhaPadrao'] ?? 'IFPR@Senha123' ?>" readonly>
                            <input type="hidden" name="senha" value="<?= $dados['senhaPadrao'] ?? 'IFPR@Senha123' ?>">

                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <input type="hidden" id="hddId" name="id" value="<?= $dados['id']; ?>" />

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Gravar</button>
                </div>
            </form>
        </div>

        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
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