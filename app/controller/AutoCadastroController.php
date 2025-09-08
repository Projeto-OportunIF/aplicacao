<?php

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/CursoDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../service/AutoCadastroService.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/enum/UsuarioTipo.php");

class CadastroController extends Controller
{
    private UsuarioDAO $usuarioDao;
    private AutoCadastroService $cadastroService;
    private CursoDAO $cursoDAO;

    public function __construct()
    {
        $this->usuarioDao = new UsuarioDAO();
        $this->cadastroService = new AutoCadastroService();
        $this->cursoDAO = new CursoDAO();

        $this->handleAction();
    }

    protected function cadastrar()
    {
        $dados['id'] = 0;
        $dados['tipoUsuario'] = UsuarioTipo::getSemAdminAsArray();
        $dados['cursos'] = $this->cursoDAO->list();

        $this->loadView("autocadastro/autocadastro_form.php", $dados);
    }

    protected function save()
    {
        // Capturar os dados do formulário
        $id = $_POST['id'];
        $nomeCompleto = trim($_POST['nomeCompleto']) ?: null;
        $email = trim($_POST['email']) ?: null;
        $senha = trim($_POST['senha']) ?: null;
        $confSenha = trim($_POST['conf_senha']) ?: null;
        $cpf = trim($_POST['cpf']) ?: null;
        $tipoUsuario = trim($_POST['tipoUsuario']) ?: null;
        $matricula = trim($_POST['matricula']) ?: null;
        $idCurso = trim($_POST['curso']) ?: null;

        // Criar o objeto do modelo
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
        } else {
            $usuario->setCurso(null);
        }

        $usuario->setTipoUsuario($tipoUsuario);

        // Validar os dados (camada service)
        $erros = $this->cadastroService->validarDados($usuario, $confSenha);

        if (!$erros) {
            try {
                if ($usuario->getId() == 0) {
                    $this->usuarioDao->insert($usuario);
                } else {
                    $this->usuarioDao->update($usuario);
                }

                header("location: " . BASEURL . "/controller/UsuarioController.php?action=list");
                exit;
            } catch (PDOException $e) {
                $erros[] = "Erro ao gravar no banco de dados!";
                $erros[] = $e->getMessage();
            }
        }

        // Mostrar os erros
        $dados['id'] = $usuario->getId();
        $dados['tipoUsuario'] = UsuarioTipo::getAllAsArray();
        $dados['cursos'] = $this->cursoDAO->list();
        $dados['confSenha'] = $confSenha;
        $dados['usuario'] = $usuario;

        $msgErro = implode("<br>", $erros);

        $this->loadView("autocadastro/autocadastro_form.php", $dados, $msgErro);
    }
}

new CadastroController();
