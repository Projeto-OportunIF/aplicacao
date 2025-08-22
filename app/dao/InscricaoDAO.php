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
 public function insert(int $idAluno, int $idOportunidade, string $documento = null)
{
    $sql = "INSERT INTO inscricoes (documentosAnexo, status, idOportunidades, idUsuarios) 
            VALUES (:documento, 'PENDENTE', :idOportunidade, :idAluno)";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":documento", $documento);
    $stmt->bindValue(":idOportunidade", $idOportunidade, PDO::PARAM_INT);
    $stmt->bindValue(":idAluno", $idAluno, PDO::PARAM_INT);
    $stmt->execute();
}


    // Verifica se o aluno já está inscrito naquela oportunidade
    public function findByAlunoEOportunidade(int $idAluno, int $idOportunidade)
    {
        $sql = "SELECT * FROM inscricoes WHERE idUsuarios = :idAluno AND idOportunidades = :idOportunidade";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":idAluno", $idAluno, PDO::PARAM_INT);
        $stmt->bindValue(":idOportunidade", $idOportunidade, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function listByAluno(int $idAluno)
{
    $sql = "SELECT i.*, o.titulo, o.descricao, o.tipoOportunidade, o.dataInicio, o.dataFim 
            FROM inscricoes i
            INNER JOIN oportunidades o ON i.idOportunidades = o.idOportunidades
            WHERE i.idUsuarios = :idAluno
            ORDER BY i.idInscricoes DESC";

    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":idAluno", $idAluno, PDO::PARAM_INT);
    $stmt->execute();

    return $stmt->fetchAll(PDO::FETCH_OBJ); // retorna array de objetos
}
public function deleteById(int $idInscricao)
{
    $sql = "DELETE FROM inscricoes WHERE idInscricoes = :idInscricao";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindValue(":idInscricao", $idInscricao, PDO::PARAM_INT);
    $stmt->execute();
}

}
