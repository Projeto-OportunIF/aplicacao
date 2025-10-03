<?php
# Nome do arquivo: OportunidadeDAO.php
# Objetivo: classe DAO para o model de Oportunidade


include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Oportunidade.php");
include_once(__DIR__ . "/../model/Curso.php");


class OportunidadeDAO
{
    // Lista todas as oportunidades
    public function list()
    {
        $conn = Connection::getConn();


        $sql = "SELECT * FROM oportunidades o ORDER BY o.titulo";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();


        return $this->mapOportunidades($result);
    }


    // Lista oportunidades filtrando pelo tipo (Estágio, Pesquisa, Extensão)
    public function listByTipo(string $tipo)
    {
        $conn = Connection::getConn();

        $sql = "SELECT * FROM oportunidades o 
            WHERE o.tipoOportunidade = :tipo
            ORDER BY o.titulo";
        $stm = $conn->prepare($sql);
        $stm->bindValue(":tipo", $tipo);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapOportunidades($result);
    }

    //filtra para que as oportunidades que o professor cadastrou de um curso apareca somente para o aluno dessse determinado curso 
    public function listByTipoECurso(string $tipo, int $idCurso)
    {
        $conn = Connection::getConn();

        $sql = "SELECT o.* FROM oportunidades o
            INNER JOIN oportunidade_curso oc ON o.idOportunidades = oc.idOportunidade
            WHERE o.tipoOportunidade = :tipo
              AND oc.idCurso = :idCurso
            ORDER BY o.titulo";

        $stm = $conn->prepare($sql);
        $stm->bindValue(":tipo", $tipo);
        $stm->bindValue(":idCurso", $idCurso);
        $stm->execute();
        $result = $stm->fetchAll();

        return $this->mapOportunidades($result);
    }



    // Busca oportunidade por ID
    public function findById(int $id)
    {
        $conn = Connection::getConn();


        $sql = "SELECT * FROM oportunidades o WHERE o.idOportunidades = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();


        $oportunidades = $this->mapOportunidades($result);


        if (count($oportunidades) == 1)
            return $oportunidades[0];
        elseif (count($oportunidades) == 0)
            return null;


        die("OportunidadeDAO.findById() - Erro: mais de uma oportunidade encontrada.");
    }


    // Inserir nova oportunidade
    public function insert(Oportunidade $oportunidade)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO oportunidades 
        (titulo, descricao, tipoOportunidade, dataInicio, dataFim, documentoAnexo, professor_responsavel, vaga) 
        VALUES (:titulo, :descricao, :tipoOportunidade, :dataInicio, :dataFim, :documentoAnexo, :professor_responsavel, :vaga)";

        $stm = $conn->prepare($sql);
        $stm->bindValue(":titulo", $oportunidade->getTitulo());
        $stm->bindValue(":descricao", $oportunidade->getDescricao());
        $stm->bindValue(":tipoOportunidade", $oportunidade->getTipoOportunidade());
        $stm->bindValue(":dataInicio", $oportunidade->getDataInicio());
        $stm->bindValue(":dataFim", $oportunidade->getDataFim());
        $stm->bindValue(":documentoAnexo", $oportunidade->getDocumentoAnexo());
        $stm->bindValue(":professor_responsavel", $oportunidade->getProfessorResponsavel());
        $stm->bindValue(":vaga", $oportunidade->getVaga());
        $stm->execute();

        $idOportunidade = $conn->lastInsertId();

