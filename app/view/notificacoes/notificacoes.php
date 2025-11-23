<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
require_once(__DIR__ . "/../../dao/OportunidadeDAO.php");
require_once(__DIR__ . "/../../model/enum/OportunidadeTipo.php");

if (isset($_SESSION["usuarioLogadoTipo"])) {
    switch ($_SESSION["usuarioLogadoTipo"]) {
        case "PROFESSOR":
            $homePage = BASEURL . "/controller/HomeController.php?action=homeProfessor";
            break;
        case "ADMIN":
            $homePage = BASEURL . "/controller/HomeController.php?action=homeAdministrador";
            break;
        case "ALUNO":
        default:
            $homePage = BASEURL . "/controller/HomeController.php?action=homeAluno";
            break;
    }
}
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/notificacoee.css">

<div class="container mt-4">

    <h2 class="text-center titulo-pagina mb-4">TELA DE NOTIFICAÇÕES</h2>

    <div class="text-center mb-4">
        <a href="<?= $homePage ?>" class="btn-voltar">
            <i class="bi bi-arrow-left-circle"></i> Voltar
        </a>
    </div>

    <div class="row"> <!-- LINHA CORRETA -->

        <?php if (count($dados["notificacoes"]) > 0): ?>
            <?php foreach ($dados["notificacoes"] as $notificacao): ?>

                <?php
                $idNot = $notificacao->getId() ?? null;
                $idOport = $notificacao->getIdOportunidade() ?? null;
                $mensagem = $notificacao->getMensagem() ?? '';
                $dataEnvio = $notificacao->getDataEnvio() ?? '';

                if (!empty($dataEnvio)) {
                    $dataEnvio = date("d/m/Y", strtotime($dataEnvio));
                }

                $tipoOportunidade = "";
                if (!empty($idOport)) {
                    $dao = new OportunidadeDAO();
                    $oportunidade = $dao->findById($idOport);
                    if ($oportunidade) {
                        $tipoOportunidade = OportunidadeTipo::getLabel($oportunidade->getTipoOportunidade());
                    }
                }
                ?>

                <div class="col-12 col-md-6 col-lg-4 mb-4"> <!-- AJUSTE IMPORTANTE AQUI -->
                    <div class="card-oportunidade shadow-sm p-3">

                        <h3 class="mb-3"><?= htmlspecialchars($mensagem) ?></h3>

                        <?php if (!empty($tipoOportunidade)): ?>
                            <p class="tipo-oportunidade">
                                <strong>Tipo da Oportunidade:</strong>
                                <?= htmlspecialchars($tipoOportunidade) ?>
                            </p>
                        <?php endif; ?>

                        <p><strong>Data:</strong> <?= htmlspecialchars($dataEnvio) ?></p>

                        <?php if ($_SESSION['usuarioLogadoTipo'] === 'PROFESSOR'): ?>
                            <p class="descricao-fixa mt-2">
                                Você tem um novo inscrito nessa oportunidade.
                                Clique em <strong>"Visualizar Inscritos"</strong> para ver os detalhes.
                            </p>
                        <?php endif; ?>

                         <?php if ($_SESSION['usuarioLogadoTipo'] === 'ALUNO'): ?>
                            <p class="descricao-fixa mt-2">
                                Uma nova oportunidade está disponível.
                                Clique em <strong>"Visualizar Oportunidade"</strong> para ver os detalhes.
                            </p>
                        <?php endif; ?>

                        <div class="d-flex flex-column flex-sm-row gap-2 mt-3">

                            <a href="<?= BASEURL . '/controller/NotificacaoController.php?action=atualizarStatusPorUsuario&id_notificacao=' . $idNot ?>"
                                class="btn btn-marcar-lido flex-fill">
                                <i class="bi bi-check-circle"></i> Marcar como lido
                            </a>

                            <?php if ($_SESSION['usuarioLogadoTipo'] === 'PROFESSOR'): ?>
                                <?php if (!empty($idOport) && $oportunidade && $oportunidade->getTipoOportunidade() !== 'ESTAGIO'): ?>
                                    <a href="<?= BASEURL ?>/controller/OportunidadeController.php?action=visualizarInscritos&idOport=<?= $idOport ?>"
                                        class="btn btn-visualizar flex-fill">
                                        <i class="bi bi-people"></i> Visualizar Inscritos
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if ($_SESSION['usuarioLogadoTipo'] === 'ALUNO'): ?>
                                <?php if (!empty($idOport)): ?>
                                    <a href="<?= BASEURL ?>/controller/InscricaoController.php?action=view&idOport=<?= $idOport ?>"
                                        class="btn btn-visualizar flex-fill">
                                        <i class="bi bi-people"></i> Visualizar Oportunidade
                                    </a>
                                <?php endif; ?>
                            <?php endif; ?>

                        </div>

                    </div>
                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="col-12">
                <div class="sem-notificacoes text-center">
                    <i class="bi bi-bell-slash"></i>
                    <p>Não há notificações no momento.</p>
                </div>
            </div>

        <?php endif; ?>

    </div> 

</div>

<?php require_once(__DIR__ . "/../include/footer.php"); ?>
