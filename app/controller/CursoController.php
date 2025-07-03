<?php

require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/CursoDAO.php");
require_once(__DIR__ . "/../model/Curso.php");
require_once(__DIR__ . "/../service/CursoService.php");

class CursoController extends Controller
{
    private CursoDAO $cursoDAO;
    private CursoService $cursoService;

    public function __construct()
    {
        $this->cursoDAO = new CursoDAO();
        $this->cursoService = new CursoService();
        $this->handleAction();
    }

    protected function create()
    {
        $dados['id'] = 0;
        $this->loadView("curso/form.php", $dados);
    }

    protected function save()
    {
        $id = $_POST['id'] ?? 0;
        $nome = trim($_POST['nome']) ?? null;

        $curso = new Curso();
        $curso->setId($id);
        $curso->setNome($nome);


        $erros = $this->cursoService->validarDados($curso);
        if (! $erros) {
            //Inserir no Base de Dados
            try {
                if ($curso->getId() == 0)
                    $this->cursoDAO->insert($curso);
                else
                    $this->cursoDAO->update($curso);

                header("location: " . BASEURL . "/controller/CursoController.php?action=list");
                exit;
            } catch (PDOException $e) {
                //Iserir erro no array
                array_push($erros, "Erro ao gravar no banco de dados!");
                array_push($erros, $e->getMessage());
            }
        }
        
        $msgErro = implode("<br>", $erros);
        $dados['id'] = $id;
        $dados['curso'] = $curso;

        $this->loadView("curso/form.php", $dados, $msgErro);
    }

    protected function list()
    {
        $cursos = $this->cursoDAO->list();
        $dados['cursos'] = $cursos;

        $this->loadView("curso/list.php", $dados);
    }

    protected function edit()
    {
        $id = $_GET['id'] ?? 0;
        $curso = $this->cursoDAO->findById($id);

        if ($curso) {
            $dados['id'] = $curso->getId();
            $dados['curso'] = $curso;
            $this->loadView("curso/form.php", $dados);
        } else {
            $this->list("Curso não encontrado.");
        }
    }

    protected function delete()
    {
        $id = $_GET['id'] ?? 0;
        $this->cursoDAO->deleteById($id);
        header("Location: " . BASEURL . "/controller/CursoController.php?action=list");
        exit;
    }
}

new CursoController();
