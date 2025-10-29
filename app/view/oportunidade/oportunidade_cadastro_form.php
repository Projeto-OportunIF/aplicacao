<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<!-- Link para CSS externo -->
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/oportunidade_cadastro.css">
<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />

<h3 class="text-center">
    <?= $dados['id'] == 0 ? "Inserir" : "Alterar" ?> Oportunidade
</h3>

<div class="container">
    <div class="row" style="margin-top: 30px;">
        <div class="col-12">
            <a href="<?= BASEURL ?>/controller/HomeController.php?action=homeProfessor" class="btn-voltar">
                <i class="bi bi-arrow-left-circle"></i> Voltar
            </a>
        </div>
    </div>

    <div class="row" style="margin-top: 10px;">
        <div class="col-6">
            <form id="frmOportunidade" method="POST" action="<?= BASEURL ?>/controller/OportunidadeController.php?action=save">
                <input type="hidden" id="hddId" name="id" value="<?= $dados['id']; ?>" />

                <!-- Campos básicos -->
                <div class="mb-3">
                    <label class="form-label" for="txtTitulo">Título:</label>
                    <input class="form-control" type="text" id="txtTitulo" name="titulo" placeholder="Informe o título"
                        value="<?= isset($dados["oportunidade"]) ? $dados["oportunidade"]->getTitulo() : ''; ?>" />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="txtDescricao">Descrição:</label>
                    <textarea class="form-control" id="txtDescricao" name="descricao"
                        placeholder="Informe a descrição"><?= isset($dados["oportunidade"]) ? $dados["oportunidade"]->getDescricao() : ''; ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="professor_responsavel">Professor Responsável:</label>
                    <input class="form-control" type="text" id="professor_responsavel" name="professor_responsavel"
                        placeholder="Informe o professor responsável"
                        value="<?= isset($dados["oportunidade"]) ? $dados["oportunidade"]->getProfessorResponsavel() : ''; ?>" />
                </div>

                <div class="mb-3">
                    <label class="form-label" for="selTipo">Tipo de Oportunidade:</label>
                    <select name="tipo" id="selTipo" class="form-select">
                        <option value="">Selecione o Tipo de Oportunidade</option>
                        <?php foreach (OportunidadeTipo::getAllAsArray() as $tipo): ?>
                            <option value="<?= $tipo ?>" <?= isset($dados["oportunidade"]) && $dados["oportunidade"]->getTipoOportunidade() == $tipo ? 'selected' : '' ?>>
                                <?= OportunidadeTipo::getLabel($tipo) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="vaga">Quantidade de Vagas:</label>
                    <input type="number" class="form-control" name="vaga" id="vaga"
                        value="<?= isset($dados["oportunidade"]) ? $dados["oportunidade"]->getVaga() : '' ?>">
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

                <!-- Checkbox Documento Anexo -->
                <div class="mb-3 documento-seletor">
                    <label class="form-label" for="documento">Possui Documento em Anexo?</label>
                    <label class="switch">
                        <input class="checkbox" type="checkbox" name="temDocumento" value="1"
                            <?= isset($dados['oportunidade']) && $dados['oportunidade']->getDocumentoAnexo() != "" ? 'checked' : '' ?>>
                        <span class="slider round"></span>
                    </label>
                </div>

                <!-- Campo descrição do documento -->
                <div class="mb-3 documento-anexo">
                    <label class="form-label" for="documento">(Descreva o documento que deve ser anexado):</label>
                    <input type="text" name="documento" id="documento" class="form-control"
                        value="<?= isset($dados['oportunidade']) ? $dados['oportunidade']->getDocumentoAnexo() : '' ?>">
                </div>

                <!-- Cursos -->
                <div class="mb-3">
                    <label class="form-label">Cursos:</label>
                    <div>
                        <?php foreach ($dados['cursos'] as $curso): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="cursos[]" value="<?= $curso->getId() ?>"
                                    <?= isset($dados['oportunidadeCursos']) && in_array($curso->getId(), array_map(fn($oc) => $oc->getId(), $dados['oportunidadeCursos'])) ? 'checked' : '' ?>>
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
</div>

<script>
    // Checkbox e campo de documento
    const seletorCheckbox = document.querySelector(".documento-seletor .checkbox");
    const anexosDiv = document.querySelector(".documento-anexo");
    const inputDocumento = document.getElementById("documento");

    // Mostrar/esconder campo ao carregar
    anexosDiv.style.display = seletorCheckbox.checked ? "block" : "none";

    // Atualiza ao clicar no checkbox
    seletorCheckbox.addEventListener("click", () => {
        if (seletorCheckbox.checked) {
            anexosDiv.style.display = "block";
        } else {
            anexosDiv.style.display = "none";
            inputDocumento.value = ""; // Limpa campo
        }
    });

    // Tipo de oportunidade: esconde seletor se for ESTÁGIO
    const tipoSelect = document.getElementById("selTipo");
    const seletorDiv = document.querySelector(".documento-seletor");

    function atualizarCampoDocumento() {
        if (tipoSelect.value === "ESTAGIO") {
            seletorDiv.style.display = "none";
            anexosDiv.style.display = "none";
            seletorCheckbox.checked = false;
            inputDocumento.value = "";
        } else {
            seletorDiv.style.display = "block";
            anexosDiv.style.display = seletorCheckbox.checked ? "block" : "none";
        }
    }

    tipoSelect.addEventListener("change", atualizarCampoDocumento);
    atualizarCampoDocumento();
</script>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
<script>
    new FroalaEditor("#txtDescricao");
</script>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>