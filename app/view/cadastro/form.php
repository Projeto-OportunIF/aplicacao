<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema

require_once(__DIR__ . "/../include/header.php");
?>


<div class="container">
    <div class="left-panel">
        <span>seja bem- vindo ao</span>
        <div class="logo">
            <img src="<?= BASEURL ?>/view/img/cadastro1.png">
        </div>
        <p>
            Plataforma destinada à divulgação de oportunidades de estágios e projetos para os alunos do IFPR.
        </p>
    </div>

    <div class="form-wrapper">
        <h3>
            <?php if ($dados['id'] == 0) echo "Cadastro"; else echo "Alterar"; ?>
        </h3>

        <form id="frmUsuario" method="POST" action="<?= BASEURL ?>/controller/CadastroController.php?action=save">
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
                <select class="form-select" name="tipoUsuario" id="seltipoUsuario">
                    <option value="">Select</option>
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

            <div class="mb-3">
                <label class="form-label" for="txtmatricula">Número Matrícula ou SIAPE (Professor):</label>
                <input class="form-control" type="text" id="txtmatricula" name="matricula"
                    maxlength="70" placeholder="Informe a Matrícula"
                    value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getMatricula() : ''); ?>" />
            </div>

            <div class="mb-3">
                <label class="form-label" for="txtCpf">CPF:</label>
                <input class="form-control" type="text" id="txtcpf" name="cpf"
                    maxlength="70" placeholder="Informe o CPF"
                    value="<?php echo (isset($dados["usuario"]) ? $dados["usuario"]->getCpf() : ''); ?>" />
            </div>

            <div class="mb-3">
                <label class="form-label" for="selCurso">Curso:</label>
                <select class="form-select" name="curso" id="selCurso">
                    <option value="">Select</option>
                    <?php foreach ($dados["cursos"] as $curso): ?>
                        <option value="<?= $curso->getId() ?>"
                            <?php
                            if (isset($dados["usuario"]) &&
                                $dados["usuario"]->getCurso() != NULL &&
                                $dados["usuario"]->getCurso()->getId() == $curso->getId())
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

<style>
    * {
        box-sizing: border-box;
    }

    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #d3e2be;
    }

    .container {
        display: flex;
        min-height: 100vh;
        flex-wrap: wrap;
    }

    .left-panel {
        background-color: #c63d5d;
        color: white;
        flex: 1;
        min-width: 500px;
        padding: 60px 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: flex-start;
    }

    .left-panel span {
        font-size: 20px;
    }

    .left-panel .logo {
        margin: 10px 0;
    }

    .left-panel p {
        font-size: 16px;
        max-width: 300px;
    }

    .form-wrapper {
        background-color: #e2edcd;
        flex: 1;
        min-width: 300px;
        padding: 60px 80px;
    }

    .form-wrapper h3 {
        font-size: 43px;
        font-weight: 900;
        color: #c63d5d;
        text-align: center;
        margin-bottom: 34px;
        text-transform: uppercase;
        
    }

    form .form-label {
        font-weight: bold;
        color: #444;
        text-transform: uppercase;
        font-size: 12px;
        margin-bottom: 5px;
    }

    form input.form-control,
    form select.form-select {
        border: none;
        border-bottom: 2px solid black;
        border-radius: 0;
        padding: 10px 5px;
        background-color: transparent;
        margin-bottom: 20px;
        font-size: 14px;
        width: 100%;
        outline: none; 
        box-shadow: none;
        
    }

    form input::placeholder {
        color: #aaa;
    }

    .btn-success {
        background-color: #c63d5d;
        border: none;
        padding: 10px 25px;
        font-size: 16px;
        border-radius: 30px;
        color: white;
        width: 100%;
        max-width: 180px;
    }

    .btn-success:hover {
        background-color: #c63d5d;
    }

    .btn-secondary {
        margin-top: 30px;
    }

    .text-center {
        text-align: center;
    }

    .img-logo {
        max-width: 200%;
        height: 200%;
        margin: 10px 0;
    }

    @media (max-width: 768px) {
        .container {
            flex-direction: column;
        }

        .form-wrapper,
        .left-panel {
            padding: 30px;
            align-items: center;
        }

        .left-panel p {
            max-width: 100%;
            text-align: center;
        }

        .form-wrapper h3 {
            font-size: 24px;
        }
    }
</style>


<?php
require_once(__DIR__ . "/../include/footer.php");
?>

