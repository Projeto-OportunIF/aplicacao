<?php
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../service/ArquivoService.php");
require_once(__DIR__ . "/../service/LoginService.php");
require_once(__DIR__ . "/../dao/CursoDAO.php");


class PerfilController extends Controller
{
    private UsuarioDAO $usuarioDao;
    private UsuarioService $usuarioService;
    private ArquivoService $arquivoService;
    private LoginService $loginService;

    public function __construct()
    {
        $this->usuarioDao = new UsuarioDAO();
        $this->usuarioService = new UsuarioService();
        $this->arquivoService = new ArquivoService();
        $this->loginService = new LoginService();

        // Verifica se o usuário está logado pela sessão
        session_start();
        if (!isset($_SESSION[SESSAO_USUARIO_ID])) {
            header("Location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        $this->handleAction();
    }

    // Carrega a view de perfil com os dados do usuário logado 
    protected function view()
    {
        $idUsuarioLogado = $_SESSION[SESSAO_USUARIO_ID];
        $usuario = $this->usuarioDao->findById($idUsuarioLogado);
        $dados['usuario'] = $usuario;
        $this->loadView("perfil/perfil.php", $dados);
    }

    protected function save()
    {

        $idUsuario = $_SESSION[SESSAO_USUARIO_ID];
        $usuario = $this->usuarioDao->findById($idUsuario);

        $erros = [];

        if ($usuario) {
            $usuario->setNomeCompleto($_POST['nomeCompleto'] ?? $usuario->getNomeCompleto());
            $usuario->setEmail($_POST['email'] ?? $usuario->getEmail());
            $usuario->setCpf($_POST['cpf'] ?? $usuario->getCpf());
            $usuario->setMatricula($_POST['matricula'] ?? $usuario->getMatricula());
            $usuario->setTipoUsuario($_POST['tipoUsuario'] ?? $usuario->getTipoUsuario());
        }

        if (!empty($_POST['curso_id'])) {
            $cursoDao = new CursoDAO();
            $curso = $cursoDao->findById($_POST['curso_id']);
            if ($curso) {
                $usuario->setCurso($curso);
            }
        }

        if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) {

            $foto = $_FILES["foto"];
            $fotoNome = $this->arquivoService->salvarArquivo($foto);
            $usuario->setFotoPerfil($fotoNome);
        } else if ($usuario->getFotoPerfil() == null) {
            $erros[] = "Nenhuma foto foi enviada.";
        }

        $erros = $this->usuarioService->validarDados($usuario, $usuario->getSenha());

        if (!$erros) {

            $this->usuarioDao->update($usuario);

            // Atualiza sessão com nova foto
            $this->loginService->salvarUsuarioSessao($usuario);

            header("Location: " . BASEURL . "/controller/PerfilController.php?action=view");
        }

        $dados['usuario'] = $usuario;
        $msgErro = implode("<br>", $erros);
        $this->loadView("perfil/perfil.php", $dados, $msgErro);
    }

    // Carrega tela de edição
    protected function editarPerfil()
    {
        if (!isset($_SESSION[SESSAO_USUARIO_ID])) {
            header("Location: " . BASEURL . "/controller/LoginController.php?action=login");
            exit;
        }

        $idUsuario = $_SESSION[SESSAO_USUARIO_ID];
        $usuario = $this->usuarioDao->findById($idUsuario);

        require_once(__DIR__ . "/../dao/CursoDAO.php");
        $cursoDao = new CursoDAO();
        $cursos = $cursoDao->list();

        $tiposUsuario = ["Aluno", "Professor", "Administrador"];

        $dados = [
            "id" => $usuario->getId(),
            "usuario" => $usuario,
            "cursos" => $cursos,
            "tipoUsuario" => $tiposUsuario,
        ];

    // Validação e atualização da senha
    $senhaNova = $_POST['Senha'] ?? null; 

    if (!empty($senhaNova)) {
        $errosSenha = $this->validarSenha($senhaNova);

        if (!empty($errosSenha)) {
            $cursoDao = new CursoDAO();
            $cursos = $cursoDao->list();

            $dados = [
                "usuario" => $usuario,
                "cursos" => $cursos,
                "erros" => $errosSenha,
            ];

            $this->loadView("perfil/perfilEdit.php", $dados);
            return;
        }

        // Se passou na validação, criptografa e define a nova senha
        $usuario->setSenha(password_hash($senhaNova, PASSWORD_DEFAULT));
    }
        $this->loadView("perfil/perfilEdit.php", $dados);
    }

        private function validarSenha($senha): array{
        $erros = [];

        if (strlen($senha) < 8) {
            $erros[] = "A senha deve ter no mínimo 8 caracteres.";
        }
        if (!preg_match('/[A-Z]/', $senha)) {
            $erros[] = "A senha deve conter pelo menos uma letra maiúscula.";
        }
        if (!preg_match('/[a-z]/', $senha)) {
            $erros[] = "A senha deve conter pelo menos uma letra minúscula.";
        }
        if (!preg_match('/[0-9]/', $senha)) {
            $erros[] = "A senha deve conter pelo menos um número.";
        }
        if (!preg_match('/[\W]/', $senha)) {
            $erros[] = "A senha deve conter pelo menos um caracter especial.";
        }

        return $erros;
    }

    // Salva todas as alterações do perfil
    //TODO: Verificar se essa funcao continua sendo util
    protected function salvarEdicaoPerfil()
    {
        // if (!isset($_SESSION[SESSAO_USUARIO_ID])) {
        //     header("Location: " . BASEURL . "/controller/LoginController.php?action=login");
        //     exit;
        // }

        // $idUsuario = $_SESSION[SESSAO_USUARIO_ID];
        // $usuario = $this->usuarioDao->findById($idUsuario);

        // if ($usuario) {
        //     $usuario->setNomeCompleto($_POST['nomeCompleto'] ?? $usuario->getNomeCompleto());
        //     $usuario->setEmail($_POST['email'] ?? $usuario->getEmail());
        //     $usuario->setCpf($_POST['cpf'] ?? $usuario->getCpf());
        //     $usuario->setMatricula($_POST['matricula'] ?? $usuario->getMatricula());
        //     $usuario->setTipoUsuario($_POST['tipoUsuario'] ?? $usuario->getTipoUsuario());

        //     if (isset($foto) && $foto != ""){
        //         $usuario->setFotoPerfil($foto);
        //     }


        //     if (!empty($_POST['curso_id'])) {
        //         require_once(__DIR__ . "/../dao/CursoDAO.php");
        //         $cursoDao = new CursoDAO();
        //         $curso = $cursoDao->findById($_POST['curso_id']);
        //         if ($curso) {
        //             $usuario->setCurso($curso);
        //         }
        //     }

        //     $this->usuarioDao->update($usuario);

        //     $this->loginService->salvarUsuarioSessao($usuario);
        // }

        // header("Location: " . BASEURL . "/controller/PerfilController.php?action=view");
        // exit;
    }
}

new PerfilController();
