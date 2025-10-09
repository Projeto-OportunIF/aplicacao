<?php


require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");


class HomeController extends Controller
{


    private UsuarioDAO $usuarioDAO;


    public function __construct()
    {
        //Verificar se o usuário está logado
        if (! $this->usuarioEstaLogado())
            return;


        $this->usuarioDAO = new UsuarioDAO();


        //Tratar a ação solicitada no parâmetro "action"
        $this->handleAction();
    }


    protected function home()
    {
        $usuario = $this->usuarioDAO->findById($this->getIdUsuarioLogado());


        if ($usuario->getTipoUsuario() === UsuarioTipo::ADMINISTRADOR) {


            $this->homeAdministrador();
        } elseif ($usuario->getTipoUsuario() === UsuarioTipo::ALUNO) {

            $this->homeAluno();
        } elseif ($usuario->getTipoUsuario() === UsuarioTipo::PROFESSOR) {

            $this->homeAluno();
        } else {
            // Fallback para uma home genérica se tipo desconhecido
            echo "Tipo de usuário inválido!";
        }
    }


    protected function homeAdministrador()
    {
        $dados["qtdUsuarios"] = $this->usuarioDAO->quantidadeUsuarios();
        $this->loadView("home/homeAdmin.php", $dados);
    }


    protected function homeAluno()
    {
        $dados["titulo"] = "";
        $this->loadView("home/homeAluno.php", $dados);
    }


    protected function homeProfessor()
    {
        $dados["titulo"] = "";
        $this->loadView("home/homeProfessor.php", $dados);
    }
}


//Criar o objeto do controller
new HomeController();
