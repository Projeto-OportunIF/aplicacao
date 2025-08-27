<?php
#Classe controller para a Logar do sistema
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../service/LoginService.php");
require_once(__DIR__ . "/../model/Usuario.php");

class LoginController extends Controller
{

    private LoginService $loginService;
    private UsuarioDAO $usuarioDao;

    public function __construct()
    {
        $this->loginService = new LoginService();
        $this->usuarioDao = new UsuarioDAO();

        $this->handleAction();
    }

    protected function login()
    {
        $this->loadView("login/login.php", []);
    }

    /* Método para logar um usuário a partir dos dados informados no formulário */
    protected function logon()
    {
        $email = isset($_POST['email']) ? trim($_POST['email']) : null;
        $senha = isset($_POST['senha']) ? trim($_POST['senha']) : null;

        //Validar os campos
        $erros = $this->loginService->validarCampos($email, $senha);
        if (empty($erros)) {
            //Valida o login a partir do banco de dados
            $usuario = $this->usuarioDao->findByEmailSenha($email, $senha);
            if ($usuario) {
                $this->loginService->salvarUsuarioSessao($usuario);
                // Redirecionar para telas diferentes conforme o tipo de usuário
                if ($usuario->getTipoUsuario() === UsuarioTipo::ADMINISTRADOR) {
                    header("location: " . BASEURL . "/controller/HomeController.php?action=home");
                } elseif ($usuario->getTipoUsuario() === UsuarioTipo::ALUNO) {
                    header("location: " . BASEURL . "/controller/HomeController.php?action=homeAluno");
                } elseif ($usuario->getTipoUsuario() === UsuarioTipo::PROFESSOR) {
                    header("location: " . BASEURL . "/controller/HomeController.php?action=homeProfessor");
                } else {
                    // Fallback para uma home genérica se tipo desconhecido
                    echo "Tipo de usuário inválido!";
                }

                exit;
            } {
                $erros = ["Login ou senha informados são inválidos!"];
            }
        }

        //Se há erros, volta para o formulário            
        $msg = implode("<br>", $erros);
        $dados["email"] = $email;
        $dados["senha"] = $senha;

        $this->loadView("login/login.php", $dados, $msg);
    }

    /* Método para logar um usuário a partir dos dados informados no formulário */
    protected function logout()
    {
        $this->loginService->removerUsuarioSessao();

        $this->loadView("login/login.php", [], "", "Usuário deslogado com suscesso!");
    }
}


#Criar objeto da classe para assim executar o construtor
new LoginController();
