<?php

require_once(__DIR__ . "/../dao/NotificacaoDAO.php");


class NotificacaoService
{
    private $dao;

    public function __construct()
    {
        $this->dao = new NotificacaoDAO();
    }

    public static function countNotificacoesByUsuario()
    {
        $notificacaoDAO = new NotificacaoDAO();

        $id = $_SESSION[SESSAO_USUARIO_ID];

        $notificacoes = $notificacaoDAO->countNotificacoesByUsuario($id);

        $_SESSION[SESSAO_USUARIO_NOTIFICACOES] = $notificacoes["total_notificacoes"];
    }

    
    public function  notificarUsuariosByCurso( $mensagem, array $cursos)
    {
        //validar se os cursos existem 

        $this->dao->notificarUsuariosByCurso( $mensagem, $cursos);
    }

    public function  notificarUsuarioById( $mensagem, $id)
    {
        $this->dao->notificarUsuarioById( $mensagem, $id);
    }
}
