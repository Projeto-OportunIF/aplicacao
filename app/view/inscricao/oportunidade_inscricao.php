<?php
#Nome do arquivo: oportunidade_inscricao.php
#Objetivo: interface para inscrição em oportunidade

$voltarUrl = $_SERVER['HTTP_REFERER'] ?? (BASEURL . "/controller/HomeController.php?action=homeAluno");

// Pequena proteção para evitar loops (caso o referer seja a própria página)
if (strpos($voltarUrl, 'inscricao') !== false) {
    $voltarUrl = BASEURL . "/controller/HomeController.php?action=homeAluno";
}
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/css/oportunidade_inscricao.css">

<div class="container my-4">
    <div class="row inscricao-container">
        <div class="col-md-5 inscricao-info">

            <h2>Inscrição</h2>
            <p><strong>Nome:</strong> <?= htmlspecialchars($dados['oportunidade']->getTitulo()) ?></p>
            <p><strong>Descrição:</strong> <?= nl2br(strip_tags($dados['oportunidade']->getDescricao())) ?></p>
            <?php if (!empty($dados['oportunidade']->getDocumentoEdital())): ?>
                <?php $doc = basename($dados['oportunidade']->getDocumentoEdital()); ?>
                <p>
                    <strong>Documento Edital:</strong><br>
                    <a href="<?= BASEURL ?>/../uploads/<?= htmlspecialchars($doc) ?>"
                        target="_blank"
                        class="link-doc">
                        <i class="bi bi-file-earmark-text"></i>
                        Documento do Edital da oportunidade
                    </a>
                </p>

            <?php endif; ?>
            <p><strong>Professor Responsável:</strong> <?= htmlspecialchars($dados['oportunidade']->getProfessorResponsavel()) ?></p>
            <p><strong>Modalidade:</strong> <?= htmlspecialchars($dados['oportunidade']->getTipoOportunidade()) ?></p>
            <p><strong>Data de Início:</strong> <?= date('d/m/Y', strtotime($dados['oportunidade']->getDataInicio())) ?></p>
            <p><strong>Data de Fim:</strong> <?= date('d/m/Y', strtotime($dados['oportunidade']->getDataFim())) ?></p>
            <p><strong>Vagas:</strong> <?= htmlspecialchars($dados['oportunidade']->getVaga()) ?></p>

            <!-- Documento Anexo: só aparece se houver -->
            <?php if (!empty($dados['oportunidade']->getDocumentoAnexo())): ?>
                <p><strong>Requisitos para participar da oportunidade:</strong> <?= htmlspecialchars($dados['oportunidade']->getDocumentoAnexo()) ?></p>
            <?php endif; ?>
            <!-- Formulário / Mensagem -->
            <?php if ($dados['oportunidade']->getTipoOportunidade() !== 'ESTAGIO'): ?>
                <form action="<?= BASEURL ?>/controller/InscricaoController.php?action=inscrever&idOport=<?= $dados['oportunidade']->getId() ?>" method="post" enctype="multipart/form-data">

                    <!-- Campo de Documento: só aparece se houver -->
                    <?php if (!empty($dados['oportunidade']->getDocumentoAnexo())): ?>
                        <div id="uploadContainer" class="mb-3">
                            <label>Enviar comprovante dos requisitos (obrigatórios):</label>
                            <div id="inputsArquivos">
                                <input type="file" name="documentoAluno[]" class="form-control mb-2" required>
                            </div>
                            <button type="button" id="adicionarArquivo" class="btn btn-secondary btn-sm">Adicionar mais arquivo</button>
                        </div>
                    <?php endif; ?>
                    <button type="submit" class="btn-inscrever">Inscrever-me</button>
                </form>
            <?php else: ?>
                <div class="aviso-externo">
                    <i class="bi bi-info-circle-fill"></i>
                    <span>A inscrição desta oportunidade é externa.<br>Leia a descrição com atenção para mais informações.</span>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-5 inscricao-figura">
            <a href="<?= htmlspecialchars($voltarUrl) ?>" class="btn-voltar">
                <i class="bi bi-arrow-left-circle"></i> Voltar
            </a>
            <img src="<?= BASEURL ?>/view/img/inscricao.png" alt="Figura inscrição">
        </div>
    </div>
</div>

<script>
    const btnAdicionar = document.getElementById("adicionarArquivo");
    const containerInputs = document.getElementById("inputsArquivos");


    btnAdicionar.addEventListener("click", () => {
        const novoInput = document.createElement("input");
        novoInput.type = "file";
        novoInput.name = "documentoAluno[]";
        novoInput.className = "form-control mb-2";
        novoInput.required = true;
        containerInputs.appendChild(novoInput);
    });
</script>
<?php
require_once(__DIR__ . "/../include/footer.php");
?>