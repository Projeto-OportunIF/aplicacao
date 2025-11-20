<?php
# Nome do arquivo: NotificacaoDAO.php
# Objetivo: gerenciar as notificações dos usuários


require_once(__DIR__ . "/../connection/Connection.php");
require_once(__DIR__ . "/../model/Notificacao.php");



class NotificacaoDAO
{
    private $conn;


    public function __construct()
    {
        $this->conn = Connection::getConn();
    }


    public function countNotificacoesByUsuario(int $idUsuario)
    {
        $sql = "SELECT COUNT(*) AS total_notificacoes
            FROM notificacoes_usuarios
            WHERE idUsuario = :id AND status != 'LIDO'";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $idUsuario);
        $stmt->execute();


        $count = $stmt->fetch(PDO::FETCH_ASSOC);
        return $count;
    }




    // Enviar nova notificação
    public function notificarUsuario(string $mensagem, int $idUsuario)
    {
        $sql = "INSERT INTO notificacoes (mensagem) VALUES (:mensagem)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":mensagem", $mensagem);
        $stmt->execute();

        $idNotificacao = $this->conn->lastInsertId();

        $sql = "INSERT INTO notificacoes_usuarios (idNotificacao, idUsuario) VALUES (:idNotificacao, :idUsuario)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":idNotificacao", $idNotificacao);
        $stmt->bindValue(":idUsuario", $idUsuario);
        $stmt->execute();
    }


    // Enviar nova notificação
    public function notificarUsuariosByCurso(string $mensagem, array $cursos, int  $idOportunidade)
    {
        $idCursos = implode(',', array_fill(0, count($cursos), '?'));

        $sql = "INSERT INTO notificacoes (mensagem, dataEnvio, idOportunidade) VALUES (:mensagem, :dataEnvio, :idOportunidade)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":mensagem", $mensagem);
        $stmt->bindValue(":dataEnvio", date('Y-m-d'));
        $stmt->bindValue(":idOportunidade", $idOportunidade);

        $stmt->execute();

        $idNotificacao = $this->conn->lastInsertId();

        $sql = "SELECT idUsuarios FROM usuarios WHERE idCursos IN ($idCursos)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute($cursos);
        $idUsuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);


