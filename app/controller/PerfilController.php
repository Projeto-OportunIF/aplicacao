<?php  
require_once(__DIR__ . "/Controller.php"); 
require_once(__DIR__ . "/../dao/UsuarioDAO.php"); 
require_once(__DIR__ . "/../service/UsuarioService.php"); 
require_once(__DIR__ . "/../service/ArquivoService.php"); 
require_once(__DIR__ . "/../service/LoginService.php"); 

class PerfilController extends Controller { 
    private UsuarioDAO $usuarioDao; 
    private UsuarioService $usuarioService; 
    private ArquivoService $arquivoService; 
    private LoginService $loginService; 

    public function __construct() { 
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
    protected function view() { 
        $idUsuarioLogado = $_SESSION[SESSAO_USUARIO_ID]; 
        $usuario = $this->usuarioDao->findById($idUsuarioLogado); 
        $dados['usuario'] = $usuario; 
        $this->loadView("perfil/perfil.php", $dados); 
    } 

    // Salva a foto de perfil do usuário 
    protected function save() { 
        $erros = []; 

        if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) { 
            $foto = $_FILES["foto"]; 
            $erros = $this->usuarioService->validarFotoPerfil($foto); 

            if (!$erros) { 
                $fotoNome = $this->arquivoService->salvarArquivo($foto); 
                $idUsuarioLogado = $_SESSION[SESSAO_USUARIO_ID]; 
                $usuario = $this->usuarioDao->findById($idUsuarioLogado); 
                $usuario->setFotoPerfil($fotoNome); 
                $this->usuarioDao->update($usuario); 

                // Atualiza sessão com nova foto
                $this->loginService->salvarUsuarioSessao($usuario);
            } 
        } else { 
            $erros[] = "Nenhuma foto foi enviada."; 
        } 

        $idUsuarioLogado = $_SESSION[SESSAO_USUARIO_ID]; 
        $usuario = $this->usuarioDao->findById($idUsuarioLogado); 
        $dados['usuario'] = $usuario; 
        $msgErro = implode("<br>", $erros); 
        $this->loadView("perfil/perfil.php", $dados, $msgErro); 
    } 

    protected function editarPerfil() { 
        if (!isset($_SESSION[SESSAO_USUARIO_ID])) { 
            header("Location: " . BASEURL . "/controller/LoginController.php?action=login"); 
            exit; 
        } 

        $idUsuario = $_SESSION[SESSAO_USUARIO_ID]; 
        $usuario = $this->usuarioDao->findById($idUsuario); 

        // Instancia o CursoDAO para listar cursos
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

        $this->loadView("perfil/perfilEdit.php", $dados); 
    } 

    protected function salvarEdicaoPerfil() { 
        if (!isset($_SESSION[SESSAO_USUARIO_ID])) { 
            header("Location: " . BASEURL . "/controller/LoginController.php?action=login"); 
            exit; 
        } 

        $idUsuario = $_SESSION[SESSAO_USUARIO_ID]; 
        $usuario = $this->usuarioDao->findById($idUsuario); 

        if ($usuario) {
            $usuario->setNomeCompleto($_POST['nomeCompleto'] ?? $usuario->getNomeCompleto());
            $usuario->setEmail($_POST['email'] ?? $usuario->getEmail());
            $usuario->setTipoUsuario($_POST['tipoUsuario'] ?? $usuario->getTipoUsuario());
            $usuario->setCursoId($_POST['curso_id'] ?? $usuario->getCursoId());

            $this->usuarioDao->update($usuario);
            $this->loginService->salvarUsuarioSessao($usuario); // Atualiza sessão
        }

        header("Location: " . BASEURL . "/controller/PerfilController.php?action=view");
        exit;
    } 
} 

new PerfilController();