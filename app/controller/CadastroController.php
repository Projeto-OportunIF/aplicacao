<?php

require_once(__DIR__ . "/Controller.php");

class CadastroController extends Controller {

    public function __construct() {
        //Tratar a ação solicitada no parâmetro "action"
        $this->handleAction();
    }

    protected function cadastrar() {
        echo "Chamou cadastrar!";
        
    }

}

new CadastroController();