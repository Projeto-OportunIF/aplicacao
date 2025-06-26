<?php
# Nome do arquivo: CursoDAO.php
# Objetivo: classe DAO para o model de Curso

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Curso.php");


class CursoDAO {

    // Método para listar todos os cursos
    public function list() {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM cursos ORDER BY nome";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapCursos($result);
    }

    // Método para buscar um curso por ID
    public function findById(int $id) {
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

    // Método para converter registros do banco em objetos Curso
    private function mapCursos($result) {
        $cursos = [];

        foreach ($result as $reg) {
            $curso = new Curso();
            $curso->setId($reg["idCursos"]);
            $curso->setNome($reg["nome"]);
            array_push($cursos, $curso);
        }

        return $cursos;
    }
}