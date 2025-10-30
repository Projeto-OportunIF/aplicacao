<?php
require_once(__DIR__ . "/Controller.php");
require_once(__DIR__ . "/../dao/OportunidadeDAO.php");


class InscricaoController extends Controller
{
    private OportunidadeDAO $oportunidadeDao;


    public function __construct()
    {
        if (!$this->usuarioEstaLogado()) return;


        $this->oportunidadeDao = new OportunidadeDAO();

        $this->handleAction();
    }


    public function view(string $msgErro = "", string $msgSucesso = "")
    {
        $oportunidade = $this->findOportunidadeById();

        $dados["oportunidade"] = $oportunidade;
        $this->loadView("inscricao/oportunidade_inscricao.php", $dados, $msgErro, $msgSucesso);
    }


    private function findOportunidadeById()
    {
        $id = 0;
        if (isset($_GET["idOport"]))
            $id = $_GET["idOport"];

        //Busca o usuário na base pelo ID    
        return $this->oportunidadeDao->findById($id);
    }

    public function inscrever()
    {
        $idOport = $_GET['idOport'] ?? 0;
        $idAluno = $_SESSION['usuarioLogadoId'];

        require_once(__DIR__ . "/../dao/InscricaoDAO.php");

        $inscricaoDao = new InscricaoDAO();

        // Evita duplicidade
        if ($inscricaoDao->findByAlunoEOportunidade($idAluno, $idOport)) {
            $_SESSION['msgErro'] = "Você não pode se inscrever nesta oportunidade pois já está inscrito na mesma!";
            header("Location: " . BASEURL . "/controller/HomeController.php?action=homeAluno");
            exit;
        }

        $oportunidade = $this->findOportunidadeById();
        $uploadDir = __DIR__ . "/../../uploads/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $documentosSalvos = [];

        if (isset($_FILES['documentoAluno'])) {
            foreach ($_FILES['documentoAluno']['tmp_name'] as $key => $tmpName) {
                if ($_FILES['documentoAluno']['error'][$key] === 0 && !empty($tmpName)) {
                    $nomeArquivo = time() . "_" . basename($_FILES['documentoAluno']['name'][$key]);
                    $caminho = $uploadDir . $nomeArquivo;
                    if (move_uploaded_file($tmpName, $caminho)) {
                        $documentosSalvos[] = $nomeArquivo;
                    }
                }
            }
        }

        // Validação do documento obrigatório
        $erros = [];
        if (!empty($oportunidade->getDocumentoAnexo()) && count($documentosSalvos) === 0) {
            $erros[] = "O envio de pelo menos um documento é obrigatório para esta oportunidade.";
        }

        if (count($erros) > 0) {
            $_SESSION['msgErro'] = implode("<br>", $erros);
            header("Location: " . BASEURL . "/controller/OportunidadeController.php?action=oportunidade_inscricao&idOport=$idOport");
            exit;
        }

        // Salva nomes separados por vírgula no banco
        $documentosString = implode(',', $documentosSalvos);

        $inscricaoDao->insert($idAluno, $idOport, $documentosString);

        $_SESSION['msgSucesso'] = "Inscrição realizada com sucesso! Vá em \"Minhas Inscrições\" para visualizar.";
        header("Location: " . BASEURL . "/controller/HomeController.php?action=homeAluno");
        exit;
    }


    protected function listarInscricoes()
    {
        $idAluno = $_SESSION['usuarioLogadoId'];
        require_once(__DIR__ . "/../dao/InscricaoDAO.php");

        $inscricaoDao = new InscricaoDAO();
        $inscricoes = $inscricaoDao->listByAluno($idAluno);

        $dados["inscricoes"] = $inscricoes;
        $this->loadView("inscricao/inscricao_list.php", $dados);
    }
    protected function cancelar()
    {
        if (!isset($_GET['idInscricao'])) {
            $_SESSION['msgErro'] = "Inscrição não encontrada!";
            header("Location: " . BASEURL . "/controller/InscricaoController.php?action=listarInscricoes");
            exit;
        }

        $idInscricao = intval($_GET['idInscricao']);
        $idAluno = $_SESSION['usuarioLogadoId'];

        require_once(__DIR__ . "/../dao/InscricaoDAO.php");
        $inscricaoDao = new InscricaoDAO();

        // Verifica se realmente pertence ao aluno logado
        $inscricao = $inscricaoDao->findByAlunoEInscricao($idAluno, $idInscricao);
        if (!$inscricao) {
            $_SESSION['msgErro'] = "Você não pode cancelar esta inscrição.";
            header("Location: " . BASEURL . "/controller/InscricaoController.php?action=listarInscricoes");
            exit;
        }

        // Cancela a inscrição
        $inscricaoDao->deleteById($idInscricao);

        $_SESSION['msgSucesso'] = "Inscrição cancelada com sucesso!";
        header("Location: " . BASEURL . "/controller/InscricaoController.php?action=listarInscricoes");
        exit;
    }
}


new InscricaoController();
