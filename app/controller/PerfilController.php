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
            $usuario->setSenha($_POST['senhaNova'] ?? $usuario->getSenha());
        }
        $confNovaSenha = $_POST['confSenhaNova'] ?? $usuario->getSenha();

        // --- Upload da foto de perfil ---
        if (isset($_FILES['fotoPerfil']) && $_FILES['fotoPerfil']['error'] == UPLOAD_ERR_OK) {
            $tipoArquivo = mime_content_type($_FILES['fotoPerfil']['tmp_name']);

            // Aceita apenas PNG e JPEG
            if ($tipoArquivo === 'image/png' || $tipoArquivo === 'image/jpeg') {
                $nomeArquivo = $this->arquivoService->salvarArquivo($_FILES['fotoPerfil']);

                if ($nomeArquivo) {
                    // Remove a foto antiga, se existir
                    if ($usuario->getFotoPerfil()) {
                        $this->arquivoService->removerArquivo($usuario->getFotoPerfil());
                    }

                    // Atualiza o banco e a sessão
                    $usuario->setFotoPerfil($nomeArquivo);
                    $this->usuarioDao->updateFotoPerfil($usuario);
                    $_SESSION[SESSAO_USUARIO_FOTO_PERFIL] = $nomeArquivo;
                }
            } else {
                // Caso o tipo não seja permitido
                $_SESSION['erro_foto'] = "Apenas arquivos PNG e JPEG são permitidos.";
            }
        }

        $erros = $this->usuarioService->validarDados($usuario, $confNovaSenha);

        if (!$erros) {

            $usuario->setSenha(password_hash($usuario->getSenha(), PASSWORD_DEFAULT));

            $this->usuarioDao->update($usuario);

            // Atualiza sessão com nova foto
            $this->loginService->salvarUsuarioSessao($usuario);

            header("Location: " . BASEURL . "/controller/PerfilController.php?action=view");
        }

        $dados['usuario'] = $usuario;

        if (isset($_GET['edicaoPerfil'])) {
            $dados['erros'] = $erros;
            $this->loadView("perfil/perfilEdit.php", $dados);
        } else {
            $msgErro = implode("<br>", $erros);
            $this->loadView("perfil/perfil.php", $dados, $msgErro);
        }
    }

    // Carrega tela de edição
    protected function editarPerfil()
    {
        $idUsuario = $_SESSION[SESSAO_USUARIO_ID];
        $usuario = $this->usuarioDao->findById($idUsuario);

        $dados["usuario"] = $usuario;
        $this->loadView("perfil/perfilEdit.php", $dados);
    }
}

new PerfilController();
