<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/inscricao_list.css">
<div class="container mt-5 mb-5">
    <h2 class="text-center titulo-pagina mb-4">Minhas Inscrições</h2>

    <div class="text-center mt-5 mb-5">
        <a href="<?= BASEURL ?>/controller/HomeController.php?action=homeAluno" class="btn-voltar">
            <i class="bi bi-arrow-left-circle"></i> Voltar
        </a>
    </div>

    <?php if (count($dados['inscricoes']) > 0): ?>
        <div class="cards-container">
            <?php foreach ($dados['inscricoes'] as $inscricao): ?>
                <div class="card-inscricao">
                    <div class="conteudo-card">
                        <h4 class="titulo-inscricao"><?= htmlspecialchars($inscricao->titulo) ?></h4>



                        <p><strong>Tipo:</strong> <?= htmlspecialchars($inscricao->tipoOportunidade) ?></p>
                        <p><strong>Professor:</strong> <?= htmlspecialchars($inscricao->professor_responsavel ?? "Não definido") ?></p>
                        <p><strong>Início:</strong> <?= date('d/m/Y', strtotime($inscricao->dataInicio)) ?></p>
                        <p><strong>Fim:</strong> <?= date('d/m/Y', strtotime($inscricao->dataFim)) ?></p>
                        <p><strong>Status:</strong>
                            <span class="status-badge <?= strtolower($inscricao->status) ?>">
                                <?= htmlspecialchars($inscricao->status) ?>
                            </span>
                        </p>

                        <p><strong>Documento:</strong>
                            <?php if ($inscricao->documentosAnexo): ?>
                                <a href="<?= BASEURL ?>/../uploads/<?= $inscricao->documentosAnexo ?>"
                                    target="_blank" class="link-doc">
                                    <i class="bi bi-file-earmark-text"></i> Ver Documento
                                </a>
                            <?php else: ?>
                                <span class="sem-doc"><i class="bi bi-x-circle"></i> Nenhum</span>
                            <?php endif; ?>
                        </p>
                    </div>

                    <a href="<?= BASEURL ?>/controller/InscricaoController.php?action=cancelar&idInscricao=<?= $inscricao->idInscricoes ?>"
                        onclick="return confirm('Tem certeza que deseja cancelar sua inscrição?')"
                        class="btn-cancelar">
                        Cancelar
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center mt-4">
            Você ainda não se inscreveu em nenhuma oportunidade.
        </div>
    <?php endif; ?>

</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>