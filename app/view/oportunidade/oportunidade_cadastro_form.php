<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<!-- Link para CSS externo -->
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/oportunidade_cadastro_formm.css">
<link href="https://cdn.jsdelivr.net/npm/froala-editor@latest/css/froala_editor.pkgd.min.css" rel="stylesheet" type="text/css" />


<h3 class="text-center">
    <?= $dados['id'] == 0 ? "Inserir" : "Alterar" ?> Oportunidade
</h3>

<div class="container">
    <div class="row" style="margin-top: 10px; display: flex; justify-content: center;">
        <div class="col-lg-6">
            <a href="<?= BASEURL ?>/controller/HomeController.php?action=homeProfessor" class="btn-voltar">
                <i class="bi bi-arrow-left-circle"></i> Voltar
            </a>
        </div>

        <div class="row" style="margin-top: 10px; display: flex; justify-content: center;">
            <div class="col-12 col-md-8 col-lg-6">
                <form id="frmOportunidade" method="POST" enctype="multipart/form-data" action="<?= BASEURL ?>/controller/OportunidadeController.php?action=save">
                    <input type="hidden" id="hddId" name="id" value="<?= $dados['id']; ?>" />

                    <div class="mb-3">
                        <label class="form-label" for="txtTitulo">
                            Título: <span id="contTitulo">0/55 caracteres</span>
                        </label>

                        <input class="form-control" type="text" id="txtTitulo" name="titulo" maxlength="55" placeholder="Informe o título"
                            value="<?= isset($dados["oportunidade"]) ? $dados["oportunidade"]->getTitulo() : ''; ?>" />

                        <?php if (isset($dados['erros']['titulo'])): ?>
                            <span class="form_error_message"><?= $dados['erros']['titulo'] ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="txtDescricao">Descrição:</label>
                        <textarea class="form-control" id="txtDescricao" name="descricao"
                            placeholder="Informe a descrição"><?= isset($dados["oportunidade"]) ? $dados["oportunidade"]->getDescricao() : ''; ?></textarea>

                        <?php if (isset($dados['erros']['descricao'])): ?>
                            <span class="form_error_message"><?= $dados['erros']['descricao'] ?></span>
                        <?php endif; ?>

                    </div>


                    <div class="mb-3">
                        <label class="form-label" for="documentoEdital">Documento de Edital da Oportunidade:</label>
                        <input class="form-control" type="file" id="documentoEdital" name="documentoEdital" accept=".pdf,.doc,.docx" />

                        <?php if (isset($dados['erros']['documentoEdital'])): ?>
                            <span class="form_error_message"><?= $dados['erros']['documentoEdital'] ?></span>
                        <?php endif; ?>

                        <?php if (isset($dados["oportunidade"]) && $dados["oportunidade"]->getDocumentoEdital()): ?>
                            <p>
                                <strong class="titulo-doc">Documento Edital Atual:</strong>
                                <a href="<?= BASEURL ?>/../uploads/<?= trim($dados["oportunidade"]->getDocumentoEdital()) ?>"
                                    target="_blank"
                                    class="link-doc ms-2">
                                    <i class="bi bi-file-earmark-text"></i>
                                    Edital da sua oportunidade
                                </a>
                            </p>


                            <input type="hidden"
                                name="documentoEditalExistente"
                                value="<?= htmlspecialchars($dados["oportunidade"]->getDocumentoEdital()) ?>">
                        <?php endif; ?>


                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="professor">Professor Responsável:</label>
                        <input class="form-control" type="text" id="professor" name="professor"
                            placeholder="Informe o professor responsável"
                            value="<?= isset($dados["oportunidade"]) ? $dados["oportunidade"]->getProfessor() : ''; ?>" />


                            

                        <?php if (isset($dados['erros']['profresponsavel'])): ?>
                            <span class="form_error_message"><?= $dados['erros']['profresponsavel'] ?></span>
                        <?php endif; ?>

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

                        <?php if (isset($dados['erros']['tipooport'])): ?>
                            <span class="form_error_message"><?= $dados['erros']['tipooport'] ?></span>
                        <?php endif; ?>

                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="vaga">Quantidade de Vagas:</label>
                        <input type="number" class="form-control" name="vaga" id="vaga"
                            value="<?= isset($dados["oportunidade"]) ? $dados["oportunidade"]->getVaga() : '' ?>">

                        <?php if (isset($dados['erros']['vaga'])): ?>
                            <span class="form_error_message"><?= $dados['erros']['vaga'] ?></span>
                        <?php endif; ?>

                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="dataInicio">Data de Início:</label>
                        <input type="date" name="dataInicio" id="dataInicio" class="form-control"
                            value="<?= isset($dados['oportunidade']) ? $dados['oportunidade']->getDataInicio() : '' ?>">

                        <?php if (isset($dados['erros']['datainicio'])): ?>
                            <span class="form_error_message"><?= $dados['erros']['datainicio'] ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="dataFim">Data de Fim:</label>
                        <input type="date" name="dataFim" id="dataFim" class="form-control"
                            value="<?= isset($dados['oportunidade']) ? $dados['oportunidade']->getDataFim() : '' ?>">

                        <?php if (isset($dados['erros']['datafim'])): ?>
                            <span class="form_error_message"><?= $dados['erros']['datafim'] ?></span>
                        <?php endif; ?>
                    </div>

                    <!-- Checkbox Documento Anexo -->
                    <div class="mb-3 documento-seletor">
                        <label class="form-label" for="documento">O aluno deve possuir algum requisito para participar da oportunidade?</label>
                        <label class="switch">
                            <input class="checkbox" type="checkbox" name="temDocumento" value="1"
                                <?= (isset($_POST['temDocumento']) && $_POST['temDocumento'] == "1") ||
                                    (isset($dados['oportunidade']) && $dados['oportunidade']->getDocumentoAnexo() != "") ? 'checked' : '' ?>>
                            <span class="slider round"></span>
                        </label>
                    </div>

                    <!-- Campo descrição do documento -->
                    <div class="mb-3 documento-anexo">
                        <label class="form-label" for="documentoAnexo">(Descreva os requisitos ou documento que deve ser anexado):</label>
                        <input type="text" name="documentoAnexo" id="documento" class="form-control"
                            value="<?= isset($dados['oportunidade']) ? $dados['oportunidade']->getDocumentoAnexo() : '' ?>">

                        <?php if (isset($dados['erros']['documentoAnexo'])): ?>
                            <span class="form_error_message"><?= $dados['erros']['documentoAnexo'] ?></span>
                        <?php endif; ?>
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
                        <?php if (isset($dados['erros']['curso'])): ?>
                            <span class="form_error_message"><?= $dados['erros']['curso'] ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="mt-3 btn-salvar">
                        <button type="submit" class="btn btn-success">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="col-6">
    <?php require_once(__DIR__ . "/../include/msg.php"); ?>
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

    const inputTitulo = document.getElementById("txtTitulo");
    const contador = document.getElementById("contTitulo");

    inputTitulo.addEventListener("input", () => {
        contador.textContent = `${inputTitulo.value.length}/55`;
    });
</script>


<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js"></script>
<script>
    new FroalaEditor("#txtDescricao");
</script>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>