<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");

?>

<h2 class="text-center">Minhas Inscrições</h2>

<div class="container">
    <?php if (count($dados['inscricoes']) > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Professor</th>
                        <th>Início</th>
                        <th>Fim</th>
                        <th>Status</th>
                        <th>Documento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados['inscricoes'] as $inscricao): ?>
                        <tr>
                            <td><?= htmlspecialchars($inscricao->titulo) ?></td>
                            <td><?= nl2br(strip_tags($inscricao->descricao)) ?></td>
                            <td><?= htmlspecialchars($inscricao->tipoOportunidade) ?></td>
                           <td><?= htmlspecialchars($inscricao->professor_responsavel ?? "Não definido") ?></td>
                            <td><?= date('d/m/Y', strtotime($inscricao->dataInicio)) ?></td>
                            <td><?= date('d/m/Y', strtotime($inscricao->dataFim)) ?></td>
                            <td><?= htmlspecialchars($inscricao->status) ?></td>
                            <td>
                                <?php if ($inscricao->documentosAnexo): ?>
                                    <a href="<?= BASEURL ?>/uploads/<?= $inscricao->documentosAnexo ?>" target="_blank">Ver Documento</a>
                                <?php else: ?>
                                    Nenhum
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="<?= BASEURL ?>/controller/InscricaoController.php?action=cancelar&idInscricao=<?= $inscricao->idInscricoes ?>"
                                    onclick="return confirm('Tem certeza que deseja cancelar sua inscrição?')"
                                    class="btn btn-danger btn-sm">
                                    Cancelar
                                </a>


                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p>Você ainda não se inscreveu em nenhuma oportunidade.</p>
    <?php endif; ?>
</div>

<div class="mt-3">
    <a href="<?= BASEURL ?>/controller/HomeController.php?action=homeAluno" class="btn btn-secondary">Voltar</a>
</div>

<?php
require_once(__DIR__ . "/../include/footer.php");
?>