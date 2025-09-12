<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<h3 class="text-center">
    <?php if ($dados['id'] == 0) echo "Inserir";
    else echo "Alterar"; ?>
    Usuário
</h3>

<div class="container">
    <div class="row" style="margin-top: 10px;">
        <div class="row" style="margin-top: 30px;">
            <div class="col-12">
                <a class="btn btn-secondary" href="<?= BASEURL ?>/controller/UsuarioController.php?action=list">Voltar</a>
            </div>
        </div>

        <div class="col-6">
            <form id="frmUsuario" method="POST" action="<?= BASEURL ?>/controller/UsuarioController.php?action=save">
                <div class="mb-3">
                    <label class="form-label" for="txtNomeCompleto">Nome Completo:</label>
                    <input class="form-control" type="text" id="txtNomeCompleto" name="nomeCompleto"
                        maxlength="70" placeholder="Informe o nome"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getNomeCompleto() : ''); ?>" />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtCpf">CPF:</label>
                    <input class="form-control" type="text" id="txtcpf" name="cpf"
                        maxlength="14" placeholder="000.000.000-00"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getCpf() : ''); ?>" />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtmatricula">Matrícula ou SIAPE:</label>
                    <input class="form-control" type="text" id="txtmatricula" name="matricula"
                        maxlength="70" placeholder="Informe a Matricula"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getMatricula() : ''); ?>" />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtemail">E-mail:</label>
                    <input class="form-control" type="text" id="txtemail" name="email"
                        maxlength="70" placeholder="Informe o e-mail"
                        value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getEmail() : ''); ?>" />
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
                </div>


                <?php if (isset($dados['resetarSenha']) && $dados['resetarSenha']): ?>
                    <div class="mb-3">
                        <label class="form-label">Senha (resetada para padrão)</label>
                        <input class="form-control" type="text" name="senha" value="<?= $dados['usuario']->getSenha() ?>" readonly>
                    </div>
                <?php else: ?>
                    <div class="mb-3">
                        <?php if (isset($dados["usuario"]) && $dados["usuario"]->getId() > 0): ?>
                            <label class="form-label">Senha (resetada para padrão)</label>
                        <?php else: ?>
                            <label class="form-label">Senha</label>
                        <?php endif; ?>
                        <input class="form-control" type="text" name="senha" value="<?= $dados['senhaPadrao'] ?>" readonly>
                    </div>
                <?php endif; ?>

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