<?php
require_once(__DIR__ . "/../include/header.php");
require_once(__DIR__ . "/../include/menu.php");
require_once(__DIR__ . "/../../dao/OportunidadeDAO.php");

if (isset($_SESSION["usuario_tipo"])) {
    switch ($_SESSION["usuario_tipo"]) {
        case "professor":
            $homePage = BASEURL . "/controller/HomeController.php?action=homeProfessor";
            break;
        case "admin":
            $homePage = BASEURL . "/controller/HomeController.php?action=homeAdmin";
            break;
        case "aluno":
        default:
            $homePage = BASEURL . "/controller/HomeController.php?action=homeAluno";
            break;
    }
}
?>
<link rel="stylesheet" href="<?= BASEURL ?>/view/css/notificacoes.css">

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
            $idNot = $notificacao['idNotificacoes'] ?? null;
            $idOport = $notificacao['idOportunidade'] ?? null;
            $mensagem = $notificacao['mensagem'] ?? '';
            $dataEnvio = $notificacao['dataEnvio'] ?? '';

            // dia/mês/ano
            $dataFormatada = '';
            if (!empty($dataEnvio)) {
                $dataFormatada = date('d/m/Y', strtotime($dataEnvio));
            }
            ?>
            <div class="card-oportunidade">
                <h3><?= htmlspecialchars($mensagem) ?></h3>

                <!-- Mensagem fixa -->
                <p class="mensagem-fixa">
                    Você tem uma nova inscrição nessa oportunidade.
                    Clique em <strong>"Visualizar Inscritos"</strong> para visualizá-los.
                </p>

                <p><strong>Data:</strong> <?= htmlspecialchars($dataFormatada) ?></p>

                <div class="acoes-notificacao">
                    <a href="<?= BASEURL . '/controller/NotificacaoController.php?action=atualizarStatusPorUsuario&id_notificacao=' . $idNot ?>"
                        class="btn btn-marcar-lido">
                        <i class="bi bi-check-circle"></i> Marcar como lido
                    </a>


                    <?php
                    // Exibe o botão apenas se houver uma oportunidade associada
                    if (!empty($idOport)) {
                        $oportunidadeDAO = new OportunidadeDAO();
                        $oportunidade = $oportunidadeDAO->findById($idOport);

                        // Exibe o botão apenas se não for estágio
                        if ($oportunidade && $oportunidade->getTipoOportunidade() !== 'ESTAGIO'): ?>
                            <a class="btn btn-visualizar-inscritos"
                                href="<?= BASEURL ?>/controller/OportunidadeController.php?action=visualizarInscritos&idOport=<?= $idOport ?>">
                                <i class=""></i> Visualizar Inscritos
                            </a>

                    <?php endif;
                    }
                    ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="sem-notificacoes">
            <i class="bi bi-bell-slash"></i>
            <p>Não há notificações no momento.</p>
        </div>
    <?php endif; ?>
</div>

<?php require_once(__DIR__ . "/../include/footer.php"); ?>