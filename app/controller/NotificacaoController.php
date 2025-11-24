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
        $this->loadView("notificacoes/notificacoes.php", $dados);
    }

    public function atualizarStatusPorUsuario()
    {
        $idNotificacao = $_GET['id_notificacao'];

        // Atualiza o status da notificação para 'LIDO'
        $this->dao->atualizarStatusPorUsuario($this->getIdUsuarioLogado(), $idNotificacao);

        // Atualiza a contagem de notificações na sessão
        require_once(__DIR__ . "/../service/NotificacaoService.php");
        NotificacaoService::countNotificacoesByUsuario();

        // Recarrega a lista de notificações
        $this->listar();
    }
}

new NotificacaoController();
