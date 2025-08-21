<?php
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/OportunidadeDAO.php");


class InscricaoController extends Controller
{
    private OportunidadeDAO $oportunidadeDao;


    public function __construct()
    {
        if (!$this->usuarioEstaLogado()) return;


        $this->oportunidadeDao = new OportunidadeDAO();

        $this->handleAction();
    }


    protected function view(string $msgErro = "", string $msgSucesso = "")
    {
        $oportunidade = $this->findOportunidadeById();

        $dados["oportunidade"] = $oportunidade;
        $this->loadView("inscricao/oportunidade_inscricao.php", $dados, $msgErro, $msgSucesso);
    }


    private function findOportunidadeById()
    {
        $id = 0;
        if (isset($_GET["idOport"]))
            $id = $_GET["idOport"];

        //Busca o usuário na base pelo ID    
        return $this->oportunidadeDao->findById($id);
    }
}


new InscricaoController();
