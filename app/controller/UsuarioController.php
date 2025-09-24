<?php
#Classe controller para Usuário
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/CursoDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/enum/UsuarioTipo.php");



class UsuarioController extends Controller
{

    private UsuarioDAO $usuarioDao;
    private UsuarioService $usuarioService;
    private CursoDAO $cursoDAO;

    //Método construtor do controller - será executado a cada requisição a está classe
    public function __construct()
    {
        if (! $this->usuarioEstaLogado())
            return;

        //Verificar se o usuário é ADMIN
        if (! $this->isUsuarioLogadoAdmin()) {
            echo "Acesso negado!";
            return;
        }

        $this->usuarioDao = new UsuarioDAO();
        $this->usuarioService = new UsuarioService();
        $this->cursoDAO = new CursoDAO();

        $this->handleAction();
    }

    protected function list(string $msgErro = "", string $msgSucesso = "")
    {
        $dados["lista"] = $this->usuarioDao->list();

        $this->loadView("usuario/usuario_list.php", $dados,  $msgErro, $msgSucesso);
    }
    protected function create()
    {
        $dados['id'] = 0;
        $dados['tipoUsuario'] = UsuarioTipo::getAllAsArray();
        $dados['cursos'] = $this->cursoDAO->list();
        $dados['senhaPadrao'] = 'IFPR@SENHA123';


        $this->loadView("usuario/cadastro_usuario_form.php", $dados);
    }
    protected function edit()
    {
        //Busca o usuário na base pelo ID    
        $usuario = $this->findUsuarioById();

        if ($usuario) {
            $dados['id'] = $usuario->getId();

            // senha padrão em texto puro
            $senhaPadrao = "IFPR@1234"; // senha que o admin verá
            $usuario->setSenha(password_hash($senhaPadrao, PASSWORD_DEFAULT));
            $this->usuarioDao->update($usuario);

            // Passa a senha em texto puro para a view
            $dados['resetarSenha'] = true;
            $dados['usuario'] = $usuario;
            $dados['senhaPadrao'] = $senhaPadrao; // <-- aqui!


            $dados['tipoUsuario'] = UsuarioTipo::getAllAsArray();
            $dados['cursos'] = $this->cursoDAO->list();

            $this->loadView("usuario/cadastro_usuario_form.php", $dados);
        } else {
            $this->list("Usuário não encontrado!");
        }
    }

