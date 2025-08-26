<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<!-- Link para CSS externo -->
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/oportunidades.css">

<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />



<h3 class="text-center">
    <?php if ($dados['id'] == 0) echo "Inserir";
    else echo "Alterar"; ?>
    Oportunidade
</h3>


<div class="container">


    <div class="row" style="margin-top: 10px;">


        <div class="col-6">
            <form id="frmOportunidade" method="POST"
                action="<?= BASEURL ?>/controller/OportunidadeController.php?action=save">


                <input type="hidden" id="hddId" name="id"
                    value="<?= $dados['id']; ?>" />


                <div class="mb-3">
                    <label class="form-label" for="txtTitulo">Título:</label>
                    <input class="form-control" type="text" id="txtTitulo" name="titulo"
                        placeholder="Informe o título"
                        value="<?= isset($dados["oportunidade"]) ? $dados["oportunidade"]->getTitulo() : ''; ?>" />
                </div>


                <div class="mb-3">
                    <label class="form-label" for="txtDescricao">Descrição:</label>
                    <textarea class="form-control" id="txtDescricao" name="descricao"
                        placeholder="Informe a descrição"><?= isset($dados["oportunidade"]) ? $dados["oportunidade"]->getDescricao() : ''; ?></textarea>
                </div>


                <div class="mb-3">
                    <label class="form-label" for="selTipo">Tipo de Oportunidade:</label>
                    <select name="tipo" id="selTipo" class="form-select">
                        <option value="">Selecione o Tipo de Oportunidade</option>

                        <?php foreach (OportunidadeTipo::getAllAsArray() as $tipo): ?>
                            <option value="<?= $tipo ?>"
                                <?php
                                if (
                                    isset($dados["oportunidade"]) &&
                                    $dados["oportunidade"]->getTipoOportunidade() == $tipo
                                )
                                    echo "selected";
                                ?>>
                                <?= OportunidadeTipo::getLabel($tipo) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>


                    <div class="mb-3">
                        <label class="form-label" for="vaga">Quantidade de Vagas:</label>

                        <input type="number" class="form-control" name="vaga" id="vaga"
                            value="<?= isset($dados["oportunidade"]) ? $dados["oportunidade"]->getVaga() : '' ?>">
                    </div>

                </div>


                <div class="mb-3">
                    <label class="form-label" for="dataInicio">Data de Início:</label>
                    <input type="date" name="dataInicio" id="dataInicio" class="form-control"
                        value="<?= isset($dados['oportunidade']) ? $dados['oportunidade']->getDataInicio() : '' ?>">
                </div>


                <div class="mb-3">
                    <label class="form-label" for="dataFim">Data de Fim:</label>
                    <input type="date" name="dataFim" id="dataFim" class="form-control"
                        value="<?= isset($dados['oportunidade']) ? $dados['oportunidade']->getDataFim() : '' ?>">
                </div>

                <div class="mb-3 documento-seletor">
                    <label class="form-label" for="documento">Possui Documento em Anexo? </label>

                    <label class="switch">
                        <input class="checkbox" type="checkbox" value="false">
                        <span class="slider round"></span>
                    </label>
                </div>


                <div class="mb-3 documento-anexo">
                    <label class="form-label" for="documento">Documento Anexo (descreva separando por ponto e vírgula) :</label>
                    <input type="text" name="documento" id="documento" class="form-control"
                        value="<?= isset($dados['oportunidade']) ? $dados['oportunidade']->getDocumentoAnexo() : '' ?>">
                </div>


                <div class="mb-3">
                    <label class="form-label">Cursos:</label>
                    <div>
                        <?php foreach ($dados['cursos'] as $curso): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    name="cursos[]"
                                    value="<?= $curso->getId() ?>"
                                    <?php
                                    if (isset($dados['oportunidadeCursos'])) {
                                        foreach ($dados['oportunidadeCursos'] as $oc) {
                                            if ($oc->getId() == $curso->getId()) echo "checked";
                                        }
                                    }
                                    ?>>
                                <label class="form-check-label"><?= $curso->getNome() ?></label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>



                <div class="mt-3">
                    <button type="submit" class="btn btn-success">Salvar</button>
                </div>
            </form>
        </div>


        <div class="col-6">
            <?php require_once(__DIR__ . "/../include/msg.php"); ?>
        </div>
    </div>


    <div class="row" style="margin-top: 30px;">
        <div class="col-12">
            <a class="btn btn-secondary"
                href="<?= BASEURL ?>/controller/HomeController.php?action=homeProfessor">Voltar</a>
        </div>
    </div>
</div>

<script>
    let exibirCampoAnexos = false;
    let seletor = document.querySelector(".documento-seletor .checkbox");
    let anexos = document.querySelector(".documento-anexo");


    seletor.addEventListener("click", () => {
        exibirCampoAnexos = seletor.checked;

        if (exibirCampoAnexos == true) {
            anexos.style.display = "block";
        } else {
            anexos.style.display = "none";

        }
    });
</script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
<script>
    new FroalaEditor("#txtDescricao");
</script>


<?php
require_once(__DIR__ . "/../include/footer.php");
?>