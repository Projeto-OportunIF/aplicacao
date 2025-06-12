<?php

require_once(__DIR__ . "/Controller.php");

class CursoController extends Controller {

    public function __construct() {
        //Verificar se o usuário está logado
        if(! $this->usuarioEstaLogado())
            return;

        //Tratar a ação solicitada no parâmetro "action"
        $this->handleAction();
    }

    protected function list() {
        echo "Chamou!";
    }

}

new CursoController();