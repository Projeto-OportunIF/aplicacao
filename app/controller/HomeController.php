<?php
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../model/enum/UsuarioTipo.php");

class HomeController extends Controller
{
    private UsuarioDAO $usuarioDAO;
    private $usuarioLogado;

    public function __construct()
    {
        // Verifica se o usuário está logado
        if (!$this->usuarioEstaLogado()) {
            header("Location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        $this->usuarioDAO = new UsuarioDAO();
        $this->usuarioLogado = $this->usuarioDAO->findById($this->getIdUsuarioLogado());

        $this->handleAction();
    }

    protected function home()
    {
        switch ($this->usuarioLogado->getTipoUsuario()) {
            case UsuarioTipo::ADMINISTRADOR:
                $this->homeAdministrador();
                break;
            case UsuarioTipo::ALUNO:
                $this->homeAluno();
                break;
            case UsuarioTipo::PROFESSOR:
                $this->homeProfessor();
                break;
            default:
                echo "Tipo de usuário inválido!";
        }
    }

    // HOMES INDIVIDUAIS
    protected function homeAdministrador()
    {
        //Verifica se o tipo é ADMIN
        if ($this->usuarioLogado->getTipoUsuario() !== UsuarioTipo::ADMINISTRADOR) {
            $this->redirecionarParaHomeCorreta("Você não tem permissão para acessar a área do administrador.");
            return;
        }

        $dados["qtdUsuarios"] = $this->usuarioDAO->quantidadeUsuarios();
        $dados["mensagem"] = $_SESSION["mensagem"] ?? null;
        unset($_SESSION["mensagem"]);

        $this->loadView("home/homeAdmin.php", $dados);
    }

    protected function homeAluno()
    {
        //Verifica se o tipo é ALUNO
        if ($this->usuarioLogado->getTipoUsuario() !== UsuarioTipo::ALUNO) {
            $this->redirecionarParaHomeCorreta("Você não tem permissão para acessar a área do aluno.");
            return;
        }

        $dados["mensagem"] = $_SESSION["mensagem"] ?? null;
        unset($_SESSION["mensagem"]);

        $this->loadView("home/homeAluno.php", $dados);
    }

    protected function homeProfessor()
    {
        // Verifica se o tipo é PROFESSOR
        if ($this->usuarioLogado->getTipoUsuario() !== UsuarioTipo::PROFESSOR) {
            $this->redirecionarParaHomeCorreta("Você não tem permissão para acessar a área do professor.");
            return;
        }

        $dados["mensagem"] = $_SESSION["mensagem"] ?? null;
        unset($_SESSION["mensagem"]);

        $this->loadView("home/homeProfessor.php", $dados);
    }

    // REDIRECIONAMENTO SEGURO
    private function redirecionarParaHomeCorreta(string $mensagem)
    {
        $_SESSION['msgErro'] = $mensagem;

        switch ($this->usuarioLogado->getTipoUsuario()) {
            case UsuarioTipo::ADMINISTRADOR:
                header("Location: " . BASEURL . "/controller/HomeController.php?action=homeAdministrador");
                break;
            case UsuarioTipo::ALUNO:
                header("Location: " . BASEURL . "/controller/HomeController.php?action=homeAluno");
                break;
            case UsuarioTipo::PROFESSOR:
                header("Location: " . BASEURL . "/controller/HomeController.php?action=homeProfessor");
                break;
        }
        exit;
    }
}

new HomeController();
