<?php
#Classe controller padrão

require_once(__DIR__ . "/../util/config.php");

class Controller
{

    //Método que efetua a chamada do ação conforme parâmetro GET recebido pela requisição
    protected function handleAction()
    {
        //Captura a ação do parâmetro GET
        $action = NULL;
        if (isset($_GET['action']))
            $action = $_GET['action'];

        //Chama a ação
        $this->callAction($action);
    }

    protected function callAction($methodName)
    {
        //Verifica se o método da action recebido por parâmetro existe na classe
        //Se sim, chama-o
        if ($methodName && method_exists($this, $methodName))
            $this->$methodName();

        else {
            echo "Ação não encontrada no controller.<br>";
            echo "Verifique com o administrador do sistema.";
        }
    }

    protected function loadView(string $path, array $dados, string $msgErro = "", string $msgSucesso = "")
    {

        $caminho = __DIR__ . "/../view/" . $path;
        //echo $caminho;
        if (file_exists($caminho)) {
            extract($dados);  // <-- ESSA LINHA DEIXA AS VARIÁVEIS DISPONÍVEIS NA VIEW
            require $caminho;
        } else {
            echo "Erro ao carrega a view solicitada<br>";
            echo "Caminho: " . $caminho;
        }
    }

    protected function usuarioEstaLogado()
    {
        session_start();

        if (! isset($_SESSION[SESSAO_USUARIO_ID])) {
            header("location: " . LOGIN_PAGE);
            return false;
        }
        return true;
    }

    protected function getIdUsuarioLogado()
    {
        if (session_status() != PHP_SESSION_ACTIVE)
            session_start();

        if (isset($_SESSION[SESSAO_USUARIO_ID]))
            return $_SESSION[SESSAO_USUARIO_ID];

        return 0;
    }

    protected function isUsuarioLogadoAdmin()
    {
        if (session_status() != PHP_SESSION_ACTIVE)
            session_start();

        if (isset($_SESSION[SESSAO_USUARIO_ID])) {
            if ($_SESSION[SESSAO_USUARIO_TIPO] == UsuarioTipo::ADMINISTRADOR)
                return true;
        }

        return false;
    }

    protected function verificarPermissao(array $tiposPermitidos)
    {
        if (session_status() != PHP_SESSION_ACTIVE)
            session_start();

        if (!isset($_SESSION[SESSAO_USUARIO_TIPO])) {
            $_SESSION['msgErro'] = "Você precisa estar logado para acessar esta página.";
            header("Location: " . LOGIN_PAGE);
            exit;
        }

        $tipoUsuario = $_SESSION[SESSAO_USUARIO_TIPO];

        if (!in_array($tipoUsuario, $tiposPermitidos)) {
            $_SESSION['msgErro'] = "🚫 Você não tem permissão para acessar esta área.";

            switch ($tipoUsuario) {
                case UsuarioTipo::ADMINISTRADOR:
                    header("Location: " . BASEURL . "/controller/HomeController.php?action=homeAdministrador");
                    break;
                case UsuarioTipo::PROFESSOR:
                    header("Location: " . BASEURL . "/controller/HomeController.php?action=homeProfessor");
                    break;
                case UsuarioTipo::ALUNO:
                    header("Location: " . BASEURL . "/controller/HomeController.php?action=homeAluno");
                    break;
            }
            exit;
        }
    }
}
