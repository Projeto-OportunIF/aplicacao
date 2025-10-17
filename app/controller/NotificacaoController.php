<?php

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/NotificacaoDAO.php");

class NotificacaoController extends Controller
{
    private $dao;

    public function __construct()
    {

        $this->dao = new NotificacaoDAO();

        $this->handleAction();
    }

    public function countNotificacoesByUsuario()
    {

        $id = $this->getIdUsuarioLogado();
        $notificacoes = $this->dao->countNotificacoesByUsuario($id);
        $_SESSION[SESSAO_USUARIO_NOTIFICACOES] = $notificacoes["total_notificacoes"];
    }

    public function  notificarUsuariosByCurso()
    {
        $this->dao->notificarUsuariosByCurso("oii", [1]);
    }


    // private function listar()
    // {
    //     $idUsuario = $_SESSION['usuarioLogadoId'] ?? 0;
    //     $notificacoes = $this->dao->listByUsuario($idUsuario);
    //     include("../view/notificacao/notificacao_list.php");
    // }

    // private function visualizar()
    // {
    //     $id = $_GET['id'] ?? 0;
    //     $notificacao = $this->dao->findById($id);
    //     $this->dao->updateStatus($id, "lida");
    //     include("../view/notificacao/notificacao_view.php");
    // }

    // private function deletar()
    // {
    //     $id = $_GET['id'] ?? 0;
    //     $this->dao->deleteById($id);
    //     header("Location: NotificacaoController.php?action=listar");
    //     exit;
    // }
}

new NotificacaoController();
