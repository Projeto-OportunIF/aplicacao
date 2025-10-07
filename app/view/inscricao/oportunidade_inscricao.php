<?php
#Nome do arquivo: oportunidade_inscricao.php
#Objetivo: interface para inscrição em oportunidade

require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>

<link rel="stylesheet" href="<?= BASEURL ?>/view/css/inscricao_oportuni.css">

<div class="container my-4">
    <div class="row inscricao-container">

        <!-- Coluna esquerda verde -->
        <div class="col-md-5 inscricao-info">
            <h2>Inscrição</h2>

            <p><strong>Nome:</strong> <?= htmlspecialchars($dados['oportunidade']->getTitulo()) ?></p>
            <p><strong>Descrição:</strong> <?= nl2br(strip_tags($dados['oportunidade']->getDescricao())) ?></p>
            <p><strong>Professor Responsável:</strong> <?= htmlspecialchars($dados['oportunidade']->getProfessorResponsavel()) ?></p>
            <p><strong>Modalidade:</strong> <?= htmlspecialchars($dados['oportunidade']->getTipoOportunidade()) ?></p>
            <p><strong>Data de Início:</strong> <?= date('d/m/Y', strtotime($dados['oportunidade']->getDataInicio())) ?></p>
            <p><strong>Data de Fim:</strong> <?= date('d/m/Y', strtotime($dados['oportunidade']->getDataFim())) ?></p>
            <p><strong>Vagas:</strong> <?= htmlspecialchars($dados['oportunidade']->getVaga()) ?></p>
            <p><strong>Documento Anexo:</strong> <?= htmlspecialchars($dados['oportunidade']->getDocumentoAnexo() ?? "Não há documento") ?></p>

            <!-- Formulário / Mensagem -->
            <?php if ($dados['oportunidade']->getTipoOportunidade() !== 'ESTAGIO'): ?>
                <form action="<?= BASEURL ?>/controller/InscricaoController.php?action=inscrever&idOport=<?= $dados['oportunidade']->getId() ?>" method="post" enctype="multipart/form-data">

                    <!-- Campo de Documento -->
                    <?php if (!empty($dados['oportunidade']->getDocumentoAnexo())): ?>
                        <label for="documentoAluno">Enviar Documento (obrigatório):</label>
                        <input type="file" name="documentoAluno" id="documentoAluno" class="form-control mb-3" required>
                    <?php endif; ?>

                    <button type="submit" class="btn-inscrever">Inscrever-me</button>
                </form>
            <?php else: ?>
                <p class="alert alert-info">
                    A inscrição desta oportunidade é externa. Leia a descrição com atenção para mais informações.
                </p>
            <?php endif; ?>
        </div>

        <!-- Coluna direita rosa -->
        <div class="col-md-5 inscricao-figura">
            <button class="btn-voltar" onclick="window.history.back()">Voltar</button>
            <img src="<?= BASEURL ?>/view/img/inscricao.png" alt="Figura inscrição">
        </div>

    </div>
</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>