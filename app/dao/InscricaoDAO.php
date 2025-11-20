<?php
# Nome do arquivo: InscricaoDAO.php
# Objetivo: gerenciar as inscrições de alunos nas oportunidades

require_once(__DIR__ . "/../connection/Connection.php");

class InscricaoDAO
{
    private $conn;

    public function __construct()
    {
        $this->conn = Connection::getConn();
    }

    // Inserir nova inscrição
    public function insert(int $idAluno, int $idOportunidade, string $documento = null, string $status = null)
    {
        $sql = "INSERT INTO inscricoes (documentosAnexo, status, idOportunidades, idUsuarios) 
                VALUES (:documento, :status, :idOportunidade, :idAluno)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":documento", $documento);
        $stmt->bindValue(":status", $status ?? 'PENDENTE');
        $stmt->bindValue(":idOportunidade", $idOportunidade, PDO::PARAM_INT);
        $stmt->bindValue(":idAluno", $idAluno, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Verifica se o aluno já está inscrito naquela oportunidade
    public function findByAlunoEOportunidade(int $idAluno, int $idOportunidade)
    {
        $sql = "SELECT * FROM inscricoes 
                WHERE idUsuarios = :idAluno 
                AND idOportunidades = :idOportunidade";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":idAluno", $idAluno, PDO::PARAM_INT);
        $stmt->bindValue(":idOportunidade", $idOportunidade, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Busca inscrição pelo id da inscrição
    public function findByAlunoEInscricao(int $idAluno, int $idInscricao)
    {
        $sql = "SELECT * FROM inscricoes 
                WHERE idUsuarios = :idAluno 
                AND idInscricoes = :idInscricao";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":idAluno", $idAluno, PDO::PARAM_INT);
        $stmt->bindValue(":idInscricao", $idInscricao, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Listar inscrições de um aluno
public function listByAluno(int $idAluno)
{
    $sql = "SELECT i.*, 
                   o.titulo, 
                   o.descricao, 
                   o.tipoOportunidade, 
                   o.dataInicio, 
                   o.dataFim,
                   o.vaga,
                   o.documentoAnexo,
                   o.idProfessor,
                   p.nomeCompleto AS nomeProfessor
            FROM inscricoes i
            INNER JOIN oportunidades o ON i.idOportunidades = o.idOportunidades
            LEFT JOIN usuarios p ON o.idProfessor = p.idUsuarios
            WHERE i.idUsuarios = :idAluno
            ORDER BY i.idInscricoes DESC";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":idAluno", $idAluno, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}


    // Deletar inscrição
    public function deleteById(int $idInscricao)
    {
        $sql = "DELETE FROM inscricoes WHERE idInscricoes = :idInscricao";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":idInscricao", $idInscricao, PDO::PARAM_INT);
        $stmt->execute();
    }

   public function listByOportunidadeDetalhado(int $idOportunidade)
{
    $sql = "SELECT i.*, 
                   u.nomeCompleto AS nomeAluno, 
                   u.email AS emailAluno, 
                   u.matricula AS matriculaAluno,
                   c.nome AS cursoAluno,
                   p.nomeCompleto AS nomeProfessor
            FROM inscricoes i
            INNER JOIN usuarios u ON i.idUsuarios = u.idUsuarios
            INNER JOIN cursos c ON u.idCursos = c.idCursos
            INNER JOIN oportunidades o ON i.idOportunidades = o.idOportunidades
            LEFT JOIN usuarios p ON o.idProfessor = p.idUsuarios
            WHERE i.idOportunidades = :idOportunidade
            ORDER BY i.idInscricoes DESC";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":idOportunidade", $idOportunidade, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_OBJ);
}



    // Atualizar status e feedback
    public function updateStatus($idInscricao, $novoStatus, $feedbackProfessor = null)
    {
        try {
            $sql = "UPDATE inscricoes 
                    SET status = :status, feedbackProfessor = :feedback 
                    WHERE idInscricoes = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":status", $novoStatus);
            $stmt->bindValue(":feedback", $feedbackProfessor);
            $stmt->bindValue(":id", $idInscricao);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Erro ao atualizar status: " . $e->getMessage());
        }
    }

    // 🔹 Corrigido: listar inscritos de uma oportunidade
    // 🔹 Corrigido: listar inscritos de uma oportunidade
    public function listarInscritosPorOportunidade($idOportunidade)
{
    $sql = "SELECT 
                i.idInscricoes, 
                u.nomeCompleto AS nome, 
                u.email AS email, 
                i.documentosAnexo AS documentos,
                i.status,
                i.feedbackProfessor
            FROM inscricoes i
            INNER JOIN usuarios u ON u.idUsuarios = i.idUsuarios
            WHERE i.idOportunidades = :idOportunidade
            ORDER BY i.idInscricoes DESC";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(':idOportunidade', $idOportunidade, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

}
