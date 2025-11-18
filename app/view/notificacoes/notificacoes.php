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
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/notificacoess.css">

<h2 class="titulo-pagina">TELA DE NOTIFICAÇÕES</h2>

<div class="text-center mt-5 mb-5">
    <a href="<?= $homePage ?>" class="btn-voltar">
        <i class="bi bi-arrow-left-circle"></i> Voltar
    </a>
</div>

<div class="cards-container">
    <?php if (count($dados["notificacoes"]) > 0): ?>
        <?php foreach ($dados["notificacoes"] as $notificacao): ?>

            <?php 

            //print_r($notificacao);
            //die;
            ?>

            <?php
            $idNot = $notificacao->getId() ?? null;
            $idOport = $notificacao->getIdOportunidade() ?? null;
            $mensagem = $notificacao->getMensagem() ?? '';
            $dataEnvio = $notificacao->getDataEnvio() ?? '';

            // Formatar data
            if (!empty($dataEnvio)) {
                $dataEnvio = date("d/m/Y", strtotime($dataEnvio));
            }

            // Buscar tipo de oportunidade
            $tipoOportunidade = "";
            if (!empty($idOport)) {
                $oportunidadeDAO = new OportunidadeDAO();
                $oportunidade = $oportunidadeDAO->findById($idOport);
                if ($oportunidade) {
                    $tipoOportunidade = OportunidadeTipo::getLabel($oportunidade->getTipoOportunidade());
                }
            }
            ?>
            <div class="card-oportunidade">
                <h3><?= htmlspecialchars($mensagem) ?></h3>

                <?php if (!empty($tipoOportunidade)): ?>
                    <p class="tipo-oportunidade">
                        <strong>Tipo da Oportunidade:</strong> <?= htmlspecialchars($tipoOportunidade) ?>
                    </p>
                <?php endif; ?>

                <p><strong>Data:</strong> <?= htmlspecialchars($dataEnvio) ?></p>

                <?php if (isset($_SESSION['usuarioLogadoTipo']) && $_SESSION['usuarioLogadoTipo'] === 'PROFESSOR'): ?>
                    <p class="descricao-fixa">
                        Você tem um novo inscrito nessa oportunidade. Clique em
                        <strong>"Visualizar Inscritos"</strong> para visualizá-los.
                    </p>
                <?php endif; ?>

                <div class="acoes-notificacao">
                    <a href="<?= BASEURL . '/controller/NotificacaoController.php?action=atualizarStatusPorUsuario&id_notificacao=' . $idNot ?>"
                        class="btn btn-marcar-lido">
                        <i class="bi bi-check-circle"></i> Marcar como lido
                    </a>

                    <?php if (!empty($idOport) && $oportunidade && $oportunidade->getTipoOportunidade() !== 'ESTAGIO'): ?>
                        <a class="btn btn-visualizar"
                            href="<?= BASEURL ?>/controller/OportunidadeController.php?action=visualizarInscritos&idOport=<?= $idOport ?>">
                            <i class="bi bi-people"></i> Visualizar Inscritos
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; ?>

    <?php else: ?>
              </div>
        <div class="sem-notificacoes">
            <i class="bi bi-bell-slash"></i>
            <p>Não há notificações no momento.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once(__DIR__ . "/../include/footer.php"); ?>
