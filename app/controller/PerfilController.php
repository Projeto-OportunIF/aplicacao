<?php

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../service/ArquivoService.php");
require_once(__DIR__ . "/../service/LoginService.php");

class PerfilController extends Controller
{

    private UsuarioDAO $usuarioDao;
    private UsuarioService $usuarioService;
    private ArquivoService $arquivoService;
    private LoginService $loginService;

    public function __construct()
    {
        if (! $this->usuarioEstaLogado())
            return;

        $this->usuarioDao = new UsuarioDAO();
        $this->usuarioService = new UsuarioService();
        $this->arquivoService = new ArquivoService();
        $this->loginService = new LoginService();

        $this->handleAction();
    }

    // Carrega a view de perfil com os dados do usuário logado
    protected function view()
    {
        $idUsuarioLogado = $this->getIdUsuarioLogado();
        $usuario = $this->usuarioDao->findById($idUsuarioLogado);
        $dados['usuario'] = $usuario;

        $this->loadView("perfil/perfil.php", $dados);
    }

    // Salva a foto de perfil do usuário
    protected function save()
    {
        $erros = [];

        // Verifica se a foto foi enviada
        if (isset($_FILES['foto']) && !empty($_FILES['foto']['name'])) {
            $foto = $_FILES["foto"];

            // Valida a imagem usando o serviço
            $erros = $this->usuarioService->validarFotoPerfil($foto);

            if (! $erros) {
                // 1 - Salva o arquivo da imagem
                $fotoNome = $this->arquivoService->salvarArquivo($foto);

                // 2 - Atualiza o nome do arquivo de imagem no usuário
                $idUsuarioLogado = $this->getIdUsuarioLogado();
                $usuario = $this->usuarioDao->findById($idUsuarioLogado);

                $usuario->setFotoPerfil($fotoNome);


                // TODO: Certifique-se de que o método update atualiza a foto
                $this->usuarioDao->update($usuario);
            }
        } else {
            // Nenhuma imagem foi enviada
            $erros[] = "Nenhuma foto foi enviada.";
        }

        // Carrega novamente os dados e exibe os erros na view
        $idUsuarioLogado = $this->getIdUsuarioLogado();
        $usuario = $this->usuarioDao->findById($idUsuarioLogado);

        $this->loginService->salvarUsuarioSessao($usuario);

        $dados['usuario'] = $usuario;

        $msgErro = implode("<br>", $erros);

        $this->loadView("perfil/perfil.php", $dados, $msgErro);
    }

    protected function editarPerfil() {
         
    }

    protected function salvarEdicaoPerfil() {
        //Chamar o UsuarioDAO para fazer o update no banco

    }


}

new PerfilController();
