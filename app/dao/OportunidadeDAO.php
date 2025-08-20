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

    $sql = "SELECT * FROM oportunidades o 
            WHERE o.tipoOportunidade = :tipo 
              AND o.idCursos = :idCurso
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


        // ;


        $sql = "INSERT INTO `oportunidades` (`titulo`, `descricao`, `tipoOportunidade`, `dataInicio`, `dataFim`, `documentoAnexo`, `idUsuarios`, `idCursos`, `vaga`) VALUES (:titulo, :descricao, :tipoOportunidade, :dataInicio, :dataFim, :documentoAnexo, :idUsuarios, :idCursos, :vaga)";


        $stm = $conn->prepare($sql);
        $stm->bindValue("titulo", $oportunidade->getTitulo());
        $stm->bindValue("descricao", $oportunidade->getDescricao());
        $stm->bindValue("tipoOportunidade", $oportunidade->getTipoOportunidade());
        $stm->bindValue("dataInicio", $oportunidade->getDataInicio());
        $stm->bindValue("dataFim", $oportunidade->getDataFim());
        $stm->bindValue("documentoAnexo", $oportunidade->getDocumentoAnexo());
        $stm->bindValue("idUsuarios", $oportunidade->getProfessor()->getId());
        $stm->bindValue("idCursos", $oportunidade->getCurso() ? $oportunidade->getCurso()->getId() : null);
        $stm->bindValue(":vaga", $oportunidade->getVaga());


        $stm->execute();
    }


    // Atualizar oportunidade
  public function update(Oportunidade $oportunidade)
{
    $conn = Connection::getConn();


    $sql = "UPDATE oportunidades SET
                titulo = :titulo,
                descricao = :descricao,
                tipoOportunidade = :tipo,
                dataInicio = :dataInicio,
                dataFim = :dataFim,
                documentoAnexo = :documentoAnexo,
                idCursos = :idCursos,
                 vaga = :vaga
            WHERE idOportunidades = :id";


    $stm = $conn->prepare($sql);


    $stm->bindValue(":vaga", $oportunidade->getVaga());
   
    $stm->bindValue(":titulo", $oportunidade->getTitulo());
    $stm->bindValue(":descricao", $oportunidade->getDescricao());
    $stm->bindValue(":tipo", $oportunidade->getTipoOportunidade());
    $stm->bindValue(":dataInicio", $oportunidade->getDataInicio());
    $stm->bindValue(":dataFim", $oportunidade->getDataFim());
    $stm->bindValue(":documentoAnexo", $oportunidade->getDocumentoAnexo());
    $stm->bindValue(":idCursos", $oportunidade->getCurso() ? $oportunidade->getCurso()->getId() : null);
    $stm->bindValue(":id", $oportunidade->getId());


    $stm->execute();
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


            
            $curso = new Curso();
            $curso->setId($reg['idCursos']);
            $oportunidade->setCurso($curso);


            array_push($oportunidades, $oportunidade);
        }


        return $oportunidades;
    }




}


