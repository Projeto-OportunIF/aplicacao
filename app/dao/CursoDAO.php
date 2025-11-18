<?php
# Nome do arquivo: CursoDAO.php
# Objetivo: classe DAO para o model de Curso

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Curso.php");


class CursoDAO
{

    // Método para listar todos os cursos
    public function list()
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM cursos ORDER BY nome";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapCursos($result);
    }

    // Método para buscar um curso por ID
    public function findById(int $id)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM cursos WHERE idCursos = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();

        $cursos = $this->mapCursos($result);

        if (count($cursos) == 1)
            return $cursos[0];
        elseif (count($cursos) == 0)
            return null;

        die("CursoDAO.findById() - Erro: mais de um curso com o mesmo ID.");
    }
    public function insert(Curso $curso)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO cursos (nome) VALUES (?)";
        $stm = $conn->prepare($sql);
        $stm->execute([$curso->getNome()]);
    }

    public function update(Curso $curso)
    {
        $conn = Connection::getConn();

        $sql = "UPDATE cursos SET nome = ? WHERE idCursos = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$curso->getNome(), $curso->getId()]);
    }

  public function deleteById(int $id)
{
    $conn = Connection::getConn();

    try {
        $sql = "DELETE FROM cursos WHERE idCursos = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);

    } catch (PDOException $e) {

        if ($e->getCode() == "23000") {
            throw new Exception("Você não pode excluir este curso pois ele está vinculado a um usuário.");
        }

        throw $e;
    }
}



    // Método para converter registros do banco em objetos Curso
    private function mapCursos($result)
    {
        $cursos = [];

        foreach ($result as $reg) {
            $curso = new Curso();
            $curso->setId($reg["idCursos"]);
            $curso->setNome($reg["nome"]);
            array_push($cursos, $curso);
        }

        return $cursos;
    }

    public function getCursosByOportunidade(int $idOportunidade): array
    {
        $conn = Connection::getConn();
        $sql = "SELECT c.* FROM cursos c
            INNER JOIN oportunidade_curso oc ON c.idCursos = oc.idCurso
            WHERE oc.idOportunidade = :idOportunidade";
        $stm = $conn->prepare($sql);
        $stm->bindValue(":idOportunidade", $idOportunidade);
        $stm->execute();
        $result = $stm->fetchAll();

        $cursos = [];
        foreach ($result as $reg) {
            $curso = new Curso();
            $curso->setId($reg['idCursos']);
            $curso->setNome($reg['nome']);
            $cursos[] = $curso;
        }

        return $cursos;
    }
}