        foreach ($idUsuarios as $id) {


            $sql = "INSERT INTO notificacoes_usuarios (idNotificacao, idUsuario) VALUES (:idNotificacao, :idUsuario)";


            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":idNotificacao", $idNotificacao);
            $stmt->bindValue(":idUsuario", $id["idUsuarios"]);
            $stmt->execute();
        }
    }


    public function notificarUsuarioById(string $mensagem,  int $id)
    {
        $sql = "INSERT INTO notificacoes (mensagem, dataEnvio) VALUES (:mensagem, :dataEnvio)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":mensagem", $mensagem);
        $stmt->bindValue(":dataEnvio", date('Y-m-d'));

        $stmt->execute();

        $idNotificacao = $this->conn->lastInsertId();

        $sql = "INSERT INTO notificacoes_usuarios (idNotificacao, idUsuario) VALUES (:idNotificacao, :idUsuario)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":idNotificacao", $idNotificacao);
        $stmt->bindValue(":idUsuario", $id);
        $stmt->execute();
    }

    public function notificarProfessorPorNovaInscricao($idOportunidade)
    {
        // Passo 1: Busca os dados da oportunidade
        $sql = "SELECT o.titulo, o.tipoOportunidade, o.idProfessor
            FROM oportunidades o
            WHERE o.idOportunidades = :idOportunidade";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":idOportunidade", $idOportunidade, PDO::PARAM_INT);
        $stmt->execute();

        $dados = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$dados) return;

        $titulo = $dados["titulo"];
        $nomeProfessor = $dados["professor"];

        // Passo 2: Busca o ID do professor
        $sqlProf = "SELECT idUsuarios FROM usuarios WHERE nomeCompleto = :nomeProfessor LIMIT 1";
        $stmtProf = $this->conn->prepare($sqlProf);
        $stmtProf->bindValue(":nomeProfessor", $nomeProfessor);
        $stmtProf->execute();

        $professor = $stmtProf->fetch(PDO::FETCH_ASSOC);
        if (!$professor) return;

        $idProfessor = $professor["idUsuarios"];

        // Passo 3: Cria mensagem e link
        $mensagem = "Um novo aluno se inscreveu na sua oportunidade \"$titulo\".";
        $link = BASEURL . "/controller/InscricaoController.php?action=listarInscritos&idOport=" . $idOportunidade;

        // Passo 4: Insere notificação na tabela notificacoes
        $sqlInsertNotificacao = "INSERT INTO notificacoes (mensagem, link, idOportunidade, dataEnvio)
                             VALUES (:mensagem, :link, :idOportunidade, NOW())";
        $stmtInsertNotificacao = $this->conn->prepare($sqlInsertNotificacao);
        $stmtInsertNotificacao->bindValue(":mensagem", $mensagem);
        $stmtInsertNotificacao->bindValue(":link", $link);
        $stmtInsertNotificacao->bindValue(":idOportunidade", $idOportunidade, PDO::PARAM_INT);
        $stmtInsertNotificacao->execute();

        $idNotificacao = $this->conn->lastInsertId();

        // Passo 5: Relaciona com o professor
        $sqlInsertRelacao = "INSERT INTO notificacoes_usuarios (idNotificacao, idUsuario, status)
                         VALUES (:idNotificacao, :idUsuario, 'ENVIADO')";
        $stmtInsertRelacao = $this->conn->prepare($sqlInsertRelacao);
        $stmtInsertRelacao->bindValue(":idNotificacao", $idNotificacao, PDO::PARAM_INT);
        $stmtInsertRelacao->bindValue(":idUsuario", $idProfessor, PDO::PARAM_INT);
        $stmtInsertRelacao->execute();
    }




    // Listar notificações por usuário
    public function listByUsuario(int $idUsuario)
    {
        $sql = "SELECT n.idNotificacoes, n.mensagem, n.dataEnvio, n.link, n.idOportunidade
            FROM notificacoes AS n
            INNER JOIN notificacoes_usuarios AS nu
                ON n.idNotificacoes = nu.idNotificacao
            WHERE nu.idUsuario = :idUsuario
              AND nu.status != 'LIDO'
            ORDER BY n.dataEnvio DESC";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        $notificacoes =  $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->mapNotificacoes($notificacoes);
    }

    public function atualizarStatusPorUsuario($idUsuario, $idNotificacao)
    {
        $sql = "UPDATE notificacoes_usuarios
                SET status = 'LIDO'
                WHERE idUsuario = :idUsuario AND idNotificacao = :idNotificacao";


        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':idUsuario', $idUsuario);
        $stmt->bindValue(':idNotificacao', $idNotificacao);


        return $stmt->execute();
    }



    public function mapNotificacoes($notificacoes): array
    {
        $listaNotificacoes = [];

        foreach ($notificacoes as $notificacao) {

            $notificacaoObj = new Notificacao();

            // Campos principais
            $notificacaoObj->setId($notificacao['idNotificacoes']);
            $notificacaoObj->setMensagem($notificacao['mensagem']);
            $notificacaoObj->setDataEnvio($notificacao['dataEnvio']);
            $notificacaoObj->setIdOportunidade($notificacao['idOportunidade']);
            $notificacaoObj->setLink($notificacao['link']);



            if (isset($notificacao['idOportunidade'])) {
                $notificacaoObj->setIdOportunidade($notificacao['idOportunidade']);
            }


            if (isset($notificacao['link'])) {
                $notificacaoObj->setLink($notificacao['link']);
            }

            $listaNotificacoes[] = $notificacaoObj;
        }

        return $listaNotificacoes;
    }







    /*






    // Listar todas as notificações
    public function listAll()
    {
        $sql = "SELECT * FROM notificacoes ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    // Buscar notificação por ID
    public function findById(int $id)
    {
        $sql = "SELECT * FROM notificacoes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }






    // Atualizar dados da notificação
    public function update(int $id, string $mensagem, string $dataEnvio, string $status, int $idUsuarios)
    {
        $sql = "UPDATE notificacoes
                SET mensagem = :mensagem, dataEnvio = :dataEnvio, status = :status, idUsuarios = :idUsuarios
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":mensagem", $mensagem);
        $stmt->bindValue(":dataEnvio", $dataEnvio);
        $stmt->bindValue(":status", $status);
        $stmt->bindValue(":idUsuarios", $idUsuarios, PDO::PARAM_INT);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }


    // Deletar notificação por ID
    public function deleteById(int $id)
    {
        $sql = "DELETE FROM notificacoes WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }


    // Atualizar apenas o status da notificação
    public function updateStatus(int $id, string $novoStatus)
    {
        $sql = "UPDATE notificacoes SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":status", $novoStatus);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
    }
   
    */
}