    protected function save()
    {
        // Captura os dados do formulário
        $id = $_POST['id'] ?? 0;
        $nomeCompleto = trim($_POST['nomeCompleto']) ?: null;
        $email = trim($_POST['email']) ?: '';
        $senhaPost = isset($_POST['senha']) ? trim($_POST['senha']) : null;
        $confSenha = isset($_POST['conf_senha']) ? trim($_POST['conf_senha']) : null;
        $cpf = trim($_POST['cpf']) ?: null;
        $tipoUsuario = trim($_POST['tipoUsuario']) ?: null;
        $matricula = trim($_POST['matricula']) ?: null;
        $idCurso = trim($_POST['curso']) !== "" ? (int) $_POST['curso'] : null;
        $resetSenha = isset($_POST['reset_senha']);

        // Cria o objeto Usuario (campos básicos)
        $usuario = new Usuario();
        $usuario->setId($id);
        $usuario->setNomeCompleto($nomeCompleto);
        $usuario->setCpf($cpf);
        $usuario->setEmail($email);
        $usuario->setMatricula($matricula);
        $usuario->setTipoUsuario($tipoUsuario);


        if ($idCurso) {
            $curso = new Curso();
            $curso->setId($idCurso);
            $usuario->setCurso($curso);
        } else {
            $usuario->setCurso(null);
        }
        // === Lógica de senha ===
        if ($resetSenha) {
            // admin pediu reset -> vamos prepara a senha padrão (visível) para validação
            $senhaPadrao = "IFPR@1234";
            // para validação colocamos a senha em texto no objeto e em confSenha
            $usuario->setSenha($senhaPadrao);
            $confSenha = $senhaPadrao;
            // para a view mostrar a senha limpa
            $dados['senhaVisivel'] = $senhaPadrao;
        } else {
            if ($id != 0) {

                $usuarioExistente = $this->usuarioDao->findById($id);
                if ($usuarioExistente) {

                    $usuario->setSenha($usuarioExistente->getSenha());

                    $confSenha = $usuarioExistente->getSenha();
                } else {

                    $usuario->setSenha($senhaPost);
                }
            } else {

                $usuario->setSenha($senhaPost);
                // confSenha vem do form
            }
        }
        // Validação via service
        $erros = $this->usuarioService->validarDados($usuario, $confSenha);

        if (!$erros) {
            try {
                // Antes de persistir, garantir que o que for salvo no banco é HASH
                if ($id == 0 || $resetSenha) {
                    // se for inserção ou reset, hash da senha em texto
                    $plain = $resetSenha ? $senhaPadrao : $senhaPost;
                    $usuario->setSenha(password_hash($plain, PASSWORD_DEFAULT));
                }
                // Se for edição sem reset, já colocamos o hash do DB no $usuario

                if ($usuario->getId() == 0) {
                    $this->usuarioDao->insert($usuario);
                    header("location: " . BASEURL . "/controller/UsuarioController.php?action=list");
                    exit;
                } else {
                    $this->usuarioDao->update($usuario);

                    if ($resetSenha) {
                        // Se resetou, NÃO redirecionamos: reexibimos o form com a senha visível
                        $msgSucesso = "Senha resetada com sucesso.";
                        // buscar dados atuais do usuário pro formulário
                        $usuarioAtualizado = $this->usuarioDao->findById($usuario->getId());
                        $dados['id'] = $usuarioAtualizado->getId();
                        $dados['usuario'] = $usuarioAtualizado;
                        $dados['tipoUsuario'] = UsuarioTipo::getAllAsArray();
                        $dados['cursos'] = $this->cursoDAO->list();
                        $dados['confSenha'] = null;
                        // já temos $dados['senhaVisivel'] definido acima
                        $this->loadView("usuario/cadastro_usuario_form.php", $dados, "", $msgSucesso);
                        return;
                    } else {
                        header("location: " . BASEURL . "/controller/UsuarioController.php?action=list");
                        exit;
                    }
                }
            } catch (PDOException $e) {
                $erros[] = "Erro ao gravar no banco de dados!";
                $erros[] = $e->getMessage();
            }
        }
        // Se houver erros, reexibir form com dados e mensagens
        $dados['id'] = $usuario->getId();
        $dados['tipoUsuario'] = UsuarioTipo::getAllAsArray();
        $dados['cursos'] = $this->cursoDAO->list();
        $dados['confSenha'] = $confSenha;
        $dados['usuario'] = $usuario;
        $msgErro = implode("<br>", $erros);
        $this->loadView("usuario/cadastro_usuario_form.php", $dados, $msgErro);
    }
    protected function delete()
    {
        //Busca o usuário na base pelo ID    
        $usuario = $this->findUsuarioById();

        if ($usuario) {
            //Excluir
            $this->usuarioDao->deleteById($usuario->getId());

            header("location: " . BASEURL . "/controller/UsuarioController.php?action=list");
            exit;
        } else {
            $this->list("Usuário não encontrado!");
        }
    }
    protected function listJson()
    {
        //Retornar uma lista de usuários em forma JSON
        $usuarios = $this->usuarioDao->list();
        $json = json_encode($usuarios);

        echo $json;
    }

    private function findUsuarioById()
    {
        $id = 0;
        if (isset($_GET["id"]))
            $id = $_GET["id"];

        //Busca o usuário na base pelo ID    
        return $this->usuarioDao->findById($id);
    }
}
#Criar objeto da classe para assim executar o construtor
new UsuarioController();
