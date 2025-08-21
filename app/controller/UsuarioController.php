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

        //Criar o objeto Usuario
        $usuario = new Usuario();

        $dados['id'] = 0;
        $dados['tipoUsuario'] = UsuarioTipo::getAllAsArray();
        $dados['cursos'] = $this->cursoDAO->list();

        $this->loadView("usuario/cadastro_usuario_form.php", $dados);
    }

    protected function edit()
    {
        //Busca o usuário na base pelo ID    
        $usuario = $this->findUsuarioById();

        if ($usuario) {
            $dados['id'] = $usuario->getId();
            $usuario->setSenha("");
            $dados["usuario"] = $usuario;

            $dados['tipoUsuario'] = UsuarioTipo::getAllAsArray();
            $dados['cursos'] = $this->cursoDAO->list();

            $this->loadView("usuario/cadastro_usuario_form.php", $dados);
        } else
            $this->list("Usuário não encontrado!");
    }

    protected function save()
    {
        //Capturar os dados do formulário
        $id = $_POST['id'];
        $nomeCompleto = trim($_POST['nomeCompleto']) != "" ? trim($_POST['nomeCompleto']) : NULL;
        $email = trim($_POST['email']) != "" ? trim($_POST['email']) : NULL;
        $senha = trim($_POST['senha']) != "" ? trim($_POST['senha']) : NULL;
        $confSenha = trim($_POST['conf_senha']) !== "" ? trim($_POST['conf_senha']) : null;
        $cpf = trim($_POST['cpf']) != "" ? trim($_POST['cpf']) : NULL;
        $tipoUsuario = trim($_POST['tipoUsuario']) != "" ? trim($_POST['tipoUsuario']) : NULL;
        $matricula = trim($_POST['matricula']) != "" ? trim($_POST['matricula']) : NULL;
        $idCurso = trim($_POST['curso']) != "" ? trim($_POST['curso']) : NULL;

        //Criar o objeto do modelo
        $usuario = new Usuario();
        $usuario->setId($id);
        $usuario->setNomeCompleto($nomeCompleto);
        $usuario->setCpf($cpf);
        $usuario->setSenha($senha);
        $usuario->setEmail($email);
        $usuario->setMatricula($matricula);

        if ($idCurso) {
            $curso = new Curso();
            $curso->setId($idCurso);
            $usuario->setCurso($curso);
        } else
            $usuario->setCurso(NULL);

        $usuario->setTipoUsuario($tipoUsuario);


        //Validar os dados (camada service)
        $erros = $this->usuarioService->validarDados($usuario, $confSenha);
        if (! $erros) {
            //Inserir no Base de Dados
            try {
                if ($usuario->getId() == 0)
                    $this->usuarioDao->insert($usuario);
                else
                    $this->usuarioDao->update($usuario);

                header("location: " . BASEURL . "/controller/UsuarioController.php?action=list");
                exit;
            } catch (PDOException $e) {
                //Iserir erro no array
                array_push($erros, "Erro ao gravar no banco de dados!");
                array_push($erros, $e->getMessage());
            }
        }

        //Mostrar os erros
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

        //[{},{},{}]
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
