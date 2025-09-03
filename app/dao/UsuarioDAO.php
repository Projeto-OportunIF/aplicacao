<?php
#Nome do arquivo: UsuarioDAO.php
#Objetivo: classe DAO para o model de Usuario

include_once(__DIR__ . "/../connection/Connection.php");
include_once(__DIR__ . "/../model/Usuario.php");
include_once(__DIR__ . "/../model/Curso.php");

class UsuarioDAO
{
    public function list()
    {
        $conn = Connection::getConn();
        $sql = "SELECT * FROM usuarios u ORDER BY u.nomeCompleto";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();
        return $this->mapUsuarios($result);
    }

    public function findById(int $id)
    {
        $conn = Connection::getConn();
        $sql = "SELECT u.*, c.nome AS nomeCursos FROM usuarios u
                LEFT JOIN cursos c ON (c.idCursos = u.idCursos)
                WHERE u.idUsuarios = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$id]);
        $result = $stm->fetchAll();
        $usuarios = $this->mapUsuarios($result);

        if (count($usuarios) == 1)
            return $usuarios[0];
        elseif (count($usuarios) == 0)
            return null;

        die("UsuarioDAO.findById() - Erro: mais de um usuário encontrado.");
    }

    public function findByEmailSenha(string $email, string $senha)
    {
        $conn = Connection::getConn();
        $sql = "SELECT * FROM usuarios u WHERE BINARY u.email = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$email]);
        $result = $stm->fetchAll();
        $usuarios = $this->mapUsuarios($result);

        if (count($usuarios) == 1) {
            if (password_verify($senha, $usuarios[0]->getSenha()))
                return $usuarios[0];
            else
                return null;
        } elseif (count($usuarios) == 0)
            return null;

        die("UsuarioDAO.findByEmailSenha() - Erro: mais de um usuário encontrado.");
    }

    public function findByEmail(string $email)
    {
        $conn = Connection::getConn();
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$email]);
        $result = $stm->fetchAll();
        $usuarios = $this->mapUsuarios($result);

        return count($usuarios) > 0 ? $usuarios[0] : null;
    }

    public function insert(Usuario $usuario)
    {
        $conn = Connection::getConn();

        // Validação de curso obrigatório para aluno
        if ($usuario->getTipoUsuario() === 'aluno') {
            if (!$usuario->getCurso() || !$usuario->getCurso()->getId()) {
                throw new Exception("Aluno precisa ter um curso definido!");
            }
            $idCurso = $usuario->getCurso()->getId();
        } else {
            $idCurso = $usuario->getCurso() ? $usuario->getCurso()->getId() : null;
        }

        $sql = "INSERT INTO usuarios (nomeCompleto, senha, tipoUsuario, cpf, matricula, idCursos, email)
                VALUES (:nome, :senha, :tipoUsuario, :cpf, :matricula, :idCursos, :email)";

        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $usuario->getNomeCompleto());
        $stm->bindValue("senha", password_hash($usuario->getSenha(), PASSWORD_DEFAULT));
        $stm->bindValue("tipoUsuario", $usuario->getTipoUsuario());
        $stm->bindValue("cpf", $usuario->getCpf());
        $stm->bindValue("matricula", $usuario->getMatricula());
        $stm->bindValue("idCursos", $idCurso);
        $stm->bindValue("email", $usuario->getEmail());

        $stm->execute();
    }

    public function update(Usuario $usuario)
    {
        $conn = Connection::getConn();

        // Validação de curso obrigatório para aluno
        if ($usuario->getTipoUsuario() === 'aluno') {
            if (!$usuario->getCurso() || !$usuario->getCurso()->getId()) {
                throw new Exception("Aluno precisa ter um curso definido!");
            }
            $idCurso = $usuario->getCurso()->getId();
        } else {
            $idCurso = $usuario->getCurso() ? $usuario->getCurso()->getId() : null;
        }

        $sql = "UPDATE usuarios SET nomeCompleto = :nome, email = :email, cpf = :cpf,
                senha = :senha, tipoUsuario = :tipoUsuario, matricula = :matricula, idCursos = :idCursos, fotoPerfil = :fotoPerfil
                WHERE idUsuarios = :id";

        $stm = $conn->prepare($sql);
        $stm->bindValue("nome", $usuario->getNomeCompleto());
        $stm->bindValue("email", $usuario->getEmail());
        $stm->bindValue("cpf", $usuario->getCpf());
        $stm->bindValue("senha", password_hash($usuario->getSenha(), PASSWORD_DEFAULT));
        $stm->bindValue("tipoUsuario", $usuario->getTipoUsuario());
        $stm->bindValue("matricula", $usuario->getMatricula());
        $stm->bindValue("idCursos", $idCurso);
        $stm->bindValue("id", $usuario->getId());
        $stm->bindValue("fotoPerfil", $usuario->getFotoPerfil());

        $stm->execute();
    }

    public function deleteById(int $id)
    {
        $conn = Connection::getConn();

        try {
            $conn->beginTransaction();

            // Apagar inscrições
            $sql1 = "DELETE FROM inscricoes WHERE idUsuarios = :id";
            $stm1 = $conn->prepare($sql1);
            $stm1->bindValue(":id", $id);
            $stm1->execute();

            // Apagar oportunidades
            $sql2 = "DELETE FROM oportunidades WHERE idUsuarios = :id";
            $stm2 = $conn->prepare($sql2);
            $stm2->bindValue(":id", $id);
            $stm2->execute();

            // Apagar usuário
            $sql3 = "DELETE FROM usuarios WHERE idUsuarios = :id";
            $stm3 = $conn->prepare($sql3);
            $stm3->bindValue(":id", $id);
            $stm3->execute();

            $conn->commit();
        } catch (PDOException $e) {
            $conn->rollBack();
            throw $e;
        }
    }

    public function updateFotoPerfil(Usuario $usuario)
    {
        $conn = Connection::getConn();
        $sql = "UPDATE usuarios SET foto_perfil = ? WHERE idUsuarios = ?";
        $stm = $conn->prepare($sql);
        $stm->execute([$usuario->getFotoPerfil(), $usuario->getId()]);
    }

    public function quantidadeUsuarios()
    {
        $conn = Connection::getConn();
        $sql = "SELECT COUNT(*) AS qtd_usuarios FROM usuarios";
        $stm = $conn->prepare($sql);
        $stm->execute();
        $result = $stm->fetchAll();
        return $result[0]["qtd_usuarios"];
    }

    private function mapUsuarios($result)
    {
        $usuarios = array();
        foreach ($result as $reg) {
            $usuario = new Usuario();
            $usuario->setId($reg['idUsuarios']);
            $usuario->setNomeCompleto($reg['nomeCompleto']);
            $usuario->setEmail($reg['email']);
            $usuario->setSenha($reg['senha']);
            $usuario->setMatricula($reg['matricula']);
            $usuario->setTipoUsuario($reg['tipoUsuario']);
            $usuario->setCpf($reg['cpf']);
            $usuario->setFotoPerfil($reg['fotoPerfil']);

            $curso = new Curso();
            $curso->setId($reg['idCursos']);
            if (isset($reg["nomeCursos"]))
                $curso->setNome($reg["nomeCursos"]);

            $usuario->setCurso($curso);

            $usuarios[] = $usuario;
        }

        return $usuarios;
    }
}
