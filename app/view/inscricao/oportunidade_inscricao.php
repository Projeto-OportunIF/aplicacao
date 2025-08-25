<?php
#Nome do arquivo: oportunidade_inscricao.php
#Objetivo: interface para inscrição em oportunidade

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?> 



<h3 class="text-center">Inscrição na Oportunidade</h3>

<div class="container" style="margin-top: 20px;">
    <div class="row">
        <div class="col-12">
            <div><strong>Nome:</strong> <?= htmlspecialchars($dados['oportunidade']->getTitulo()) ?></div>
            <div><strong>Descrição:</strong> <?= nl2br(strip_tags($dados['oportunidade']->getDescricao())) ?></div>

            <div><strong>Modalidade:</strong> <?= htmlspecialchars($dados['oportunidade']->getTipoOportunidade()) ?></div>
            <div><strong>Data de Início:</strong> <?= htmlspecialchars($dados['oportunidade']->getDataInicio()) ?></div>
            <div><strong>Data de Fim:</strong> <?= htmlspecialchars($dados['oportunidade']->getDataFim()) ?></div>
            <div><strong>Vagas:</strong> <?= htmlspecialchars($dados['oportunidade']->getVaga()) ?></div>
            <div><strong>Documento Anexo:</strong> <?= htmlspecialchars($dados['oportunidade']->getDocumentoAnexo() ?? "Não há documento") ?></div>
        </div>
    </div>

    <div class="row" style="margin-top: 20px;">
        <div class="col-12">
         <form action="<?= BASEURL ?>/controller/InscricaoController.php?action=inscrever&idOport=<?= $dados['oportunidade']->getId() ?>" method="post" enctype="multipart/form-data">
    <!-- Campo de upload obrigatório -->
    <div class="mb-3">
        <label class="form-label" for="documentoAluno">Enviar Documento (obrigatório):</label>
        <input type="file" name="documentoAluno" id="documentoAluno" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-success">Inscrever-se</button>
</form>


        </div>
    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>