<?php
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/OportunidadeDAO.php");
require_once(__DIR__ . "/../dao/CursoDAO.php");
require_once(__DIR__ . "/../dao/UsuarioDAO.php");
require_once(__DIR__ . "/../model/Oportunidade.php");
require_once(__DIR__ . "/../model/Usuario.php");
require_once(__DIR__ . "/../service/OportunidadeService.php");
require_once(__DIR__ . "/../service/NotificacaoService.php");






class OportunidadeController extends Controller
{
    private OportunidadeDAO $oportunidadeDao;
    private CursoDAO $cursoDao;
    private UsuarioDAO $usuarioDao;
    private Usuario $usuario;
    private OportunidadeService $service;
    private NotificacaoService $notificacaoService;






    public function __construct()
    {
        if (!$this->usuarioEstaLogado()) return;




        $this->oportunidadeDao = new OportunidadeDAO();
        $this->cursoDao = new CursoDAO();
        $this->usuarioDao = new UsuarioDAO();




        $this->service = new OportunidadeService();
        $this->notificacaoService = new NotificacaoService();




        $this->handleAction();
    }




    protected function list(string $msgErro = "", string $msgSucesso = "")
    {
        $dados["lista"] = $this->oportunidadeDao->list();
        $this->loadView("oportunidade/oportunidade_list.php", $dados, $msgErro, $msgSucesso);
    }




    protected function create()
    {
        //TODO: VERIFICAR
        $dados['id'] = 0;
        $dados['nome'] = "Jefferson";
        $dados['cursos'] = $this->cursoDao->list();
        $this->loadView("oportunidade/oportunidade_cadastro_form.php", $dados);
    }




    protected function edit()
    {
        $id = $_GET["id"] ?? 0;
        $oportunidade = $this->oportunidadeDao->findById($id);


        if ($oportunidade) {
            $dados["id"] = $oportunidade->getId();
            $dados["oportunidade"] = $oportunidade;
            $dados["cursos"] = $this->cursoDao->list();


            // Buscar cursos associados à oportunidade
            // Esse método precisa existir no OportunidadeDAO
            $dados["oportunidadeCursos"] = $this->oportunidadeDao->getCursosByOportunidade($id);


            $this->loadView("oportunidade/oportunidade_cadastro_form.php", $dados);
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
        $documento = isset($_POST["documento"]) ? trim($_POST["documento"]) : '';

        $idCursos = $_POST['cursos'] ?? [];
        $vaga = isset($_POST["vaga"]) && $_POST["vaga"] !== "" ? (int)$_POST["vaga"] : null;


        $oportunidade = new Oportunidade();
        $oportunidade->setId($id);
        $oportunidade->setTitulo($titulo);
        $oportunidade->setDescricao($descricao);
        $oportunidade->setTipoOportunidade($tipo);
        $oportunidade->setDataInicio($dataInicio);
        $oportunidade->setDataFim($dataFim);
        $oportunidade->setDocumentoAnexo(isset($_POST['documentoAnexo']) ? trim($_POST['documentoAnexo']) : '');

        $oportunidade->setVaga($vaga);


        // =======================
        // PROCESSAR DOCUMENTO EDITAL (UPLOAD)
        // =======================
        if (isset($_FILES['documentoEdital']) && $_FILES['documentoEdital']['error'] == UPLOAD_ERR_OK) {
            // gera nome único
            $nomeArquivoEdital = uniqid('edital_') . '_' . basename($_FILES['documentoEdital']['name']);
            $caminhoDestino = __DIR__ . "/../../uploads/" . $nomeArquivoEdital;


            if (move_uploaded_file($_FILES['documentoEdital']['tmp_name'], $caminhoDestino)) {
                $oportunidade->setDocumentoEdital($nomeArquivoEdital);
            } else {
                $oportunidade->setDocumentoEdital(null);
            }
        } elseif (!empty($_POST['documentoEditalExistente'])) {
            // mantém o arquivo antigo se não houver novo upload
            $oportunidade->setDocumentoEdital($_POST['documentoEditalExistente']);
        } else {
            $oportunidade->setDocumentoEdital(null);
        }
        // =======================


        // CURSOS
        if (empty($idCursos)) {
            $erros[] = "Selecione pelo menos um curso.";
        } else {
            $cursos = [];
            foreach ($idCursos as $idCurso) {
                $curso = new Curso();
                $curso->setId($idCurso);
                $cursos[] = $curso;
            }
            $oportunidade->setCursos($cursos);
        }


        // PROFESSOR RESPONSÁVEL (usuário logado)
        $professorResponsavel = trim($_POST["professor_responsavel"]);
        $oportunidade->setProfessorResponsavel($professorResponsavel);


        // VALIDAR DADOS
        $erros = $this->service->validarDados($oportunidade);


        if (count($erros) > 0) {
            $dados['oportunidade'] = $oportunidade;
            $dados['cursos'] = $this->cursoDao->list();
            $dados['oportunidadeCursos'] = $oportunidade->getCursos();
            $dados['id'] = $oportunidade->getId();
            $dados['erros'] = $erros;


            $this->loadView("oportunidade/oportunidade_cadastro_form.php", $dados);
            return;
        }


        // =======================
        // SALVAR NO BANCO
        // =======================
        try {
            if ($oportunidade->getId() == 0) {
                $this->oportunidadeDao->insert($oportunidade);
                $this->notificacaoService->notificarUsuariosByCurso(
                    "Uma nova oportunidade foi criada: $titulo",
                    $idCursos
                );
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
            $this->loadView("oportunidade/oportunidade_cadastro_form.php", $dados, $msgErro);
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


    protected function visualizarInscritos()
    {
        $idOport = $_GET['idOport'] ?? 0;
        $oportunidade = $this->oportunidadeDao->findById($idOport);


        if (!$oportunidade) {
            $_SESSION['msgErro'] = "Oportunidade não encontrada!";
            header("Location: " . BASEURL . "/controller/HomeController.php?action=homeProfessor");
            exit;
        }


        // segue com a lógica normal...




        // Busca inscritos
        require_once(__DIR__ . "/../dao/InscricaoDAO.php");
        $inscricaoDao = new InscricaoDAO();
        $inscritos = $inscricaoDao->listByOportunidadeDetalhado($idOport);


        $dados["oportunidade"] = $oportunidade;
        $dados["inscritos"] = $inscritos;


        $this->loadView("oportunidade/visualizar_inscritos.php", $dados);
    }


    public function alterarStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idInscricao = (int) $_POST['idInscricao'];
            $novoStatus = $_POST['novoStatus'];
            $feedbackProfessor = isset($_POST['feedbackProfessor']) ? trim($_POST['feedbackProfessor']) : null;


            require_once(__DIR__ . "/../dao/InscricaoDAO.php");
            $dao = new InscricaoDAO();
            $dao->updateStatus($idInscricao, $novoStatus, $feedbackProfessor);


            // Redireciona de volta para a lista de inscritos
            header("Location: " . BASEURL . "/controller/OportunidadeController.php?action=visualizarInscritos&idOport=" . (int)$_POST['idOport']);
            exit;
        }
    }
}






new OportunidadeController();
