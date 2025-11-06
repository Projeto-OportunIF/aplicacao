<?php
#Classe controller para a Logar do sistema
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../service/LoginService.php");
require_once(__DIR__ . "/../model/Usuario.php");
//require_once(__DIR__ . "/NotificacaoController.php");




class LoginController extends Controller
{


    private LoginService $loginService;
    private UsuarioDAO $usuarioDao;
    private NotificacaoController $notificacaoController;

    public function __construct()
    {
        $this->loginService = new LoginService();
        $this->usuarioDao = new UsuarioDAO();
        //$this->notificacaoController = new NotificacaoController();




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

        // Validar os campos obrigatórios
        $erros = $this->loginService->validarCampos($email, $senha);
        $msgErro = ""; // Variável para mensagem de erro geral

        if (empty($erros)) {
            // Tenta buscar o usuário no banco
            $usuario = $this->usuarioDao->findByEmailSenha($email, $senha);

            if ($usuario) {
                // Salva sessão
                $this->loginService->salvarUsuarioSessao($usuario);

                // Redireciona conforme tipo de usuário
                if ($usuario->getTipoUsuario() === UsuarioTipo::ADMINISTRADOR) {
                    header("location: " . BASEURL . "/controller/HomeController.php?action=home");
                } elseif ($usuario->getTipoUsuario() === UsuarioTipo::ALUNO) {
                    header("location: " . BASEURL . "/controller/HomeController.php?action=homeAluno");
                } elseif ($usuario->getTipoUsuario() === UsuarioTipo::PROFESSOR) {
                    header("location: " . BASEURL . "/controller/HomeController.php?action=homeProfessor");
                } else {
                    echo "Tipo de usuário inválido!";
                }

                exit;
            } else {
                // Mostra mensagem de erro estilizada pelo msg.php
                $msgErro = "Login ou senha informados são inválidos!";
            }
        }

        // Retorna os dados para o formulário
        $dados["email"] = $email;
        $dados["senha"] = $senha;
        $dados['erros'] = $erros;

        // Passa a mensagem para a view
        $this->loadView("login/login.php", $dados, $msgErro);
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
