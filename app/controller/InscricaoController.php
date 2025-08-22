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


    protected function view(string $msgErro = "", string $msgSucesso = "")
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

   protected function inscrever()
{
    $idOport = $_GET['idOport'] ?? 0;
    $idAluno = $_SESSION['usuarioLogadoId'];

    require_once(__DIR__ . "/../dao/InscricaoDAO.php");
    require_once(__DIR__ . "/../service/DocsInscricaoService.php");

    $inscricaoDao = new InscricaoDAO();
    $service = new InscricaoService();

    // Verifica se já existe inscrição
    if ($inscricaoDao->findByAlunoEOportunidade($idAluno, $idOport)) {
        $_SESSION['msgSucesso'] = "Você já está inscrito nesta oportunidade!";
        header("Location: " . BASEURL . "/controller/HomeController.php?action=homeAluno");
        exit;
    }

    // Diretório de upload
    $uploadDir = __DIR__ . "/../../uploads/";

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Captura o arquivo
    $documento = null;
    if (isset($_FILES['documentoAluno']) && $_FILES['documentoAluno']['error'] === 0) {
        $nomeArquivo = time() . "_" . basename($_FILES['documentoAluno']['name']);
        $caminho = $uploadDir . $nomeArquivo;

        if (move_uploaded_file($_FILES['documentoAluno']['tmp_name'], $caminho)) {
            $documento = $nomeArquivo;
        }
    }

    // Validação do documento obrigatório
    $erros = $service->validarDados(['documento' => $documento]);
    if (count($erros) > 0) {
        $_SESSION['msgErro'] = implode("<br>", $erros);
        header("Location: " . BASEURL . "/controller/OportunidadeController.php?action=oportunidade_inscricao&idOport=$idOport");
        exit;
    }

    // Inserir inscrição no banco
    $inscricaoDao->insert($idAluno, $idOport, $documento);

    // Mensagem de sucesso e redirecionamento
    $_SESSION['msgSucesso'] = "Inscrição realizada com sucesso!";
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

}


new InscricaoController();
