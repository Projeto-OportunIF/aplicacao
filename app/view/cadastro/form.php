<?php
#Nome do arquivo: usuario/list.php
#Objetivo: interface para listagem dos usuários do sistema


require_once(__DIR__ . "/../include/header.php");
?>



<div class="container">
    <div class="left-panel">
        <span>seja bem- vindo ao</span>
        <div class="logo">
            <img src="<?= BASEURL ?>/view/img/logo.png">
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
   /* Define o corpo da página */
body {
    margin: 0; /* Remove espaçamento externo do navegador */
    font-family: 'Arial', sans-serif; /* Fonte principal do conteúdo */
    background-color: #c1dba5; /* Cor de fundo geral */
}


/* Contêiner principal que agrupa o painel e o formulário */
.container {
    display: flex; /* Coloca os filhos lado a lado (painel e formulário) */
    height: 100vh; /* Altura total da tela */
    margin: 0;     /* Remove margens padrão */
    padding: 0;    /* Remove preenchimento */
    background-color: #c1dba5; /* Cor de fundo */
}


/* Painel da esquerda */
.left-panel {
    background-color: #c23956; /* Cor de fundo vermelho escuro */
    color: white;              /* Cor do texto */
    padding: 60px 40px;        /* Espaço interno (top/bottom 60px, left/right 40px) */
    width: 70%;                /* Ocupa 40% da largura da tela */
    display: flex;             /* Layout flexível */
    flex-direction: column;   /* Elementos empilhados verticalmente */
    align-items: center;      /* Centraliza horizontalmente os filhos */
    border-top-right-radius: 20px;  /* Arredonda o canto superior direito */
    border-bottom-right-radius: 20px; /* Arredonda o canto inferior direito */
    height: 103vh;            /* Garante que o painel ocupe toda a altura da tela */
    box-sizing: border-box;   /* Inclui padding dentro da altura */
}


/* Texto de boas-vindas */
.left-panel span {
    font-size: 20px;        /* Tamanho da fonte */
    margin-bottom: 20px;    /* Espaço inferior */
    font-weight: 500;       /* Peso da fonte (meio negrito) */
    text-align: center;     /* Centraliza o texto */
}


/* Logo */
.left-panel .logo img {
    width: 380px;           /* Largura fixa da imagem */
    margin-bottom: 20px;    /* Espaço abaixo da imagem */
}


/* Parágrafo de descrição */
.left-panel p {
    font-size: 20px;        /* Tamanho da fonte do texto */
    line-height: 1.5;       /* Espaçamento entre linhas */
}


/* Formulário de cadastro */
.form-wrapper {
    width: 900px;           /* Largura do formulário */
    background-color: #ecf7dc; /* Fundo verde claro */
    padding: 40px;          /* Espaço interno */
    display: flex;          /* Flex para layout vertical dos campos */
    flex-direction: column;
    justify-content: center;
    border-radius: 20px;    /* Borda arredondada */
    margin-left: 100px;     /* Aproxima da esquerda (mais perto do painel) */
    margin-top: 40px;       /* Distância do topo */
}


/* Título "Cadastro" ou "Alterar" */
.form-wrapper h3 {
    color: #c23956;         /* Cor do texto */
    font-weight: bold;
    font-size: 40px;
    margin-bottom: 30px;
    text-align: center;
}


/* Rótulos dos campos */
.form-label {
    font-weight: bold;
    font-size: 13px;
    margin-bottom: 1px;
}


/* Estilo dos inputs e selects */
.form-control, .form-select {
    border: none;
    border-bottom: 2px solid #333; /* Apenas a borda inferior */
    background-color: transparent;
    padding: 2px;
    width: 100%;
    font-size: 14px;
    margin-bottom: 20px;
}


/* Estilo especial para select */
.form-select {
    appearance: none;
    background-color: #f1e9f6;
    border: none;
    height: 40px;
}


/* Botão de salvar/cadastrar */
.btn-success {
    background-color: #c23956;
    border: none;
    color: white;
    padding: 10px 40px;
    font-weight: bold;
    border-radius: 20px;
    transition: 0.3s;
     margin-bottom: 30px;
}


/* Hover do botão */
.btn-success:hover {
    background-color: #a52e45;
}


/* Botão de voltar */
.btn-secondary {
    margin-top: 5px;
}


/* Alinha os botões ao centro */
.text-center {
    text-align: center;
}


</style>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>
