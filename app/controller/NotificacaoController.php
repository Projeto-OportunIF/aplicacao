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

    public function  notificarUsuariosByCurso()
    {
        $this->dao->notificarUsuariosByCurso("Olá! Existe uma oportunidade de estágio", [1]);
    }

    public function  notificarUsuarioById()
    {
        $this->dao->notificarUsuarioById("Olá! tudo bem?", 33);
    }


    public function listar()
    {
        $dados['notificacoes'] = $this->dao->listByUsuario($this->getIdUsuarioLogado());

        // print '<pre>';
        // print_r($dados['notificacoes']);
        // print '</pre>';

        // [0] => Array
        // (
        //     [idNotificacoes] => 2
        //     [mensagem] => Olá! Existe uma oportunidade de estágio
        //     [dataEnvio] => 2025-10-30
        //     [status] => ENVIADO
        // )

        $this->loadView("notificacoes/notificacoes.php", $dados);
    }

    public function atualizarStatusPorUsuario()
    {

        $idNotificacao = $_GET['id_notificacao'];

        $this->dao->atualizarStatusPorUsuario($this->getIdUsuarioLogado(), $idNotificacao);

        $this->listar();
    }

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