        // Inserir cursos relacionados
        foreach ($oportunidade->getCursos() as $curso) {
            $sqlCurso = "INSERT INTO oportunidade_curso (idOportunidade, idCurso) VALUES (:idOportunidade, :idCurso)";
            $stmCurso = $conn->prepare($sqlCurso);
            $stmCurso->bindValue(":idOportunidade", $idOportunidade);
            $stmCurso->bindValue(":idCurso", $curso->getId());
            $stmCurso->execute();
        }
    }


    // Atualizar oportunidade
    public function update(Oportunidade $oportunidade)
    {
        $conn = Connection::getConn();

        //  Atualizar dados da oportunidade (sem idCursos)
        $sql = "UPDATE oportunidades SET
            titulo = :titulo,
            descricao = :descricao,
            tipoOportunidade = :tipo,
            dataInicio = :dataInicio,
            dataFim = :dataFim,
            documentoAnexo = :documentoAnexo,
            vaga = :vaga,
            professor_responsavel = :professor_responsavel
        WHERE idOportunidades = :id";




        $stm = $conn->prepare($sql);
        $stm->bindValue(":titulo", $oportunidade->getTitulo());
        $stm->bindValue(":descricao", $oportunidade->getDescricao());
        $stm->bindValue(":tipo", $oportunidade->getTipoOportunidade());
        $stm->bindValue(":dataInicio", $oportunidade->getDataInicio());
        $stm->bindValue(":dataFim", $oportunidade->getDataFim());
        $stm->bindValue(":documentoAnexo", $oportunidade->getDocumentoAnexo());
        $stm->bindValue(":vaga", $oportunidade->getVaga());
        $stm->bindValue(":professor_responsavel", $oportunidade->getProfessorResponsavel());
        $stm->bindValue(":id", $oportunidade->getId());
        $stm->execute();

        //  Atualizar cursos relacionados
        // 2a - Apagar cursos antigos
        $sqlDelete = "DELETE FROM oportunidade_curso WHERE idOportunidade = :idOportunidade";
        $stmDelete = $conn->prepare($sqlDelete);
        $stmDelete->bindValue(":idOportunidade", $oportunidade->getId());
        $stmDelete->execute();

        // 2b - Inserir cursos novos
        foreach ($oportunidade->getCursos() as $curso) {
            $sqlInsert = "INSERT INTO oportunidade_curso (idOportunidade, idCurso) VALUES (:idOportunidade, :idCurso)";
            $stmInsert = $conn->prepare($sqlInsert);
            $stmInsert->bindValue(":idOportunidade", $oportunidade->getId());
            $stmInsert->bindValue(":idCurso", $curso->getId());
            $stmInsert->execute();
        }
    }


    // Excluir oportunidade
    public function deleteById(int $id)
    {
        $conn = Connection::getConn();


        $sql = "DELETE FROM oportunidades WHERE idOportunidades = :id";


        $stm = $conn->prepare($sql);
        $stm->bindValue("id", $id);
        $stm->execute();
    }


    // Mapear resultado do banco em objetos Oportunidade
    private function mapOportunidades($result)
    {
        $oportunidades = array();
        foreach ($result as $reg) {
            $oportunidade = new Oportunidade();
            $oportunidade->setId($reg['idOportunidades']);
            $oportunidade->setTitulo($reg['titulo']);
            $oportunidade->setDescricao($reg['descricao']);
            $oportunidade->setTipoOportunidade($reg['tipoOportunidade']);
            $oportunidade->setDataInicio($reg['dataInicio']);
            $oportunidade->setDataFim($reg['dataFim']);
            $oportunidade->setDocumentoAnexo($reg['documentoAnexo']);
            $oportunidade->setVaga($reg['vaga']);

            // Professor
            $oportunidade->setProfessorResponsavel($reg['professor_responsavel']);



            // Cursos: agora você deve buscar na tabela oportunidade_curso
            require_once(__DIR__ . "/CursoDAO.php");
            $cursoDao = new CursoDAO();
            $oportunidade->setCursos($cursoDao->getCursosByOportunidade($reg['idOportunidades']));

            $oportunidades[] = $oportunidade;
        }

        return $oportunidades;
    }



    // Inscrever aluno em uma oportunidade
    public function inscreverAluno(int $idAluno, int $idOportunidade)
    {
        $conn = Connection::getConn();

        $sql = "INSERT INTO inscricoes (idUsuarios, idOportunidades, status) 
                VALUES (:idAluno, :idOportunidade, 'PENDENTE')";

        $stm = $conn->prepare($sql);
        $stm->bindValue(":idAluno", $idAluno);
        $stm->bindValue(":idOportunidade", $idOportunidade);

        return $stm->execute(); // retorna true se deu certo
    }

    // Busca cursos associados a uma oportunidade específica
    public function getCursosByOportunidade(int $idOportunidade): array
    {
        $conn = Connection::getConn();

        $sql = "SELECT c.* 
            FROM cursos c
            INNER JOIN oportunidade_curso oc ON c.idCursos = oc.idCurso
            WHERE oc.idOportunidade = :idOportunidade";

        $stm = $conn->prepare($sql);
        $stm->bindValue(":idOportunidade", $idOportunidade);
        $stm->execute();

        $cursos = [];
        while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
            $curso = new Curso();
            $curso->setId($row['idCursos']);
            $curso->setNome($row['nome']);
            $cursos[] = $curso;
        }

        return $cursos;
    }
}
