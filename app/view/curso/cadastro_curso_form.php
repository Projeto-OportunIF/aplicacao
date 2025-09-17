<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/cadastro_curso_form.css">
<h3 class="text-center">
    <?php if ($dados['id'] == 0) echo "Inserir";
    else echo "Alterar"; ?>
    Curso
</h3>

<img src="/aplicacao/app/view/img/cadastro_curso.png" alt="Ilustração" class="illustration">

<div class="container">

    <div class="row mt-4">

        <div class="col-md-6">
            <form id="frmCurso" method="POST"
                action="<?= BASEURL ?>/controller/CursoController.php?action=save">

                <div class="mb-3">
                    <label class="form-label" for="txtNome">Nome do Curso:</label>
                    <input class="form-control" type="text" id="txtNome" name="nome"
                        maxlength="70" placeholder="Informe o nome do curso"
                        value="<?php echo isset($dados['curso']) ? htmlspecialchars($dados['curso']->getNome()) : ''; ?>" />
                </div>

                <input type="hidden" id="hddId" name="id" value="<?= $dados['id']; ?>" />

                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Gravar</button>
                    <a href="<?= BASEURL ?>/controller/CursoController.php?action=list" class="btn btn-secondary" type="button">Voltar</a>
                </div>

            </form>
        </div>

        <div class="col-md-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>

    </div>

</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>