<?php
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/OportunidadeDAO.php");
require_once(__DIR__ . "/../dao/CursoDAO.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../model/Oportunidade.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../service/OportunidadeService.php");


class OportunidadeController extends Controller
{
    private OportunidadeDAO $oportunidadeDao;
    private CursoDAO $cursoDao;
    private UsuarioDAO $usuarioDao;
    private Usuario $usuario;
    private OportunidadeService $service;


    public function __construct()
    {
        if (!$this->usuarioEstaLogado()) return;


        $this->oportunidadeDao = new OportunidadeDAO();
        $this->cursoDao = new CursoDAO();
        $this->usuarioDao = new UsuarioDAO();


        $this->service = new OportunidadeService();


        $this->handleAction();
    }


    protected function list(string $msgErro = "", string $msgSucesso = "")
    {
        $dados["lista"] = $this->oportunidadeDao->list();
        $this->loadView("oportunidade/oportunidade_list.php", $dados, $msgErro, $msgSucesso);
    }


    protected function create()
    {
        $dados['id'] = 0;
        $dados['nome'] = "Jefferson";
        $dados['cursos'] = $this->cursoDao->list();
        $this->loadView("oportunidade/oportunidade_cadastro.php", $dados);
    }


    protected function edit()
    {
        $id = $_GET["id"] ?? 0;
        $oportunidade = $this->oportunidadeDao->findById($id);


        if ($oportunidade) {
            $dados["id"] = $oportunidade->getId();
            $dados["oportunidade"] = $oportunidade;
            $dados["cursos"] = $this->cursoDao->list();
            $this->loadView("oportunidade/oportunidade_cadastro.php", $dados);
        } else {
            $this->list("Oportunidade não encontrada.");
        }
    }


    protected function save()
    {
        $id = $_POST["id"];
        $titulo = trim($_POST["titulo"]);
        $descricao = trim($_POST["descricao"]);
        $tipo = trim($_POST["tipo"]);
        $dataInicio = $_POST["dataInicio"];
        $dataFim = $_POST["dataFim"];
        $documento = trim($_POST["documento"]);
        $idCurso = $_POST["curso"];
        $vaga = isset($_POST["vaga"]) && $_POST["vaga"] !== "" ? (int)$_POST["vaga"] : null;





        $oportunidade = new Oportunidade();


        $oportunidade->setId($id);
        $oportunidade->setTitulo($titulo);
        $oportunidade->setDescricao($descricao);
        $oportunidade->setTipoOportunidade($tipo);
        $oportunidade->setDataInicio($dataInicio);
        $oportunidade->setDataFim($dataFim);
        $oportunidade->setDocumentoAnexo($documento);
        $oportunidade->setVaga($vaga);




        if ($idCurso) {
            $curso = new Curso();
            $curso->setId($idCurso);
            $oportunidade->setCurso($curso);
        } else {
            $oportunidade->setCurso(null);
        }


        // SETAR O PROFESSOR (usuário logado)
        if (isset($_SESSION["usuarioLogadoId"])) {


            $id_profesor = $_SESSION["usuarioLogadoId"];


            $professor = $this->usuarioDao->findById($id_profesor);


            $oportunidade->setProfessor($professor);
        }


        // VALIDAR
        $erros = $this->service->validarDados($oportunidade);


        if (count($erros) > 0) {
            $dados['oportunidade'] = $oportunidade;
            $dados['cursos'] = $this->cursoDao->list();
            $msgErro = implode("<br>", $erros);

            $dados['id'] = 0;


            $this->loadView("oportunidade/oportunidade_cadastro.php", $dados, $msgErro);
            return;
        }




        // print "<pre>";
        // print_r($oportunidade);
        // print "</pre>";
        // die;


        try {
            if ($oportunidade->getId() == 0) {

                $this->oportunidadeDao->insert($oportunidade);
            } else {
                $this->oportunidadeDao->update($oportunidade);
            }


            header("Location: " . BASEURL . "/controller/OportunidadeController.php?action=list");
            exit;
        } catch (PDOException $e) {
            $msgErro = "Erro ao gravar: " . $e->getMessage();


            $dados['id'] = 0;


            $dados['oportunidade'] = $oportunidade;
            $dados['cursos'] = $this->cursoDao->list();
            $this->loadView("oportunidade/oportunidade_cadastro.php", $dados, $msgErro);
        }
    }
    protected function delete()
    {
        $id = $_GET["id"] ?? 0;


        try {
            $this->oportunidadeDao->deleteById($id);
            $this->list("", "");
        } catch (PDOException $e) {
            $this->list("Erro ao excluir: " . $e->getMessage());
        }
    }


    protected function estagios() //colocar no oportunidade list essa parte, para ter só uma view de oportunidades e não, uma para cada  tipo de oportunidade
    {
        $usuarioLogado = $this->usuarioDao->findById($_SESSION["usuarioLogadoId"]);
        $idCurso = $usuarioLogado->getCurso()->getId();

        $dados["oportunidades"] = $this->oportunidadeDao->listByTipoECurso(OportunidadeTipo::ESTAGIO, $idCurso);
        $this->loadView("oportunidade/oportunidades_disponiveis.php", $dados);
    }


    protected function projetopesquisa()
    {
        $usuarioLogado = $this->usuarioDao->findById($_SESSION["usuarioLogadoId"]);
        $idCurso = $usuarioLogado->getCurso()->getId();

        $dados["oportunidades"] = $this->oportunidadeDao->listByTipoECurso(OportunidadeTipo::PROJETOPESQUISA, $idCurso);
        $this->loadView("oportunidade/oportunidades_disponiveis.php", $dados);
    }


    protected function projetoextensao()
    {
        $usuarioLogado = $this->usuarioDao->findById($_SESSION["usuarioLogadoId"]);
        $idCurso = $usuarioLogado->getCurso()->getId();

        $dados["oportunidades"] = $this->oportunidadeDao->listByTipoECurso(OportunidadeTipo::PROJETOEXTENSAO, $idCurso);
        $this->loadView("oportunidade/oportunidades_disponiveis.php", $dados);
    }
}


new OportunidadeController();
