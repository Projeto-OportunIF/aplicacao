<?php

require_once(__DIR__ . "/../dao/NotificacaoDAO.php");


class NotificacaoService
{

    public static function countNotificacoesByUsuario()
    {
        $notificacaoDAO = new NotificacaoDAO();

        $id = $_SESSION[SESSAO_USUARIO_ID];

        $notificacoes = $notificacaoDAO->countNotificacoesByUsuario($id);

        $_SESSION[SESSAO_USUARIO_NOTIFICACOES] = $notificacoes["total_notificacoes"];
    }

}
