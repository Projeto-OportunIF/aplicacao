<?php

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../dao/CursoDAO.php");
require_once(__DIR__ . "/../service/UsuarioService.php");
require_once(__DIR__ . "/../service/CadastroService.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../model/enum/UsuarioTipo.php");


class CadastroController extends Controller {

    private UsuarioDAO $usuarioDao;
    private cadastroService $cadastroService;
    private CursoDAO $cursoDAO;

    public function __construct() {
        $this->usuarioDao = new UsuarioDAO();
        $this->cadastroService = new CadastroService();
        $this->cursoDAO = new CursoDAO();

        $this->handleAction();
    }
      
    protected function cadastrar() {
        $dados['id'] = 0;
        $dados['tipoUsuario'] = UsuarioTipo::getSemAdminAsArray();
        $dados['cursos'] = $this->cursoDAO->list();

        $this->loadView("cadastro/form.php", $dados);

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
        $erros = $this->cadastroService->validarDados($usuario, $confSenha);
       if (! $erros) {
    try {
        if ($usuario->getId() == 0) {
            // Verifica se e-mail já existe
            $usuarioExistente = $this->usuarioDao->findByEmail($usuario->getEmail());
            if ($usuarioExistente) {
                array_push($erros, "Já existe um usuário com este e-mail!");
            } else {
                $this->usuarioDao->insert($usuario);
                header("location: " . BASEURL . "/controller/UsuarioController.php?action=list");
                exit;
            }
        } else {
            $this->usuarioDao->update($usuario);
            header("location: " . BASEURL . "/controller/UsuarioController.php?action=list");
            exit;
        }

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

        $this->loadView("cadastro/form.php", $dados, $msgErro);



    }


}

new CadastroController();
