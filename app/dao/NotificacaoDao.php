<?php
# Nome do arquivo: NotificacaoDAO.php
# Objetivo: gerenciar as notificações dos usuários

require_once(__DIR__ . "/../connection/Connection.php");

class NotificacaoDAO
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connection::getConn();
    }

    public function countNotificacoesByUsuario(int $idUsuario)
    {

        $sql = "SELECT COUNT(*) AS total_notificacoes FROM notificacoes_usuarios WHERE idUsuario = :id;";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":id", $idUsuario);
        $stmt->execute();

        $count = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $count[0];
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
    public function notificarUsuariosByCurso(string $mensagem, array $cursos)
    {
        $sql = "INSERT INTO notificacoes (mensagem) VALUES (:mensagem)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":mensagem", $mensagem);
        $stmt->execute();

        $idNotificacao = $this->conn->lastInsertId();

        $sql = "SELECT idUsuarios FROM usuarios WHERE idCursos = 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $idUsuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);



        foreach ($idUsuarios as $id) {

            $sql = "INSERT INTO notificacoes_usuarios (idNotificacao, idUsuario) VALUES (:idNotificacao, :idUsuario)";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":idNotificacao", $idNotificacao);
            $stmt->bindValue(":idUsuario", $id["idUsuarios"]);
            $stmt->execute();
        }
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

    // Listar notificações por usuário
    public function listByUsuario(int $idUsuarios)
    {
        $sql = "SELECT * FROM notificacoes WHERE idUsuarios = :idUsuarios ORDER BY id DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":idUsuarios", $idUsuarios, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
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
